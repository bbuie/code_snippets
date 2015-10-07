
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
            withScroll: false, //true means that move will alter the scroll, not margin left. Allows for scroll bar
        } 

        var settings = $.extend({},defaults, options);
        
        bbCarousel.init = function(me){

            this.innerLeftOffset = 0; //used below to position carousel

            this.me = me;
            this.innerBox = this.me.find(settings.innerBoxSelector);
            this.outerBox = this.me.find(settings.outerBoxSelector);
            this.items = this.me.find(settings.itemSelector);
            this.controlsBox = this.me.find(settings.controlsBoxSelector);
            this.dotsParent = this.me.find(settings.dotsParentSelector);
            this.nextButton = this.me.find(settings.nextSelector);
            this.prevButton = this.me.find(settings.prevSelector);
                                    

            this.enable();
            this.onresize(); 
            return this;
        }
        bbCarousel.enable = function(){

            //var dbugThis = true;
            if(dbugAll||dbugThis){console.log("%ccalled bbCarousel.enable()","color:orange");}

            this.setCSS();
            if(settings.showDots){
                this.createDots();    
            }
            this.controlsBox.show();
            this.checkInstance(); 
            this.bindEvents();
            this.isEnabled = true; 
        }
        bbCarousel.disable = function(){
            //remove existing styles
            this.items.removeAttr('style');
            this.innerBox.removeAttr('style');
            this.controlsBox.hide();
            this.unbindEvents();
            this.isEnabled = false;
        }
        bbCarousel.setCSS = function(){

            var dbugThis = true;
            if(dbugAll||dbugThis){console.log("%ccalled bbCarousel.setCSS()","color:orange");}
            if(dbugAll||dbugThis){console.log("%c  this","color:grey",this);}

            //remove existing styles
            this.items.removeAttr('style');
            this.innerBox.removeAttr('style');

            //find width of item to set inner box width
            var firstItem = this.items.first();
            var boundedRec = firstItem[0].getBoundingClientRect();
            var dimensions = {};
            dimensions.itemCount = this.items.length; 
            dimensions.outerWidth = firstItem.outerWidth();
            dimensions.width = boundedRec.width;
            dimensions.innerWidth = firstItem.innerWidth();
            dimensions.borderWidth = dimensions.outerWidth  - dimensions.innerWidth;
            dimensions.paddingWidth = dimensions.innerWidth - firstItem.width();
            dimensions.marginWidth = firstItem.outerWidth(true) - dimensions.outerWidth;
            dimensions.fullWidth = dimensions.width;
            dimensions.innerBoxWidth = dimensions.fullWidth * dimensions.itemCount;
            dimensions.outerBoxWidth = this.outerBox.outerWidth();
            if(dbugAll||dbugThis){console.log("%c  dimensions","color:grey",dimensions);}
            
            //set styles of items
            this.items.css({'width': dimensions.fullWidth, 'margin': dimensions.marginWidth / 2, 'padding': dimensions.paddingWidth / 2});
            this.innerBoxWidth = dimensions.innerBoxWidth;
            if(dbugAll||dbugThis){console.log("%cadded styles","color:orange");}

            this.innerBox.css('width',this.innerBoxWidth);                    

            //set global object sizing properties
            this.itemWidth = dimensions.fullWidth;
            this.itemCount = dimensions.itemCount;
            this.outerBoxWidth = dimensions.outerBoxWidth;
            this.visibleItems = Math.round(this.outerBoxWidth / this.itemWidth); 
            this.visiblePanels =  Math.ceil(this.innerBoxWidth / (this.visibleItems * this.itemWidth));
        }
        bbCarousel.createDots = function(){

            //var dbugThis = true;
            if(dbugAll||dbugThis){console.log("%ccalled bbCarousel.createDots()","color:orange");}

            //create dots
            this.dotsParent.html('');

            var dotsCnt = (settings.scrollVisible)? this.visiblePanels : this.itemCount;
            for(i = 0; i < dotsCnt; i++) {
                var isactive = '';
                if(i==0){
                    isactive = ' active'
                }
                this.dotsParent.append('<a class="dot'+isactive+'" href="#dot'+i+'">'+i+'</a>');
            }
        };
        bbCarousel.bindEvents = function(){

            //var dbugThis = true;
            if(dbugAll||dbugThis){console.log("%ccalled bbCarousel.bindEvents()","color:orange");}

            var thisGlobal = this;
            
            //set event the next button
            this.nextButton.on('click.bbCarousel', function(e){
                e.preventDefault();
                thisGlobal.move('next');
                thisGlobal.setActiveDot();
            });
            //set event for the previous button
            this.prevButton.on('click.bbCarousel', function(e){
                e.preventDefault();
                thisGlobal.move('prev');
                thisGlobal.setActiveDot();
            });

            //set events for dots
            this.dotsParent.on('click.bbCarousel', settings.dotSelector, function(e){
                e.preventDefault();
                var me = $(this);
                var siblings = me.siblings();
                siblings.removeClass('active');
                me.addClass('active');
                var index = me.index();
                thisGlobal.move('dot', index);
                thisGlobal.setActiveDot(me);
            });
        };
        bbCarousel.unbindEvents = function(){
            this.nextButton.off('click.bbCarousel');
            this.prevButton.off('click.bbCarousel');
            this.dotsParent.off('click.bbCarousel');
        };
        bbCarousel.setActiveDot = function(me){
            var dots = this.me.find(settings.dotSelector);
            dots.removeClass('active');
            var itemScrollCount = (settings.scrollVisible)? this.visibleItems : 1;
            var index = -this.innerLeftOffset / (this.itemWidth * itemScrollCount);
            dots.eq(index).addClass('active');
        }
        bbCarousel.move = function(direction, index){
            
            //var dbugThis = true;
            if(dbugAll||dbugThis){console.log("%ccalled bbCarousel.move()","color:orange");}

            var visibleItems = this.visibleItems; 
            var visiblePanels =  this.visiblePanels;
            var maxAllowableMargin = (settings.scrollVisible)? -visiblePanels * visibleItems * this.itemWidth : -(this.innerBoxWidth - (visibleItems * this.itemWidth));
            var itemScrollCount = (settings.scrollVisible)? visibleItems : 1;
            var newInnerLeftOffset = false;
            if(direction == 'next'){                    
                newInnerLeftOffset = (this.innerLeftOffset - (this.itemWidth * itemScrollCount));
                if(newInnerLeftOffset <= maxAllowableMargin){
                    newInnerLeftOffset = 0;
                }   
            } else if(direction == 'prev') {
                newInnerLeftOffset = (this.innerLeftOffset + (this.itemWidth * itemScrollCount));
                if(newInnerLeftOffset > 0){
                    newInnerLeftOffset = (settings.scrollVisible)? maxAllowableMargin + (visibleItems * this.itemWidth) : maxAllowableMargin;
                }
            } else if(direction == 'dot') {
                newInnerLeftOffset = - index *  itemScrollCount * this.itemWidth;
            }

            this.innerLeftOffset = newInnerLeftOffset;
            if(dbugAll||dbugThis){console.log("%c  this.innerLeftOffset","color:grey",this.innerLeftOffset);}

            if(settings.withScroll){
                if(dbugAll||dbugThis){console.log("%c  has scroll bar","color:grey");}
                this.outerBox.stop(true, true).animate({'scrollLeft': -newInnerLeftOffset}, 500);
            } else {
                this.innerBox.stop(true, true).animate({'margin-left': newInnerLeftOffset}, 500);
            }
        }
        bbCarousel.onresize = function(){
            var thisGlobal = this;
            var resizeDelay;
            var nowResize = function(){
                thisGlobal.disable();
                thisGlobal.enable();
            };

            $(window).resize(function() {
                clearTimeout(resizeDelay);
                resizeDelay = setTimeout(nowResize, 500);
                
            });
        }
        bbCarousel.checkInstance = function(){

            //var dbugThis = true;
            if(dbugAll||dbugThis){console.log("%ccalled bbCarousel.checkInstance()","color:orange");}

            //if outerbox and innerbox are the same width disable
            var difference = this.outerBoxWidth - this.innerBoxWidth;
            if(dbugAll||dbugThis){console.log("%c  difference","color:grey",difference);}
            if(dbugAll||dbugThis){console.log("%c  difference","color:grey",difference);}
            if(difference >= -1) {
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