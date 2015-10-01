
(function($){
	
	$.fn.bbCarousel = function(options) {

		var dbugThis = false; var dbugAll = false;
		if(dbugAll||dbugThis){console.log("%ccalled $.fn.bbCarousel()","color:orange");}

	    //object which is cloned per carousel by the plugin
	    var bbCarousel = new Object();
	    
	    //these defaults can be overidden by the options passed into this function
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
	        scrollVisible: true, // true means that a move click will show all new items. Dots will be per panel (i.e. visible group of items)
	    } 

	    var settings = $.extend({},defaults, options);
	    
	    bbCarousel.init = function(me){
            this.me = me;
            this.innerBox = this.me.find(settings.innerBoxSelector); 
            this.innerBoxMarginLeft = 0;                        

            this.setCSS();
            this.bindEvents();
            this.onresize(); 
            this.checkInstance(); 
            this.isEnabled = true;    
            return this;
        }
	    bbCarousel.setCSS = function(){

	    	var dbugThis = true;
	    	if(dbugAll||dbugThis){console.log("%ccalled bbCarousel.setCSS()","color:orange");}
	    	if(dbugAll||dbugThis){console.log("%c  this","color:grey",this);}

            var items = this.me.find(settings.itemSelector); 
            if(dbugAll||dbugThis){console.log("%c  items","color:grey",items);}	

            //remove existing styles
            items.removeAttr('style');
            this.innerBox.removeAttr('style');

            //find width of item to set inner box width
            var firstItem = items.first();
            var boundedRec = firstItem[0].getBoundingClientRect();
            var dimensions = {};
            dimensions.itemCount = items.length; 
            dimensions.outerWidth = firstItem.outerWidth();
            dimensions.width = boundedRec.width;
            dimensions.innerWidth = firstItem.innerWidth();
            dimensions.borderWidth = dimensions.outerWidth  - dimensions.innerWidth;
            dimensions.paddingWidth = dimensions.innerWidth - firstItem.width();
            dimensions.marginWidth = firstItem.outerWidth(true) - dimensions.outerWidth;
            dimensions.fullWidth = dimensions.width;
            dimensions.innerBoxWidth = dimensions.fullWidth * dimensions.itemCount;
            if(dbugAll||dbugThis){console.log("%c  dimensions","color:grey",dimensions);}
            
            //set styles of items
            items.css({'width': dimensions.fullWidth, 'margin': dimensions.marginWidth / 2, 'padding': dimensions.paddingWidth / 2});
            this.innerBoxWidth = dimensions.innerBoxWidth;
            if(dbugAll||dbugThis){console.log("%cadded styles","color:orange");}

            this.innerBox.css('width',this.innerBoxWidth);		              

            //set global object sizing properties
            this.itemWidth = dimensions.fullWidth;
            this.itemCount = dimensions.itemCount;
            this.outerBox =  this.me.find(settings.outerBoxSelector);
            this.outerBoxWidth = this.outerBox.outerWidth();
            this.visibleItems = Math.round(this.outerBoxWidth / this.itemWidth); 
            this.visiblePanels =  Math.ceil(this.innerBoxWidth / (this.visibleItems * this.itemWidth));
            this.items = items;		            
        }
	    bbCarousel.bindEvents = function(){

	    	var dbugThis = true;
	    	if(dbugAll||dbugThis){console.log("%ccalled bbCarousel.bindEvents()","color:orange");}

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
	    		var index = -this.innerBoxMarginLeft / (this.itemWidth * itemScrollCount);
	    		dots.eq(index).addClass('active');
	    	}
	    bbCarousel.move = function(direction, index)
	        {
	        	var outerBox =  this.outerBox;
	        	var outerBoxWidth = this.outerBoxWidth;	
	        	var visibleItems = this.visibleItems; 
	        	var visiblePanels =  this.visiblePanels;
	            var maxAllowableMargin = (settings.scrollVisible)? -visiblePanels * visibleItems * this.itemWidth : -(this.innerBoxWidth - (visibleItems * this.itemWidth));
	            var itemScrollCount = (settings.scrollVisible)? visibleItems : 1;
	            var newMargin = false;
	            if(direction == 'next'){                    
	                newMargin = (this.innerBoxMarginLeft - (this.itemWidth * itemScrollCount));
	                if(newMargin <= maxAllowableMargin){
	                    newMargin = 0;
	                }   
	            } else if(direction == 'prev') {
	                newMargin = (this.innerBoxMarginLeft + (this.itemWidth * itemScrollCount));
	                if(newMargin > 0){
	                    newMargin = (settings.scrollVisible)? maxAllowableMargin + (visibleItems * this.itemWidth) : maxAllowableMargin;
	                }
	            } else if(direction == 'dot') {
	            	newMargin = - index *  itemScrollCount * this.itemWidth;
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
	    		this.isEnabled = false;
	    	}
	    bbCarousel.enable = function()
	    	{
	    		this.setCSS();
	    		this.me.find(settings.controlsBoxSelector).show();
	    		this.isEnabled = true;
	    	}
	    bbCarousel.checkInstance = function(){

	    	var dbugThis = true;
	    	if(dbugAll||dbugThis){console.log("%ccalled bbCarousel.checkInstance()","color:orange");}

    		//if outerbox and innerbox are the same width disable
    		var absoluteDifference = Math.abs(this.outerBoxWidth - this.innerBoxWidth);
    		if(dbugAll||dbugThis){console.log("%c  absoluteDifference","color:grey",absoluteDifference);}
    		if(absoluteDifference < 10) {
    			if(dbugAll||dbugThis){console.log("%c  disabling","color:red");}
    			this.disable();
    		}
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