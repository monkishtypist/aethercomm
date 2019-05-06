<?php
/**
 * The global template for the page header backgrounds
 */

global $post;

if ( $post->post_parent ) {
    $template_slug = 'child';
} else {
    $template_slug = $post->post_name;
}

$section_header_background_image_id = false;

if ( get_acf_field( 'page_header_background' ) ) {
    $section_header_background_image_id = get_acf_field( 'page_header_background', true );
}

?>

<section id="<?php echo $post->post_name; ?>_header" class="section_header <?php echo $template_slug; ?>_header section-header-overlay_<?php echo get_acf_field( 'page_header_overlay' ); ?>">

    <?php if ( $section_header_background_image_id ) : ?>
        <div class="section-image-overlay-wrapper" <?php // echo $section_header_styles; ?>>
            <div class="section-image-overlay-wrapper-inner">
                <div class="overlay"></div>
                <?php echo wp_get_attachment_image( $section_header_background_image_id, 'full', false, array( 'class' => 'section-overlay-image img-fluid' ) ); ?>
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
