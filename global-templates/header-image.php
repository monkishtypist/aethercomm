<?php
/**
 * The global template for the page header backgrounds
 */

global $post;

$section_header_background_image_url = '/wp-content/uploads/2019/04/who-we-are-hero.png'; // default

if ( get_acf_field( $post->post_name . '_page_settings_header_background' ) ) {
    $section_header_background_img_id = get_acf_field( $post->post_name . '_page_settings_header_background' );
    if ( is_array( $section_header_background_img_id ) && isset( $section_header_background_img_id[0] ) ) {
        $section_header_background_image_url = wp_get_attachment_url( $section_header_background_img_id[0] );
    }
}

$section_header_styles = sprintf( 'style="%1$s"',
    sprintf( 'background-image:url(%1$s);',
        $section_header_background_image_url
    )
);

?>

<?php if ( $section_header_background_image_url ) : ?>
    <div class="section-image-overlay-wrapper" <?php // echo $section_header_styles; ?>>
        <div class="section-image-overlay-wrapper-inner">
            <div class="overlay"></div>
            <img class="section-overlay-image" src="<?php echo $section_header_background_image_url; ?>" width="100%" />
        </div>
    </div>
<?php endif; ?>
