<?php
    namespace App\Controller\Admin;
    use \App\Utils\View;

    class Alert{
        //Metodo responsável por retornar uma mensagem de sucesso
        public static function getSucess($message) {
            return View::render('admin/alert/status',[
                'tipo' => 'success',
                'mensagem' => $message
            ]);
        }
        //Metodo responsável por retornar uma mensagem de erro
        public static function getError($message) {
            return View::render('admin/alert/status',[
                'tipo' => 'danger',
                'mensagem' => $message
            ]);
        }
    }

?>