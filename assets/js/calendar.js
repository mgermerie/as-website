const BASE_ZOOM_LEVEL = 16;

const FULL_CALENDAR_BASE_OPTIONS = {
	initialView: 'dayGridMonth',
	locale: 'fr',
	weekends: false,
	fixedWeekCount: false,
	showNonCurrentDates: false,
	headerToolbar: {
		end: 'dayGridWeek,dayGridMonth today prev,next',
	},
	buttonText: {
		today:    "Aujourd'hui",
		month:    'Mois',
		week:     'Semaine',
	},
	height: '75vh',
}


class Calendar {
	#fullCalendar;
	#domContainer;
	#style;
	#mapContainer;
	#map;
	#mapMarkers;
	#userInfo;
	#eventTypes;

	constructor(domContainer, style) {
		this.#domContainer = domContainer;
		this.#style = style;


		this.#mapContainer = document.getElementById('event-map-template')
			.content.getElementById('event-map');
		this.#map = L.map(this.#mapContainer)
			.setView([48.84573, 2.424583], BASE_ZOOM_LEVEL);
		L.tileLayer(
			"https://data.geopf.fr/wmts?" +
			"&REQUEST=GetTile&SERVICE=WMTS&VERSION=1.0.0" +
			"&STYLE=normal" +
			"&TILEMATRIXSET=PM_0_19" +
			"&FORMAT=image/png"+
			"&LAYER=GEOGRAPHICALGRIDSYSTEMS.PLANIGNV2"+
			"&TILEMATRIX={z}" +
			"&TILEROW={y}" +
			"&TILECOL={x}",
			{
				minZoom: 0,
				maxZoom: 18,
				attribution: 'IGN-F/Geoportail',
				tileSize: 256,
			},
		).addTo(this.#map);
		this.#mapMarkers = L.layerGroup().addTo(this.#map);


		Promise.all([
			Calendar.getUserInfo(),
			Calendar.getEventTypes(),
		]).then((result) => {
			[this.#userInfo, this.#eventTypes] = result;
			this.#fullCalendar = this.setupCalendar(this.#domContainer);
		});
	}


	setupCalendar() {
		const fullCalendar = new FullCalendar.Calendar(
			this.#domContainer,
			Object.assign({}, FULL_CALENDAR_BASE_OPTIONS, {
				eventClick: this.onEventClick.bind(this),
			}),
		);
		fullCalendar.render();


		const eventSources = [];

		// If user is loged in, display the events he or she is registered to
		if (this.#userInfo.id) {
			const registeredSource = this.setupEventSource({
				id: 'registeredEvents',
				title: 'Mes épreuves',
				url: '/index.php?action=calendar',
			});
			registeredSource.eventDataTransform = (function(eventData) {
				return Calendar.isEventRegistered(
					eventData.id,
					this.#userInfo.registeredEvents,
				) ? eventData : false;
			}).bind(this);
			registeredSource.display = 'block';
			eventSources.push(registeredSource);
			fullCalendar.addEventSource(registeredSource);
		}

		// Display all events at which user is not registered to
		for (const eventType of this.#eventTypes) {
			const eventSource = this.setupEventSource({
				id: eventType['title'],
				title: eventType['title'],
				url: '/index.php?action=calendar&eventType='
					+ eventType['title'],
			});
			eventSource.eventDataTransform = (function(eventData) {
				return Calendar.isEventRegistered(
					eventData.id,
					this.#userInfo.registeredEvents,
				) ? false : eventData;
			}).bind(this),
			eventSources.push(eventSource);
			fullCalendar.addEventSource(eventSource);
		}


		document.getElementById('form-event-filters').addEventListener(
			'submit',
			(browserEvent) => {
				browserEvent.preventDefault();
				for (const eventSource of eventSources) {
					if (eventSource.tickedCheckbox ===
						eventSource.filterCheckbox.checked) {
						continue;
					}
					eventSource.tickedCheckbox =
						eventSource.filterCheckbox.checked;

					if (eventSource.filterCheckbox.checked) {
						fullCalendar.addEventSource(eventSource);
					} else {
						const parsedEventSource = fullCalendar
							.getEventSourceById(eventSource.id);
						if (parsedEventSource) {
							parsedEventSource.remove();
							fullCalendar.refetchEvents();
						}
					}
				}
			}
		);

		return fullCalendar;
	}


	setupEventSource(source) {
		const eventFilter = document.getElementById('event-filter-template')
			.content.cloneNode(true);
		eventFilter.querySelector('.calendar-filter-label')
			.insertAdjacentHTML('beforeend', source.title);
		const eventFilterCheckbox = eventFilter.querySelector('input');
		document.getElementById('event-filters').appendChild(eventFilter);

		return {
			id: source.id,
			url: source.url,
			color: this.#style.color[source.id],
			backgroundColor: this.#style.backgroundColor[source.id],

			filterCheckbox: eventFilterCheckbox,
			tickedCheckbox: true,
		};
	}


	onEventClick(eventClickInfo) {
		const eventPanel = document.getElementById('event-panel-template')
			.content.cloneNode(true);
		const eventInfo = eventClickInfo.event;
		const eventProperties = eventInfo.extendedProps;

		// Event information list

		eventPanel.getElementById('event-panel-title')
			.innerHTML = eventInfo.title;
		eventPanel.getElementById('event-panel-date-start')
			.innerHTML = Calendar.parseDateToStringDate(eventInfo.start);
		eventPanel.getElementById('event-panel-time-start')
			.innerHTML = Calendar.parseDateToStringHour(eventInfo.start);
		eventPanel.getElementById('event-panel-date-end')
			.innerHTML = Calendar.parseDateToStringDate(eventInfo.end);
		eventPanel.getElementById('event-panel-time-end')
			.innerHTML = Calendar.parseDateToStringHour(eventInfo.end);
		eventPanel.getElementById('event-panel-location')
			.innerHTML = eventProperties.name;

		// Event map

		if (eventProperties.latitude && eventProperties.longitude) {
			const coordinates = [
				eventProperties.latitude,
				eventProperties.longitude,
			];
			this.#map.setView(
				coordinates,
				BASE_ZOOM_LEVEL,
				{ animate: false },
			);

			this.#mapMarkers.clearLayers();
			L.marker(coordinates).addTo(this.#mapMarkers);

			eventPanel.getElementById('event-panel').insertBefore(
				this.#mapContainer,
				eventPanel.getElementById('event-panel-registration'),
			);
		}

		// Event registration form

		if (this.#userInfo.id) {
			const form = eventPanel.getElementById('form-event-register');

			// If user is already registered to this event, display un-register
			// buttons
			const userRegisteredToEvent = Calendar.isEventInRegisteredEvents(
				eventInfo.id,
				this.#userInfo.registeredEvents,
			);
			if (userRegisteredToEvent.asReferee) {
				form.classList.add('registered-referee');
			}
			if (userRegisteredToEvent.asUser) {
				form.classList.add('registered-user');
			} else if (Calendar.isSimilarEventInRegisteredEvents(
				eventInfo.title,
				this.#userInfo.registeredEvents,
			)) {
				// If user is already registered to another similar event, he or
				// she cannot subscribe to this one
				form.classList.add('cannot-register');
			}

			form.addEventListener(
				'submit',
				(function (browserEvent) {
					browserEvent.preventDefault();

					const formData = new FormData();
					formData.append(browserEvent.submitter.name, true);
					formData.append('eventId', eventInfo.id);

					fetch(
						'index.php?action=calendar',
						{
							method: 'POST',
							body: formData,
						},
					).then(response => response.text()).then((response) => {
						console.log(response);
						if (
							response === 'error'
							|| response === 'removeEventSuccess'
						) {
							window.location.reload();
						} else if (response === 'registerSuccess') {
							form.classList.add('registered-user');
							this.#userInfo.registeredEvents.push({
								event_id: eventInfo.id,
								title: eventInfo.title,
								referee: false,
							});
						} else if (response === 'registerRefereeSuccess') {
							form.classList.add('registered-referee');
							this.#userInfo.registeredEvents.push({
								event_id: eventInfo.id,
								title: eventInfo.title,
								referee: true,
							});
						} else if (response === 'unregisterSuccess') {
							form.classList.remove('registered-user');
							this.#userInfo.registeredEvents =
								this.#userInfo.registeredEvents.filter(
									function (value) {
										return value.event_id != eventInfo.id
											|| value.referee == true;
									}
								);
						} else if (response === 'unregisterRefereeSuccess') {
							form.classList.remove('registered-referee');
							this.#userInfo.registeredEvents =
								this.#userInfo.registeredEvents.filter(
									function (value) {
										return value.event_id != eventInfo.id
											|| value.referee == false;
									}
								);
						}
						this.#fullCalendar.refetchEvents();
					});
				}).bind(this),
			);

			const eventRemovalButton = eventPanel.getElementById(
				'event-removal-button',
			);
			const cancelEventRemovalButton = eventPanel.getElementById(
				'cancel-event-removal-button',
			);
			if (eventRemovalButton && cancelEventRemovalButton) {
				eventRemovalButton.onclick = function () {
					form.classList.add('form-remove-event');
				}
				cancelEventRemovalButton.onclick = function (e) {
					e.preventDefault();
					form.classList.remove('form-remove-event');
				}
			}
		}


		document.body.appendChild(
			eventPanel.getElementById('event-panel-wrapper'),
		);
		this.#map.invalidateSize();

		// TODO: find an alternative (with event listener for instance)
		loginPanel.refreshButtons();
		new Panel(
			'event-panel',
			{
				onHideCallback: function() {
					document.body.removeChild(
						document.getElementById('event-panel-wrapper'),
					);
					delete this;
				},
			},
		).show();
	}


	static isEventInRegisteredEvents(eventId, registeredEvents) {
		if (!registeredEvents) {
			return false;
		}
		let registeredUser = {
			asUser: false,
			asReferee: false,
		};
		for (const registeredEvent of registeredEvents) {
			if (registeredEvent['event_id'] == eventId) {
				if (registeredEvent['referee']) {
					registeredUser.asReferee = true;
				} else {
					registeredUser.asUser = true;
				}
			}
		}
		return registeredUser;
	}

	static isSimilarEventInRegisteredEvents(eventTitle, registeredEvents) {
		if (!registeredEvents) {
			return false;
		}
		for (const registeredEvent of registeredEvents) {
			if (
				registeredEvent['title'] == eventTitle
				&& !registeredEvent['referee']
			) {
				return true;
			}
		}
		return false;
	}

	static isEventRegistered(eventId, registeredEvents) {
		const eventRegistered = Calendar.isEventInRegisteredEvents(
			eventId,
			registeredEvents,
		);
		return eventRegistered
			&& (eventRegistered.asUser || eventRegistered.asReferee);
	}

	static parseDateToStringDate(date) {
		const localParameters = ['fr-FR', { minimumIntegerDigits: 2 }];
		return date.getDate().toLocaleString(...localParameters)
			+ '/'
			+ (date.getMonth() + 1).toLocaleString(...localParameters)
			+ '/'
			+ date.getFullYear();
	}

	static parseDateToStringHour(date) {
		const localParameters = ['fr-FR', { minimumIntegerDigits: 2 }];
		return date.getHours().toLocaleString(...localParameters)
			+ ':'
			+ date.getMinutes().toLocaleString(...localParameters);
	}

	static async getUserInfo() {
		const parsedResponse = await fetch(
			'index.php?action=calendar&requestUserInfo',
		).then(response => response.json());
		return parsedResponse;
	}

	static async getEventTypes() {
		const parsedResponse = await fetch(
			'index.php?action=calendar&requestEventTypes',
		).then(response => response.json());
		return parsedResponse;
	}
}


new Calendar(
	document.getElementById('calendar-container'),
	{
		color: {
			'ping-pong': 'red',
			'course': 'blue',
			'registeredEvents': 'green',
		},
		backgroundColor: {
			'registeredEvents': 'green',
		}
	},
);


async function getSession() {
	return await fetch(
		'index.php?action=calendar&requestUserInfo',
	).then(response => response.json());
}

