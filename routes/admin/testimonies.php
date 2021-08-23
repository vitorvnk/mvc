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