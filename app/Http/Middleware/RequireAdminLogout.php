<?php
    namespace App\Http\Middleware;
    use \App\Session\Admin\Login as SessionAdminLogin;

    class RequireAdminLogout{
        //Responsável por executar a middleware
        public function handle($request, $next){
            //Verifica se o usuário está logado
            if(SessionAdminLogin::isLogged()){
                $request->getRouter()->redirect('/admin');
            }
            //Continua a Execução
            return $next($request);
        }
    }

?>