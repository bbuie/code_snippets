<script>
// remap jQuery to $
(function($){
	
	/* trigger when page is ready */
	$(document).ready(function (){
		//add screen saver
		buie.screenSaverInit();
	});

	buie.screenSaverInit = function(){
		buie.screenSaver = $('.screenSaver');
		buie.screenSaverTransitionDelay = 7000;//7 seconds
		buie.screenSaverInitDelay = 200000;//20 seconds
		buie.screenSaverFadeDelay = 800;
		//start the screensaver after a delay
		buie.screenSaverTimeout = setTimeout(function(){
	        buie.screenSaverStart();
	    }, buie.screenSaverInitDelay);
	    //restart the timeout and stop the slideshow if user's mouse moves
		$('body').mousemove(function() {
		    clearTimeout(buie.screenSaverTimeout);
		
		   	buie.screenSaverTimeout = setTimeout(function(){
		        buie.screenSaverStart();
		    }, buie.screenSaverInitDelay);
		
		   	buie.screenSaverStop();
		});
	}
	buie.screenSaverTransitionInterval = null;
	buie.screenSaverStart = function(){
		var saver = buie.screenSaver;
		var items = saver.find('.item');
		saver.find('.item').hide();
		var activeItem = items.filter('.active');		
		activeItem.show();
		var activeItemSrc = activeItem.attr('dataSrc');	
		//don't wait for load if image is already loaded
		if(activeItemSrc == activeItem.attr('src')){
			buie.screenSaverSizeImages(activeItem);
			saver.fadeIn(buie.screenSaverFadeDelay);
			//set the slideshow interval to show all images in a loop
			buie.screenSaverTransitionInterval = setInterval(function(){
				buie.screenSaverTransition(items);
			}, buie.screenSaverTransitionDelay);
		} else {
			activeItem.show().on('load',function(){
				buie.screenSaverSizeImages(activeItem);
				saver.fadeIn(buie.screenSaverFadeDelay);
				//set the slideshow interval to show all images in a loop
				buie.screenSaverTransitionInterval = setInterval(function(){
					buie.screenSaverTransition(items);
				}, buie.screenSaverTransitionDelay);			
			});
			activeItem.attr('src',activeItem.attr('dataSrc'));
		}
	}
	//show the next slideshow image	
	buie.screenSaverTransition = function(items){
		var itemsLength = items.length -1;
		var activeItem = items.filter('.active');
		var activeIndex = activeItem.index()+1;
		var nextItem = items.filter(':eq('+activeIndex+')');		
		if(activeItem.index() == itemsLength){
			nextItem = items.filter(':eq(0)');
		}
		var nextItemSrc = nextItem.attr('dataSrc');
		//don't wait for image to load if it is already loaded
		if(nextItemSrc == nextItem.attr('src')){
			buie.screenSaverSizeImages(nextItem);
			activeItem.fadeOut(buie.screenSaverFadeDelay, function(){
				activeItem.removeClass('active')
				nextItem.addClass('active');
			});
			nextItem.fadeIn(buie.screenSaverFadeDelay);
		} else {
			nextItem.on('load',function(){
				buie.screenSaverSizeImages(nextItem);
				activeItem.fadeOut(buie.screenSaverFadeDelay, function(){
					activeItem.removeClass('active')
					nextItem.addClass('active');
				});
				nextItem.fadeIn(buie.screenSaverFadeDelay);
			});
			nextItem.attr('src',nextItem.attr('dataSrc'));
		}
	}
	//size the screensaver images to fit the screen
	buie.screenSaverSizeImages = function(image){
		var imageSpirit = new Image();
		imageSpirit.src = image.attr("src");
		
		var imageWidth = imageSpirit.width; //need the raw width due to a jquery bug that affects chrome
		var imageHeight = imageSpirit.height; //need the raw height due to a jquery bug that affects chrome
		var maxWidth = $(window).width();
		var maxHeight = $(window).height();
		var widthRatio = maxWidth / imageWidth;
		var heightRatio = maxHeight / imageHeight;
		var ratio, margin;
		
		if (widthRatio * imageHeight > maxHeight) {
		    ratio = widthRatio;
		    margin = -(((imageHeight * ratio) - maxHeight)/2);
		    //now resize the image relative to the ratio
			image.css({
				'width':maxWidth,
				'margin-top':margin
			});
		} else {			
			ratio = heightRatio; //default to the width ratio until proven wrong
			margin = -(((imageWidth * ratio)- maxWidth)/2);
			image.css({
				'margin-left': margin,
				'width': imageWidth * ratio,
				'height': maxHeight,
				'max-width': 'none',
				'margin-top': 'auto'
			});
		}
	}
	//reset all items if user's mouse moves
	buie.screenSaverStop = function(){
		var items = buie.screenSaver.find('.item');		
		buie.screenSaver.fadeOut(buie.screenSaverFadeDelay, function(){
			items.unbind('load').removeAttr('style');
		});
		clearInterval(buie.screenSaverTransitionInterval);
	}
})(window.jQuery);
</script>

<style>
	.screenSaver {
		display: none;
		position: fixed;
		top: 0;
		left: 0;
		z-index: 100;
	}
	.screenSaver .item {
		display: none;
		position: absolute;
		top: 0;
		left: 0;
	}
	.screenSaver .item.active {
		display: block;
	}
</style>

<div class='screenSaver'>
	<img class='item <?php if($imgCount == 0){echo 'active';} ?>' src='' dataSrc=''/>
</div>