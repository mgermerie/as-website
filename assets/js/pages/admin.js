function showRegistrationsPanel(eventClickInfo) {
	const eventInfo = eventClickInfo.event;

	const template = document.getElementById('registrations-panel-template');
	const panel = document.importNode(template.content, true);

	panel.getElementById('registrations-panel-title')
		.innerHTML = eventInfo.title;
	panel.getElementById('registrations-panel-referee')
		.innerHTML = eventInfo.extendedProps.team_name;

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


function formatPerformance(result) {
	if (result.performance_number !== null) {
		return result.performance_number + ' points';
	} else if (result.performance_distance !== null) {
		return result.performance_distance + ' mètres';
	} else if (result.performance_time !== null) {
		return result.performance_time;
	}
}


function showResultInsertionPanel(eventClickInfo) {
	const eventInfo = eventClickInfo.event;

	const template = document.getElementById('insert-result-panel-template');
	const panel = document.importNode(template.content, true);

	panel.getElementById('insert-result-panel-title')
		.innerHTML = eventInfo.title;

	new Table(
		panel.getElementById('insert-result-table-container'),
		`index.php?action=admin&requestTypedResults=${ eventInfo.id }`,
		['Participant', 'Équipe', 'Performance', 'Score'],
		data => data
			.map(input => {
				input.performance = formatPerformance(input);
				return [
					`${ input.first_name } ${ input.name }`,
					input.team,
					input.performance,
					input.score,
				];
			}),
		{ sort: false },
	);

	document.body.appendChild(panel);

	loginPanel.refreshButtons();
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

