<div class="container">
    <div class="row">
        <?php if($this->session->flashdata('validation_errors')): ?>
            <div class="alert alert-danger">
                <?= validation_errors() ?>
            </div>
        <?php endif; ?>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="well">
                <h3>Links úteis</h3>
                <ul class="list-group">
                    <a class="list-group-item" href="http://json.parser.online.fr/beta/" target="_blank">Json parser (validar estrutura json)</a>
                    <a class="list-group-item" href="<?=base_url('utilidades/estrutura-json-boleto')?>" target="_blank">Estutura json boleto</a>
                </ul>
            </div>
        </div>       
        <div class="col-md-7">
            <div class="well">
                <h3>Dados boleto</h3>
                <?= form_open('boleto/remessa')?>
                    <div class="form-group">
                        <?= form_label('Json', 'jsonDados')?>
                        <?= form_textarea(array('id'=>'jsonDados', 'name'=>'jsonDados', 'rows'=>'16', 'class'=>'form-control', 'style' => 'resize:vertical')) ?>
                    </div>
                    <div class="form-group">
                        <?= form_submit('gerar', 'Gerar', array('class' => 'btn btn-primary'))?>
                    </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>    
</div>