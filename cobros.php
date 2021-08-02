<?php
session_start( );

if( !isset( $_SESSION['currentUser'] ) ) header('location: ./ ');

require_once('definitions.php');
require_once('./includes/layout/header.php');
require_once('./includes/admin/menu-admin.php');

require_once('./includes/classes/cuenta.cls.php');

$_C				= new cuenta( );
$cuentas	= $_C->get_cuenta( );

?>
<script>
function inicializa( ) {

	$("#search").autocomplete(
								{

									minLength	: 2 	,
									delay			: 500	,
									source		: function( request, response ) {

													$.ajax(

															{
																url 		: AJAX_catalogos_url,
																type		: 'POST'			,
																dataType	: 'json'			,
																data		:	{
																					_data1	: 'reservacion->search',
																					search	: request.term
																				}				,
																success		: function( data ) {

																				response( $.map( data, function( item ) {

																										return	{

																													label	: item.busquedaResultado	,
																													value	: item.reservacionId

																												}

																									}

																								)
																						)

																				}

															}

														)

												}	,
									select		: function( event, ui ) {

													event.preventDefault( );
													g( event.target.id ).value = '';

													get_reservacion_cobro( ui.item.value );

												}
								}

	);

}
window.onload = function( ) {
	inicializa( );
}

//get_reservacion_cobro( 6 );

</script>
<main class="container" role="main">
	<? require_once('./includes/layout/header_print.php'); ?>
	<form name="form" method="post" class="form-inline my-2 d-print-none">

		<input name="_data0" type="hidden" value=""/>
		<input name="_data1" type="hidden" value=""/>
		<input name="_data2" type="hidden" value=""/>

		<input name="clienteId" type="hidden" value=""/>
		<input name="proveedorId" type="hidden" value=""/>


		<div class="col-4 px-0 input-group mb-3 w-25">
			<input class="form-control" id="search" type="search" placeholder="Buscar reservaci&oacute;n" aria-label="Buscar">
			<div class="input-group-append">
				<span class="input-group-text" id="basic-addon1"><span class="loupe"></span></span>
			</div>
		</div>
		<div class="col py-5 px-0 text-right">
			<h2>Cobros</h2>
			<span class="text-black-50"><small>Captura de cobros ( pagos de clientes ) de <strong>reservaci&oacute;n.</strong></small></p>
		</div>
	</form>
	<div id="contenedor_reservacion" style="display: none">
		<hr class="  mt-4">
		<div class="d-flex p-0">
			<div class="mr-auto">
				<h1 id="cliente"></h1>
			</div>
			<div>
				<h1 id="reservacionLocalizador"></h1>
			</div>
		</div>
		<div class="d-flex p-0">
			<!--Detalle-->
			<table class="table col-6">
				<tbody>
					<tr>
						<th id="reservacionHotel"></th>
					</tr>
					<tr>
						<th id="reservacionCheckIn"></th>
					</tr>
					<tr>
						<th id="reservacionServicio"></th>
					</tr>
					<tr>
						<th id="reservacionHabitaciones"></th>
					</tr>
					<tr>
						<th id="reservacionPrecio"></th>
					</tr>
				</tbody>
			</table>
			<table class="table col-6 border-start">
				<tbody>
					<tr class="d-print-none">
						<td>Proveedor</td>
						<th class="text-right" id="reservacionProveedor"></th>
					</tr>
					<tr class="d-print-none">
						<td>Localizador Externo</td>
						<th class="text-right" id="reservacionLocalizadorExterno"></th>
					</tr>
					<tr class="d-print-none">
						<td>Coste</td>
						<th class="text-right" id="reservacionCoste"></th>
					</tr>
					<tr>
						<td>Acumulado de Cobros</td>
						<th class="text-right" id="reservacionAcumuladoCobro"></th>
					</tr>
					<tr>
						<td>Saldo por Cobrar</td>
						<th class="text-right" id="reservacionSaldoCobro"></th>
					</tr>
					<tr>
						<td>Status Cobro</td>
						<th class="text-right" id="reservacionStatusCobro"></th>
					</tr>
					<tr class="d-print-none">
						<td>Status de Pago</td>
						<th class="text-right" id="reservacionStatusPago"></th>
					</tr>
				</tbody>
			</table>
		</div>
		<hr class=" ">
		<div class="d-flex p-0">
			<h5>Detalle de la Reservaci&oacute;n</h5>
		</div>
		<div class="d-flex p-0">
			<div class=" " id="reservacionDetalle"></div>
		</div>
		<hr class=" ">

		<h3 class="text-secondary mt-5 mb-3">Histórico de Cobros</h3>
		<table class="table table-striped table-hover my-5" id="listCobros"></table>

		<form id="form_cobro" class="needs-validation d-print-none mb-5" novalidate="">
			<input type="hidden" name="reservacionId" value="0" />
			<input type="hidden" name="cobroId" value="0" />
			<!--Inputs-->

			<hr class="  my-5">
			<h3 class="text-secondary mt-5 mb-3">Agregar nuevo Cobro</h3>
			<hr class=" ">
			<div class="form-row">
				<div class="col-md-2 mb-3">
					<label for="cobroFechaAplicacion">Fecha Aplicación</label>
					<input type="date" class="form-control" id="cobroFechaAplicacion" name="cobroFechaAplicacion" placeholder="dd/mm/yyyy" pattern="(^(((0[1-9]|1[0-9]|2[0-8])[\/](0[1-9]|1[012]))|((29|30|31)[\/](0[13578]|1[02]))|((29|30)[\/](0[4,6,9]|11)))[\/](19|[2-9][0-9])\d\d$)|(^29[\/]02[\/](19|[2-9][0-9])(00|04|08|12|16|20|24|28|32|36|40|44|48|52|56|60|64|68|72|76|80|84|88|92|96)$)" required>
					<div class="invalid-feedback">
						El nombre es requerido.
					</div>
				</div>
				<div class="col-md-2 mb-3">
					<label for="cobroTipo">Cobro tipo</label>
					<select class="custom-select" id="cobroTipo" onchange="" required>
						<option></option>
						<? foreach( COBRO_TIPOS as $k => $v ) { ?>
							<option value="<?= $k; ?>"><?= $v; ?></option>
						<? } ?>
					</select>
					<div class="invalid-feedback">
						Seleccione la forma de cobro.
					</div>
				</div>
				<div class="col-md-2 mb-3">
					<label for="cobroTipo">Cuenta</label>
					<select class="custom-select" id="cobroCuenta" onchange="" required>
						<option></option>
						<? foreach( $cuentas as $k => $v ) { ?>
							<option value="<?= $k; ?>"><?= $v['cuentaAlias']; ?></option>
						<? } ?>
					</select>
					<div class="invalid-feedback">
						Seleccione la cuenta bancaria.
					</div>
				</div>
				<div class="col-md-2 mb-3">
					<label for="cobroMonto">Monto</label>
					<input type="text" class="form-control" id="cobroMonto" placeholder="" value="" required="" pattern="^-?(?!0+\.00)(?=.{1,9}(\.|$))(?!0(?!\.))\d{1,5}(,\d{5})*(\.\d+)?$">
					<div class="invalid-feedback">
						El monto no es correcto.
					</div>
				</div>
				<div class="col-md-4 mb-3">
					<label for="cobroArchivo">Archivo</label>
					<input type="file" class="form-control" id="cobroArchivo" accept="image/gif,image/jpeg,image/jpg,image/png,.pdf" placeholder="" value="">
				</div>
			</div>
			<div class="form-row">
				<div class="col-md-12 mb-3">
					<label for="cobroDetalle">Detalle</label>
					<textarea class="form-control" id="cobroDetalle" name="cobroDetalle" rows="15"></textarea>
				</div>
			</div>

			<!--Botones-->
			<hr class="mb-4">
			<div class="form-row d-flex justify-content-end">
				<div class="col-2">
					<button class="btn btn-info btn-lg btn-block" type="button" onclick="window.print();">Imprimir</button>
				</div>
				<div class="col-2" id="btn_nuevo" style="display: none">
					<button class="btn btn-danger btn-lg btn-block" type="button" onclick="limpia_cobro( );">Nuevo</button>
				</div>
				<div class="col-2" id="btn_eliminar" style="display: none">
					<button class="btn btn-danger btn-lg btn-block" type="button" onclick="delete_cobro( );">Eliminar</button>
				</div>
				<div class="col-3" id="btn_guardar">
					<button class="btn btn-primary btn-lg btn-block" type="submit">Guardar</button>
				</div>
			</div>
		</form>


	</div>
</main>
<?php
require_once('./includes/layout/footer.php');
?>
