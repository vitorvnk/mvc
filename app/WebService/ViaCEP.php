<?php
    namespace App\WebService;

    class ViaCep{
        //Responsável por consultar o CEP no ViaCep
        public static function consultarCEP($cep){
            // Inicia o CURL
            $curl = curl_init();

            // Configurações
            curl_setopt_array($curl,[
                CURLOPT_URL => 'https://viacep.com.br/ws/'.$cep.'/json/',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => 'GET'
            ]);
        
            //RESPONSE
            $response = curl_exec($curl);

            //Fecha a conexão
            curl_close($curl);

            //converte para array
            $array = json_decode($response, true);

            //Retorna
            return isset($array['cep']) ? $array : null;
        }
    }



?>