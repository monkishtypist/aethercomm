<?php
/**
 * Pagination layout.
 *
 * @package aethercomm
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'understrap_pagination' ) ) {

	function understrap_pagination( $args = array(), $class = 'pagination' ) {

		if ( $GLOBALS['wp_query']->max_num_pages <= 1 ) {
			return;
		}

		$args = wp_parse_args(
			$args,
			array(
				'mid_size'           => 4,
				'prev_next'          => true,
				'prev_text'          => '<i class="fal fa-chevron-left"></i>',
				'next_text'          => '<i class="fal fa-chevron-right"></i>',
                'screen_reader_text' => __( 'Posts navigation', 'aethercomm' ),
                // 'show_all'           => true,
				'type'               => 'array',
				'current'            => max( 1, get_query_var( 'paged' ) ),
			)
		);

		$links = paginate_links( $args );

		?>

		<nav aria-label="<?php echo $args['screen_reader_text']; ?>">

			<ul class="pagination">

            <pre><?php print_r( $links ); ?></pre>

				<?php foreach ( $links as $key => $link ) { ?>
					<li class="page-item <?php echo strpos( $link, 'current' ) ? 'active' : ''; ?>">
						<?php echo str_replace( 'page-numbers', 'page-link', $link ); ?>
					</li>
                <?php } ?>

			</ul>

		</nav>

		<?php
	}
}

?>
