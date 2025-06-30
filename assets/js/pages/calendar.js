const BASE_ZOOM_LEVEL = 16;


function parseDateToStringDate(date) {
	const localParameters = ['fr-FR', { minimumIntegerDigits: 2 }];
	return date.getDate().toLocaleString(...localParameters)
		+ '/'
		+ (date.getMonth() + 1).toLocaleString(...localParameters)
		+ '/'
		+ date.getFullYear();
}


function parseDateToStringHour(date) {
	const localParameters = ['fr-FR', { minimumIntegerDigits: 2 }];
	return date.getHours().toLocaleString(...localParameters)
		+ ':'
		+ date.getMinutes().toLocaleString(...localParameters);
}


function isEventInRegisteredEvents(eventId, registeredEvents) {
	if (!registeredEvents) {
		return false;
	}
	for (const registeredEvent of registeredEvents) {
		if (
			!registeredEvent['referee']
			&& registeredEvent['event_id'] == eventId
		) {
			return true;
		}
	}
	return false;
}

function isEventInRegisteredRefereeEvents(eventId, registeredEvents) {
	if (!registeredEvents) {
		return false;
	}
	for (const registeredEvent of registeredEvents) {
		if (
			registeredEvent['referee']
			&& registeredEvent['event_id'] == eventId
		) {
			return true;
		}
	}
	return false;
}


function isSimilarEventInRegisteredEvents(eventTitle, registeredEvents) {
	if (!registeredEvents) {
		return false;
	}
	for (const registeredEvent of registeredEvents) {
		if (
			!registeredEvent['referee']
			&& registeredEvent['title'] == eventTitle) {
			return true;
		}
	}
	return false;
}


async function getUserInfo() {
	return await fetch(
		'index.php?action=calendar&requestUserInfo',
	).then(response => response.json());
}


function onEventClick(eventClickInfo) {
	const eventPanel = document.getElementById('event-panel-template')
		.content.cloneNode(true);
	const eventInfo = eventClickInfo.event;
	const eventProperties = eventInfo.extendedProps;
	console.log(eventInfo);
	console.log(eventProperties);

	// Event information list

	eventPanel.getElementById('event-panel-title')
		.innerHTML = eventInfo.title;
	eventPanel.getElementById('event-panel-date-start')
		.innerHTML = parseDateToStringDate(eventInfo.start);
	eventPanel.getElementById('event-panel-time-start')
		.innerHTML = parseDateToStringHour(eventInfo.start);
	eventPanel.getElementById('event-panel-date-end')
		.innerHTML = parseDateToStringDate(eventInfo.end);
	eventPanel.getElementById('event-panel-time-end')
		.innerHTML = parseDateToStringHour(eventInfo.end);
	eventPanel.getElementById('event-panel-location')
		.innerHTML = eventProperties.name;
	eventPanel.getElementById('event-panel-referee-number')
		.innerHTML = eventProperties['referee_number'];
	eventPanel.getElementById('event-panel-rules')
		.href = '/data/rules/' + eventInfo.title + '.pdf';

	// Event map

	if (eventProperties.latitude && eventProperties.longitude) {
		const coordinates = [
			eventProperties.latitude,
			eventProperties.longitude,
		];
		this.map.setView(
			coordinates,
			BASE_ZOOM_LEVEL,
			{ animate: false },
		);

		this.mapMarkers.clearLayers();
		L.marker(coordinates).addTo(this.mapMarkers);

		eventPanel.getElementById('event-panel').insertBefore(
			this.mapContainer,
			eventPanel.getElementById('event-panel-registration'),
		);
	}

	// Event registration form

	if (this.userInfo.id) {
		const form = eventPanel.getElementById('form-event-register');

		// If user is already registered to this event, display un-register
		// buttons
		if (isEventInRegisteredEvents(
			eventInfo.id,
			this.userInfo.registeredEvents,
		)) {
			form.classList.add('registered-user');
		} else if (isSimilarEventInRegisteredEvents(
			eventInfo.title,
			this.userInfo.registeredEvents,
		)) {
			// If user is already registered to another similar event, he or
			// she cannot subscribe to this one
			form.classList.add('cannot-register');
		}

		// If user is already regeistered as referee to this event
		if (isEventInRegisteredRefereeEvents(
			eventInfo.id,
			this.userInfo.registeredEvents,
		)) {
			form.classList.add('registered-referee');
		}


		form.addEventListener(
			'submit',
			(function (browserEvent) {
				browserEvent.preventDefault();

				const formData = new FormData();
				formData.append(browserEvent.submitter.name, '');
				formData.append('eventId', eventInfo.id);

				fetch(
					'index.php?action=calendar',
					{
						method: 'POST',
						body: formData,
					},
				).then(response => response.text()).then((response) => {
					if (
						response === 'error'
						|| response === 'removeEventSuccess'
					) {
						window.location.reload();
					} else if (response === 'registerSuccess') {
						form.classList.add('registered-user');
						this.userInfo.registeredEvents.push({
							event_id: eventInfo.id,
							title: eventInfo.title,
							referee: 0,
						});
					} else if (response === 'unregisterSuccess') {
						form.classList.remove('registered-user');
						this.userInfo.registeredEvents =
							this.userInfo.registeredEvents.filter(
								function (value) {
									return value.event_id != eventInfo.id;
								}
							);
					} else if (response === 'registerRefereeSuccess') {
						form.classList.remove('form-register-referee');
						form.classList.add('registered-referee');
						this.userInfo.registeredEvents.push({
							event_id: eventInfo.id,
							title: eventInfo.title,
							referee: 1,
						});
					}
					this.fullCalendar.refetchEvents();
				});
			}).bind(this),
		);

		const registerRefereeButton = eventPanel.getElementById(
			'register-referee-button',
		);
		const cancelRegisterRefereeButton = eventPanel.getElementById(
			'cancel-register-referee-button',
		);
		if (registerRefereeButton && cancelRegisterRefereeButton) {
			registerRefereeButton.onclick = function () {
				form.classList.add('form-register-referee');
			}
			cancelRegisterRefereeButton.onclick = function (e) {
				e.preventDefault();
				form.classList.remove('form-register-referee');
			}
		}

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
	// TODO : CODE THIS MORE PROPERLY
	if (eventInfo.title === "Cérémonie de clôture") {
		document.getElementById('event-panel-rules').style.display = 'none';
		if (document.getElementById('register-referee-button')) {
			document.getElementById('register-referee-button').style.display = 'none';
		}
	}

	this.map.invalidateSize();

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


class RegistrationCalendar extends Calendar {
	#domContainer;


	constructor(domContainer, mapContainer, onEventClick=()=>{}, style={}) {
		super(domContainer, onEventClick, style);

		this.mapContainer = mapContainer;
		this.map = L.map(this.mapContainer)
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
		).addTo(this.map);
		this.mapMarkers = L.layerGroup().addTo(this.map);
	}


	init() {
		Promise.resolve(
			getUserInfo(),
		).then((result) => {
			this.userInfo = result;
			super.init();
		});
	}


	addData() {
		const eventSources = [];

		if (this.userInfo.id) {
			const registeredSource = this.setupSpecificEventSource({
				id: 'registeredEvents',
				title: 'Mes épreuves',
				url: '/index.php?action=calendar',
			});
			registeredSource.eventDataTransform = (function(eventData) {
				return (
					isEventInRegisteredEvents(
						eventData.id,
						this.userInfo.registeredEvents,
					)
					|| isEventInRegisteredRefereeEvents(
						eventData.id,
						this.userInfo.registeredEvents,
					)) && eventData;
			}).bind(this);
			registeredSource.display = 'block';
			eventSources.push(registeredSource);
			this.fullCalendar.addEventSource(registeredSource);
		}

		for (const eventType of this.eventTypes) {
			const eventTitle = eventType['title'];
			const eventSource = this.setupSpecificEventSource({
				id: eventTitle,
				title: eventTitle,
				url: `/index.php?action=calendar&eventType=${ eventTitle }`,
			});
			eventSource.eventDataTransform = (function(eventData) {
				return !isEventInRegisteredEvents(
					eventData.id,
					this.userInfo.registeredEvents,
				) && eventData;
			}).bind(this);
			eventSources.push(eventSource);
			this.fullCalendar.addEventSource(eventSource);
		}

		document.getElementById('form-event-filters').addEventListener(
			'submit',
			(e) => {
				e.preventDefault();
				for (const eventSource of eventSources) {
					if (eventSource.tickedCheckbox ===
						eventSource.filterCheckbox.checked) {
						continue;
					}
					eventSource.tickedCheckbox =
						eventSource.filterCheckbox.checked;

					if (eventSource.filterCheckbox.checked) {
						this.fullCalendar.addEventSource(eventSource);
					} else {
						const parsedEventSource = this.fullCalendar
							.getEventSourceById(eventSource.id);
						if (parsedEventSource) {
							parsedEventSource.remove();
							this.fullCalendar.refetchEvents();
						}
					}
				}
			},
		);
	}


	setupSpecificEventSource(source) {
		const filterTemplate = document.getElementById('event-filter-template');
		const filter = document.importNode(filterTemplate.content, true);
		const filterCheckbox = filter.querySelector('input');

		filter.getElementById('event-filter-name')
			.innerHTML = source.title;

		document.getElementById('event-filters').appendChild(filter);

		return {
			id: source.id,
			url: source.url,
			color: this.style.color[source.id],
			backgroundColor: this.style.backgroundColor[source.id],

			filterCheckbox,
			tickedCheckbox: true,
		};
	}
}


new RegistrationCalendar(
	document.getElementById('calendar-container'),
	document.getElementById('event-map-template')
		.content.getElementById('event-map'),
	onEventClick,
	{
		backgroundColor: {
			'registeredEvents': 'green',
		}
	},
);

