var chartOptionsLegend = {
    position: 'bottom',
    align: 'center',
    labels: {
        usePointStyle: true,
        padding: 20,
        boxWidth: 15,
        fontSize: 13,
        fontColor: '#7996B9',
    },
    onClick: function (e, legendItem) {
        var index = legendItem.datasetIndex;
        var ci = this.chart;
        var alreadyHidden = (ci.getDatasetMeta(index).hidden === null) ? false : ci.getDatasetMeta(index).hidden;

        ci.data.datasets.forEach(function (e, i) {
            var meta = ci.getDatasetMeta(i);

            if (i !== index) {
                if (!alreadyHidden) {
                    meta.hidden = meta.hidden === null ? !meta.hidden : null;
                } else if (meta.hidden === null) {
                    meta.hidden = true;
                }
            } else if (i === index) {
                meta.hidden = null;
            }
        });

        ci.update();
    }
}

var chartOptionsScalesQuarters = {
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
    // crosshair: {
    //     line: {
    //         color: '#F66',  // crosshair line color
    //         width: 1        // crosshair line width
    //     },
    // }
}

var chartOptionsQuarters = {
    responsive: true,
    maintainAspectRatio: false,
    legend: chartOptionsLegend,
    scales: chartOptionsScalesQuarters,
    plugins: chartOptionsPlugins,
    annotation: {
        events: ["click"],
        annotations: []
    },
};

var chartOptionsYears = {
    responsive: true,
    maintainAspectRatio: false,
    legend: chartOptionsLegend,
    scales: chartOptionsScalesYears,
    plugins: chartOptionsPlugins,
    annotation: {
        events: ["click"],
        annotations: []
    },
};

var chartOptionsOverview = {
    responsive: true,
    maintainAspectRatio: false,
    position: 'bottom',
    align: 'center',
    legend: {
        display: false
    },
    scales: chartOptionsScalesYears,
}
