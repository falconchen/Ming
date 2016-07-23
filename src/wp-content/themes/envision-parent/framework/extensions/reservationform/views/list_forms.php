<?php wp_nonce_field('tfuse_ajax_delete_forms', 'tfuse_nonce_form_delete', false); ?><br />
<a class="delete_selected_forms button">Delete Selected</a> <a class="button" href="<?php echo admin_url('admin.php?page=tf_reservation_form') ?>">Add New</a><br /><br />
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
            <th style="" class="manage-column" id="datepickers_number" scope="col">
                <a href="">
                    <span>Date Pickers</span>
                </a>
            </th>
            <th style="" class="manage-column" scope="col">
                <a href="">
                    <span>Email Subject</span>
                </a>
            </th>
            <th style="" class="manage-column" id="shortcode" scope="col">
                <a href="">
                    <span>Shortcode</span>
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
                    <span>Date Pickers</span>
                </a>
            </th>
            <th style="" class="manage-column" scope="col">
                <a href="">
                    <span>Email Subject</span>
                </a>
            </th>
            <th style="" class="manage-column"  scope="col">
                <a href="">
                    <span>Shortcode</span>
                </a>
            </th>

        </tr>
    </tfoot>

    <tbody id="the-list">
        <?php
        $alternate = 0;
        if ($forms)
            foreach ($forms as $form_id => $form) {
                $edit_url = get_admin_url() . 'admin.php?page=tf_reservation_form&id=' . $form->term_id;
                ?>
                <tr valign="top" class="<?php if ($alternate++ % 2 == 0) { ?>alternate<?php } ?>" id="">
                    <th class="check-column" scope="row"><input class="checkbox_delete_form" type="checkbox" value="<?php echo $form->term_id ?>" name="forms"></th>
                    <td >
                        <strong   >
                            <a href="<?php echo $edit_url; ?>" class="row-title">
                                <?php echo urldecode($form->name); ?>
                            </a>
                        </strong>
                        <div class="row-actions">
                            <span class="edit">
                                <a title="Edit this item" href="<?php echo $edit_url; ?>">
                                    Edit
                                </a> | 
                            </span>
                            <span class="trash">
                                <a href="#" title="Delete this item" rel="<?php echo $form->term_id ?>" class="tf_delete_reservation_form">
                                    Delete
                                </a>
                            </span>
                        </div>
                    </td>			
                    <td class="date">
                        <?php  echo count($form->description['input']); ?>
                    </td>
                    <td>
                        <?php $options=array(
                        1 => 'Check In',
                        2 => 'Check In & Check Out'
                    ); ?>
                        <?php  echo @$options[$form->description['datepickers_count']]; ?>
                    </td>
                    <td>
                        <?php  echo urldecode($form->description['email_subject']); ?>
                    </td>
                    <td>
                        <code class="tfuse_selectable_code">[tfuse_reservationform tf_rf_formid="<?php echo $form->term_id; ?>"]</code>
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
<a class="delete_selected_forms button">Delete Selected</a> <a class="button" href="<?php echo admin_url('admin.php?page=tf_reservation_form') ?>">Add New</a>