# **Curl-Handler**

An Easy to use Curl class. Allows single-line easy API calls.

### **Requirements**

`PHP 7 > PHP 8.1`

__How to use the Library__

Install via Composer **[Composer](https://getcomposer.org/download)** (Recommended)

__Using Composer (Recommended)__

```
composer require otifsolutions/curl-handler
```


Namespace for the package class

```php 
use OTIFSolutions\CurlHandler\Curl
```

__Methods used with the package's curl class__

`url('')`

`header([])`

`params([])`

`body([])`

`execute()`

```php
getCurlErrors();    // used to display errors if any
``` 


__Supported Request Methods:__

`GET`

`POST` 

`PUT`

`DELETE`


__How to use the package:__

```php

use OTIFSolutions\CurlHandler\Curl;
use OTIFSolutions\CurlHandler\Exceptions\CurlException;

try{

    Curl::Make()
        ->get // this could be, get, post, put, delete
        ->url('REQUEST_URL_GOES_HERE')
        ->header(['AUTHENTICATION_ARRAY_GOES_HERE'])
        ->body(['BODY_ARRAY_GOES_HERE'])
        ->params(['PARAMETERS_ARRAY_GOES_HERE'])
        ->execute();
}

catch(CurlException $ce){
    return ($ce->getCurlErrors());
}

```


__Method signatures of all the methods/requests used in the package__  

    `url('STRING') : Object`,
    `header(['ARRAY']) : Object`,
    `body(['ARRAY']) : Object`,
    `params(['ARRAY]) : Object`,
    `execute() : array`,
    `getCurlErrors() : array`,
    `isJson('string'): bool`,
    `isDomDocument('string'): bool`,
    `domToArray($node): mixed`
    

If you are using `PhpStorm IDE` then you don't have to check method signatures every time, 
just go to the method, click it, then do `CTRL + Q` on it, everything that belongs to this method, will be shown.


__Get request for API call__

```php
use OTIFSolutions\CurlHandler\Curl;

Curl::Make()
    ->GET
    ->url('URL_GOES_HERE')
    ->header(['AUTHENTICATION_ARRAY_GOES_HERE'])
    ->params(['PARAMS_ARRAY_GOES_HERE'])
    ->execute();
```

__Post request__

```php
use OTIFSolutions\CurlHandler\Curl;

Curl::Make()
    ->POST
    ->url('URL_GOES_HERE')
    ->header(['AUTHENTICATION_ARRAY_GOES_HERE'])
    ->body(['BODY_ARRAY_GOES_HERE'])
    ->params(['PARAMS_ARRAY_GOES_HERE'])
    ->execute();
```

__Put Request__

```php
use OTIFSolutions\CurlHandler\Curl;

Curl::Make()
    ->PUT
    ->url('URL_GOES_HERE')
    ->header(['AUTHENTICATION_ARRAY_GOES_HERE'])
    ->body(['BODY_ARRAY_GOES_HERE'])
    ->params(['PARAMS_ARRAY_GOES_HERE'])
    ->execute();
```

__Delete request__

```php
use OTIFSolutions\CurlHandler\Curl;

Curl::Make()
    ->DELETE
    ->url('URL_GOES_HERE')
    ->header(['AUTHENTICATION_ARRAY_GOES_HERE'])
    ->params(['PARAMS_ARRAY_GOES_HERE'])
    ->execute();
```

__Note (Precaution):__

If you call any method that does not belong to the `OTIFSolutions\CurlHandler\Curl::class` or give any parameter that it does not understand, then you will see the error messages.

__Realtime example you can check__

This example demonstrates the usage of `curl-handleer` with `get` method, have a look at

**[laravel-currency-layer/Commands/FetchCurrencyRates](https://github.com/otifsolutions/laravel-currency-layer/blob/main/src/Commands/FetchCurrencyRates.php)**