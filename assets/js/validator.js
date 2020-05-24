$(document).ready(function() {
	jQuery.validator.addMethod('email_rule', function(value, element, param) {
		return /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/.test(value);
	}, 'Your E-mail is wrong');

	jQuery.validator.addMethod('phone_rule', function(value, element, param) {
		return /^((0|\+?63)((2 ?[3-9]|3 ?[4-9]|7 ?[3-9])(\d{7}|\d{3} ?\d{4})|[8,4](\d{8}|\d{2} ?\d{3} ?\d{3}))|0500[\d]{6}|0550[\d]{6}|059[\d]{7}|13[\d]{4}|1300\d{6}|1800\d{6}|0198\d{2}|0198\d{6}|190\d{7})$/.test(value);
	}, 'Please enter a valid phone number');

	jQuery.validator.addMethod('password_rule', function(value, element, param) {
		var result = /*this.optional(element) ||*/ (/*value.length >= 6 && *//\d/.test(value)/* && /[a-z]/i.test(value)*/);
		if ($('#retype_password:visible').length) {
			if ($.trim(value) != $.trim($('#retype_password').val())) {
				result = false;
			}
		}
		return result;
	}, 'Please enter a valid password');

	var forms = $('.form-validate');

	forms.each(function(i, elem) {
		var form = $(elem);
		// var recaptcha = form.find('.g-recaptcha');
		form.validate({
			ignore: '.ignore',
			debug: true,
			/*invalidHandler: function (e, validator) {
				var errors = validator.numberOfInvalids();
				console.log(errors, e, validator);
			},*/
			errorPlacement: function(error, element) {
				if (element.prop('tagName') === 'SELECT' && element.hasClass('chosen-select')) {
					element.parent().find('.chosen-container-single').addClass('error');
				}
				if (element.attr('type') === 'file' && element.hasClass('custom-file-input')) {
					element.parents('.input-group').addClass('error');
				}
				element.addClass('error');
			},
			highlight: function (element, errorClass, validClass) {
				$(element).addClass('error');
			},
			unhighlight: function (element, errorClass, validClass) {
				$(element).removeClass('error');
			},
			rules: {
				'email_address': {
					required:  true,
					email_rule: true
				},
				'phone': {
					required: true,
					phone_rule: true
				},
				'password': {
					required: true,
					password_rule: true
				}
			},
			submitHandler: function(form) {
				form.submit();
				// grecaptcha.execute(window.parseInt(recaptcha.data('rendered-id')));
			}/*,
			messages: {
				retype_password: { 
					required: " ", 
					equalTo: "Please enter the same password as above" 
				},
				email_address: { 
					required: " ", 
					email: "Please enter a valid email address, example: you@yourdomain.com", 
					remote: jQuery.validator.format("{0} is already taken, please enter a different address.") 
				},
			}*/
		});
	});
});

// revised and moved the codes from down here to public\requirements\js\recaptcha-loader.js

/*$(document).ready(function () {
	$.mockjax({
		url: 'emails.action',
		response: function (settings) {
			var email = settings.data.email,
			emails = ["glen@marketo.com", "george@bush.gov", "me@god.com", "aboutface@cooper.com", "steam@valve.com", "bill@gates.com"];
			this.responseText = "true";
			if ($.inArray(email, emails) !== -1) {
				this.responseText = "false";
			}
		},
		responseTime: 500,
	});
	jQuery.validator.addMethod(
		"password",
		function (value, element) {
			var result = this.optional(element) || (value.length >= 6 && /\d/.test(value) && /[a-z]/i.test(value));
			if (!result) {
				element.value = "";
				var validator = this;
				setTimeout(function () {
					validator.blockFocusCleanup = true;
					element.focus();
					validator.blockFocusCleanup = false;
				}, 1);
			}
			return result;
		},
		"Your password must be at least 6 characters long and contain at least one number and one character."
		);
	jQuery.validator.addMethod(
		"defaultInvalid",
		function (value, element) {
			return value != element.defaultValue;
		},
		""
		);
	jQuery.validator.addMethod(
		"billingRequired",
		function (value, element) {
			if ($("#bill_to_co").is(":checked")) return $(element).parents(".subTable").length;
			return !this.optional(element);
		},
		""
		);
	jQuery.validator.messages.required = "";
	$("form").validate({
		invalidHandler: function (e, validator) {
			var errors = validator.numberOfInvalids();
			if (errors) {
				var message = errors == 1 ? "You missed 1 field. It has been highlighted below" : "You missed " + errors + " fields.  They have been highlighted below";
				$("div.error span").html(message);
				$("div.error").show();
			} else {
				$("div.error").hide();
			}
		},
		onkeyup: false,
		submitHandler: function () {
			$("div.error").hide();
			alert("submit! use link below to go to the other step");
		},
		messages: {
			password2: { 
				required: " ", 
				equalTo: "Please enter the same password as above" 
			},
			email: { 
				required: " ", 
				email: "Please enter a valid email address, example: you@yourdomain.com", 
				remote: jQuery.validator.format("{0} is already taken, please enter a different address.") 
			},
		},
		debug: true,
	});
	$(".resize").vjustify();
	$("div.buttonSubmit").hoverClass("buttonSubmitHover");
	$("input.phone").mask("(999) 999-9999");
	$("input.zipcode").mask("99999");
	var creditcard = $("#creditcard").mask("9999 9999 9999 9999");
	$("#cc_type").change(function () {
		switch ($(this).val()) {
			case "amex":
			creditcard.unmask().mask("9999 999999 99999");
			break;
			default:
			creditcard.unmask().mask("9999 9999 9999 9999");
			break;
		}
	});
	var subTableDiv = $("div.subTableDiv");
	var toggleCheck = $("input.toggleCheck");
	toggleCheck.is(":checked") ? subTableDiv.hide() : subTableDiv.show();
	$("input.toggleCheck").click(function () {
		if (this.checked == true) {
			subTableDiv.slideUp("medium");
			$("form").valid();
		} else {
			subTableDiv.slideDown("medium");
		}
	});
});
$.fn.vjustify = function () {
	var maxHeight = 0;
	$(".resize").css("height", "auto");
	this.each(function () {
		if (this.offsetHeight > maxHeight) {
			maxHeight = this.offsetHeight;
		}
	});
	this.each(function () {
		$(this).height(maxHeight);
		if (this.offsetHeight > maxHeight) {
			$(this).height(maxHeight - (this.offsetHeight - maxHeight));
		}
	});
};
$.fn.hoverClass = function (classname) {
	return this.hover(function () {
		$(this).addClass(classname);
	}, function () {
		$(this).removeClass(classname);
	});
};*/
