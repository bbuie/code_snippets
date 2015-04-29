(function ($) {

	//object for organizing all custom javascript for this project
	var customApp = new Object();

	$(window).resize(function() {		
		//resize function go here
	});

	$(document).ready(function (){

		//call your custom functions like this
		customApp.testFunction()

	});

	customApp.testFunction = function()
		{
			//add functions like this
		}

}(window.jQuery || window.$));