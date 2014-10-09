<script type="text/javascript">
	/* trigger when page is ready */
	$(document).ready(function (){

		//get inputs to select on input focus
		customApp.inputFocus();		

	});
	
	customApp.inputFocus = function(){
		$("input:text").each(function (){
			// store default value
			var v = this.value;

			$(this).blur(function () {
				// if input is empty, reset value to default 
				if (this.value.length == 0) this.value = v;
			}).mouseup(function () {
				// when input is focused, select its contents
				this.select();
			}); 
		});
	}
</script>