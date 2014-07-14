<script>
	//object used to organize up your service javascript functionality
	var buie = new Object();	
	
	/* trigger when page is ready */
	$(document).ready(function (){
		buie.sliderInit();
	});

	bigchill.vtgSlider = function(options){
		var vtgSlider = this;
		
		this.defaults = {
			slider: '.banner',
			firstSlide: '.one',
			sliderImage: '.bannerImg'
		}
				
		var settings = $.extend({},this.defaults, options);	

		if($(settings.slider).length){
			$(settings.slider).each(function(){
				bigchill.sliderDeterminLoadType($(this), settings);				
			});
		}
	};
	bigchill.sliderDeterminLoadType = function(banner, settings){
		if(banner.find('ul '+ settings.firstSlide + ' '+ settings.sliderImage).height() > 30){
			bigchill.loadUnslider(banner);
		} else {
			banner.find('ul '+ settings.firstSlide + ' '+ settings.sliderImage).on('load', function(){
				bigchill.loadUnslider(banner);
			});
		}
	};
	bigchill.loadUnslider = function(banner){		

		var sliderBoxUnslider = banner.unslider({
			speed: 600,               //  The speed to animate each slide (in milliseconds)
			delay: 7000,              //  The delay between slide animations (in milliseconds)
			complete: function() {},  //  A function that gets called after every slide animation
			keys: true,               //  Enable keyboard (left, right) arrow shortcuts
			dots: true,               //  Display dot navigation
			fluid: true 
		});
	};
</script>