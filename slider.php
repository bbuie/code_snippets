<!-- sample script, must include unslider -->
<script>
	//object used to organize javascript functionality
	var customApp = new Object();	
	
	/* trigger when page is ready */
	$(document).ready(function (){
		customApp.buieSlide();
	});

	//add slider, dependant on unslider.js
	customApp.buieSlide = function(options)
		{
			var buieSlide = new Object;
			
			var defaults = {
				slider: '.banner',
				firstSlide: '.one',
				sliderImage: '.bannerImg',
				nextButton: '.next',
				prevButton: '.prev'
			}

			var settings = $.extend({},defaults, options);



			buieSlide.setup = function()
				{
					if($(settings.slider).length){
						$(settings.slider).each(function(){
							 buieSlide.sliderDeterminLoadType($(this));				
						});
					}
				}
			buieSlide.sliderDeterminLoadType = function(banner)
				{
					if(banner.find('ul '+ settings.firstSlide + ' '+ settings.sliderImage).height() > 30){
						 buieSlide.loadUnslider(banner);
					} else {
						banner.find('ul '+ settings.firstSlide + ' '+ settings.sliderImage).on('load', function(){
							 buieSlide.loadUnslider(banner);
						});
					}
				};	
			buieSlide.loadUnslider = function(banner)
				{	
					var slider = banner.unslider({ //download this plugin here: http://unslider.com/
						speed: 600,               //  The speed to animate each slide (in milliseconds)
						delay: 7000,              //  The delay between slide animations (in milliseconds)
						complete: function() {},  //  A function that gets called after every slide animation
						keys: true,               //  Enable keyboard (left, right) arrow shortcuts
						dots: true,               //  Display dot navigation
						fluid: true 
					});		
					buieSlide.navigationButtons();
				};		
			buieSlide.navigationButtons = function()
				{
					$(settings.slider +" "+ settings.nextButton).click(function(){
						var me = $(this);
						var $slider = me.closest(settings.slider);
						var slider = $slider.data('unslider');
						slider.next();
					});
					$(settings.slider +" "+ settings.prevButton).click(function(){
						var me = $(this);
						var $slider = me.closest(settings.slider);
						var slider = $slider.data('unslider');
						slider.prev();
					});
				}
			buieSlide.removeSliders = function() 
				{
					if($(settings.slider).length){
						$(settings.slider).each(function(){	
							var me = $(this);
							
							//check if the element has a slider setup
							var unslider = 	me.data('unslider');
						    if (unslider){

						    	//remove styles and classes from the dom
						        var meUl = me.find('ul');
						        var meLi = me.find('li');
						        me.add(meUl).add(meLi).removeAttr('style');
						        me.find('.dots').remove();
						        me.removeClass('has-dots');	

						        //unbind all events added by buieSlide and unslider
						        me.off();
						        me.unbind();
						        var firstSlideImg = me.find('ul '+ settings.firstSlide + ' '+ settings.sliderImage);
						        firstSlideImg.off();
						        firstSlideImg.unbind();	
						        var nextButton = me.find(settings.slider +" "+ settings.nextButton);
						        nextButton.off();
						        nextButton.unbind();	
						        var prevButton = me.find(settings.slider +" "+ settings.prevButton);
						        prevButton.off();
						        prevButton.unbind();						        

						        //remove the timeout and data created by the unslider instantiation
						        unslider.stop();
						        me.removeData();
						    }
				   		});
				   	}	
				};
			//setup the buieSlide funtion
			buieSlide.setup();
			customApp.buieSlideObject = buieSlide;
		};
</script>
<style>


/* Slider Styles ****************************************************/
.banner { position: relative; overflow: auto; custom: both; margin-bottom: 10px;}
.banner ul {
	margin-left: 0;
}
.banner .navigation .next {
	position: absolute;
	top: 50%;
	cursor: pointer;
	margin-top: -12px;
	right: 100px;
}
.banner .navigation .prev {
	position: absolute;
	top: 50%;
	cursor: pointer;
	margin-top: -12px;
	left: 100px;

}
.banner .item { list-style: none; }
.banner ul .item { float: left; width: 100%; overflow: hidden; position: relative;} 
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
/* fix added for slider in IE8, don't wrap these in id for scss */
.ie8 .banner .dots li {
	-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=50)";
	background: white;
}
.ie8 .banner .dots li.active {
	-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";
}
/*end of fix */

/*or styles for scss*/

body {
	.banner { 
		position: relative; overflow: auto; custom: both;

		ul {
			margin-left: 0;

			.item { float: left; width: 100%; overflow: hidden; position: relative;} 
		}
		.item { list-style: none; }
		.navigation {
			.next, .prev {
				position: absolute;
				top: 50%;
				cursor: pointer;
				margin-top: -12px;
			}
			.next {				
				right: 100px;

				@media #{$breakpointPhoneLandscape} {
					right: 30px;
				}
			}
			.prev {
				left: 100px;

				@media #{$breakpointPhoneLandscape} {
					left: 30px;
				}
			}
		}

		.bannerPrev {
			
		}
		.dots {
			position: absolute;
			right: 24px;
			top: 12px;
			z-index: 1;

			li {
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

				&.active {
					background: #fff;
					opacity: 1;
				}
			}
		}
	}
	.ie8 .banner .dots li {
		/* fix added for slider in IE8, don't wrap these in id for scss */
		-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=50)";
		background: white;

		&.active {
			-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";
		}
	}
}
</style>


<!-- html for simple banner -->
<div class='banner'>
	<ul>
		<li class="item one">
			<img class="bannerImg" src="">
		</li>
		<li class="item">
			<img class="bannerImg" src="">
		</li>
	</ul>
	<div class="navigation">
		<div class="next">
			<img src="<?php echo $stylesheetURL ?>/img/arrowRight.png">
		</div>
		<div class="prev">
			<img src="<?php echo $stylesheetURL ?>/img/arrowLeft.png">
		</div>
	</div>
</div>

<!-- php for wordpress slider -->
<?php if(!empty($allFields['slider_images'])){ ?>
	<!-- begin slider -->
	<div id="banner">
		<div class="banner">
		    <ul>
		    	<?php $sliderCnt = 0; ?>
		    	<?php foreach($allFields['slider_images'] as $slide){ ?>
			    	<li class='item <?php if($sliderCnt == 0){echo 'one';} ?>'>
			    		<?php if(!empty($slide['link'])){ ?>
			    			<a href="<?php echo $slide['link'] ?>">
			    		<?php } ?>
			    				<img class="bannerImg" src="<?php echo $slide['image']['url'] ?>">
			    		<?php if(!empty($slide['link'])){ ?>
			    			</a>
			    		<?php } ?>
			    	</li>
		    	<?php $sliderCnt++;} ?>
		    </ul>
		</div>
	</div>
<?php } ?>

<?php 
//use the following code to add advanced custom fields for a slider
if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_slider-fields',
		'title' => 'Slider Fields',
		'fields' => array (
			array (
				'key' => 'field_540f1a2195768',
				'label' => 'Slider Images',
				'name' => 'slider_images',
				'type' => 'repeater',
				'sub_fields' => array (
					array (
						'key' => 'field_540f1a2d95769',
						'label' => 'Image',
						'name' => 'image',
						'type' => 'image',
						'instructions' => 'Optimal size: 960px width by variable height',
						'column_width' => '',
						'save_format' => 'object',
						'preview_size' => 'full',
						'library' => 'all',
					),
					array (
						'key' => 'field_540f1a6b9576a',
						'label' => 'Link',
						'name' => 'link',
						'type' => 'text',
						'instructions' => 'e.g. ###site_url###/contact-us <br/> Note: ###site_url### is replaced by the actual site url',
						'column_width' => '',
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'formatting' => 'html',
						'maxlength' => '',
					),
				),
				'row_min' => '',
				'row_limit' => '',
				'layout' => 'table',
				'button_label' => 'Add Image',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'templates/front-page-new.php',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'acf_after_title',
			'layout' => 'no_box',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
}


?>