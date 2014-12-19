<script>
	
// remap jQuery to $
(function($){
	
	customApp.breakpointsInit = function(options)
		{
			//object for organizing code
			var breakpointsInit = new Object();

			//default options
			var defaults = {
				desktopMaxWidth: 1200,
				tabletLandscapeMaxWidth: 1024,
				tabletMaxWidth: 768,
				phoneLandscapeMaxWidth: 480,
				phoneMaxWidth: 320
			}

			//buid settings based on defaults and options
			var settings = $.extend({}, defaults, options);

			breakpointsInit.setup = function()
				{
					customApp.viewportWidth = $(window).width();
					customApp.viewportHeight = $(window).height();
					customApp.breakPoints = {
						desktopWide: {
							maxWidth: 1000000,
							next: false
						},
						desktop: {
							maxWidth: settings.desktopMaxWidth,
							next: 'desktopWide'
						},
						tabletLandscape: {
							maxWidth: settings.tabletLandscapeMaxWidth,
							next: 'desktop'
						},
						tablet: {
							maxWidth: settings.tabletMaxWidth,
							next: 'tabletLandscape'
						},
						phoneLandscape: {
							maxWidth: settings.phoneLandscapeMaxWidth,
							next: 'tablet'
						},
						phone: {
							maxWidth: settings.phoneMaxWidth,
							next: 'phoneLandscape'
						}			
					}
					for (var breakpoint in customApp.breakPoints) {
						if(customApp.viewportWidth <= customApp.breakPoints[breakpoint].maxWidth){
							customApp.currentView = breakpoint;
							customApp.loadedView = breakpoint;
						}
					}
					breakpointsInit.resize()
				}
			breakpointsInit.checkBreakpointLoaded = function()
				{
					for (var breakpoint in customApp.breakPoints) {
						if(customApp.viewportWidth <= customApp.breakPoints[breakpoint].maxWidth){
							customApp.currentView = breakpoint;				
						}
					}
					if($('.ie8').length){
						customApp.currentView = 'desktop';
					}
				}
			breakpointsInit.resize = function()
				{
					$(window).resize(function() {		
						customApp.viewportWidth = $(window).width();
						customApp.viewportHeight = $(window).height();
						customApp.breakpointsInitObj.checkBreakpointLoaded();
						if(customApp.currentView != customApp.loadedView) {
							customApp.loadedView = customApp.currentView;
							customApp.breakpointsViewChange();			
						}
					});
				}
			breakpointsInit.setup();
			customApp.breakpointsInitObj = breakpointsInit;
		}
	customApp.breakpointsInit();
	customApp.breakpointsViewChange = function()
		{
			//use this function to perform any changes to the view based on breakpoint changes

			//change responsive images
			//customApp.breakpointImagesObj.emptySrc();
			//customApp.breakpointImages();
		}	
	customApp.breakpointImages = function(callback)
		{
			//object for organizing code
			var breakpointImages = new Object();

			breakpointImages.setup = function()
				{
					//load first priority images
					$("img[responsiveImg='1']").each(function(){
						var me = $(this);
						breakpointImages.loadImages(me)
					});
					//run callback after first priority images are loaded
					if(callback){
						callback();
					}
					//load second priority images
					$("img[responsiveImg='2']").each(function(){
						var me = $(this);
						breakpointImages.loadImages(me)
					});
				}
			breakpointImages.loadImages = function($image)
				{
					var srcAttr = 'src-'+customApp.currentView;
					var src = $image.attr(srcAttr);
					var currentSrc = $image.attr('src');

					//loop through all breakpoints to show the smallest image that is bigger than the breakpoint
					var loopCount = 0;
					var nextView = customApp.breakPoints[customApp.currentView].next;		
					while(!src && nextView != false){	
						//prevent an infinite loop
						if(loopCount > 10){
							break;
						}
						srcAttr = 'src-'+nextView;
						src = $image.attr(srcAttr);
						nextView = customApp.breakPoints[nextView].next;
						loopCount++;
					}
					//set the source if it is different from current and if one was found
					if(src && src != currentSrc){
						$image.attr('src',src);
					}
				}
			breakpointImages.emptySrc = function()
				{					
					$("img[responsiveImg='1'], img[responsiveImg='2']").each(function(){
						var me = $(this);
						me.attr('src', '');
					});
				}
			breakpointImages.setup();
			customApp.breakpointImagesObj = breakpointImages;		
		}
	customApp.setFullpageElement = function(options)
		{
			//object for organizing calculations
			var sfe = new Object();

			//default options
			var defaults = {
				contentElement: false, //the element which should fill the page
				wrapperElement: false, //the wrapper element, note this should have overflow hidden
				verticalPaddingSelectors: false, //comma separated list of selectors that should reduce the vertical height of the full page element
				debug: false
			}

			//buid settings based on defaults and options
			var settings = $.extend({}, defaults, options);			

			//remove old styles from element or wrapper
			settings.wrapperElement.add(settings.contentElement).removeAttr('style');

			//find the vertical padding that needs to reduce the maxHeight
			sfe.verticalPadding = 0;
			if(settings.verticalPaddingSelectors){
				var verticalPaddingElements = $(settings.verticalPaddingSelectors);
				verticalPaddingElements.each(function(){
					var me = $(this);
					var outerHeight = me.outerHeight();
					sfe.verticalPadding = sfe.verticalPadding + outerHeight;
				});
			}

			//set all variables
			sfe.contentHeight = settings.contentElement.outerHeight();
			sfe.contentWidth = settings.contentElement.outerWidth();
			sfe.viewportWidth = $(window).width();
			sfe.viewportHeight = $(window).height();
			sfe.maxHeight = sfe.viewportHeight - sfe.verticalPadding;
			sfe.maxWidth =  sfe.viewportWidth;
		    sfe.scaleHeight = (sfe.contentHeight * sfe.maxWidth) / sfe.contentWidth; //scale the height while keeping the width at max width
		    sfe.scaleWidth = (sfe.contentWidth * sfe.maxHeight) / sfe.contentHeight; //scale the width while keeping the height at max height

		    //if the scale width is greater than the max width, then we need to crop the sides
		    sfe.scaleOnWidth = (sfe.scaleWidth > sfe.maxWidth);
		    if (sfe.scaleOnWidth) {
		    	sfe.width = Math.floor(sfe.scaleWidth);
		    	sfe.height = Math.floor(sfe.maxHeight);
		    	sfe.crop = 'sides';        
		    } else {
		        sfe.width = Math.floor(sfe.maxWidth);
		        sfe.height = Math.floor(sfe.scaleHeight);
		        sfe.crop = 'top'; 
		    }
		    sfe.marginLeft = Math.floor((sfe.maxWidth - sfe.width) / 2);
		    sfe.marginTop = Math.floor((sfe.maxHeight - sfe.height) / 2);
		    if(settings.debug){
		    	console.log(' sfe.maxWidth '+sfe.maxWidth+' sfe.maxHeight '+sfe.maxHeight);
		    	console.log(' sfe.scaleWidth '+sfe.scaleWidth+' sfe.scaleHeight '+sfe.scaleHeight);
		    	console.log(sfe);
		    }	

		    if(sfe.crop == 'top')  {
			    //now resize the image relative to the ratio
				settings.contentElement.attr('crop', 'top')
					.css({
						'margin-top': sfe.marginTop,
						'height': sfe.height,
						'width': sfe.width, 
						'min-width': '100%',
						'max-width': '100%',
						'min-height': 'none',
						'max-height': 'none'
					});				    
				settings.wrapperElement.css('height', sfe.maxHeight);
			} else {
				settings.contentElement .attr('crop', 'sides')
					.css({
						'margin-left': sfe.marginLeft,
						'height': sfe.height,
						'width': sfe.width, 
						'min-width': 'none',
						'max-width': 'none',
						'min-height': '100%',
						'max-height': '100%'
					});
				settings.wrapperElement.css('height', sfe.maxHeight);
			}
		}
	
})(window.jQuery);
</script>


<!-- start html for responsive img, IMPORTANT! img-desktopWide is the fallback -->
<!-- responsiveImg = 1 for high priority image -->
<img 
	src=''
	alt='' 
	responsiveImg='1'								
	src-phone=''
	src-phoneLandscape=''
	src-tablet=''
	src-tabletLandscape=''
	src-desktop=''
	src-desktopWide=''	
/>
<!-- responsiveImg = 2 for low priority image -->
<img 
	src=''
	alt='' 
	responsiveImg='2'								
	src-phone=''
	src-phoneLandscape=''
	src-tablet=''
	src-tabletLandscape=''
	src-desktop=''
	src-desktopWide=''	
/>