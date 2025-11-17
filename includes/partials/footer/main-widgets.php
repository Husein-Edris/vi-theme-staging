<?php
/**
* Footer widget area
*
* @package Salient WordPress Theme
* @subpackage Partials
* @version 10.5
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$nectar_options = get_nectar_theme_options();

$using_footer_widget_area = ( ! empty( $nectar_options['enable-main-footer-area'] ) && $nectar_options['enable-main-footer-area'] === '1' ) ? 'true' : 'false';
$footer_columns           = ( ! empty( $nectar_options['footer_columns'] ) ) ? $nectar_options['footer_columns'] : '4';
$footer_has_widgets       = ( is_active_sidebar( 'Footer Area 1' ) || is_active_sidebar( 'Footer Area 2' ) || is_active_sidebar( 'Footer Area 3' ) || is_active_sidebar( 'Footer Area 4' ) ) ? 'true' : 'false';

if ( $using_footer_widget_area === 'true' ) { ?>
	
	<div id="footer-widgets" data-has-widgets="<?php echo esc_attr( $footer_has_widgets ); ?>" data-cols="<?php echo esc_attr( $footer_columns ); ?>">
		
		<div class="container">
			
			<?php nectar_hook_before_footer_widget_area(); ?>
			
			<div class="row">
                <div class="col span_5">
                    <div class="footer-logo">
                        <a href="#">
                            <img src="<?php bloginfo('url');?>/wp-content/uploads/2023/04/footer-logo.png" alt="Vi" />
                        </a>
                    </div>

                    <?php // if( ! is_cf_page() && ! is_common_page() ){?>
                    <!-- <div class="footer-subscription">
                        <p>Join our newsletter to stay up to date on work experience, employability, and the world of Virtual Internships.</p>
                        
                        <div class="vi-hubspot-form">
                            <script charset="utf-8" type="text/javascript" src="//js-eu1.hsforms.net/forms/embed/v2.js"></script>
                            <script>
                            hbspt.forms.create({
                                region: "eu1",
                                portalId: "26293027",
                                formId: "23656219-c990-4d92-8a17-958e4da481c7"
                            });
                            </script>
                        </div>
                        
                        <p><small>By subscribing you agree with our <a href="<?php bloginfo('url');?>/privacy-policy/">Privacy Policy</a> and provide consent to receive updates from our company.</small></p>

                    </div> -->
                    <div class="footer-featured-logos">
                        <p class="featured-title">As featured on:</p>
                        <div class="logo-grid">
                            <div class="logo-item">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/footer-partner-logos/BBC%20Logo.png" alt="BBC" />
                            </div>
                            <div class="logo-item">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/footer-partner-logos/Business%20Leader%20Logo.png" alt="Business Leader" />
                            </div>
                            <div class="logo-item">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/footer-partner-logos/EdTechX%20Logo.png" alt="EdTechX" />
                            </div>
                            <div class="logo-item">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/footer-partner-logos/Forbes%20Logo.png" alt="Forbes" />
                            </div>
                            <div class="logo-item">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/footer-partner-logos/Inside%20Higher%20Ed%20Logo.png" alt="Inside Higher Ed" />
                            </div>
                            <div class="logo-item">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/footer-partner-logos/TechCrunch%20Logo.png" alt="TechCrunch" />
                            </div>
                            <div class="logo-item">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/footer-partner-logos/The%20PIE%20Logo.png" alt="The PIE" />
                            </div>
                            <div class="logo-item">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/footer-partner-logos/The%20Times%20Logo.png" alt="The Times" />
                            </div>
                            <div class="logo-item">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/footer-partner-logos/Times%20Higher%20Education%20Logo.png" alt="Times Higher Education" />
                            </div>
                        </div>
                    </div>
                    <?php // }?>
                </div>
                <div class="col span_7">
                    <div class="menu-area">
                        <div class="row">
                            <div class="col span_4 mobile-6">
                                <div class="footer-menu">
                                    <ul>
                                        <li><a href="<?php bloginfo('url');?>/companies/">Companies</a></li>
                                        <li><a href="<?php bloginfo('url');?>/universities/">Educators</a></li>
                                        <li><a href="<?php bloginfo('url');?>/interns">Interns</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col span_4 mobile-6">
                                <div class="footer-menu">
                                    <ul>
                                        <li><a href="<?php bloginfo('url');?>/our-mission/">Our Mission</a></li>
                                        <li><a href="<?php bloginfo('url');?>/our-team/">Our Team</a></li>
                                        <li><a href="<?php bloginfo('url');?>/join-us/">Join Us</a></li>
                                        <li><a href="<?php bloginfo('url');?>/press/">Press</a></li>
                                        <li><a href="https://blog.virtualinternships.com/" target="_blank" rel="noopener">Blog</a></li>
                                        <li><a href="<?php bloginfo('url');?>/contact-us/">Contact Us</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col span_4">
                                <div class="footer-menu social-share">
                                    <h3>Follow Us</h3>
                                    <ul>
                                        <li class="f-icon fb"><a target="_blank" rel="noopener" href="https://www.facebook.com/virtualintern/">Facebook</a></li>
                                        <li class="f-icon ins"><a target="_blank" rel="noopener" href="https://www.instagram.com/virtualinternships/">Instagram</a></li>
                                        <li class="f-icon tw"><a target="_blank" rel="noopener" href="https://twitter.com/onlineinterns">Twitter</a></li>
                                        <li class="f-icon li"><a target="_blank" rel="noopener" href="https://www.linkedin.com/company/virtual-internships">LinkedIn</a></li>
                                        <li class="f-icon tk"><a target="_blank" rel="noopener" href="https://www.tiktok.com/@virtual_internships">TikTok</a></li>
                                        <li class="f-icon yt"><a target="_blank" rel="noopener" href="https://www.youtube.com/VirtualInternships">YouTube</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			
            <?php nectar_hook_after_footer_widget_area(); ?>
		</div><!--/container-->
	</div><!--/footer-widgets-->
					
<?php
} //endif for enable main footer area