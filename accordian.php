<script>
	//object used to organize javascript functionality
	var customApp = new Object();	
	
	/* trigger when page is ready */
	$(document).ready(function (){
		customApp.buieAccordian();
	});

	//add accordian
	customApp.buieAccordian = function(options)
		{
			var buieAccordian = new Object();

			var defaults = {
				parentSelector: '.accordian',
				itemSelector: '.item',
				clickSelector: '.accordianClicker',
				hiddenSelector: '.accordianHidden'
			}

			var settings = $.extend({},defaults, options);

			buieAccordian.setup = function()
				{
					//bind event to open hidden content
					buieAccordian.bindEvents();
				}
			buieAccordian.bindEvents = function()
				{
					$(settings.clickSelector).click(function(e){
						e.preventDefault();
						var me = $(this);
						var parent = me.closest(settings.itemSelector);
						var hidden = parent.find(settings.hiddenSelector);
						//var parentSiblings = me.closest(settings.parentSelector).find(settings.itemSelector);
						var parentSiblings = parent.siblings(settings.itemSelector);
						var parentSiblingsHidden = parentSiblings.find(settings.hiddenSelector);
						
						parentSiblingsHidden.slideUp();
						parentSiblings.removeClass('open');

						if(parent.hasClass('open')){
							hidden.stop(true,true).slideUp();
							parent.removeClass('open');
						} else {
							hidden.stop(true,true).slideDown();
							parent.addClass('open');
						}
					});
				}

			buieAccordian.setup();
			customApp.buieAccordianObj = buieAccordian;

		}
</script>
<style type="text/css">
.accordian {
	.item {
		.accordianClicker {
			background: $darkGreen;
			background-image: image-url('hp-arrow-right-mobile.png');
			background-position: 95% 31px;
			background-repeat: no-repeat;
			color: white;
			display: block;
			padding: 21px 30px;
			margin-bottom: 8px;
		}
		&.open {
			.accordianClicker {
				background: $green;
				background-image: image-url('hp-arrow-down-mobile.png');
				background-position: 95% 31px;
				font-weight: bold;
				background-repeat: no-repeat;
			}
		}
		.accordianHidden {
			display: none;
			padding: 13px 30px;
		}
	}
}
</style>

<div class="accordian">
	<div class="item">
		<a class="accordianClicker" href="">ROOMY</a>
		<div class="accordianHidden">
			<p>Voltage vendo consilium et consilium, firma sit plenum servitium praestant electrifying technology pro creatrix et telam print, idem, notans, packaging, metus et elit.</p>
		</div>
	</div>
</div>