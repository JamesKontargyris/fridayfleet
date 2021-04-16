<?php

use FridayFleet\FridayFleetController;

$ff                 = new FridayFleetController;
$ship_type_db_slugs = get_ship_type_database_slugs(); // get all ship type database slugs for comparison to the one passed in, if any
// $args is passed in by WordPress' get_template_part function in WP5.5+
$form_data = isset( $args ) ? $args['form_data'] : [];

if ( ! $form_data['build_date'] || ! validateDate( $form_data['build_date'], 'd/m/Y' ) ) : // build date not present or valid
	?>
    <div class="message message--error">ERROR: please enter a valid build date in the format dd/mm/yyyy.</div>
	<?php exit();
endif;

$ship_db_slug = $form_data['ship'] ?: '0';
if ( ! in_array( $ship_db_slug, $ship_type_db_slugs ) ) : // ship type not found
	?>
    <div class="message message--error">ERROR: invalid ship type.</div>
	<?php exit();
endif;

if ( ! $ship_type_data = get_ship_type_by_database_slug( $ship_db_slug ) ) : ?>
    <div class="message message--error">ERROR: ship not found.</div>
	<?php exit();
endif;

$depreciation_data = [];
$graph_is_visible  = 0; // if this turns to one, market notes can be plotted on the graph, otherwise hide the plot on graph link
// Use str_replace to make sure date functions know the format is dd-mm-yyyy rather than mm-dd-yyyy, as we are passing in xx/xx/xxxx, which PHP assumes to be the American structure of mm/dd/yyyy
$build_date            = str_replace( '/', '-', $form_data['build_date'] );
$date_of_finance       = str_replace( '/', '-', $form_data['date_of_finance'] );
$date_of_finance_array = [
	'year'  => date( 'Y', strtotime( $date_of_finance ) ),
	'month' => date( 'm', strtotime( $date_of_finance ) ),
	'day'   => date( 'd', strtotime( $date_of_finance ) ),
];

$depreciation_data = $ff->getDepreciationData( date( 'Y-m-d', strtotime( $build_date ) ), $ship_db_slug );

if ( $depreciation_data ) { // we got a result
	$graph_is_visible = 1;
}
$ship_type_id  = $ship_type_data->ID;
$graph_colours = $ff->getColours();

if ( ! $depreciation_data && $build_date ) : // there's a build date, but there's no data for it
	?>
    <div class="message message--error">
        ERROR: no data found. Please enter another build date.
        <div class="message__close"></div>
    </div>
<?php endif;

if ( $depreciation_data ) : ?>

    <div class="graph-update-button-group">
        <button onclick="resetZoom()" class="btn btn--graph-update btn--reset-zoom--vessel-finance-calculator">Reset Zoom
        </button>
        <button onclick="clearAnnotations()"
                class="btn btn--graph-update btn--clear-annotations--vessel-finance-calculator">
            Remove Line(s)
        </button>
    </div>

    <div id="graphs" class="graphs-container">

        <div class="graph-group is-active">
            <div class="graph-group__canvas-container">
                <canvas class="graph graph__depreciation" id="graph__depreciation"></canvas>
            </div>
        </div>

    </div>

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
			$latest_set_of_data_year = substr( key( $table_data ), 0, 4 ); // gets the year from the latest set of data. Used to display the latest year's set of data on page load (format of keys is YYYYQQ, where QQ is first month of quarter)

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
                    <td><?php echo number_format( $depreciation_value, 2 ); ?></td>
                </tr>
			<?php endforeach; ?>
            </tbody>

        </table>
    </div>


<?php endif; ?>

<?php if ( isset( $build_date ) && isset( $depreciation_data ) && $depreciation_data ) : ?>
    <script>
        (function ($) {
            var ctxDepreciation = document.getElementById('graph__depreciation');

            var chartDepreciation = new Chart(ctxDepreciation, {
                type: 'line',
                data: {
                    datasets: [
                        {
                            data: [
								<?php foreach($depreciation_data as $x => $y) : ?>
                                {x: moment('<?php echo $x; ?>', "YYYYMM"), y: <?php echo number_format( $y, 2 ); ?>},
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

            window.resetZoom = function () {
                chartDepreciation.resetZoom();
                document.getElementsByClassName('btn--reset-zoom--vessel-finance-calculator')[0].classList.remove('is-active');
            };

            window.clearAnnotations = function () {
                // keep first element of array as this is the finance line
                for ($i = 1; $i <= chartDepreciation.options.annotation.annotations.length; $i++) {
                    delete chartDepreciation.options.annotation.annotations[$i];
                }
                chartDepreciation.update();
                document.getElementsByClassName('btn--clear-annotations--vessel-finance-calculator')[0].classList.remove('is-active');
            };

            window.addAnnotationVertical = function (year, month, day, text, showRemoveButton = 1, isFinanceLine = 0) {
                var line = year + ' ' + month + ' ' + day,
                    graphValue = year + ' ' + month + ' ' + day,
                    borderColor = isFinanceLine ? 'rgba(54,157,223)' : 'white',
                    borderWidth = isFinanceLine ? 2 : 1,
                    backgroundColor = isFinanceLine ? 'rgba(54,157,223,0.4)' : 'rgba(0,0,0,0.4)';


                var newAnnotation = {
                    drawTime: "afterDatasetsDraw",
                    id: line,
                    type: "line",
                    mode: "vertical",
                    scaleID: "x-axis-0",
                    value: graphValue,
                    borderColor: borderColor,
                    borderWidth: borderWidth,
                    borderDash: [2, 2],
                    borderDashOffset: 5,
                    label:
                        {
                            enabled: true,
                            backgroundColor: backgroundColor,
                            cornerRadius: 3,
                            position: "end",
                            fontColor: "rgba(255,255,255,1)",
                            fontFamily: "Lato",
                            fontSize: 11,
                            content: text,
                            rotation: 90,
                            xAdjust: -12,
                            yAdjust: 140,
                        }
                };
                chartDepreciation.options.annotation.annotations.push(newAnnotation);
                chartDepreciation.update();

                if (showRemoveButton) {
                    document.getElementsByClassName('btn--clear-annotations--vessel-finance-calculator')[0].className += ' is-active';
                }
            }

			<?php if(isset( $date_of_finance_array )) : ?>
            window.addAnnotationVertical('<?php echo $date_of_finance_array['year']; ?>', '<?php echo $date_of_finance_array['month']; ?>', '<?php echo $date_of_finance_array['day']; ?>', 'Date of Finance - <?php echo date( 'd/m/y', strtotime( $date_of_finance ) ); ?>', 0, 1);
			<?php endif; ?>
        })(jQuery);
    </script>

<?php endif; ?>
