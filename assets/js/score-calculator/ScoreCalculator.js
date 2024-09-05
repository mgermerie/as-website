const DEFAULT_SCHEMA = {
	'Score': {
		prop: 'score',
		type: Number,
	},
	'POIDS': {
		prop: 'Lancer de poids',
		type: Number,
	},
	'LONGUEUR': {
		prop: 'Saut en longueur',
		type: Number,
	},
	'BALLONS': {
		prop: 'Ballons',
		type: Number,
	},
	'PETANQUE': {
		prop: 'Pétanque',
		type: Number,
	},
	'HALTERES': {
		prop: 'Haltères',
		type: Number,
	},
	'FLECHETTES': {
		prop: 'Fléchettes',
		type: Number,
	},
	'RELAIS': {
		prop: 'Relais',
		type: String,
	},
	'EKIDEN': {
		prop: 'Ekiden',
		type: String,
	},
};


const DIMINISHING_PROPERTIES = [
	'Relais',
	'Ekiden',
];


function isDiminishing(property) {
	return DIMINISHING_PROPERTIES.includes(property);
}


class ScoreCalculator {
	#table;


	constructor(url, schema=DEFAULT_SCHEMA) {
		fetch(url)
			.then(response => response.arrayBuffer())
			.then(result => readXlsxFile(result, { schema }))
			.then((table) => {
				if (table.errors.length) {
					console.error(table.errors);
					throw new Error('Error in xlsx file');
				}
				this.#table = table.rows;
			});
	}


	getScore(property, performance) {

		const indexes = [];

		for (const index in this.#table) {
			if (this.#table[index][property] === undefined) { continue }
			indexes.push(Number(index));
		}

		let lowerBound = indexes.at(0);
		let upperBound = indexes.at(-1);
		const scoreMin = this.#table[lowerBound]['score'];
		const scoreMax = this.#table[upperBound]['score'];

		const parsedPerformance = ScoreCalculator.parsePerformance(performance);

		for (const index of indexes) {
			const value = this.#table[index][property];

			const parsedValue = ScoreCalculator.parsePerformance(value);

			if ((index > lowerBound) && (index < upperBound)) {
				if (parsedValue <= parsedPerformance) {
					if (isDiminishing(property)) {
						upperBound = index;
					} else {
						lowerBound = index;
					}
				} else if (parsedValue >= parsedPerformance) {
					if (isDiminishing(property)) {
						lowerBound = index;
					} else {
						upperBound = index;
					}
				}
			}
		}


		const yMin = this.#table[lowerBound]['score'];
		const yMax = this.#table[upperBound]['score'];
		const xMin = ScoreCalculator.parsePerformance(
			this.#table[lowerBound][property],
		);
		const xMax = ScoreCalculator.parsePerformance(
			this.#table[upperBound][property],
		);

		const score = Math.round(
			Math.min(
				Math.max(
					yMin + (yMax - yMin) * (parsedPerformance - xMin) / (xMax - xMin),
					scoreMin,
				),
				scoreMax,
			),
		);

		return score;
	}


	static parsePerformance(value) {
		if (!isNaN(Number(value))) {
			return Number(value);
		} else if (/(2[0-3]|[01][0-9]):[0-5][0-9]:[0-5][0-9]/.test(value)) {
			const split = value.split(':').map(number => Number(number));
			return split[0] * 3600 + split[1] * 60 + split[2];
		}
	}
}

