<select id="extra_select">
    <option rel="" value="">Select </option>
    <option rel="is_default" value="is_default">Default</option>
    <?php
    foreach ($select_options as $id => $cfg) {
        ?>
        <option class="<?php
    if ($cfg['has_id'] === TRUE)
        echo ' has_id ';
        ?>" rel="<?php echo $id; ?>" value="<?php echo $id; ?>"><?php echo $cfg['name']; ?>
        </option>
        <?php
    }
    ?>
</select>
<br/>
<a href="#" id="show_more_opts">Show advanced options</a>