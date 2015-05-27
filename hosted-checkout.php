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
    .hosted-form{
      height: 530px;
      margin: 0 auto;
      width: 400px;
      border:0;
    }
  </style>


  <!-- https://www.simplify.com/commerce/ie/docs/tools/hosted-payments -->
  <script type="text/javascript" src="https://www.simplify.com/commerce/v1/simplify.js"></script>
  <script type="text/javascript" src="https://www.simplify.com/commerce/simplify.pay.js"></script>
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

          <div class="card-info">
            <div class="row-fluid">
              <div class="span12 text-center">

                <!-- https://www.simplify.com/commerce/ie/docs/tools/hosted-payments#embed -->
                <iframe name="submit_order" class="hosted-form"
                  data-unstyled="true"
                  data-receipt="true"
                  data-sc-key="<?php echo $simplifyPublicKey ?>"
                  data-name="The Simplify Cake"
                  data-description="Please enter your card details"
                  data-color="#F15E92"
                  data-masterpass="true"
                  data-operation="create.token"
                  data-amount="<?php echo $totalAmount ?>">
                  Place My Order
                </iframe>

              </div>
            </div>
          </div>

          <div class="button-row">
            <div class="pull-right"> 
              <form id="checkout_form" action="payment.php" method="POST">
                <label for="saveCardDetails"><input id="saveCardDetails" type="checkbox" name="saveCardDetails" value="true"/> Save customer card details</label></div>
              </form>
            <h3><a id="go_back" class="btn btn-custom">Return</a></h3>

          </div><!-- button-row -->

      </div><!-- form-body -->

      <footer>
        <p class="pull-right">Visit <a href="<?php echo $merchant->url ?>" target="_blank"><?php echo $merchant->urlDisplay ?></a></p>
        <p>Powered by <a href="http://www.simplify.com" target="simplify">Simplify.com</a></p>
      </footer>
    </div><!-- form-body-wrapper -->
  </div><!-- form-wrapper -->

  <!-- javascript -->
  <script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
  <script src="assets/js/validation.js"></script>
  <script type="text/javascript">

    // https://www.simplify.com/commerce/ie/docs/tools/hosted-payments
    SimplifyCommerce.hostedPayments(
        // response handler
        function(response) {

          var $paymentForm = $("#checkout_form");

          // Insert the token into the form so it gets submitted to the server
          $paymentForm.append("<input type='hidden' name='simplifyToken' value='" + response.cardToken + "' />");

          if (response.name) {
            $paymentForm.append("<input type='hidden' name='customerName' value='" + response.name + "' />");
          }
          if (response.email) {
            $paymentForm.append("<input type='hidden' name='customerEmail' value='" + response.email + "' />");
          }

          // Submit the form to the server
          $paymentForm.get(0).submit();
        }
    )

    $(document).ready(function() {
      $("#go_back").click(function() {
        window.history.go(-1);        
      });
    });

  </script>
</body>
</html>

