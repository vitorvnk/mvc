<?php
    namespace App\Controller\Admin;
    use \App\Utils\View;

    class Page{
        //Retorna o conteudo (View) da estrutura genética de página do painel de controle
        public static function getPage($title, $content) {
            return View::render('admin/page',[
                'title' => $title,
                'content' => $content
            ]);
        }
    }

?>