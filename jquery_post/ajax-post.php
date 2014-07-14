<?php 

$ajax_status = false;//changes to true if post is successful
$ajax_code = 0;//use this to process codes
$ajax_message = '';//use this to add a message
$ajax_data = Array();//use to add data to response
$error_log_destination = 'ajax-log/errors.txt';
$currentFileName = 'ajax-post.php';

//===============================================================================================
if(isset($_POST['post_type']) && $_POST['post_type'] == 'your_post_type'){
	
	foreach($_POST as $name => $value) {
		$_POST[$name] = mysql_escape_string($value); 
	}
	
	if($mysqli->query($sSQL)){
		$ajax_status = true;
		$ajax_code = 1;
		$ajax_message .= "Your success message.<br/>";
	} else {
		$ajax_message .= $mysqli->error.".<br/>";
		$error_message = "[" . date ( 'r' , $timestamp = time()).'] Error in '.$currentFileName.' - code: '
			.$mysqli->error
			.PHP_EOL;
		error_log($error_message ,$message_type = 3, $error_log_destination);
	}	
}
echo json_encode(array('success'=> $ajax_status,'code'=> $ajax_code,'message'=> $ajax_message,'data'=> $ajax_data), JSON_FORCE_OBJECT);
?>