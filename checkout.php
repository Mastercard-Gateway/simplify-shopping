<?php 
/*
 * Copyright (c) 2013, MasterCard International Incorporated
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without modification, are 
 * permitted provided that the following conditions are met:
 * 
 * Redistributions of source code must retain the above copyright notice, this list of 
 * conditions and the following disclaimer.
 * Redistributions in binary form must reproduce the above copyright notice, this list of 
 * conditions and the following disclaimer in the documentation and/or other materials 
 * provided with the distribution.
 * Neither the name of the MasterCard International Incorporated nor the names of its 
 * contributors may be used to endorse or promote products derived from this software 
 * without specific prior written permission.
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY 
 * EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES 
 * OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT 
 * SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, 
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED
 * TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; 
 * OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER 
 * IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING 
 * IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF 
 * SUCH DAMAGE.
 */

require_once 'data/MerchantData.php'; 

if (isset($_REQUEST["quantity0"]) == false) {
  header("Location: index.php"); /* Redirect browser */
  exit();
} 

session_start();

$totalAmount = 0;
$orders = array();
for ($i = 0; $i < count($merchant->products); $i++) { 
  $quantityVar = sprintf("quantity%d", $i);
  if (isset($_REQUEST[$quantityVar]) && $_REQUEST[$quantityVar] > 0) {
    $orders[$i] = $_REQUEST[$quantityVar];
  }
  $p = $merchant->products[$i];
  $totalAmount += $p->price * $_REQUEST[sprintf("quantity%d", $i)];
}
if ($totalAmount <= 0) {
  header("Location: index.php"); /* Redirect browser */
  exit();
}

//store orderList & totalAmount in session variable  
$_SESSION['orders'] = $orders;
$_SESSION['totalAmount'] = $totalAmount;            
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Checkout - <?php echo $merchant->name ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">

  <!-- Le styles -->
  <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
  <link href="assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/bootstrap-responsive.min.css" rel="stylesheet">
  <link href="assets/css/styles.css" rel="stylesheet">

  <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
  <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->

  <!-- Fav and touch icons -->
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
  <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
  <link rel="shortcut icon" href="assets/ico/favicon.png">

  <!-- Styles for brand color -->
  <style type="text/css">
    .form-header {
      background-color: <?php echo $merchant->mainColor ?> !important;
    }
    footer a:hover {
    color: <?php echo $merchant->mainColor ?> !important;
    }
    .btn-custom {
      background-color: <?php echo $merchant->mainColor ?> !important;
      filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="<?php echo $merchant->mainColor ?>", endColorstr="<?php echo $merchant->mainColor ?>");
      background-image: -khtml-gradient(linear, left top, left bottom, from(<?php echo $merchant->mainColor ?>), to(<?php echo $merchant->mainColor ?>));
      background-image: -moz-linear-gradient(top, <?php echo $merchant->mainColor ?>, <?php echo $merchant->mainColor ?>);
      background-image: -ms-linear-gradient(top, <?php echo $merchant->mainColor ?>, <?php echo $merchant->mainColor ?>);
      background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, <?php echo $merchant->mainColor ?>), color-stop(100%, <?php echo $merchant->mainColor ?>));
      background-image: -webkit-linear-gradient(top, <?php echo $merchant->mainColor ?>, <?php echo $merchant->mainColor ?>);
      background-image: -o-linear-gradient(top, <?php echo $merchant->mainColor ?>, <?php echo $merchant->mainColor ?>);
      background-image: linear-gradient(<?php echo $merchant->mainColor ?>, <?php echo $merchant->mainColor ?>);
      border-color: <?php echo $merchant->mainColor ?> <?php echo $merchant->mainColor ?> <?php echo $merchant->mainColor ?>;
    }
  </style>
</head>

<body>
  <div class="bg-img size-header"><!--[if lt IE 9]><img class="bg-img" src="assets/img/bg_banner.jpg" /><![endif]--></div>

  <div class="container form-wrapper">

    <div class="container form-header-wrapper">
      <div class="container form-header" style="background-color: <?php echo $merchant->mainColor ?>">
        <div class="pull-right text-right">
          <p>Order Total</p>
          <h3><div id="total_amount">$<?php echo number_format($totalAmount / 100.0,2) ?></div></h3>
        </div>
        <div>
          <p>Merchant</p>
          <h3><?php echo $merchant->name ?></h3>
        </div>
      </div><!--form-header -->
    </div><!-- form-header-wrapper -->

    <div class="container form-body-wrapper bg-grey">
      <div class="container form-body">
        <form id="checkout_form" action="payment.php" method="POST">
          <div class="card-info">
            <h3>Enter your card details.</h3>
            <div class="row-fluid">
              <div class="span4 field-title text-right">Name on Card</div>
              <div class="span6"><input id="name_on_card" name="nameOnCard" class="span12" type="text" maxlength="50" placeholder="e.g. John Smith" /></div>
            </div>
            <div class="row-fluid">
              <div class="span4 field-title text-right">Card Number</div>
              <div class="span6"><input id="pan" name="pan" class="span12" type="text" maxlength="19" placeholder="e.g. 5555555555554444" pattern="[0-9 ]+" autocomplete="off"/></div>
            </div>
            <div class="row-fluid">
              <div class="span4 field-title text-right">Exp Date &amp; CVC</div>
              <div class="span2">
                <select id="exp_month" name="expiryMonth" class="span12">
                  <?php 
                    $month = date("m");
                    for ($i = 1; $i <= 12; $i++) { ?>
                      <option value="<?php echo $i ?>" <?php if ($i == $month) echo "selected" ?>><?php echo $i ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="span2">
                <select id="exp_year" name="expiryYear" class="span12">
                  <?php 
                    $year = date("Y");
                    for ($i = 0; $i < 10; $i++) { ?>
                      <option value="<?php echo ($year + $i) % 100 ?>"><?php echo $year + $i ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="span2"><input id="cvc" name="cvc" class="span12" type="text" maxlength="4" placeholder="e.g. 123" pattern="[0-9]*" autocomplete="off" /></div>
            </div>
          </div><!-- card-info -->
          <div class="address-info">
            <h3>Enter your address.</h3><!-- NOTE: We now assume billing & shipping addresses are the same for demo purpose. -->
            <div class="row-fluid">
              <div class="span4 field-title text-right">Address</div>
              <div class="span6"><input id="address" name="address" class="span12" type="text" maxlength="100" placeholder="e.g. 123 Main St." /></div>
            </div>
            <div class="row-fluid">
              <div class="span4 field-title text-right">City</div>
              <div class="span6"><input id="city" name="city" class="span12" type="text" maxlength="50" placeholder="e.g. Jackson" /></div>
            </div>
            <div class="row-fluid">
              <div class="span4 field-title text-right">State &amp; ZIP</div>
              <div class="span3">
                <select id="state" name="state" class="span12">
                  <?php 
                    for ($i = 0; $i < count($merchant->shippingToStates); $i++) { ?>
                      <option value="<?php echo $merchant->shippingToStates[$i] ?>"><?php echo $merchant->shippingToStates[$i] ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="span3"><input id="zip" name="zip" class="span12" type="text" placeholder="e.g. 63367" maxlength="9" pattern="[0-9]*"></div>
            </div>
          </div><!-- address-info -->

          <div class="button-row">
            <h3><a id="submit_order" class="btn btn-custom pull-right">Place My Order</a></h3>
            <h3><a id="go_back" class="btn btn-custom pull-left">Return</a></h3>
          </div><!-- button-row -->
        </form>
      </div><!-- form-body -->

      <footer>
        <p class="pull-right">Visit <a href="<?php echo $merchant->url ?>" target="_blank"><?php echo $merchant->urlDisplay ?></a></p>
        <p>Powered by <a href="http://www.simplify.com" target="simplify">Simplify.com</a></p>
      </footer>
    </div><!-- form-body-wrapper -->
  </div><!-- form-wrapper -->

  <!-- javascript -->
  <script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script type="text/javascript" src="https://www.simplify.com/commerce/v1/simplify.js"></script>
  <script type="text/javascript" src="https://www.simplify.com/commerce/simplify.form.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
  <script src="assets/js/validation.js"></script>
  <script type="text/javascript">
    function simplifyResponseHandler(data) {
      
      var $paymentForm = $("#checkout_form");
      // Remove all previous errors
      $(".error").remove();
      // Check for errors
      if (data.error) {
        // Show any validation errors
        if (data.error.code == "validation") {
          var fieldErrors = data.error.fieldErrors,
          fieldErrorsLength = fieldErrors.length,
          errorList = "";
          for (var i = 0; i < fieldErrorsLength; i++) {
            errorList += "<div class='error'>Field: '" + fieldErrors[i].field + "' is invalid - " + fieldErrors[i].message + "</div>";
          }
          // Display the errors
          $paymentForm.before(errorList);
        }
        // Re-enable the submit button
          $("#submit_order").removeAttr("disabled");
      } else {
        // The token contains id, last4, and card type
        var token = data["id"];
        // Insert the token into the form so it gets submitted to the server
        $paymentForm.append("<input type='hidden' name='simplifyToken' value='" + token + "' />");
        // Submit the form to the server
        $paymentForm.get(0).submit();
      }
    }

    $(document).ready(function() {
      //digit only for input
      $("#cvc").keydown(digitsOnly);
      $("#pan").keydown(digitsOnly);
      $("#zip").keydown(digitsOnly);

      // formatCardNumber : simplify.form.js
      $("#pan").formatCardNumber();

      $("input#name_on_card").blur(function() {nameValidator(this, this.value);});
      $("input#pan").blur(function() {creditCardValidator(this, this.value);});
      $("input#cvc").blur(function() {cvcValidator(this, this.value);});
      $("select#exp_month").change(function() {expValidator(this, this.value);});
      $("select#exp_year").change(function() {expValidator(this, this.value);});
      $("input#address").blur(function() {addressValidator(this, this.value);});
      $("input#city").blur(function() {cityValidator(this, this.value);});
      $("input#zip").blur(function() {zipValidator(this, this.value);});
      $("#go_back").click(function() {
        window.history.go(-1);        
      });
      $("#submit_order").click(function() {
        if (overallValidation()) {
          $("#submit_order").attr("disabled", "disabled");
          // Generate a card token & handle the response
          SimplifyCommerce.generateToken({
            key: "<?php echo $simplifyPublicKey ?>",
            card: {
              number: $("#pan").val().replace(/ /g, ""),
              cvc: $("#cvc").val(),
              expMonth: $("#exp_month").val(),
              expYear: $("#exp_year").val(),
              name: $("#name_on_card").val(),
              addressLine1: $("#address").val(),
              addressCity: $("#city").val(),
              addressState: $("#state").val(),
              addressZip: $("#zip").val()
            }
          }, simplifyResponseHandler);
        }
      });
    });
  </script>
</body>
</html>

