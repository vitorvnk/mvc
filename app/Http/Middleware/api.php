<?php
    namespace App\Http\Middleware;

    class Api{
        //Responsável por executar a middleware
        public function handle($request, $next) {
            //Altera o contentType para Json
            $request->getRouter()->setContentType('application/json');

            //Executa o próximo nível do middleware
            return $next($request);




        }
    }

?>