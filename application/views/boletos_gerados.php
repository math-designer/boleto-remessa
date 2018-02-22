<div class="container">
	<div class="row">
		<div class="col-md-12">
			<a href="<?=base_url('home')?>" class="btn btn-primary pull-left">Voltar</a>
			<a href="<?=base_url('utilidades/boletos/apagar-tudo')?>" class="btn btn-danger pull-right">Apagar tudo</a>
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Nome</th>
						<th>Data Criação</th>
						<th>#</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($arquivos as $arquivo):?>
						<tr>
							<td><?= $arquivo['nome']?></td>
							<td><?= $arquivo['data']?></td>
							<td>
								<a href="<?=base_url('utilidades/boletos/baixar/'.$arquivo['nome_link'])?>" class="btn btn-primary btn-sm">Baixar</a>
								<a href="<?=base_url('utilidades/boletos/apagar/'.$arquivo['nome_link'])?>" class="btn btn-danger btn-sm">Apagar</a>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>