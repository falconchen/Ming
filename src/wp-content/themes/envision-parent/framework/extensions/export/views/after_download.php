<?php
if ( is_wp_error( $this->export->tf_export_file ) )
{
    echo '<img class="tfuse_install_icon" src="' . TFUSE_ADMIN_IMAGES . '/warning.png" width="35" height="35" />
    <h3>Export Failed</h3>
    <p>';
    _e( 'Failed to export XML file', 'wordpress-importer' );
    echo ': ' . $this->export->tf_export_file->get_error_message();
    echo '</p>';
    return;
}
?>
<img class="tfuse_install_icon" src="<?php echo TFUSE_ADMIN_IMAGES . '/happy.png' ?> " width="32" height="32" />
<h3>Export Done</h3>
<p>Your exported folder is located here: <span><?php echo $this->export->upload_basedir ?></span><br />
Once you've saved this folder on your computer (via FTP) you can upload it (via FPT) and replace the <span>Install</span> folder<br />
of another WordPress powered website. Now you can use the Import function to import all your data in the new website.
</p>