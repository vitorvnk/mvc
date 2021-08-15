<?php
    require __DIR__ . '/includes/app.php';
    use \App\Http\Router;

    //Inicia o Router
    $obRouter = new Router(URL);

    //Inclui as rotas de páginas
    include __DIR__.'/routes/pages.php';

    //imprimir o Response da rota
    $obRouter->run()->sendResponse();

?>
