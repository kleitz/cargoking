<?php
  include ('dbconnect.php');

  if($_POST['submit']) {
    $userProfileId      = mysqli_real_escape_string($conn, $_REQUEST['userProfileId']);
    $profileFirstName   = mysqli_real_escape_string($conn, $_REQUEST['profileFirstName']);
    $profileLastName    = mysqli_real_escape_string($conn, $_REQUEST['profileLastName']);
    $profileMiddleName  = mysqli_real_escape_string($conn, $_REQUEST['profileMiddleName']);

    $profileAddress     = mysqli_real_escape_string($conn, $_REQUEST['profileAddress']);
    $profileEmail       = mysqli_real_escape_string($conn, $_REQUEST['profileEmail']);
    $contactNumber      = mysqli_real_escape_string($conn, $_REQUEST['contactNumber']);

    //$profileUsername    = mysqli_real_escape_string($conn, $_REQUEST['profileUsername']);    
    $profilePassword    = mysqli_real_escape_string($conn, $_REQUEST['profilePassword']);
    

    $sqlUpdate  = "";
    $sqlUpdate .= " update users set \n";
    $sqlUpdate .= "   firstname = '" . $profileFirstName . "', \n";
    $sqlUpdate .= "   lastname = '" . $profileLastName . "', \n";
    $sqlUpdate .= "   middlename = '" . $profileMiddleName . "', \n";
    $sqlUpdate .= "   address = '" . $profileAddress . "', \n";
    $sqlUpdate .= "   email = '" . $profileEmail . "', \n";
    $sqlUpdate .= "   phone = '" . $contactNumber . "', \n";
    $sqlUpdate .= "   password = '" . $profilePassword . "' \n";
    $sqlUpdate .= " where id = " . $userProfileId;

    $successInsertion = mysqli_query($conn,  $sqlUpdate );

    if( $successInsertion ) {
      header('Location: edit_profile.php?action=update&success=true');
    }
    else {
      $errorNo  = mysqli_errno($conn);
      $errorMsg = mysqli_error($conn);
      header('Location: edit_profile.php?action=update&success=false&errorNo=' . $errorNo . '&errorMsg=' . urlencode($errorMsg) . '&isDebug=true&updateSQL=' . urlencode($sqlUpdate));
    }
  }

?>