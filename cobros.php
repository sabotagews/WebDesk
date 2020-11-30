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
<main class="container" role="main">
	<div class="py-5 text-center">
		<h2>Cobros</h2>
		<p class="lead">Captura de cobros ( pagos de clientes ) de <strong>reservación.</strong></p>
	</div>
	<form class="form-inline my-2 my-lg-0">
		<input class="form-control mr-sm-2"  id="search" type="search" placeholder="Buscar reservación" aria-label="Buscar">
		<button class="btn btn-primary my-2 my-sm-0 loupe" type="submit">Buscar</button>
	</form>

	<hr class="mb-4">
	<div class="row" id="contenedor_reservacion" style="display: none">
		<div class="col-md-12">
			<h4 class="mb-3">Informaci&oacute;n de la reservaci&oacute;n</h4>
			<hr class="mb-4">

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
	                    <label for="reservacionStatus">Status</label>
						<span id="reservacionStatus"></span>
	                </div>

				</div>

				<!--Inputs-->
				<div class="form-row">
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
						<textarea class="form-control" id="cobroDetalle" name="cobroDetalle" rows="5"></textarea>
					</div>
				</div>

				<!--Botones-->
				<hr class="mb-4">
				<div class="form-row">
					<div class="col-5" id="btn_nuevo" style="display: none">
						<button class="btn btn-danger btn-lg btn-block" type="button" onclick="limpia_cobro( );">Nuevo</button>
					</div>
					<div class="col-5" id="btn_eliminar" style="display: none">
						<button class="btn btn-danger btn-lg btn-block" type="button">Eliminar</button>
					</div>
					<div class="col-5" id="btn_guardar">
						<button class="btn btn-primary btn-lg btn-block" type="submit">Guardar</button>
					</div>
				</div>

			</form>

		</div>

		<div class="col-md-12">

			<hr class="mb-4">
			<table class="table table-striped table-hover">
				<thead class="thead-dark">
					<tr>
						<th scope="col" data-sort="string-ins" data-sort-onload="yes">Tipo</th>
						<th scope="col" data-sort="string-ins">Monto</th>
						<th scope="col" data-sort="int">Saldo</th>
					</tr>
				</thead>
				<div id="listCobros"></div>
			</table>

		</div>

	</div>

</main>
<?php
require_once('./includes/layout/footer.php');
?>
