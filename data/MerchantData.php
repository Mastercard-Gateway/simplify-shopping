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

require_once 'SimplifyKeys.php';
require_once 'MerchantModel.php';

$merchant = new Merchant;
$merchant->name = 'The Simplify Cake';
$merchant->header = 'Enjoy our delectable cupcakes.';
$merchant->description = 'We are a delivery only cupcake business. We specialize in made from scratch gourmet cupcakes. Our goal is to change your cupcake experience forever.';
$merchant->url = 'index.php'; //'http://www.simplifycake.com';
$merchant->urlDisplay = 'simplifycake.com';
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

?>
