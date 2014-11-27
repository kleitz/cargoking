<?php 
	include('protect.php');
	include 'dbconnect.php';

	$rate = trim($_REQUEST['rate']);
	$has_vat = trim($_REQUEST['has_vat']);

	/* TODO: Convert this code to return JSON Objects and will be processed via Javascript instead of returning HTML codes. */
	
 	if($has_vat == "withvat") { 
		$fc1 = ($rate * 100 ) / 112;
		$fc = number_format($fc1,'2','.',',');
		$vat1 = $rate - $fc;
		$vat= number_format($vat1,'2','.',',');
?>
        <table width="100%" cellpadding="0" cellspacing="0" align="center">
        	<tr>
				<td width="15">&nbsp;</td>
        		<td width="135"><label for="txtFreightCharge">Freight Charge</label></td>
            	<td width="400">
					<input type="text" id="txtFreightCharge" name="fcharge1" value="<?php echo $fc;?>" class="form-field" style="width:110px;" readonly="readonly" />
				</td>
            </tr>
            <tr>
				<td width="15">&nbsp;</td>
            	<td width="135"><label for="txtVAT">VAT 12%</label></td>
                <td width="400">
					<input type="text" id="txtVAT" name="vat1" value="<?php echo $vat;?>" class="form-field" style="width: 110px; padding-top: 4px; margin-top: 6px; margin-bottom: 2px;" readonly="readonly" />
				</td>
            </tr>
        </table>
<?php 
	}

	if($has_vat == "withoutvat") {
?>
	<table width="99%" cellpadding="0" cellspacing="0" align="center">
		<tr>
			<td width="15">&nbsp;</td>
			<td width="135"><label for="txtFreightCharge">Freight Charge</label></td>
			<td width="400">
				<input type="text" id="txtFreightCharge" name="fcharge1" value="<?php echo $rate; ?>" class="form-field" style="width:110px;" />
				<input type="hidden" name="vat1" id="vat1" value="" />
			</td>
		</tr>
	</table>
<?php
 		}
?>