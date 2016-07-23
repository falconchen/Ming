<?php
/**
 * Nivo slider's configurations
 *
 * @since Envision 2.0
 */

$options = array(
    'tabs' => array(
        array(
            'name' => 'Slider Settings',
            'id' => 'slider_settings', #do no t change this ID
            'headings' => array(
                array(
                    'name' => 'Slider Settings',
                    'options' => array(
                        array('name' => 'Slider Title',
                            'desc' => 'Change the title of your slider. Only for internal use (Ex: Homepage)',
                            'id' => 'slider_title',
                            'value' => '',
                            'type' => 'text',
                            'divider' => true),
                        array('name' => 'Resize images?',
                            'desc' => 'Want to let our script to resize the images for you? Or do you want to have total control and upload images with the exact slider image size?',
                            'id' => 'slider_image_resize',
                            'value' => 'false',
                            'type' => 'checkbox')
                    )
                )
            )
        ),
        array(
            'name' => 'Add/Edit Slides',
            'id' => 'slider_setup', #do not change ID
            'headings' => array(
                array(
                    'name' => 'Add New Slide', #do not change
                    'options' => array(
                        array('name' => 'URL',
                            'desc' => 'When a user will click the image, the browser will load this URL.',
                            'id' => 'slide_url',
                            'value' => '',
                            'type' => 'text',
                            'divider' => true),

                        array('name' => 'TARGET',
                            'desc' => 'Specifies where to open the linked an URL.',
                            'id' => 'slide_target_url',
                            'value' => '_blank',
                            'type' => 'select',
                            'options'	=> array(
                                '_self' => 'Open link in same window',
                                '_blank' => 'Open link in new window'),
                            'divider' => true),
                        // Custom Favicon Option
                        array('name' => 'Image <br />(898px × 362px)',
                            'desc' => 'You can upload an image from your hard drive or use one that was already uploaded by pressing  "Insert into Post" button from the image uploader plugin.',
                            'id' => 'slide_src',
                            'value' => '',
                            'type' => 'upload',
                            'media' => 'image',
                            'required' => TRUE)
                    )
                )
            )
        ),
    )
);
$options['extra_options'] = array();

?>