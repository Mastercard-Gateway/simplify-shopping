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
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Order - <?php echo $merchant->name ?></title>
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
    .unit-price-on {
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

<?php if ($merchant->enableHostedPayments) { ?>
  <form id="order_form" action="hosted-checkout.php" method="POST">
<?php } else { ?>
  <form id="order_form" action="checkout.php" method="POST">
<?php } ?>
    <div class="container form-wrapper">

      <div class="container form-header-wrapper">
        <div class="container form-header">
          <div class="pull-right text-right">
            <p>Order Total</p>
            <h3><div id="total_amount">$0.00</div></h3>
          </div>
          <div>
          	<div>
          		<p>Merchant</p>
            	<h3><?php echo $merchant->name ?></h3>
          	</div>
          </div>
        </div>
      </div>

      <div class="container form-body-wrapper bg-grey">
          <div class="container form-body">

            <h3><?php echo $merchant->header ?></h3>
            <p><?php echo $merchant->description ?></p>

            <div class="product-list">

              <?php 
              for ($i = 0; $i < count($merchant->products); $i++) { 
                $p = $merchant->products[$i];
              ?>
              <div class="product">
                <div class="row-fluid">
                  <img class="img-rounded span2" src="<?php echo $p->imgUrl ?>">
                  <div class="span6">
                    <h4><?php echo $p->name ?></h4>
                    <p><?php echo $p->description ?></p>
                  </div>
                  <div class="pricing-box span4">
                    <div class="span5"><div id="price<?php echo $i ?>" class="unit-price pull-right">$<?php echo number_format($p->price / 100.0,2) ?></div></div>
                    <div class="span2 cross-sign">X</div>
                    <div class="span5"><input id="quantity<?php echo $i ?>" name="quantity<?php echo $i ?>" class="quantity-picker span12" type="number" min="0" max="20" step="1" value="0" pattern="[0-9]*" onClick="this.select();" /></div>
                  </div>
                </div>
              </div>
              <?php 
              } 
              ?>

            </div>

            <div class="button-row">
              <h3><a id="submit_order" class="btn btn-custom pull-right">Place My Order</a></h3>
            </div>

          </div>

          <footer>
            <p class="pull-right">Visit <a href="<?php echo $merchant->url ?>" target="_blank"><?php echo $merchant->urlDisplay ?></a></p>
            <p>Powered by <a href="http://www.simplify.com" target="simplify">Simplify.com</a></p>
          </footer>
      </div>
    </div>
  </form>

  <!-- javascript -->
  <script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
  <script src="assets/js/validation.js"></script>
  <script type="text/javascript">
    function updateTotalAmount() {
      var totalAmount = 0;
      <?php 
        for ($i = 0; $i < count($merchant->products); $i++) {
          $p = $merchant->products[$i];
      ?>
      var quantity = parseInt($("#quantity<?php echo $i ?>").val(), 10);
      totalAmount += <?php echo $p->price ?> * quantity;
      if (quantity > 0) {
        $("#price<?php echo $i ?>").addClass("unit-price-on");
      }
      else {
        $("#price<?php echo $i ?>").removeClass("unit-price-on");
      }
      <?php  
        }
      ?>
      if (isNaN(totalAmount)) {
        $("#total_amount").text("$0.00");
      }
      else {
        $("#total_amount").text("$" + parseFloat(Math.round(totalAmount) / 100.0).toFixed(2));
      }
    }

    function validated() {
      var isEmptyOrder = true;
      <?php for ($i = 0; $i < count($merchant->products); $i++) { ?>
      if (isEmptyOrder && parseInt($("#quantity<?php echo $i ?>").val(), 10) > 0) {
        isEmptyOrder = false;
      }
      if (parseInt($("#quantity<?php echo $i ?>").val(), 10) > 20) {
        alert("You can only select up to 20 items for each product.");
        return false;
      }
      <?php } ?>
      if (isEmptyOrder) {
        alert("Please select some products.");
        return false;
      }
      return true;
    }

    $(document).ready(function() {
      updateTotalAmount();
      <?php for ($i = 0; $i < count($merchant->products); $i++) { ?>
      $("#quantity<?php echo $i ?>").bind("change", updateTotalAmount);
      $("#quantity<?php echo $i ?>").keydown(digitsOnly);
      <?php } ?>

      $("#submit_order").click(function() {
        if (validated()) {
          $("#order_form").submit();
        }
      });
    });
  </script>
</body>
</html>

