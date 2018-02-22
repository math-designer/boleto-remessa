<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Carbon\Carbon;

class Utils extends CI_Controller {
	
	const BOLETOSPATH = APPPATH.'/storage/boletos/';

	public function estutura_boleto()
	{
		$arquivo = read_file(APPPATH.'/storage/estrutura-json-boleto.json');
		header('Content-Type: application/json');
		echo $arquivo;
	}

	//Listagem dos arquivos
	public function boletos_gerados()
	{
		$arquivos_dir = get_filenames(self::BOLETOSPATH);
		$arquivos = array();
		foreach ($arquivos_dir as $arquivo) {
			$meta_data = stat(self::BOLETOSPATH.$arquivo);
			
			$arquivos[] = array(
				'nome' => $arquivo, 
				'data' => Carbon::createFromTimestamp($meta_data['mtime'])->format('d/m/Y H:i:s'),
				'nome_link' => base64_encode($arquivo)
			);
			
		}

		$this->load->view('layout/header');
		$this->load->view('boletos_gerados', compact('arquivos'));
		$this->load->view('layout/footer');
	}

	public function baixar_arquivo($nome)
	{
		$this->load->helper('download');
		force_download(self::BOLETOSPATH.base64_decode($nome), NULL);
	}

	public function limpar_diretorio_boletos()
	{
		delete_files(self::BOLETOSPATH);
		redirect(base_url('utilidades/boletos/boletos-gerados'));
	}

	public function apagar_arquivo($nome)
	{
		unlink(self::BOLETOSPATH.base64_decode($nome));
		redirect(base_url('utilidades/boletos/boletos-gerados'));
	}
}