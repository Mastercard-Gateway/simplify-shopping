Simplify Shopping Website Template
==================================

This website template is an example to help developers start building a simple shopping website using Simplify Commerce by MasterCard to accept payments.

This example shows a cupcake shop named 'Simplify Cake' with three products on the menu. 

Features
--------
* Based on Bootstrap by Twitter
* Responsive design for different screen sizes including mobile devices
* Basic form validations (e.g. quantity check, credit card luhn check, expiry date check, etc)
* Integrated with SimplifyJS for card tokenization and Simplify Commerce PHP SDK for payment creation
* Runnable end-to-end demo flow out of the box (without customization)
* Merchant information and products can be easily customized in PHP
* Checkout with [Simplify Hosted Payments](https://www.simplify.com/commerce/docs/tools/hosted-payments)
* Save customer card details

Customization
-------------

### Simplify API Keys

Firstly, you need to configure your Simplify API keys.  Visit simplify.com to sign up for an account if you haven't done so.  Login to your account and you will find your keys in the 'Settings' -> 'API Keys'.

Copy your keys and change the data/SimplifyKeys.php accordingly.

```php
<?php
$simplifyPrivateKey = 'YOUR_SIMPLIFY_PRIVATE_API_KEY';	//E.g.: DvO+9QRpinM6iBQI/OFxpbId/kYi9pCQ4petiZHZiCJ5YFFQL0ODSXAOkNtXTToq
$simplifyPublicKey 	= 'YOUR_SIMPLIFY_PUBLIC_API_KEY';	//E.g.: sbpb_M2M0ZTk2Y2ItNTcxMi00Y2QxLWJmNTctNzg4ZjEzMGMzY2Nj
?>
```

### Merchant Data

If you want to change the merchant information, update the data/MerchantData.php.  Please follow the existing content as an example.  It is quite simple and self explanatory.

```php
$merchant = new Merchant;
$merchant->name = 'The Simplify Cake';
$merchant->header = 'Enjoy our delectable cupcakes.';
$merchant->description = 'We are a delivery only cupcake business. We specialize in made from scratch gourmet cupcakes. Our goal is to change your cupcake experience forever.';
$merchant->url = 'index.php'; //'http://whatever_url';
$merchant->urlDisplay = 'simplifycake.com'; //Only for display purpose
$merchant->email = 'simplifycake@gmail.com';
$merchant->mainColor = '#F15E92';

$merchant->products[] = new Product('Mixed Box of Cupcakes', 
	'You will get one box of mixed cupcakes in the mail. They will arrive in a sealed and chilled bag.', 
	'assets/img/cupcake1.png', 
	1000); //$10.00

$merchant->products[] = new Product('Rainbow Cupcake', 
	'This is for a single box of rainbow cupcakes.', 
	'assets/img/cupcake2.png', 
	2000); //$20.00

$merchant->products[] = new Product('One Tiny Cake', 
	'This is for one piece of our signature cake.', 
	'assets/img/cupcake3.png', 
	350); //$3.50

$merchant->shippingToStates = array('AK', 'AL', 'AR', 'AZ', 'CA', 'CO', 'CT', 'DC', 'DE', 'FL', 'GA', 'HI', 'IA', 'ID', 'IL', 'IN', 'KS', 'KY', 'LA', 'MA', 'MD', 'ME', 'MI', 'MN', 'MO', 'MS', 'MT', 'NC', 'ND', 'NE', 'NH', 'NJ', 'NM', 'NV', 'NY', 'OH', 'OK', 'OR', 'PA', 'RI', 'SC', 'SD', 'TN', 'TX', 'UT', 'VA', 'VT', 'WA', 'WI', 'WV', 'WY');

// flag to enable Simplify hosted payments : https://www.simplify.com/commerce/docs/tools/hosted-payments
$merchant->enableHostedPayments = true;

```

### Testing

To test the checkout flow you can use the test cards detailed here - [https://www.simplify.com/commerce/docs/tools/hosted-payments#testing](https://www.simplify.com/commerce/docs/tools/hosted-payments#testing)

Details on Simplify hosted payments and MasterPass can be found here - [https://www.simplify.com/commerce/docs/tools/hosted-payments](https://www.simplify.com/commerce/docs/tools/hosted-payments)

Details on the Simplify API can be found here - [https://www.simplify.com/commerce/docs/api/index](https://www.simplify.com/commerce/docs/api/index)
