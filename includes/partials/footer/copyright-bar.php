<?php
/**
 * Footer copyright bar
 *
 * @package Salient WordPress Theme
 * @subpackage Partials
 * @version 13.0
 */
 
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$nectar_options = get_nectar_theme_options();

$disable_footer_copyright = ( ! empty( $nectar_options['disable-copyright-footer-area'] ) && $nectar_options['disable-copyright-footer-area'] === '1' ) ? 'true' : 'false';
$copyright_footer_layout  = ( ! empty( $nectar_options['footer-copyright-layout'] ) ) ? $nectar_options['footer-copyright-layout'] : 'default';
$footer_columns           = ( ! empty( $nectar_options['footer_columns'] ) ) ? $nectar_options['footer_columns'] : '4';


if ( 'false' === $disable_footer_copyright ) {
	?>

  <div class="row" id="copyright" data-layout="<?php echo esc_attr( $copyright_footer_layout ); ?>">
	
	<div class="container">

        <div class="copy-container">

            <div class="col span_6">
                <div class="copy-content">
                    <p>&copy; <?php echo date("Y");?> Virtual Internships. All right reserved.</p>
                </div>
            </div>

            <div class="col span_6">
                <div class="footer-bottom-links">
                    <ul>
                        <li><a href="<?php bloginfo('url');?>/policies/privacy">Privacy Policy</a></li>
                        <li><a href="<?php bloginfo('url');?>/policies">Terms of Service</a></li>
                        <li><a href="#" id="open-cookie-settings" class="cookie-settings-link">Cookie Settings</a></li>                    
                    </ul>
                </div>
            </div>
        
        </div>
	</div><!--/container-->
  </div><!--/row-->
	<?php }