<?php
    namespace App\Http\Middleware;

    class Maintenance{
        //Responsável por executar a middleware
        public function handle($request, $next) {

            //Verifica o estado de manuteção da página
            if(getenv('MAINTENANCE') == 'true'){
                throw new \Exception("PÁGINA EM MANUTENÇÃO!",200);
            }

            //Executa o próximo nível do middleware
            return $next($request);




        }
    }

?>