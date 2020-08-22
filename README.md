# Tingg express checkout
This is a package that aims to encapsulate most of the server side set needed when integrating your site to the Tingg express checkout. Features included:
1. Account creation. 
Create an account on our sandbox to get started on this [link](https://developer.tingg.africa/checkout/v2/portal/#/register/user)
2. Encryption
Encrypt your parameters before sending to checkout for processing. The encryption adds security to your requests ensuring that the data is delivered securely

## Getting started
This is a composer package and can thus pull it in by adding; <br>
`"mula/express-checkout": "dev-master"`<br>
to your composer.json `require` object and running 
`composer update`

## Encrypting the request data
Before you send your parameters to the express checkout, you are required to encrypt them so as to protect your data from being read or changed by any man-in-the-middle attacks. The below params are the request params

```php
...
const params = {
	  merchantTransactionID: no,
	  customerFirstName: 'Customer first name',
	  customerLastName: 'Customer last name',
	  customerEmail: 'test@gmail.com',
	  amount: <chargeAmountToPay>,
	  accountNumber: no,
	  currencyCode: '<currencyCode>',
	  languageCode: 'en',
	  serviceDescription: 'Payment for x service',
	  transactionID: no,
	  serviceCode: '<serviceCode>',
	  productCode: '',
      	  payerClientCode:"",
	  MSISDN: '<mobileNumber>',
	  countryCode: '<countrycode>',
          accessKey:"<access key>",
	  dueDate: '2020-08-20 19:30:00',
	  successRedirectUrl:"http://localhost/tingg-checkout/success.php",
          failRedirectUrl: "http://localhost/tingg-checkout/failed.php",
          paymentWebhookUrl: "http://localhost/tingg-checkout/payment_webhook.php"
  };

...
```

## Adding the Tingg button on your webpage
<!-- The "Pay with Tingg" button needs to have the "checkout-button" class -->
<a class="checkout-button"></a>

You also need to have our js file imported on your web page which include the support functions
<script id="mula-checkout-library" type="text/javascript" src="https://developer.tingg.africa/checkout/v2/tingg-checkout.js" charset="utf-8"></script>

Tingg.addPayWithMulaButton({ className:'checkout-button', checkoutType:'redirect'});

## Send the params to the encryption URL
 // Initialize the Tingg checkout modal/redirect
            //on button click, redirect to express checkout
            document.querySelector(".checkout-button").addEventListener("click", function () {

		    function encrypt() {
		        return fetch(
				merchantURL, 
				{
					method:'POST', 
					body:JSON.stringify(params),
					mode:'cors'
				}).then(response => response.json())
		    }

		    encrypt().then(response => {
			Tingg.renderMulaCheckout({
		                    checkoutType: "express",
                		    merchantProperties: response,
	        	        });
			    }
		   	 )
			    .catch(error => console.log(error));;

	    });

## The response params after encryption have the below params
```php
...

array(
    'params' => $encrypted, // The encrypted parameter string
    'accessKey' => $access_key, // The merchant's access key
    'countryCode' => $country_code // The merchant's country code
);

...
```
> Please make sure you protect your access, secret and iv keys from the public as they may be used to masquerade as you to your customers and/ or used to intercept between your communication with mula Express checkout.

## You may use the below encryption call for IE supported browsers
Tingg.renderPayButton({ className:'checkout-button', checkoutType:'redirect'});

  // Initialize the tingg checkout modal/redirect. To use the modal option use the checkout type: modal
            //on button click, redirect to express checkout
            document.querySelector(".checkout-button").addEventListener("click", function () {

		    function encrypt() {
					var request = new XMLHttpRequest();
					request.open('POST', merchantURL, true);
					request.setRequestHeader('Content-Type', 'application/json; charset=UTF-8');

					request.onreadystatechange = function() {

					    if(this.readyState == XMLHttpRequest.DONE && this.status == 200) {
						var jsonData = JSON.parse(request.responseText);

						Tingg.renderCheckout({
						    checkoutType: "redirect",
						    merchantProperties: jsonData
						});
					    }
					}

					request.send(JSON.stringify(paramss));
		    }
			//encrypt and load checkout
			encrypt();
	    });
