<?php

class Centros_model extends CI_Model
{

   function traerTodosCentros()
   {
   		return $this->db->get('centros')->result();
   }
	
	function editarCentro($centro,$id)
	{
		return $this->db->where('codigo',$id)->update('centros',$centro);
	}
	
	function traerCentros()
   {
   		return $this->db->get('centros')->result();
   }
	
	function insertarCentro($centro)
   	{
   		$this->db->insert('centros',$centro);
		return $this->db->insert_id();
   	}
   
}

?>