<?php
 
$method = $_SERVER['REQUEST_METHOD'];//recupera o método que foi usado para o envio da requisição

$request = explode('/', trim($_SERVER['PATH_INFO'],'/'));

$input = json_decode(file_get_contents('php://input'),true);//php://input é uma maneira de recuperar tudo que foi enviado para o script PHP
$table = $request[0];
$column = $request[1];

 
// conectar com mysql
$db = mysqli_connect('localhost', 'root', 'toor', 'teste');
mysqli_set_charset($db,'utf8');

//tratar a informação aqui//
 
// Analisa o método HTTP enviado
switch ($method) {
  case 'GET':
    $sql = "select * from `$table` WHERE id=$column"; 
	break;
  case 'PUT':
    //$sql = "update `$table` set $set where id=$column"; 
  	//break;
  case 'POST':
    //$sql = "insert into `$table` set $set"; 
  	//break;
  case 'DELETE':
    //$sql = "delete `$table` where id=$column"; 
  	//break;
}
 
// excecute SQL statement
$result = mysqli_query($db,$sql);
 
// verifica se trouxe resultados
if (!$result) {
  http_response_code(404);
  die(mysqli_error($db));
}
 
if ($method == 'GET') {
  if (!$column) {
 	 echo '[';
  }

  for ($i=0 ; $i < mysqli_num_rows($result); $i++) {
    echo ($i >0 ? ',' : '').json_encode(mysqli_fetch_object($result));
  }

  if (!$column) {
  	 echo ']';
  }

} elseif ($method == 'POST') {

  echo mysqli_insert_id($db);
} else {

  echo mysqli_affected_rows($db);
}
 
// fechar a conexão
mysqli_close($db);