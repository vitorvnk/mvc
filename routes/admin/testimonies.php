<?php
    use \App\Http\Response;
    use \App\Controller\Admin;


    //Rota de listagem de Depoimentos
    $obRouter->get('/admin/testimonies',[
        'middlewares' => [
            'required-admin-login'
        ],
        function($request){
            return new Response(200,Admin\Testimonies::getTestimonies($request));
        }
    ]);

    //Rota de Cadastro para o novo depoimento
    $obRouter->get('/admin/testimonies/new',[
        'middlewares' => [
            'required-admin-login'
        ],
        function($request){
            return new Response(200,Admin\Testimonies::getNewTestimony($request));
        }
    ]);

    //Rota de Cadastro para o novo depoimento (post)
    $obRouter->post('/admin/testimonies/new',[
        'middlewares' => [
            'required-admin-login'
        ],
        function($request){
            return new Response(200,Admin\Testimonies::setNewTestimony($request));
        }
    ]);

    //Rota de Edição de um depoimento
    $obRouter->get('/admin/testimonies/{id}/edit',[
        'middlewares' => [
            'required-admin-login'
        ],
        function($request,$id){
            return new Response(200,Admin\Testimonies::getEditTestimony($request,$id));
        }
    ]);

    //Rota de Edição de um depoimento (post)
    $obRouter->post('/admin/testimonies/{id}/edit',[
        'middlewares' => [
            'required-admin-login'
        ],
        function($request,$id){
            return new Response(200,Admin\Testimonies::setEditTestimony($request,$id));
        }
    ]);

    //Rota para a Exclusão de um depoimento
    $obRouter->get('/admin/testimonies/{id}/delete',[
        'middlewares' => [
            'required-admin-login'
        ],
        function($request,$id){
            return new Response(200,Admin\Testimonies::getDeleteTestimony($request,$id));
        }
    ]);

    //Rota para a Exclusão de um depoimento (post)
    $obRouter->post('/admin/testimonies/{id}/delete',[
        'middlewares' => [
            'required-admin-login'
        ],
        function($request,$id){
            return new Response(200,Admin\Testimonies::setDeleteTestimony($request,$id));
        }
    ]);