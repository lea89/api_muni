<?php
class Soapserver extends CI_Controller
{
     function index()
     {
          parent::__construct();
          $ns = 'http://gisdesa.mardelplata.gob.ar/opendata/ws.php/centros_de_salud';
          $this->load->library("Nusoap_library"); // load nusoap toolkit library in controller
          $this->nusoap_server = new soap_server();
          $this->nusoap_server->configureWSDL("SOAP Server Using NuSOAP in CodeIgniter", $ns); // wsdl cinfiguration
          $this->nusoap_server->wsdl->schemaTargetNamespace = $ns; // server namespace
		 
		  //registrando funciones
        $input_array = array ('token' => "xsd:string");
        $return_array = array ("return" => "xsd:string");
        $this->nusoap_server->register('centros_de_salud', $input_array, $return_array, "urn:SOAPServerWSDL", "urn:".$ns."/centros_de_salud", "rpc", "encoded");;
		 
		 
		  $this->nusoap_server->service(file_get_contents("php://input"));
		
 

     }
	
	
	
	
}
?>