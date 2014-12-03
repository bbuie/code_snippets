<script>
// remap jQuery to $
(function($){
	/* trigger when page is ready */
	$(document).ready(function (){		
		$('.vtgCarousel').vtgCarousel();
	});
	
	$.fn.vtgCarousel = function(options) {
	    var vtgCarousel = new Object();
	    
	    var defaults = {
	        outerBoxClass: '.outerBox', 
	        innerBoxClass: '.innerBox',
	        itemClass: '.item',
	        nextClass: '.rightArrow',
	        prevClass: '.leftArrow'
	    } 

	    var settings = $.extend({},defaults, options);
	    
	    vtgCarousel.init = function(el)
	        {
	            vtgCarousel.el = el;
	            vtgCarousel.innerBox = vtgCarousel.el.find(settings.innerBoxClass);
	            vtgCarousel.outerBox = vtgCarousel.el.find(settings.outerBoxClass);
	            vtgCarousel.items = vtgCarousel.el.find(settings.itemClass);                

	            vtgCarousel.setcss();
	            vtgCarousel.bindEvents(); 
	            vtgCarousel.onresize()         
	            return vtgCarousel;
	        }
	    vtgCarousel.setcss = function()
	        {
	            vtgCarousel.items.removeAttr('style');
	            vtgCarousel.innerBox.removeAttr('style');

	            //find width of item to set inner box width
	            vtgCarousel.itemWidth = vtgCarousel.items.first().outerWidth() + 2;       
	            vtgCarousel.itemCount = vtgCarousel.items.length;
	            vtgCarousel.innerBoxWidth = vtgCarousel.itemWidth * vtgCarousel.itemCount;
	            vtgCarousel.items.css('width', vtgCarousel.itemWidth);
	            vtgCarousel.innerBox.css('width',vtgCarousel.innerBoxWidth);
	            
	            //find the number of visible items
	            vtgCarousel.outerBoxWidth = vtgCarousel.outerBox.outerWidth();
	            vtgCarousel.visibleItems = Math.round(vtgCarousel.outerBoxWidth / vtgCarousel.itemWidth);  
	        }
	    vtgCarousel.bindEvents = function()
	        {
	            vtgCarousel.el.find(settings.nextClass).click(function(e){
	                e.preventDefault();
	                vtgCarousel.move('next');
	            });
	            vtgCarousel.el.find(settings.prevClass).click(function(e){
	                e.preventDefault();
	                vtgCarousel.move('prev');
	            });
	        }
	    vtgCarousel.move = function(direction)
	        {               
	            var marginLeft = parseInt(vtgCarousel.innerBox.css('margin-left'));
	            var maxAllowableMargin = -(vtgCarousel.innerBoxWidth - ((vtgCarousel.visibleItems-1) * vtgCarousel.itemWidth));
	            var newMargin;
	            if(direction == 'next'){                    
	                newMargin = (marginLeft - vtgCarousel.itemWidth - 1);
	                if(newMargin <= maxAllowableMargin){
	                    newMargin = 0;
	                }   
	            } else {
	                newMargin = (marginLeft + vtgCarousel.itemWidth - 1);
	                if(newMargin >= 0){
	                    newMargin = -(vtgCarousel.innerBoxWidth - ((vtgCarousel.visibleItems) * vtgCarousel.itemWidth));
	                }
	            }
	            vtgCarousel.innerBox.animate({'margin-left': newMargin}, 500);
	        }
	    vtgCarousel.onresize = function()
	        {
	            $(window).resize(function() {
	                vtgCarousel.setcss();
	            });
	        }

	    var len = this.length;
	    return this.each(function(index) { 
	        var me = $(this);
	        var instance = vtgCarousel.init(me);
	        me.data('vtgcarousel' + (len > 1 ? '-' + (index + 1) : ''), instance);     
	    });
	};
})(window.jQuery);
</script>


<style>
/*
 * carouselStyles *************************************************************
 */
.vtgCarousel {
	width: 100%;
}
.vtgCarousel .leftArrow, .vtgCarousel .rightArrow {
	margin-top: 77px;
}
.vtgCarousel .leftArrow {
	float: left;
	width: 6%;
	display: block;
}
.vtgCarousel .leftArrow img {
	float: right;
}
.vtgCarousel .outerBox {
	float: left;
	width: 88%;
	overflow: hidden;
}
.vtgCarousel .rightArrow {
	float: right;
	width: 6%;
	display: block;
}
.vtgCarousel .innerBox {
	
}
.vtgCarousel .item {
	width: 33%;
	border-left: 1px solid #e2e2e2;
	float: left;
}
.vtgCarousel .item:first-child {
	border-left: 0px;
}
.vtgCarousel .itemImg {
	
}
/* carouselStyles */
</style>

<?php if(get_field('carousel_items')){ ?>
	<div class='vtgCarousel'>
		<a class='leftArrow' href=''>
			<img src='<?php echo get_stylesheet_directory_uri(); ?>/img/left-arrow.png'/>
		</a>
		<div class='outerBox'>
			<div class='innerBox'>
				<?php while(has_sub_field('carousel_items')){ ?>
					<?php 
						$image = get_sub_field('image');
						$link = get_sub_field('link');
					?>
					<div class='item'>
						<?php if($link){ ?>
							<a href='<?php echo $link ?>'>
						<?php } ?>
						<img class='itemImg' src='<?php echo $image['url'] ?>'/>
						<?php if($link){ ?>
							</a>
						<?php } ?>
					</div>
				<?php } ?>
			</div>
		</div>
		<a class='rightArrow' href=''>
			<img src='<?php echo get_stylesheet_directory_uri(); ?>/img/right-arrow.png'/>
		</a>
		<div class=c></div>
	</div>
<?php } ?>