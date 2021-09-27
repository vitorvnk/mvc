<?php
    use \App\Http\Response;
    use \App\Controller\Admin;


    //Rota de listagem de Usuários
    $obRouter->get('/admin/users',[
        'middlewares' => [
            'required-admin-login'
        ],
        function($request){
            return new Response(200,Admin\User::getUsers($request));
        }
    ]);

    //Rota de Cadastro para o novo Usuário
    $obRouter->get('/admin/users/new',[
        'middlewares' => [
            'required-admin-login'
        ],
        function($request){
            return new Response(200,Admin\User::getNewUser($request));
        }
    ]);

    //Rota de Cadastro para o novo Usuário (post)
    $obRouter->post('/admin/users/new',[
        'middlewares' => [
            'required-admin-login'
        ],
        function($request){
            return new Response(200,Admin\User::setNewUser($request));
        }
    ]);

    //Rota de Edição de um Usuário
    $obRouter->get('/admin/users/{id}/edit',[
        'middlewares' => [
            'required-admin-login'
        ],
        function($request,$id){
            return new Response(200,Admin\User::getEditUser($request,$id));
        }
    ]);

    //Rota de Edição de um Usuário (post)
    $obRouter->post('/admin/users/{id}/edit',[
        'middlewares' => [
            'required-admin-login'
        ],
        function($request,$id){
            return new Response(200,Admin\User::setEditUser($request,$id));
        }
    ]);

    //Rota para a Exclusão de um Usuário
    $obRouter->get('/admin/users/{id}/delete',[
        'middlewares' => [
            'required-admin-login'
        ],
        function($request,$id){
            return new Response(200,Admin\User::getDeleteUser($request,$id));
        }
    ]);

    //Rota para a Exclusão de um Usuário (post)
    $obRouter->post('/admin/users/{id}/delete',[
        'middlewares' => [
            'required-admin-login'
        ],
        function($request,$id){
            return new Response(200,Admin\User::setDeleteUser($request,$id));
        }
    ]);

