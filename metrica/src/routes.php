<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes
$app->get('/', function (Request $request, Response $response, array $args) {
    // Sample log message
    //$this->logger->info("Slim-Skeleton '/' route");
	
    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});

$app->get('/empleado', function (Request $request, Response $response, array $args) {
    $json = file_get_contents(__DIR__ . '/../data/employees.json');
    $data = json_decode($json, true);
    $json_email = $request->getQueryParam('correo');
    //$json_nombre=$request->getQueryParam('nombre');
    ($json_email=='')?$valor = $data:$valor = [];

    if ($json_email!='') {
    	foreach ($data as $json_general) {
    		if (strpos($json_general['email'], $json_email) !== false) {
			    $valor[] = $json_general;
			  }
    	}
    }
    return $this->renderer->render($response, 'employees.phtml', array('empleado' => $valor,'correo' => $json_email));
});

$app->get('/salario', function ($request, $response, $args) {
	$json = file_get_contents(__DIR__ . '/../data/employees.json');
    $data = json_decode($json, true);
    $minimo = $request->getQueryParam('minimo');
    $maximo = $request->getQueryParam('maximo');

	($minimo=='' && $maximo=='')?$valor = $data:$valor = [];

    if ($minimo && $maximo) {
	    foreach ($data as $contenido) {
	    	$sueldo = str_replace(',', '', $contenido['salary']);
	    	$sueldo = str_replace('$', '', $sueldo);
	    	$sueldo = floatval($sueldo);
	    	if ($sueldo >= $minimo && $sueldo <= $maximo ) {
	    		$valor[] = $contenido;
	    	}
	    }
    }

	$doc = new DomDocument('1.0');
	$root = $doc->createElement('root');
	$root = $doc->appendChild($root);

	foreach ($valor as $elemento=>$data):

	    $occ = $doc->createElement('empleado');
	    $occ = $root->appendChild($occ);

	    foreach ($data as $key=>$informacion) :
	        $child = $doc->createElement($key);
	        $child = $occ->appendChild($child);
			if (is_array($informacion) || is_object($informacion)){
				foreach($informacion as $valor):
					$value = $doc->createElement('skill');
					$value = $child->appendChild($value);
					$values = $doc->createTextNode($valor['skill']);
			        $values = $value->appendChild($values);
				endforeach;
			}else{
				$value = $doc->createTextNode($informacion);
		        $value = $child->appendChild($value);
			}
	    endforeach;
	endforeach;
	$xml_string = $doc->saveXML() ;
	echo $xml_string;
});
