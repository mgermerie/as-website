const FULL_CALENDAR_BASE_OPTIONS = {
	initialView: 'dayGridMonth',
	initialDate: '2024-09-01',
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


const DEFAULT_STYLE = {
	color: {
		"Fléchettes": 'red',
		"Haltères": 'black',
		"Ballons": 'yellow',
		"Lancer de poids": 'gray',
		"Relais": 'brown',
		"Saut en longueur": 'blue',
		"Pétanque": 'orange',
		"Ekiden": 'green',

		'registeredEvents': 'green',
	},
	backgroundColor: {},
};


async function getEventTypes() {
	return await fetch(
		'index.php?action=calendar&requestEventTypes',
	).then(response => response.json());
}


class Calendar {
	#domContainer;
	#onEventClick;


	constructor(domContainer, onEventClick=()=>{}, style={}) {
		this.#domContainer = domContainer;
		this.style = Object.assign({}, DEFAULT_STYLE, style);
		this.#onEventClick = onEventClick.bind(this);

		this.fullCalendar = this.setupCalendar();
		this.init();
	}


	init() {
		Promise.resolve(
			getEventTypes(),
		).then((result) => {
			this.eventTypes = result;
			this.addData();
		});
	}



	setupCalendar() {
		const fullCalendar = new FullCalendar.Calendar(
			this.#domContainer,
			Object.assign({}, FULL_CALENDAR_BASE_OPTIONS, {
				eventClick: this.#onEventClick.bind(this),
			}),
		);
		fullCalendar.render();

		return fullCalendar;
	}


	addData() {
		for (const eventType of this.eventTypes) {
			const eventTitle = eventType['title'];
			const eventSource = {
				id: eventTitle,
				url: `index.php?action=calendar&eventType=${ eventTitle }`,
				color: this.style.color[eventTitle],
				backgroundColor: this.style.backgroundColor[eventTitle],
			};

			this.fullCalendar.addEventSource(eventSource);
		}
	}
}

