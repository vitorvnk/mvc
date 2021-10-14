<?php
    use \App\Http\Response;
    use \App\Controller\Admin;

    //Rota de Login
    $obRouter->get('/admin/login',[
        'middlewares' => [
            'required-admin-logout'
        ],
        function($request){
            return new Response(200, Admin\Login::getLogin($request));
        }
    ]);

    //Rota de Login(post)
    $obRouter->post('/admin/login',[
        'middlewares' => [
            'required-admin-logout'
        ],
        function($request){
            return new Response(200, Admin\Login::setLogin($request));
        }
    ]);

    //Rota de Logout
    $obRouter->get('/admin/logout',[
        'middlewares' => [
            'required-admin-login'
        ],
        function($request){
            return new Response(200, Admin\Login::setLogout($request));
        }
    ]);

    //Rota de Cadastro de um novo Usuário - Area Deslogada 
    $obRouter->get('/admin/registro',[
        function($request){
            return new Response(200,Admin\Registro::getNewUser($request));
        }
    ]);

    //Rota de Cadastro de um novo Usuário - Area Deslogada (post)
    $obRouter->post('/admin/registro',[
        function($request){
            return new Response(200,Admin\Registro::setNewUser($request));
        }
    ]);

    //Rota para Esquecimento de Senha - Area Deslogada
    $obRouter->get('/admin/recovery',[
        function($request){
            return new Response(200,'Página em Construção!');
        }
    ]);

    //Rota de Cadastro de um novo Usuário - Area Deslogada (post)
    $obRouter->post('/admin/recovery',[
        function($request){
            return new Response(200,'');
        }
    ]);
