<?php
session_start();
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

													get_reservacion_pago( ui.item.value );

												}
								}

	);

//get_reservacion_pago( 6 );

}
window.onload = function( ) {
	inicializa( );
}

</script>
<main class="container" role="main">
	<form name="form" method="post" class="form-inline my-2 d-print-none">

		<input name="_data0" type="hidden" value=""/>
		<input name="_data1" type="hidden" value=""/>
		<input name="_data2" type="hidden" value=""/>

		<input name="clienteId" type="hidden" value=""/>
		<input name="proveedorId" type="hidden" value=""/>


		<div class="col-4 input-group mb-3 w-25">
			<input class="form-control" id="search" type="search" placeholder="Buscar reservaci&oacute;n" aria-label="Buscar">
			<div class="input-group-append">
				<span class="input-group-text" id="basic-addon1"><span class="loupe"></span></span>
			</div>
		</div>
		<div class="col py-5 text-right">
			<h2>Pagos</h2>
			<span class="text-black-50"><small>Captura de pagos ( pagos a proveedores ) de <strong>reservaci&oacute;n.</strong></small></span>
		</div>
	</form>
	<div id="contenedor_reservacion" style="display: none">
		<hr class="col-12 mt-4">
		<div class="d-flex col-12 p-0">
			<div class="mr-auto">
				<h1 id="cliente"></h1>
			</div>
			<div>
				<h1 id="reservacionLocalizador"></h1>
			</div>
		</div>
		<div class="d-flex col-12 p-0">
			<!--Detalle-->
			<table class="table col-6 mr-4">
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
					<tr>
						<td>Proveedor</td>
						<th class="text-right" id="reservacionProveedor"></th>
					</tr>
					<tr>
						<td>Localizador Externo</td>
						<th class="text-right" id="reservacionLocalizadorExterno"></th>
					</tr>
					<tr>
						<td>Coste</td>
						<th class="text-right" id="reservacionCoste"></th>
					</tr>
					<tr>
						<td>Acumulado de Pagos</td>
						<th class="text-right" id="reservacionAcumuladoPago"></th>
					</tr>
					<tr>
						<td>Saldo por Pagar</td>
						<th class="text-right" id="reservacionSaldoPago"></th>
					</tr>
					<tr class="d-print-none">
						<td>Status de Cobro</td>
						<th class="text-right" id="reservacionStatusCobro"></th>
					</tr>
					<tr>
						<td>Status de Pago</td>
						<th class="text-right" id="reservacionStatusPago"></th>
					</tr>
				</tbody>
			</table>
		</div>
		<hr class="col-12">
		<div class="d-flex col-12 p-0">
			<h5>Detalle de la Reservaci&oacute;n</h5>
		</div>
		<div class="d-flex col-12 p-0">
			<div class="col-12" id="reservacionDetalle"></div>
		</div>
		<hr class="col-12">

		<h3 class="text-secondary mt-5 mb-3">Histórico de Pagos</h3>
		<table class="table table-striped table-hover my-5" id="listPagos"></table>

		<form id="form_pago" class="needs-validation d-print-none mb-5" novalidate="">
			<input type="hidden" name="reservacionId" value="0" />
			<input type="hidden" name="pagoId" value="0" />
			<!--Inputs-->

			<hr class="col-12 my-5">
			<h3 class="text-secondary mt-5 mb-3">Agregar nuevo Pago</h3>
			<hr class="col-12">
			<div class="form-row">
				<div class="col col-md-2 mb-3">
					<label for="pagoFechaAplicacion">Fecha Aplicación</label>
					<input type="text" class="form-control hasDatePicker" id="pagoFechaAplicacion" name="pagoFechaAplicacion" placeholder="dd/mm/yyyy" pattern="(^(((0[1-9]|1[0-9]|2[0-8])[\/](0[1-9]|1[012]))|((29|30|31)[\/](0[13578]|1[02]))|((29|30)[\/](0[4,6,9]|11)))[\/](19|[2-9][0-9])\d\d$)|(^29[\/]02[\/](19|[2-9][0-9])(00|04|08|12|16|20|24|28|32|36|40|44|48|52|56|60|64|68|72|76|80|84|88|92|96)$)" required>
				</div>
				<div class="col col-md-2 mb-3">
					<label for="pagoTipo">Pago tipo</label>
					<select class="custom-select" id="pagoTipo" onchange="" required>
						<option></option>
						<? foreach( PAGO_TIPOS as $k => $v ) { ?>
							<option value="<?= $k; ?>"><?= $v; ?></option>
						<? } ?>
					</select>
					<div class="invalid-feedback">
						Seleccione la forma de pago.
					</div>
				</div>
				<div class="col col-md-2 mb-3">
					<label for="pagoTipo">Cuenta Origen</label>
					<select class="custom-select" id="pagoCuenta" onchange="" required>
						<option></option>
						<? foreach( $cuentas as $k => $v ) { ?>
							<option value="<?= $k; ?>"><?= $v['cuentaAlias']; ?></option>
						<? } ?>
					</select>
					<div class="invalid-feedback">
						Seleccione la cuenta bancaria.
					</div>
				</div>

				<div class="col col-md-2 mb-3">
					<label for="pagoTipo">Cuenta Destino</label>
					<select class="custom-select" id="pagoCuentaDestino" onchange="" required>
						<option></option>
						<? foreach( $cuentas as $k => $v ) { ?>
							<option value="<?= $k; ?>"><?= $v['cuentaAlias']; ?></option>
						<? } ?>
					</select>
					<div class="invalid-feedback">
						Seleccione la cuenta bancaria.
					</div>
				</div>

				<div class="col col-md-1 mb-3">
					<label for="pagoMonto">Monto $</label>
					<input type="text" class="form-control" id="pagoMonto" placeholder="" value="" required="">
					<div class="invalid-feedback">
						El monto no es correcto.
					</div>
				</div>
				<div class="col col-md-3 mb-3">
					<label for="pagoArchivo">Archivo</label>
					<input type="file" class="form-control" id="pagoArchivo" accept="image/gif,image/jpeg,image/jpg,image/png,.pdf" placeholder="" value="">
				</div>
			</div>
			<div class="form-row">
				<div class="col col-md-12 mb-3">
					<label for="pagoDetalle">Detalle</label>
					<textarea class="form-control" id="pagoDetalle" name="pagoDetalle" rows="15"></textarea>
				</div>
			</div>

			<!--Botones-->
			<div class="form-row d-flex justify-content-end">
				<div class="col-2" id="btn_nuevo" style="display: none">
					<button class="btn btn-danger btn-lg btn-block" type="button" onclick="limpia_pago( );">Nuevo</button>
				</div>
				<div class="col-2" id="btn_eliminar" style="display: none">
					<button class="btn btn-danger btn-lg btn-block" type="button" onclick="delete_pago( );">Eliminar</button>
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
