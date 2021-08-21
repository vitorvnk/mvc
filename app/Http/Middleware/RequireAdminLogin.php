<?php
    namespace App\Http\Middleware;
    use \App\Session\Admin\Login as SessionAdminLogin;

    class RequireAdminLogin{
        //Responsável por executar a middleware
        public function handle($request, $next){
            //Verifica se o usuário está logado
            if(!SessionAdminLogin::isLogged()){
                $request->getRouter()->redirect('/admin/login');
            }
            //Continua a Execução
            return $next($request);
        }
    }

?>