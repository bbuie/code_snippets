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
	customApp.overflowEllipsis = function() 
		{
			var items = $('.overflowEllipsisParent');
			items.each(function(){
				var me = $(this);
				var itemHeight = me.innerHeight();
				var scrollHeight = me[0].scrollHeight;
				if(itemHeight < scrollHeight) {
					me.find('.overflowEllipsis').show();
				}
			});
		}
</script>

<!-- html for overflowEllipsis -->
<style type="text/css">
	.overflowEllipsisParent {
		max-height: 113px;
		min-height: 113px;
		overflow: hidden;
		position: relative;
	}
	.overflowEllipsis {
		display: none;
		background: url('../../images/overflowEllipsis.png');
		background-repeat: repeat-y;
		position: absolute;
		bottom: 0;
		padding-left: 86px;
		width: 100%;				
	}
</style>
<div class='overflowEllipsisParent'>
	<div class='overflowEllipsis'>&#8230;</div>
</div>

<!-- addthis sharing buttons -->
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js" async="async"></script>
<div class="addthis_toolbox addthis_32x32_style"> 
	<a class="addthis_button_facebook"></a>
	<a class="addthis_button_twitter"></a>
	<a class="addthis_button_google_plusone_share"></a>						
	<a class="addthis_button_pinterest_share"></a>							
	<a class="addthis_counter addthis_bubble_style"></a>
</div>