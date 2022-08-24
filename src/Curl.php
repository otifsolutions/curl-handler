<?php

namespace OTIFSolutions\CurlHandler;
use OTIFSolutions\CurlHandler\Exceptions\CurlException;
use OTIFSolutions\CurlHandler\Helpers\Helper;

/**
 * Class Curl
 * @package OTIFSolutions\CurlHandler
 */
class Curl
{
    /**
     * @param array $cookies
     * @return object
     */
    public static function Make(array &$cookies = []):object
    {
        return new class($cookies){
            private string $url ;
            private $bodies ;
            private $headers ;
            private $params ;
            private string $method ;
            private mixed $curl;
            private array $errors = [];
            private array $cookies;

            public function __construct(&$cookies){
                $this->curl = curl_init();
                $this->cookies = &$cookies;
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
             * @param mixed $arguments
             *
             * @return mixed
             */
            public function __call(mixed $func, mixed $arguments)
            {
                if ($func === 'url') {
                    return $this->url($arguments);
                }

                if ($func === 'header') {
                    return $this->header($arguments);
                }

                if ($func === 'body') {
                    return $this->body($arguments);
                }

                if ($func === 'params') {
                    return $this->params($arguments);
                }

                if($func === 'execute') {
                    return $this->execute();
                }

                $this->errors[] = $func.'()'.' is not defined function';
                return $this;
            }
            /**
             * @param mixed $url
             *
             * @return object
             */
            private function url(mixed $url): object
            {
                if(isset($url[0]) && is_string($url[0])){
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
            private function header(mixed $headers): object
            {
                if(isset($headers[0]) && is_array($headers[0])){
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
            private function body(mixed $bodies): object
            {
                if(isset($bodies[0]) && is_array($bodies[0])){
                    if(count($bodies[0])>0){
                        $this->bodies = json_encode($bodies[0], JSON_THROW_ON_ERROR);
                    }
                }
                elseif(isset($bodies[0]) && is_string($bodies[0])){
                    $this->bodies = $bodies[0];
                }
                else{
                    $this->errors[] = 'Body data must be an array or string';
                }
                return $this;
            }
            /**
             * @param mixed $params
             *
             * @return object
             */
            private function params(mixed $params): object
            {
                if(isset($params[0]) && is_array($params[0])){
                    if(count($params[0])>0){
                        $this->params = http_build_query($params[0]);
                    }
                }

                else{
                    $this->errors[] = 'Param data must be an array';
                }
                return $this;
            }

            /**
             * @return array
             */
            private function execute() : array
            {
                if(count($this->errors) === 0){
                    curl_setopt_array ( $this->curl, [
                        CURLOPT_URL => $this->url.($this->params?'?'.$this->params:''),
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => $this->method,
                        CURLOPT_HTTPHEADER => $this->headers ?? [],
                        CURLOPT_POSTFIELDS => $this->bodies,
                        CURLOPT_HEADERFUNCTION => function($ch , $headerLine){
                            if (preg_match('/^Set-Cookie:\s*([^;]*)/mi', $headerLine, $cookies) === 1) {
                                foreach ($cookies as $cookie)
                                {
                                    $this->cookies[] = $cookie;
                                }
                            }
                            return strlen($headerLine);
                        }
                    ]);
                    $response = curl_exec($this->curl);
                    if (curl_error($this->curl)){
                        $this->errors[] = 'Internal error occured';
                        throw new CurlException($this->errors);
                    }
                    if (Helper::isJson($response)) {
                        return json_decode($response, true, 512, JSON_THROW_ON_ERROR);
                    }

                    return Helper::isDOMDocument($response) ? Helper::domToArray($response) : [
                        'body' => $response
                    ];
                }

                throw new CurlException($this->errors);
            }

            public function __destruct(){
                curl_close($this->curl);
            }
        };
    }
}
