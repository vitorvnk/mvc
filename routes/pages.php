<?php
    use \App\Http\Response;
    use \App\Controller\Pages;

    //Rota da HOME
    $obRouter->get('/',[
        function(){
            return new Response(200, Pages\Home::getHome());
        }
    ]);
    //Rota do SOBRE
    $obRouter->get('/sobre',[
        function(){
            return new Response(200, Pages\About::getAbout());
        }
    ]);
    //Rota do DEPOIMENTOS
    $obRouter->get('/depoimentos',[
        function($request){
            return new Response(200, Pages\Testimony::getTestimonies($request));
        }
    ]);
    //Rota do DEPOIMENTOS (Insert)
    $obRouter->post('/depoimentos',[
        function($request){
            return new Response(200, Pages\Testimony::insertTestimony($request));
        }
    ]);

    //Rota diâmica
    $obRouter->get('/pagina/{idPagina}/{acao}',[
        function($idPagina, $acao){
            return new Response(200, 'Página'.$idPagina.' - '.$acao);
        }
    ]);
?>