var chartOptionsLegend = {
    position: 'bottom',
    align: 'center',
    labels: {
        usePointStyle: true,
        padding: 20,
        boxWidth: 15,
        fontSize: 13,
        fontColor: '#7996B9',
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
            enabled: true,
            mode: 'xy',
            speed: 2,
            threshold: 2
        },
        zoom: {
            enabled: true,
            mode: 'xy',
            sensitivity: 1,
            onZoomComplete: function ({chart}) {
                document.getElementsByClassName('btn--reset-zoom')[0].className += ' is-active';
            }
        }
    },
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
    }
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
    }
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
