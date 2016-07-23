<?php
//TODO sa traduc descrierea in engleza
/**
    * Daca a fost selectat sa fie imagine in header, optinem imaginea
    * in functia tfuse_get_header_content() ce se afla in 
    * theme_config/theme_includes/THEME_HEADER_CONTENT.php
    * imaginea se transmite prin variabila globala $header_image
    */
    global $header_image;

    if ( !empty($header_image['src']) ) :
?>

    <!-- header image/slider -->
    <div class="container_12">
        <div class="header_flash">

            <?php
                $image  = new TF_GET_IMAGE();
                $tf_img =  $image->width(960)->height(368)->src($header_image['src'])->get_img();

                if ( $header_image['url'] != '')
                    echo '<a href="'.$header_image['url'].'" target="'.$header_image['target'].'">'.$tf_img.'</a>';
                else
                    echo $tf_img;
            ?>
        </div>
    </div>
    <!--/ header image/slider -->

<?php endif; ?>


