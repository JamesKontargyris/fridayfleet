(function () {
    window.legendClickCallback = function (event) {
        event = event || window.event;

        var target = event.target || event.srcElement;
        while (target.nodeName !== 'LI') {
            target = target.parentElement;
        }
        var parent = target.parentElement;
        var chartId = parseInt(parent.classList[0].split("-")[0], 10);
        var chart = Chart.instances[chartId];
        var index = Array.prototype.slice.call(parent.children).indexOf(target);

        var allVisible = true; // assume that all datasets are visible

        var i = 0;
        while (i < (chart.config.data.datasets.length / 2)) { // all datasets divided by 2, as second half of datasets is polynomials of first half
            if (chart.legend.legendItems[i].hidden) { // this dataset is hidden, meaning this is not the first legend click
                allVisible = false; // not all datasets are visible
                break;
            }
            i++;
        }

        if (allVisible) { // all datasets are visible, so hide all but the one clicked
            i = 0;
            while (i < (chart.config.data.datasets.length / 2)) { // all datasets divided by 2, as second half of datasets is polynomials of first half
                if (index !== i) {
                    // i doesn't equal the current index, so we'll effect a click on those legend items to hide the lines on the graph
                    chart.legend.options.onClick.call(chart, event, chart.legend.legendItems[i]); // Actual data
                    chart.legend.options.onClick.call(chart, event, chart.legend.legendItems[i + 7]); // +7 to hide polynomial line too
                    // Update the legend items
                    $('.' + chartId + '-legend li:nth-child(' + (i + 1) + ')').addClass('hidden');
                }
                i++;
            }
            document.getElementsByClassName('btn--reset-graph')[0].classList.add('is-active');
        } else { // not all datasets are visible, so we need to show/hide the one clicked depending on current state
            chart.legend.options.onClick.call(chart, event, chart.legend.legendItems[index]); // Actual data
            chart.legend.options.onClick.call(chart, event, chart.legend.legendItems[index + 7]); // +7 to show/hide polynomial line too
            // Update the legend item
            $('.' + chartId + '-legend li:nth-child(' + (index + 1) + ')').toggleClass('hidden');
            document.getElementsByClassName('btn--reset-graph')[0].classList.add('is-active');
        }

        // Now check if the actions above have hidden all datasets - if so, reset the graph
        var allHidden = true; // assume all datasets are hidden
        i = 0;
        while (i < (chart.config.data.datasets.length / 2)) { // all datasets divided by 2, as second half of datasets is polynomials of first half
            if (!chart.legend.legendItems[i].hidden) { // this dataset is NOT hidden
                allHidden = false; // not all datasets are hidden
                break;
            }
            i++;
        }

        if (allHidden) {
            // all datasets are hidden, so reset all to be visible
            i = 0;
            while (i < (chart.config.data.datasets.length / 2)) { // all datasets divided by 2, as second half of datasets is polynomials of first half
                chart.legend.options.onClick.call(chart, event, chart.legend.legendItems[i]); // Actual data
                chart.legend.options.onClick.call(chart, event, chart.legend.legendItems[i + 7]); // +7 to show polynomial line too
                i++;
                // Update the legend item
            }
            $('.' + chartId + '-legend li').removeClass('hidden');
            document.getElementsByClassName('btn--reset-graph')[0].classList.remove('is-active');
        }

        return true;
    }
})();