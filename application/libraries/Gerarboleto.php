<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use OpenBoleto\Banco\Itau;
use OpenBoleto\Agente;

class Gerarboleto
{
    public function gerar($cedente, $sacado, $boleto)
    {
        $_cedente = new Agente(
            $cedente->nome,
            $cedente->documento,
            $cedente->endereco->logradouro,
            $cedente->endereco->cep,
            $cedente->endereco->cidade,
            $cedente->endereco->uf
        );


        $_sacado = new Agente(
            $sacado->nome,
            $sacado->documento,
            $sacado->endereco->logradouro,
            $sacado->endereco->cep,
            $sacado->endereco->cidade,
            $sacado->endereco->uf
        );

        $_boleto = [
            // Parâmetros obrigatórios
            'dataVencimento' => \DateTime::createFromFormat('d/m/Y', $boleto->dataVencimento),
            'valor' => $boleto->valor,
            'sequencial' => $boleto->sequencial, // 8 dígitos
            'sacado' => $_sacado,
            'cedente' => $_cedente,
            'agencia' => $boleto->agencia, // 4 dígitos
            'carteira' => $boleto->carteira, // 3 dígitos
            'conta' => $boleto->conta, // 5 dígitos

            // Parâmetro obrigatório somente se a carteira for
            // 107, 122, 142, 143, 196 ou 198
            'codigoCliente' => $boleto->codigoCliente, // 5 dígitos
            'numeroDocumento' => $boleto->numeroDocumento, // 7 dígitos

            // Parâmetros recomendáveis
            'contaDv' => $boleto->contaDv,
            'agenciaDv' => $boleto->agenciaDv,
            'descricaoDemonstrativo' => [], // Até 5
            'instrucoes' => [], // Até 8

            // Parâmetros opcionais
            'moeda' => Itau::MOEDA_REAL,
            'dataDocumento' => new \DateTime(),
            'dataProcessamento' => new \DateTime(),
            //'contraApresentacao' => true,
            //'pagamentoMinimo' => 23.00,
            'aceite' => $boleto->aceite,
            //'especieDoc' => 'ABC',
            //'usoBanco' => 'Uso banco',
            //'layout' => 'layout.phtml',
            //'logoPath' => 'http://boletophp.com.br/img/opensource-55x48-t.png',
            //'sacadorAvalista' => new Agente('Antônio da Silva', '02.123.123/0001-11'),
            //'descontosAbatimentos' => 123.12,
            //'moraMulta' => 123.12,
            //'outrasDeducoes' => 123.12,
            //'outrosAcrescimos' => 123.12,
            //'valorCobrado' => 123.12,
            //'valorUnitario' => 123.12,
            //'quantidade' => 1,
        ];

        foreach ($boleto->descricaoDemonstrativo as $key => $value) {
            $value = (array)$value;
            $k = array_keys($value)[0];
            $_boleto['descricaoDemonstrativo'][] = $value[$k];
        }

        foreach ($boleto->instrucoes as $key => $value) {
            $value = (array)$value;
            $k = array_keys($value)[0];
            $_boleto['instrucoes'][] = $value[$k];
        }

        return new Itau($_boleto);
    }

}