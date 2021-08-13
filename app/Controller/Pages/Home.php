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
                'name'          => $obOrganization->name,
                'site'          => $obOrganization->site,
                'description'   => $obOrganization->description
                
            ]);

            //Retorna a View da página
            return parent::getPage('Tela inicial', $content);
        }


    }

?>