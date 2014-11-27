<?php 
  session_start();
  include("securimage.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Cargoking: Login Page</title>
    <link href="css/style.css" type="text/css" rel="stylesheet"/>
    <link href="css/blitzer/jquery-ui-1.10.4.custom.css" rel="stylesheet">

    <style type="text/css">
      .loginContainer {
        background-color: #333333;
        opacity: 0.8;  
        -moz-opacity: 0.8;  
        filter:alpha(opacity=80);
        border-radius: 10px;
        width: 600px;
        height: 410px;
      }

      .centered {
        margin: auto;
        position: absolute;
        top: 0; left: 0; bottom: 0; right: 0;
      }

      .loginLabel {
        font-family: "OpenSanRegular";
        font-size: 14px;
        font-weight: bold;
        color: #ffffff;
        width: 150px;
        height: 15px;
        margin-left: 45px;
        display: inline-block;
        vertical-align: middle;
        text-align: left;
      }

      .loginField {
        font-family: "OpenSanRegular";
        font-size: 12px;
        font-weight: bold;
        color: #000000;
        width: 200px;
        height: 15px;
        display: inline-block;
        text-align: left;
        padding: 5px 10px;
        border: 3px solid #131426;
        border-radius:5px;
      }

      .loginLogo {
        width: 275px;
        height: 86px;
        padding: 5px;
        margin: 0px;
      }

      .buttonContainer {
        margin-right: 50px;
      }

      .divider {
        color: #ffffff;
        background: #ffffff;
        width: 390px;
        height: 2px;
        margin-top: 25px;
      }

      .verifyLabel {
        font-family: "OpenSanRegular";
        font-size: 14px;
        font-weight: bold;
        color: #ffffff;
        width: 150px;
        height: 30px;
        margin-left: 45px;
        display: inline-block;
        vertical-align: middle;
        text-align: left;
      }

      .verifyField {
        font-family: "OpenSanRegular";
        font-size: 14px;
        font-weight: bold;
        color: #131426;
        width: 102px;
        display: inline-block;
        text-align: left;
        padding: 5px 10px;
        border: 3px solid #131426;
        border-radius:5px;
        background-color: #ffffff;
      }

      .verifyCodeImage {
        border: 3px solid #131426;
        border-radius:5px;
      }

      .loginButton {
        font-family: 'OpenSanBold';
        font-size: 14px;
        background-color: #e74c3c;
        
        color: white;
        padding: 10px 30px;
        border-radius: 6px;
      }

      #divStatus {
        overflow: hidden;
        background-color: #E56967;
        width: 600px;
        height: 98px;
        margin-top: 60px;
        border-radius:5px;
      }

      #divStatus label {
        font-family: 'OpenSanBold';
        font-size: 14px;
        color: white;
        width: auto;
      }


    </style>

    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/jquery.validate.min.js"></script>
    <script type="text/javascript">
    	$(document).ready(function(){

          $("#divStatus").hide();

          $("#formLogin").validate({
            rules: {
              loginUserName: { required:true },
              loginPassword: { required:true }

              ,
              loginVerificationCode: {
                required:true,
                remote: {
                  url: "checkVerificationAnswer.php",
                  type: "post",
                  data: {
                    verificationAnswer: function() {
                      return $("#txtLoginVerificationCode").val();
                    }
                  }
                }
              }

            },

            messages: {
              loginUserName: {
                required: "Please enter login username."
              },
              loginPassword: {
                required: "Please provide login password."
              }

              ,
              loginVerificationCode: {
                required: "Please enter the result of the math operation from the image displayed.",
                remote: "Math operation answer incorrect."
              }

            },

            errorContainer: $('#divStatus'),
            errorLabelContainer: $('#divStatus ul'),
            wrapper: 'li'
          });

          centerStatusContainer();

          /*
          $("#txtLoginVerificationCode").keypress(function(event) {
              if (event.which == 13) {
                  event.preventDefault();
                  $("#formLogin").submit();
              }
          });
          */

    	});

      var validateVerification = function() {
        var verified = false;
        var answer = $("#txtLoginVerificationCode").val();

        console.log("[Answer]: " + answer);

        $.post( "checkVerificationAnswer.php", { verificationAnswer: answer }, function(result){
          if( result == "true") {
            verified = true;
          }
          else {

            alert("[Verified]: " + result);

            //add error status message
            verified = false;
          }
        });



        return verified;
      };

      var centerStatusContainer = function(){
          var loginContainerHeight = $("#divLoginContainer").css("height");
          loginContainerHeight = loginContainerHeight.replace(/px/g, '');

          var containerHalf = Number(loginContainerHeight)/2;
          var screenHalf = $(document).height()/2;

          var statusContainerHeight = $("#divStatus").css("height");
          statusContainerHeight = statusContainerHeight.replace(/px/g, '');
          var statusHeight = Number(statusContainerHeight);

          var centerTop = screenHalf - containerHalf - statusContainerHeight - 10;

          //alert("[Margin-Top]: " + centerTop);

          $("#divStatus").css("margin-top", centerTop + "px");
      }
    </script>

</head>

<body>
  <center>

    <!-- Contents -->
    <div id="divLoginContainer" class="loginContainer centered">
      <div style="width: 470px; padding: 10px;">

        <div align="left">
          <img src="images/ck_logo_01.png" class="loginLogo" />
        </div>

        <!-- Table Data Container -->
        <div align="center">
          <div>

            <!-- START: Login Form -->
            <form id="formLogin" name="loginForm" action="submit_login.php" method="post">
              <p align="left">
                <span class="loginLabel">Username:</span>
                <input type="text" id="txtUsername" name="loginUserName" value="" class="loginField" />
              </p>
              <p align="left">
                <span class="loginLabel">Password:</span>
                <input type="password" id="txtLoginPassword" name="loginPassword" value="" class="loginField" />
              </p>
              <hr class="divider">
              <p align="left">
                <span class="verifyLabel">Verification Code:</span>
                <input type="text" id="txtLoginVerificationCode" name="loginVerificationCode" value="" class="verifyField" maxlength="6" autocomplete="off" />
              </p>
              <p align="left">
                <span class="verifyLabel">&nbsp;</span>
                <img src="securimage_show.php?sid=<?php echo md5(uniqid(time())); ?>" class="verifyCodeImage" />            
              </p>
              <p align="center" style="margin-left: 30px;">
                <input type="submit" id="btnLogin" name="submit" value="Login" class="button" />
              </p>
            </form>
            <!-- END: Login Form -->

          </div>
        </div>

      </div>
    </div>

    <!-- Status Messages -->      
    <div id="divStatus" align="left">
      <ul />
    </div>

  </center>
</body>
</html>