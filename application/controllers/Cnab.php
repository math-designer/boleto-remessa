<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use JansenFelipe\Utils\Utils as Utils;

class Cnab extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('zip');
		$this->load->library('gerarboleto', '', 'boleto_l');
		$this->load->library('gerarremessa', '', 'remessa_l');
		$this->load->library('html2pdf', '', 'html2pdf_l');
	}

	private function render_form()
	{
		$this->load->view('layout/header');
		$this->load->view('home');
		$this->load->view('layout/footer');
	}

	public function index()
	{
		$this->render_form();
	}


	public function validar_json($json)
	{
		if(is_null(json_decode($json))) {
			$this->form_validation->set_message('validar_json', 'O campo "{field}" deve conter um formato válido');
			return FALSE;
		}
		
		return TRUE;
	}

	public function gerar()
	{
		if($this->input->method() == 'get') {
			redirect(base_url('home'));
		}

		$this->form_validation->set_rules('jsonDados', 'Json', 'callback_validar_json');
		$dados = json_decode($this->input->post('jsonDados'));
		
		if($this->form_validation->run() == FALSE) {
			$this->render_form();
		} else {
			$this->gerar_boleto_remessa($dados);
		}
	}
	
	private function gerar_boleto_remessa($dados)
	{
		$cedente = $dados->cedente;
        $boletos = $dados->boletos;

        $boletosRemessas = [];
        foreach ($boletos as $key => $b) {
            $boletosRemessas[$key]['boleto'] = $this->boleto_l->gerar($cedente, $b->sacado, $b->boleto);
            $boletosRemessas[$key]['remessa'] = $this->remessa_l->gerar($cedente, $b->sacado, $b->boleto);
        }
        
        $this->criar_zip($boletosRemessas);
	}
	
	private function criar_zip($arquivos)
	{
		foreach ($arquivos as $key => $value) {
			$id = time();
			$sacado = trim(str_replace(' ', '_', strtolower($value['boleto']->getSacado()->getNome())));
            $boleto = array(
            	'nome' => "{$id}_boleto_{$sacado}.pdf",
            	'arquivo' => $this->html2pdf_l->criar($value['boleto']->getOutput())
            );
            $remessa = array(
            	'nome' => "{$id}_remessa_{$sacado}.txt",
            	'arquivo' => $value['remessa']->getText()
            );

            $this->zip->add_data($boleto['nome'], $boleto['arquivo']);
            $this->zip->add_data($remessa['nome'], $remessa['arquivo']);

            $this->salvar_arquivo($boleto['nome'], $boleto['arquivo']);
            $this->salvar_arquivo($remessa['nome'], $remessa['arquivo']);
		}
		
		$this->zip->download("boletos-softvision.zip");
	}

	private function salvar_arquivo($nome, $arquivo)
	{
		write_file(APPPATH . '/storage/boletos/' . $nome, $arquivo);
	}
}
