var chartOptionsLegend = {
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

var chartOptionsTooltips = {
    onlyShowForDatasetIndex: [7, 8, 9, 10, 11, 12, 13], // only for polynomial lines
    // mode: 'interpolate',
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
};

var chartOptionsHover = {
    mode: 'nearest'
};

var chartOptionsAnnotations = {
    events: ["click"],
    annotations: []
};

var
    chartOptionsScalesQuarters = {
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

var chartOptionsScalesYears = {
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

var chartOptionsPlugins = {
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
    }
}

var chartOptionsQuarters = {
        responsive: true,
        maintainAspectRatio: false,
        legend: chartOptionsLegend,
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
        tooltips: chartOptionsTooltips,
        hover: chartOptionsHover,
        scales: chartOptionsScalesQuarters,
        plugins: chartOptionsPlugins,
        annotation: chartOptionsAnnotations,
    }
;

var chartOptionsYears = {
    responsive: true,
    maintainAspectRatio: false,
    legend: chartOptionsLegend,
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
    tooltips: chartOptionsTooltips,
    hover: chartOptionsHover,
    scales: chartOptionsScalesYears,
    plugins: chartOptionsPlugins,
    annotation: chartOptionsAnnotations,
};