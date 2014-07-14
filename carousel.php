<script>
// remap jQuery to $
(function($){
	/* trigger when page is ready */
	$(document).ready(function (){		
		$('.vtgCarousel').vtgCarousel();
	});
	
	$.fn.vtgCarousel = function(options) {
		var vtgCarousel = this;
		
		vtgCarousel.defaults = {
			outerBoxClass: '.outerBox', 
			innerBoxClass: '.innerBox',
			itemClass: '.item',
			nextClass: '.rightArrow',
			prevClass: '.leftArrow'
		}		
		var settings = $.extend({},this.defaults, options);
		
		vtgCarousel.init = function(el){
			var carousel = new Object();
			carousel.el = $(el);
			carousel.innerBox = carousel.el.find(settings.innerBoxClass);
			carousel.outerBox = carousel.el.find(settings.outerBoxClass)
			carousel.items = carousel.el.find(settings.itemClass);
			
			//find width of item to set inner box width
			carousel.itemWidth = carousel.items.outerWidth() + 2;		
			carousel.itemCount = carousel.items.length;
			carousel.innerBoxWidth = carousel.itemWidth * carousel.itemCount;
			carousel.items.css('width', carousel.itemWidth);
			carousel.innerBox.css('width',carousel.innerBoxWidth);
			
			//find the number of visible items
			carousel.outerBoxWidth = carousel.outerBox.outerWidth();
			carousel.visibleItems = Math.round(carousel.outerBoxWidth / carousel.itemWidth);
			
			carousel.el.find(settings.nextClass).click(function(e){
				e.preventDefault();
				vtgCarousel.move('next', carousel);
			});
			carousel.el.find(settings.prevClass).click(function(e){
				e.preventDefault();
				vtgCarousel.move('prev', carousel);
			});
		}
		
		vtgCarousel.move = function(direction, carousel){				
			var marginLeft = parseInt(carousel.innerBox.css('margin-left'));
			var maxAllowableMargin = -(carousel.innerBoxWidth - ((carousel.visibleItems-1) * carousel.itemWidth));
			var newMargin;
			if(direction == 'next'){					
				newMargin = (marginLeft - carousel.itemWidth - 1);
				if(newMargin <= maxAllowableMargin){
					newMargin = 0;
				}	
			} else {
				newMargin = (marginLeft + carousel.itemWidth - 1);
				if(newMargin >= 0){
					newMargin = -(carousel.innerBoxWidth - ((carousel.visibleItems) * carousel.itemWidth));
				}
			}
			carousel.innerBox.animate({'margin-left': newMargin}, 500);
		}
		
		return vtgCarousel.each(function() { 
			vtgCarousel.init(this);		
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
	<div class='caseStudyViewer vtgCarousel'>
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