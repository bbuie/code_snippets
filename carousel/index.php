<script>
// remap jQuery to $
(function($){
	/* trigger when page is ready */
	$(document).ready(function (){		
		$('.bbCarousel').bbCarousel();
	});
	
})(window.jQuery);
</script>


<style>
/*carouselStyles blank*/
body {
	.bbCarousel {
	  -webkit-box-sizing: border-box; /* Safari/Chrome, other WebKit */
	  -moz-box-sizing: border-box;    /* Firefox, other Gecko */
	  box-sizing: border-box;         /* Opera/IE 8+ */

	  .carouselOuter {
	    overflow: hidden;
	  } 
	  .carouselControls {
	    text-align: center;

	    .leftArrow {}
	    .dots {
	      .dot {
	        border: 9px solid white;
	        width: 10px;
	        height: 10px;
	        margin: 0 4px;
	        text-indent: -999em;
	        border: 3px solid #00aeef;
	        display: inline-block;
	        border-radius: 9px;
	        cursor: pointer;
	        vertical-align: middle;
	        @include transition(background, .5s, ease, 0s);

	        &.active {
	          background-color: white;
	          @include box-shadow(0, 0, 3px, white);
	        }
	      }
	    }
	    .rightArrow {}
	  }
	}
}
</style>

<div class='bbCarousel'>
	<div class='carouselOuter'>
		<div class='carouselInner'>
				<div class='item'></div>
		</div>
	</div>
	<div class='carouselControls'>
		<a class='leftArrow' href="">Previous</a> 
		<span class='dots'>
			<!-- dots are appended here by js -->
			<!-- <a class="dot active" href="#dot1">1</a> -->
		</span> 
		<a class="rightArrow" href="">Next</a>
	</div>
</div>