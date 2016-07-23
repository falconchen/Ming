<div class="widget-container widget_search">
    <form method="get" id="searchform" action="<?php echo home_url( '/' ) ?>">
        <div>
            <input type="text" value="<?php echo tfuse_options('search_box_text'); ?>" onfocus="if (this.value == '<?php echo tfuse_options('search_box_text'); ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php echo tfuse_options('search_box_text'); ?>';}" name="s" id="s" class="input" />
            <input type="submit" id="searchsubmit"  class="btn-submit" value="<?php _e('Search', 'tfuse') ?>"/>
        </div>
    </form>
    <div class="clear"></div>
</div>
