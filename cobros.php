<?php
session_start();
require_once('definitions.php');
require_once('./includes/layout/header.php');
require_once('./includes/admin/menu-admin.php');
?>
<script type="text/javascript">
function inicializa( ) {

	$("#search").autocomplete(
								{

									minLength	: 2 	,
									delay		: 500	,
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

</script>
<main class="container-fluid p-5" role="main">
	<div class="py-5 text-center">
		<h2>Cobros</h2>
		<p class="lead">Captura de cobros ( pagos de clientes ) de <strong>reservaci&oacute;n.</strong></p>
	</div>
	<form class="form-inline my-2 my-lg-0">
		<input class="form-control mr-sm-2"  id="search" type="search" placeholder="Buscar reservaci&oacute;n" aria-label="Buscar">
		<button class="btn btn-primary my-2 my-sm-0 loupe" type="submit">Buscar</button>
	</form>
	<div class="row" id="contenedor_reservacion" style="display: none">
		<hr class="col-12 mt-4">
		<div class="d-flex col-12 mt-4">
			<div class="mr-auto">
				<h1 id="cliente"></h1>
			</div>
			<div>
				<h1 id="reservacionLocalizador"></h1>
			</div>
		</div>

		<div class="col-12">

			<form id="form_cobro" class="needs-validation" novalidate="">

				<input type="hidden" name="reservacionId" value="0" />
				<input type="hidden" name="cobroId" value="0" />

				<!--Detalle-->
				<div class="form-row">
					<div class="col-md-6 mb-3">
						<label for="reservacionLocalizador">Localizador</label>
						<span id="reservacionLocalizador"></span>
					</div>
					<div class="col-md-6 mb-3">
						<label for="reservacionLocalizador">Saldo</label>
						<span id="reservacionSaldo"></span>
	                </div>
					<div class="col-md-6 mb-3">
	                    <label for="reservacionProveedor">Proveedor</label>
						<span id="reservacionProveedor"></span>
	                </div>
					<div class="col-md-6 mb-3">
	                    <label for="cliente">Cliente</label>
						<span id="cliente"></span>
	                </div>
					<div class="col-md-6 mb-3">
	                    <label for="reservacionServicio">Servicio</label>
						<span id="reservacionServicio"></span>
	                </div>
					<div class="col-md-6 mb-3">
	                    <label for="reservacionDestino">Destino</label>
						<span id="reservacionDestino"></span>
	                </div>
					<div class="col-md-6 mb-3">
	                    <label for="reservacionHotel">Hotel</label>
						<span id="reservacionHotel"></span>
	                </div>
					<div class="col-md-6 mb-3">
	                    <label for="reservacionPlan">Plan</label>
						<span id="reservacionPlan"></span>
	                </div>
					<div class="col-md-6 mb-3">
	                    <label for="reservacionCheckIn">CheckIn</label>
						<span id="reservacionCheckIn"></span>
	                </div>
					<div class="col-md-6 mb-3">
	                    <label for="reservacionCheckOut">CheckOut</label>
						<span id="reservacionCheckOut"></span>
	                </div>
					<div class="col-md-6 mb-3">
	                    <label for="reservacionHabitaciones">Habitaciones</label>
						<span id="reservacionHabitaciones"></span>
	                </div>

					<div class="col-md-6 mb-3">
	                    <label for="reservacionDetalle">Detalle</label>
						<span id="reservacionDetalle"></span>
	                </div>
					<div class="col-md-6 mb-3">
	                    <label for="reservacionCoste">Coste</label>
						<span id="reservacionCoste"></span>
	                </div>
					<div class="col-md-6 mb-3">
	                    <label for="reservacionPrecio">Precio</label>
						<span id="reservacionPrecio"></span>
	                </div>
					<div class="col-md-6 mb-3">
	                    <label for="reservacionStatusCobro">Status de Cobro</label>
						<span id="reservacionStatusCobro"></span>
	                </div>
					<div class="col-md-6 mb-3">
						<label for="reservacionStatusPago">Status de Pago</label>
						<label for="reservacionStatusPago">Status de Pago</label>
						<span id="reservacionStatusPago"></span>
					</div>

				</div>

				<!--Inputs-->
				<div class="form-row">
					<div class="col-md-6 mb-3">
						<label for="cobroFechaAplicacion">Fecha Aplicación</label>
						<input type="date" class="form-control" id="cobroFechaAplicacion" name="cobroFechaAplicacion" placeholder="dd/mm/yyyy" pattern="(^(((0[1-9]|1[0-9]|2[0-8])[\/](0[1-9]|1[012]))|((29|30|31)[\/](0[13578]|1[02]))|((29|30)[\/](0[4,6,9]|11)))[\/](19|[2-9][0-9])\d\d$)|(^29[\/]02[\/](19|[2-9][0-9])(00|04|08|12|16|20|24|28|32|36|40|44|48|52|56|60|64|68|72|76|80|84|88|92|96)$)" required>
					</div>
					<div class="col-md-6 mb-3">
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
					<div class="col-md-6 mb-3">
						<label for="clienteApellido">Monto</label>
						<input type="text" class="form-control" id="cobroMonto" placeholder="" value="" required="">
						<div class="invalid-feedback">
							El monto no es correcto.
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 mb-3">
						<label for="cobroDetalle">Detalle</label>
						<textarea class="form-control" id="cobroDetalle" name="cobroDetalle" rows="15"></textarea>
					</div>
				</div>

				<!--Botones-->
				<hr class="mb-4">
				<div class="form-row">
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

		<div class="col-md-12">
			<hr class="mb-4">
			<table class="table table-striped table-hover" id="listCobros"></table>
		</div>

	</div>

</main>
<?php
require_once('./includes/layout/footer.php');
?>
