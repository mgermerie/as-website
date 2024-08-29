const GRID_DEFAULT_OPTIONS = {
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


class Table {
	#columns;
	#domContainer;
	#formatData;
	#grid;
	#gridData;
	#gridOptions = {};
	#url;

	constructor(domContainer, url, columns, formatData, gridOptions={}) {
		this.#domContainer = domContainer;
		this.#url = url;
		this.#columns = columns;
		this.#formatData = formatData;
		Object.assign(this.#gridOptions, GRID_DEFAULT_OPTIONS, gridOptions);

		this.#grid = this.setupGrid()
	}


	setupGrid() {
		const grid = new gridjs.Grid(
			Object.assign({}, this.#gridOptions, {
				columns: this.#columns,
				server: {
					url: this.#url,
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
