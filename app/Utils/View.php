<?php
    namespace App\Utils;
    class View{
        private static $vars=[];

        //Metodo resonsável por definitir os dados iniciais da classe
        public static function init($vars = []){
            self::$vars = $vars;
        }


        //Retorna o conteudo de uma view
        private static function getContentView($view){
            $file = __DIR__.'/../../resources/view/'.$view.'.html';
            return file_exists($file) ? file_get_contents($file) : '';
        }


        //Retorna o conteudo renderizado de uma view
        public static function render($view, $vars=[]){
            //conteudo da View
            $contentView = self::getContentView($view);

            //Merge de variáveis da View
            $vars = array_merge(self::$vars, $vars);


            //Chaves do Array de Variáveis
            $keys = array_keys($vars);
            $keys = array_map(function($item){
                return '{{'.$item.'}}';
            }, $keys);


            //Retorna o conteudo já renderizado
            return str_replace($keys, array_values($vars), $contentView);
        }
    }
?>