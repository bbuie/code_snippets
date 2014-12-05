<script>
// remap jQuery to $
(function($){
	/* trigger when page is ready */
	$(document).ready(function (){		
		$('.bbCarousel').bbCarousel();
	});
	
	$.fn.bbCarousel = function(options) 
		{
		    //object which is cloned per carousel by the plugin
		    var bbCarousel = new Object();
		    
		    //use these to change the default behavior
		    var defaults = {
		        //default selectors
		        outerBoxSelector: '.carouselOuter', //note all these selectors must be within the selector that initiated bbCarousel (i.e. $('.bbCarousel').bbCarousel()
		        innerBoxSelector: '.carouselInner',
		        controlsBoxSelector: '.carouselControls',
		        itemSelector: '.item', //these items must have identical margin, border, and padding styles
		        nextSelector: '.rightArrow',
		        prevSelector: '.leftArrow',
		        dotsParentSelector: '.dots',
		        dotSelector: '.dot',//include one dot in the html which will be cloned to create the rest of the dots

		        //default functionality
		        showDots: true, //show dot navigation, must have correct selectors above
		        scrollVisible: true // true means that a move click will show all new items. Dots will be per panel (i.e. visible group of items)
		    } 

		    var settings = $.extend({},defaults, options);
		    
		    bbCarousel.init = function(me)
		        {
		            this.me = me;
		            this.innerBox = this.me.find(settings.innerBoxSelector); 
		            this.innerBoxMarginLeft = 0;                        

		            this.setCSS();
		            this.bindEvents();
		            this.onresize();        
		            return this;
		        }
		    bbCarousel.setCSS = function()
		        {
		            var items = this.me.find(settings.itemSelector); 	

		            //remove existing styles
		            items.removeAttr('style');
		            this.innerBox.removeAttr('style');

		            //find width of item to set inner box width
		            var firstItem = items.first();
		            var itemCount = items.length; 
		            var outerWidth = firstItem.outerWidth();
		            var innerWidth = firstItem.innerWidth();
		            var borderWidth = outerWidth - innerWidth;
		            var paddingWidth = innerWidth - firstItem.width();
		            var marginWidth = firstItem.outerWidth(true) - outerWidth;
		            
		            //set styles of items
		            items.css({'width': outerWidth, 'margin': marginWidth / 2});
		            this.innerBoxWidth = (outerWidth + marginWidth) * itemCount;

		            this.innerBox.css('width',this.innerBoxWidth);		              

		            //set global object sizing properties
		            this.itemWidthWithMargin = outerWidth + marginWidth;
		            this.itemCount = itemCount;
		            this.outerBox =  this.me.find(settings.outerBoxSelector);
		            this.outerBoxWidth = this.outerBox.outerWidth();
		            this.visibleItems = Math.round(this.outerBoxWidth / this.itemWidthWithMargin); 
		            this.visiblePanels =  Math.ceil(this.innerBoxWidth / (this.visibleItems * this.itemWidthWithMargin));
		            this.items = items;		            
		        }
		    bbCarousel.bindEvents = function()
		        {
		            var thisGlobal = this;
		            
		            //set event the next button
		            this.me.find(settings.nextSelector).click(function(e){
		                e.preventDefault();
		                thisGlobal.move('next');
		                thisGlobal.setActiveDot();
		            });
		            //set event for the previous button
		            this.me.find(settings.prevSelector).click(function(e){
		                e.preventDefault();
		                thisGlobal.move('prev');
		                thisGlobal.setActiveDot();
		            });

		            //create dots
		            var dots = this.me.find(settings.dotsParentSelector);
		            var dotsCnt = (settings.scrollVisible)? this.visiblePanels : this.itemCount;
		            for(i = 0; i < dotsCnt; i++) {
		            	var isactive = '';
		            	if(i==0){
		            		isactive = ' active'
		            	}
		            	dots.append('<a class="dot'+isactive+'" href="#dot'+i+'">'+i+'</a>');
		            }

		            //set events for dots
		            this.me.find(settings.dotSelector).click(function(e){
		            	e.preventDefault();
		            	var me = $(this);
		            	var siblings = me.siblings();
		            	siblings.removeClass('active');
		            	me.addClass('active');
		            	var index = me.index();
		            	thisGlobal.move('dot', index);
		            	thisGlobal.setActiveDot(me);
		            });
		        }
		    bbCarousel.setActiveDot = function(me)
		    	{
		    		var dots = this.me.find(settings.dotSelector);
		    		dots.removeClass('active');
		    		var itemScrollCount = (settings.scrollVisible)? this.visibleItems : 1;
		    		var index = -this.innerBoxMarginLeft / (this.itemWidthWithMargin * itemScrollCount);
		    		dots.eq(index).addClass('active');
		    	}
		    bbCarousel.move = function(direction, index)
		        {
		        	var outerBox =  this.outerBox;
		        	var outerBoxWidth = this.outerBoxWidth;	
		        	var visibleItems = this.visibleItems; 
		        	var visiblePanels =  this.visiblePanels;
		            var maxAllowableMargin = (settings.scrollVisible)? -visiblePanels * visibleItems * this.itemWidthWithMargin : -(this.innerBoxWidth - (visibleItems * this.itemWidthWithMargin));
		            var itemScrollCount = (settings.scrollVisible)? visibleItems : 1;
		            var newMargin = false;
		            if(direction == 'next'){                    
		                newMargin = (this.innerBoxMarginLeft - (this.itemWidthWithMargin * itemScrollCount));
		                if(newMargin <= maxAllowableMargin){
		                    newMargin = 0;
		                }   
		            } else if(direction == 'prev') {
		                newMargin = (this.innerBoxMarginLeft + (this.itemWidthWithMargin * itemScrollCount));
		                if(newMargin > 0){
		                    newMargin = (settings.scrollVisible)? maxAllowableMargin + (visibleItems * this.itemWidthWithMargin) : maxAllowableMargin;
		                }
		            } else if(direction == 'dot') {
		            	newMargin = - index *  itemScrollCount * this.itemWidthWithMargin;
		            }

		            this.innerBoxMarginLeft = newMargin;
		            this.innerBox.stop(true, true).animate({'margin-left': newMargin}, 500);
		        }
		    bbCarousel.onresize = function()
		        {
		            $(window).resize(function() {
		                this.setCSS();
		            });
		        }
		    bbCarousel.disable = function()
		    	{
		    		//remove existing styles
		    		this.items.removeAttr('style');
		    		this.innerBox.removeAttr('style');
		    		this.me.find(settings.controlsBoxSelector).hide();
		    	}
		    bbCarousel.enable = function()
		    	{
		    		this.setCSS();
		    		this.me.find(settings.controlsBoxSelector).show();
		    	}

		    var len = this.length;
		    return this.each(function(index) { 
		        var me = $(this);
		        var carousel = Object.create(bbCarousel);
		        var instance = carousel.init(me);  
		        me.data('bbCarousel', instance);  
		    });
		};
})(window.jQuery);
</script>


<style>
/*carouselStyles blank*/
body {
	.bbCarousel {
		.carouselOuter {
			overflow: hidden;
		} 
		.carouselControls {
			text-align: center;

			.leftArrow {}
			.dots {
				.dot {
					border: 9px solid $lightBlue;
					width: 10px;
					height: 10px;
					margin: 0 4px;
					text-indent: -999em;
					border: 3px solid #00aeef;
					display: inline-block;
					border-radius: 9px;
					cursor: pointer;
					vertical-align: middle;
					-webkit-transition: background .5s, opacity .5s;
					-moz-transition: background .5s, opacity .5s;
					transition: background .5s, opacity .5s;

					&.active {
						background-color: $lightBlue;
						@include shadow(0, 0, 3px, $lightBlue);
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