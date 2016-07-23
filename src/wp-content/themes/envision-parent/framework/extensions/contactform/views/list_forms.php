<?php wp_nonce_field('tfuse_ajax_delete_forms', 'tfuse_nonce_form_delete', false); ?><br />
<a class="delete_selected_forms button">Delete Selected</a> <a class="button" href="<?php echo admin_url('admin.php?page=tf_contact_form') ?>">Add New</a><br /><br />
<table cellspacing="0" class="wp-list-table widefat fixed pages form_list_table">
    <thead>
        <tr>
            <th style="" class="manage-column column-cb check-column" id="cb" scope="col"><input type="checkbox"></th>
            <th style="" class="manage-column" id="form_title" scope="col">
                <a href="">
                    <span>Form name</span>
                </a>
            </th>
            <th style="" class="manage-column" id="slide_number" scope="col">
                <a href="">
                    <span>No. of fields</span>
                </a>
            </th>
            <th style="" class="manage-column" id="form_design" scope="col">
                <a href="">
                    <span>Email send to</span>
                </a>
            </th>
            <th style="" class="manage-column" id="form_design" scope="col">
                <a href="">
                    <span>Email subject</span>
                </a>
            </th>
            <th style="" class="manage-column" id="form_design" scope="col">
                <a href="">
                    <span>Form Shortcode</span>
                </a>
            </th>

        </tr>
    </thead>

    <tfoot>
        <tr>
            <th style="" class="manage-column column-cb check-column" scope="col"><input type="checkbox"></th>
            <th style="" class="manage-column" scope="col">
                <a href="">
                    <span>Form name</span>
                </a>
            </th>
            <th style="" class="manage-column" scope="col">
                <a href="">
                    <span>No. of fields</span>
                </a>
            </th>
            <th style="" class="manage-column" scope="col">
                <a href="">
                    <span>Email send to</span>
                </a>
            </th>
            <th style="" class="manage-column" scope="col">
                <a href="">
                    <span>Email subject</span>
                 </a>
            </th>
            <th style="" class="manage-column" id="form_design" scope="col">
                <a href="">
                    <span>Form Shortcode</span>
                </a>
            </th>

        </tr>
    </tfoot>

    <tbody id="the-list">
        <?php
        $alternate = 0;
        if ($forms)
            foreach ($forms as $form_id => $form) {
                $edit_url = get_admin_url() . 'admin.php?page=tf_contact_form&id=' . $form_id;
                ?>
                <tr valign="top" class="<?php if ($alternate++ % 2 == 0) { ?>alternate<?php } ?>" id="">
                    <th class="check-column" scope="row"><input class="checkbox_delete_form" type="checkbox" value="<?php echo $form_id ?>" name="forms"></th>
                    <td>
                        <strong>
                            <a href="<?php echo $edit_url; ?>" class="row-title">
                                <?php echo $form['form_name'] ?>
                            </a>
                        </strong>
                        <div class="row-actions">
                            <span class="edit">
                                <a title="Edit this item" href="<?php echo $edit_url; ?>">
                                    Edit
                                </a> | 
                            </span>
                            <span class="trash">
                                <a href="#" title="Delete this item" rel="<?php echo $form_id ?>" class="tf_delete_form">
                                    Delete
                                </a>
                            </span>
                        </div>
                    </td>			
                    <td class="date">
                        <?php  echo count($form['input']); ?>
                    </td>
                    <td>
                        <?php  echo $form['email_to']; ?>
                    </td>
                    <td>
                        <?php  echo $form['email_subject']; ?>
                    </td>
                    <td>
                       <code><?php  echo '[tfuse_contactform tf_cf_formid="'.$form_id.'"]'; ?></code>
                    </td>

                </tr>
                <?php
            } else {
            ?>
            <tr><td colspan="4">Nothing found</td></tr>
        <?php } ?>
    </tbody>
</table>
<br/>
<a class="delete_selected_forms button">Delete Selected</a> <a class="button" href="<?php echo admin_url('admin.php?page=tf_contact_form') ?>">Add New</a>