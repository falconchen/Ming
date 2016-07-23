<?php

$_inc_['type_opts'] =
        array(
            'name' => 'Add Sidebar for',
            'desc' => 'Choose what to add sidebars for. Ex: Posts, Pages, Category...',
            'id' => 'sidebars_choose_type',
            'value' => '',
            'type' => 'callback',
            'callback' => array(&$this->ext->sidebars, 'sidebars_choose_type_cb'),
            'divider' => TRUE
);
$_inc_['subtype_opts'] =
        array(
            'name' => 'Choose subtype',
            'desc' => 'Choose subtype',
            'id' => 'sidebars_choose_subtype',
            'value' => '',
            'type' => 'callback',
            'callback' => array(&$this->ext->sidebars, 'sidebars_choose_subtype_cb')
);
$_inc_['multi_opts'] =
        array(
            'name' => '&nbsp;',
            'desc' => 'Type and search automatically',
            'id' => 'sidebars_choose_multi',
            'value' => '',
            'type' => 'callback',
            'callback' => array(&$this->ext->sidebars, 'sidebars_choose_multi_cb')
);
$_inc_['sidebars_positions'] =
        array(
            'name' => 'Sidebar position',
            'desc' => 'Choose the position for your sidebars.',
            'id' => 'sidebars_positions',
            'value' => '',
            'type' => 'callback',
            'callback' => array(&$this->ext->sidebars, 'sidebars_positions_cb')
);
$_inc_['sidebars_placeholders'] =
        array(
            'name' => 'Sidebar add/edit',
            'desc' => '',
            'id' => 'sidebars_placeholders',
            'value' => '',
            'type' => 'callback',
            'callback' => array(&$this->ext->sidebars, 'sidebars_placeholders_cb')
);

$_inc_['multi_options'] =
        array(
            'post' => array(
                'name' => 'Name',
                'desc' => 'Test description',
                'id' => 'sidebar_multi_select_',
                'type' => 'multi',
                'subtype' => 'post'
            ),
            'page' => array(
                'name' => 'Name',
                'desc' => 'Test description',
                'id' => 'sidebar_multi_select_',
                'type' => 'multi',
                'subtype' => 'page'
            ),
            'category' => array(
                'name' => 'Name',
                'desc' => 'Test description',
                'id' => 'sidebar_multi_select_',
                'type' => 'multi',
                'subtype' => 'category'
            ),
            'taxonomy' => array(
                'name' => 'Name',
                'desc' => 'Test description',
                'id' => 'sidebar_multi_select_',
                'type' => 'multi',
                'subtype' => 'taxonomy'
            ),
            'templates' => array(
                'name' => 'Name',
                'desc' => 'Test description',
                'id' => 'sidebar_multi_select_templates',
                'value' => '',
                'type' => 'select',
                'options' => tf_get_templates()
            ),
            'custom_post' => array(
                'name' => 'Name',
                'desc' => 'Test description',
                'id' => 'sidebar_multi_select_',
                'type' => 'multi',
                'subtype' => ''
            ),
            'custom_category' => array(
                'name' => 'Name',
                'desc' => 'Test description',
                'id' => 'sidebar_multi_select_',
                'type' => 'multi',
                'subtype' => ''
            )
);