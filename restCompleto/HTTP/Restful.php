<?php
namespace HTTP;

use Exception;

/**
 * Class Restful
 * Classe padrão para servidor Restful
 * @author James Miranda
 */
class Restful
{
    /**
     * Method server
     * Executa servidor restful, verificando o método e a URL
     * @param String $method Método da requisição, POST, GET, DELETE, PUT
     * @param String $url
     * @param callback $callback
     * @return bool
     */
    public function server ($method, $url, $callback)
    {
        try {
            $this->checkMethod($method);
            if (is_callable($callback)) {
                if (is_array($this->checkUrl($url))) {
                    call_user_func_array($callback, $this->checkUrl($url));
                } else {
                    call_user_func($callback, $this->checkUrl($url));
                }
            }
            $return = true;
        } catch (Exception $e) {
            //não é a melhor abordagem para tratamento de excessões
            echo ($e->getMessage());
            $return = false;
        }
        return $return;
    }

    /**
     * Method checkMethod
     * Valida o nome do método
     * @param String $method POST, GET, DELETE, PUT
     * @throws Exception
     */
    private function checkMethod ($method)
    {
        if ($_SERVER['REQUEST_METHOD'] != $method) {
            throw new Exception('O método usado é diferente do método declarado.');
        }
    }

    /**
     * Method checkUrl
     * Verifica url da requisição
     * @param String $url
     * @throws Exception
     * @return array
     */
    private function checkUrl ($url)
    {
        $url = array_filter(explode('/', $url));
        $queryString = array_filter(explode('/', $_GET['url']));
        $vars = array();

        if (count($url) != count($queryString)) {
            throw new Exception('The request URL is invalid.');
        }

        foreach ($url as $key  => $val) {
            if (preg_match('/^:/', $val)) {
                $val = $queryString[$key];
                array_push($vars, $queryString[$key]);
            }

            if ($queryString[$key] != $val) {
                throw new Exception('The request URL is invalid.');
            }
        }
        return $vars;
    }

}