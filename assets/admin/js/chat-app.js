
	function formatDate(date, type) {
		if (date == undefined) date = new Date();
		if (type == undefined) type = 0;
		var monthNames = [
			"January", "February", "March",
			"April", "May", "June", "July",
			"August", "September", "October",
			"November", "December"
		];
		var hours = date.getHours();
		var minutes = date.getMinutes();
		var ampm = hours >= 12 ? 'pm' : 'am';
		hours = hours % 12;
		hours = hours ? hours : 12; // the hour '0' should be '12'
		minutes = minutes < 10 ? '0'+minutes : minutes;
		var strTime = hours + ':' + minutes + ' ' + ampm;
		// return date.getMonth()+1 + "/" + date.getDate() + "/" + date.getFullYear() + (notime ? "" : "  " + strTime);
		var mdy = monthNames[date.getMonth()] + " " + date.getDate() + ", " + date.getFullYear();

		if (type == 2) { /*time only*/
			return strTime;
		} else if (type == 1) { /*date only*/
			return mdy;
		} else { /*datetime*/
			return mdy + "  " + strTime;
		}
	}

	function IDGenerator() {
		this.length = 8;
		this.timestamp = +new Date;

		var _getRandomInt = function( min, max ) {
			return Math.floor( Math.random() * ( max - min + 1 ) ) + min;
		}

		this.generate = function() {
			var ts = this.timestamp.toString();
			var parts = ts.split( "" ).reverse();
			var id = "";

			for( var i = 0; i < this.length; ++i ) {
				var index = _getRandomInt( 0, parts.length - 1 );
				id += parts[index];	 
			}
			return id;
		}
	}

	function styleCloud(obj, position, lastTime, callBack) {
		var sTime = formatDate();
		// console.log(sTime, formatDate(lastTime));
		if (sTime == formatDate(lastTime)) {
			if ($('.myid-'+obj.data.id).length > 1) {
				var src = $('.myid-'+obj.data.id+':first').find('.direct-chat-img').attr('src');
				$('.myid-'+obj.data.id+':not(:last)').each(function(i, elem) {
					if ($(elem).prev().length == 0 || $(elem).prev().hasClass('myid-'+obj.data.id)) {
						$(elem).find('.direct-chat-text').css('border-bottom-'+position+'-radius', 0);
						$(elem).find('.direct-chat-img').replaceWith('<div class="direct-chat-img" src="'+src+'"></div>');
						$(elem).find('.direct-chat-text').addClass('no-arrow');
					}
					if ($(elem).css('line-height') != '21px') {
						$(elem).css({'margin-bottom':0, 'line-height':1.8});
					}
				});
				$('.myid-'+obj.data.id+':first').css({'margin-bottom':0, 'line-height':1.5});
				$('.myid-'+obj.data.id+':last').find('.direct-chat-info').remove();
				$('.myid-'+obj.data.id+':last').find('.direct-chat-msg').css('margin-bottom', 0);
				if (position == 'left') {
					$('.myid-'+obj.data.id+':last').find('.direct-chat-text').css({'border-top-left-radius':0, 'margin-top':0});
				} else {
					$('.myid-'+obj.data.id+':last').find('.direct-chat-text').css({'border-top-right-radius':0, 'margin-top':0});
				}
			}
		} else {
			callBack();
		}
	}

	var IDClass = new IDGenerator();
	var iMYId = IDClass.generate();
	/*initialize pushthru app*/
	var pushthru = new PushThru('66CD77215D7C92B6FD862BAEB831AF3A', {
		debug: false, /*set to true to see debugger in console*/
		autoConnect: false, /*set to true to auto connect*/
		autoRunStash: true /*set to false to disable previous sent data*/
	});

	$(document).ready(function() {
		/*Function to connect to data server*/
		if (pushthru != undefined) {
			pushthru.connect(function(app) {
				if (app.connected) {
					pushthru.app.options.autoConnect = true;
					// pushthru.bind('send-msg', pushthru.app.sessionid, function(obj) {
					pushthru.bind('send-msg', 'msg-channel', function(obj) {
						var data = obj.data.message;
						var lastTime = new Date();
						var castTime = formatDate(new Date(obj.when));
						if (iMYId == obj.data.id) {
							$('#mine').find('.direct-chat-text').html(data.replace(new RegExp('\n', 'g'), '<br>')).attr('title', castTime);
							$('#mine').find('.direct-chat-timestamp').text(castTime);
							var msgBox = $('#mine').clone().removeAttr('id').addClass('myid-'+obj.data.id), position = 'right';
						} else {
							$('#theirs').find('.direct-chat-text').html(data.replace(new RegExp('\n', 'g'), '<br>')).attr('title', castTime);
							$('#theirs').find('.direct-chat-timestamp').text(castTime);
							var msgBox = $('#theirs').clone().removeAttr('id').addClass('myid-'+obj.data.id), position = 'left';
						}
						if ($('.myid-'+obj.data.id+':last').find('.direct-chat-text').length) {
							lastTime = new Date($('.myid-'+obj.data.id+':last').find('.direct-chat-text').attr('title'));
						}
						$('div.direct-chat-messages').append(msgBox);
						styleCloud(obj, position, lastTime, function() {
							$('.myid-'+obj.data.id+':last').css({'margin-bottom':0, 'line-height':1.5}).find('.direct-chat-timestamp').text(formatDate(new Date(obj.when), 2)).attr('title', formatDate(new Date(obj.when), 1));
							$('.myid-'+obj.data.id+':last').prev().find('.direct-chat-text').css('border-bottom-'+position+'-radius', 20);
						});
						if ($('.direct-chat-messages').length) {
							$('.direct-chat-messages').scrollTop($('.direct-chat-messages')[0].scrollHeight - $('.direct-chat-messages').height());
						}
					});
				}
			});
		}
		/*Function to transmit data to client in the same channel in real-time*/
		$('#send_data').off('click').on('click', function(e) {
			/*Function to transmit data to client in the same channel in real-time*/
			if (pushthru != undefined) {
				if (pushthru.app.is_loaded) {
					var sMessage = $('#message').val();
					if ($.trim(sMessage) != '') {
						// pushthru.trigger('send-msg', pushthru.app.sessionid, {
						pushthru.trigger('send-msg', 'msg-channel', {
							'id': iMYId,
							'message': sMessage,
							'sessionid': pushthru.app.sessionid
						});
					}
					$('#message').val('');
				}
			}
		});

		// console.log($(parent.document.body).find('iframe'));
		var iframe = $(parent.document.body).find('iframe');
		iframe.css({'box-shadow': '0px 0px 10px 10px #d8d8d8'});
		$('[data-widget="collapse"]').bind('click', function(e) {
			if ($(e.target).closest('.box').hasClass('collapsed-box') == false) {
				iframe.css({'box-shadow': 'unset'});
				$(e.target).closest('.box').siblings().addClass('hide');
				$(e.target).closest('.box').find('.heading').toggle('blind', function() {
					iframe.css({
						'box-shadow': '0px 0px 10px 10px #d8d8d8', 
						'border-radius': '100%', 
						'max-height': '50px', 
						'max-width': '50px'
					});
				});
			} else {
				$(e.target).closest('.box').find('.heading').toggle('blind', function() {
					iframe.css({'border-radius': '4px', 'max-height': '359px', 'max-width': '100%'});
					$(e.target).closest('.box').siblings().removeClass('hide');
				});
			}
		});
	});

	window.onbeforeunload = function() {
		console.log(pushthru.app);
		return;
	}