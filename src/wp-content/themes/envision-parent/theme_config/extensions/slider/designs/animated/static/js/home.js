function load_animations(){
		    var $j = jQuery.noConflict();
			if (!$j.browser.msie) {
				$j('#header_images').css({height: '468px', opacity:'0'})
				$j('#aside2').css({height:'558px', opacity:'0'});
				$j('#overlay_bg').css({height:'468px'});

				$j('#header_controls_left').animate({opacity:'1'});
				$j('#header_controls_right').animate({opacity:'1'});

				$j('#header_images').stop().animate({opacity:'1'},400,'easeOutQuad');
				$j('#header_images > .header_image:first-child').stop().animate({opacity: '1'},400,'easeOutQuad');
				$j('#aside2').stop().animate({opacity:'1'},400,'easeOutQuad');

			}
			else{
				$j('#header_images').css({height: '468px'});
				$j('#aside2').css({height:'558px'});
				$j('#overlay_bg').css({height:'468px'});
				$j('#header_images .header_image').stop().animate({opacity:'0'},0);
				$j('#header_images .header_image:first-child').stop().animate({opacity:'1'},0);
			}

		/// end animation in ///
		var header_count = $j("#header_images > .header_image").size();
		var current_project = 1;
		var header_color = $j('.header_image').attr('color');

     	$j('#aside2').css({'background-image':'none','background-color':header_color});


		if (!$j.browser.msie) {
			$j('#overlay_bg')
			.click(function(event){
				var link_target = $j('#header_images > img:nth-child('+current_project+')').attr('target');
				if(link_target == '_blank') {
					window.open($j('#header_images > img:nth-child('+current_project+')').attr('link'));
				} else {
					window.location=($j('#header_images > img:nth-child('+current_project+')').attr('link'));
				}

			});
		} else	{
			$j('.header_image')
			.click(function(event){
				var link_target = $j('#header_images > img:nth-child('+current_project+')').attr('target');
				if(link_target == '_blank') {
					window.open($j('#header_images > img:nth-child('+current_project+')').attr('link'));
				} else {
					window.location=($j('#header_images > img:nth-child('+current_project+')').attr('link'));
				}

			});
		}

		$j('#aside2')
		.hover(
		function(event){
		$j('#header_controls_left').show();
		$j('#header_controls_right').show();
		if (!$j.browser.msie) {
			$j('#header_controls_left').stop().animate({left:'0px'},200,'easeOutQuad');
			$j('#header_controls_right').stop().animate({right:'0px'},200,'easeOutQuad');
		}},
		function(event){
		$j('#header_controls_left').hide();
		$j('#header_controls_right').hide();
		if (!$j.browser.msie) {
			$j('#header_controls_left').stop().animate({left:'10px'},300,'easeOutQuad');
			$j('#header_controls_right').stop().animate({right:'10px'},300,'easeOutQuad');
		}})

		$j('#header_controls_right').click(function(event){animate_header('right',0);clearInterval(interval_header);})

		$j('#header_controls_left').click(function(event){animate_header('left',0);clearInterval(interval_header);})

		document.onkeyup = handleArrowKeys;

		function handleArrowKeys(evt) {
		if (evt.keyCode == 37){animate_header('left',0);clearInterval(interval_header);}
		if (evt.keyCode == 39){animate_header('right',0);clearInterval(interval_header);}
		}


		function animate_header(direction,project){
		if (!$j.browser.msie) {
			$j('#header_images > .header_image:nth-child('+current_project+')').stop().animate({opacity:'0',marginLeft:'-100px',marginTop:'-50px',width:'1210px',height:'590px'},250,'easeInQuad', function(){
			$j(this).css({marginLeft:'0px',marginTop:'0px',width:'960px',height:'468px'});



			if(direction == 'logo'){current_project = project};
			if(direction == 'left'){current_project--};
			if(direction == 'right'){current_project++};
			if(current_project>header_count){current_project=1};
			if(current_project<1){current_project=header_count};


			var new_color = $j('#header_images > .header_image:nth-child('+current_project+')').attr('color');
			//$j('#aside2').animate({backgroundColor:new_color},80,'easeOutQuart');
			$j('#aside2').css({backgroundColor: new_color});
			$j('#header_images > .header_image:nth-child('+current_project+')').css({marginLeft:'100px',marginTop:'50px',width:'760px',height:'340px'});
			$j('#header_images > .header_image:nth-child('+current_project+')').stop().animate({opacity: '1',marginLeft:'0',marginTop:'0',width:'960px',height:'468px'},250,'easeOutQuad');
			});
		}
		else{
			$j('#header_images > .header_image:nth-child('+current_project+')').stop().animate({opacity:'0'},150,'easeInQuad', function(){

			if(direction == 'logo'){current_project = project};
			if(direction == 'left'){current_project--};
			if(direction == 'right'){current_project++};
			if(current_project>header_count){current_project=1};
			if(current_project<1){current_project=header_count};

			var new_color = $j('#header_images > .header_image:nth-child('+current_project+')').attr('color');
			//$j('#aside2').animate({backgroundColor: new_color},80,'easeOutQuart');
			$j('#aside2').css({backgroundColor: new_color}).css("filter","none");
			$j('#header_images > .header_image:nth-child('+current_project+')').stop().animate({opacity: '1'},150,'easeInQuad');
			});
		}
		}

		var interval_header = setInterval(timerFunction, 6000);

		function timerFunction(){
		animate_header('right',0);
		}
}
