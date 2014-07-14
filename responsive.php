<script>
	
// remap jQuery to $
(function($){
		
	uys.setViewportVariables = function(){
		uys.viewportWidth = $(window).width();
		uys.viewportHeight = $(window).height();
		uys.breakPoints = {
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
		uys.responsiveView = 'desktop';
		uys.viewLoaded = 'desktop';
		for (var breakpoint in uys.breakPoints) {
			if(uys.viewportWidth <= uys.breakPoints[breakpoint].maxWidth){
				uys.responsiveView = breakpoint;
				uys.viewLoaded = breakpoint;
			}
		}
	}
	uys.setViewportVariables();
	
	//need to add function for resizing
	
	buie.loadResponsiveImages = function(callback){
		$("img[responsiveImg='1']").each(function(){
			var newImgSrcAttr = 'img-'+buie.responsiveView;		
			var newImgSrc = $(this).attr(newImgSrcAttr); //this finds the source link using the attribute data-desktopImg, data-tabletImg, or data-mobileImg
			var currentImgSrc = $(this).attr('src');
			var loopCount = 0;
			while(!newImgSrc && buie.responsiveView != 'desktop'){	
				//prevent an infinite loop
				if(loopCount > 10){
					break;
				}
				newImgSrcAttr = 'img-'+buie.breakPoints[buie.responsiveView].next;
				newImgSrc = $(this).attr(newImgSrcAttr); //this finds the source link using the attribute data-desktopImg, data-tabletImg, or data-mobileImg
			loopCount++}
			if(newImgSrc && newImgSrc != currentImgSrc){
				$(this).attr('src',newImgSrc);
			}
		});
		buie.viewLoaded = buie.responsiveView;
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