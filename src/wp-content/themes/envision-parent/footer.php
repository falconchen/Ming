<div class="footer">
    <div class="footer_bg">
        <div class="container_12">
        <?php
            $tf_soc = tfuse_footer_social('<div class="col_2_3 col"><div class="inner">','</div></div>', true);
            tfuse_footer();
        ?>
        <div class="divider_space"></div>
        <?php echo $tf_soc; ?>
        <div class="col_1_3 col">
            <div class="inner">
                <p class="copyright <?php echo (!$tf_soc) ? 'copyrightStatic':'';?>"><?php echo tfuse_options('custom_copyright'); ?></p>
            </div>
        </div>
        <div class="clear"></div>
        </div>
    </div>
</div>
<?php wp_footer(); ?>
</body>
</html>