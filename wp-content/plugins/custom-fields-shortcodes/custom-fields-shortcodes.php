<?php
/*
  Plugin Name: Custom Fields Shortcodes
  Plugin URI: http://wp-types.com/home/custom-fields-shortcodes/
  Description: Allows inserting custom fields into content without using PHP
  Author: ICanLocalize
  Author URI: http://wp-types.com/
  Version: 0.9
 */

add_shortcode('cf-shortcode', 'wptacf_shorttags_process_shorttags');
add_action('admin_menu', 'wptacf_admin_menu', 99999999);
add_action('load-post.php', 'wptacf_post_page');
add_action('load-post-new.php', 'wptacf_post_page');
add_filter('editor_addon_menus_wpv-views', 'wptacf_editor_addon_menus_filter');
add_filter('editor_addon_dropdown_top_message_wptacf',
        'wptacf_editor_dropdown_top_message');

/**
 * Admin menu hook.
 */
function wptacf_admin_menu() {
    if (class_exists('custom_field_template')
            || function_exists('more_fields_field_types')) {
        add_options_page('Dynamic Templates', 'Dynamic Templates',
                'manage_options', 'cfshortcode-settings',
                'wpacf_promotional_text');
    }
    if (class_exists('Acf')) {
        $hook = add_submenu_page('edit.php?post_type=acf', 'Dynamic Templates',
                'Dynamic Templates', 'manage_options', 'cfshortcode',
                'wpacf_promotional_text');
    }
}

/**
 * Post edit page processes.
 * 
 * @global stdClass $wpcfs
 * @global type $wpdb
 * @return type 
 */
function wptacf_post_page() {
    // Get post
    if (isset($_GET['post'])) {
        $post_id = (int) $_GET['post'];
    } else if (isset($_POST['post_ID'])) {
        $post_id = (int) $_POST['post_ID'];
    } else {
        $post_id = 0;
    }
    $post_type = get_post_type($post_id);
    if (empty($post_type)) {
        if (!isset($_GET['post_type'])) {
            $post_type = 'post';
        } else if (in_array($_GET['post_type'],
                        get_post_types(array('show_ui' => true)))) {
            $post_type = $_GET['post_type'];
        } else {
            return false;
        }
    }

    $processed_fields = array();

    // ACF
    if (class_exists('Acf')) {
        define('WPCFS_ACF', true);
        $acf_groups = get_posts('post_type=acf&status=publish&numberposts=-1');
        if (!empty($acf_groups)) {
            foreach ($acf_groups as $acf_key => $acf_post) {
                $metas = get_post_custom($acf_post->ID);
                foreach ($metas as $meta_name => $meta) {
                    if (strpos($meta_name, 'field_') === 0) {
                        $data = array();
                        $meta = unserialize($meta[0]);
                        $data['plugin'] = 'acf';
                        $data['group_id'] = $acf_post->ID;
                        $data['group_title'] = $acf_post->post_title;
                        $data['field_id'] = $meta['name'];
                        $data['field_title'] = $meta['label'];
                        if (in_array($post_type, array('view', 'view-template'))) {
                            $data['dropdowns'] = array('wpv_views');
                        } else {
                            $data['dropdowns'] = array('wpv_views', 'wptacf');
                        }
                        wptacf_add_to_editor($data);
                        $processed_fields[] = $data['field_id'];
                    }
                }
            }
        }
    }
    // CFT
    if (class_exists('custom_field_template')) {
        global $wpcfs;
        $wpcfs = new stdClass();
        $wpcfs->cft = new custom_field_template();
        define('WPCFS_CFT', true);
        $cft_groups = $wpcfs->cft->get_custom_field_template_data();
        foreach ($cft_groups['custom_fields'] as $key => $group) {
            $group_title = $group['title'];
            $group = $wpcfs->cft->get_custom_fields($key);
            foreach ($group as $fields) {
                foreach ($fields as $field_name => $field) {
                    $data = array();
                    $data['plugin'] = 'cft';
                    $data['group_id'] = sanitize_title($group_title);
                    $data['group_title'] = $group_title;
                    $data['field_id'] = $field_name;
                    $data['field_title'] = $field_name;
                    if (in_array($post_type, array('view', 'view-template'))) {
                        $data['dropdowns'] = array('wpv_views');
                    } else {
                        $data['dropdowns'] = array('wpv_views', 'wptacf');
                    }
                    wptacf_add_to_editor($data);
                    $processed_fields[] = $data['field_id'];
                }
            }
        }
    }
    // MF
    if (function_exists('more_fields_field_types')) {
        define('WPCFS_MF', true);
        $mf = get_option('more_fields', array());
        foreach ($mf as $group_id => $group_data) {
            if (empty($group_data['fields'])) {
                continue;
            }
            foreach ($group_data['fields'] as $field_id => $field) {
                $data = array();
                $data['plugin'] = 'more-fields';
                $data['group_id'] = sanitize_title($group_data['index']);
                $data['group_title'] = $group_data['label'];
                $data['field_id'] = $field['key'];
                $data['field_title'] = $field['label'];
                if (in_array($post_type, array('view', 'view-template'))) {
                    $data['dropdowns'] = array('wpv_views');
                } else {
                    $data['dropdowns'] = array('wpv_views', 'wptacf');
                }
                wptacf_add_to_editor($data);
                $processed_fields[] = $data['field_id'];
            }
        }
    }
    // Generic
    global $wpdb;
    if ($post_id) {
        $generic = get_post_custom($post_id);
        foreach ($generic as $type_id => $type_data) {
            if (substr($type_id, 0, 1) != '_' && !in_array($type_id,
                            $processed_fields)) {
                $data = array();
                $data['plugin'] = 'generic';
                $data['group_id'] = 'generic';
                $data['group_title'] = __('Generic');
                $data['field_id'] = $type_id;
                $data['field_title'] = $type_id;
                if (in_array($post_type, array('view', 'view-template'))) {
                    $data['dropdowns'] = array('wpv_views');
                } else {
                    $data['dropdowns'] = array('wpv_views', 'wptacf');
                }
                wptacf_add_to_editor($data);
                $processed_fields[] = $data['field_id'];
            }
        }
    }

    if (empty($processed_fields)) {
        wptacf_add_to_editor(array(
            'plugin' => 'no-data',
            'group_id' => 'no-data',
            'group_title' => '',
            'field_id' => '',
            'field_title' => '',
        ));
        add_filter('editor_addon_dropdown_top_message_wptacf',
                'wptacf_editor_dropdown_top_message_empty');
    }
}

/**
 * Processes shorttags.
 * 
 * @param type $atts
 * @return type 
 */
function wptacf_shorttags_process_shorttags($atts, $content = null, $code = '') {
    $atts = shortcode_atts(array(
        'field' => 'none',
        'plugin' => 'none',
            ), $atts);
    $output = '';
    if ($atts['plugin'] == 'acf' && !empty($atts['field']) && is_callable('get_field')) {
        $field = get_field($atts['field']);
        if (!empty($field)) {
            $output = is_array($field) ? array_shift($field) : $field;
        }
    } else if (in_array($atts['plugin'], array('cft', 'more-fields', 'generic'))) {
        $output = wptacf_view_simple($atts['field']);
    }
    return $output;
}

/**
 * Renders field's value.
 * 
 * @global type $post
 * @param type $field
 * @return type 
 */
function wptacf_view_simple($field) {
    if (empty($field)) {
        return '';
    }
    global $post;
    $field = get_post_meta($post->ID, $field, true);
    if (!empty($field)) {
        $field = maybe_unserialize($field);
        if (is_array($field)) {
            $field = implode(', ', array_values($field));
        }
        if (strpos($field, "\n")) {
            $field = htmlspecialchars_decode(stripslashes($field));
            $field = do_shortcode($field);
            $field = wpautop($field);
        }
        return $field;
    }
    return '';
}

/**
 * Stores fields for editor menu.
 * 
 * @staticvar array $fields
 * @param type $field
 * @return array 
 */
function wptacf_add_to_editor($field, $dropdown = 'wptacf') {
    static $fields = array();
    if ($field == 'get') {
        return $fields[$dropdown];
    }
    if (empty($fields)) {
        add_action('admin_enqueue_scripts', 'wptacf_add_to_editor_js');
    }
    foreach ($field['dropdowns'] as $dropdown) {
        $fields[$dropdown][$field['group_id']][$field['field_id']] = $field;
    }
}

/**
 * Renders JS for editor menu.
 * 
 * @return type 
 */
function wptacf_add_to_editor_js() {
    global $post;
    if (in_array($post->post_type, array('view', 'view-template'))) {
        return false;
    }
    require_once dirname(__FILE__) . '/includes/visual-editor/editor-addon.class.php';
    $groups = wptacf_add_to_editor('get');
    $editor_addon = new Editor_addon('wptacf',
                    __('Insert custom fields shortcode', 'wptacf'),
                    plugins_url('', __FILE__) . '/js/wptacf_editor_plugin.js',
                    plugins_url('', __FILE__) . '/images/bw_icon16.png');

    foreach ($groups as $group_id => $group) {
        foreach ($group as $field_id => $field) {
            $editor_addon->add_insert_shortcode_menu(stripslashes($field['field_title']),
                    'cf-shortcode plugin="' . trim($field['plugin'])
                    . '" field="' . trim($field['field_id']) . '"',
                    $field['group_title']);
        }
    }
}

/**
 * Adds items to view dropdown.
 * 
 * @param type $items
 * @return type 
 */
function wptacf_editor_addon_menus_filter($items) {
    $groups = wptacf_add_to_editor('get', 'wpv_views');
    $add = array();
    if (!empty($groups)) {
        foreach ($groups as $group_id => $group) {
            foreach ($group as $field_id => $field) {
                $add[$field['group_title']][stripslashes($field['field_title'])] = array(
                    stripslashes($field['field_title']),
                    'cf-shortcode plugin="' . $field['plugin']
                    . '" field="' . $field['field_id'] . '"',
                    $field['group_title']
                );
            }
        }
    }
    $items = $items + $add;
    return $items;
}

/**
 * Renders promotional screen.
 */
function wpacf_promotional_text() {
    $promotional_text = '<div class="message updated" style="padding: 5px 20px;"><h3>' . __('Want to display custom content easily?',
                    'wpcf') . '</h3>';
    $promotional_text .= '<p style="font-size: 110%;">' . __('<a href="http://wp-types.com">Views</a> plugin let\'s you create dynamic templates for single pages and complex content lists. It queries content from the database, filters it and displays in any way you choose.',
                    'wpcf') . '</p>';
    if (defined('WPV_VERSION')) { // Views active
        $promotional_text .= '<ul style="list-style-type:disc; list-style-position: inside; font-size: 110%;"><li><a href="' . admin_url('edit.php?post_type=view-template') . '">' . __('Create <strong>View Templates</strong> for single pages',
                        'wpcf') . '</a></li>';
        $promotional_text .= '<li><a href="' . admin_url('edit.php?post_type=view') . '">' . __('Create <strong>Views</strong> for content lists',
                        'wpcf') . '</a></li>';
        $promotional_text .= '<li><a href="http://wp-types.com">' . __('Find <strong>documentation</strong> and <strong>help</strong>',
                        'wpcf') . '</a></li></ul>';
    } else {
        $promotional_text .= '<p style="font-size: 110%;">' . __('Learn more:',
                        'wpcf') . '</p>';
        $promotional_text .= '<ul style="list-style-type:disc; list-style-position: inside; font-size: 110%;"><li><a href="http://wp-types.com/documentation/user-guides/view-templates/">' . __('Creating dynamic templates',
                        'wpcf') . '</a></li>';
        $promotional_text .= '<li><a href="http://wp-types.com/documentation/user-guides/views/">' . __('Query content and display it',
                        'wpcf') . '</a></li>';
        $promotional_text .= '</ul><p style="font-size: 110%;">' . __('Get Views:',
                        'wpcf') . '</p><ul>';
        $promotional_text .= '<li style="font-size: 110%;"><a href="http://wp-types.com/buy/">' . __('Buy and download Views',
                        'wpcf') . '</a></li>';
        $promotional_text .= '</ul>';
    }
    $promotional_text .= '</div>';

    ?>
    <div id="icon-options-general" class="icon32">
        <br>
    </div>
    <h2><?php _e('Dynamic Templates'); ?></h2>
    <br>
    <?php echo $promotional_text; ?>
    </div>
    <?php
}

/**
 * Adds message to editor dropdown.
 */
function wptacf_editor_dropdown_top_message($messages) {
    if (!defined('WPCFS_ACF') && !defined('WPCFS_CFT') && !defined('WPCFS_MF')) {
        return '';
    }
    $link = defined('WPCFS_ACF') ? 'edit.php?post_type=acf&page=cfshortcode' : 'options-general.php?page=cfshortcode-settings';
    return '<div style="margin: 5px 0 5px;border: 1px solid #E6DB55;background-color: #FFFFE0;padding: 0 0.6em;">'
            . sprintf(__('%sAdding custom fields to dynamic templates%s'),
                    '<a href="'
                    . admin_url($link) . '" style="text-decoration: underline;color: #21759B;display: block;margin: 0.5em 0;padding: 5px;">',
                    '</a>')
            . '</div>' . $messages;
}

/**
 * Adds message to editor dropdown.
 */
function wptacf_editor_dropdown_top_message_empty($messages) {
    return '<div style="margin: 5px 0 5px;border: 1px solid #E6DB55;background-color: #FFFFE0;padding: 0 0.6em;"><p style="display: block;margin: 0.5em 0;padding: 5px;">'
            . __('This content has no custom fields')
            . '</p></div>' . $messages;
}

// Local debug
if ($_SERVER['SERVER_NAME'] == 'localhost') {

    function debug($data) {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        die();
    }

}
