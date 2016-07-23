<?php
header('Content-type:text/xml');
?>
<?php echo '<?xml version="1.0" encoding="utf-8" ?>'; ?>
<config version="1.0.0">
	<settings>
		<!--
			autoresize:
				- true: the slideshow will have the sizes provided in the embedded code
				- false: the slideshow will have the sizes that are set with the "width" and "height" parameters (usually it is used when you want to load the slideshow in another swf file)
			width: the slideshow's width (it is used only if autoresize is set to "false")
			height: the slideshow's height (it is used only if autoresize is set to "false")
		-->
		<size
			autoResize="true"
			width="640"
			height="480"
		/>

		<!--
			autoPlay: if it is set to true, the items will switch automatically if the mouse is not over an item, after a number of seconds set in the "delay" parameter
			delay: the number of seconds after the current item is replaced by the next one (it is used only if autoPlay is set to "true")

			loop: set this parameter to true if you want the items to appear continuously
			startDirection: set from which direction (i.e. "right" or "left") the slideshow will move when it starts the autoPlay (it is used only if autoPlay is set to "true")

			bounce: a value from 0 to 100 that is used for a bounce effect before the items are placed in the final position
			speed: a value from 0 to 100 that is used for the speed with which the items change their positions

			startItem: set which item you want to be placed in front when the slideshow appears (the items are numerated starting from 0)
		-->
		<slider
			autoPlay="true"
			delay="5"

			loop="true"
			startDirection="right"

			bounce="55"
			speed="20"

			startItem="0"
		/>

		<!--
			fonts: set the fonts that you want the slideshow to load; the fonts need to be comma separated (e.g. "Arial,Georgia,Verdana"); each font needs to have a corresponding swf file placed in the "fonts" folder
		-->
		<fonts
			fonts="Georgia"
		/>
	</settings>

	<skin>
		<!--
			bck: set the background of the slideshow; the value can be a color (e.g. "0xE8E8E8") or the path to an image (e.g. "images/bck.jpg")
			cornerRadius: if you want round corners for your slideshow set here the radius value for the corners

			yOffset: if you do not want the items in the middle of the slideshow, you can adjust the displacement by changing this parameter

			cameraY: you can change the view position on the vertical axe
		-->
		<slideshow
			bck="images/bck.png"
			cornerRadius="0"

			yOffset="-7"

			cameraY="-5"
		/>

		<!--
			bck: set the background of the items; the value can be a color or the path to an image
			width: the width of each item
			height: the height of each item
			depth: the depth of each item
			hSpace: the space between the items on the horizontal plan
			vSpace: the space between the items on the vertical plan
			dSpace: the space between the items on the depth plan
			scale: the percentage with which an item will be smaller than the one in front of it
			frontPadding: you are able to set a "frame" for the image that is displayed on an item
			frontAngle: the angle for the item that is displayed on the front of all the others
			maxAngle: the maximum angle for the items that are behind the item in the very front
			displayedNo: the number of items that are visible

			shadowColor: the item's shadow color
			shadowAlpha: the item's shadow alpha
			shadowDistance: the item's shadow distance
			shadowAngle: the item's shadow angle
			shadowSize: the item's shadow size

			reflectionSize: the percentage, from 0 to 100, from the item that you desire to be reflected
			reflectionAlpha: the transparency value, from 0 to 100, from which you want to start the reflection
		-->
		<items
			bck="images/bgitem.jpg"
			width="430"
			height="329"
			depth="20"
			hSpace="300"
			vSpace="-240"
			dSpace="320"
			scale="10"
			frontPadding="0"
			frontAngle="-17"
			maxAngle="36"
			displayedNo="5"

			shadowColor="0x000000"
			shadowAlpha="55"
			shadowDistance="2"
			shadowAngle="75"
			shadowSize="4"

			reflectionSize="15"
			reflectionAlpha="5"
		/>

		<!--
			font: the preloader's font
			size: the preloader's size
			color: the preloader's color
		-->
		<preloader
			font="Georgia"
			size="17"
			color="0xa9a8a2"
		/>
	</skin>

	<?php
    require_once( '../../../../../../../../wp-load.php');

    global $TFUSE;

	$darr = explode(",", $TFUSE->request->GET('d'));
	$post_ID = $darr[1];
	$slide  = $darr[2];

    $slider = $TFUSE->ext->slider->model->get_slider($slide);  ?>

	<items>
	
		<!--
			Here you can set the items that appear in the slidehshow.
			path: the path to the image that you want to appear on an item
			link: the link where to navigate when you click on the item that is in the front position
			target: the target (i.e. "_self", "_blank", "_parent" or "_top") where you want the page from the link to be opened
		-->

		<?php foreach ($slider['slides'] as $slide) :

			 $img_slider = explode("wp-content", $slide['slide_src']);
			if (is_multisite() && !isset($img_slider[1])){
                $img_slider = explode("/files/", $slideArr['img']);
                $img_slider[1] = '/files/'.$img_slider[1];
            }
			if ( $slide['slide_url'] != '') { ?>
				<item path="../../../../../../../..<?php echo $img_slider[1]; ?>" link="<?php echo $slide['slide_url']; ?>" target="<?php echo $slide['slide_target_url']; ?>"/>
			<?php
			} else {
			?>
				<item path="../../../../../../../..<?php echo $img_slider[1]; ?>" link="#" target="_blank"/>
			<?php }
		  endforeach; ?>

	</items>
</config>
