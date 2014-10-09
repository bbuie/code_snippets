<script type="text/javascript">
	// remap jQuery to $
	(function($){
		
		var popup = new Object;	
		popup.init = function(settings) {	
			
			//check that the end date has not happened
			var today = new Date();
			var endDate = new Date(settings.endDate);
			var dateDifference = (endDate - today)/1000/60/60/24; //difference in days
			
			//only show popup if before end date
			if(dateDifference > 0){
				// Only show popup if we can use cookies
				if(popup.cookiesOn()) {
					if(!$.cookie(settings.cookieName)) {
						//setTimeout(popup.show(settings.cookieName), settings.delay);
						
					}
				}
			}
			
			popup.show(settings.cookieName);
			popup.close();
		}
		
		// Determine if cookies are enabled or not, we don't want to show this repeatedly to visitors w/o cookies
		popup.cookiesOn = function() {
		
			var cookieEnabled = (navigator.cookieEnabled) ? true : false;
			if ( typeof navigator.cookieEnabled == "undefined" && !cookieEnabled) {
				document.cookie = "testcookie";
				cookieEnabled = (document.cookie.indexOf("testcookie") != -1) ? true : false;
			}
			return (cookieEnabled);
		}
		
		// Show a popup and set a cookie so the popup doesn't happen again
		popup.show = function(cookieName) {
			// Set a cookie so the popup only opens once
			$.cookie(cookieName, "yes", {
				expires : 365,
				path : '/'
			});
			$('.popupModal').show();
		}
		
		//close functionality for popup
		popup.close = function(){
			$('.popupClose, .modalBg').click(function(){
				$(this).closest('.popupModal').hide();
			});
		}
		
		//delete the cookie for testing
		popup.reset = function(cookieName){
			$.removeCookie(cookieName, { expires: 365, path: '/' }); // delete a cookie
		}

		/* trigger when page is ready */
		$(document).ready(function (){
			
			//popup.reset('gettv');	
			popup.init({
				delay: 1, //this is the time it will take to show
				cookieName: 'gettv',
				endDate: '2014-04-16'
			});
			

		});
		
	})(window.jQuery);
</script>