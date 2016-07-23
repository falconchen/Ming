<input id="slider_uniqid" type="hidden" value="<?php echo (isset($slider['id']) ? $slider['id'] : null); ?>"/>
<input type="hidden" id="slider_design" value="<?php echo $this->ext->slider->design; ?>"/>
<input type="hidden" id="slider_type" value="<?php echo $this->ext->slider->type; ?>"/>
<div class="slide_options_box">
    <input type="button" class="button" id="save_slider" value="<?php print apply_filters('tf_ext_slider_save_slider_text', 'Save Slider'); ?>"/>
    <input type="button" class="button reset-button" id="cancel_slider" value="<?php print apply_filters('tf_ext_slider_cancel_slider_changes_text', 'Cancel Slider Changes'); ?>"/>
</div>
<div class="frame_box_buttons">
    <a id="add_slide" class="button"><?php print apply_filters('tf_ext_slider_add_slide_text', 'Add Slide'); ?></a>
    <a id="save_changes_slide" class="button">Save Changes</a>
    <a id="cancel_changes_slide" class="button">Cancel Changes</a>
</div>