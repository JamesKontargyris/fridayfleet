<?php

if($_GET['data-view']) {
	get_template_part( 'template-parts/partials/partial', 'data-view--' . $_GET['data-view'] );
} else {
	get_template_part( 'template-parts/partials/partial', 'data-view--fixed-age-value' );
}