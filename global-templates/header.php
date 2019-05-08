<?php
/**
 * The global template for the page header backgrounds
 */

global $post;

$queried_object = get_queried_object();

$container = get_theme_mod( 'understrap_container_type' );

if ( $post->post_parent ) {
    $template_slug = 'child';
} else {
    $template_slug = $post->post_name;
}

// Header image overlay
if ( get_acf_field( 'page_header_background' ) ) {
    $section_header_image_id = get_acf_field( 'page_header_background', true );
    $section_header_image = wp_get_attachment_image( $section_header_image_id, 'full', false, array( 'class' => 'section-overlay-image img-fluid' ) );
} elseif ( has_post_thumbnail() ) {
    $section_header_image = get_the_post_thumbnail( get_the_ID(), 'full', array( 'class' => 'section-overlay-image img-fluid' ) );
} else {
    $section_header_image = false;
}
$overlay_color = ( get_acf_field( 'page_header_overlay' ) ? get_acf_field( 'page_header_overlay', true ) : 'black' );

$cats = get_the_category();
$cat_names_string = null;

if ( $cats ) :
    $cat_names_array = array();
    foreach ( $cats as $cat ) {
        $cat_names_array[] = esc_html( $cat->name );
    }
    $cat_names_string = implode( " | ", $cat_names_array );
endif;

// Page Title & Lede
$page_title = false;
$page_lede = false;

if ( is_single() ) :
    $page_title = sprintf( '<div class="page-title">%1$s</div>',
        $cat_names_string );
    $page_lede = sprintf( '<h1 class="page-lede">%1$s</h1>',
        get_the_title() );
elseif ( $post->post_parent ) :
    $page_title = sprintf( '<div class="page-title">%1$s</div>',
        get_the_title( $post->post_parent ) );
    $page_lede = sprintf( '<h1 class="page-lede">%1$s</h1>',
        get_the_title() );
elseif ( is_tax( 'product-categories' ) ) :
    $page_title = sprintf( '<div class="page-title">%1$s</div>',
        __( 'Our Products', 'aethercomm' ) );
    $page_lede = sprintf( '<h1 class="page-lede">%1$s</h1>',
        esc_html( $queried_object->name ) );
else :
    if ( get_acf_field( 'page_header_lede' ) ) {
        $page_title = sprintf( '<h1 class="page-title">%1$s</h1>',
            get_the_title() );
        $page_lede = sprintf( '<div class="page-lede">%1$s</div>',
            apply_filters( 'the_content', get_acf_field( 'page_header_lede', true ) ) );
    } else {
        $page_lede = sprintf( '<h1 class="page-lede">%1$s</h1>',
            get_the_title() );
    }
endif;

// Page header Copy
$page_header_copy = false;
if ( get_acf_field( 'page_header_copy' ) ) :
    $page_header_copy = apply_filters( 'the_content', get_acf_field( 'page_header_copy', true ) );
elseif ( is_tax() && ! empty( $queried_object->description ) ) :
    $page_header_copy = apply_filters( 'the_content', $queried_object->description );
endif;

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
            <?php echo $page_title; ?>
            <?php echo $page_lede; ?>
            <?php echo $page_header_copy; ?>
        </header>

        <span class="crosshairs-white crosshairs-sm-gray crosshairs-top-left"></span>
        <span class="crosshairs-gray crosshairs-top-right"></span>

    </div>

</section>
