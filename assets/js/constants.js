const PERFORMANCES_FORMAT = {
	'Lancer de poids': {
		test: value => !isNaN(Number(value)),
		placeholder: 'Distance en mètres',
		unit: ' mètres',
	},
	'Saut en longueur': {
		test: value => !isNaN(Number(value)),
		placeholder: 'Distance en mètres',
		unit: ' mètres',
	},
	'Ballons': {
		test: value => !isNaN(Number(value)),
		placeholder: 'Nombre de points',
		unit: ' points',
	},
	'Pétanque': {
		test: value => !isNaN(Number(value)),
		placeholder: 'Nombre de points',
		unit: ' points',
	},
	'Haltères': {
		test: value => !isNaN(Number(value)),
		placeholder: 'Ratio des poids',
		unit: ' points',
	},
	'Fléchettes': {
		test: value => !isNaN(Number(value)),
		placeholder: 'Nombre de points',
		unit: ' points',
	},
	'Relais': {
		test: value => /^(2[0-3]|[01][0-9]):[0-5][0-9]:[0-5][0-9]$/.test(value),
		placeholder: 'Durée (hh:mm:ss)',
		unit: '',
	},
	'Ekiden': {
		test: value => /^(2[0-3]|[01][0-9]):[0-5][0-9]:[0-5][0-9]$/.test(value),
		placeholder: 'Durée (hh:mm:ss)',
		unit: '',
	},
	"Course d'orientation": {
		noPerformance: true,
		unit: '',
	},
};

