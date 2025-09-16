fetch(
	'index.php?action=personalResults&requestUser',
).then(response => response.json()).then((response) => {
	new Table(
		document.getElementById('results-container-self'),
		'index.php?action=personalResults&requestResults',
		[
			'Épreuve',
			{ name: 'Performance', sort: false },
			'Score',
		],
		data => data
			.filter(input =>
				input.first_name === response.first_name
				&& input.name === response.name
				&& input.user_team === response.team
			)
			.map((input) => {
				input.performance += PERFORMANCES_FORMAT[input.title].unit;
				return [
					input.title,
					input.performance,
					input.score,
				];
			}),
	);

	new Table(
		document.getElementById('results-container-team'),
		'index.php?action=personalResults&requestResults',
		[
			'Épreuve',
			'Équipe',
			{ name: 'Performance', sort: false },
			'Score',
		],
		data => data
			.filter(input => input.team && input.team === response.team)
			.map((input) => {
				input.performance += PERFORMANCES_FORMAT[input.title].unit;
				return [
					input.title,
					input.team,
					input.performance,
					input.score,
				];
			}),
	);

	new Table(
		document.getElementById('results-container-mates'),
		'index.php?action=personalResults&requestResults',
		[
			'Épreuve',
			'Participant',
			{ name: 'Performance', sort: false },
			'Score',
		],
		data => data
			.filter(input =>
				(input.first_name !== response.first_name
				|| input.name !== response.name)
				&& input.user_team === response.team
			)
			.map((input) => {
				input.performance += PERFORMANCES_FORMAT[input.title].unit;
				return [
					input.title,
					input.first_name + ' ' + input.name,
					input.performance,
					input.score,
				];
			}),
		{ search: true },
	);
});

