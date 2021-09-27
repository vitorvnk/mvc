<?php
    namespace App\Http;
    use \Closure;
    use \Exception;
    use \ReflectionFunction;
    use \App\Http\Middleware\Queue as MiddlewareQueue;

    class Router{
        //URL completa do projeto (Raiz)
        private $url = '';
        //Prefixo de todas as rotas
        private $prefix = '';
        //Indice de rotas
        private $routes = [];
        //instância de request
        private $request = '';
        //Content type padrão do response
        private $contentType = 'text/html';


        public function __construct($url){
            $this->request = new Request($this);
            $this->url = $url;
            $this->setPrefix();
        }
        private function setPrefix(){
            //Informações da URL atual
            $parseUrl = parse_url($this->url);

            //Define o Prefixo
            $this->prefix = $parseUrl ['path'] ?? '';
        }

        // Muda o contentType
        public function setContentType($contentType){
            $this->contentType = $contentType;
        }


        //Responsável por adicionar uma rota na classe
        private function addRoute($method,$route,$params=[]){
            //Validação dos parâmetros
            foreach($params as $key=>$value){
                if($value instanceof Closure){
                    $params['controller']= $value;
                    unset($params[$key]);
                    continue;
                }
            }

            //Middlewares da Rota
            $params['middlewares'] = $params['middlewares'] ?? [];

            //Variáveis da Rota
            $params['variables'] = [];

            //Padrão de validação das variáveis das rotas
            $patternVariables = '/{(.*?)}/';
            if(preg_match_all($patternVariables,$route,$matches)){
                $route = preg_replace($patternVariables,'(.*?)',$route);
                $params['variables'] = $matches[1];
            }



            //Padrão de validação da URL
            $patternRoute = '/^'.str_replace('/','\/',$route).'$/';

            //Adiciona a roda dentro da classes
            $this->routes[$patternRoute][$method] = $params;
        }

        //Metodo responsável por definir uma rota de GET
        public function get($route,$params=[]){
            return $this->addRoute('GET',$route,$params);
        }
        //Metodo responsável por definir uma rota de POST
        public function post($route,$params=[]){
            return $this->addRoute('POST',$route,$params);
        }
        //Metodo responsável por definir uma rota de PUT
        public function put($route,$params=[]){
            return $this->addRoute('PUT',$route,$params);
        }
        //Metodo responsável por definir uma rota de DELETE
        public function delete($route,$params=[]){
            return $this->addRoute('DELETE',$route,$params);
        }


        //Metodo responsável por Retornar a URI desconsiderando o Prefixo
        private function getUri(){
            //URI da Request
            $uri = $this->request->getUri();

            //Fatia a URI com o prefixo
            $xUri = strlen($this->prefix) ? explode($this->prefix, $uri) : [$uri];

            //retorna a URI sem o prefixo
            return rtrim(end($xUri), '/') == '' ? end($xUri) : rtrim(end($xUri), '/'); 

        }

        //método responsável por retornar os dados da rota atual
        private function getRoute(){
            //URI
            $uri = $this->getUri();
            
            //Metodo
            $httpMethod = $this->request->getHttpMethod();

            //Valida as rotas
            foreach ($this->routes as $patternRoute=>$methods){
                //Verifica se a Rota bate com o padrão
                if(preg_match($patternRoute,$uri,$matches)){
                    //Verifica o metodo
                    if(isset($methods[$httpMethod])){
                        //Remove a primeira posição
                        unset($matches[0]);

                        //Variáveis processadas 
                        $keys = $methods[$httpMethod]['variables'];
                        $methods[$httpMethod]['variables'] = array_combine($keys,$matches);
                        $methods[$httpMethod]['variables']['request'] = $this->request;

                        //Retorno dos parâmetros da rota
                        return $methods[$httpMethod];
                    } else {
                        throw new Exception("Método não permitido", 405);
                    }
                    
                }
            }
            throw new Exception("URL não encontrada", 404);
        }

        //Metodo responsável por executar a rota atual
        public function run(){
            try{
                //Obtem a rota atual
                $route = $this->getRoute();

                //Verifica o controlador
                if(!isset($route['controller'])){
                    throw new Exception("URL não pode ser processada", 500);
                }

                //Argumentos da função
                $args = [];

                //Reflection
                $reflection = new ReflectionFunction($route['controller']);
                foreach($reflection->getParameters() as $parameter) {
                    $name = $parameter->getName();
                    $args[$name] = $route['variables'][$name] ?? '';
                }

                //Retorna a Execução da fila de Middleware
                return (new MiddlewareQueue($route['middlewares'],$route['controller'],$args))->next($this->request);


            }catch(Exception $e){
                return new Response($e->getCode(),$this->getErrorMessage($e->getMessage()),$this->contentType);
            }
        }

        //Metodo responsável por retornar a mensagem de erro de acordo com o content type
        private function getErrorMessage($message){
            switch($this->contentType){
                case 'application/json':
                    return [
                        'error' => $message
                    ];
                    break;

                default:
                    return $message;
                    break;

            }
        }

        //Retorna a URL atual
        public function getCurrentUrl(){
            return $this->url.$this->getUri();
        }

        //Metodo responsável por redirecionar a URL
        public function redirect($route){
            //URL
            $url = $this->url.$route;

            //Executa o redirect
            header('location: '.$url);
            exit;
        }
    }   
?>