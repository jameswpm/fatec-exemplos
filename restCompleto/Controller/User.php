<?php
namespace Controller;

use HTTP\Restful;

/**
 * Classe Controller - User
 * @author James Miranda
 */
class User
{

	/**
     * Method get
     * Obtém um usuário
     */
    public function get ()
    {    
    	$rest = new Restful();
    	$rest->server('GET', 'user/get', function () {
    		echo "ok";
    	});
    }
}