
				<div class="table-responsive">
				<?php if($lista){ ?>
				  <table id="tablaCronos" class="table table-bordered table-striped tablaCronos">
				    <thead>
				      <tr>
				        <th width="5%">N</th>
				        <th width="10%">CAE</th>
				        <th width="10%">Sector</th>
				        <th width="65%">Estación</th>
				        <th width="5%">Fecha</th>
				        <th width="5%"></th>
				      </tr>
				    </thead>
				    <tbody>
				    <?php $i=1; ?>
				    <?php foreach ($lista as $lt) { ?>
				      <tr>
				        <td><?php echo $i; $i++; ?></td>
				        <td><?php echo $lt->nombreCae; ?></td>
				        <td><?php echo $lt->nombreSector; ?></td>
				        <td><?php echo $lt->nombreEstacion; ?></td>
				        <td><?php echo $lt->fechaParte; ?></td>
				        <td>
				        	<button type="button" class="btn btn-success" data-idparte="<?php echo $lt->idParte; ?>" id="btnAutorizarParte" onclick="autorizarParte(this)" <?php echo $auth; ?>><i class="fa fa-user"></i> Autorizar</button>
				        </td>
				      </tr>
				    <?php } ?>            
				    </tbody>
				    <tfoot>
				      <tr>
				        <th>N</th>
				        <th>Nombre</th>
				        <th>Sector</th>
				        <th>Estación</th>
				        <th>Fecha</th>
				        <th></th>
				      </tr>
				    </tfoot>
				  </table>
				<?php }else{ ?>
				  <div class="alert alert-danger">
				    <b>No se encontraton datos</b>
				  </div>
				<?php } ?>

				</div>


<script type="text/javascript" src="<?php echo site_url('assets/plugins/owner/js/datatables.js'); ?>"></script>    