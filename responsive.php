<script>
	
// remap jQuery to $
(function($){
	
	customApp.breakpointsInit = function()
		{
			//object for organizing code
			var breakpointsInit = new Object();

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
							maxWidth: 1200,
							next: 'desktopWide'
						},
						tabletLandscape: {
							maxWidth: 1024,
							next: 'desktop'
						},
						tablet: {
							maxWidth: 768,
							next: 'tabletLandscape'
						},
						phoneLandscape: {
							maxWidth: 480,
							next: 'tablet'
						},
						phone: {
							maxWidth: 320,
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