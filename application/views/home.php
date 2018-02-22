<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="well">
                <h4>Links úteis</h4>
                <ul class="list-group">
                    <a class="list-group-item" href="http://json.parser.online.fr/beta/" target="_blank">Json parser (validar estrutura json)</a>
                    <a class="list-group-item" href="<?=site_url('utilidades/estrutura-json-boleto')?>" target="_blank">Estutura json boleto</a>
                    <a class="list-group-item" href="<?=site_url('utilidades/boletos/boletos-gerados')?>">Boletos gerados</a>
                </ul>
            </div>
        </div>       
        <div class="col-md-7">
            <div class="well">
                <?php if(validation_errors()): ?>
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <?= validation_errors() ?>
                    </div>
                <?php endif; ?>
                <h3>Dados boleto</h3>
                <?= form_open(site_url('boleto/remessa'))?>
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