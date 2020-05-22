<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<title></title>
</head>
<body>
	<div style="word-break:break-word;vertical-align:top;border-collapse:collapse" valign="top">
		<div style="background-color:transparent">
			<div style="Margin:0 auto;min-width:320px;max-width:600px;word-wrap:break-word;word-break:break-word;background-color:transparent">
				<div style="border-collapse:collapse;display:table;width:100%;background-color:transparent">
					<div style="min-width:320px;max-width:600px;display:table-cell;vertical-align:top">
						<div style="width:100%!important">
							<div style="border-top:0px solid transparent;border-left:0px solid transparent;border-bottom:0px solid transparent;border-right:0px solid transparent;padding-top:5px;padding-bottom:0px;padding-right:0px;padding-left:0px">
								<div align="center" style="padding-right:0px;padding-left:0px">
									<div style="font-size:1px;line-height:25px">&nbsp;</div>
									<img align="center" alt="Image" border="0" src="<?php echo base_url('assets/images/email/rounder-up.png');?>" style="outline:none;text-decoration:none;clear:both;border:0;height:auto;float:none;width:100%;max-width:600px;display:block" title="Image" width="600">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div style="background-color:transparent">
			<div style="Margin:0 auto;min-width:320px;max-width:600px;word-wrap:break-word;word-break:break-word;background-color:#ffffff">
				<div style="border-collapse:collapse;display:table;width:100%;background-color:#ffffff">
					<div style="min-width:320px;max-width:600px;display:table-cell;vertical-align:top">
						<div style="width:100%!important">
							<div style="border-top:0px solid transparent;border-left:0px solid transparent;border-bottom:0px solid transparent;border-right:0px solid transparent;padding-top:5px;padding-bottom:5px;padding-right:0px;padding-left:0px">
								<div align="center" style="padding-right:0px;padding-left:0px">
									<a href="<?php echo base_url();?>" rel="noreferrer" target="_blank"> <img align="center" alt="Image" border="0" src="<?php echo base_url('assets/images/email/icon.png');?>" style="outline:none;text-decoration:none;clear:both;height:auto;float:none;border:none;width:100%;max-width:210px;display:block" title="Image" width="210"></a>
								</div>
								<div style="color:#555555;font-family:'Montserrat','Trebuchet MS','Lucida Grande','Lucida Sans Unicode','Lucida Sans',Tahoma,sans-serif;line-height:150%;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px">
									<div style="font-size:12px;line-height:18px;color:#555555;font-family:'Montserrat','Trebuchet MS','Lucida Grande','Lucida Sans Unicode','Lucida Sans',Tahoma,sans-serif">
										<p style="font-size:14px;line-height:27px;text-align:center;margin:0"><span style="font-size:18px;color:#ff6600"><strong>Send-Data</strong></span></p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div style="background-color:transparent">
			<div style="Margin:0 auto;min-width:320px;max-width:600px;word-wrap:break-word;word-break:break-word;background-color:#ffffff">
				<div style="border-collapse:collapse;display:table;width:100%;background-color:#ffffff">
					<div style="min-width:320px;max-width:600px;display:table-cell;vertical-align:top">
						<div style="width:100%!important">
							<div style="border-top:0px solid transparent;border-left:0px solid transparent;border-bottom:0px solid transparent;border-right:0px solid transparent;padding-top:0px;padding-bottom:5px;padding-right:0px;padding-left:0px">
								<div style="color:#0d0d0d;font-family:'Montserrat','Trebuchet MS','Lucida Grande','Lucida Sans Unicode','Lucida Sans',Tahoma,sans-serif;line-height:120%;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px">
									<div style="font-size:12px;line-height:14px;color:#0d0d0d;font-family:'Montserrat','Trebuchet MS','Lucida Grande','Lucida Sans Unicode','Lucida Sans',Tahoma,sans-serif">
										<p style="font-size:14px;line-height:33px;text-align:center;margin:0"><span style="font-size:28px"><strong><span style="line-height:33px;font-size:28px">Payload Limit Reached!</span></strong></span></p>
									</div>
								</div>
								<div align="center">
									<img align="center" alt="Image" border="0" src="<?php echo base_url('assets/images/email/divider.png');?>" style="outline:none;text-decoration:none;clear:both;border:0;height:auto;float:none;width:100%;max-width:316px;display:block" title="Image" width="316">
								</div>
								<div style="color:#555555;font-family:'Montserrat','Trebuchet MS','Lucida Grande','Lucida Sans Unicode','Lucida Sans',Tahoma,sans-serif;line-height:150%;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px">
									<div style="font-size:12px;line-height:18px;color:#555555;font-family:'Montserrat','Trebuchet MS','Lucida Grande','Lucida Sans Unicode','Lucida Sans',Tahoma,sans-serif">
										<center>
											<table border="1">
												<tr>
													<th>WEEK NUMBER</th>
													<th>PAYLOAD DATA LENGTH</th>
													<th>PAYLOAD REACHED</th>
													<th>WEEK RANGE</th>
												</tr>
												<?php foreach($data['accumulated'] as $row) {?>
												<tr>
													<td align="center"><?php echo $row->week;?></td>
													<td align="center"><?php echo number_format($row->length);?></td>
													<td align="center"><?php echo number_format($row->count);?></td>
													<td align="center"><?php echo $row->date_range;?></td>
												</tr>
													<?php $last_date = $row->last_date;?>
												<?php }?>
											</table>
										</center>
										<p style="font-size:14px;line-height:21px;text-align:center;margin:0">You have reached your <b style="color: blue;"><?php echo number_format($data['limit']);?> payload limit</b>, you accumulated <b style="color: red;"><?php echo number_format($data['count']);?> payload</b><br>as of <b style="color: black;"><?php echo $data['added_in'];?> to <?php echo $last_date;?></b>.<br><br></p>
										<p style="font-size:14px;line-height:21px;text-align:center;margin:0">To continue your <?php echo $data['plan'];?> Service Subscription<br>Please log in to your account <a href="<?php echo base_url();?>?page=login" rel="noopener noreferrer" style="text-decoration:none;color:#0068a5" target="_blank" data-saferedirecturl="https://www.google.com/url?q=<?php echo base_url();?>?page%3Dlogin&amp;source=gmail&amp;ust=1566174810798000&amp;usg=AFQjCNHP0tqTWZI6UO2tvxk5yy5fefCiPA">HERE</a><span style="color:#a8bf6f;font-size:14px;line-height:21px"><strong><br></strong></span></p>
									</div>
								</div>
								<div style="color:#0d0d0d;font-family:'Montserrat','Trebuchet MS','Lucida Grande','Lucida Sans Unicode','Lucida Sans',Tahoma,sans-serif;line-height:150%;padding-top:20px;padding-right:10px;padding-bottom:10px;padding-left:10px">
									<div style="font-size:12px;line-height:18px;color:#0d0d0d;font-family:'Montserrat','Trebuchet MS','Lucida Grande','Lucida Sans Unicode','Lucida Sans',Tahoma,sans-serif">
										<p style="font-size:14px;line-height:21px;text-align:center;margin:0">GO TO YOUR PROJECT TAB AND SETTLE</p>
										<p style="font-size:14px;line-height:21px;text-align:center;margin:0">BY CLICKING CONTINUE BUTTON</p>
										<p style="font-size:14px;line-height:21px;text-align:center;margin:0">THEN YOU'RE ALL SET!!</p>
									</div>
								</div>
								<div align="center" style="padding-top:25px;padding-right:10px;padding-bottom:10px;padding-left:10px">
									<a href="//app.send-data.co/accounts/login" style="text-decoration:none;display:inline-block;color:#ffffff;background-color:#a8bf6f;border-radius:4px;width:auto;width:auto;border-top:1px solid #a8bf6f;border-right:1px solid #a8bf6f;border-bottom:1px solid #a8bf6f;border-left:1px solid #a8bf6f;padding-top:15px;padding-bottom:15px;font-family:'Montserrat','Trebuchet MS','Lucida Grande','Lucida Sans Unicode','Lucida Sans',Tahoma,sans-serif;text-align:center;word-break:keep-all" rel="noreferrer" target="_blank"><span style="padding-left:15px;padding-right:15px;font-size:16px;display:inline-block">
										<span style="font-size:16px;line-height:32px">LOGIN TO YOUR ACCOUNT</span>
									</span></a>
								</div>
								<table border="0" cellpadding="0" cellspacing="0" style="table-layout:fixed;vertical-align:top;border-spacing:0;border-collapse:collapse;min-width:100%" valign="top" width="100%">
									<tbody>
										<tr style="vertical-align:top" valign="top">
											<td style="word-break:break-word;vertical-align:top;min-width:100%;padding-top:30px;padding-right:10px;padding-bottom:10px;padding-left:10px;border-collapse:collapse" valign="top">
												<table align="center" border="0" cellpadding="0" cellspacing="0" height="0" style="table-layout:fixed;vertical-align:top;border-spacing:0;border-collapse:collapse;width:100%;border-top:0px solid transparent;height:0px" valign="top" width="100%">
													<tbody>
														<tr style="vertical-align:top" valign="top">
															<td height="0" style="word-break:break-word;vertical-align:top;border-collapse:collapse" valign="top"><span></span></td>
														</tr>
													</tbody>
												</table>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div style="background-color:transparent">
			<div style="Margin:0 auto;min-width:320px;max-width:600px;word-wrap:break-word;word-break:break-word;background-color:#525252">
				<div style="border-collapse:collapse;display:table;width:100%;background-color:#525252">
					<div style="max-width:320px;min-width:300px;display:table-cell;vertical-align:top">
						<div style="width:100%!important">
							<div style="border-top:0px solid transparent;border-left:0px solid transparent;border-bottom:0px solid transparent;border-right:0px solid transparent;padding-top:5px;padding-bottom:5px;padding-right:0px;padding-left:0px">
								<table cellpadding="0" cellspacing="0" style="table-layout:fixed;vertical-align:top;border-spacing:0;border-collapse:collapse" valign="top" width="100%">
									<tbody>
										<tr style="vertical-align:top" valign="top">
											<td style="word-break:break-word;vertical-align:top;padding-top:15px;padding-right:0px;padding-bottom:0px;padding-left:0px;border-collapse:collapse" valign="top">
												<table align="center" cellpadding="0" cellspacing="0" style="table-layout:fixed;vertical-align:top;border-spacing:0;border-collapse:inherit;" valign="top">
													<tbody>
														<tr align="center" style="vertical-align:top;display:inline-block;text-align:center" valign="top">
															<td style="word-break:break-word;vertical-align:top;padding-bottom:5px;padding-right:3px;padding-left:3px;border-collapse:collapse" valign="top"><a href="https://www.facebook.com/send-data/" rel="noreferrer" target="_blank"><img alt="Facebook" height="32" src="<?php echo base_url('assets/images/email/facebook@2x.png');?>" style="outline:none;text-decoration:none;clear:both;height:auto;float:none;border:none;display:block" title="Facebook" width="32" class="CToWUd"></a></td>
														</tr>
													</tbody>
												</table>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div style="max-width:320px;min-width:300px;display:table-cell;vertical-align:top">
						<div style="width:100%!important">
							<div style="border-top:0px solid transparent;border-left:0px solid transparent;border-bottom:0px solid transparent;border-right:0px solid transparent;padding-top:5px;padding-bottom:5px;padding-right:0px;padding-left:0px">
								<div style="color:#a8bf6f;font-family:'Montserrat','Trebuchet MS','Lucida Grande','Lucida Sans Unicode','Lucida Sans',Tahoma,sans-serif;line-height:120%;padding-top:20px;padding-right:0px;padding-bottom:0px;padding-left:0px">
									<div style="font-size:12px;line-height:14px;color:#a8bf6f;font-family:'Montserrat','Trebuchet MS','Lucida Grande','Lucida Sans Unicode','Lucida Sans',Tahoma,sans-serif">
										<p style="font-size:12px;line-height:14px;text-align:center;margin:0">Email <span style="color:#ffffff;font-size:12px;line-height:14px"><a href="mailto:gacelabs.inc@gmail.com" style="text-decoration:underline;color:#ffffff" title="gacelabs.inc@gmail.com" rel="noreferrer" target="_blank">gacelabs.inc@gmail.com</a></span></p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div style="background-color:transparent">
			<div style="Margin:0 auto;min-width:320px;max-width:600px;word-wrap:break-word;word-break:break-word;background-color:transparent">
				<div style="border-collapse:collapse;display:table;width:100%;background-color:transparent">
					<div style="min-width:320px;max-width:600px;display:table-cell;vertical-align:top">
						<div style="width:100%!important">
							<div style="border-top:0px solid transparent;border-left:0px solid transparent;border-bottom:0px solid transparent;border-right:0px solid transparent;padding-top:0px;padding-bottom:5px;padding-right:0px;padding-left:0px">
								<div align="center" style="padding-right:0px;padding-left:0px">
									<img align="center" alt="Image" border="0" src="<?php echo base_url('assets/images/email/rounder-dwn.png');?>" style="outline:none;text-decoration:none;clear:both;border:0;height:auto;float:none;width:100%;max-width:600px;display:block" title="Image" width="600">
								</div>
								<table border="0" cellpadding="0" cellspacing="0" style="table-layout:fixed;vertical-align:top;border-spacing:0;border-collapse:collapse;min-width:100%" valign="top" width="100%">
									<tbody>
										<tr style="vertical-align:top" valign="top">
											<td style="word-break:break-word;vertical-align:top;min-width:100%;padding-top:30px;padding-right:30px;padding-bottom:30px;padding-left:30px;border-collapse:collapse" valign="top">
												<table align="center" border="0" cellpadding="0" cellspacing="0" height="0" style="table-layout:fixed;vertical-align:top;border-spacing:0;border-collapse:collapse;width:100%;border-top:0px solid transparent;height:0px" valign="top" width="100%">
													<tbody>
														<tr style="vertical-align:top" valign="top">
															<td height="0" style="word-break:break-word;vertical-align:top;border-collapse:collapse" valign="top"><span></span></td>
														</tr>
													</tbody>
												</table>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>