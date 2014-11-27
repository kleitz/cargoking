<?php 
	include('protect.php');
	include 'dbconnect.php';

	$rate = trim($_REQUEST['suggest']);
	$sug = trim($_REQUEST['sug']);
 
 	if($sug == "withvat") { 
		$fc1 = ($rate * 100 ) / 112;
		$fc = number_format($fc1,'2','.',',');
		$vat1 = $rate - $fc;
		$vat= number_format($vat1,'2','.',',');
?>
        <table width="99%" cellpadding="0" cellspacing="0" align="center">
        	<tr>
        		<td width="132">Freight Charge</td>
            	<td width="324"><input type="text" name="fcharge1" id="fcharge1" value="<?php echo $fc;?>" readonly="readonly" style="width:110px;" /></td>
            </tr>
            <tr>
            	<td>VAT 12%</td>
                <td><input type="text" name="vat1" id="vat1" value="<?php echo $vat;?>" readonly="readonly" style="width:110px;" /></td>
            </tr>
        </table>
<?php 
	}

	if($sug == "withoutvat") {
?>
	<table width="99%" cellpadding="0" cellspacing="0" align="center">
		<tr>
			<td width="132">Freight Charge</td>
			<td width="324"><input type="text" name="fcharge1" id="fcharge1" value="<?php echo $rate; ?>" style="width:110px;" /><input type="hidden" name="vat1" id="vat1" value="" /></td>
		</tr>
	</table>
<?php
 		}
?>