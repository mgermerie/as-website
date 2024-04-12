const BASE_POSITION = [48.84573, 2.424583];
const BASE_ZOOM_LEVEL = 14;


class EventsMap {
	#map;
	#eventsWithLocations;

	constructor(domContainer) {
		this.#map = L.map(domContainer)
			.setView(BASE_POSITION, BASE_ZOOM_LEVEL);
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

		EventsMap.getEventsWithLocations().then((result) => {
			this.#eventsWithLocations = result;
			this.setupMap();
		});
	}

	setupMap() {
		const teamEventsList = document.getElementById('team-events');
		const individualEventsList = document.getElementById(
			'individual-events',
		);

		const parsedEvents = this.parseEventsWithLocations(
			this.#eventsWithLocations,
		);

		for (const [key, event] of Object.entries(parsedEvents)) {
			const eventListInput = document.getElementById(
				'event-list-input-template',
			).content.cloneNode(true);

			const eventButton = eventListInput.querySelector('button');
			eventButton.innerHTML = key;

			eventButton.onclick = () => {
				if (eventButton.classList.contains('focused-on')) {
					this.#map.setView(BASE_POSITION, BASE_ZOOM_LEVEL);
					this.#map.eachLayer((layer) => {
						if (layer instanceof L.Marker) {
							layer.setOpacity(1);
						}
					});

					eventButton.classList.remove('focused-on');
					eventButton.classList.remove('second-color');
					eventButton.classList.add('first-color');
					return;
				}

				for (const button of document.getElementsByClassName(
					'focused-on',
				)) {
					button.classList.remove('focused-on');
					button.classList.remove('second-color');
					button.classList.add('first-color');
				}

				eventButton.classList.add('focused-on');
				eventButton.classList.add('second-color');
				eventButton.classList.remove('first-color');

				this.#map.fitBounds(
					event.markerGroup.getBounds(),
					{
						maxZoom: BASE_ZOOM_LEVEL,
					},
				);
				this.#map.eachLayer((layer) => {
					if (layer instanceof L.Marker) {
						if (layer.eventName === key) {
							layer.setOpacity(1);
						} else {
							layer.setOpacity(0);
						}
					}
				});
			};



			if (event.teamEvent) {
				teamEventsList.appendChild(eventListInput);
			} else {
				individualEventsList.appendChild(eventListInput);
			}
		}

		this.#map.invalidateSize();
	}

	parseEventsWithLocations(eventsWithLocations) {
		const sortedEvents = {}

		for (const event of eventsWithLocations) {
			// If event is already added to the list, just sort its location
			if (sortedEvents.hasOwnProperty(event.title)) {
				if (!sortedEvents[event.title].locationIds.includes(
					event.location_id,
				)) {
					sortedEvents[event.title].locationIds.push(
						event.location_id,
					);

					const marker = L.marker([event.latitude, event.longitude]);
					marker.eventName = event.title;
					marker.bindPopup(event.name);
					marker.addTo(sortedEvents[event.title].markerGroup);
				}
				continue;
			}

			const markerGroup = L.featureGroup().addTo(this.#map);

			const marker = L.marker([event.latitude, event.longitude]);
			marker.eventName = event.title;
			marker.bindPopup(event.name);
			marker.addTo(markerGroup);

			sortedEvents[event.title] = {
				locationIds: [event.location_id],
				markerGroup: markerGroup,
				teamEvent: event.team_event,
			}
		}

		return sortedEvents;
	}


	static async getEventsWithLocations() {
		return await fetch(
			'index.php?action=information&requestEventsWithLocations',
		).then(response => response.json());
	}
}


new EventsMap(document.getElementById('events-locations'));

