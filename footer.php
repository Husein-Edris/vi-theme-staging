<?php
/**
* The template for displaying the footer.
*
* @package Salient WordPress Theme
* @version 12.2
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$nectar_options = get_nectar_theme_options();
$header_format  = ( !empty($nectar_options['header_format']) ) ? $nectar_options['header_format'] : 'default';

nectar_hook_before_footer_open();

?>

<div id="footer-outer" <?php nectar_footer_attributes(); ?>>
	
	<?php
	
	nectar_hook_after_footer_open();
	
	get_template_part( 'includes/partials/footer/call-to-action' );
	
	get_template_part( 'includes/partials/footer/main-widgets' );
	
	get_template_part( 'includes/partials/footer/copyright-bar' );
	
	?>
	
</div><!--/footer-outer-->

<?php

nectar_hook_before_outer_wrap_close();

get_template_part( 'includes/partials/footer/off-canvas-navigation' );

?>

</div> <!--/ajax-content-wrap-->

<?php
	
	// Boxed theme option closing div.
	if ( ! empty( $nectar_options['boxed_layout'] ) && 
	'1' === $nectar_options['boxed_layout'] && 
	'left-header' !== $header_format ) {

		echo '</div><!--/boxed closing div-->'; 
	}
	
	get_template_part( 'includes/partials/footer/back-to-top' );
	
	nectar_hook_after_wp_footer();
	nectar_hook_before_body_close();
	
	wp_footer();
?>

<script type="text/javascript">
	jQuery(function () {
		jQuery(".blog-recent-articles .vc_column-inner").click(function () {
			var href = jQuery(this).find('.read-more').attr('href');
			window.location.replace( href );
		});

		jQuery('.vi-toggle-btn').click(function(){
			jQuery(this).hide();
			jQuery('.vi-toggle-row').show();
		});

		// Duplicate menu remove code Mobile View
		var liText = '', liList = jQuery('.off-canvas-menu-container .menu li'), listForRemove = [];
		jQuery(liList).each(function () {
		var text = jQuery(this).text();
		if (liText.indexOf('|'+ text + '|') == -1)
			liText += '|'+ text + '|';
		else
			listForRemove.push(jQuery(this));
		});
		jQuery(listForRemove).each(function () { jQuery(this).remove(); });

		// UTM tracking
		jQuery(function(){
			var urlParams = new URLSearchParams(window.location.search);
			var utm = urlParams.toString();

			if( utm != ''){
				jQuery( "a" ).each(function( index ) {
					//console.log( jQuery(this).attr('href') );
					var cHref = jQuery(this).attr("href");
					jQuery(this).attr("href", cHref + '/?' + utm );
				});
			}

			// if( utm != ''){ 
			// 	jQuery(".nectar-button").attr("href", cHref + '/?' + utm );
			// }
		});
		// console.log("ok 1");
		<?php if( is_page(11) ){?>
			console.log("ok 2");
			// Get the full query string from the URL (e.g., "?openForm=true")
			var queryString = window.location.search;

			console.log( queryString.indexOf('openForm=true') );

			// Check if the query string contains "openForm=true"
			if (queryString.indexOf('openForm=true') !== -1) {
				// Trigger the button with the class ".pum-trigger"
				console.log("ok 3");
				jQuery('.pum-trigger').trigger('click');
			}
		<?php } ?>

	});
</script>

</body>
</html>