
                 PHP SDK for Simplify Commerce


  What is it?
  ------------

  A PHP API to the Simplify Commerce payments platform.   If you have
  not already got an account sign up at https://www.simplify.com/commerce.


  Installation
  ------------

  Add the lib directory to your PHP include path to access the SDK from
  your application:

      require_once 'Simplify.php'


  Using the SDK
  --------------

  To run a payment though Simplify Commerce use the following
  script substituting your public and private API keys:

    <?php
        require_once("Simplify.php");

        Simplify::$publicKey = 'YOUR_PUBLIC_API_KEY';
        Simplify::$privateKey = 'YOUR_PRIVATE_API_KEY';

        $payment = Simplify_Payment::createPayment(array(
            "card" => array(
                 "number" => "5555555555554444",
                 "expMonth" => 11,
                 "expYear" => 15,
                 "cvc" => "123"
            ),
            'amount' => '1000',
            'description' => 'prod description',
            'currency' => 'USD'
        ));

        print_r($payment);

    ?>


  For more examples see https://www.simplify.com/commerce/docs/sdk/php.

  Version
  -------

  This is version 1.0.1 of the SDK.  See CHANGES.txt for a list 
  of changes. For an up-to-date version check at 
  https://www.simplify.com/commerce/docs/sdk/php.

  Licensing
  ---------

  Please see LICENSE.txt for details.

  Documentation
  -------------

  API documentation is available in the doc directory in HTML.  For more
  detailed information on the API with examples visit the online
  documentation at https://www.simplify.com/commerce/docs/sdk/php.

  Support
  -------

  Please see https://www.simplify.com/commerce/docs/support for information.

  Copyright
  ---------

  Copyright (c) 2013, MasterCard International Incorporated
  All rights reserved.

