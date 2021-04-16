(function ($) {
    // Reset the zoom of a chart
    window.resetZoom = function (GraphIDs = [], buttonClass = null) {
        updateGraph('resetZoom', GraphIDs, buttonClass);
    };

    // Reset a graph so all datasets are shown and legend items are "on"
    window.resetGraph = function (GraphIDs = [], buttonClass = null) {
        updateGraph('resetGraph', GraphIDs, buttonClass);
    };

    // Clear annotations from a graph
    window.clearAnnotations = function (GraphIDs = [], buttonClass = null) {
        updateGraph('clearAnnotations', GraphIDs, buttonClass);
    };

    // Generate a custom legend
    window.generateCustomLegend = function (GraphIDs = [], legendContainer = null, clickAffectsGraphIDs = []) {
        updateGraph('generateCustomLegend', GraphIDs, null, {
            legendContainer: legendContainer,
            clickAffectsGraphIDs: clickAffectsGraphIDs
        });
    }

    // Hide a button with class of buttonClass
    window.hideGraphUpdateButton = function (buttonClass = null, activeClass = 'is-active') {
        if (buttonClass) {
            // Belt and braces: remove . from class name passed in if present
            buttonClass = buttonClass.replace('.', '');
            // Remove the is-active class
            $('.' + buttonClass).removeClass(activeClass);

            return true;
        }

        return false;
    }

    window.updateGraph = function (instruction = null, GraphIDs = [], buttonClass = null, data) {
        // Loop through all graph IDs passed in
        GraphIDs.forEach(function (GraphID) {
            // Find the instance with the ID passed in, on the canvas element
            Chart.helpers.each(Chart.instances, function (instance) {
                if (instance.chart.canvas.id == GraphID) {

                    switch (instruction) {
                        case 'resetZoom':
                            // Reset the zoom on the relevant chart instance
                            instance.chart.resetZoom();
                            break;
                        case 'resetGraph':
                            // Show all datasets
                            instance.chart.data.datasets.forEach(function (e, index) {
                                instance.chart.data.datasets[index].hidden = false;
                            });
                            instance.chart.update();
                            // Update the legend items
                            $('.' + instance.chart.id + '-legend li').removeClass('hidden');
                            break;
                        case 'clearAnnotations':
                            // clear annotations
                            instance.chart.options.annotation.annotations = [];
                            instance.chart.update();
                            break;
                        case 'generateCustomLegend':
                            if (data.legendContainer) {
                                var legendContainer = data.legendContainer;
                                // generate HTML legend
                                $(legendContainer).html(instance.chart.generateLegend());

                                // bind onClick event to all li tags of the legend
                                $(legendContainer + ' li').each(function () {
                                    $(this).on("click", function (event) {
                                        window.legendClick(event, data.clickAffectsGraphIDs);
                                    });
                                });
                            }
                            break;
                    }
                }
            })
        });
        hideGraphUpdateButton(buttonClass);

        return true;
    }

    window.legendClick = function (event, clickAffectsGraphIDs = []) {
        event = event || window.event;
        var target = event.target || event.srcElement;
        while (target.nodeName !== 'LI') {
            target = target.parentElement;
        }
        var parent = target.parentElement;
        var index = Array.prototype.slice.call(parent.children).indexOf(target);

        // Loop through all graph IDs passed in that should react to this click
        clickAffectsGraphIDs.forEach(function (GraphID) {
            // Find the instance with the ID passed in, on the canvas element
            Chart.helpers.each(Chart.instances, function (instance) {
                if (instance.chart.canvas.id == GraphID) {

                    var allVisible = true, // assume that all datasets are visible
                        datasetSize = instance.chart.data.datasets.length / 2; // all datasets divided by 2, as second half of datasets is polynomials of first half

                    var i = 0;
                    while (i < datasetSize) {
                        if (instance.chart.legend.legendItems[i].hidden) { // this dataset is hidden, meaning this is not the first legend click
                            allVisible = false; // not all datasets are visible
                            break;
                        }
                        i++;
                    }

                    if (allVisible) { // all datasets are visible, so hide all but the one clicked
                        i = 0;
                        while (i < datasetSize) {
                            if (index !== i) {
                                instance.chart.data.datasets[i].hidden = true; // raw data dataset
                                instance.chart.data.datasets[i + 7].hidden = true; // polynomial dataset

                                // Update the legend items
                                $('.' + instance.chart.id + '-legend li:nth-child(' + (i + 1) + ')').addClass('hidden');
                            }
                            i++;
                        }
                        // Show the reset graph button
                        document.getElementsByClassName('btn--reset-graph--fixed-age-value')[0].classList.add('is-active');

                        instance.chart.update();

                    } else { // not all datasets are visible, so we need to show/hide the one clicked depending on current state
                        instance.chart.data.datasets[index].hidden = !instance.chart.data.datasets[index].hidden; // toggles hidden value - true/false
                        instance.chart.data.datasets[index + 7].hidden = !instance.chart.data.datasets[index + 7].hidden;

                        // Update the legend items
                        $('.' + instance.chart.id + '-legend li:nth-child(' + (index + 1) + ')').toggleClass('hidden');

                        // Show the reset graph button
                        document.getElementsByClassName('btn--reset-graph--fixed-age-value')[0].classList.add('is-active');

                        instance.chart.update();
                    }

                    // Now check if the actions above have hidden all datasets - if so, reset the graph
                    var allHidden = true; // assume all datasets are hidden
                    i = 0;
                    while (i < datasetSize) {
                        if (!instance.chart.legend.legendItems[i].hidden) { // this dataset is NOT hidden
                            allHidden = false; // not all datasets are hidden
                            break;
                        }
                        i++;
                    }

                    if (allHidden) {
                        // all datasets are hidden, so reset all to be visible
                        i = 0;
                        while (i < datasetSize) {
                            instance.chart.data.datasets[i].hidden = false;
                            instance.chart.data.datasets[i + 7].hidden = false;
                            i++;
                        }
                        // Update the legend item
                        $('.' + instance.chart.id + '-legend li').removeClass('hidden');

                        // Hide the reset graph button
                        document.getElementsByClassName('btn--reset-graph--fixed-age-value')[0].classList.remove('is-active');

                        instance.chart.update();
                    }

                    // Now check if the actions above have led to all datasets being displayed - if so, hide the reset graph button
                    var allVisible = true; // assume all datasets are visible
                    i = 0;
                    while (i < datasetSize) {
                        if (instance.chart.legend.legendItems[i].hidden) { // this dataset is hidden
                            allVisible = false; // not all datasets are hidden
                            break;
                        }
                        i++;
                    }

                    if (allVisible) {
                        // Hide the reset graph button
                        document.getElementsByClassName('btn--reset-graph--fixed-age-value')[0].classList.remove('is-active');
                    }
                }
            });
        });
    }

    // Change the graph options based on window size
    window.changeGraphOptions = function (numberOfDatasets = 0) {
        // Get width and height of the window excluding scrollbars
        var w = document.documentElement.clientWidth;

        Chart.helpers.each(Chart.instances, function (instance) {

            if (w <= 767) {
                for (var i = 0; i < numberOfDatasets; i++) {
                    instance.chart.data.datasets[i].borderWidth = 1;
                    instance.chart.data.datasets[i].pointRadius = 2;
                }
            } else {
                for (var i = 0; i < numberOfDatasets; i++) {
                    instance.chart.data.datasets[i].borderWidth = 2;
                    instance.chart.data.datasets[i].pointRadius = 3;
                }
            }

            instance.chart.update();
        });

    }

    window.legendCallback = function (chart) {
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
    }

})(jQuery);