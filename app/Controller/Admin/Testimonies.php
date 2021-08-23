<?php
    namespace App\Controller\Admin;
    use \App\Utils\View;

    class Testimonies extends Page{
        //Reponsável por renderizar a view de Listagem Depoimentos
        public static function getTestimonies($request) {
            //Conteudo da Home
            $content = View::render('admin/modules/home/index', []);

            //retorna a página completa
            return parent::getPanel('Depoimentos', $content,'testimonies');
        }

    }


?>