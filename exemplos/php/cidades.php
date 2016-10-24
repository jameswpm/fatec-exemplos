<?php
/**
* Classe de exemplo de uso do WebService usando SOAP
* Classe apenas de exemplo para mini-curso sobre APIs
* @author James Miranda 
*/
class GetCitiesWS
{
    const WSDL = 'http://www.webservicex.com/globalweather.asmx?wsdl';

    private $soap;
    private $functions;
    private $result;
    private $lastRequest;
        
    public $error = '';              

    /**
    * Inicializa o serviço SOAP e retorna as cidades para o país recebido
    * @access public
    */
    public function getInfo($countryName)
    {        

        try{
            $this->soap = new SoapClient('http://www.webservicex.com/globalweather.asmx?wsdl', array("trace" => 1, "exception" => 0));//trace é um parametro que permite recuperar a requisição

            $this->functions = $this->soap->__getFunctions();

            $soapArgs = array(
                'CountryName'  => $countryName
            );

            $this->result = $this->soap->GetCitiesByCountry($soapArgs);
            $this->lastRequest = $this->soap->__getLastRequest();
            return $this->result;    

        } catch( Exception $e ) {

            $this->erro = 'Erro encontrado: ' . $e->getMessage();

        }
    }
}

$countryName = $_POST['country'];
$currency = new GetCitiesWS();
echo '<pre>';
echo ($currency->getInfo($countryName)->GetCitiesByCountryResult);
?>