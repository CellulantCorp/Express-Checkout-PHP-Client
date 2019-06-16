# Mula express checkout
This is a composer package that aims to encapsulate most of the server side set needed when integrating your site to the Mula express checkout. Features included:
1. Account creation. 
Create an account on our sandbox to get started on this [link](https://beep2.cellulant.com:9212/checkout/v2/portal/#/register/user)
2. Encryption

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
	  customerFirstName: 'Customer',
	  customerLastName: 'Customer',
	  customerEmail: 'test@gmail.com',
	  amount: 100,
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
	  dueDate: '2018-10-17 19:30:00',
	  successRedirectUrl:"http://localhost/mula-checkout/success.php",
          failRedirectUrl: "http://localhost/mula-checkout/failed.php",
          paymentWebhookUrl: "http://localhost/mula-checkout/payment_webhook.php"
  };

...
```

## Adding the mula button on your webpage
<!-- The "Pay with mula" button needs to have the "mula-checkout-button" class -->
<a class="checkout-button"></a>

You also need to have our js file imported on your web page which include the support functions
<script id="mula-checkout-library" type="text/javascript" src="https://beep2.cellulant.com:9212/checkout/v2/mula-checkout.js" charset="utf-8"></script>

MulaCheckout.addPayWithMulaButton({ className:'checkout-button', checkoutType:'express'});

## Send the params to the encryption URL
 // Initialize the mula checkout modal/redirect
            //on button click, redirect to express checkout
            document.querySelector(".mula-checkout-button").addEventListener("click", function () {

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
			MulaCheckout.renderMulaCheckout({
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
