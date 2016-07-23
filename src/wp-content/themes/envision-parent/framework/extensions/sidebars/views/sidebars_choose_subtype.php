<?php
$tf_post_types = tf_get_post_types();
foreach ($tf_post_types as $key => $name) {
    $taxonomy = tf_custom_post_category($key);
    ?>
    <select placeholders="<?php echo get_placeholders_number($key); ?>" class="sidebars_subtype sidebar_box_<?php echo $key; ?>">
        <option value="">Select subtype</option>
        <option value="default_<?php echo $key; ?>">Default settings for <?php echo $key; ?></option>
        <?php
        if ($taxonomy) {
            ?>
            <option value="by_category_<?php echo $key; ?>">From specific <?php echo $taxonomy; ?></option>
        <?php } ?>
        <option value="by_id_<?php echo $key; ?>">Choose by name</option>
    </select>
<?php } ?>
<select placeholders="<?php echo get_placeholders_number('post'); ?>" class="sidebars_subtype sidebar_box_post">
    <option value="">
        Select subtype
    </option>
    <option value="default_post">
        Defaults settings for post
    </option>
    <option value="by_category_post">
        From specific category
    </option>
    <option value="by_id_post">
        Choose by name
    </option>
</select>

<select placeholders="<?php echo get_placeholders_number('page'); ?>" class="sidebars_subtype sidebar_box_page">
    <option value="">
        Select subtype
    </option>
    <option value="default_page">
        Defaults settings for page
    </option>
    <!--<option value="by_template_page">
        From specific template
    </option>-->
    <option value="by_id_page">
        Choose by name
    </option>
</select>

<select placeholders="<?php echo get_placeholders_number('category'); ?>" class="sidebars_subtype sidebar_box_category">
    <option value="">
        Select subtype
    </option>
    <option value="default_category">
        Defaults settings for category
    </option>
    <option value="by_id_category">
        Choose by name
    </option>
</select>

<?php
$tf_taxonomies = tf_get_taxonomies();
foreach ($tf_taxonomies as $key => $name) {
    ?>
    <select placeholders="<?php echo get_placeholders_number($key); ?>" class="sidebars_subtype sidebar_box_<?php echo $key; ?>">
        <option value="">
            Select subtype
        </option>
        <option value="default_<?php echo $key; ?>">
            Defaults settings for <?php echo $key; ?>
        </option>
        <option value="by_id_<?php echo $key; ?>">
            Choose by name
        </option>
    </select>
<?php } ?>

<select placeholders="<?php echo get_placeholders_number('is_default'); ?>" class="sidebars_subtype sidebar_box_is_default">
    <option value="">
        Select subtype
    </option>
    <option value="default_is_default">
        Global default settings
    </option>
</select>

<select placeholders="<?php echo get_placeholders_number('is_archive'); ?>" class="sidebars_subtype sidebar_box_is_archive">
    <option value="">
        Select subtype
    </option>
    <option value="default_is_archive">
        Default settings for archive pages
    </option>
</select>

<select placeholders="<?php echo get_placeholders_number('is_front_page'); ?>" class="sidebars_subtype sidebar_box_is_front_page">
    <option value="">
        Select subtype
    </option>
    <option value="default_is_front_page">
        Default settings for front page
    </option>
</select>

<select placeholders="<?php echo get_placeholders_number('is_search'); ?>" class="sidebars_subtype sidebar_box_is_search">
    <option value="">
        Select subtype
    </option>
    <option value="default_is_search">
        Default settings for search page
    </option>
</select>

<select placeholders="<?php echo get_placeholders_number('is_blogpage'); ?>" class="sidebars_subtype sidebar_box_is_blogpage">
    <option value="">
        Select subtype
    </option>
    <option value="default_is_blogpage">
        Default settings for Blog Page
    </option>
</select>

<select placeholders="<?php echo get_placeholders_number('is_404'); ?>" class="sidebars_subtype sidebar_box_is_404">
    <option value="">
        Select subtype
    </option>
    <option value="default_is_404">
        Default settings for 404 error page
    </option>
</select>

<div id="sidebar_manager_container">
    <?php
    for ($i = 1; $i <= $max_placeholders; $i++) {
        ?>
        <div class="sidebar_placeholder" id="sidebar_placeholder_<?php echo $i; ?>">
            <span class="placeholder_name">Placeholder <?php echo $i; ?></span>
        </div>
    <?php } ?>
    <br class="clear">
    <input type="button" id="sidebar_settings_save" value="Save"/>
</div>
<br class="clear">