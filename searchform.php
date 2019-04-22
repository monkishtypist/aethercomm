<?php
/**
 * The template for displaying search forms
 *
 * @package aethercomm
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
	<label class="sr-only" for="s"><?php esc_html_e( 'Search', 'aethercomm' ); ?></label>
	<div class="input-group">
		<input class="field form-control" id="s" name="s" type="text" placeholder="<?php esc_attr_e( 'Search &hellip;', 'aethercomm' ); ?>" value="<?php the_search_query(); ?>">
		<span class="input-group-append">
			<button type="submit" id="searchsubmit">
                <i class="fas fa-search"></i>
            </button>
		</span>
	</div>
</form>
