function formatPerformance(result) {
	if (result.performance_number !== null) {
		return result.performance_number + ' points';
	} else if (result.performance_distance !== null) {
		return result.performance_distance + ' mètres';
	} else if (result.performance_time !== null) {
		return result.performance_time;
	}
}


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
			input.performance = formatPerformance(input);
			return [
				input.title,
				input.first_name + ' ' + input.name,
				input.team,
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
		.map(input => [
			input.title,
			input.team,
			input.performance_number
				|| input.performance_distance
				|| input.performance_time,
			input.score,
		]),
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
