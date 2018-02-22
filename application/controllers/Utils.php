<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Utils extends CI_Controller {
	
	public function estutura_boleto()
	{
		$arquivo = read_file(APPPATH.'/storage/estrutura-json-boleto.json');
		header('Content-Type: application/json');
		echo $arquivo;
	}
}