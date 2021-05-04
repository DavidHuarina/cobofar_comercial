<?php 
require "../conexionmysqli.inc";
require "configModule.php";
?>
<div class="content">
	<div class="container-fluid">
		<div class="col-md-12">
			<div class="card">
			  	<div class="card-header card-success card-header-text">
					<div class="card-text">
				  		<h4 class="card-title">Reportes Productos</h4>
					</div>
			  	</div>

			  	<div class="card-body ">
					<div class="row">				  	
				  		<div class="col-sm-4">
							<div class="form-group">
								<a href="<?=$urlRepoCodBarras?>" target="_blank" class="btn btn-success"> Productos sin Codigo Barras</a>
							</div>
				  		</div>
				  		<div class="col-sm-4">
							<div class="form-group">
								<a href="<?=$urlProductosVencer?>" target="_blank" class="btn btn-primary"> Productos Vencer</a>
							</div>
				  		</div>
				  		<div class="col-sm-4">
							<div class="form-group">
								<a href="<?=$urlVentasVsSaldos?>" target="_blank" class="btn btn-warning"> Ventas Vs Saldos</a>
							</div>
				  		</div>
				  		<div class="col-sm-4">
							<div class="form-group">
								<a href="<?=$urlVentasVsSaldosMes?>" target="_blank" class="btn btn-warning"> Ventas Vs Saldos Mes</a>
							</div>
				  		</div>
				  		<div class="col-sm-4">
							<div class="form-group">
								<a href="<?=$urlVentasVsSaldosDia?>" target="_blank" class="btn btn-warning"> Ventas Vs Saldos Dia</a>
							</div>
				  		</div>
				  		<div class="col-sm-4">
							<div class="form-group">
								<a href="<?=$urlInventario?>" target="_blank" class="btn btn-info"> Inventario Productos</a>
							</div>
				  		</div>
				  		<div class="col-sm-4">
							<div class="form-group">
								<a href="<?=$urlInventario2?>" target="_blank" class="btn btn-primary"> Saldos Productos</a>
							</div>
				  		</div>
					</div>

				  		
					</div>
			  	</div>
			</div>

		</div>
	</div>
</div>