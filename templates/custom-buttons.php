<?php
/**
 * VI Button Shortcode
 * 
 * This file contains the button shortcode implementation for the VI theme
 */

// Make sure this file is not accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * VI Button Shortcode
 * 
 * This function creates a customizable button with various style options
 * and ensures proper display of background colors.
 */
// function vi_button_shortcode($atts) {
//     $atts = shortcode_atts(array(
//         'text' => 'Learn More',
//         'subtitle' => '',
//         'link' => '#',
//         'icon' => 'none',
//         'size' => 'medium',
//         'bg_color' => 'primary',
//         'custom_bg_color' => '#0D3875',
//         'text_color' => '#FFFFFF',
//         'hover_bg_color' => '',
//         'hover_text_color' => '',
//         'hover_border_color' => '',
//         'border_color' => '',
//         'border_width' => '0',
//         'border_radius' => '4',
//         'icon_position' => 'right',
//         'target' => '_self',
//         'margin_top' => '',
//         'margin_bottom' => '',
//         'margin_left' => '',
//         'margin_right' => '',
//         'button_id' => '',
//         'class' => ''
//     ), $atts);

//     // Define color presets
//     $color_presets = array(
//         'primary' => '#f89122',
//         'secondary' => '#00b1aa',
//         'accent' => '#0A272B',
//         'highlight' => '#f54265',
//         'white' => '#ffffff',
//         'black' => '#000000',
//         'gray' => '#676767'
//     );

//     // Get background color based on selection
//     if ($atts['bg_color'] === 'custom' && !empty($atts['custom_bg_color'])) {
//         $bg_color = $atts['custom_bg_color'];
//     } else {
//         $bg_color = isset($color_presets[$atts['bg_color']]) ? $color_presets[$atts['bg_color']] : '#f89122';
//     }
    
//     // Create unique ID for this button instance
//     $unique_id = uniqid('vi-btn-');
    
//     // Get icon SVG if selected
//     $icon_html = '';
//     if (!empty($atts['icon']) && $atts['icon'] !== 'none') {
//         $icon_path = get_stylesheet_directory() . '/assets/icons/' . $atts['icon'] . '.svg';
//         if (file_exists($icon_path)) {
//             $icon_html = '<span class="vi-button__icon">' . file_get_contents($icon_path) . '</span>';
//         }
//     }

//     // Build CSS classes for the button
//     $classes = array(
//         'vi-button',
//         'vi-button--' . esc_attr($atts['size']),
//         'vi-button-' . esc_attr($atts['bg_color']), // Add preset class for CSS fallback
//         $unique_id
//     );

//     // Add icon position class if icon is set
//     if ($atts['icon'] !== 'none') {
//         $classes[] = 'vi-button--icon-' . esc_attr($atts['icon_position']);
//     }

//     // Add custom classes if provided
//     if (!empty($atts['class'])) {
//         $custom_classes = explode(' ', $atts['class']);
//         foreach($custom_classes as $class) {
//             $classes[] = sanitize_html_class($class);
//         }
//     }

//     // Prepare inline styles for margins
//     $styles = array();
//     if (!empty($atts['margin_top'])) $styles[] = 'margin-top:' . intval($atts['margin_top']) . 'px';
//     if (!empty($atts['margin_bottom'])) $styles[] = 'margin-bottom:' . intval($atts['margin_bottom']) . 'px';
//     if (!empty($atts['margin_left'])) $styles[] = 'margin-left:' . intval($atts['margin_left']) . 'px';
//     if (!empty($atts['margin_right'])) $styles[] = 'margin-right:' . intval($atts['margin_right']) . 'px';

//     // Set hover colors
//     $hover_bg = !empty($atts['hover_bg_color']) ? $atts['hover_bg_color'] : $bg_color;
//     $hover_text = !empty($atts['hover_text_color']) ? $atts['hover_text_color'] : $atts['text_color'];
//     $hover_border = !empty($atts['hover_border_color']) ? $atts['hover_border_color'] : $atts['border_color'];

//     // Generate inline styles with !important to ensure they're applied
//     $button_styles = sprintf(
//         '<style>
//             .%1$s {
//                 background-color: %2$s !important;
//                 color: %3$s !important;
//                 border: %4$spx solid %5$s !important;
//                 border-radius: %6$spx !important;
//                 transition: all 0.3s ease !important;
//             }
//             .%1$s:hover,
//             .%1$s:focus {
//                 background-color: %7$s !important;
//                 color: %8$s !important;
//                 border-color: %9$s !important;
//                 opacity: 0.9 !important;
//             }
//             .%1$s .vi-button__icon svg {
//                 fill: %3$s !important;
//             }
//             .%1$s:hover .vi-button__icon svg,
//             .%1$s:focus .vi-button__icon svg {
//                 fill: %8$s !important;
//             }
//         </style>',
//         $unique_id,
//         esc_attr($bg_color),
//         esc_attr($atts['text_color']),
//         esc_attr($atts['border_width']),
//         !empty($atts['border_color']) ? esc_attr($atts['border_color']) : 'transparent',
//         esc_attr($atts['border_radius']),
//         esc_attr($hover_bg),
//         esc_attr($hover_text),
//         esc_attr($hover_border)
//     );
    
//     // Process button text
//     $button_text = do_shortcode($atts['text']);
//     $button_text = str_replace(array('``', '""'), '"', $button_text);
//     $button_text = html_entity_decode($button_text, ENT_QUOTES);
    
//     // Build button content with proper icon positioning
//     $button_content = $atts['icon'] !== 'none' && $atts['icon_position'] === 'left' 
//         ? $icon_html . '<span class="vi-button__text">' . $button_text . '</span>'
//         : '<span class="vi-button__text">' . $button_text . '</span>' . ($atts['icon'] !== 'none' ? $icon_html : '');
        
//     // Build final button HTML
//     $button = $button_styles . sprintf(
//         '<a %s href="%s" class="%s" target="%s" %s>%s</a>',
//         !empty($atts['button_id']) ? 'id="' . esc_attr($atts['button_id']) . '"' : '',
//         esc_url($atts['link']),
//         esc_attr(implode(' ', array_unique($classes))),
//         esc_attr($atts['target']),
//         !empty($styles) ? 'style="' . esc_attr(implode(';', $styles)) . '"' : '',
//         $button_content
//     );
    
//     return $button;
// }
// add_shortcode('vi_button', 'vi_button_shortcode');

/**
 * Add Visual Composer integration for the button shortcode
 */
// function vi_button_vc_map() {
//     if (function_exists('vc_map')) {
//         vc_map(array(
//             'name' => 'VI Custom Button',
//             'base' => 'vi_button',
//             'category' => 'Content',
//             'params' => array(
//                 array(
//                     'type' => 'textfield',
//                     'heading' => 'Text',
//                     'param_name' => 'text',
//                     'value' => 'Learn More',
//                     'description' => 'Add your button text'
//                 ),
//                 array(
//                     'type' => 'textfield',
//                     'heading' => 'Link',
//                     'param_name' => 'link',
//                     'value' => '#',
//                     'description' => 'Add URL for button'
//                 ),
//                 array(
//                     'type' => 'dropdown',
//                     'heading' => 'Background Color',
//                     'param_name' => 'bg_color',
//                     'value' => array(
//                         'Primary' => 'primary',
//                         'Secondary' => 'secondary',
//                         'Accent' => 'accent',
//                         'Highlight' => 'highlight',
//                         'White' => 'white',
//                         'Custom' => 'custom'
//                     ),
//                     'std' => 'primary'
//                 ),
//                 array(
//                     'type' => 'colorpicker',
//                     'heading' => 'Custom Background Color',
//                     'param_name' => 'custom_bg_color',
//                     'dependency' => array(
//                         'element' => 'bg_color',
//                         'value' => 'custom'
//                     )
//                 ),
//                 array(
//                     'type' => 'colorpicker',
//                     'heading' => 'Text Color',
//                     'param_name' => 'text_color',
//                     'value' => '#FFFFFF'
//                 ),
//                 array(
//                     'type' => 'dropdown',
//                     'heading' => 'Size',
//                     'param_name' => 'size',
//                     'value' => array(
//                         'Small' => 'small',
//                         'Medium' => 'medium',
//                         'Large' => 'large'
//                     ),
//                     'std' => 'medium'
//                 ),
//                 array(
//                     'type' => 'dropdown',
//                     'heading' => 'Icon',
//                     'param_name' => 'icon',
//                     'value' => array(
//                         'None' => 'none',
//                         'Companies' => 'Companies',
//                         'Educators' => 'Educators',
//                         'Interns' => 'Interns'
//                     ),
//                     'std' => 'none'
//                 ),
//                 array(
//                     'type' => 'dropdown',
//                     'heading' => 'Icon Position',
//                     'param_name' => 'icon_position',
//                     'value' => array(
//                         'Left' => 'left',
//                         'Right' => 'right'
//                     ),
//                     'std' => 'right',
//                     'dependency' => array(
//                         'element' => 'icon',
//                         'value_not_equal_to' => 'none'
//                     )
//                 ),
//                 array(
//                     'type' => 'textfield',
//                     'heading' => 'Border Radius',
//                     'param_name' => 'border_radius',
//                     'value' => '4'
//                 ),
//                 array(
//                     'type' => 'textfield',
//                     'heading' => 'Extra Class',
//                     'param_name' => 'class',
//                     'description' => 'Add additional CSS classes'
//                 )
//             )
//         ));
//     }
// }
// add_action('vc_before_init', 'vi_button_vc_map');