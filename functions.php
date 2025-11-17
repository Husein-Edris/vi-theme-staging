<?php

add_action('wp_enqueue_scripts', 'salient_child_enqueue_styles', 100);

// Remove the skip to main content link from parent theme 
add_action('init', function() {
    remove_action('nectar_hook_after_body_open', 'nectar_skip_to_content_link');
}, 11);

function salient_child_enqueue_styles()
{


    $nectar_theme_version = nectar_get_theme_version();

    wp_enqueue_style('salient-child-cookies', 'https://cdn.jsdelivr.net/gh/orestbida/cookieconsent@v2.9.1/dist/cookieconsent.css', '', $nectar_theme_version);

    wp_enqueue_style('salient-child-responsive', get_stylesheet_directory_uri() . '/css/responsive.css', '', $nectar_theme_version);

    wp_enqueue_style('salient-child-flag', 'https://cdn.jsdelivr.net/gh/lipis/flag-icons@6.6.6/css/flag-icons.min.css', '', $nectar_theme_version);

    wp_enqueue_script('salient-child-cookies-js', 'https://cdn.jsdelivr.net/gh/orestbida/cookieconsent@v2.9.1/dist/cookieconsent.js', array(), $nectar_theme_version);

    wp_enqueue_script('salient-child-cookies-theme-js', get_stylesheet_directory_uri() . '/js/cookies.js', array('salient-child-cookies-js'), '15.0.9');

    wp_enqueue_style('vi-button-styles', get_stylesheet_directory_uri() . '/css/vi-button.css');

    wp_enqueue_style('salient-child-style', get_stylesheet_directory_uri() . '/style.css', '', $nectar_theme_version);

    wp_enqueue_style('salient-child-cookies-custom', get_stylesheet_directory_uri() . '/css/cookie-consent-custom.css', array('salient-child-cookies'), $nectar_theme_version);


    // Enqueue mobile menu fix JavaScript
    // wp_enqueue_script('vi-mobile-menu-fix', get_stylesheet_directory_uri() . '/js/mobile-menu-fix.js', array('jquery'), $nectar_theme_version, true);

    // Enqueue skip link focus JavaScript for accessibility 
    wp_enqueue_script('vi-skip-link-focus', get_stylesheet_directory_uri() . '/js/skip-link-focus.js', array(), $nectar_theme_version, true);

    if (is_rtl()) {
        wp_enqueue_style('salient-rtl',  get_template_directory_uri() . '/rtl.css', array(), '1', 'screen');
    }
}




function mind_defer_scripts($tag, $handle, $src)
{
    $defer = array(
        'salient-child-cookies-js',
        'salient-child-cookies-theme-js'
    );

    if (in_array($handle, $defer)) {
        return '<script src="' . $src . '" defer="defer" type="text/javascript"></script>' . "\n";
    }

    return $tag;
}

add_filter('script_loader_tag', 'mind_defer_scripts', 10, 3);

// Add JSON-LD structured data for social media links
function vi_add_social_media_structured_data()
{
    $social_links = array(
        'https://www.facebook.com/virtualintern/',
        'https://www.instagram.com/virtualinternships/',
        'https://twitter.com/onlineinterns',
        'https://www.linkedin.com/company/virtual-internships',
        'https://www.tiktok.com/@virtual_internships',
        'https://www.youtube.com/VirtualInternships'
    );

    $structured_data = array(
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => 'Virtual Internships',
        'url' => home_url(),
        'sameAs' => $social_links
    );

    echo '<script type="application/ld+json">' . wp_json_encode($structured_data, JSON_UNESCAPED_SLASHES) . '</script>' . "\n";
}
add_action('wp_head', 'vi_add_social_media_structured_data');


add_action('after_setup_theme', 'salient_child_register_nav_menu', 0);
function salient_child_register_nav_menu()
{
    register_nav_menus(array(
        'primary_menu' => __('Primary Navigation Menu', 'salient'),
        'mobile_footer' => __('Mobile Footer Links', 'salient'),
    ));
}

// Simplified menu function - now just returns the primary menu location
function get_current_page_menu()
{
    return "primary_menu";
}

// Override the parent theme's menu location to use our unified menu
add_filter('pre_wp_nav_menu', 'vi_unified_menu_override', 10, 2);
function vi_unified_menu_override($output, $args)
{
    // Check if this is the main navigation menu
    if (isset($args->theme_location) && $args->theme_location === 'top_nav') {
        // Replace with our unified menu location
        $args->theme_location = 'primary_menu';
    }
    return $output;
}

function is_cf_page()
{
    $cf_page_id = 21;
    $cid = get_the_ID();
    $pid = wp_get_post_parent_id($cid);
    if ($cf_page_id == $pid) {
        return true;
    }
    return false;
}

function is_common_page()
{
    $common_page = array(740, 744, 234, 341, 618, 771, 1612, 881, 883, 877, 879, 871, 885, 887, 875, 889);
    $cid = get_the_ID();

    if (in_array($cid, $common_page)) {
        return true;
    }
    return false;
}

add_filter('gform_progressbar_start_at_zero', '__return_true');
// add_filter( 'gform_rfc_url_validation', '__return_false', 10, 1 );


// GF MEDIA UPLOADS

add_action('gform_after_submission', 'iss_gf_after_submission', 10, 2);
function iss_gf_after_submission($entry, $form)
{
    // Walk through form fields, find file upload fields
    foreach ($form['fields'] as $field) {
        if ($field->type == 'fileupload') {
            // See if file was submitted with entry
            if (isset($entry[$field->id])) {
                $fileurl = $entry[$field->id];
                // ID of post this attachment is for. 0 for unattached
                $parent_post_id = 0;
                // Check type of file, for use as 'post_mime_type'
                $filetype = wp_check_filetype(basename($fileurl), null);
                // Path to upload directory
                $wp_upload_dir = wp_upload_dir();
                // Gravity Forms uses its own upload folder, get that location
                $parts = explode('uploads/', $entry[$field->id]);
                $filepath = $wp_upload_dir['basedir'] . '/' . $parts[1];
                $fileurl = $wp_upload_dir['baseurl'] . '/' . $parts[1];
                // Array of post data for attachment
                $attachment = array(
                    'guid' => $fileurl,
                    'post_mime_type' => $filetype['type'],
                    'post_title' => preg_replace('/\.[^.]+$/', '', basename($fileurl)),
                    'post_content' => '',
                    'post_status' => 'inherit'
                );
                // Insert attachment
                $attach_id = wp_insert_attachment($attachment, $filepath, $parent_post_id);
                // Image manipulations are an admin side function. Gravity Forms is a frontend function, include image manipulations here.
                require_once(ABSPATH . 'wp-admin/includes/image.php');
                // Generate metadata for attachment, update database
                if ($attach_data = wp_generate_attachment_metadata($attach_id, $filepath)) {
                    wp_update_attachment_metadata($attach_id, $attach_data);
                } else {
                    echo '<div id="message" class="error"><h1>Failed to create Meta-Data</h1></div>';
                }
                wp_update_attachment_metadata($attach_id, $attach_data);
            }
        }
    }
}

/**
 * Gravity Wiz // Gravity Forms // Limit How Many Checkboxes Can Be Checked
 * https://gravitywiz.com/limiting-how-many-checkboxes-can-be-checked/
 *
 * Limit how many checkboxes can be checked (and how many checkboxes *must* be checked) on a checkbox field.
 * ADDED BY LAM TRAN ON 18/7/2023 3:20PM GMT +7:00
 */

class GFLimitCheckboxes
{

    private $form_id;
    private $field_limits;
    private $output_script;

    function __construct($form_id, $field_limits)
    {

        $this->form_id      = $form_id;
        $this->field_limits = $this->set_field_limits($field_limits);

        add_filter("gform_pre_render_$form_id", array(&$this, 'pre_render'));
        add_filter("gform_validation_$form_id", array(&$this, 'validate'));
    }

    function pre_render($form)
    {

        $script        = '';
        $output_script = false;

        foreach ($form['fields'] as $field) {

            $field_id     = $field['id'];
            $field_limits = $this->get_field_limits($field['id']);

            if (
                ! $field_limits                                          //    if field limits not provided for this field
                || RGFormsModel::get_input_type($field) !== 'checkbox'  // or if this field is not a checkbox
                || ! isset($field_limits['max'])                        // or if 'max' is not set for this field
            ) {
                continue;
            }

            $output_script = true;
            $max           = $field_limits['max'];
            $selectors     = array();

            foreach ($field_limits['field'] as $checkbox_field) {
                $selectors[] = "#field_{$form['id']}_{$checkbox_field} .gfield_checkbox input:checkbox";
            }

            $script .= "jQuery( '" . implode(', ', $selectors) . "' ).checkboxLimit({$max});";
        }

        GFFormDisplay::add_init_script($form['id'], 'limit_checkboxes', GFFormDisplay::ON_PAGE_RENDER, $script);

        if ($output_script) :
?>

<script type="text/javascript">
jQuery(document).ready(function($) {
    $.fn.checkboxLimit = function(n) {

        var checkboxes = this;

        this.toggleDisable = function() {

            // if we have reached or exceeded the limit, disable all other checkboxes
            if (this.filter(':checked').length >= n) {
                var unchecked = this.not(':checked');
                unchecked.prop('disabled', true);
            }
            // if we are below the limit, make sure all checkboxes are available
            else {
                this.prop('disabled', false);
            }

        }

        // when form is rendered, toggle disable
        checkboxes.bind('gform_post_render', checkboxes.toggleDisable());

        // when checkbox is clicked, toggle disable
        checkboxes.click(function(event) {

            checkboxes.toggleDisable();

            // if we are equal to or below the limit, the field should be checked
            return checkboxes.filter(':checked').length <= n;
        });

    }
});
</script>

<?php
        endif;

        return $form;
    }

    function validate($validation_result)
    {

        $form            = $validation_result['form'];
        $checkbox_counts = array();

        // loop through and get counts on all checkbox fields (just to keep things simple)
        foreach ($form['fields'] as $field) {

            if (RGFormsModel::get_input_type($field) !== 'checkbox') {
                continue;
            }

            $field_id = $field['id'];
            $count    = 0;

            foreach ($_POST as $key => $value) {
                if (strpos($key, "input_{$field['id']}_") !== false) {
                    $count++;
                }
            }

            $checkbox_counts[$field_id] = $count;
        }

        // loop through again and actually validate
        foreach ($form['fields'] as &$field) {

            if (! $this->should_field_be_validated($form, $field)) {
                continue;
            }

            $field_id     = $field['id'];
            $field_limits = $this->get_field_limits($field_id);

            $min = isset($field_limits['min']) ? $field_limits['min'] : false;
            $max = isset($field_limits['max']) ? $field_limits['max'] : false;

            $count = 0;
            foreach ($field_limits['field'] as $checkbox_field) {
                $count += rgar($checkbox_counts, $checkbox_field);
            }

            if ($count < $min) {
                $field['failed_validation'] = true;
                // translators: placeholder is minimum number of checkboxes that must be checked
                $field['validation_message']   = sprintf(_n('You must select at least %s item.', 'You must select at least %s items.', $min), $min);
                $validation_result['is_valid'] = false;
            } elseif ($count > $max) {
                $field['failed_validation'] = true;
                // translators: placeholder is maximum number of checkboxes that can be checked
                $field['validation_message']   = sprintf(_n('You may only select %s item.', 'You may only select %s items.', $max), $max);
                $validation_result['is_valid'] = false;
            }
        }

        $validation_result['form'] = $form;

        return $validation_result;
    }

    function should_field_be_validated($form, $field)
    {

        if ($field['pageNumber'] != GFFormDisplay::get_source_page($form['id'])) {
            return false;
        }

        // if no limits provided for this field
        if (! $this->get_field_limits($field['id'])) {
            return false;
        }

        // or if this field is not a checkbox
        if (RGFormsModel::get_input_type($field) != 'checkbox') {
            return false;
        }

        // or if this field is hidden
        if (RGFormsModel::is_field_hidden($form, $field, array())) {
            return false;
        }

        return true;
    }

    function get_field_limits($field_id)
    {

        foreach ($this->field_limits as $key => $options) {
            if (in_array($field_id, $options['field'], true)) {
                return $options;
            }
        }

        return false;
    }

    function set_field_limits($field_limits)
    {

        foreach ($field_limits as $key => &$options) {

            if (isset($options['field'])) {
                $ids = is_array($options['field']) ? $options['field'] : array($options['field']);
            } else {
                $ids = array($key);
            }

            $options['field'] = $ids;
        }

        return $field_limits;
    }
}
/*
 * TEMPLATE
 * new GFLimitCheckboxes(FORM_ID, array(
	FIELD_ID => array(
		'min' => MIN_NUMBER,
		'max' => MAX_NUMBER,
	),
	));
 */
new GFLimitCheckboxes(2, array(
    13 => array(
        'max' => 5,
    ),
));
/*
 * END OF LAM TRAN EDIT ON 18/7/2023 3:20PM GMT +7:00
 */


// function vi_location_finder($classes) {
//     $geoplugin = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$_SERVER['REMOTE_ADDR']));
//     if(isset( $geoplugin['geoplugin_continentName'] )){
//         $classes[] = str_replace(' ', '_', $geoplugin['geoplugin_continentName']); ;
//     }
//     return $classes;
// }

// add_filter('body_class', 'vi_location_finder');


// Register Testimonials Post Type
function register_testimonials_post_type()
{
    $labels = array(
        'name'               => _x('Testimonials', 'post type general name', 'textdomain'),
        'singular_name'      => _x('Testimonial', 'post type singular name', 'textdomain'),
        'menu_name'          => _x('Testimonials', 'admin menu', 'textdomain'),
        'name_admin_bar'     => _x('Testimonial', 'add new on admin bar', 'textdomain'),
        'add_new'            => _x('Add New', 'testimonial', 'textdomain'),
        'add_new_item'       => __('Add New Testimonial', 'textdomain'),
        'new_item'           => __('New Testimonial', 'textdomain'),
        'edit_item'          => __('Edit Testimonial', 'textdomain'),
        'view_item'          => __('View Testimonial', 'textdomain'),
        'all_items'          => __('All Testimonials', 'textdomain'),
        'search_items'       => __('Search Testimonials', 'textdomain'),
        'parent_item_colon'  => __('Parent Testimonials:', 'textdomain'),
        'not_found'          => __('No testimonials found.', 'textdomain'),
        'not_found_in_trash' => __('No testimonials found in Trash.', 'textdomain'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'testimonials'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array('title', 'editor', 'thumbnail', 'excerpt'),
    );

    register_post_type('testimonials', $args);
}
add_action('init', 'register_testimonials_post_type');

// Register Region Taxonomy
function register_region_taxonomy()
{
    $labels = array(
        'name'              => _x('Regions', 'taxonomy general name', 'textdomain'),
        'singular_name'     => _x('Region', 'taxonomy singular name', 'textdomain'),
        'search_items'      => __('Search Regions', 'textdomain'),
        'all_items'         => __('All Regions', 'textdomain'),
        'parent_item'       => __('Parent Region', 'textdomain'),
        'parent_item_colon' => __('Parent Region:', 'textdomain'),
        'edit_item'         => __('Edit Region', 'textdomain'),
        'update_item'       => __('Update Region', 'textdomain'),
        'add_new_item'      => __('Add New Region', 'textdomain'),
        'new_item_name'     => __('New Region Name', 'textdomain'),
        'menu_name'         => __('Region', 'textdomain'),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'region'),
    );

    register_taxonomy('region', array('testimonials'), $args);
}
add_action('init', 'register_region_taxonomy');

// Register Career Field Taxonomy
function register_career_field_taxonomy()
{
    $labels = array(
        'name'              => _x('Career Fields', 'taxonomy general name', 'textdomain'),
        'singular_name'     => _x('Career Field', 'taxonomy singular name', 'textdomain'),
        'search_items'      => __('Search Career Fields', 'textdomain'),
        'all_items'         => __('All Career Fields', 'textdomain'),
        'parent_item'       => __('Parent Career Field', 'textdomain'),
        'parent_item_colon' => __('Parent Career Field:', 'textdomain'),
        'edit_item'         => __('Edit Career Field', 'textdomain'),
        'update_item'       => __('Update Career Field', 'textdomain'),
        'add_new_item'      => __('Add New Career Field', 'textdomain'),
        'new_item_name'     => __('New Career Field Name', 'textdomain'),
        'menu_name'         => __('Career Field', 'textdomain'),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'career-field'),
    );

    register_taxonomy('career_field', array('testimonials'), $args);
}
add_action('init', 'register_career_field_taxonomy');


// Testimonials Shortcode
function display_testimonials_shortcode($atts)
{
    // Shortcode attributes
    $atts = shortcode_atts(
        array(
            'count' => -1, // Display all testimonials by default
        ),
        $atts,
        'testimonials'
    );

    // Query arguments
    $args = array(
        'post_type'      => 'testimonials', // Change to your custom post type
        'posts_per_page' => intval($atts['count']),
    );

    // The Query
    $testimonials_query = new WP_Query($args);

    // Display Testimonials
    if ($testimonials_query->have_posts()) {
        $output = '<div class="vi-testimonials">';

        while ($testimonials_query->have_posts()) {

            $testimonials_query->the_post();

            $terms_cf = get_the_terms($testimonials_query->post->ID, 'career_field');
            $terms_cf = join(', ', wp_list_pluck($terms_cf, 'slug'));

            $terms_rg = get_the_terms($testimonials_query->post->ID, 'region');
            $terms_rg = join(', ', wp_list_pluck($terms_rg, 'slug'));

            $university = get_post_meta($testimonials_query->post->ID, '_university', true);
            $role = get_post_meta($testimonials_query->post->ID, '_role', true);
            $video = get_post_meta($testimonials_query->post->ID, '_video', true);

            if (has_post_thumbnail($testimonials_query->post->ID)) {
                $image = wp_get_attachment_image_src(get_post_thumbnail_id($testimonials_query->post->ID), 'thumbnail');
            } else {
                $image[0] = "https://prod-vi-wordpress.s3.ap-southeast-1.amazonaws.com/wp-content/uploads/2023/10/18000236/b3.png";
            }

            $output .= '<div class="vi-testimonial ' . $terms_cf . ' ' . $terms_rg . '">';
            if ($video != '') {
                $output .= '<div class="vi-testimonial-content"><iframe width="100%" height="150" src="' . $video . '" title="YouTube video player" frameborder="0" allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe></div>';
            } else {
                $output .= '<div class="vi-testimonial-content">' . get_the_content() . '</div>';
            }

            $output .= '<div class="vi-testimonial-title" style="background-image:url(' . $image[0] . ')">';
            $output .= '<h3>' . get_the_title() . '</h3>';
            $output .= '<h4>' . esc_attr($university) . '</h4>';
            $output .= '<h5>' . esc_attr($role) . '</h5>';
            $output .= '</div>';
            $output .= '</div>';
        }

        $output .= '</div>';

        // Reset post data
        wp_reset_postdata();

        return $output;
    } else {
        return '<p>No testimonials found.</p>';
    }
}
add_shortcode('testimonials', 'display_testimonials_shortcode');

// Add Meta Box for Testimonials
function add_testimonials_meta_box()
{
    add_meta_box(
        'testimonials_meta_box',
        'Testimonial Details',
        'render_testimonials_meta_box',
        'testimonials', // Change to your custom post type
        'normal',
        'default'
    );
}
add_action('add_meta_boxes', 'add_testimonials_meta_box');

// Render Meta Box Content
function render_testimonials_meta_box($post)
{
    // Nonce to verify data when saved
    wp_nonce_field('testimonials_meta_box_nonce', 'testimonials_nonce');

    // Get existing values
    $university = get_post_meta($post->ID, '_university', true);
    $role = get_post_meta($post->ID, '_role', true);
    $video = get_post_meta($post->ID, '_video', true);

    // Display form fields
    echo '<label for="university">University:</label>';
    echo '<input type="text" id="university" name="university" value="' . esc_attr($university) . '" style="width: 100%;" />';

    echo '<label for="role">Role:</label>';
    echo '<input type="text" id="role" name="role" value="' . esc_attr($role) . '" style="width: 100%;" />';

    echo '<label for="video">Video:</label>';
    echo '<input type="text" id="video" name="video" value="' . esc_attr($video) . '" style="width: 100%;" />';
}

// Save Meta Box Data
function save_testimonials_meta_data($post_id)
{
    // Check if nonce is set
    if (!isset($_POST['testimonials_nonce'])) {
        return $post_id;
    }

    // Verify nonce
    if (!wp_verify_nonce($_POST['testimonials_nonce'], 'testimonials_meta_box_nonce')) {
        return $post_id;
    }

    // Check if autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    // Check post type
    if ('testimonials' !== $_POST['post_type']) {
        return $post_id;
    }

    // Save University and Role
    if (isset($_POST['university'])) {
        update_post_meta($post_id, '_university', sanitize_text_field($_POST['university']));
    }

    if (isset($_POST['role'])) {
        update_post_meta($post_id, '_role', sanitize_text_field($_POST['role']));
    }

    if (isset($_POST['video'])) {
        update_post_meta($post_id, '_video', sanitize_text_field($_POST['video']));
    }
}
add_action('save_post', 'save_testimonials_meta_data');



function vi_button_shortcode($atts)
{
    $atts = shortcode_atts(array(
        'text' => 'Learn More',
        'subtitle' => '',
        'link' => '#',
        'icon' => 'none',
        'size' => 'medium',
        'bg_color' => 'primary',
        'custom_bg_color' => '',
        'text_color' => '#FFFFFF',
        'hover_bg_color' => '',
        'hover_text_color' => '',
        'hover_border_color' => '',
        'border_color' => '',
        'border_width' => '0',
        'border_radius' => '4',
        'icon_position' => 'right',
        'target' => '_self',
        'margin_top' => '',
        'margin_bottom' => '',
        'margin_left' => '',
        'margin_right' => '',
        'button_id' => '',
        'class' => ''
    ), $atts);

    // Define color presets
    $color_presets = array(
        'primary' => '#f89122',
        'secondary' => '#00b1aa',
        'accent' => '#f54265',
        'white' => '#fff',
        'black' => '#000',
        'gray' => '#676767',
        'highlight' => '#0A272B'
    );

    // Handle background color - custom or preset
    $bg_color = $atts['bg_color'] === 'custom' ?
        $atts['custom_bg_color'] : ($color_presets[$atts['bg_color']] ?? '#f89122');

    $unique_id = uniqid('vi-btn-');

    // Get icon SVG if selected and not 'none'
    $icon_html = '';
    if (!empty($atts['icon']) && $atts['icon'] !== 'none') {
        $icon_path = get_stylesheet_directory() . '/assets/icons/' . $atts['icon'] . '.svg';
        if (file_exists($icon_path)) {
            $icon_html = '<span class="vi-button__icon">' . file_get_contents($icon_path) . '</span>';
        }
    }

    // Build classes
    $classes = array(
        'vi-button',
        'vi-button--' . esc_attr($atts['size']),
        'vi-button-' . esc_attr($atts['bg_color']),  // Add preset class for fallback
        $unique_id
    );

    if ($atts['icon'] !== 'none') {
        $classes[] = 'vi-button--icon-' . esc_attr($atts['icon_position']);
    }

    if (!empty($atts['class'])) {
        $custom_classes = explode(' ', $atts['class']);
        foreach ($custom_classes as $class) {
            $classes[] = sanitize_html_class($class);
        }
    }

    // Handle hover styles
    $hover_bg = !empty($atts['hover_bg_color']) ? $atts['hover_bg_color'] : $bg_color;
    $hover_text = !empty($atts['hover_text_color']) ? $atts['hover_text_color'] : $atts['text_color'];
    $hover_border = !empty($atts['hover_border_color']) ? $atts['hover_border_color'] : $atts['border_color'];

    // Handle margins
    $styles = array();
    if (!empty($atts['margin_top'])) $styles[] = 'margin-top:' . intval($atts['margin_top']) . 'px';
    if (!empty($atts['margin_bottom'])) $styles[] = 'margin-bottom:' . intval($atts['margin_bottom']) . 'px';
    if (!empty($atts['margin_left'])) $styles[] = 'margin-left:' . intval($atts['margin_left']) . 'px';
    if (!empty($atts['margin_right'])) $styles[] = 'margin-right:' . intval($atts['margin_right']) . 'px';

    // Generate styles with !important to ensure they're applied
    $button_styles = sprintf(
        '<style>
            .%1$s {
                background-color: %2$s !important;
                color: %3$s !important;
                border: %4$spx solid %5$s !important;
                border-radius: %6$spx !important;
                transition: all 0.3s ease !important;
            }
            .%1$s:hover,
            .%1$s:focus {
                background-color: %7$s !important;
                color: %8$s !important;
                border-color: %9$s !important;
                opacity: 0.9 !important;
            }
            .%1$s .vi-button__icon svg {
                fill: %3$s !important;
                transition: fill 0.3s ease !important;
            }
            .%1$s:hover .vi-button__icon svg,
            .%1$s:focus .vi-button__icon svg {
                fill: %8$s !important;
            }
        </style>',
        $unique_id,
        esc_attr($bg_color),
        esc_attr($atts['text_color']),
        esc_attr($atts['border_width']),
        !empty($atts['border_color']) ? esc_attr($atts['border_color']) : 'transparent',
        esc_attr($atts['border_radius']),
        esc_attr($hover_bg),
        esc_attr($hover_text),
        esc_attr($hover_border)
    );

    // Build button content
    $button_text = do_shortcode($atts['text']); // Allow shortcode processing
    $button_text = str_replace(array('``', '""'), '"', $button_text); // Fix quotes
    $button_text = html_entity_decode($button_text, ENT_QUOTES); // Decode HTML entities

    $button_content = $atts['icon'] !== 'none' && $atts['icon_position'] === 'left'
        ? $icon_html . '<span class="vi-button__text">' . $button_text . '</span>'
        : '<span class="vi-button__text">' . $button_text . '</span>' . ($atts['icon'] !== 'none' ? $icon_html : '');

    // Build button HTML
    $button = $button_styles . sprintf(
        '<a %s href="%s" class="%s" target="%s" %s>%s</a>',
        !empty($atts['button_id']) ? 'id="' . esc_attr($atts['button_id']) . '"' : '',
        esc_url($atts['link']),
        esc_attr(implode(' ', array_unique($classes))),
        esc_attr($atts['target']),
        !empty($styles) ? 'style="' . esc_attr(implode(';', $styles)) . '"' : '',
        $button_content
    );

    return $button;
}
add_shortcode('vi_button', 'vi_button_shortcode');

// Enhanced GA4 UTM tracking with referrer override
add_action('wp_footer', function () {
    if (!is_admin()) {
        ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const platformLinks = document.querySelectorAll('a[href*="web.virtualinternships.com"]');

    platformLinks.forEach(link => {
        const url = new URL(link.href);
        const currentPage = window.location.pathname.replace(/^\/|\/$/g, '').replace(/\//g, '-') ||
            'homepage';

        // Enhanced UTM parameter mapping
        let campaignName, contentName;
        const path = window.location.pathname.toLowerCase();

        if (path.includes('/companies')) {
            campaignName = 'companies_to_platform';
            contentName = 'companies_page';
        } else if (path.includes('/interns')) {
            campaignName = 'interns_to_platform';
            contentName = 'interns_page';
        } else if (path.includes('/how-it-works')) {
            campaignName = 'how_it_works_to_platform';
            contentName = 'how_it_works_page';
        } else if (path === '/' || path === '') {
            campaignName = 'homepage_to_platform';
            contentName = 'homepage';
        } else {
            campaignName = 'website_to_platform';
            contentName = currentPage;
        }

        // Add UTM parameters
        url.searchParams.set('utm_source', 'main_website');
        url.searchParams.set('utm_medium', 'internal_navigation');
        url.searchParams.set('utm_campaign', campaignName);
        url.searchParams.set('utm_content', contentName);

        // Add custom referrer parameter that GA4 can use
        url.searchParams.set('ref_page', encodeURIComponent(window.location.pathname));
        url.searchParams.set('ref_url', encodeURIComponent(window.location.href));

        link.href = url.toString();

        // Enhanced click tracking
        link.addEventListener('click', function() {
            // Send enhanced dataLayer event for GTM
            if (typeof dataLayer !== 'undefined') {
                dataLayer.push({
                    'event': 'platform_navigation_enhanced',
                    'enhanced_source_page': window.location.pathname,
                    'enhanced_source_url': window.location.href,
                    'enhanced_campaign': campaignName,
                    'enhanced_content': contentName,
                    'enhanced_destination': link.href,
                    // This will override GA4's automatic referrer detection
                    'custom_referrer': window.location.href
                });
            }

            // Direct GA4 event with referrer override
            if (typeof gtag !== 'undefined') {
                gtag('event', 'platform_click_tracked', {
                    'source_page_path': window.location.pathname,
                    'source_full_url': window.location.href,
                    'campaign_name': campaignName,
                    'content_name': contentName,
                    'destination_url': link.href,
                    // Custom parameter that preserves full referrer
                    'custom_parameter_full_referrer': window.location.href
                });
            }
        });
    });
});

// CRITICAL: Override GA4's automatic page_referrer for platform pages
// Add this to the platform domain (web.virtualinternships.com)
if (window.location.hostname === 'web.virtualinternships.com') {
    // Check for custom referrer parameters in URL
    const urlParams = new URLSearchParams(window.location.search);
    const customRefUrl = urlParams.get('ref_url');
    const customRefPage = urlParams.get('ref_page');

    if (customRefUrl && typeof gtag !== 'undefined') {
        // Override the automatic page_view with custom referrer
        gtag('config', 'GA_MEASUREMENT_ID', {
            'custom_parameter_override_referrer': customRefUrl,
            'custom_parameter_source_page': customRefPage
        });

        // Send custom page_view with correct referrer
        gtag('event', 'page_view', {
            'page_referrer': customRefUrl,
            'custom_parameter_true_referrer': customRefUrl,
            'custom_parameter_source_page': customRefPage
        });
    }
}
</script>
<?php
    }
});