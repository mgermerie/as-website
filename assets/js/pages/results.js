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

fetch(
	'index.php?action=results&requestEvents',
).then(response => response.json()).then((response) => {
	const tabList = [
		new Tab(
			document.getElementById('tab-individual'),
			document.getElementById('tab-button-individual'),
		),
		new Tab(
			document.getElementById('tab-team'),
			document.getElementById('tab-button-team'),
		),
	]

	for (const tab of response) {
		const title = tab['title'];

		if (tab['team_event']) {
			new Table(
				document.getElementById(`results-container-${title}`),
				'index.php?action=results&requestResults',
				[
					'Équipe',
					{ name: 'Performance', sort: false },
					'Score',
				],
				data => data
					.filter((input) => {
						return input.title === title;
					})
					.map((input) => {
						input.performance += PERFORMANCES_FORMAT[input.title].unit;
						return [
							input.team,
							input.performance,
							input.score,
						];
					}),
				{ search: true },
			);
		} else {
			new Table(
				document.getElementById(`results-container-${title}`),
				'index.php?action=results&requestResults',
				[
					'Participant',
					'Équipe',
					{ name: 'Performance', sort: false },
					'Score',
				],
				data => data
					.filter((input) => {
						return input.title === title;
					})
					.map((input) => {
						input.performance += PERFORMANCES_FORMAT[input.title].unit;
						return [
							input.first_name + ' ' + input.name,
							input.user_team,
							input.performance,
							input.score,
						];
					}),
				{ search: true },
			);
		}

		tabList.push(
			new Tab(
				document.getElementById(`tab-${title}`),
				document.getElementById(`tab-button-${title}`),
			)
		);
	}

	new TabsManager(tabList);
});

