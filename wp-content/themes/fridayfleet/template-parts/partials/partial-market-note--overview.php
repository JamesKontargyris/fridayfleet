<?php $note_date = strtotime( get_field( 'market_note_date' ) ); ?>

<div class="note" data-year="<?php echo date( 'Y', $note_date ); ?>">
    <div class="note__meta">
		<?php foreach ( get_field( 'market_note_ship_types' ) as $ship_type ) : $ship_type_id = $ship_type->ID; ?>
            <a href="<?php echo get_the_permalink( $ship_type_id ); ?>" class="btn btn--pill btn--pill--small change-ship">
                <?php echo get_the_title( $ship_type_id ); ?>
            </a>
		<?php endforeach; ?>
    </div>
    <div class="note__timestamp has-note-indicator note-indicator--<?php the_field( 'market_note_indicator' ); ?>">
		<?php echo date( 'j F Y', $note_date ) ?> <br><?php the_title(); ?>
    </div>
    <div class="note__content">
		<?php the_field( 'market_note_text' ); ?>
    </div>
</div>