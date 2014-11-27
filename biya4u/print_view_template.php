	<table cellpadding="0" cellspacing="0" style="width:842px; height:595px; border:thick #999999;">
		<tbody>
    	<tr>
        	<td width="30%" height="225" align="center" valign="top">
			<img src="images/logo.png" border="0" />
			<table class="reportInfoTable" width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-top:20px;">
				<tbody>
				<tr>
					<td class="bottomRightBorder" align="center" width="60%"><strong>SERVICE MODE</strong></td>
					<td class="bottomBorder" align="center" width="40%"><strong>MOVEMENT</strong></td>
				</tr>
				<tr>
					<td class="rightBorder" height="75" valign="middle">
						<?php
							while($sermode=mysqli_fetch_array($rsServiceMode))
							{
								if($sermode['id'] == $result['service_mode_id']){
									echo ("&nbsp;&nbsp;");
									echo ("<img src='images/tickbox.jpg' border='0' align='absmiddle'> &nbsp; ".$sermode['category']."<br>");
								} else {
									echo ("&nbsp;&nbsp;");
									echo ("<img src='images/checkbox.jpg' border='0' align='absmiddle'> &nbsp; ".$sermode['category']."<br>");
								}
							}
						?>
					</td>
					<td valign="middle">
						<?php
							while($move=mysqli_fetch_array($rsMovement))
							{
								if($move['id'] == $result['movement_type_id']){
									echo ("&nbsp;&nbsp;");
									echo ("<img src='images/tickbox.jpg' border='0' align='absmiddle'> &nbsp; ".$move['category']."<br>");
								} else {
									echo ("&nbsp;&nbsp;");
									echo ("<img src='images/checkbox.jpg' border='0' align='absmiddle'> &nbsp; ".$move['category']."<br>");
								}
							}
						?>
					</td>
				</tr>
				</tbody>
			</table>
			</td>
			<td width="70%" valign="top">
			<strong>IMPORTANT:</strong><br>
			WE WILL BE LIABLE TO THE EXTENT OF THE DECLARED VALUE ON THE
			FACE OF THIS WAYBILL, CLAIMS NOT FILED WITHIN (30) DAYS AFTER DATE OF
			THIS WAYBILL ARE DEEMED WAIVED BY THE SHIPPER.
			<br>
			<table class="cargoInfoTable" border="0" cellpadding="1" cellspacing="0" width="100%" height="173">
				<tbody>
				<tr>
					<td class="reportData bottomRightBorder" width="30%">DATE &nbsp;&nbsp;<?php echo $result['hawb_date']; ?></td>
					<td class="reportData bottomBorder" width="70%">SHIPPER: &nbsp;&nbsp;<strong><?php echo $result['sender_name']; ?></strong></td>
				</tr>
				<tr>
					<td class="reportData bottomRightBorder" width="30%">ORIGIN &nbsp;&nbsp;<strong><?php echo $result['origin']; ?></strong></td>
					<td class="reportData bottomBorder" width="70%">ADDRESS: &nbsp;&nbsp;<?php echo $result['sender_address']; ?></td>
				</tr>
				<tr>
					<td class="reportData bottomRightBorder" width="30%">DESTINATION &nbsp;&nbsp;<strong><?php echo $result['destination']; ?></strong></td>
					<td class="reportData bottomBorder" width="70%">TIN: &nbsp;&nbsp;<?php echo $result['identification_number']; ?></td>
				</tr>
				<tr>
					<td class="bottomRightBorder" align="center" width="30%"><strong>PAYMENT MODE</strong></td>
					<td class="reportData bottomBorder" width="70%">CONTACT NO: &nbsp;&nbsp; <?php echo $result['sender_phone']; ?></td>
				</tr>
				<tr>
					<td class="rightBorder" rowspan="3" align="left" valign="middle" width="30%">
						<?php
							while($modpay=mysqli_fetch_array($rsMop))
							{
								if($modpay['id'] == $result['payment_mode_id']) {
									echo ("&nbsp;&nbsp;");
									echo ("<img src='images/tickbox.jpg' border='0' align='absmiddle'> &nbsp; ".$modpay['category']."<br>");
								} else {
									echo ("&nbsp;&nbsp;");
									echo ("<img src='images/checkbox.jpg' border='0' align='absmiddle'> &nbsp; ".$modpay['category']."<br>");
								}
							}
						?>
					</td>
					<td class="reportData bottomBorder" height="28" width="70%">CONSIGNEE: &nbsp;&nbsp; <strong><?php echo $result['receiver_name']; ?></strong></td>
				</tr>
				<tr>
				<td class="reportData bottomBorder" height="28" width="70%">ADDRESS: &nbsp;&nbsp; <strong><?php echo $result['receiver_address']; ?></strong></td>
				</tr>
				<tr>
					<td class="reportData" width="70%">CONTACT NO: &nbsp;&nbsp; <strong><?php echo $result['receiver_phone']; ?></strong></td>
					</tr>
				</tbody>
			</table>
		</td>
	</tr>
	<tr>
		<td height="74" colspan="2" valign="top">
			<table class="cargoInfoTable" cellpadding="0" cellspacing="0" border="0" width="100%">
				<tbody>
				<tr>
					<th class="cargoInfoFirstHeader rightBorder">NUMBER OF PIECES</th>
					<th class="cargoInfoHeader rightBorder">CARGO DESCRIPTION</th>
					<th class="cargoInfoHeader rightBorder">MEASUREMENT<br>L x W x H (CBM)</th>
					<th class="cargoInfoHeader rightBorder">WEIGHT(KILO)</th>
					<th class="cargoInfoHeader">DECLARED VALUE</th>
				</tr>
				<tr>
					<td class="cargoInfoFirstDetail rightBorder">
						<?php
							foreach($arHawbItems as $item)
								echo $item['quantity'] . "<br>";
						?>
					</td>
					<td class="cargoInfoDetails rightBorder">
						<?php
							foreach($arHawbItems as $item)
								echo $item['shipment_type'] . "<br>";
						?>
					</td>
					<td class="cargoInfoDetails rightBorder">
						<?php
							foreach($arHawbItems as $item)
								echo number_format((float) $item['dimension_total'], 2, '.', ',') . "<br>";
						?>
					</td>
					<td class="cargoInfoDetails rightBorder">
						<?php
							foreach($arHawbItems as $item)
								echo number_format((float) $item['preferred_weight'], 2, '.', ',') . "<br>";
						?>
					</td>
					<td class="cargoInfoDetails rightBorder">
						<?php
							foreach($arHawbItems as $item)
								echo number_format((float) $item['declared_value'], 2, '.', ',') . "<br>";
						?>
					</td>
				</tr>
				<tr>
					<td class="cargoInfoFirstCharges rightBorder">FREIGHT CHARGE</td>
					<td class="cargoInfoBlankSpaces rightBorder" colspan="3">&nbsp;</td>
					<td class="cargoInfoBlankSpaces">&nbsp;</td>
				</tr>
				<tr>
					<td class="cargoInfoFirstCharges rightBorder">VALUATION CHARGE</td>
					<td class="cargoInfoBlankSpaces rightBorder" colspan="3">&nbsp;</td>
					<td class="cargoInfoBlankSpaces">&nbsp;</td>
				</tr>
				<tr>
					<td class="cargoInfoFirstCharges rightBorder">WAYBILL FEE</td>
					<td class="cargoInfoBlankSpaces rightBorder" colspan="3">&nbsp;</td>
					<td class="cargoInfoBlankSpaces">&nbsp;</td>
				</tr>
				<tr>
					<td class="cargoInfoFirstCharges rightBorder">FUEL SURCHARGE</td>
					<td class="cargoInfoBlankSpaces rightBorder" colspan="3">&nbsp;</td>
					<td class="cargoInfoBlankSpaces">&nbsp;</td>
				</tr>
				<tr>
					<td class="cargoInfoFirstCharges rightBorder">INSURANCE FEE</td>
					<td class="cargoInfoBlankSpaces rightBorder" colspan="3">&nbsp;</td>
					<td class="cargoInfoBlankSpaces">&nbsp;</td>
				</tr>
				<tr>
					<td class="cargoInfoFirstCharges rightBorder">SPECIAL HANDLING FEE</td>
					<td class="cargoInfoBlankSpaces rightBorder" colspan="3">&nbsp;</td>
					<td class="cargoInfoBlankSpaces">&nbsp;</td>
				</tr>
				<tr>
					<td class="cargoInfoFirstCharges rightBorder">PICK-UP &amp; DELIVERY</td>
					<td class="cargoInfoBlankSpaces rightBorder" colspan="3">&nbsp;</td>
					<td class="cargoInfoBlankSpaces">&nbsp;</td>
				</tr>
				<tr>
					<td class="cargoInfoFirstCharges rightBorder">OTHERS</td>
					<td class="cargoInfoBlankSpaces rightBorder" colspan="3">&nbsp;</td>
					<td class="cargoInfoBlankSpaces">&nbsp;</td>
				</tr>
				<tr>
					<td class="cargoInfoFirstCharges rightBorder">SUB TOTAL</td>
					<td class="cargoInfoBlankSpaces rightBorder" colspan="3">&nbsp;</td>
					<td class="cargoInfoBlankSpaces">&nbsp;</td>
				</tr>
				<tr>
					<td class="cargoInfoFirstCharges rightBorder">VAT</td>
					<td class="cargoInfoBlankSpaces rightBorder" colspan="3">&nbsp;</td>
					<td class="cargoInfoBlankSpaces">&nbsp;</td>
				</tr>
				<tr>
					<td class="cargoInfoRemarks">REMARKS / NOTATIONS</td>
					<td class="cargoInfoRemarks rightBorder" colspan="2"><?php echo $result['remarks']; ?></td>
					<td class="cargoInfoRemarks rightBorder">TOTAL CHARGES</td>
					<td class="cargoInfoRemarks" align="center"><?php echo number_format((float) $result['total_price'], 2, '.', ','); ?></td>
				</tr>
				</tbody>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<table cellpadding="2" cellspacing="2" border="0" width="100%">
				<tbody>
				<tr valign="top">
					<td width="35%">
						<table class="cargoInfoTable" cellpadding="0" cellspacing="0" border="0" width="100%">
							<tbody>
							<tr valign="top">
								<td style="padding:5px;">
									THIS IS TO CERTIFY THAT THE SHIPMENT IS PROPERLY DESCRIBED AND IN GOOD CONDITION.<br /><br />
									SHIPPER<BR />
									CONFORME: _____________________________
									<div style="text-align:center">SIGNATURE OVER PRINTED NAME</div>
								</td>
							</tr>
							</tbody>
						</table>
					</td>
					<td width="35%">
						<table class="cargoInfoTable" cellpadding="0" cellspacing="0" border="0" width="100%">
							<tbody>
							<tr valign="top">
								<td style="padding:5px;">
									TO BE FILLED UP BY CARGO KING <strong>FOR PICK-UP ONLY</strong>
									<BR />
									TRUCKER NAME: _______________________________<BR />
									SIGNATURE:&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; _______________________________<br />
									<BR />
									RECEIPT AT WHSE CHECKER:
									 _____________________
									 <div style="text-align:center">SIGNATURE OVER PRINTED NAME</div>
								</td>
							</tr>
							<tbody>
						</table>
					</td>
					<td width="15%">
						<table class="cargoInfoTable" cellpadding="0" cellspacing="0" border="0" width="100%">
							<tbody>
							<tr valign="top">
								<td bgcolor="#000000" style="color:#FFFFFF; padding:5px; font-weight:bold; font-size:16px;" align="center">HAWB #</td>
							</tr>
							<tr>
								<td style="padding:5px; font-weight:bold; font-size:16px;" align="center" valign="bottom" height="52"><?php echo $result['booking_code']?></td>
							</tr>
							</tbody>
						</table>
					</td>
					<td width="10%" valign="bottom">
						<table cellpadding="0" cellspacing="0" border="0" width="100%">
							<tbody>
							<tr valign="top">
								<td valign="bottom">
									<?php  
										$tempDir = "qrtemp/";
										$codeContents="http://".$root."/tracking/biya4u/update_status.php?ed=".$result['id'];

										// we need to generate filename somehow,  
										// with md5 or with database ID used to obtains $codeContents... 
										$fileName = 'cargo'.md5($codeContents).'.png';

										$img=$tempDir.$fileName;
										// generating 

										// frame config values below 4 are not recomended !!! 
										QRcode::png($codeContents, $img, QR_ECLEVEL_L, 3, 0);

										// displaying 
										echo '<img src="'.$img.'" border="1" />';
									 ?>
								</td>
							</tr>
							</tbody>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<?php
			$des=$result['origin'];
			$sta_add=getAssociativeArrayFromSQL($conn, "select * from bplace where id=$des");
		?>
		<td colspan="2"><strong><?=$sta_add['address'];?></strong></td>
	</tr>
	</tbody>
</table>