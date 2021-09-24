<?php
    require __DIR__ . '/includes/app.php';
    use \App\Http\Router;

    //Inicia o Router
    $obRouter = new Router(URL);

    //Inclui as rotas de páginas
    include __DIR__.'/routes/pages.php';

    //Inclui as rotas do Painel
    include __DIR__.'/routes/admin.php';

    //Inclui as rotas API
    include __DIR__.'/routes/api.php';

    //imprimir o Response da rota
    $obRouter->run()->sendResponse();

?>
