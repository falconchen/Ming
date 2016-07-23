<?php
/**
 * Generate theme menu
 *
 * @since Envision 2.0
 */

global $menus;


// -----------------------------------------------
register_nav_menus(array(
    'default' => __('Default Navigation', 'tfuse')
));


// -----------------------------------------------
$menus = array(
    'default' => array(
        'depth' => 3,
        'container_class' => 'menu-header',
        'menu_class' => 'topmenu',
        'theme_location' => 'default',
        'fallback_cb' => 'tfuse_select_menu_msg',
        'link_before'     => '<span>',
        'link_after'      => '</span>',

    )
);

// -----------------------------------------------
function tfuse_menu($menu_type) {
    global $menus;
    if (isset($menus[$menu_type])) {
        wp_nav_menu($menus[$menu_type]);
    }
}

function tfuse_select_menu_msg()
{
    echo '<div class="menu-header"><p>Please go to the <a href="' . admin_url('nav-menus.php') . '" target="_blanck">Menu</a> section, create a  menu and then select the newly created menu from the Theme Locations box from the left.</p></div>';
}
