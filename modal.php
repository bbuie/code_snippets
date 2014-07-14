<script>
	survey.showModal = function(object){
		//needs viewport variables set
		
		//default variables
		var type = (object.type)? object.type : false; // video, img, content
		var src = (object.src)? object.src : false; // e.g. //www.youtube.com/embed/D8E7G0a4_Ao?autoplay=1
		var contentSelector = (object.contentSelector)? object.contentSelector : false; //any css selector for an element
		var isResponsive = (object.responsive)? object.responsive : false;// true or false
		
		if(!type){
			alert('contact the webmaster, no type was added for this functionality.');
			return false;
		}		
			
		var modal = $('.modalHidden').clone(true,true).removeClass('modalHidden');
		
		if(type == 'video' && src == false){
			alert('contact the webmaster, no video source is specified.');
			return false;
		} else if(type == 'video' && src){
			modal.find('.modalImage').remove();
			modal.find('.modalContent').remove();
			modal.find('.modalIframe').attr('src',src);
		}
		
		if(type == 'content' && contentSelector == false){
			alert('contact the webmaster, no content was added for this functionality.');
			return false;
		} else if(type == 'content' && contentSelector != false) {
			//console.log('had contentElement')
			modal.find('.modalIframe').remove();
			modal.find('.modalImage').remove();
			var contentElement = $(contentSelector).clone(true,true).css('display', 'block');
			contentElement.appendTo(modal.find('.modalContent'));
		}
		
		//show the modal
		modal.appendTo('body');
		
		//set default position
		//set size of content
		var contentHeight = modal.find('.modalViewer').height();
		//console.log('contentHeight: '+contentHeight);
		var contentWidth = modal.find('.modalViewer').width();
		//console.log('contentWidth: '+contentWidth);
		modal.find('.modalViewer').css({
			'margin-top': -contentHeight/2
		});
		modal.find('.modalViewer').css({
			'margin-left': -contentWidth/2
		});
		
		if(isResponsive){
			
			if(contentWidth > survey.viewportWidth){
				modal.find('.modalViewer').css({
					'margin-left': '0',
					'left': '0',
					'width': survey.viewportWidth
				});
			} 
			if(contentHeight > survey.viewportHeight){
				modal.find('.modalViewer').css({
					'margin-top': '0',
					'top': '0',
					'height': survey.viewportHeight
				});
			} 
		}
		
		//remove event functions
		modal.find('.modalOpacity').click(function(){
			$(this).closest('.modal').remove();
		});
		modal.find('.modalClose').click(function(){
			$(this).closest('.modal').remove();
		});
	}
</script>

<style>
/*
 * modalStyles ******************************************************************
 */
.modalHidden {
	display: none;
}
.modal {
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
	top:0;
	right: 0;
	z-index: 3;
}
.modalCloseText {
	color: white;
	font-size: 23px;
	font-weight: bold;
	padding: 6px 14px 1px;
	cursor: pointer;
	border: 7px solid #c0c0c0;
	background-color: #b72728;
}
.modalViewer {
	left: 50%;
	top: 50%;
	z-index: 3;
	position: absolute;
}
.modalIframe {	
	width: 720px;
	height: 405px;
	max-height: 100%;
	border: 0px;
}
@media only screen and (max-width: 767px) {
	.modalIframe {
		width: 320px;
		height: 180px;
	}
}
</style>

	<div class='modal modalHidden'>
		<div class='modalOpacity'></div>
		<div class='modalViewer'>
			<img class='modalImage' src=''/>
			<div class='modalContent'></div>
			<iframe class='modalIframe' src=''></iframe>
		</div>
		<div class='modalClose'>
			<div class='modalCloseText'>X</div>
			<!-- <img src='<?php echo get_stylesheet_directory_uri(); ?>/img/close.png'/> -->
		</div>
	</div>