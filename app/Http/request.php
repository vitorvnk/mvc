<?php
    namespace App\Http;

    class Request{
        //método HTTP da request
        private $httpMethod;
        //URI da request
        private $uri;
        //Parametros da URL
        private $queryParams = [];
        //Variáveis recebidos no POST da página
        private $postVars = [];
        //Cabeçario da Request
        private $headers =[];

        public function __construct(){
            $this->queryParams = $_GET ?? [];
            $this->postVars = $_POST ?? [];
            $this->headers = getallheaders();
            $this->httpMethod = $_SERVER['REQUEST_METHOD'] ?? '';
            $this->uri = $_SERVER['REQUEST_URI'] ?? '';
        }
        public function getHttpMethod(){
            return $this->httpMethod;
        }
        public function getUri(){
            return $this->uri;
        }
        public function getHeaders(){
            return $this->headers;
        }
        public function getQueryParams(){
            return $this->queryParams;
        }
        public function getPostVars(){
            return $this->postVars;
        }

    }


?>