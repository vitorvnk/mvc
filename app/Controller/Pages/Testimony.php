<?php
    namespace App\Controller\Pages;
    use \App\Utils\View;
    use \App\Model\Entity\Testimony as EntityTestimony;

    class Testimony extends Page{
        //retorna o conteudo da tela de Depoimentos
        public static function getTestimonies(){
            //View da Depoimentos
            $content = View::render('pages/testimonies',[

            ]);

            //Retorna a View da página
            return parent::getPage('Depoimentos', $content);
        }

        //Metodo repsonável por cadastrar o depoimento
        public static function insertTestimony($request){
            //Dados do post
            $postVars = $request->getPostVars();

            //Nova instância de Depoimentos
            $obTestimony = new EntityTestimony;
            $obTestimony->nome = $postVars['nome'];
            $obTestimony->mensagem = $postVars['mensagem'];
            $obTestimony->cadastrar();

            return self::getTestimonies();
        }


    }

?>