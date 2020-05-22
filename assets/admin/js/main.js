$(document).ready(function() {
	$('#main-script').remove();

	var date = new Date();
	yearNow = date.getFullYear();
	$('.yearNow').text(yearNow);

	/*$('.treeview').on('click', function(e) {
		console.log(e.isDefaultPrevented);
	});*/

	$('ul').tree({
		'followLink': true
	});

	$(function() {
		/*$('.treeview').on('click', function() {
			$('.domain-project-content').removeClass('active');
			var targetContent = $(this).attr('target-content');
			contentBody = $(this).parents().eq(2).next().find('#admin-content-body');

			contentBody.find('#'+targetContent).addClass('active');
		});*/
	});

	$("img.profile-photo").on('click', function() {
		$(this).next('input').trigger('click');
	});

	$('[cloned-tag="profile-photo"]').on('change', function() {
		readURL(this);
	});

	$('.barChart').each(function(i, elem) {
		var cBar = elem;
		drawCharts(cBar);
	});

	$('form.regen-keys').on('submit', function(e) {
		e.preventDefault();
		e.returnValue;
		$.ajaxq('ReGenKeys', {
			url : $(this).attr('action'),
			type: 'post',
			dataType : 'json',
			data: $(this).serialize(),
			success : function(data) {
				/*console.log(data);*/
				if (data) {
					$('a#'+data.id).attr('href', 'generate_files/'+data.app_key);
					$('#app_key_'+data.id).val(data.app_key);
				}
			}
		});
	});

	$('span.fa-file-archive-o').off('click').on('click', function(e) {
		e.preventDefault(); e.returnValue;
		var oThis = $(this);
		// console.log($(this).parent('h3').next('.form-origin'))
		var oSettings = {
			url : 'projects/archive',
			type: 'post',
			dataType : 'json',
			data: oThis.parent('h3').next('.form-origin').serialize(),
			success : function(data) {
				/*console.log(data);*/
				if (data) {
					oThis.parent('h3').parents('.box:first').remove();
					$('#origin-name-'+data.id).parents('.treeview:first').remove();
					$('#app-files-'+data.id).remove();
					$('#regen-keys-'+data.id).remove();
					call_toast({header: 'SUCCESS', body: 'Project has been archived!'});
				}
			}
		};
		call_toast({
			header: 'INFO',
			body: 'Do you want to archive this project?',
			footer: {
				yes: {
					event: 'click',
					action: function() {
						$.ajaxq('archiveProject', oSettings);
					}
				}
			}
		});
	});

	$('.origin-name').off('click').on('click', 'span.fa-pencil', function(e) {
		e.preventDefault(); e.returnValue;
		$(this).parent('h3').next('.form-origin').toggle();
		$(this).parent('h3').toggle();
	});

	$('.form-origin').off('click').on('click', 'button.btn-danger', function(e) {
		e.preventDefault(); e.returnValue;
		$(this).parents('form:first').prev('.origin-name').toggle();
		$(this).parents('form:first').toggle();
	});

	$('#url-protocol').on('change', function(e) {
		if ($.trim($('#url-name').val()) != '') {
			$('#url-name').removeClass('input-error').removeAttr('title');
			var regex = /((?:https\:\/\/)|(?:http\:\/\/)|(?:www\.))?([a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(?:\??)[a-zA-Z0-9\-\._\?\,\'\/\\\+&%\$#\=~]+)/gi
			var matches = $.trim($('#url-name').val()).match(regex);
			if (matches == null) {
				var matches = $.trim($('#url-name').val()).match(/\b(?:(?:2(?:[0-4][0-9]|5[0-5])|[0-1]?[0-9]?[0-9])\.){3}(?:(?:2([0-4][0-9]|5[0-5])|[0-1]?[0-9]?[0-9]))\b/);
				if (matches == null) {
					$('#url-name').addClass('input-error').attr('title', 'This is not a valid website domain!').tooltip({placement:'bottom'});
				} else {
					$('input#url-name').tooltip('destroy');
					var url = $('#url-protocol').val() + $('#url-name').val();
					$('#url-origin').val(url);
					$('#url-domain').val($('#url-name').val());
				}
			} else {
				$('input#url-name').tooltip('destroy');
				var url = $('#url-protocol').val() + matches[0];
				var a = document.createElement("a"); a.href = url;
				$('#url-name').val(a.hostname+a.pathname);
				$('#url-origin').val(a.origin+a.pathname);
				$('#url-domain').val(a.hostname);
			}
		}
	});

	$('input#url-name').on('change', function(e) {
		if ($.trim($('#url-name').val()) != '') {
			$('#url-name').removeClass('input-error').removeAttr('title');
			var regex = /((?:https\:\/\/)|(?:http\:\/\/)|(?:www\.))?([a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(?:\??)[a-zA-Z0-9\-\._\?\,\'\/\\\+&%\$#\=~]+)/gi
			var matches = $.trim($('#url-name').val()).match(regex);
			if (matches == null) {
				var matches = $.trim($('#url-name').val()).match(/\b(?:(?:2(?:[0-4][0-9]|5[0-5])|[0-1]?[0-9]?[0-9])\.){3}(?:(?:2([0-4][0-9]|5[0-5])|[0-1]?[0-9]?[0-9]))\b/);
				if (matches == null) {
					$('#url-name').addClass('input-error').attr('title', 'This is not a valid website domain!').tooltip({placement:'bottom'});
				} else {
					$('input#url-name').tooltip('destroy');
					var url = $('#url-protocol').val() + $('#url-name').val();
					$('#url-origin').val(url);
					$('#url-domain').val($('#url-name').val());
				}
			} else {
				$('input#url-name').tooltip('destroy');
				var url = $('#url-protocol').val() + matches[0];
				var a = document.createElement("a"); a.href = url;
				$('#url-name').val(a.hostname+a.pathname);
				$('#url-origin').val(a.origin+a.pathname);
				$('#url-domain').val(a.hostname);
			}
		}
	});

	$('.form-origin').off('submit').on('submit', function(e) {
		e.preventDefault(); e.stopPropagation(); e.returnValue;
		var oThis = $(this);
		$.ajaxq('saveOriginName', {
			url : oThis.attr('action'),
			type: 'post',
			dataType : 'json',
			data: oThis.serialize(),
			success : function(data) {
				/*console.log(data);*/
				if (data) {
					oThis.toggle();
					oThis.prev('.origin-name').toggle().find('font').text(data.origin);
					$('#origin-name-'+data.id).text(data.domain);
					$('#app_key_'+data.id).val(data.app_key).parents('.form-group').find('label').text(data.domain + ' APP KEY');
					$('a#'+data.id).attr('href', 'generate_files/'+data.app_key).find('strong code').text(data.domain);
				}
			}
		});
	});

	$('.form-add-domain').off('submit').on('submit', function(e) {
		var oThis = $(this);
		oThis.find('input#url-name').removeClass('input-error').removeAttr('title');
		if ($.trim(oThis.find('input#url-name').attr('type')) == 'text' || oThis.find('input#url-name').data('type') == 'url') {
			var regex = /((?:https\:\/\/)|(?:http\:\/\/)|(?:www\.))?([a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(?:\??)[a-zA-Z0-9\-\._\?\,\'\/\\\+&%\$#\=~]+)/gi
			var matches = $.trim(oThis.find('input#url-name').val()).match(regex);
			if (matches == null) {
				var matches = $.trim(oThis.find('input#url-name').val()).match(/\b(?:(?:2(?:[0-4][0-9]|5[0-5])|[0-1]?[0-9]?[0-9])\.){3}(?:(?:2([0-4][0-9]|5[0-5])|[0-1]?[0-9]?[0-9]))\b/);
				if (matches == null) {
					oThis.find('input#url-name').addClass('input-error').attr('title', 'This is not a valid website domain!').tooltip({placement:'bottom'});
					e.preventDefault(); e.stopPropagation(); e.returnValue;
					bValid = false;
				} else {
					oThis.find('input#url-name').tooltip('destroy');
					var url = $('#url-protocol').val() + oThis.find('input#url-name').val();
					$('#url-origin').val(url);
					$('#url-domain').val(oThis.find('input#url-name').val());
				}
			} else {
				oThis.find('input#url-name').tooltip('destroy');
				var url = $('#url-protocol').val() + matches[0];
				var a = document.createElement("a"); a.href = url;
				oThis.find('input#url-name').val(a.hostname+a.pathname);
				$('#url-origin').val(a.origin+a.pathname);
				$('#url-domain').val(a.hostname);
			}
		}
		if (oThis.find('input#package_type').val() == '') {
			e.preventDefault(); e.stopPropagation(); e.returnValue;
		}
	});

	if ($(".calculatorSlider").length) {
		var sliderUIs = $(".calculatorSlider");
		var license = oLicense;

		var loadValue = 1;
		sliderUIs.each(function(i, slider){
			var projectID = slider.id;
			var payloadLimit = $(slider).parents('.box-body:first').find(".payloadLimit");
			var clientPrice = $(slider).parents('.box-body:first').find(".clientPrice");
			var clientPriceVal = $(slider).parents('.box-body:first').find(".clientPriceVal");
			var paypalFormHolder = $(slider).parents('.box-body:first').next('.box-footer');
			// calculate($(slider), license.corpo.price, parseInt(loadValue), payloadLimit, clientPrice, paypalFormHolder, clientPriceVal);
			
			$(slider).off("input change").on("input change", function() {
				var price = 1000;
				if (license.priv.active) {
					price = license.priv.price;
				} else if (license.corpo.active) {
					price = license.corpo.price;
				} else if (license.enterprise.active) {
					price = license.enterprise.price;
				}
				calculate($(slider), price, $(slider).val(), payloadLimit, clientPrice, paypalFormHolder, clientPriceVal);
			});

			var obj = oUserProjects[projectID].sub1.data;
			if (obj) {
				if (obj.package_type == 'Customed') {
					if (obj.payload != undefined) {
						loadValue = obj.payload / 1000;
						$(slider).attr('value', loadValue);
						$(slider).attr('data-value', loadValue);
					}
					var price = 1000;
					if (license.priv.active) {
						price = license.priv.price;
					} else if (license.corpo.active) {
						price = license.corpo.price;
					} else if (license.enterprise.active) {
						price = license.enterprise.price;
					}
					calculate($(slider), price, parseInt(loadValue), payloadLimit, clientPrice, paypalFormHolder, clientPriceVal);
				} else if (obj.package_type == 'Free' || obj.payload == MAX_FREE_PAYLOAD) {
					$(slider).attr('value', 1);
					$(slider).attr('data-value', 1);
					var price = 1000;
					if (license.priv.active) {
						price = license.priv.price;
					} else if (license.corpo.active) {
						price = license.corpo.price;
					} else if (license.enterprise.active) {
						price = license.enterprise.price;
					}
					calculate($(slider), price, 1, payloadLimit, clientPrice, paypalFormHolder, clientPriceVal);
				}
			}

			$(slider).slider();
			$(slider).parents('.range-field:first').on('mouseover', function() {
				var price = 1000;
				if (license.priv.active) {
					price = license.priv.price;
				} else if (license.corpo.active) {
					price = license.corpo.price;
				} else if (license.enterprise.active) {
					price = license.enterprise.price;
				}
				calculate($(slider), price, $(slider).val(), payloadLimit, clientPrice, paypalFormHolder, clientPriceVal);
			});
		});

		function calculate(slider, price, value, payloadLimit, clientPrice, paypalFormHolder, clientPriceVal) {
			// console.log(value)
			var newLimit = Math.round(value * 10000);
			payloadLimit.text(newLimit);
			if ((value * 1000) == 0) {
				clientPrice.text(Math.round(formatMoney(0)));
				clientPriceVal.val(Math.round(0));
			} else {
				var percentageFee = DEFAULT_PAYLOAD_FEE;
				if (license.priv.active) {
					percentageFee = license.priv.percentage;
				} else if (license.corpo.active) {
					percentageFee = license.corpo.percentage;
				} else if (license.enterprise.active) {
					percentageFee = license.enterprise.percentage;
				}
				var newPrice = Math.round(((value * 300) + price) * percentageFee);
				newPrice = Math.round(newPrice / 39);
				clientPrice.text(formatMoney(newPrice));
				clientPriceVal.val(newPrice);

				var projectID = slider.attr('id');
				var obj = oUserProjects[projectID].sub1.data;
				if (obj.package_type == 'Customed') {
					// console.log(obj, projectID);
					slider.attr('value', parseInt(newLimit) / 10000);
					slider.attr('data-value', parseInt(newLimit) / 10000);
				}
			}
		}
	}

	if ($('#test_transfer').length) {
		var sentCount = 0;
		pushthru = new PushThru(APP_KEY, {
			// autoConnect: true,
			autoRunStash: true
		}); /*initialize pushthru app*/
		$('#connect_app:not([disabled])').off('click').on('click', function(e) {
			sentCount = 0;
			if (pushthru == null || (pushthru && pushthru.app.connected == false)) {
				$('#connect_app').attr('disabled', 'disabled').find('span').text('Connecting');
			}
			$('#error_transfer').addClass('hide').find('p').text("Something's not right?");
			if (typeof PushThru != 'undefined') {
				pushthru.connect(function(app) {
					if (app.connected) {
						$('#connect_app').attr('disabled', 'disabled').find('span').text('Connected');
						$('#disconnect_app').removeAttr('disabled').find('span').text('Disconnect');
						$('#transfer_data').removeAttr('disabled').focus();
						$('#send_data').removeAttr('disabled');
						pushthru.bind('send-data', 'test-transfer', function(obj) {
							$('#test_overlay').addClass('hide');
							var text = $('#transfered_data').text();
							var data = obj.data, message = text;
							for(x in obj) {
								if (x == 'data') {
									message += x.ucwords()+': '+($.trim(data.message) == '' ? 'No data' : data.message)+'\n';
								} else {
									message += x.ucwords()+': '+obj[x]+'\n';
								}
							}
							$('#transfered_data').text(message+'Id: '+data.sessionid+'\n\n');
							if ($('#transfered_data').length) {
								$('#transfered_data').scrollTop($('#transfered_data')[0].scrollHeight - $('#transfered_data').height());
							}
						});
					}
				});
			}
		});
		$('#disconnect_app[disabled]').off('click').on('click', function(e) {
			$('#error_transfer').addClass('hide').find('p').text("Something's not right?");
			if (pushthru != null && pushthru.app.connected) {
				$('#disconnect_app').attr('disabled', 'disabled').find('span').text('Disconnecting');
				pushthru.disconnect(function(app) {
					if (app.connected == false) {
						$('#connect_app').removeAttr('disabled').find('span').text('Connect');
						$('#transfer_data').attr('disabled', 'disabled').val('');
						$('#send_data').attr('disabled', 'disabled');
						$('#disconnect_app').attr('disabled', 'disabled').find('span').text('Disconnected');
					}
				});
			}
		});
		$('#send_data').off('click').on('click', function(e) {
			$('#error_transfer').addClass('hide').find('p').text("Something's not right?");
			if (pushthru != null) {
				if (pushthru.app.connected) {
					sentCount = sentCount+1;
					pushthru.trigger('send-data', 'test-transfer', {
						'count': sentCount,
						'message': $('#transfer_data').val(),
						'sessionid': pushthru.app.sessionid
					});
					$('#test_overlay').removeClass('hide');
				} else {
					$('#error_transfer').removeClass('hide').find('p').text('App not connected, click connect button first!');
				}
			} else {
				$('#error_transfer').removeClass('hide').find('p').text('App not connected, click connect button first!');
			}
		});
	}
});

function setSession(id) {
	$.ajaxq('Session', {
		url: 'admin/set_session/'+id,
	});
}

function readURL(input) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function(e) {
			$('img.'+$(input).attr('cloned-tag')).attr('src', e.target.result);
			$('input:hidden.'+$(input).attr('cloned-tag')).val(e.target.result);
		}
		reader.readAsDataURL(input.files[0]);
	}
}

function drawCharts(cBar) {
	/*BAR CHART*/
	if ($(cBar).length) {
		$.ajaxq('barChart', {
			url : "admin/get_charts/"+$(cBar).attr('project-id'),
			dataType : 'json',
			success : function(data) {
				cBar = cBar.getContext("2d");
				var barData = { labels: data.labels, datasets: data.records };
				window.barChart = new Chart(cBar, {
					type: 'bar',
					data: barData,
					options:{
						responsive: true,
						title: {
							display: true,
							text: "Current Year - Payload Statistics"
						},
						legend: {
							display: false
						},
						scales: {
							yAxes: [{
								scaleLabel: {
									display: true,
									labelString: 'Number of sent data'
								},
								ticks: {
									min: 0,
									max: Math.ceil((parseInt(data.yMax)+1)/10)*10,
									beginAtZero: true,
									callback: function(value, index, values) {
										if (Math.floor(value) === value) {
											return value;
										}
									}
								}
							}],
							xAxes: [{
								scaleLabel: {
									display: true,
									labelString: 'Weekly sent data'
								}
							}]
						},
						tooltips: {
							callbacks: {
								title: function(tooltipItem, chartData) {
									return tooltipItem[0].xLabel+"\n"+tooltipItem[0].yLabel+' payload sent';
								},
								label: function(tooltipItem, chartData) {
									return data.date_range[tooltipItem.index];
								}
							}
						}
					}
				});
			}
		});
	}
}

function getRandomColor() {
	var letters = '0123456789ABCDEF';
	var color = '#';
	for (var i = 0; i < 6; i++) {
		color += letters[Math.floor(Math.random() * 16)];
	}
	return color;
}

function formatMoney(n, c, d, t) {
	var c = isNaN(c = Math.abs(c)) ? 0 : c,
	d = d == undefined ? "" : d,
	t = t == undefined ? "," : t,
	s = n < 0 ? "-" : "",
	i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
	j = (j = i.length) > 3 ? j % 3 : 0;

	return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
}

function call_toast(obj) {
	$('.toast-overlay').hide();
	$('.toast-overlay').off('click').on('click', function() {
		$('.toast-overlay').hide();
	});
	if (obj != undefined) {
		var toast = $('.toast-overlay').find('.toast').children();
		// console.log(toast);
		var header = toast[0];
		if (obj.header == undefined) obj.header = '';
		$(header).find('strong').text(obj.header);
		$(header).find('button.close').off('click').on('click', function() {
			$('.toast-overlay').hide();
			if (typeof obj.close == 'function') {
				obj.close();
			}
		});
		
		var body = toast[1];
		if (obj.body == undefined) obj.body = 'No message';
		$(body).html(obj.body);
		
		var footer = toast[2];
		$(footer).find('.btn-group').find('button').hide();
		$(footer).find('.btn-group').find('button:first').text('Yes');
		$(footer).find('.btn-group').find('button:last').text('No');
		// console.log(obj.footer);
		if (obj.footer != undefined) {
			if (obj.footer.yes != undefined) {
				if (obj.footer.yes.name == undefined) {
					btnName = 'Yes';
				} else {
					btnName = obj.footer.yes.name;
				}
				$(footer).find('.btn-group').find('button:first').text(btnName).show();
				if (obj.footer.yes.event == undefined) {
					btnEvent = 'click';
				} else {
					btnEvent = obj.footer.yes.event;
				}
				$(footer).find('.btn-group').find('button:first').off(btnEvent).on(btnEvent, function() {
					$('.toast-overlay').hide();
					if (typeof obj.footer.yes.action == 'function') {
						obj.footer.yes.action();
					}
				});
			}
			if (obj.footer.no != undefined) {
				if (obj.footer.no.name == undefined) {
					btnName = 'No';
				} else {
					btnName = obj.footer.no.name;
				}
				$(footer).find('.btn-group').find('button:last').text(btnName).show();
				if (obj.footer.no.event == undefined) {
					btnEvent = 'click';
				} else {
					btnEvent = obj.footer.no.event;
				}
				$(footer).find('.btn-group').find('button:last').off(btnEvent).on(btnEvent, function() {
					$('.toast-overlay').hide();
					if (typeof obj.footer.no.action == 'function') {
						obj.footer.no.action();
					}
				});
			} else {
				$(footer).find('.btn-group').find('button:last').text('Close').show();
				$(footer).find('.btn-group').find('button:last').off('click').on('click', function() {
					$('.toast-overlay').hide();
				});
			}
		}
		$('.toast-overlay').show();
	}
}

String.prototype.ucwords = function() {
	str = this.toLowerCase();
	return str.replace(/(^([a-zA-Z\p{M}]))|([ -][a-zA-Z\p{M}])/g,
		function(s){
			return s.toUpperCase();
		});
};