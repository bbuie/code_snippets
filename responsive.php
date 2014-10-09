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
			clear.loadedView = clear.currentView;
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
				desktop: {
					maxWidth: 1000000,
					next: undefined
				},
				tabletLandscape: {
					maxWidth: 1024,
					next: 'desktop'
				},
				tablet: {
					maxWidth: 768,
					next: 'tabletLandscape'
				},
				mobileLandscape: {
					maxWidth: 480,
					next: 'tablet'
				},
				mobile: {
					maxWidth: 320,
					next: 'mobileLandscape'
				}			
			}
			customApp.currentView = 'desktop';
			customApp.loadedView = 'desktop';
			for (var breakpoint in customApp.breakPoints) {
				if(customApp.viewportWidth < customApp.breakPoints[breakpoint].maxWidth){
					customApp.currentView = breakpoint;
					customApp.loadedView = breakpoint;
				}
			}
		}
	customApp.setViewportVariables();
	
	//need to add function for resizing
	
	customApp.loadResponsiveImages = function(callback){
		$("img[responsiveImg='1']").each(function(){
			var newImgSrcAttr = 'img-'+customApp.currentView;		
			var newImgSrc = $(this).attr(newImgSrcAttr); //this finds the source link using the attribute data-desktopImg, data-tabletImg, or data-mobileImg
			var currentImgSrc = $(this).attr('src');
			var loopCount = 0;
			while(!newImgSrc && customApp.currentView != 'desktop'){	
				//prevent an infinite loop
				if(loopCount > 10){
					break;
				}
				newImgSrcAttr = 'img-'+customApp.breakPoints[customApp.currentView].next;
				newImgSrc = $(this).attr(newImgSrcAttr); //this finds the source link using the attribute data-desktopImg, data-tabletImg, or data-mobileImg
			loopCount++}
			if(newImgSrc && newImgSrc != currentImgSrc){
				$(this).attr('src',newImgSrc);
			}
		});
		customApp.loadedView = customApp.currentView;
		callback();
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

<img 
	alt='' 
	responsiveImg='1'
	src=''							
	img-mobile=''
	img-tablet=''
	img-desktop=''	
/>