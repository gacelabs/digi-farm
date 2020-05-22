$(document).ready(function() {

	var utils = Samples.utils;
	var inputs = {
		min: 20,
		max: 80,
		count: 12,
		decimals: 2,
		continuity: 1
	};

	utils.srand(42);

	function generateData() {
		return utils.numbers(inputs);
	}
	function generateLabels() {
		return utils.months({count: inputs.count});
	}

	console.log(generateData());

	var ctx = document.getElementById('myChart').getContext('2d');
	var myChart = new Chart(ctx, {
		type: 'line',
		data: {
			labels: generateLabels(),
			datasets: [{
				label: 'Carrots',
				backgroundColor: utils.color(0),
				borderColor: utils.color(0),
				data: generateData(),
				fill: false,
			}, {
				label: 'Tomatoes',
				backgroundColor: utils.color(1),
				borderColor: utils.color(1),
				data: generateData(),
				fill: false,
			}]
		},
		options: {
			title: {
				display: true,
				text: 'Sales Chart'
			},
			/*legend: {
				onHover: function(event, legendItem) {
					log('onHover: ' + legendItem.text);
				},
				onLeave: function(event, legendItem) {
					log('onLeave: ' + legendItem.text);
				},
				onClick: function(event, legendItem) {
					log('onClick:' + legendItem.text);
				}
			},*/
			scales: {
				xAxes: [{
					display: true,
					scaleLabel: {
						display: true,
						labelString: 'Month'
					}
				}],
				yAxes: [{
					display: true,
					scaleLabel: {
						display: true,
						labelString: 'Price'
					}
				}]
			},
			tooltips: {
				callbacks: {
					title: function(tooltipItem, chartData) {
						var item = chartData.datasets[tooltipItem[0].datasetIndex].label;
						var yLabel = tooltipItem[0].label;
						return yLabel+"\n("+item+")";
					},
					label: function(tooltipItem, chartData) {
						// console.log(tooltipItem, chartData)
						return '₱ '+tooltipItem.value;
					}
				}
			}
		}
	});
	
});

'use strict';

window.chartColors = {
	red: 'rgb(255, 99, 132)',
	orange: 'rgb(255, 159, 64)',
	yellow: 'rgb(255, 205, 86)',
	green: 'rgb(75, 192, 192)',
	blue: 'rgb(54, 162, 235)',
	purple: 'rgb(153, 102, 255)',
	grey: 'rgb(201, 203, 207)'
};

(function(global) {
	var MONTHS = [
		'January',
		'February',
		'March',
		'April',
		'May',
		'June',
		'July',
		'August',
		'September',
		'October',
		'November',
		'December'
	];

	var COLORS = [
		'#4dc9f6',
		'#f67019',
		'#f53794',
		'#537bc4',
		'#acc236',
		'#166a8f',
		'#00a950',
		'#58595b',
		'#8549ba'
	];

	var Samples = global.Samples || (global.Samples = {});
	var Color = global.Color;

	Samples.utils = {
		// Adapted from http://indiegamr.com/generate-repeatable-random-numbers-in-js/
		srand: function(seed) {
			this._seed = seed;
		},

		rand: function(min, max) {
			var seed = this._seed;
			min = min === undefined ? 0 : min;
			max = max === undefined ? 1 : max;
			this._seed = (seed * 9301 + 49297) % 233280;
			return min + (this._seed / 233280) * (max - min);
		},

		numbers: function(config) {
			var cfg = config || {};
			var min = cfg.min || 0;
			var max = cfg.max || 1;
			var from = cfg.from || [];
			var count = cfg.count || 8;
			var decimals = cfg.decimals || 8;
			var continuity = cfg.continuity || 1;
			var dfactor = Math.pow(10, decimals) || 0;
			var data = [];
			var i, value;

			for (i = 0; i < count; ++i) {
				value = (from[i] || 0) + this.rand(min, max);
				if (this.rand() <= continuity) {
					data.push(Math.round(dfactor * value) / dfactor);
				} else {
					data.push(null);
				}
			}

			return data;
		},

		labels: function(config) {
			var cfg = config || {};
			var min = cfg.min || 0;
			var max = cfg.max || 100;
			var count = cfg.count || 8;
			var step = (max - min) / count;
			var decimals = cfg.decimals || 8;
			var dfactor = Math.pow(10, decimals) || 0;
			var prefix = cfg.prefix || '';
			var values = [];
			var i;

			for (i = min; i < max; i += step) {
				values.push(prefix + Math.round(dfactor * i) / dfactor);
			}

			return values;
		},

		months: function(config) {
			var cfg = config || {};
			var count = cfg.count || 12;
			var section = cfg.section;
			var values = [];
			var i, value;

			for (i = 0; i < count; ++i) {
				value = MONTHS[Math.ceil(i) % 12];
				values.push(value.substring(0, section));
			}

			return values;
		},

		color: function(index) {
			return COLORS[index % COLORS.length];
		},

		transparentize: function(color, opacity) {
			var alpha = opacity === undefined ? 0.5 : 1 - opacity;
			return Color(color).alpha(alpha).rgbString();
		}
	};

	// DEPRECATED
	window.randomScalingFactor = function() {
		return Math.round(Samples.utils.rand(-100, 100));
	};

	// INITIALIZATION
	Samples.utils.srand(Date.now());

}(this));



function generateData2() {
	// var unit = document.getElementById('unit').value;
	var unit = 'day';

	function unitLessThanDay() {
		return unit === 'second' || unit === 'minute' || unit === 'hour';
	}

	function beforeNineThirty(date) {
		return date.hour() < 9 || (date.hour() === 9 && date.minute() < 30);
	}

	// Returns true if outside 9:30am-4pm on a weekday
	function outsideMarketHours(date) {
		if (date.isoWeekday() > 5) {
			return true;
		}
		if (unitLessThanDay() && (beforeNineThirty(date) || date.hour() > 16)) {
			return true;
		}
		return false;
	}

	function randomNumber(min, max) {
		return Math.random() * (max - min) + min;
	}

	function randomBar(date, lastClose) {
		var open = randomNumber(lastClose * 0.95, lastClose * 1.05).toFixed(2);
		var close = randomNumber(open * 0.95, open * 1.05).toFixed(2);
		return {
			t: date.valueOf(),
			y: close
		};
	}

	var date = moment('Jan 01 2019', 'MMM DD YYYY');
	var now = moment();
	var data = [];
	var lessThanDay = unitLessThanDay();
	for (; data.length < 600 && date.isBefore(now); date = date.clone().add(1, unit).startOf(unit)) {
		if (outsideMarketHours(date)) {
			if (!lessThanDay || !beforeNineThirty(date)) {
				date = date.clone().add(date.isoWeekday() >= 5 ? 8 - date.isoWeekday() : 1, 'day');
			}
			if (lessThanDay) {
				date = date.hour(9).minute(30).second(0);
			}
		}
		data.push(randomBar(date, data.length > 0 ? data[data.length - 1].y : 30));
	}

	return data;
}

console.log(generateData2());
var ctx = document.getElementById('chart1').getContext('2d');
ctx.canvas.width = 1000;
ctx.canvas.height = 300;

var color = Chart.helpers.color;
var cfg = {
	data: {
		datasets: [{
			label: 'CHRT - Chart.js Corporation',
			backgroundColor: color(window.chartColors.red).alpha(0.5).rgbString(),
			borderColor: window.chartColors.red,
			data: generateData2(),
			type: 'line',
			pointRadius: 0,
			fill: false,
			lineTension: 0,
			borderWidth: 2
		}]
	},
	options: {
		animation: {
			duration: 0
		},
		scales: {
			xAxes: [{
				type: 'time',
				distribution: 'series',
				offset: true,
				ticks: {
					major: {
						enabled: true,
						fontStyle: 'bold'
					},
					source: 'data',
					autoSkip: true,
					autoSkipPadding: 75,
					maxRotation: 0,
					sampleSize: 100
				},
				afterBuildTicks: function(scale, ticks) {
					var majorUnit = scale._majorUnit;
					var firstTick = ticks[0];
					var i, ilen, val, tick, currMajor, lastMajor;

					val = moment(ticks[0].value);
					if ((majorUnit === 'minute' && val.second() === 0)
							|| (majorUnit === 'hour' && val.minute() === 0)
							|| (majorUnit === 'day' && val.hour() === 9)
							|| (majorUnit === 'month' && val.date() <= 3 && val.isoWeekday() === 1)
							|| (majorUnit === 'year' && val.month() === 0)) {
						firstTick.major = true;
					} else {
						firstTick.major = false;
					}
					lastMajor = val.get(majorUnit);

					for (i = 1, ilen = ticks.length; i < ilen; i++) {
						tick = ticks[i];
						val = moment(tick.value);
						currMajor = val.get(majorUnit);
						tick.major = currMajor !== lastMajor;
						lastMajor = currMajor;
					}
					return ticks;
				}
			}],
			yAxes: [{
				gridLines: {
					drawBorder: false
				},
				scaleLabel: {
					display: true,
					labelString: 'Closing price ($)'
				}
			}]
		},
		tooltips: {
			intersect: false,
			mode: 'index',
			callbacks: {
				label: function(tooltipItem, myData) {
					var label = myData.datasets[tooltipItem.datasetIndex].label || '';
					if (label) {
						label += ': ';
					}
					label += parseFloat(tooltipItem.value).toFixed(2);
					return label;
				}
			}
		}
	}
};

var chart = new Chart(ctx, cfg);

/*document.getElementById('update').addEventListener('click', function() {
	var type = document.getElementById('type').value;
	var dataset = chart.config.data.datasets[0];
	dataset.type = type;
	dataset.data = generateData2();
	chart.update();
});*/

