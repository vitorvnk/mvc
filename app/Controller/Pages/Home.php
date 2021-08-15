<?php
    namespace App\Controller\Pages;
    use \App\Utils\View;
    use \App\Model\Entity\Organization;

    class Home extends Page{
        //retorna o conteudo da Home
        public static function getHome(){
            //pega os dados da Organization
            $obOrganization = new Organization;



            //View da Home
            $content = View::render('pages/home',[
                'name'          => $obOrganization->name
                
            ]);

            //Retorna a View da página
            return parent::getPage('Home', $content);
        }


    }

?>