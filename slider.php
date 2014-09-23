<script>
	//object used to organize javascript functionality
	var buie = new Object();	
	
	/* trigger when page is ready */
	$(document).ready(function (){
		buie.sliderInit();
	});

	buie.vtgSlider = function(options)
		{
			var vtgSlider = new Object;
			
			vtgSlider.defaults = {
				slider: '.banner',
				firstSlide: '.one',
				sliderImage: '.bannerImg'
			}

			var settings = $.extend({},vtgSlider.defaults, options);

			vtgSlider.dotsNewLocation = function()
				{
					alert('dots')
				}
			vtgSlider.loadUnslider = function(banner)
				{	

					vtgSlider.slider = banner.unslider({ //download this plugin here: http://unslider.com/
						speed: 600,               //  The speed to animate each slide (in milliseconds)
						delay: 7000,              //  The delay between slide animations (in milliseconds)
						complete: function() {},  //  A function that gets called after every slide animation
						keys: true,               //  Enable keyboard (left, right) arrow shortcuts
						dots: true,               //  Display dot navigation
						fluid: true 
					});

					vtgSlider.functions = vtgSlider.slider.data('unslider');
				};	
			vtgSlider.sliderDeterminLoadType = function(banner, settings)
				{
					if(banner.find('ul '+ settings.firstSlide + ' '+ settings.sliderImage).height() > 30){
						 vtgSlider.loadUnslider(banner);
					} else {
						banner.find('ul '+ settings.firstSlide + ' '+ settings.sliderImage).on('load', function(){
							 vtgSlider.loadUnslider(banner);
						});
					}
				};		

			if($(settings.slider).length){
				$(settings.slider).each(function(){
					 vtgSlider.sliderDeterminLoadType($(this), settings);				
				});
			}


		};
</script>
<style>
/* Slider Styles ****************************************************/
.banner { position: relative; overflow: auto; buie: both; margin-bottom: 10px;}
.banner ul {
	margin-left: 0;
}
.banner .item { list-style: none; }
.banner ul .item { float: left; width: 100%; overflow: hidden; position: relative; max-height: 565px;} 
.banner .dots {
	position: absolute;
	right: 24px;
	top: 12px;
	z-index: 1;
}
.banner .dots li {
	display: inline-block;
	width: 0px;
	height: 0px;
	margin: 0 4px;
	text-indent: -999em;
	border: 9px solid #fff;
	border-radius: 9px;
	cursor: pointer;
	opacity: .4;
	-webkit-transition: background .5s, opacity .5s;
	-moz-transition: background .5s, opacity .5s;
	transition: background .5s, opacity .5s;
}
.banner .dots li.active {
	background: #fff;
	opacity: 1;
}
/* fix added for slider in IE8 */
.ie8 .banner .dots li {
	-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=50)";
	background: white;
}
.ie8 .banner .dots li.active {
	-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";
}
/*end of fix */
</style>

<div class='banner'>
	<ul>
		<li class="item one"></li>
		<li class="item"></li>
	</ul>
</div>