<section class="content">
	<div class="row">
		<div class="col-md-4">
			<div class="box box-danger">
				<div class="box-header with-border">
					<h3 class="box-title">Test data transfer</h3>
				</div>
				<div class="box-body">
					<div class="callout callout-info hide" id="error_transfer">
						<h4>Info</h4>
						<p>Something's not right?</p>
					</div>
					<form role="form" onsubmit="return false;" id="test_transfer">
						<a class="btn btn-app bg-green" id="connect_app"><i class="fa fa-plug"></i> <i class="fa fa-link hide"></i> <span>Connect</span></a>
						<a class="btn btn-app bg-red" id="disconnect_app" disabled="disabled"><i class="fa fa-power-off"></i> <span>Disconnected</span></a>
						<div class="input-group">
							<input type="text" id="transfer_data" placeholder="Type data to transfer ..." class="form-control" disabled="disabled">
							<span class="input-group-btn">
								<button type="submit" class="btn btn-success btn-flat" id="send_data" disabled="disabled">Send&nbsp;<i class="fa fa-send-o"></i></button>
							</span>
						</div>
						<br>
						<div class="form-group">
							<label>Transfered Data</label>
							<textarea class="form-control" rows="10" placeholder="No data received yet ..." disabled="disabled" style="resize: none; height: 960px;" id="transfered_data"></textarea>
						</div>
					</form>
				</div>
				<div id="test_overlay" class="overlay hide">
					<i class="fa fa-refresh fa-spin"></i>
				</div>
			</div>
		</div>
		<div class="col-md-8">
			<div class="box box-danger">
				<div class="box-header with-border">
					<h3 class="box-title">Sample code</h3>
				</div>
				<div class="box-body">
					<pre style="font-size: x-small; background: #342e2e; color: #c8c3c3;">
						<code>
<span style="color: #ad13ad;">var</span> sentCount <span style="color: orange;">=</span> 0;
<span style="color: gray;">/*initialize pushthru app*/</span>
<span style="color: #ad13ad;">var</span> pushthru <span style="color: orange;">=</span> <span style="color: orange;">new</span> PushThru(<span style="color: #ff7243;">APP_KEY</span>, {
  debug: <span style="color: #6161e7;">false</span>, <span style="color: gray;">/*set to true to see debugger in console*/</span>
  autoConnect: <span style="color: #6161e7;">false</span>, <span style="color: gray;">/*set to true to auto connect*/</span>
  autoRunStash: <span style="color: #6161e7;">true</span> <span style="color: gray;">/*set to false to disable previous sent data*/</span>
});
<span style="color: gray;">/*Function to connect to data server*/</span>
$(<span style="color: #25c825;">'#connect_app:not([disabled])'</span>).off(<span style="color: #25c825;">'click'</span>).on(<span style="color: #25c825;">'click'</span>, <span style="color: #ad13ad;">function</span>(e) {
  sentCount <span style="color: orange;">=</span> 0;
  <span style="color: orange;">if</span> (pushthru <span style="color: orange;">==</span> <span style="color: #6161e7;">null</span> <span style="color: orange;">||</span> (pushthru <span style="color: orange;">&&</span> pushthru.app.connected <span style="color: orange;">==</span> <span style="color: #6161e7;">false</span>)) {
    $(<span style="color: #25c825;">'#connect_app'</span>).attr(<span style="color: #25c825;">'disabled'</span>, <span style="color: #25c825;">'disabled'</span>).find(<span style="color: #25c825;">'span'</span>).text(<span style="color: #25c825;">'Connecting'</span>);
  }
  $(<span style="color: #25c825;">'#error_transfer'</span>).addClass(<span style="color: #25c825;">'hide'</span>).find(<span style="color: #25c825;">'p'</span>).text(<span style="color: #25c825;">"Something's not right?"</span>);
  <span style="color: orange;">if</span> (<span style="color: orange;">typeof</span> <span style="color: #ff7243;">PushThru</span> <span style="color: orange;">!=</span> <span style="color: #25c825;">'undefined'</span>) {
    pushthru.connect(<span style="color: #ad13ad;">function</span>(app) {
      <span style="color: orange;">if</span> (app.connected) {
        $(<span style="color: #25c825;">'#connect_app'</span>).attr(<span style="color: #25c825;">'disabled'</span>, <span style="color: #25c825;">'disabled'</span>).find(<span style="color: #25c825;">'span'</span>).text(<span style="color: #25c825;">'Connected'</span>);
        $(<span style="color: #25c825;">'#disconnect_app'</span>).removeAttr(<span style="color: #25c825;">'disabled'</span>).find(<span style="color: #25c825;">'span'</span>).text(<span style="color: #25c825;">'Disconnect'</span>);
        $(<span style="color: #25c825;">'#transfer_data'</span>).removeAttr(<span style="color: #25c825;">'disabled'</span>).focus();
        $(<span style="color: #25c825;">'#send_data'</span>).removeAttr(<span style="color: #25c825;">'disabled'</span>);
        pushthru.bind(<span style="color: #25c825;">'send-data'</span>, <span style="color: #25c825;">'test-transfer'</span>, <span style="color: #ad13ad;">function</span>(obj) {
          $(<span style="color: #25c825;">'#test_overlay'</span>).addClass(<span style="color: #25c825;">'hide'</span>);
          <span style="color: #ad13ad;">var</span> text <span style="color: orange;">=</span> $(<span style="color: #25c825;">'#transfered_data'</span>).text();
          <span style="color: #ad13ad;">var</span> data <span style="color: orange;">=</span> obj.data, message <span style="color: orange;">=</span> text;
          <span style="color: orange;">for</span>(x <span style="color: orange;">in</span> obj) {
            <span style="color: orange;">if</span> (x <span style="color: orange;">==</span> <span style="color: #25c825;">'data'</span>) {
              message <span style="color: orange;">+=</span> x.ucwords()<span style="color: orange;">+</span><span style="color: #25c825;">': '</span><span style="color: orange;">+</span>($.trim(data.message) <span style="color: orange;">==</span> <span style="color: #25c825;">''</span> ? <span style="color: #25c825;">'No data'</span> : data.message)<span style="color: orange;">+</span><span style="color: #25c825;">'</span><span style="color: #ad13ad;">\n</span><span style="color: #25c825;">'</span>;
            } else {
              message <span style="color: orange;">+=</span> x.ucwords()<span style="color: orange;">+</span><span style="color: #25c825;">': '</span><span style="color: orange;">+</span>obj[x]<span style="color: orange;">+</span><span style="color: #25c825;">'</span><span style="color: #ad13ad;">\n</span><span style="color: #25c825;">'</span>;
            }
          }
          $(<span style="color: #25c825;">'#transfered_data'</span>).text(message<span style="color: orange;">+</span><span style="color: #25c825;">'From: '</span><span style="color: orange;">+</span>data.sessionid<span style="color: orange;">+</span><span style="color: #25c825;">'</span><span style="color: #ad13ad;">\n\n</span><span style="color: #25c825;">'</span>);
          <span style="color: orange;">if</span> ($(<span style="color: #25c825;">'#transfered_data'</span>).length) {
            $(<span style="color: #25c825;">'#transfered_data'</span>).scrollTop($(<span style="color: #25c825;">'#transfered_data'</span>)[0].scrollHeight - $(<span style="color: #25c825;">'#transfered_data'</span>).height());
          }
        });
      }
    });
  }
});
<span style="color: gray;">/*Function to disconnect to data server*/</span>
$(<span style="color: #25c825;">'#disconnect_app[disabled]'</span>).off(<span style="color: #25c825;">'click'</span>).on(<span style="color: #25c825;">'click'</span>, <span style="color: #ad13ad;">function</span>(e) {
  $(<span style="color: #25c825;">'#error_transfer'</span>).addClass(<span style="color: #25c825;">'hide'</span>).find(<span style="color: #25c825;">'p'</span>).text(<span style="color: #25c825;">"Something's not right?"</span>);
  <span style="color: orange;">if</span> (pushthru <span style="color: orange;">!=</span> <span style="color: #6161e7;">null</span> <span style="color: orange;">&&</span> pushthru.app.connected) {
    $(<span style="color: #25c825;">'#disconnect_app'</span>).attr(<span style="color: #25c825;">'disabled'</span>, <span style="color: #25c825;">'disabled'</span>).find(<span style="color: #25c825;">'span'</span>).text(<span style="color: #25c825;">'Disconnecting'</span>);
    pushthru.disconnect(<span style="color: #ad13ad;">function</span>(app) {
      <span style="color: orange;">if</span> (app.connected <span style="color: orange;">==</span> <span style="color: #6161e7;">false</span>) {
        $(<span style="color: #25c825;">'#connect_app'</span>).removeAttr(<span style="color: #25c825;">'disabled'</span>).find(<span style="color: #25c825;">'span'</span>).text(<span style="color: #25c825;">'Connect'</span>);
        $(<span style="color: #25c825;">'#transfer_data'</span>).attr(<span style="color: #25c825;">'disabled'</span>, <span style="color: #25c825;">'disabled'</span>).val(<span style="color: #25c825;">''</span>);
        $(<span style="color: #25c825;">'#send_data'</span>).attr(<span style="color: #25c825;">'disabled'</span>, <span style="color: #25c825;">'disabled'</span>);
        $(<span style="color: #25c825;">'#disconnect_app'</span>).attr(<span style="color: #25c825;">'disabled'</span>, <span style="color: #25c825;">'disabled'</span>).find(<span style="color: #25c825;">'span'</span>).text(<span style="color: #25c825;">'Disconnected'</span>);
      }
    });
  }
});
<span style="color: gray;">/*Function to transmit data to client in the same channel in real-time*/</span>
$(<span style="color: #25c825;">'#send_data'</span>).off(<span style="color: #25c825;">'click'</span>).on(<span style="color: #25c825;">'click'</span>, <span style="color: #ad13ad;">function</span>(e) {
  $(<span style="color: #25c825;">'#error_transfer'</span>).addClass(<span style="color: #25c825;">'hide'</span>).find(<span style="color: #25c825;">'p'</span>).text(<span style="color: #25c825;">"Something's not right?"</span>);
  <span style="color: orange;">if</span> (pushthru <span style="color: orange;">!=</span> <span style="color: #6161e7;">null</span>) {
    <span style="color: orange;">if</span> (pushthru.app.connected) {
      sentCount <span style="color: orange;">=</span> sentCount<span style="color: orange;">+</span>1;
      pushthru.trigger(<span style="color: #25c825;">'send-data'</span>, <span style="color: #25c825;">'test-transfer'</span>, {
        <span style="color: #25c825;">'count'</span>: sentCount,
        <span style="color: #25c825;">'message'</span>: $(<span style="color: #25c825;">'#transfer_data'</span>).val(),
        <span style="color: #25c825;">'sessionid'</span>: pushthru.app.sessionid
      });
      $(<span style="color: #25c825;">'#test_overlay'</span>).removeClass(<span style="color: #25c825;">'hide'</span>);
    } else {
      $(<span style="color: #25c825;">'#error_transfer'</span>).removeClass(<span style="color: #25c825;">'hide'</span>).find(<span style="color: #25c825;">'p'</span>).text(<span style="color: #25c825;">'App not connected, click connect button first!'</span>);
    }
  } else {
    $(<span style="color: #25c825;">'#error_transfer'</span>).removeClass(<span style="color: #25c825;">'hide'</span>).find(<span style="color: #25c825;">'p'</span>).text(<span style="color: #25c825;">'App not connected, click connect button first!'</span>);
  }
});
						</code>
Go to Documentation here <span style="color: orange;">=></span> <a href="<?php echo str_replace('login', 'documentation', MAIN_URL);?>" target="_blank"><?php echo str_replace('login', 'documentation', MAIN_URL);?></a>
					</pre>
				</div>
				<div id="test_overlay" class="overlay hide">
					<i class="fa fa-refresh fa-spin"></i>
				</div>
			</div>
		</div>
	</div>
</section>