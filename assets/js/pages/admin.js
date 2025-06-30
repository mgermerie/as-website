function showRegistrationsPanel(eventClickInfo) {
	const eventInfo = eventClickInfo.event;

	const template = document.getElementById('registrations-panel-template');
	const panel = document.importNode(template.content, true);

	panel.getElementById('registrations-panel-title')
		.innerHTML = eventInfo.title;

	new Table(
		panel.getElementById('registrations-table-container'),
		`index.php?action=admin&requestRegistered=${eventInfo.id}`,
		['Nom', 'Prénom', 'Équipe'],
		data => data.map(input => [
			input.name,
			input.first_name,
			input.team,
		]),
	);

	new Table(
		panel.getElementById('registrations-table-container-referee'),
		`index.php?action=admin&requestRegisteredReferee=${eventInfo.id}`,
		['Nom', 'Prénom', 'Équipe'],
		data => data.map(input => [
			input.name,
			input.first_name,
			input.team,
		]),
	);

	document.body.appendChild(panel);

	loginPanel.refreshButtons();
	new Panel(
		'registrations-panel',
		{
			onHideCallback: function() {
				document.body.removeChild(
					document.getElementById('registrations-panel-wrapper'),
				);
				delete this;
			},
		},
	).show();
}


function showResultInsertionPanel(eventClickInfo) {
	const eventInfo = eventClickInfo.event;
	const eventTitle = eventInfo.title;

	const template = document.getElementById('insert-result-panel-template');
	const panel = document.importNode(template.content, true);

	panel.getElementById('insert-result-panel-title')
		.innerHTML = eventTitle;


	if(eventInfo.extendedProps['team_event']) {
		panel.getElementById('insert-team-result-label')
			.classList.remove('hidden');
		panel.getElementById('insert-individual-result-label')
			.classList.add('hidden');
	}

	const scoreInput = panel.getElementById('score-input');

	if (PERFORMANCES_FORMAT[eventTitle].noPerformance) {
		panel.getElementById('insert-performance-label')
			.classList.add('hidden');
		scoreInput.placeholder = 'Saisir un score entre 0 et 1100';
	} else {
		const performanceInput = panel.getElementById('performance-input');
		const scoreInputPlaceholder = scoreInput.placeholder;

		performanceInput.placeholder = PERFORMANCES_FORMAT[eventTitle]
			.placeholder;

		performanceInput.addEventListener('input', () => {
			const value = performanceInput.value;

			if (value.length === 0) {
				scoreInput.value = '';
				scoreInput.placeholder = scoreInputPlaceholder;
			} else if (PERFORMANCES_FORMAT[eventTitle].test(value)) {
				scoreInput.value = scoreCalculator.getScore(eventTitle, value);
			} else {
				scoreInput.value = '';
				scoreInput.placeholder = 'Format de performance non reconnu';
			}
		});
	}


	const resultTable = new Table(
		panel.getElementById('insert-result-table-container'),
		`index.php?action=admin&requestTypedResults=${ eventInfo.id }`,
		eventInfo.extendedProps['team_event']
			? ['Équipe', 'Performance', 'Score']
			: ['Participant', 'Équipe', 'Performance', 'Score'],
		data => data
			.map(input => {
				input.performance += PERFORMANCES_FORMAT[eventTitle].unit;
				return input.team
					? [
						input.team,
						input.performance,
						input.score,
					]
					: [
						`${ input.first_name } ${ input.name }`,
						input.user_team,
						input.performance,
						input.score,
					];
			}),
		{ sort: false },
	);


	const form = panel.getElementById('form-add-result');
	form.addEventListener('submit', (function (e) {
		e.preventDefault();

		const formData = new FormData(form);
		formData.append(e.submitter.name, '');
		formData.append('eventId', eventInfo.id);

		fetch(
			'index.php?action=admin',
			{
				method: 'POST',
				body: formData,
			},
		).then(response => response.text()).then((response) => {
			if (response === 'error') {
				window.location.reload();
			} else {
				resultTable.refresh();
				form.reset();
			}
		});
	}).bind(this));


	document.body.appendChild(panel);

	new Panel(
		'insert-result-panel',
		{
			onHideCallback: function() {
				document.body.removeChild(
					document.getElementById('insert-result-panel-wrapper'),
				);
				delete this;
			},
		},
	).show();

}


const scoreCalculator = new ScoreCalculator(
	'./data/score-table.xlsx',
);


const calendars = [
	new Calendar(
		document.getElementById('calendar-container'),
		showRegistrationsPanel,
	),
	new Calendar(
		document.getElementById('results-calendar-container'),
		showResultInsertionPanel,
	),
];


new TabsManager(
	[
		new Tab(
			document.getElementById('tab-add-results'),
			document.getElementById('tab-add-results-button'),
		),
		new Tab(
			document.getElementById('tab-event-registration'),
			document.getElementById('tab-event-registration-button'),
		),
	],
	() => {
		calendars.map((calendar) => { calendar.fullCalendar.updateSize() });
	},
);


