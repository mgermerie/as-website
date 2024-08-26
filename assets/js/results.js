const GRID_BASE_OPTIONS = {
	search: true,
	fixedHeader: true,
	sort: true,
	pagination: {
		limit: 50,
	},
	language: {
		search: {
			placeholder: 'Chercher une épreuve, un nom...',
		},
		pagination: {
			previous: 'Précédent',
			next: 'Suivant',
			showing: 'Affichage de',
			results: 'résultats',
			to: 'à',
			of: 'des',
		},
	},
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


class ResultsTable {
	#grid;
	#domContainer;
	#gridData;
	#columns;
	#formatData;

	constructor(domContainer, columns, formatData) {
		this.#domContainer = domContainer;
		this.#columns = columns;
		this.#formatData = formatData;

		this.#grid = this.setupGrid()
	}


	setupGrid() {
		const grid = new gridjs.Grid(
			Object.assign({}, GRID_BASE_OPTIONS, {
				columns: this.#columns,
				server: {
					url: 'index.php?action=results&requestResults',
					then: (data) => {
						return this.#formatData(data);
					}
				},
			}),
		);

		grid.render(this.#domContainer);

		return grid;
	}
}


new ResultsTable(
	document.getElementById('results-container'),
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
);

new ResultsTable(
	document.getElementById('results-container-team'),
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
);

