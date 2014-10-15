<script>
	
// remap jQuery to $
(function($){

	//trigger on resize
	$(window).resize(function() {
		customApp.viewportWidth = $(window).width();
		customApp.viewportHeight = $(window).height();
		customApp.checkBreakpointLoaded();
		var viewChangeTimeout;
		if(customApp.currentView != customApp.loadedView) {
			customApp.loadedView = customApp.currentView;
			customApp.changeViewLoaded();			
		}
	});

	customApp.changeViewLoaded = function()
		{
			//use this function to perform any changes to the view based on breakpoint changes
		}
	customApp.checkBreakpointLoaded = function()
		{
			for (var breakpoint in customApp.breakPoints) {
				if(customApp.viewportWidth < customApp.breakPoints[breakpoint].maxWidth){
					customApp.currentView = breakpoint;				
				}
			}
			if($('.ie8').length){
				customApp.currentView = 'desktop';
			}
		}		
	customApp.setViewportVariables = function()
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
		}
	customApp.setViewportVariables();
	
	//need to add function for resizing
	
	customApp.loadResponsiveImages = function(callback)
		{
			$("img[responsiveImg='1']").each(function(){
				var me = $(this);
				var srcAttr = 'src-'+customApp.currentView;

				var src = me.attr(srcAttr);
				var currentSrc = me.attr('src');

				//loop through all breakpoints to show the smallest image that is bigger than the breakpoint
				var loopCount = 0;
				var nextView = customApp.breakPoints[customApp.currentView].next;		
				while(!src && nextView != false){	
					//prevent an infinite loop
					if(loopCount > 10){
						break;
					}
					srcAttr = 'src-'+nextView;
					src = me.attr(srcAttr);
					nextView = customApp.breakPoints[nextView].next;
					loopCount++;
				}
				if(src && src != currentSrc){
					me.attr('src',src);
				}
			});
			if(callback){
				callback();
			}
		}
	
})(window.jQuery);
</script>

<style>
/*
 * TABLE OF CONTENTS
 * 
 * tabletPortraitStyles
 * mobileStyles
 */


/*
 * tabletPortraitStyles *****************************************
 */
@media only screen and (max-width: 1023px) {
}

/*
 * mobileStyles
 */
@media only screen and (max-width: 767px) {
}

</style>


<!-- start html for responsive img, IMPORTANT! img-desktopWide is the fallback -->
<img 
	alt='' 
	responsiveImg='1'
	src=''							
	src-phone=''
	src-phoneLandscape=''
	src-tablet=''
	src-tabletLandscape=''
	src-desktop=''
	src-desktopWide=''	
/>