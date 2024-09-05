new Table(
	document.getElementById('results-container'),
	'index.php?action=results&requestResults',
	[
		'Épreuve',
		'Participant',
		'Équipe',
		{ name: 'Performance', sort: false },
		'Score',
	],
	data => data
		.filter(input => !input.team_event)
		.map((input) => {
			input.performance += PERFORMANCES_FORMAT[input.title].unit;
			return [
				input.title,
				input.first_name + ' ' + input.name,
				input.user_team,
				input.performance,
				input.score,
			];
		}),
	{ search: true },
);


new Table(
	document.getElementById('results-container-team'),
	'index.php?action=results&requestResults',
	[
		'Épreuve',
		'Équipe',
		{ name: 'Performance', sort: false },
		'Score',
	],
	data => data
		.filter(input => input.team_event)
		.map((input) => {
			input.performance += PERFORMANCES_FORMAT[input.title].unit;
			return [
				input.title,
				input.team,
				input.performance,
				input.score,
			];
		}),
	{ search: true },
);


new TabsManager([
	new Tab(
		document.getElementById('tab-individual-results'),
		document.getElementById('tab-individual-results-button'),
	),
	new Tab(
		document.getElementById('tab-team-results'),
		document.getElementById('tab-team-results-button'),
	),
]);
