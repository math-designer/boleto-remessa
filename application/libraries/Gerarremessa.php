<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Cnab\Banco;
use Cnab\Especie;
use Cnab\Remessa\Cnab400\Arquivo;

class GerarRemessa
{
    public function gerar($cedente, $sacado, $boleto)
    {
        $arquivo = new Arquivo(Banco::ITAU);
        $arquivo->configure([
            'data_geracao' => new \DateTime(),
            'data_gravacao' => new \DateTime(),
            'nome_fantasia' => $cedente->nome, // seu nome de empresa
            'razao_social' => $cedente->nome,  // sua razão social
            'cnpj' => $cedente->documento, // seu cnpj completo
            'banco' => Banco::ITAU, //código do banco
            'logradouro' => $cedente->endereco->logradouro,
            'numero' => $cedente->endereco->numero,
            'bairro' => $cedente->endereco->bairro,
            'cidade' => $cedente->endereco->cidade,
            'uf' => $cedente->endereco->uf,
            'cep' => $cedente->endereco->cep,
            'agencia' => $boleto->agencia,
            'conta' => $boleto->conta,
            'conta_dac' => $boleto->contaDv, // digito da conta
        ]);


        $_boleto = [
            'codigo_de_ocorrencia' => 1, // 1 = Entrada de título, futuramente poderemos ter uma constante
            'nosso_numero' => $boleto->sequencial,
            'numero_documento' => $boleto->numeroDocumento,
            'carteira' => $boleto->carteira,
            'especie' => Especie::ITAU_CONTRATO_DE_PRESTACAO_DE_SERVICOS, // Você pode consultar as especies Cnab\Especie
            'valor' => $boleto->valor, // Valor do boleto
            'instrucao1' => "05", // 1 = Protestar com (Prazo) dias, 2 = Devolver após (Prazo) dias, futuramente poderemos ter uma constante
            'instrucao2' => "00", // preenchido com zeros
            'sacado_logradouro' => $sacado->endereco->logradouro,
            'sacado_bairro' => $sacado->endereco->bairro,
            'sacado_cep' => $sacado->endereco->cep, // sem hífem
            'sacado_cidade' => $sacado->endereco->cidade,
            'sacado_uf' => $sacado->endereco->uf,
            'data_vencimento' => \DateTime::createFromFormat('d/m/Y', $boleto->dataVencimento),
            'data_cadastro' => \DateTime::createFromFormat('d/m/Y', $boleto->dataCadastro),
            'juros_de_um_dia' => 0.10, // Valor do juros de 1 dia'
            'data_desconto' => \DateTime::createFromFormat('d/m/Y', $boleto->dataDesconto),
            'valor_desconto' => 0, // Valor do desconto
            'prazo' => 10, // prazo de dias para o cliente pagar após o vencimento
            'taxa_de_permanencia' => '0', //00 = Acata Comissão por Dia (recomendável), 51 Acata Condições de Cadastramento na CAIXA
            'mensagem' => 'Descrição do boleto',
            'data_multa' => \DateTime::createFromFormat('d/m/Y', $boleto->dataMulta), // data da multa
            'valor_multa' => 0, // valor da multa
        ];

        if($boleto->tipoInscricao == 1) {
            $dadosSacado = [
                'sacado_nome' => $sacado->nome, // O Sacado é o cliente, preste atenção nos campos abaixo
                'sacado_tipo' => 'cpf',
                'sacado_cpf' => $sacado->documento
            ];
        } else {
            $dadosSacado = [
                'sacado_razao_social' => $sacado->nome, // O Sacado é o cliente, preste atenção nos campos abaixo
                'sacado_tipo' => 'cnpj',
                'sacado_cnpj' => $sacado->documento
            ];
        }

        $_boleto = array_merge($_boleto, $dadosSacado);

        $arquivo->insertDetalhe($_boleto);


        return $arquivo;
    }
}