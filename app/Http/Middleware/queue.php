<?php
    namespace App\Http\Middleware;

    class Queue{
        //mapeamento de Middleware
        private static $map = [];
        //Fila de Middlewares a serem executadas
        private $middlewares = [];
        //Fuincção de execução do controlador
        private $controller;
        //Argumentos da função do controlador
        private $controllerArgs = [];
        //Mapeamento de middlewares que serão carregadas em todas as rotas
        private static $default = [];


        public function __construct($middlewares, $controller, $controllerArgs){
            $this->middlewares = array_merge(self::$default, $middlewares);
            $this->controller = $controller;
            $this->controllerArgs = $controllerArgs;
        }

        //Define o mapeamento de Middleware
        public static function setMap($map){
            self::$map = $map;
        }
        //Define o mapeamento de Middleware Default
        public static function setDefault($default){
            self::$default = $default;
        }


        //Responsável por executar o próximo nível da fila de Middleware
        public function next($request){
            //Verifica se a fila está vazia
            if(empty($this->middlewares)) return call_user_func_array($this->controller, $this->controllerArgs);

            //Middleware
            $middleware = array_shift($this->middlewares);

            //Vericia o mapeamento
            if(!isset(self::$map[$middleware])){
                throw new \Exception("Problemas ao processar o middleware da requisição", 500);
            }

            //Next processo
            $queue = $this;
            $next = function($request) use ($queue){
                return $queue->next($request);
            };
            
            //Executa o Middleware
            return (new self::$map[$middleware])->handle($request,$next);

        }


    }


?>