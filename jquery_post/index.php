<style>
	input {
		border: 0px inset;
		margin-bottom:5px;
	}
	.vp-input-alert { 
		border:1px solid #D4212C;
	}
	.vp-success {
		background:green;
	}
	div[id*=-vp-response]{
		display:none;
		padding: 3px;
		background: #D4212C;
		color: white;
		font-weight: bold;
		position: absolute;
		width: 571px;
	}
</style>
<script>
	// remap jQuery to $
	(function($){	
	/* trigger when page is ready */
	$(document).ready(function (){		
		$("input[type='text']").click(function () {
		   $(this).select();
		});
		
		$('form').each(function() {
	        $('input').keypress(function(e) {
	            // Enter pressed?
	            if(e.which == 10 || e.which == 13) {
	                var form_id = $(this).closest('form').attr('id');
	                var form_id_split = form_id.split('-form');
	                var submit_id = form_id_split[0];
	                voltage_post(submit_id);
	            }
	        });
   		});
	});
	})(window.jQuery);
	
	//code snipit to submit any form using a simple datastructure
	//required: jquery
	function voltage_post(id) {
		
		var stop_post = false;//set to true if you need to stop the function before posting 
		
		//show loading image and hide clicked submit button
		var loader_location = $("#"+id+"-form :input[name='loader_location']").val();
		$('#'+id).after( '<img class="'+id+'-vp-loading" src="'+loader_location+'" alt=""/>' );
		$('#'+id).hide();
		
		//check to see if required feilds are filled		
		var required_empty = false;
		var default_input_text_array = new Array('');//use this to help check if defaul input values have not been changed
		$('#'+id+'-form [required]').each(function(){
			$(this).removeClass('vp-input-alert');
	      	if( !this.value || default_input_text_array.indexOf(this.value) > -1) {
            	$(this).addClass('vp-input-alert');
            	required_empty = true;
            	stop_post = true;//setting true will stop voltage_post before posting
	    	} 
		});
		
		//reset all events if a required feild 
		if(required_empty == true){
			voltage_post_closeout(id,'failed','Highlighted fields are required');
		}
		
		//stop whole function
		if(stop_post == true){
			return false;
		}
		
		//post the form
		var post_url = $("#"+id+"-form :input[name='post_url']").val();
		var post_data = $('#'+id+'-form').serialize()
		$.post(post_url,post_data , function(d){
			var d = JSON.parse(d);
				//d.success
				//d.code
				//d.message		
			if(d.code == 1){
				//do something based on code
			}	
			if (d.success == true){//if the form was successful
				//do something based on
	       	} 
	        voltage_post_closeout(id,d.success,d.message);
		});
	};
	function voltage_post_closeout(id, status, message){
		$('#'+id+'-vp-response').stop(true, true);
		if(status=='success'){
			$('#b-response').addClass('vp-success');
            $('#'+id+'-form').hide();
		} else if(status == 'failed'){
			$('#'+id+'-form').show();
			$('#'+id+'-vp-response').removeClass('vp-success');	        
	        $('#'+id).show();	        
	        setTimeout(function() { $('#'+id+'-vp-response').fadeOut(1000) }, 7000);
       }
       $('.'+id+'-vp-loading').remove();
       $('#'+id+'-vp-response').html(message);
       $('#'+id+'-vp-response').show();
       //$("html, body").animate({ scrollTop: 0 }, "slow");
       //setTimeout(function() { $('#b-response').fadeOut(2000) }, 4000);//fade out the message after 3 seconds       
	}
</script>
<body>
	<form method=post id=voltage-submit-form action=''>
		<input type=hidden name=post_url value=''/><!-- url form should post to -->
		<input type=hidden name=loader_location value=''/><!-- relative location to a loader image -->
		<input type=hidden name=post_type value=''/><!-- used to post to the post_url from more than one location -->
			<input type=text name=typical_field value='' required>
			<select name=typical_field>
				<option value=''></option>
			</select>
			<a href="#" id="voltage-submit" onclick="voltage_post('voltage-submit')">Submit</a>
			<!-- <input id='voltage-submit' type=submit name=submit value='submit'/> -->		
	</form>
	<div id="voltage-submit-vp-response"></div>
</body>