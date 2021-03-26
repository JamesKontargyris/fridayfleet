var depreciation_chartOptionsLegend = {
    display: false
}

var depreciation_chartOptionsTooltips = {
    onlyShowForDatasetIndex: [0], // show raw data, not polynomial data
    intersect: false,
    mode: 'nearest',
    displayColors: false,
    backgroundColor: '#ffffff',
    titleFontColor: '#086296',
    titleFontFamily: "'Lato', Calibri, sans-serif",
    titleFontSize: 14,
    bodyFontColor: '#002235',
    bodyFontFamily: "'Lato', Calibri, sans-serif",
    bodyFontSize: 14,
};

var depreciation_chartOptionsHover = {
    mode: 'nearest'
};

var depreciation_chartOptionsAnnotations = {
    events: ["click"],
    annotations: []
};

var
    depreciation_chartOptionsScales = {
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
                labelString: 'DEPRECIATION',
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

var depreciation_chartOptionsPlugins = {
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
        color: '#36A2EB',
        align: 'top',
        offset: 4,
        font: {
            size: 12
        },
        formatter: function (value, context) {
            if(context.datasetIndex > 0) { // not the first dataset, i.e. the one that should have labels
                return '';
            }
            return value.y;
        }
    }
}

var depreciation_chartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    legend: depreciation_chartOptionsLegend,
    tooltips: depreciation_chartOptionsTooltips,
    hover: depreciation_chartOptionsHover,
    scales: depreciation_chartOptionsScales,
    plugins: depreciation_chartOptionsPlugins,
    annotation: depreciation_chartOptionsAnnotations,
};