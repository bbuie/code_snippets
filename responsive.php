<script>
	
// remap jQuery to $
(function($){

	//trigger on resize
	$(window).resize(function() {
		clear.viewportWidth = $(window).width();
		clear.viewportHeight = $(window).height();
	});
		
	customApp.setViewportVariables = function()
		{
			customApp.viewportWidth = $(window).width();
			customApp.viewportHeight = $(window).height();
			customApp.breakPoints = {
				desktop: {
					maxWidth: 1000000,
					next: undefined
				},
				tablet: {
					maxWidth: 1023,
					next: 'desktop'
				},
				mobile: {
					maxWidth: 767,
					next: 'tablet'
				}			
			}
			customApp.responsiveView = 'desktop';
			customApp.viewLoaded = 'desktop';
			for (var breakpoint in customApp.breakPoints) {
				if(customApp.viewportWidth <= customApp.breakPoints[breakpoint].maxWidth){
					customApp.responsiveView = breakpoint;
					customApp.viewLoaded = breakpoint;
				}
			}
		}
	customApp.setViewportVariables();
	
	//need to add function for resizing
	
	customApp.loadResponsiveImages = function(callback){
		$("img[responsiveImg='1']").each(function(){
			var newImgSrcAttr = 'img-'+customApp.responsiveView;		
			var newImgSrc = $(this).attr(newImgSrcAttr); //this finds the source link using the attribute data-desktopImg, data-tabletImg, or data-mobileImg
			var currentImgSrc = $(this).attr('src');
			var loopCount = 0;
			while(!newImgSrc && customApp.responsiveView != 'desktop'){	
				//prevent an infinite loop
				if(loopCount > 10){
					break;
				}
				newImgSrcAttr = 'img-'+customApp.breakPoints[customApp.responsiveView].next;
				newImgSrc = $(this).attr(newImgSrcAttr); //this finds the source link using the attribute data-desktopImg, data-tabletImg, or data-mobileImg
			loopCount++}
			if(newImgSrc && newImgSrc != currentImgSrc){
				$(this).attr('src',newImgSrc);
			}
		});
		customApp.viewLoaded = customApp.responsiveView;
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