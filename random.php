<script type="text/javascript">
	/* trigger when page is ready */
	$(document).ready(function (){

		//get inputs to select on input focus
		customApp.inputFocus();		

	});
	
	customApp.inputFocus = function(){
		$("input:text").each(function (){
			// store default value
			var v = this.value;

			$(this).blur(function () {
				// if input is empty, reset value to default 
				if (this.value.length == 0) this.value = v;
			}).mouseup(function () {
				// when input is focused, select its contents
				this.select();
			}); 
		});
	}
	customApp.smoothScroll = function()
		{
		    var $window = $(window);
		    var scrollTime = 1.1;
		    var scrollDistance = 400;
		    $window.on("mousewheel DOMMouseScroll", function(event) {
		        event.preventDefault();
		        var delta = event.originalEvent.wheelDelta / 120 || -event.originalEvent.detail / 3;
		        var scrollTop = $window.scrollTop();
		        var finalScroll = scrollTop - parseInt(delta * scrollDistance);
		        TweenMax.to($window, scrollTime, {
		            scrollTo: {
		                y: finalScroll,
		                autoKill: true
		            },
		            ease: Power1.easeOut,
		            overwrite: 5
		        })
		    });			
		}
</script>