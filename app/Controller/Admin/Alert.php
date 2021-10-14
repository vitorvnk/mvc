<?php
    namespace App\Controller\Admin;
    use \App\Utils\View;

    class Alert{
        //Metodo responsável por retornar uma mensagem de sucesso
        public static function getSucess($message,$url) {
            return View::render('admin/alert/status',[
                'tipo' => 'success',
                'mensagem' => $message,
                'LINK_ATUAL' => $url
            ]);
        }
        //Metodo responsável por retornar uma mensagem de erro
        public static function getError($message,$url) {
            return View::render('admin/alert/status',[
                'tipo' => 'danger',
                'mensagem' => $message,
                'LINK_ATUAL' => $url
            ]);
        }
    }

?>