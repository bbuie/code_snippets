<script>
	//dependant on viewport sizing function

	//object used to organize javascript functionality
	var customApp = new Object();	
	
	/* trigger when page is ready */
	$(document).ready(function (){

		//bind events for the modal
		customApp.bindBuieModal();

	});

	customApp.bindBuieModal = function()
		{//function dependent on customApp.buieModal function
			//add video popup click event
			$('.videoPopup').click(function(e){
				e.preventDefault();
				var $self = $(this);
				var videoSrc = $self.attr('href');
				customApp.buieModal({
					type: 'video',
					src: videoSrc
				})

			});
		}
	customApp.buieModal = function(object)
		{			
			//object used to organize javascript functionality
			var buieModal = new Object();

			//default variables
			var type = (object.type)? object.type : false; // video, img, content, gallery
			var src = (object.src)? object.src : false; // e.g. //www.youtube.com/embed/D8E7G0a4_Ao?autoplay=1
			var contentSelector = (object.contentSelector)? object.contentSelector : false; //any css selector for an element
			var buieModal = this;
			var modal = $('.modalHidden').clone(true,true).removeClass('modalHidden');

			buieModal.setup = function(){
				//make sure the data sent to buieModal method is correct
				var dataCheck = buieModal.dataCheck();
				if(!dataCheck){
					return false;
				}
				//remove unused html from modal
				buieModal.modalCleanup();
				//show the modal
				modal.appendTo('body');
				//add the content to the modal
				buieModal.addContent();
				//bind events to the modal
				buieModal.bindEvents();	
				//return the active modal to make changes outside this function
				customApp.buieModalActive = buieModal;			
			}
			buieModal.bindEvents = function(){
				//remove event functions
				modal.find('.modalOpacity').click(function(){
					$(this).closest('.buieModal').remove();
				});
				modal.find('.modalClose').click(function(){
					$(this).closest('.buieModal').remove();
				});

				//next and previous functions
				modal.find('.modalNext, .modalPrev').click(function(e){
					e.preventDefault();
					var activeIndex = parseInt(modal.find('.modalImage').attr('dataIndex'));
					var newIndex = activeIndex + 1;
					if($(this).hasClass('modalPrev')){
						newIndex = activeIndex - 1;
					}
					buieModal.move(newIndex);
				});
			}
			buieModal.move = function(newIndex){
				if(newIndex == src.length){
					newIndex = 0;
				} else if(newIndex < 0){
					newIndex = src.length -1;
				}
				modal.find('.modalImage').on('load', function(){
					buieModal.setHeight();
				}).attr('src', src[newIndex].src).attr('dataIndex', newIndex);
				modal.find('.modalCurrent').text(newIndex+1)
			}
			buieModal.addContent = function(){
				if(type == 'video' && src){
					modal.find('.modalIframe').attr('src',src);
					buieModal.setHeight();
				}
				
				if(type == 'content' && contentSelector != false) {
					var contentElement = $(contentSelector).clone(true,true).css('display', 'block');
					contentElement.appendTo(modal.find('.modalContent'));
					buieModal.setHeight();
				}

				if(type == 'img' && src){
					modal.find('.modalImage').on('load', function(){
						buieModal.setHeight();
					}).attr('src', src);
				}

				if(type == 'gallery' && src){
					modal.find('.modalImage').on('load', function(){
						buieModal.setHeight();
					}).attr('src', src[0].src).attr('dataIndex', 0);
					modal.find('.modalTotal').text(src.length);
					modal.find('.modalCurrent').text(1)
				}
			}
			buieModal.dataCheck = function(){
				if(!type){
					alert('contact the webmaster, no type was added for this functionality.');
					return false;
				}
				
				if((type == 'video' || type == 'img' || type == 'gallery') && src == false){
					alert('contact the webmaster, no source is specified.');
					return false;
				} 
				
				if(type == 'content' && contentSelector == false){
					alert('contact the webmaster, no content was added for this functionality.');
					return false;
				} 

				return true;			
			}

			buieModal.modalCleanup = function(){
				if(type == 'video' && src){
					modal.find('.modalImage').remove();
					modal.find('.modalNavigation').remove();
					modal.find('.modalContent').remove();
				}
				
				if(type == 'content' && contentSelector != false) {
					//console.log('had contentElement')
					modal.find('.modalIframe').remove();
					modal.find('.modalNavigation').remove();
					modal.find('.modalImage').remove();
				}

				if(type == 'img' && src){
					modal.find('.modalIframe').remove();
					modal.find('.modalNavigation').remove();
					modal.find('.modalContent').remove();
				}

				if(type == 'gallery' && src){
					modal.find('.modalIframe').remove();
					modal.find('.modalContent').remove();
				}
			}

			buieModal.setHeight = function(){
				modal.find('.modalViewer, .modalImage, .modalContent, .modalIframe').removeAttr('style');
				var contentHeight = modal.find('.modalViewer').outerHeight();
				//console.log('contentHeight: '+contentHeight);
				var contentWidth = modal.find('.modalViewer').outerWidth();
				//console.log('contentWidth: '+contentWidth);
				var maxWidth =  customApp.viewportWidth*.9;
				var maxHeight = customApp.viewportHeight*.9;			

				if(contentWidth > maxWidth || contentHeight > maxHeight){
					var widthRatio = maxWidth / contentWidth;
					var heightRatio = maxHeight / contentHeight;
					var ratio = Math.min(widthRatio, heightRatio);

					if(contentWidth > maxWidth) {
						modal.find('.modalViewer').css({
							'width': contentWidth*ratio
						});
						
						modal.find('.modalImage, .modalContent, .modalIframe').css({
							'max-width': '100%'
						});
					} else if(contentHeight > maxHeight){
						modal.find('.modalViewer').css({
							'height': contentHeight*ratio,
							'width': contentWidth*ratio
						});
						modal.find('.modalImage, .modalContent, .modalIframe').css({
							'overflow-y': 'auto',
							'max-height': '100%'
						});
					}

					

					
					
					contentHeight = modal.find('.modalViewer').outerHeight();
					contentWidth = modal.find('.modalViewer').outerWidth();
				}		    
				
				modal.find('.modalViewer').css({
					'margin-top': -contentHeight/2, 
					'margin-left': -contentWidth/2
				});
			}	
			
			buieModal.setup();
		}
</script>

<style>
/*
* modalStyles *********************************************************************
*/
@-webkit-keyframes fadeInDown {
  0% { opacity: 0; -webkit-transform: translateY(0); }
  100% { opacity: 1; -webkit-transform: translateY(6px);}
}
@-moz-keyframes fadeInDown {
  0% { opacity: 0; -moz-transform: translateY(0);}
  100% { opacity: 1;  -moz-transform: translateY(6px);}
}
@-o-keyframes fadeInDown {
  0% { opacity: 0; -o-transform: translateY(0); }
  100% { opacity: 1;  -o-transform: translateY(6px); }
}
@keyframes fadeInDown {
  0% { opacity: 0; transform: translateY(0);  }
  100% { opacity: 1;  transform: translateY(6px); }
}
.modalHidden {
	display: none;
}
.buieModal {
	position: fixed;
	width: 100%;
	height: 100%;
	top: 0;
	left: 0;
	right: 0;
	bottom: 0;
	z-index: 2;
}
.modalOpacity {
	position: absolute;
	width: 100%;
	height: 100%;
	top: 0;
	bottom: 0;
	right: 0;
	left: 0;
	background: rgba(0,0,0,.8);	
}
.ie8 .modalOpacity {
	-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=80)";
	background: black;
}
.modalClose {
	position: absolute;
	top:-20px;
	right: -20px;
	z-index: 3;
}
.modalCloseText {
	color: white;
	font-size: 20px;
	font-weight: bold;
	padding: 5px 9px;
	cursor: pointer;
	border: 5px solid white;
	background-color: black;
	-webkit-border-radius: 21px;
	-moz-border-radius: 21px;
	border-radius: 21px;
	height: 40px;
	width: 40px;
}
.modalNavigation {
	position: absolute;
	top: 10px;
	width: 100%;
	text-align: center;
}
.modalPrev, .modalNext {
	color: white;
	font-weight: 600;
	font-size: 17px;
}
.modalPrev:hover, .modalNext:hover {
	text-decoration: none;
}
.modalNext {
	margin-left: 30px;
}
.modalCounter {
	font-size: 17px;
}
.modalCurrent {
	margin-left: 30px;
}
.modalViewer {
	opacity: 0;
	left: 50%;
	top: 50%;
	z-index: 3;
	position: absolute;
	background: white;
	padding: 20px;
	-webkit-border-radius: 8px;
  	-moz-border-radius: 8px; 
  	border-radius: 8px; 
  	-webkit-animation: fadeInDown .3s ease-out .3s forwards; /* Safari 4+ */
	-moz-animation:    fadeInDown .3s ease-out .3s forwards; /* Fx 5+ */
	-o-animation:      fadeInDown .3s ease-out .3s forwards; /* Opera 12+ */
	animation:         fadeInDown .3s ease-out .3s forwards; /* IE 10+ */
}
.ie-lt10 .modalViewer {
	opacity: 1;
}
.modalIframe {
	width: 720px;
	height: 405px;
	border: 0px;
}
.modalImage {
	max-width: none;
}
@media only screen and (max-width: 767px) {
	.modalIframe {
		width: 320px;
		height: 180px;
	}
}
</style>

	<!-- start of modal html -->
	<div class='buieModal modalHidden'>
		<div class='modalOpacity'></div>
		<div class='modalViewer'>
			<img class='modalImage' src=''/>
			<div class='modalContent'></div>
			<iframe class='modalIframe' src=''></iframe>
			<div class='modalClose'>
				<div class='modalCloseText'>X</div>
				<!-- <img src='<?php echo get_stylesheet_directory_uri(); ?>/img/close.png'/> -->
			</div>
		</div>
		<div class='modalNavigation'> 
			<a class='modalPrev' href=''>&laquo; Previous</a>
			<span class='modalCounter'><span class='modalCurrent'></span>/<span class='modalTotal'></span></span>
			<a class='modalNext'href=''>Next &raquo;</a>
		</div>
	</div>

	<!-- start of video html -->
	<a class='videoPopup' href="<?php echo $videoEmbedURL ?>" target="_blank"></a>