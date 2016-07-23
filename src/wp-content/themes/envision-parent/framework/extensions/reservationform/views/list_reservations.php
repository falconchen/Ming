<?php

global $TFUSE;

wp_nonce_field('tfuse_ajax_delete_forms', 'tfuse_nonce_form_delete', false); ?><br/>
<div id="posts-filter">
    <?php
    $array_s = array(1=>'all',2=>'pending',3=>'approved',4=>'rejected');
    $filter = ($TFUSE->request->isset_GET('filter'))?'&filter='.$TFUSE->request->GET('filter'):'';
    $url = '?page=tf_reservations_list'.$filter.'&paged=';
    $filter_type = ($TFUSE->request->isset_GET('filter')) ? $TFUSE->request->GET('filter') : 1;
    $nr_of_pages = ($statistic[$array_s[$filter_type]]%20 == 0)?intval($statistic[$array_s[$filter_type]]/20):intval($statistic[$array_s[$filter_type]]/20+1);
    $paged = ($TFUSE->request->isset_GET('paged') && $TFUSE->request->GET('paged')>0 && $TFUSE->request->GET('paged')<=$nr_of_pages)?$TFUSE->request->GET('paged'):1;
    $is_filter = ($TFUSE->request->isset_GET('filter')) ? $TFUSE->request->GET('filter') : false;
    $pagination_class=($nr_of_pages>1)?'':'hidden';
    if(isset($term_id) && $term_id != -1)
    {
        $term       = get_term($term_id, 'reservations');
    }else{
        $term = get_terms('reservations', array('hide_empty' => 0, 'number' => 1));
        $term = (isset($term[0])) ? $term[0] : false;
    }
    $form       = ($term)  ? unserialize($term->description) : false;
    ?>
    <a class="<?php echo ($is_filter && $is_filter == 1) ? 'current_filter_type' : ''; ?>"
       href="admin.php?page=tf_reservations_list&filter=1">All <span class="count">(<?php echo $statistic['all'] ?>)</span></a> |
    <a class="<?php echo ($is_filter && $is_filter==2)?'current_filter_type':''; ?>" href="admin.php?page=tf_reservations_list&filter=2">Pending <span class="count">(<?php echo $statistic['pending'] ?>)</span></a> |
    <a class="<?php echo ($is_filter && $is_filter==3)?'current_filter_type':''; ?>" href="admin.php?page=tf_reservations_list&filter=3">Approved <span class="count">(<?php echo $statistic['approved'] ?>)</span></a> |
    <a class="<?php echo ($is_filter && $is_filter==4)?'current_filter_type':''; ?>" href="admin.php?page=tf_reservations_list&filter=4">Rejected <span class="count">(<?php echo $statistic['rejected'] ?>)</span></a>

    <form id="reservations_search" action='admin.php?page=tf_reservations_list' method='get'>
        <p class="search-box">
            <label class="screen-reader-text">Search Posts:</label>
            <input type="hidden" value="tf_reservations_list" name="page">
            <input id="post-search-input" type="search" value="" name="s">
            <input id="ssubmit" class="button" type="submit" value="Search Res. Number" name="">
        </p>
    </form>
</div>
<div class="filter_second tablenav top">
    <a class="delete_selected_reservations button">Delete Selected</a>
    <a href="#" class="approve_selected_reservations button">Approve</a>
    <a href="#" class="reject_selected_reservations button">Reject</a>

    <div class="tablenav-pages">
        <span class="displaying-num"><?php echo $statistic[$array_s[$filter_type]] ?> items</span>
<span class="pagination-links <?php echo $pagination_class; ?>"><a href="<?php echo $url; ?>1"
                                  title="Go to the first page" class="first-page">«</a>
<a href="<?php echo $url.($paged-1); ?>" title="Go to the previous page"
   class="prev-page">‹</a>
<span class="paging-input"><input type="text" size="1" value="<?php echo $paged ?>" name="paged" title="Current page" class="current-page"> of <span
    class="total-pages"><?php echo $nr_of_pages; ?></span></span>
<a href="<?php echo $url.($paged+1); ?>" title="Go to the next page"
   class="next-page">›</a>
<a href="<?php echo $url.$nr_of_pages; ?>" title="Go to the last page"
   class="last-page">»</a></span></div>
</div>
<table cellspacing="0" class="wp-list-table widefat fixed pages form_list_table">
    <thead>
    <tr>
        <th style="" class="manage-column column-cb check-column" id="cb" scope="col"><input type="checkbox"></th>
        <th style="" class="manage-column" id="form_title" scope="col">
            <a href="">
                <span>Title</span>
            </a>
        </th>
        <th style="" class="manage-column" id="res_number" scope="col">
            <a href="">
                <span>Res. Number</span>
            </a>
        </th>
        <th style="" class="manage-column" id="slide_number" scope="col">
            <a href="">
                <span>Date In</span>
            </a>
        </th>
        <th style="" class="manage-column" id="form_design" scope="col">
            <a href="">
                <span>Date Out</span>
            </a>
        </th>
        <th style="" class="manage-column" scope="col">
            <a href="">
                <span>Status</span>
            </a>
        </th>
    </tr>
    </thead>

    <tfoot>
    <tr>
        <th style="" class="manage-column column-cb check-column" scope="col"><input type="checkbox"></th>
        <th style="" class="manage-column" scope="col">
            <a href="">
                <span>Title</span>
            </a>
        </th>
        <th style="" class="manage-column" scope="col">
            <a href="">
                <span>Res. Number</span>
            </a>
        </th>
        <th style="" class="manage-column" scope="col">
            <a href="">
                <span>Date In</span>
            </a>
        </th>
        <th style="" class="manage-column" scope="col">
            <a href="">
                <span>Date Out</span>
            </a>
        </th>
        <th style="" class="manage-column" scope="col">
            <a href="">
                <span>Status</span>
            </a>
        </th>
    </tr>
    </tfoot>
    <tbody id="the-list">
    <?php
    $alternate = 0;
    $post_statuses = array('publish' => 'Approved', 'draft' => 'Rejected', 'private' => 'Pending');
    if (isset($posts[0]->ID) > 0)
    {
        $form     = unserialize($term->description);
        foreach ($posts as $post) {
            if($term_id == -1){
                $cur_post_term = wp_get_post_terms($post->ID, $post->post_type);
                $form = unserialize($cur_post_term[0]->description);
            }
            $content = unserialize($post->post_content);
            $date_out = '';
            foreach ($form['input'] as $inp) {
                if ($inp['type']==7)
                    $date_in = (isset($content[TF_THEME_PREFIX . '_' . $inp['shortcode']])) ? $content[TF_THEME_PREFIX . '_' . $inp['shortcode']] : '-';
                if($inp['type']==8)
                    $date_out = (isset($content[TF_THEME_PREFIX . '_' . $inp['shortcode']])) ? $content[TF_THEME_PREFIX . '_' . $inp['shortcode']] : '';
            }
            $edit_url = get_admin_url() . 'admin.php?page=tf_reservations_list&id=' . $post->ID;
            ?>
        <tr valign="top"
            class="<?php if ($alternate++ % 2 == 0) { ?>alternate<?php } ?>>"
            id="">
            <th class="check-column" scope="row"><input class="checkbox_delete_reservation" type="checkbox"
                                                        value="<?php echo $post->ID ?>" name="forms"></th>
            <td>
                <strong>
                    <a href="<?php echo $edit_url; ?>" class="row-title">
                        <?php echo $post->post_title; ?>
                    </a>
                </strong>

                <div class="row-actions">
                            <span class="edit">
                                <a title="Edit this item" href="<?php echo $edit_url; ?>">
                                    Edit
                                </a> |
                            </span>
                            <span class="trash">
                                <a href="#" title="Delete this item" rel="<?php echo $post->ID ?>"
                                   class="tf_delete_reservation">
                                    Delete
                                </a>
                            </span>
                </div>
            </td>
            <td class="date">
                <?php  echo encode_id($post->ID) ?>
            </td>
            <td class="date">
                <?php  echo date_i18n(get_option('date_format'), strtotime(@$date_in)) ?>
            </td>
            <td>
                <?php echo ($date_out !='') ? date_i18n(get_option('date_format'), strtotime($date_out)) : "-";$date_out = ''; ?>
            </td>
            <td>
                <div
                    class="rf_post_status_<?php echo $post->post_status ?>"><?php echo $post_statuses[$post->post_status] ?></div>
            </td>

        </tr>
            <?php
        }
        } else {
        ?>
    <tr>
        <td colspan="4">Nothing found</td>
    </tr>
        <?php } ?>
    </tbody>
</table>
<br/>
<a class="delete_selected_reservations button">Delete Selected</a><a href="#"
                                                                     class="approve_selected_reservations button">Approve</a>
<a href="#" class="reject_selected_reservations button">Reject</a>
