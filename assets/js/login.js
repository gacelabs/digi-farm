$(document).ready(function() {
	$('#login-switch').click(function() {

		$('#login').toggleClass('show hidden');
		$('#signup').toggleClass('hidden show');

		if ($(this).text() == "Sign up") {
			$(this).text("Log in");
		} else {
			$(this).text("Sign up");
		}

	});
});