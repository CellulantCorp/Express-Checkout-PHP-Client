# Mula express checkout
This is a composer package that aims to encapsulate most of the server side set needed when integrating your site to the Mula express checkout. Features included:
1. Encryption
2. Decryption
3. Response formatting. (Returns the format expected by the payment callback. Visit [Mula express checkout documentation](https://beep2.cellulant.com:9001/hub/checkoutDocumentation/express.html#add-mula-button) for more on this.)

## Getting started
This is a composer package and can thus pull it in by adding; <br>
`"mula/express-checkout": "dev-master"`<br>
to your composer.json `require` object and running 
`composer update`

## Encrypting the request data
Before you send your parameters to the express checkout, you are required to encrypt them so as to protect your data from being read or changed by any man-in-the-middle attacks.

```php
...

// Build the mula express checkout payload.
$mulaPayload = (new RequestProcessor(
    config('IV_KEY'),
    config('KEY'),
    config('ACCESS_KEY'),
    config('COUNTRY_CODE')
))->process($parameterArray)

...
```

The payload has the following structure;
```php
...

array(
    'PARAMS' => $encrypted, // The encrypted parameter string
    'ACCESS_KEY' => $access_key, // The merchant's access key
    'COUNTRY_CODE' => $country_code // The merchant's country code
);

...
```

## Decrypting the response data
When the express checkout is sending the payment details for you to acknowledge the payments, the details are encrypted and thus you need to decrypt the passed encrypted string to get the payment details.


```php
...

// Decrypt the payload from the express checkout web hook integration.
$data = (new ResponseProcessor(
    config('IV_KEY'),
    config('KEY')
))->process($passedEncryptedString);


...
```

> Please make sure you protect your access, secret and iv keys from the public as they may be used to masquerade as you to your customers and/ or used to intercept between your communication with mula Express checkout.# Mula express checkout
This is a composer package that aims to encapsulate most of the server side set needed when integrating your site to the Mula express checkout. Features included:
1. Encryption
2. Decryption
3. Response formatting. (Returns the format expected by the payment callback. Visit [Mula express checkout documentation](https://beep2.cellulant.com:9001/hub/checkoutDocumentation/express.html#add-mula-button) for more on this.)

## Getting started
This is a composer package and can thus pull it in by adding; <br>
`"mula/express-checkout": "dev-master"`<br>
to your composer.json `require` object and running 
`composer update`

## Encrypting the request data
Before you send your parameters to the express checkout, you are required to encrypt them so as to protect your data from being read or changed by any man-in-the-middle attacks.

```php
...

// Build the mula express checkout payload.
$mulaPayload = (new RequestProcessor(
    config('IV_KEY'),
    config('KEY'),
    config('ACCESS_KEY'),
    config('COUNTRY_CODE')
))->process($parameterArray)

...
```

The payload has the following structure;
```php
...

array(
    'PARAMS' => $encrypted, // The encrypted parameter string
    'ACCESS_KEY' => $access_key, // The merchant's access key
    'COUNTRY_CODE' => $country_code // The merchant's country code
);

...
```

## Decrypting the response data
When the express checkout is sending the payment details for you to acknowledge the payments, the details are encrypted and thus you need to decrypt the passed encrypted string to get the payment details.


```php
...

// Decrypt the payload from the express checkout web hook integration.
$data = (new ResponseProcessor(
    config('IV_KEY'),
    config('KEY')
))->process($passedEncryptedString);


...
```

> Please make sure you protect your access, secret and iv keys from the public as they may be used to masquerade as you to your customers and/ or used to intercept between your communication with mula Express checkout.
