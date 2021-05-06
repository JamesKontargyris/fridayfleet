<?php

use FridayFleet\FridayFleetController;

$ff                 = new FridayFleetController;
$ship_type_db_slugs = get_ship_type_database_slugs(); // get all ship type database slugs for comparison to the one passed in, if any
// $args is passed in by WordPress' get_template_part function in WP5.5+
$form_data = isset( $args ) ? $args['form_data'] : [];
// Replace slashes with dashes so PHP knows the dates are in dd/mm/yyyy format
$form_data['build_date']      = str_replace( '/', '-', $form_data['build_date'] );
$form_data['date_of_finance'] = str_replace( '/', '-', $form_data['date_of_finance'] );

if ( ! $form_data['build_date'] || ! validateDate( $form_data['build_date'], 'd-m-Y' ) ) : // build date not present or valid
	?>
    <div class="message message--error">ERROR: please enter a valid build date in the format dd/mm/yyyy.</div>
	<?php exit();
endif;

$ship_db_slug = $form_data['ship'] ?: '0';
if ( ! in_array( $ship_db_slug, $ship_type_db_slugs ) ) : // ship type not found
	?>
    <div class="message message--error">
        ERROR: invalid ship type.
    </div>
	<?php exit();
endif;

if ( ! $ship_type_data = get_ship_type_by_database_slug( $ship_db_slug ) ) : ?>
    <div class="message message--error">
        ERROR: ship not found.
    </div>
	<?php exit();
endif;

if ( $form_data['date_of_finance'] && ( strtotime( $form_data['build_date'] ) > strtotime( $form_data['date_of_finance'] ) ) ) : ?>
    <div class="message message--error">
        ERROR: date of finance must be later than build date.
    </div>
	<?php exit();
endif;

$depreciation_data     = [];
$build_date            = str_replace( '/', '-', $form_data['build_date'] );
$date_of_finance_slug  = '';
$percentage_of_finance = $form_data['percentage_of_finance'] ?: 0;

if ( $form_data['date_of_finance'] ) { // a date of finance was passed in
	$date_of_finance                  = str_replace( '/', '-', $form_data['date_of_finance'] );
	$date_of_finance_array            = [
		'year'  => date( 'Y', strtotime( $date_of_finance ) ),
		'month' => date( 'm', strtotime( $date_of_finance ) ),
		'day'   => date( 'd', strtotime( $date_of_finance ) ),
	];
	$months_by_first_month_in_quarter = [
		'01' => '01',
		'02' => '01',
		'03' => '01',
		'04' => '04',
		'05' => '04',
		'06' => '04',
		'07' => '07',
		'08' => '07',
		'09' => '07',
		'10' => '10',
		'11' => '10',
		'12' => '10'
	]; // month number => first month of quarter it belongs to
	$quarters_by_month                = [
		'01' => '1',
		'02' => '1',
		'03' => '1',
		'04' => '2',
		'05' => '2',
		'06' => '2',
		'07' => '3',
		'08' => '3',
		'09' => '3',
		'10' => '4',
		'11' => '4',
		'12' => '4'
	]; // month number => first month of quarter it belongs to
	$date_of_finance_slug             = $date_of_finance_array['year'] . $months_by_first_month_in_quarter[ $date_of_finance_array['month'] ];
	$date_of_finance_slug_pretty      = $date_of_finance_array['year'] . ' Q' . $quarters_by_month[ $date_of_finance_array['month'] ];
}

$depreciation_data = $ff->getDepreciationData( date( 'Y-m-d', strtotime( $build_date ) ), $ship_db_slug );
$ship_type_id      = $ship_type_data->ID;
$graph_colours     = $ff->getColours();

if ( ! $depreciation_data && $build_date ) : // there's a build date, but there's no data for it
	?>
    <div class="message message--error">
        ERROR: no data found. Please enter another build date.
        <div class="message__close"></div>
    </div>
<?php endif;

if ( $depreciation_data ) : ?>

    <section class="box">
        <div class="box__header">
            <div class="box__header__titles">
                <div class="box__header__title">Vessel Finance | Graph <span
                            class="help-icon tooltip--help hide--no-touch"
                            title="Drag out an area to zoom. Tap a datapoint to view data."></span>
                    <span class="help-icon tooltip--help hide--touch"
                          title="Drag out an area to zoom. Hover over a datapoint to view data."></span>
                </div>
            </div>
        </div>

        <div class="box__content">

            <div class="graph-update-button-group">
                <button onclick="resetZoom(['graph__depreciation'], 'btn--reset-zoom--vessel-finance-calculator')"
                        class="btn btn--graph-update btn--reset-zoom--vessel-finance-calculator">
                    Reset Zoom
                </button>
                <button onclick="clearAnnotations(['graph__depreciation'], 'btn--clear-annotations--vessel-finance-calculator', ['date-of-finance-line', 'percentage-of-finance-line', 'percentage-of-finance-box'])"
                        class="btn btn--graph-control btn--graph-update btn--clear-annotations--vessel-finance-calculator">
                    Remove Line(s)
                </button>
            </div>

            <div class="graphs-container">

                <div class="graph-group is-active">
                    <div class="depreciation-summary"></div>
                    <div class="graph-group__canvas-container">
                        <canvas class="graph graph__depreciation" id="graph__depreciation"></canvas>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <section class="box">
        <div class="box__header">
            <div class="box__header__titles">
                <div class="box__header__title">Vessel Finance | Data</div>
            </div>
            <div class="box__header__controls">
                <div class="toggle-switch">
                    <label for="view-depreciation-data" data-style="rounded" data-text="false"
                           data-size="xs">
                        <input checked type="checkbox" id="view-depreciation-data"
                               class="toggle-trend-data"
                               data-class-to-toggle=".is-depreciation-trend-data, .data-table__key--depreciation">
                        <span class="toggle">
                                    <span class="switch"></span>
                                </span>
                        <span class="toggle-switch__label">View trend data</span>
                    </label>
                </div>
            </div>
        </div>
        <div class="box__content box__content--scrollable" style="max-height: 25vh;">
			<?php get_template_part( 'template-parts/partials/partial', 'data-table-key', [ 'unique_class' => 'data-table__key--depreciation' ] ); ?>

            <div class="data-table-container">

                <table class="data-table data-table--first-col data-table--sticky-header"
                       cellpadding="0" cellspacing="0" border="0">

                    <tbody class="content--fixed-age-value-quarters is-active">
					<?php
					$table_data              = array_reverse( $depreciation_data, true ); // change data to descending order
					$quarters                = [
						'01' => '1',
						'04' => '2',
						'07' => '3',
						'10' => '4'
					]; // first month of each quarter assigned to quarter number
					$year                    = 0;
					$display_on_page_load    = 1; // used to display the latest year's set of data on page load
					$latest_set_of_data_year = substr( key( $table_data ), 0, 4 ); // gets the year from the latest set of data. Used to display the latest year's set of data on page load (format of keys is YYYYMM, where MM is first month of quarter)
					$datasetIndex            = 0; // used to assign each depreciation value table cell with a unique ID

					foreach ( $table_data as $timestamp => $depreciation_value ) : ?>
						<?php $timestamp_year = substr( $timestamp, 0, 4 ); // take YYYY from YYYYQQ ?>
						<?php $timestamp_quarter = substr( $timestamp, 4, 2 ); // take QQ from YYYQQ ?>

						<?php if ( $year != $timestamp_year ) : $year = $timestamp_year; ?>
                            <tr class="data-table__sub-title<?php if ( $display_on_page_load && $latest_set_of_data_year == $year ) : ?> is-active<?php endif; ?>"
                                data-year="<?php echo $year; ?>">
                                <td colspan="8"><?php echo $timestamp_year; ?></td>
                            </tr>
						<?php endif; ?>
                        <tr data-year-data="<?php echo $year; ?>" <?php if ( $display_on_page_load && $latest_set_of_data_year == $year ) : ?> class="is-active"<?php endif; ?>>
                            <td><?php echo 'Q' . $quarters[ $timestamp_quarter ]; ?></td>
                            <td data-depreciation-poly-data-target-id="<?php echo $datasetIndex; ?>"><?php echo number_format( $depreciation_value, 2 ); ?></td>
                        </tr>
						<?php $datasetIndex ++; endforeach; ?>
                    </tbody>

                </table>
            </div>
        </div>
    </section>


<?php endif; ?>

<?php if ( isset( $build_date ) && isset( $depreciation_data ) && $depreciation_data ) : ?>
    <script>
        (function ($) {
            // reset visibility of depreciation summary box
            $('.depreciation-summary').removeClass('is-active');

            // create the graph
            var ctxDepreciation = document.getElementById('graph__depreciation');

            var chartDepreciation = new Chart(ctxDepreciation, {
                type: 'line',
                data: {
                    datasets: [
                        {
                            data: [
								<?php foreach($depreciation_data as $x => $y) : ?>
                                {
                                    x: moment('<?php echo $x; ?>', "YYYYMM"),
                                    y: <?php echo number_format( $y, 2 ); ?>
                                },
								<?php endforeach; ?>
                            ],
                            fill: false,
                            borderColor: 'rgba(234,0,0, 0.4)',
                            backgroundColor: 'rgba(234,0,0, 0.4)',
                            borderWidth: 2,
                            spanGaps: true,
                            pointStyle: 'circle',
                            pointRadius: 3,
                            pointHitRadius: 10,
                            pointHoverRadius: 3,
                            pointHoverBorderColor: 'rgba(234,0,0, 0.4)',
                            pointHoverBackgroundColor: 'rgba(234,0,0, 0.4)',
                            lineTension: 0.3,
                        },
                    ]
                },

                options: depreciation_chartOptions,

            });

            //Create polynomial line and add it to the graph
            // Build an array of raw data
            var rawData = [],
                i = 0;
			<?php foreach($depreciation_data as $x => $y) : ?>
            rawData.push([i, <?php echo number_format( $y, 2 ); ?>]);
            i++;
			<?php endforeach; ?>

            polynomialData = regression.polynomial(rawData, {order: 3, precision: 10});

            // console.log(polynomialData);
            // make an easier to access polynomial array, where the keys are years/first months of quarter and the values are the polynomial points
            // This will help if we need to put a percentage of finance line on the graph
            var polynomial_data_by_date = {};
			<?php $i = 0; ?>
			<?php foreach($depreciation_data as $x => $y) : ?>
            Object.assign(polynomial_data_by_date, {<?php echo $x; ?>:
            polynomialData['points'][<?php echo $i; ?>][1].toFixed(2)
        })
            ;
			<?php $i ++; ?>
			<?php endforeach; ?>

            chartDepreciation.data.datasets.push({
                data: [
					<?php $i = 0; ?>
					<?php foreach($depreciation_data as $x => $y) : ?>
                    {
                        x: moment('<?php echo $x; ?>', "YYYYMM"),
                        y: +(polynomialData['points'][<?php echo $i; ?>][1].toFixed(2))
                    },
					<?php $i ++; ?>
					<?php endforeach; ?>
                ],
                fill: false,
                borderColor: 'rgba(234,0,0, 1)',
                backgroundColor: 'rgba(234,0,0, 1)',
                borderWidth: 2,
                spanGaps: true,
                pointStyle: 'circle',
                pointRadius: 0,
                pointHitRadius: 0,
                pointHoverRadius: 0,
                lineTension: 0.3,
                options: depreciation_chartOptions,
            });
            chartDepreciation.update();

            window.addDateOfFinanceLine = function (year, month, day, text) {
                var line = year + ' ' + month + ' ' + day,
                    graphValue = year + ' ' + month + ' ' + day;

                var newAnnotation = {
                    drawTime: "beforeDatasetsDraw",
                    id: 'date-of-finance-line',
                    type: "line",
                    mode: "vertical",
                    scaleID: "x-axis-0",
                    value: graphValue,
                    borderColor: 'rgba(255, 171, 0, 1)',
                    borderWidth: 2,
                    borderDash: [2, 2],
                    borderDashOffset: 5,
                    label:
                        {
                            enabled: true,
                            backgroundColor: 'rgba(255, 171, 0, 0.8)',
                            cornerRadius: 0,
                            position: "bottom",
                            fontColor: "rgba(0,34,43,1)",
                            fontFamily: "Lato",
                            fontSize: 12,
                            content: text,
                            rotation: 90,
                            textAlign: "end",
                            xAdjust: 12,
                            yAdjust: 50,
                        }
                };
                chartDepreciation.options.annotation.annotations.push(newAnnotation);
                chartDepreciation.update();
            }

            window.addPercentageOfFinanceBox = function (finance_value, xStartIndex = 0) {
                var newAnnotation = {
                    drawTime: "beforeDatasetsDraw",
                    id: 'percentage-of-finance-box',
                    type: "box",
                    xMin: xStartIndex,
                    xMax: '299910', // the year 2999...
                    yMin: 0,
                    yMax: finance_value,
                    xScaleID: 'x-axis-0',
                    yScaleID: 'y-axis-0',
                    backgroundColor: 'rgba(255, 171, 0,0.2)',
                };
                chartDepreciation.options.annotation.annotations.push(newAnnotation);
                chartDepreciation.update();
            }

            window.addPercentageOfFinanceLine = function (finance_value, text = '') {
                var newAnnotation = {
                    drawTime: "afterDatasetsDraw",
                    id: 'percentage-of-finance-line',
                    type: "line",
                    mode: "horizontal",
                    scaleID: "y-axis-0",
                    value: finance_value,
                    borderColor: 'rgba(255, 171, 0, 1)',
                    borderWidth: 2,
                    borderDash: [2, 2],
                    borderDashOffset: 5,
                    label:
                        {
                            enabled: true,
                            backgroundColor: 'rgba(255, 171, 0, 0.8)',
                            cornerRadius: 0,
                            position: "right",
                            fontColor: "rgba(0,34,43,1)",
                            fontFamily: "Lato",
                            fontSize: 12,
                            content: text,
                            yAdjust: -13,
                        }
                };
                chartDepreciation.options.annotation.annotations.push(newAnnotation);
                chartDepreciation.update();
            }

			<?php if(isset( $date_of_finance_array ) && isset( $date_of_finance )) : ?> // add date of finance line

            window.addDateOfFinanceLine(
                '<?php echo $date_of_finance_array['year']; ?>',
                '<?php echo $date_of_finance_array['month']; ?>',
                '<?php echo $date_of_finance_array['day']; ?>',
                'Date of Finance'
            );

			<?php if(isset( $percentage_of_finance ) && $percentage_of_finance) : // add percentage of finance line ?>
            // the value data from the DB, which equates to 100%
            var hundred_percent_finance_value = polynomial_data_by_date[<?php echo $date_of_finance_slug; ?>],
                // Simple conversion of percentage to decimal
                percentage_of_finance = <?php echo $percentage_of_finance; ?> / 100;

            if (hundred_percent_finance_value) { // we have a value for the date of finance entered
                var finance_value = hundred_percent_finance_value * percentage_of_finance;
                finance_value = finance_value.toFixed(2);
                window.addPercentageOfFinanceBox(
                    finance_value,
                    '<?php echo $date_of_finance_array['year']; ?> <?php echo $date_of_finance_array['month']; ?> <?php echo $date_of_finance_array['day']; ?>',
                );
                window.addPercentageOfFinanceLine(
                    finance_value,
                    '<?php echo $percentage_of_finance; ?>% = ' + finance_value,
                );

                $('.depreciation-summary').html('<?php echo $percentage_of_finance; ?>% <?php echo isset( $date_of_finance_slug_pretty ) ? 'in ' . $date_of_finance_slug_pretty : ''; ?> = <strong>' + finance_value + '</strong> <em>based on trend data</em>').addClass('is-active');
            }
			<?php endif; ?>

			<?php endif; ?>


            // Keep track of which group of data we are working with so we can target the right data table cell with polynomial data
            var datasetIndex = 0;

            // Reverse data as table data is descending while graph data is ascending
            var reversedPolyData = polynomialData['points'].reverse();
            // Append the polynomial data to the relevant data table cell
            reversedPolyData.forEach(function (data, index) {
                $('td[data-depreciation-poly-data-target-id="' + datasetIndex + '"]').append('<br><span class="is-trend-data is-depreciation-trend-data">' + data[1].toFixed(2) + '</span>');
                datasetIndex++;
            });

        })(jQuery);
    </script>

<?php endif; ?>
