<?php
    namespace App\Http;

    class Response{
        //Status do PHP
        private $httpCode = 200;
        //Cabeçario responsivo
        private $headers = [];
        //Tipo de conteúdo que será retornado
        private $contentType = 'text/html';
        //Guarda o conteudo do response
        private $content;

        //Inicia a classe e define os valores
        public function __construct($httpCode,$content,$contentType = 'text/html'){
            $this->httpCode = $httpCode;
            $this->content = $content;
            $this->setContentType($contentType);
        }

        //Responsável por alterar o ContentType
        public function setContentType($contentType){
            $this->contentType = $contentType;
            $this->addHeader('Content-Type', $contentType);
        }

        //Metodo responsável por adicionar o registro no cabeçário de response
        public function addHeader($key,$value){
            $this->headers[$key] = $value;
        }

        //metodo responável por enviar o Headers para o navegador
        private function sendHeaders(){
            //Status
            http_response_code($this->httpCode);

            //Enviar Headers
            foreach($this->headers as $key=>$value){
                header($key.': '.$value);
            }

        }


        //Metodo responsável por enviar a resposta para o usuário
        public function sendResponse(){
            //Envia o Headers
            $this->sendHeaders();

            //Envia o Conteudo
            switch ($this->contentType) {
                case 'text/html':
                    echo $this->content;
                    exit;
            }
        }

    }


?>