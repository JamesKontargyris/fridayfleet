<?php
$note_date = strtotime( get_field( 'market_note_date' ) );
$current_year = date('Y', strtotime('today'));
$last_year_of_data = isset($args) ? $args['last_year_of_data'] : 2999;
?>

<div class="note" data-year="<?php echo date( 'Y', $note_date ); ?>">
    <a href="#content-top"
       onclick="addAnnotationVertical('<?php echo date('Y', $note_date) ?>', '<?php echo date('m', $note_date) ?>', '<?php echo date('d', $note_date) ?>', '<?php echo date('j F Y', $note_date) ?>', ['graph__fixed-age-value-quarters', 'graph__fixed-age-value-years', 'graph__depreciation'], <?php echo $last_year_of_data; ?>)"
       class="btn--plot-on-graph scroll-to-link">Plot on graphs</a>
    <div class="note__timestamp has-note-indicator note-indicator--<?php the_field( 'market_note_indicator' ); ?>">
		<?php echo date( 'j F Y', $note_date ) ?> <br><?php the_title(); ?>
    </div>
    <div class="note__content">
		<?php the_field( 'market_note_text' ); ?>
    </div>
</div>