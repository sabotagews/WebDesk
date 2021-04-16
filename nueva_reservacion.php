<?php
session_start();
require_once( 'definitions.php' );
require_once('./includes/layout/header.php');
require_once('./includes/admin/menu-admin.php');
?>
<script>
	function inicializa( ) {

		$("#search").bind("focus", function( ) {
  			this.value = '';
			g('clienteId').value = '';
		});
		$("#search").bind("blur", function( ) {
			if( g('clienteId').value == '' ) {
				this.value = '';
			}
		});

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
																						_data1	: 'cliente->search',
																						search	: request.term
																					}				,
																	success		: function( data ) {

																					response( $.map( data, function( item ) {

																											return	{

																														label	: item.busquedaResultado,
																														value	: item.clienteId

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

														g( event.target.id ).blur( );
														g( event.target.id ).value = ui.item.label;
														set_cliente( ui.item.value );

													}
									}

		);

		$("#searchReservacion").autocomplete(
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

																														label	: item.busquedaResultado,
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

														g( event.target.id ).blur( );
														g( event.target.id ).value = '';
														get_reservacion( ui.item.value );

													}
									}

		);

	}
	function set_cliente( id ) {

		g('clienteId').value = id;

	}
	window.onload = function( ) {
		inicializa( );
		get_clientes_select( );
		get_proveedores_select( );
	}
</script>
<main class="container" role="main">

    <div class="py-5 text-center d-print-none">
        <h2>Crear una nueva Reservación</h2>
        <p class="lead">Formulario para carga de una cotizaci&oacute;n o reservaci&oacute;n.</p>
    </div>

    <div class="row mb-5">
        <div class="col order-md-1">
            <h4 class="mb-3">Datos de la Reservaci&oacute;n</h4>
            <form class="needs-validation" novalidate="" id="form_reservacion" name="form_reservacion">
				<input type="hidden" name="reservacionId" value="0" />
                <div class="row">
					<input type="hidden" id="clienteId" name="clienteId" value="" />
                    <div class="col-md-4 mb-3">
                        <label for="search">Cliente</label>
                        <input class="form-control mr-sm-2" type="search" id="search" placeholder="Buscar cliente" aria-label="Buscar" required="">
                    </div>
                    <div class="col-md-8 mb-3">
                        <label for="reservacionServicio">Tipo de Servicio</label>
                        <div id="reservacionServicio" class="mt-1">

							<? $i = 0; ?>
							<? foreach( RESERVACION_SERVICIOS as $k => $v ) { ?>

								<div class="form-check form-check-inline">
	                                <input class="form-check-input" type="radio" name="reservacionServicio" id="reservacionServicio<?= $i; ?>" value="<?= $k; ?>" required="">
	                                <label class="form-check-label" for="reservacionServicio<?= $i++; ?>"><?= $v; ?></label>
	                            </div>

							<? } unset( $i ); ?>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="reservacionDestino">Destino</label>
                        <input type="text" class="form-control" id="reservacionDestino" name="reservacionDestino" placeholder="" value="" required="">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="reservacionHotel">Hotel</label>
                        <input type="text" class="form-control" id="reservacionHotel" name="reservacionHotel" placeholder="" value="" required="">
                    </div>
				</div>
				<div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="reservacionPlan">Plan de Alimentos</label>
						<select class="custom-select" id="reservacionPlan" name="reservacionPlan">
							<option value=""></option>
							<? foreach( PLAN_ALIMENTOS as $k => $v ) { ?>
								<option value="<?= $k; ?>"><?= $v; ?></option>
							<? } ?>
						</select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="reservacionCheckIn">Check In</label>
                        <input type="text" class="form-control hasDatePicker" id="reservacionCheckIn" name="reservacionCheckIn" placeholder="dd/mm/yyyy" pattern="(^(((0[1-9]|1[0-9]|2[0-8])[\/](0[1-9]|1[012]))|((29|30|31)[\/](0[13578]|1[02]))|((29|30)[\/](0[4,6,9]|11)))[\/](19|[2-9][0-9])\d\d$)|(^29[\/]02[\/](19|[2-9][0-9])(00|04|08|12|16|20|24|28|32|36|40|44|48|52|56|60|64|68|72|76|80|84|88|92|96)$)" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="reservacionCheckOut">Check Out</label>
                        <input type="text" class="form-control hasDatePicker" id="reservacionCheckOut" name="reservacionCheckOut" placeholder="dd/mm/yyyy" pattern="(^(((0[1-9]|1[0-9]|2[0-8])[\/](0[1-9]|1[012]))|((29|30|31)[\/](0[13578]|1[02]))|((29|30)[\/](0[4,6,9]|11)))[\/](19|[2-9][0-9])\d\d$)|(^29[\/]02[\/](19|[2-9][0-9])(00|04|08|12|16|20|24|28|32|36|40|44|48|52|56|60|64|68|72|76|80|84|88|92|96)$)" required>
                    </div>
					<div class="col-md-2 mb-3">
						<label for="reservacionHabitaciones">Habitaciones</label>
						<select class="custom-select" id="reservacionHabitaciones" name="reservacionHabitaciones">
							<option value=""></option>
							<? for( $i = 1; $i <= RESERVACION_HABITACIONES; $i++ ) { ?>
								<option value="<?= $i; ?>"><?= $i; ?></option>
							<? } ?>
						</select>
					</div>
                </div>
                <div class="row">
	                <div class="col-md-12 mb-3">
                        <label for="reservacionDetalle">Detalle</label>
						<div class="d-print-none">
                        	<textarea class="form-control" id="reservacionDetalle" name="reservacionDetalle" rows="15"></textarea>
						</div>
						<div class="d-none d-print-block" id="reservacionDetallePrint"></div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-2 mb-2 d-print-none">
                        <label for="reservacionDestino">Coste</label>
                        <input type="text" class="form-control" id="reservacionCoste" name="reservacionCoste" placeholder="" value="" required>
                    </div>
                    <div class="col-5 d-print-none">
						<label for="proveedorId">Proveedor</label>
                        <select class="custom-select" id="proveedorId" onchange="" required></select>
                    </div>
					<div class="col-md-3 mb-3 d-print-none">
						<label for="reservacionLocalizadorExterno">Localizador Externo</label>
						<input type="text" class="form-control" id="reservacionLocalizadorExterno" name="reservacionLocalizadorExterno" placeholder="" value="">
					</div>
                    <div class="col-md-2 mb-2">
                        <label for="reservacionHotel">Precio</label>
                        <input type="text" class="form-control" id="reservacionPrecio" name="reservacionPrecio" placeholder="" value="" required="">
                    </div>
				</div>

				<div id="contenedor_gastos_cancelacion" class="d-none">
                    <div class="col-md-2 mb-2 d-print-none">
                        <label for="reservacionDestino">Cancelación Coste</label>
                        <input type="text" class="form-control" id="reservacionGastosCancelacionCoste" name="reservacionGastosCancelacionCoste" placeholder="" value="">
                    </div>
                    <div class="col-md-2 mb-2">
                        <label for="reservacionHotel">Cancelación Precio</label>
                        <input type="text" class="form-control" id="reservacionGastosCancelacionPrecio" name="reservacionGastosCancelacionPrecio" placeholder="" value="">
                    </div>
				</div>

				<div class="row d-print-none">
					<div class="col-md-6 mb-6">
						<label for="reservacionStatusCobro">Status de Cobro</label>
						<div id="reservacionStatusCobro" class="mt-1">

							<? $i = 0; ?>
							<? foreach( RESERVACION_STATUS_COBRO as $k => $v ) { ?>

								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="reservacionStatusCobro" id="reservacionStatusCobro<?= $i; ?>" value="<?= $k; ?>" required>
									<label class="form-check-label" for="reservacionStatusCobro<?= $i++; ?>"><?= $v; ?></label>
								</div>

							<? } unset( $i ); ?>

						</div>
					</div>
					<div class="col-md-6 mb-6">
						<label for="reservacionStatus">Status de Pago</label>
						<div id="reservacionStatusPago" class="mt-1">

							<? $i = 0; ?>
							<? foreach( RESERVACION_STATUS_PAGO as $k => $v ) { ?>

								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="reservacionStatusPago" id="reservacionStatusPago<?= $i; ?>" value="<?= $k; ?>" required>
									<label class="form-check-label" for="reservacionStatusPago<?= $i++; ?>"><?= $v; ?></label>
								</div>

							<? } unset( $i ); ?>

						</div>
					</div>
				</div>
                <hr class="mb-4">
                <div class="form-row justify-content-end d-print-none">
	                <div class="col-2">
						<button style="display: none" id="btn_nueva" class="btn btn-secondary btn-lg btn-block" type="button" onclick="limpia_reservacion( );">Nueva</button>
	                </div>
	                <div class="col-2 offset-6">
						<button style="display: none" id="btn_eliminar" class="btn btn-danger btn-lg btn-block" type="button" onclick="delete_reservacion( );">Eliminar</button>
	                </div>
					<div class="col-2">
						<button class="btn btn-primary btn-lg btn-block" type="submit">Guardar</button>
					</div>
                </div>
            </form>
        </div>
    </div>
</main>
<?php
require_once('./includes/layout/footer.php');
?>
