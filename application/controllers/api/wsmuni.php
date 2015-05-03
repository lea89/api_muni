<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Example
 *
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array.
 *
 * @package		CodeIgniter
 * @subpackage	Rest Server
 * @category	Controller
 * @author		Phil Sturgeon
 * @link		http://philsturgeon.co.uk/code/
*/

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH.'/libraries/REST_Controller.php';

class Wsmuni extends REST_Controller
{
	function __construct()
    {
        // Construct our parent class
        parent::__construct();
        
        // Configure limits on our controller methods. Ensure
        // you have created the 'limits' table and enabled 'limits'
        // within application/config/rest.php
        $this->methods['user_get']['limit'] = 500; //500 requests per hour per user/key
        $this->methods['user_post']['limit'] = 100; //100 requests per hour per user/key
        $this->methods['user_delete']['limit'] = 50; //50 requests per hour per user/key
    }

	function centros_get()
	{
		$this->load->library('Nusoap_library');
		$this->load->model('Centros_model');
		
		$cliente = new nusoap_client("http://gisdesa.mardelplata.gob.ar/opendata/ws.php/");
		
		$params = array('token' => "wwfe345gQ3ed5T67g4Dase45F6fer");
		
		$result = $cliente->call("centros_de_salud",$params);
		
		foreach($result as $centro)
		{
			$oCentro = array();
			$oCentro['codigo'] = $centro['codigo'];
		 	$oCentro['descripcion'] = $centro['descripcion'];
			$oCentro['ubicacion'] = $centro['ubicacion'];
			$oCentro['latitud'] = $centro['latitud'];
			$oCentro['longitud'] = $centro['longitud'];
			
			
			if($this->Centros_model->traerTodosCentros() > 0)
			{
				$this->Centros_model->editarCentro($oCentro,$centro['codigo']);
			}
			else
			{
				$oCentro['telefono'] = "";
				$oCentro['direccion'] = "";
				$oCentro['email'] = "";
				$oCentro['colectivos'] = "";
				$this->Centros_model->insertarCentro($oCentro);
			}
		}
		
		$centros = $this->Centros_model->traerCentros();
		$lista = array();
		for($i = 0; $i < count($centros);$i++)
				{
					$centro[$i] = array("codigo"=>$centros[$i]->codigo,"ubicacion"=>$centros[$i]->ubicacion,"descripcion"=>$centros[$i]->descripcion,"latitud"=>$centros[$i]->latitud,"longitud"=>$centros[$i]->longitud,"direccion"=>$centros[$i]->direccion,"email"=>$centros[$i]->email,"colectivos"=>$centros[$i]->colectivos,"telefono"=>$centros[$i]->telefono);
					$lista[$i] = $centro;
				}
		
			
		//$lista = array("centros"=>$centro);
		
		if(count($lista) > 0)
		{
			$this->response($centros, 200);
			echo count($lista);
		}
	}
    
   
}