<?php
$note_date = strtotime( get_field( 'market_note_date' ) );
$current_year = date('Y', strtotime('today'));
?>

<div class="note" data-year="<?php echo date( 'Y', $note_date ); ?>">
    <div class="note__timestamp has-note-indicator note-indicator--<?php the_field( 'market_note_indicator' ); ?>">
		<?php echo date( 'j F Y', $note_date ) ?> <br><?php the_title(); ?>
    </div>
</div>