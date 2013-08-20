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

Customization
-------------

### Simplify API Keys

Firstly, you need to configure your Simplify API keys.  Visit simplify.com to sign up for an account if you haven't done so.  Login to your account and you will find your keys in the 'Settings' -> 'API Keys'.

Copy your keys and change the data/SimplifyKeys.php accordingly.

```php
<?php
$simplifyPrivateKey = 'YOUR_SIMPLIFY_PRIVATE_API_KEY';	//E.g.: EeP6FNN0V/Yvf8gsSrfjv5oE0GyEZNtbDpHMFyQDgCh5YFFQL0ODSXAOkNtXTToq 
$simplifyPublicKey 	= 'YOUR_SIMPLIFY_PUBLIC_API_KEY';	//E.g.: sbpb_M2Y0NTI2MWYtNjk2OS00OGExLThlMWYtNGMyODcyMGQ1ODky
?>
```

### Merchant Data

If you want to change the merchant information, update the data/MerchantData.php.  Please follow the existing content as an example.  It is quite simple and self explanatory.



