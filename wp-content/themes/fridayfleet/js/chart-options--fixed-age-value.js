var fixedAgeValue_chartOptionsLegend = {
    display: false,

    // position: 'bottom',
    // align: 'center',
    // labels: {
    //     usePointStyle: true,
    //     padding: 20,
    //     boxWidth: 15,
    //     fontSize: 13,
    //     fontColor: '#7996B9',
    // },
}

var fixedAgeValue_chartOptionsTooltips = {
    onlyShowForDatasetIndex: [0, 1, 2, 3, 4, 5, 6], // show raw data, not polynomial data
    intersect: false,
    mode: 'nearest',
    displayColors: true,
    backgroundColor: '#ffffff',
    titleFontColor: '#086296',
    titleFontFamily: "'Lato', Calibri, sans-serif",
    titleFontSize: 14,
    bodyFontColor: '#002235',
    bodyFontFamily: "'Lato', Calibri, sans-serif",
    bodyFontSize: 14,
    callbacks: {
        label: function (tooltipItem, data) {
            if (tooltipItem.datasetIndex < 7) { // if above 7 this dataset is polynomial data, so shouldn't be displayed
                // Set up the label and data for the actual value
                var actualLabel = data.datasets[tooltipItem.datasetIndex].label || '';
                if (actualLabel) {
                    actualLabel += ': ';
                }
                actualLabel += tooltipItem.yLabel;

                // Setup the label and data for the polynomial value
                var polyLabel = 'Trend: ';
                polyLabel += data.datasets[tooltipItem.datasetIndex + 7].data[tooltipItem.index].y;

                return [actualLabel, polyLabel];
            }
            return false;
        },
        labelColor: function (tooltipItem, chart) {
            var useDatasetIndex = tooltipItem.datasetIndex < 7 ? tooltipItem.datasetIndex + 7 : tooltipItem.datasetIndex; // only use a higher dataset index if it is one of the first six datasets, i.e. the raw data, otherwise you get a console error
            return {
                borderColor: 'rgba(255,0,0, 0)',
                backgroundColor: chart.config.data.datasets[useDatasetIndex].backgroundColor, // use the background color of the polynomial lines rather than the lower opacity actual data lines

            }
        }
    },
};

var fixedAgeValue_chartOptionsHover = {
    mode: 'nearest'
};

var fixedAgeValue_chartOptionsAnnotations = {
    events: ["click"],
    annotations: []
};

var
    fixedAgeValue_chartOptionsScalesQuarters = {
        xAxes: [{
            type: 'time',
            distribution: 'series',
            time: {
                tooltipFormat: 'YYYY [Q]Q',
                unit: 'quarter',
                displayFormats: {
                    quarter: 'YYYY [Q]Q'
                }
            },
            ticks: {
                fontColor: '#7996B9',
            },
            gridLines: {
                color: 'rgba(62, 93, 122, 0.3)',
            },
        }],
        yAxes: [{
            scaleLabel: {
                display: true,
                labelString: '€ MILLIONS',
                fontSize: 11,
                fontColor: '#4C7094',
            },
            ticks: {
                beginAtZero: true,
                fontColor: '#7996B9',
            },
            gridLines: {
                color: 'rgba(62, 93, 122, 1)',
                zeroLineColor: 'rgba(62, 93, 122, 1)',
            }
        }]
    }

var fixedAgeValue_chartOptionsScalesYears = {
    xAxes: [{
        type: 'time',
        distribution: 'series',
        time: {
            tooltipFormat: 'YYYY',
            minUnit: 'year',
            displayFormats: {
                year: 'YYYY'
            }
        },
        ticks: {
            fontColor: '#7996B9',
        },
        gridLines: {
            color: 'rgba(62, 93, 122, 0.3)',
        },
    }],
    yAxes: [{
        scaleLabel: {
            display: true,
            labelString: '€ MILLIONS',
            fontSize: 11,
            fontColor: '#4C7094',
        },
        ticks: {
            beginAtZero: true,
            fontColor: '#7996B9',
        },
        gridLines: {
            color: 'rgba(62, 93, 122, 1)',
            zeroLineColor: 'rgba(62, 93, 122, 1)',
        }
    }]
}

var fixedAgeValue_chartOptionsPlugins = {
    zoom: {
        pan: {
            enabled: false,
            mode: 'xy',
            speed: 2,
            threshold: 2
        },
        zoom: {
            enabled: true,
            drag: true,
            mode: 'xy',
            sensitivity: 1,
            onZoomComplete: function ({chart}) {
                document.getElementsByClassName('btn--reset-zoom')[0].className += ' is-active';
            }
        }
    },
    crosshair: {
        line: {
            color: '#F66',  // crosshair line color
            width: 1        // crosshair line width
        },
        zoom: {
            enabled: false,                                      // enable zooming
        },
    },
    datalabels: {
        display: false
    }
}

var fixedAgeValue_chartOptionsQuarters = {
        responsive: true,
        maintainAspectRatio: false,
        legend: fixedAgeValue_chartOptionsLegend,
        legendCallback: function (chart) {
            var text = [];
            text.push('<ul class="' + chart.id + '-legend chartjs-legend">');
            for (var i = 0; i < (chart.data.datasets.length / 2); i++) { // divide by 2 as the second set of data is polynomial lines
                if (chart.data.datasets[i].label) {
                    text.push('<li>');
                    text.push(chart.data.datasets[i].label);
                    text.push('</li>');
                }
            }
            text.push('</ul>');
            return text.join('');
        },
        tooltips: fixedAgeValue_chartOptionsTooltips,
        hover: fixedAgeValue_chartOptionsHover,
        scales: fixedAgeValue_chartOptionsScalesQuarters,
        plugins: fixedAgeValue_chartOptionsPlugins,
        annotation: fixedAgeValue_chartOptionsAnnotations,
        onClick: function (event, activeElements) {


            // Get X and Y values when clicking on graph
            // var yTop = this.chart.chartArea.top;
            // var yBottom = this.chart.chartArea.bottom;
            //
            // var yMin = this.chart.scales['y-axis-0'].min;
            // var yMax = this.chart.scales['y-axis-0'].max;
            // var newY = 0;
            //
            // if (event.offsetY <= yBottom && event.offsetY >= yTop) {
            //     newY = Math.abs((event.offsetY - yTop) / (yBottom - yTop));
            //     newY = (newY - 1) * -1;
            //     newY = newY * (Math.abs(yMax - yMin)) + yMin;
            // }
            // ;
            //
            // var xTop = this.chart.chartArea.left;
            // var xBottom = this.chart.chartArea.right;
            // var xMin = this.chart.scales['x-axis-0'].min;
            // var xMax = this.chart.scales['x-axis-0'].max;
            // var newX = 0;
            //
            // if (event.offsetX <= xBottom && event.offsetX >= xTop) {
            //     newX = Math.abs((event.offsetX - xTop) / (xBottom - xTop));
            //     newX = newX * (Math.abs(xMax - xMin)) + xMin;
            // };
            //
            // console.log(newX, newY);
        }
    }
;

var fixedAgeValue_chartOptionsYears = {
    responsive: true,
    maintainAspectRatio: false,
    legend: fixedAgeValue_chartOptionsLegend,
    legendCallback: function (chart) {
        var text = [];
        text.push('<ul class="' + chart.id + '-legend chartjs-legend">');
        for (var i = 0; i < (chart.data.datasets.length / 2); i++) { // divide by 2 as the second set of data is polynomial lines
            if (chart.data.datasets[i].label) {
                text.push('<li>');
                text.push(chart.data.datasets[i].label);
                text.push('</li>');
            }
        }
        text.push('</ul>');
        return text.join('');
    },
    tooltips: fixedAgeValue_chartOptionsTooltips,
    hover: fixedAgeValue_chartOptionsHover,
    scales: fixedAgeValue_chartOptionsScalesYears,
    plugins: fixedAgeValue_chartOptionsPlugins,
    annotation: fixedAgeValue_chartOptionsAnnotations,
};