<?php

namespace OTIFSolutions\CurlHandler;
use OTIFSolutions\CurlHandler\Exceptions\CurlException;

/**
 * Class Curl
 * @package OTIFSolutions\CurlHandler
 */
class Curl
{
    /**
     * @return object
     */
    public static function Make():object
    {
        return new class(){
            private $url ;
            private $bodies ;
            private $headers ;
            private $params ;
            private $method ;
            private $curl;
            private $errors=[];

            public function __construct(){
                $this->curl = curl_init();
            }
            public function __get($method): object
            {
                if ($method === 'GET'){
                    $this->method = $method;
                }
                elseif ($method === 'POST'){
                    $this->method = $method;
                }
                elseif ($method === 'DELETE'){
                    $this->method = $method;
                }
                elseif ($method === 'PUT'){
                    $this->method = $method;
                }
                else{
                    $this->errors[] = $method. ' property not defined';
                }
                return $this;
            }
            /**
             * @param mixed $func
             * @param mixed $arguement
             *
             * @return mixed
             */
            public function __call($func,$arguement)
            {
                if($func === 'url'){
                    return $this->url($arguement);
                }
                elseif($func === 'header'){
                    return $this->header($arguement);
                }
                elseif($func === 'body'){
                    return $this->body($arguement);
                }
                elseif ($func === 'params'){
                    return $this->params($arguement);
                }
                elseif ($func === 'execute'){
                    return $this->execute();
                }
                else{
                    $this->errors[] = $func.'()'.' is not defined function';
                    return $this;
                }
            }
            /**
             * @param mixed $url
             *
             * @return object
             */
            private function url($url): object
            {
                if(isset($url[0]) && gettype($url[0]) === 'string'){
                    $this->url = implode($url);
                }
                else{
                    $this->errors[] = 'url should not null or url must be a string';
                }
                return $this;
            }
            /**
             * @param mixed $headers
             *
             * @return object
             */
            private function header($headers): object
            {

                if(isset($headers[0]) && gettype($headers[0]) === 'array'){
                    $this->headers;
                    if(count($headers[0])>0){
                        $this->headers = $headers[0];
                    }
                }

                else{
                    $this->errors[] = 'Header data must be an array';
                }
                return $this;
            }
            /**
             * @param mixed $bodies
             *
             * @return object
             */
            private function body($bodies): object
            {
                if(isset($bodies[0]) && gettype($bodies[0]) === 'array'){
                    $this->bodies;
                    if(count($bodies[0])>0){
                        $this->bodies = $bodies[0];
                    }
                }
                else{
                    $this->errors = ['message'=>'Body data must be an array'];
                }
                return $this;
            }
            /**
             * @param mixed $params
             *
             * @return object
             */
            private function params($params): object
            {
                if(isset($params[0]) && gettype($params[0]) === 'array'){
                    $this->params;
                    if(count($params[0])>0){
                        $this->params = http_build_query($params[0]);
                    }
                }

                else{
                    $this->errors[] = 'Param data must be an array';
                }
                return $this;
            }

            private function execute() : array
            {
                if(count($this->errors) ==0){
                    curl_setopt_array ( $this->curl, [
                        CURLOPT_URL => $this->url.($this->params?'?'.$this->params:''),
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => $this->method,
                        CURLOPT_HTTPHEADER => $this->headers ?? [],
                        CURLOPT_POSTFIELDS => $this->bodies ? json_encode($this->bodies) : [],
                    ]);
                    $response = curl_exec($this->curl);
                        if (curl_error($this->curl)){
                            $this->errors[] = 'Internal error occured';
                            throw new CurlException($this->errors);
                        }
                    return json_decode($response,true,512,JSON_THROW_ON_ERROR);
                }
                else{
                    throw new CurlException($this->errors);
                }
            }
            public function __destruct(){
                curl_close($this->curl);
            }
        };
    }
}
