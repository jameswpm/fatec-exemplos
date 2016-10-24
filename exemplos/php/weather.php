<?php
/**
* Classe de exemplo de uso do WebService usando REST
* Classe apenas de exemplo para mini-curso sobre APIs
* @author James Miranda 
*/
class GetWeatherWS
{
    private $clientURL;
    public $result;
        
    public $error = '';              


    /**
    * Busca pelo serviço de temperatura
    * @access public
    */
    public function getInfo($cityName, $apiKey)
    {        

        try{
            $this->clientURL = 'api.openweathermap.org/data/2.5/forecast/weather?q=' . $cityName . '&APPID=' . $apiKey;
            
            $curl = curl_init($this->clientURL);
            
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $this->result = curl_exec($curl);
            curl_close($curl);

            return $this->result;

        } catch( Exception $e ) {

            $this->erro = 'Erro encontrado: ' . $e->getMessage();

        }
    }
}

$cityName = $_POST['city'];
$key = $_POST['apikey'];
$currency = new GetWeatherWS();
echo '<pre>';
echo ($currency->getInfo($cityName, $key));
?>