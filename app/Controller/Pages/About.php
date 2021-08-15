<?php
    namespace App\Controller\Pages;
    use \App\Utils\View;
    use \App\Model\Entity\Organization;

    class About extends Page{
        //retorna o conteudo do Sobre
        public static function getAbout(){
            //pega os dados da Organization
            $obOrganization = new Organization;



            //View do Sobre
            $content = View::render('pages/About',[
                'name'          => $obOrganization->name,
                'site'          => $obOrganization->site,
                'description'   => $obOrganization->description
                
            ]);

            //Retorna a View da página
            return parent::getPage('Sobre', $content);
        }


    }

?>