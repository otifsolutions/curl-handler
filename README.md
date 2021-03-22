# **Curl-Handler**

### **Requirements**

PHP 7 > PHP 7.4

### **How to use the library**

Install via the composer

Using the composer(Recomended)

Either run the following command in the root directory of your project:

**composer require otifsolutions/curl-handler**

Namespace for using class

**use OTIFSolutions\CurlHandler\Curl;**

### **Methods:**

url('')

header([])

params([])

body([])

execute()

**getCurlErrors()** : use to display the errors

### **Request Types:**

GET 

POST 

PUT

DELETE

### **DEMO Use:**

try{

Curl::Make()->ANY REQUEST TYPE->**url**('URL_GOES_HERE')->**header**(['AUTHENTICATION_ARRAY_GOES_HERE'])->**body**(['BODY_ARRAY_GOES_HERE'])->**params**(['PARAMS_ARRAY_GOES_HERE'])->**execute**() ;

}

catch(CurlException $e){

return ($e->getCurlErrors());
    
}


### **Get request for api call**

Curl class:: Curl::Make()->GET->**url**('URL_GOES_HERE')->**header**(['AUTHENTICATION_ARRAY_GOES_HERE'])->**params**(['PARAMS_ARRAY_GOES_HERE'])->**execute**()

**Methods Type** : url('STRING'),HEADER(['ARRAY']),PARAMS(['ARRAY])

**Error Detail** : if you write any wrong function name or value then system will display error message

### **Post request**

Curl class:: Curl::Make()->POST->**url**('URL_GOES_HERE')->**header**(['AUTHENTICATION_ARRAY_GOES_HERE'])->**body**(['BODY_ARRAY_GOES_HERE'])->**params**(['PARAMS_ARRAY_GOES_HERE'])->**execute**()

**Methods Type** : url('STRING'),HEADER(['ARRAY']),BODY(['ARRAY']),PARAMS(['ARRAY])

**Error Detail** : if you write any wrong function name or value then system will display error message

### **Put request**

Curl class:: Curl::Make()->PUT->url('URL_GOES_HERE')->header(['AUTHENTICATION_ARRAY_GOES_HERE'])->**body**(['BODY_ARRAY_GOES_HERE'])->**params**(['PARAMS_ARRAY_GOES_HERE'])->**execute**()

**Methods Type** : url('STRING'),HEADER(['ARRAY']),BODY(['ARRAY']),PARAMS(['ARRAY])

**Error Detail** : if you write any wrong function name or value then system will display error message

### **Delete request**

Curl class:: Curl::Make()->DELETE->**url**('URL_GOES_HERE')->**header**(['AUTHENTICATION_ARRAY_GOES_HERE'])->**params**(['PARAMS_ARRAY_GOES_HERE'])->**execute**()

**Methods Type** : url('STRING'),HEADER(['ARRAY']),BODY(['ARRAY']),PARAMS(['ARRAY])

**Error Detail** : if you write any wrong function name or value then system will display error message

Details
This pakage is used to for handling api call by using otifsolution culr handler Curl class.