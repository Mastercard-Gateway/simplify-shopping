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
require_once 'simplifycommerce-sdk-php/lib/Simplify.php';

session_start(); 

if (isset($_REQUEST['simplifyToken']) == false || isset($_SESSION['totalAmount']) == false || isset($_SESSION['orders']) == false) {
	header("Location: index.php"); /* Redirect browser */
	exit();
} 

$simplifyToken = $_REQUEST['simplifyToken'];
$customerName = $_REQUEST['customerName'];
$customerEmail = $_REQUEST['customerEmail'];
$totalAmount = $_SESSION['totalAmount'];
$orders = $_SESSION['orders'];
//Getting shipping address
$address = $_REQUEST['address'];
$city = $_REQUEST['city'];
$state = $_REQUEST['state'];
$zip = $_REQUEST['zip'];

//Generate payment description
$description = "";
foreach ($orders as $productId => $quantity) {
	$description .= $merchant->products[$productId]->name . ":$" . number_format($merchant->products[$productId]->price / 100,2) . "X" . $quantity . ",";
}
$description .= $address . " " . $city . " " . $state . " " . $zip;

session_destroy();

try {
	Simplify::$publicKey = $simplifyPublicKey;
	Simplify::$privateKey = $simplifyPrivateKey;

	// if the save card details flag is set 
	if ($_REQUEST['saveCardDetails'] == true && isset($customerName) == true && isset($customerEmail) == true) {

		// create a customer
		$customer = Simplify_Customer::createCustomer(array(
			'token' => $simplifyToken,
			'email' => $customerEmail,
			'name' => $customerName,
			'reference' => 'Simplify Cake customer'
		));

		// make a payment with the customer
		$payment = Simplify_Payment::createPayment(array(
			'amount' => $totalAmount,
			'description' => $description,
			'currency' => 'USD',
			'customer' => $customer->id
		));

	} else {

		// make a payment with a card token
		$payment = Simplify_Payment::createPayment(array(
			'amount' => $totalAmount,
			'token' => $simplifyToken,
			'description' => $description,
			'currency' => 'USD'
		));
	}
}
catch (Exception $e) {
	//Something wrong
	//Error handling needed

	//echo $e;
}

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
	<div class="bg-img"><!--[if lt IE 9]><img class="bg-img" src="assets/img/bg.jpg" /><![endif]--></div>

	<div class="container form-wrapper">
		<div class="container form-header-wrapper">
			<div class="container form-header" style="background-color: <?php echo $merchant->mainColor ?>">
				<div>
					<p>Merchant</p>
					<h3><?php echo $merchant->name ?></h3>
				</div>
			</div>
		</div>

		<div class="container form-body-wrapper">
			<div class="container form-body">
			
				<?php if($payment->paymentStatus == 'APPROVED') { ?>
				<h3>Order #<?php echo $payment->id ?></h3>
				<div class="container-fluid receipt-wrapper">
					<?php foreach ($orders as $productId => $quantity) { ?>
						<div class='row-fluid'>
							<div class='span10'><?php echo $merchant->products[$productId]->name; ?></div>
					 		<div class='span2 text-right'>$<?php echo number_format($merchant->products[$productId]->price / 100,2) ;echo " X "; echo $quantity; ?></div>
					 	</div>
					<?php } ?> 
						<div class='row-fluid'>
							<div class='span10'><h4>TOTAL AMOUNT</h4></div>
					 		<div class='span2 text-right'><h4>$<?php echo number_format($totalAmount / 100,2) ; ?></h4></div>
					 	</div>
				</div>
				<hr/>
				<h4>Your order will be shipped to</h4>
				<div class="container-fluid receipt-wrapper">
					<div class='row-fluid'>
						<?php echo $address; ?>
					</div>
					<div class='row-fluid'>
						<?php echo $city; ?>
					</div>
					<div class='row-fluid'>
						<?php echo $state; ?> <?php echo $zip; ?>
					</div>
				</div>
				<hr/>
				<p>Thank you for completing the purchase. If you have any questions, please contact <a href="mailto:<?php echo $merchant->email; ?>"><?php echo $merchant->email; ?></a></p>
				<?php } else { ?>
				<p>Sorry, you payment has been declined. If you have any questions, please contact <a href="mailto:<?php echo $merchant->email; ?>"><?php echo $merchant->email; ?></a></p>
				<?php } ?>
			</div>

			<footer>
				<p class="pull-right">Visit <a href="<?php echo $merchant->url ?>" target="_blank"><?php echo $merchant->urlDisplay ?></a></p>
				<p>Powered by <a href="http://www.simplify.com" target="simplify">Simplify.com</a></p>
			</footer>

		</div>

	</div>


	<!-- javascript -->

	<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
</body>
</html>
