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

var chartOptionsScales = {
    xAxes: [{
        scaleLabel: {
            display: false,
            labelString: 'TIME',
            fontSize: 10,
            fontColor: '#4C7094',
        },
        ticks: {
            fontColor: '#7996B9',
        },
        gridLines: {
            color: 'rgba(62, 93, 122, 0.3)',
        }
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
    }
}

var chartOptions = {
    legend: chartOptionsLegend,
    scales:chartOptionsScales,
    plugins: chartOptionsPlugins
};
