<?php
/**
* Classe de exemplo Requisição REST enviando requisição POST
* Classe apenas de exemplo para mini-curso sobre APIs - NÃO FUNCIONAL
* @author James Miranda 
*/
class CurlPost
{
    /**
    * Exemplo de requisição POST. Não funcional, serve apenas de exemplo
    * @access public
    */
    public function getInfo()
    {        

        try{
        	
        	$post = array(
		        item1 => 'value',
		        item2 => 'value2',
		        item3 => 'value3'
		    );
			$ch = curl_init();
			//opções para enviar POST
			curl_setopt($ch, CURLOPT_URL, 'http://testcURL.com');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);			
			
			$resp = curl_exec($ch);
			
			curl_close($ch);

        } catch( Exception $e ) {

            print_r ('Erro encontrado: ' . $e->getMessage());

        }
    }
}
?>