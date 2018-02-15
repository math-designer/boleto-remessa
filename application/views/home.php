<div class="container">
    <div class="row">
        <div style="margin: 0 auto;">
            <?php if($this->session->flashdata('validation_errors')): ?>
                <div class="alert alert-danger">
                    <?= validation_errors() ?>
                </div>
            <?php endif; ?>
            
            <div class="well">
                <h2>Dados boleto</h2>
                <?= form_open('boleto/remessa')?>
                    <div class="form-group">
                        <?= form_label('Json', 'jsonDados')?>
                        <?= form_textarea(array('id'=>'jsonDados', 'name'=>'jsonDados', 'rows'=>'10', 'class'=>'form-control'), set_value('jsonDados')) ?>
                    </div>
                    <div class="form-group">
                        <?= form_submit('gerar', 'Gerar', array('class' => 'btn btn-primary'))?>
                    </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>