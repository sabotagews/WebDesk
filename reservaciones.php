<?php
session_start();
require_once( 'definitions.php' );
require_once('./includes/layout/header.php');
require_once('./includes/admin/menu-admin.php');
?>
<script type="text/javascript">
    window.onload = function() {
		get_clientes_select( );
		get_proveedores_select( );
        get_reservaciones( );
    }
</script>
<main class="container" role="main">
    <div class="py-5 text-center">
        <h2>Reservaciones</h2>
        <p class="lead">Formulario para carga de una cotización o reservación.</p>
    </div>

    <div class="row">
        <div class="col order-md-1">
            <h4 class="mb-3">Datos de la Reservación</h4>
            <form class="needs-validation" novalidate="" id="form_reservacion" name="form_reservacion">
				<input type="hidden" name="reservacionId" value="0" />
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="clienteId">Cliente</label>
                        <select class="custom-select" id="clienteId" onchange="" required></select>
                    </div>
                    <div class="col-md-8 mb-3">
                        <label for="reservacionServicio">Tipo de Servicio</label>
                        <div id="reservacionServicio" class="mt-1">

							<? $i = 0; ?>
							<? foreach( RESERVACION_SERVICIOS as $k => $v ) { ?>

								<div class="form-check form-check-inline">
	                                <input class="form-check-input" type="radio" name="reservacionServicio" id="reservacionServicio<?= $i; ?>" value="<?= $k; ?>" required>
	                                <label class="form-check-label" for="reservacionServicio<?= $i++; ?>"><?= $v; ?></label>
	                            </div>

							<? } unset( $i ); ?>

                        </div>
                    </div>

					<div class="col-md-8 mb-3">
                        <label for="reservacionStatus">Status</label>
                        <div id="reservacionStatus" class="mt-1">

							<? $i = 0; ?>
							<? foreach( RESERVACION_STATUS as $k => $v ) { ?>

								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="reservacionStatus" id="reservacionStatus<?= $i; ?>" value="<?= $k; ?>" required>
									<label class="form-check-label" for="reservacionStatus<?= $i++; ?>"><?= $v; ?></label>
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
						<select class="custom-select" id="reservacionPlan" name="reservacionPlan" required>
							<option value=""></option>
							<? foreach( PLAN_ALIMENTOS as $k => $v ) { ?>
								<option value="<?= $k; ?>"><?= $v; ?></option>
							<? } ?>
						</select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="reservacionCheckIn">Check In</label>
                        <input type="date" class="form-control" id="reservacionCheckIn" name="reservacionCheckIn" placeholder="dd/mm/yyyy" pattern="(^(((0[1-9]|1[0-9]|2[0-8])[\/](0[1-9]|1[012]))|((29|30|31)[\/](0[13578]|1[02]))|((29|30)[\/](0[4,6,9]|11)))[\/](19|[2-9][0-9])\d\d$)|(^29[\/]02[\/](19|[2-9][0-9])(00|04|08|12|16|20|24|28|32|36|40|44|48|52|56|60|64|68|72|76|80|84|88|92|96)$)" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="reservacionCheckOut">Check Out</label>
                        <input type="date" class="form-control" id="reservacionCheckOut" name="reservacionCheckOut" placeholder="dd/mm/yyyy" pattern="(^(((0[1-9]|1[0-9]|2[0-8])[\/](0[1-9]|1[012]))|((29|30|31)[\/](0[13578]|1[02]))|((29|30)[\/](0[4,6,9]|11)))[\/](19|[2-9][0-9])\d\d$)|(^29[\/]02[\/](19|[2-9][0-9])(00|04|08|12|16|20|24|28|32|36|40|44|48|52|56|60|64|68|72|76|80|84|88|92|96)$)" required>
                    </div>
					<div class="col-md-2 mb-3">
						<label for="reservacionHabitaciones">Habitaciones</label>
						<select class="custom-select" id="reservacionHabitaciones" name="reservacionHabitaciones" required>
							<option value=""></option>
							<? for( $i = 1; $i <= RESERVACION_HABITACIONES; $i++ ) { ?>
								<option value="<?= $i; ?>"><?= $i; ?></option>
							<? } ?>
						</select>
					</div>
                </div>
                <div class="row">
	                <div class="col-md-12 mb-3">
                        <label for="reservacionHotel">Detalle</label>
                        <textarea class="form-control" id="reservacionDetalle" name="reservacionDetalle" rows="5" required=""></textarea>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-3 mb-3">
                        <label for="reservacionDestino">Coste</label>
                        <input type="text" class="form-control" id="reservacionCoste" name="reservacionCoste" placeholder="" value="">
                    </div>

                    <div class="col-6">
						<label for="proveedorId">Proveedor</label>
                        <select class="custom-select" id="proveedorId" onchange=""></select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="reservacionHotel">Precio</label>
                        <input type="text" class="form-control" id="reservacionPrecio" name="reservacionPrecio" placeholder="" value="" required="">
                    </div>


					<div class="col-md-3 mb-3">
						<label for="reservacionLocalizadorExterno">Localizador Externo</label>
						<input type="text" class="form-control" id="reservacionLocalizadorExterno" name="reservacionLocalizadorExterno" placeholder="" value="" required="">
					</div>


				</div>
                <hr class="mb-4">
                <div class="form-row">
	                <div class="col-2">
						<button style="display: none" id="btn_nueva" class="btn btn-secondary btn-lg btn-block" type="button" onclick="limpia_reservacion( );">Nueva</button>
	                </div>
	                <div class="col-2">
						<button style="display: none" id="btn_eliminar" class="btn btn-danger btn-lg btn-block" type="button" onclick="delete_reservacion( );">Eliminar</button>
	                </div>
					<div class="col-8">
						<button class="btn btn-primary btn-lg btn-block" type="submit">Guardar</button>
					</div>
                </div>
            </form>
        </div>
    </div>

	<div>
		<h4 class="mb-3 mt-5">Cotizaciones / Reservaciones</h4>
		<table class="table table-striped table-hover">
			<thead class="thead-dark">
				<tr>
					<th scope="col" data-sort="string-ins" data-sort-onload="yes">Servicio</th>
					<th scope="col">Status</th>
					<th scope="col">CheckIn</th>
					<th scope="col">CheckOut</th>
					<th></th>
				</tr>
			</thead>
			<tbody id="listReservaciones"></tbody>
		</table>
	</div>

</main>
<?php
require_once('./includes/layout/footer.php');
?>
