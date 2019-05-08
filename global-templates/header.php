<?php
/**
 * The global template for the page header backgrounds
 */

global $post;

$container = get_theme_mod( 'understrap_container_type' );

if ( $post->post_parent ) {
    $template_slug = 'child';
} else {
    $template_slug = $post->post_name;
}

if ( get_acf_field( 'page_header_background' ) ) {
    $section_header_image_id = get_acf_field( 'page_header_background', true );
    $section_header_image = wp_get_attachment_image( $section_header_image_id, 'full', false, array( 'class' => 'section-overlay-image img-fluid' ) );
} elseif ( has_post_thumbnail() ) {
    $section_header_image = get_the_post_thumbnail( get_the_ID(), 'full', array( 'class' => 'section-overlay-image img-fluid' ) );
} else {
    $section_header_image = false;
}

$overlay_color = ( get_acf_field( 'page_header_overlay' ) ? get_acf_field( 'page_header_overlay', true ) : 'black' );

?>

<section id="<?php echo $post->post_name; ?>_header" class="section_header <?php echo $template_slug; ?>_header section-header-overlay section-header-overlay_<?php echo $overlay_color; ?>">

    <?php if ( $section_header_image ) : ?>
        <div class="section-image-overlay-wrapper" <?php // echo $section_header_styles; ?>>
            <div class="section-image-overlay-wrapper-inner">
                <div class="overlay"></div>
                <?php echo $section_header_image; ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="<?php echo esc_attr( $container ); ?>">

        <header>
            <?php if ( $post->post_parent ) : ?>
                <div class="page-title"><?php echo get_the_title( $post->post_parent ); ?></div>
                <?php the_title( '<h1 class="page-lede">', '</h1>' ); ?>
            <?php else : ?>
                <?php the_title( '<h1 class="page-title">', '</h1>' ); ?>
                <?php if ( get_acf_field( 'page_header_lede' ) ) { ?>
                    <div class="page-lede"><?php echo apply_filters( 'the_content', get_acf_field( 'page_header_lede', true ) ); ?></div>
                <?php } ?>
                <?php if ( get_acf_field( 'page_header_copy' ) ) { ?>
                    <?php echo apply_filters( 'the_content', get_acf_field( 'page_header_copy', true ) ); ?>
                <?php } ?>
            <?php endif; ?>
        </header>

        <span class="crosshairs-white crosshairs-sm-gray crosshairs-top-left"></span>
        <span class="crosshairs-gray crosshairs-top-right"></span>

    </div>

</section>
