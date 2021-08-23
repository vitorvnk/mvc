<?php
    namespace App\Controller\Admin;
    use \App\Utils\View;

    class Home extends Page{
        //Reponsável por renderizar a view do Home do painel
        public static function getHome($request) {
            //Conteudo da Home
            $content = View::render('admin/modules/home/index', []);

            //retorna a página completa
            return parent::getPanel('Home', $content,'home');
        }

    }


?>