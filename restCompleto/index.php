<?php
/*#indica que será utilizado o modo de reescrita das urls
RewriteEngine On

#regra de substituicao
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php?url=$1*/

function loader ($className)
{
    $osServer = 'linux';
    strtolower($osServer == 'linux' ? $className = str_replace('\\', '/', $className) : $className);

    if (file_exists(__DIR__."/$className.php")) {
        require_once __DIR__."/$className.php";
    }
}

function replaceStringUrl ($string)
{
	$str1 = array('-a','-b','-c','-d','-e','-f','-g','-h','-i','-j','-k','-l','-m','-n','-o','-p','-q','-r','-s','-t','-u','-v','-w','-x','-y','-z');
	$str2 = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
	return str_replace($str1, $str2, $string);
}

spl_autoload_register('loader');

if (isset($_GET['url'])) {
    $queryStrings = array_filter(explode('/', $_GET['url']));
    try {
        if (count($queryStrings) == 1) {
            $nameClass = 'Controller\\'.ucfirst(replaceStringUrl($queryStrings[0]));
            if (class_exists($nameClass)) {
                $class = new $nameClass;
                if (method_exists($class, 'view')) {
                    $class->view();
                } else {
                    throw new Exception('Error ao gerar view');
                }
            } else {
                throw new Exception("Classe \"$nameClass\" inexistente ou inválida.");
            }
        } elseif (count($queryStrings) >= 2) {
            $nameClass = 'Controller\\'.ucfirst(replaceStringUrl($queryStrings[0]));
            $nameMethod = replaceStringUrl($queryStrings[1]);
            if (class_exists($nameClass)) {
                $class = new $nameClass;
                if (method_exists($class, $nameMethod)) {
                    $class->$nameMethod();
                } else {
                    throw new Exception('Método inválido');
                }
            } else {
                throw new Exception("Classe \"$nameClass\" inválida.");
            }
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}