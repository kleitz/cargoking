<?php 
	include('protect.php');
	include_once("dbconnect.php");

	$id = $_POST['ed'];

	function salt( $table, $id ) {
		$query=mysqli_query($conn, "select * from  ".$table." where id='$id'");
		while($row=mysqli_fetch_assoc($query)) {
			echo $row['category'];
		}
	}

	// Insert you code for processing the form here, e.g emailing the submission, entering it into a database. 

	//error_reporting(E_ALL);
	$strhwid = $_POST['txthwid'];
	
	//echo "[BOOK-NO]: " . $strhwid . "<br>";
	
	$strcomm = addslashes($_POST['comments']);
	$strloc = addslashes($_POST['Loc']);
	$strus =$_POST['status'];
	$strdate = date("d-M-Y");
	$strtime =  date("H.i");
	$sTime =  $strtime;

	$sql =	"Insert into booking_status (hawb_code, status_date, status_time, location_id, status_id, comments) values (";
	$sql.=	"'$strhwid',";
	$sql.=	" CURDATE(),";
	$sql.=	" CURTIME(),";
	$sql.=	" 8,";  //TODO: replace this with the real Location ID <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
	$sql.=	" 1,";  //TODO: replace this with the real Status ID <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
	$sql.=	"'$strcomm')";

	$result1 = mysqli_query($conn, $sql,$con) or die("Invalid query: " . mysqli_error());
	$rs = mysqli_query($conn, "update booking set status ='$strus' where bookno='$strhwid'");

	error_reporting(0);

	$select = "SELECT * FROM vw_booking_details where bookno='$strhwid' ";		
	$export = mysqli_query($conn, $select);
	$row 	= mysqli_fetch_assoc($export);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<title>Admin</title>
		<link href="css/style.css" rel="stylesheet" type="text/css">
		<style type="text/css">
			.ds_box {
				background-color: #FFF;
				border: 1px solid #000;
				position: absolute;
				z-index: 32767;
			}
			.ds_tbl {
				background-color: #FFF;
			}
			.ds_head {
				background-color: #333;
				color: #FFF;
				font-family: Arial, Helvetica, sans-serif;
				font-size: 13px;
				font-weight: bold;
				text-align: center;
				letter-spacing: 2px;
			}
			.ds_subhead {
				background-color: #CCC;
				color: #000;
				font-size: 12px;
				font-weight: bold;
				text-align: center;
				font-family: Arial, Helvetica, sans-serif;
				width: 32px;
			}
			.ds_cell {
				background-color: #EEE;
				color: #000;
				font-size: 13px;
				text-align: center;
				font-family: Arial, Helvetica, sans-serif;
				padding: 5px;
				cursor: pointer;
			}
			.ds_cell:hover {
				background-color: #F3F3F3;
			} /* This hover code won't work for IE */
			.style1 {color: #006600}
			.blink { text-decoration: blink; }
		</style>
		<script type="text/JavaScript">
			function MM_openBrWindow(theURL, winName, features) {
				window.open(theURL, winName, features);
			}
		</script>
	</head>
	<body>
		<table width="780"  border="0" align="center" cellpadding="0" cellspacing="0">
			<?php
				if( !isset($_GET['popup']) ) {
			?>
			<tr>
				<td width="780"><?php include('adminheader.php'); ?></td>
			</tr>
			<?php
				}
			?>
			<tr>
				<td bgcolor="#FFFFFF">
					<div align="center">
						<br>
						<span class="newtext"><br></span>
						<table class="ds_box" cellpadding="0" cellspacing="0" id="ds_conclass" style="display: none;">
							<tr>
								<td id="ds_calclass"></td>
							</tr>
						</table>
						<table width="98%"  border="0" align="center">
							<tr>
								<td align="center" bgcolor="F9F5F5" class="newtext"><strong>Edit HAWB Confirm - <span class="style1"><? echo $id; ?></span></strong></td>
							</tr>
						</table>
						<br>
						<table bgcolor="#FFFFFF" border="0" width="" style="border:1px #A4A4A4 dotted;">
						<tbody>
							<tr>
								<td height="35" bgcolor="#EBEBEB">
									<div>
										<b style="width:300px; font-size:18px;">&nbsp;&nbsp;
											<?php  echo $row['bookno']; ?>
										</b>
										<b style="margin:0 0 0 380px;">
											<?php 
												$mpo=explode("-",$row['date']);
												echo $mpo[2]."-".$mpo[1]."-".$mpo[0];
											?>
										</b>
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<table border="0" width="">
									<tbody>
										<tr>
											<td width="">
												<div align="left" style="text-align:justify; line-height:30px;">
													<table width="550" cellspacing="0">
														<tr>
															<td width="167">Origin</td>
															<td width="16" align="center"><strong>:</strong></td>
															<td width="359"><?php salt("bplace",$row['origin']); ?></td>
														</tr>
														<tr>
															<td width="167">Destination</td>
															<td width="16" align="center"><strong>:</strong></td>
															<td width="359"><?php salt("bplace",$row['destination']); ?></td>
														</tr>
														<tr>
															<td>Receiver Name</td>
															<td align="center"><strong>:</strong></td>
															<td><?php  echo $row['receiver']; ?></td>
														</tr>
														<tr>
															<td>Address</td>
															<td align="center" valign="middle"><strong>:</strong></td>
															<td><?php  echo $row['radd']; ?></td>
														</tr>
														<tr>
															<td>Phone</td>
															<td align="center"><strong>:</strong></td>
															<td><?php  echo $row['rphone']; ?></td>
														</tr>
														<tr>
															<td>Sender Name</td>
															<td align="center"><strong>:</strong></td>
															<td><?php  echo $row['sendername']; ?></td>
														</tr>
														<tr>
															<td>Address</td>
															<td align="center"><strong>:</strong></td>
															<td><?php  echo $row['senderaddress']; ?></td>
														</tr>
														<tr>
															<td>Phone</td>
															<td align="center"><strong>:</strong></td>
															<td><?php  echo $row['senderphone']; ?></td>
														</tr>
														<!--
														<tr>
															<td>Destination Area</td>
															<td align="center"><strong>:</strong></td>
															<td>
																< ?php  $des= $row['desarea']; 
																	$des_query=mysqli_query($conn, "select * from destinations where id='$des'");
																	$des_row=mysqli_fetch_assoc($des_query);
																	echo $des_row['category'];
																? >
															</td>
														</tr>
														-->
														<tr>
															<td>Mode of Pay</td>
															<td align="center"><strong>:</strong></td>
															<td><?php salt("mop",$row['modpay']); ?></td>
														</tr>
														<tr>
															<td>Movement</td>
															<td align="center"><strong>:</strong></td>
															<td><?php salt("movement",$row['movement']); ?></td>
														</tr>
														<tr>
															<td>Service Mode</td>
															<td align="center"><strong>:</strong></td>
															<td><?php salt("servicemode",$row['servicemode']); ?></td>
														</tr>
													</table>
													<table width="555" cellspacing="1">
														<tr>
															<td width="123" align="center" bgcolor="#FFA851"><strong>Cargo Description</strong></td>
															<td width="87" align="center" bgcolor="#FFA851"><strong>Quantity</strong></td>
															<td width="116" align="center" bgcolor="#FFA851"><strong>Measurement</strong></td>
															<td width="129" align="center" bgcolor="#FFA851"><strong>Weight</strong></td>
															<td width="129" align="center" bgcolor="#FFA851"><strong>Declared Value</strong></td>
														</tr>
														<?php
															$boo = $row['bookno'];
															$query = mysqli_query($conn, "select * from arr where bookid='$boo'");
															while( $row = mysqli_fetch_assoc($query) ) {
														?>
														<tr>
															<td width="123" align="center" bgcolor="#EBEBEB">
															<?php 
																$tyship = $row['tyship'];
																$query1 = mysqli_query($conn, "select * from ty_ship where id='$tyship'");
																$row1 = mysqli_fetch_assoc($query1);
																echo $row1['category'];
															?>
															</td>
															<td width="87" align="center" bgcolor="#EBEBEB"><?php echo $row['qun']; ?></td>
															<td width="116" align="center" bgcolor="#EBEBEB"><?php echo $row['price']; ?></td>
															<td width="129" align="center" bgcolor="#EBEBEB"><?php echo $row['tot']; ?></td>
															<td width="129" align="center" bgcolor="#EBEBEB"><?php echo $row['at']; ?>&nbsp;</td>
														</tr>
														<?php	
															} 

															$querys=mysqli_query($conn, "select sum(qun) as qun,sum(tot) as tot from arr where bookid='$boo'");
															$rows=mysqli_fetch_assoc($querys)
														?>
														<tr>
															<td align="center" bgcolor="#EBEBEB" ><strong>Total </strong></td>
															<td align="center" bgcolor="#8CDAFF" style="border-top:1px solid #A0A0A4; border-bottom:1px solid #A0A0A4; "><?=$rows['qun']?></td>
															<td align="center" bgcolor="#EBEBEB">&nbsp;</td>
															<td align="center" bgcolor="#8CDAFF"  style="border-top:1px solid #A0A0A4; border-bottom:1px solid #A0A0A4; "><?=$rows['tot']?></td>
															<td align="center" bgcolor="#8CDAFF"  style="border-top:1px solid #A0A0A4; border-bottom:1px solid #A0A0A4; ">&nbsp;</td>
														</tr>
													</table>
													<table width="552">
														<tr>
															<td width="135">Description</td>
															<td width="13" align="center"><strong>:</strong></td>
															<td width="311"><?php  echo $row['des']; ?></td>
														</tr>
														<tr>
															<td colspan="3">&nbsp;</td>
														</tr>
													</table>
												</div>
											</td>
											<td width="1%">&nbsp;</td>
										</tr>
									</tbody>
									</table>
								</td>
							</tr>
						</tbody>
						</table>
						<span class="newtext"><br>
						<?php
							$strid	=	$_GET['id'];
							$result1 = mysqli_query($conn, "SELECT * FROM booking_status WHERE hawb_code = '$strid'");
						?>
						</span>
						<table width="75%" align="center" cellpadding="2" cellspacing="2" bgcolor="#EEEEEE">
							<tr>
								<td align="right" bgcolor="#ECECEC"><div align="center" class="newtext">Date</div></td>
								<td align="right" bgcolor="#ECECEC"><div align="center" class="newtext">Time</div></td>
								<td bgcolor="#ECECEC"><div align="center" class="newtext">Location</div></td>
								<td bgcolor="#ECECEC"><div align="center" class="newtext">Status</div></td>
								<td bgcolor="#ECECEC"><div align="center" class="newtext">Comments</div></td>
							</tr>
						<?php
							while($row = mysqli_fetch_array($result1)) {
						?>
							<tr>
								<td align="right" bgcolor="#FFFFFF"><div align="center"> <span class="newtext"><? echo $row["date"];?> </span></div></td>
								<td align="right" bgcolor="#FFFFFF"><div align="center"> <span class="newtext"><? echo $row["time"];?> </span></div></td>
								<td bgcolor="#FFFFFF"><div align="center"> <span class="newtext"><? echo $row["location"];?> </span></div></td>
								<td bgcolor="#FFFFFF"><div align="center"> <span class="newtext"><? echo $row["status"];?> </span></div></td>
								<td bgcolor="#FFFFFF"><div align="center"><span class="newtext"><? echo $row["comments"];?></span></div></td>
							</tr>
						<?php
							}
						?>
						</table>
						<br>
						<br>
						<button id="btnPrintPreview" onclick="MM_openBrWindow('print_view.php?ed=<?php echo $id; ?>','','scrollbars=yes, left=150, top=150, width=870, height=930')" style="margin-right: 16px;">Print HAWB</button>
						<br>
						<br>
					</div>
				</td>
			</tr>
			<tr>
				<td><?php include('adminfooter.php'); ?></td>
			</tr>
		</table>
	</body>
</html>
