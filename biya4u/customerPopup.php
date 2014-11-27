<?php 
	include('protect.php');
	include 'dbconnect.php'; 
	include('paging.class.php');
	include('utilities.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link href="css/style.css" type="text/css"  rel="stylesheet"/>
	<title>Admin</title>
	<style type="text/css">
	<!--
	.style1 {font-size: large;}
	-->
	</style>
	<script src="js/jquery-1.11.1.min.js"></script>
	</head>

	<body>
		<div align="center">
			<table border="0" cellspacing="0" cellpadding="0"  align="center"> 
				<tr>
					<td>
						<table border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF" >
							<tr>
								<td>
									<p align="center" class="style1">Add Customer Details</p>
									<span class="">
									<?php
										if($_POST['submit']) {

											$nam=mysqli_real_escape_string($conn, $_REQUEST['nam']);
											$address=mysqli_real_escape_string($conn, $_REQUEST['address']);
											$phone=mysqli_real_escape_string($conn, $_REQUEST['phone']);
											$city=mysqli_real_escape_string($conn, $_REQUEST['city']);

											/*$desarea=mysqli_real_escape_string($conn, $_REQUEST['desarea']);*/
											$tin=mysqli_real_escape_string($conn, $_REQUEST['tin']);
						 
											if( !$nam ) {
												$nam1="Please Enter Your Name";
												$ok=1; 
											}

											if($city=='') {
												$city1="Please Enter Your City";
												$ok=1; 
											}

											if($ok!==1) {
												$rand=rand();
												$rquery=mysqli_query($conn, "select * from customer where rando='$rand'");
												if( mysqli_num_rows($rquery) > 0 ) {
													$ram=rand();
												}
												else {
													$ram=$rand;
												}
							 
												$query=mysqli_query($conn, "insert into customer (name,address,city,phone,rando,tin) values ('$nam','$address','$city','$phone','$ram','$tin')"); 
												$rquery1=mysqli_query($conn, "select * from customer where rando='$ram'");

												$row=mysqli_fetch_assoc($rquery1);

												$id=$row['id'];
												$pre=$row['pref'];
												$tot=$pre.$id;
												$update=mysqli_query($conn, "update customer set cusid='$tot' where id='$id'");

												if($query) {
									?>
												<script type="text/javascript">
													alert("Customer Details Submitted Successfully");
													self.location='customer.php';
												</script>
									<?php
												}
											}
										}
									?>
									</span>
									<table align="center">
										<tr>
											<td>
												<form action="" method="post">
													<table>
														<tr>
															<td>Name</td>
															<td><input type="text" id='cat' name="nam" value="<?php echo $_REQUEST['nam']; ?>" style="width:255px;"/></td>
															<td style="color:red;"><?php echo $nam1; ?></td>
														</tr>
														<tr>
															<td height="98">Address</td>
															<td><textarea name="address" cols="30" rows="5"></textarea></td>
															<td style="color:red;"><?php echo $address1; ?></td>
														</tr>
														<tr>
															<td>City</td>
															<td><?php generateDropdownObject($conn, "bplace", "city", "width250"); ?></td>
															<td><?php echo $city1; ?></td>
														</tr>
														<tr>
															<td>Phone</td>
															<td><input type="text" name="phone" value="<?php echo $_REQUEST['phone']; ?>" style="width:255px;"/></td>
															<td style="color:red;"><?php echo $phone1; ?></td>
														</tr>
														<tr>
															<td>TIN</td>
															<td><input type="text" name="tin" id="tin" style="width:255px;" />
															</td>
															<td  style="color:red;">&nbsp;</td>
														</tr>
														<tr>
															<td></td>
															<td><input type="submit" name="submit" value="Submit" /></td>
														</tr>
													</table>
												</form>
											</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</div>
	</body>
</html>
