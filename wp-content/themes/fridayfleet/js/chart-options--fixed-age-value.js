var fixedAgeValue_chartOptionsLegend = {
    display: false
}

var fixedAgeValue_chartOptionsTooltips = {
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
            var datasetIndexActual = tooltipItem.datasetIndex;
            var datasetIndexPoly = tooltipItem.datasetIndex + 7;

            if (tooltipItem.datasetIndex >= 7) { // if equal to or above 7 this dataset is polynomial data, so find the corresponding dataset indices
                datasetIndexActual = tooltipItem.datasetIndex - 7;
                datasetIndexPoly = tooltipItem.datasetIndex;
            }
            // Set up the label and data for the actual value
            var actualLabel = data.datasets[datasetIndexActual].label || '';
            if (actualLabel) {
                actualLabel += ': ';
            }
            actualLabel += data.datasets[datasetIndexActual].data[tooltipItem.index].y;

            // Setup the label and data for the polynomial value
            var polyLabel = 'Trend: ';
            polyLabel += data.datasets[datasetIndexPoly].data[tooltipItem.index].y;

            return [actualLabel, polyLabel];
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
    mode: 'nearest',
    // onHover: function (event, elements) {
    //     if (elements.length) {
    //         var chart = elements[0]._chart,
    //             datasetIndex = elements[0]._datasetIndex,
    //             dataIndex = elements[0]._index;
    //         // console.log(elements[0]);
    //         if(datasetIndex >= 7) {
    //             datasetIndex = datasetIndex - 7;
    //         }
    //         chart.data.datasets[datasetIndex].backgroundColor[dataIndex] = 'white';
    //         chart.update();
    //     }
    // }
};

var fixedAgeValue_chartOptionsAnnotations = {
    events: ["click"],
    annotations: []
};

var fixedAgeValue_chartOptionsxAxes = {
    ticks: {
        fontColor: '#7996B9',
    },
    gridLines: {
        color: 'rgba(62, 93, 122, 0.3)',
    }
}

var fixedAgeValue_chartOptionsyAxes = [{
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
}];

var fixedAgeValue_chartOptionsScales = {
    quarters: {
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
            ticks: fixedAgeValue_chartOptionsxAxes.ticks,
            gridLines: fixedAgeValue_chartOptionsxAxes.gridLines
        }],
        yAxes: fixedAgeValue_chartOptionsyAxes
    },
    years: {
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
            ticks: fixedAgeValue_chartOptionsxAxes.ticks,
            gridLines: fixedAgeValue_chartOptionsxAxes.gridLines
        }],
        yAxes: fixedAgeValue_chartOptionsyAxes
    }
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
                document.getElementsByClassName('btn--reset-zoom--fixed-age-value')[0].className += ' is-active';
            }
        }
    },
    crosshair: {
        sync: {
            enabled: false
        },
        line: {
            color: '#F66',  // crosshair line color
            width: 1        // crosshair line width
        },
        zoom: {
            enabled: false // enable zooming
        },
    },
    datalabels: {
        display: false
    }
}

var fixedAgeValue_chartOptions = {
    quarters: {
        responsive: true,
        maintainAspectRatio: false,
        tooltips: fixedAgeValue_chartOptionsTooltips,
        hover: fixedAgeValue_chartOptionsHover,
        scales: fixedAgeValue_chartOptionsScales.quarters,
        plugins: fixedAgeValue_chartOptionsPlugins,
        annotation: fixedAgeValue_chartOptionsAnnotations,
        legend: fixedAgeValue_chartOptionsLegend,
        legendCallback: function (chart) {
            return legendCallback(chart);
        },
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
    },
    years: {
        responsive: true,
        maintainAspectRatio: false,
        legend: fixedAgeValue_chartOptionsLegend,
        tooltips: fixedAgeValue_chartOptionsTooltips,
        hover: fixedAgeValue_chartOptionsHover,
        scales: fixedAgeValue_chartOptionsScales.years,
        plugins: fixedAgeValue_chartOptionsPlugins,
        annotation: fixedAgeValue_chartOptionsAnnotations,
        legendCallback: function (chart) {
            return legendCallback(chart);
        },
    }
}