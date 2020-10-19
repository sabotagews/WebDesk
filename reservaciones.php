<?php
session_start();
require_once( 'definitions.php' );
require_once('./includes/layout/header.php');
require_once('./includes/admin/menu-admin.php');
?>
<script type="text/javascript">
    window.onload = function() {
        get_clientes_select();
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
            <form class="needs-validation" novalidate="" id="form_Reservacion" name="form_Reservacion" onsubmit="">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="reservacionCliente">Cliente</label>
                        <select class="custom-select" id="reservacionCliente" onchange="" required></select>
                        <!-- <div class="invalid-feedback">
                            El Cliente es requerido.
                        </div> -->
                    </div>
                    <div class="col-md-8 mb-3">
                        <label for="reservacionServicio">Tipo de Servicio</label>
                        <div id="reservacionServicio" class="mt-1">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="reservacionServicio" id="reservacionServicio1" value="option1" required>
                                <label class="form-check-label" for="reservacionServicio1">Alojamiento</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="reservacionServicio" id="reservacionServicio2" value="option2">
                                <label class="form-check-label" for="reservacionServicio2">Charter</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="reservacionServicio" id="reservacionServicio3" value="option3">
                                <label class="form-check-label" for="reservacionServicio3">Aéreo</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="reservacionServicio" id="reservacionServicio4" value="option4">
                                <label class="form-check-label" for="reservacionServicio4">Autobús</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="reservacionServicio" id="reservacionServicio5" value="option5">
                                <label class="form-check-label" for="reservacionServicio5">Paquete</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="reservacionServicio" id="reservacionServicio6" value="option6">
                                <label class="form-check-label" for="reservacionServicio6">Grupo</label>
                            </div>
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
							<option></option>
							<option>Europeo</option>
							<option>Con Desayuno</option>
							<option>Todo Incluido</option>
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
							<option>1</option>
							<option>2</option>
							<option>3</option>
							<option>4</option>
							<option>5</option>
						</select>
					</div>
                </div>
                <hr class="mb-4">
                <button class="btn btn-primary btn-lg btn-block" type="submit">Guardar</button>
            </form>
        </div>
    </div>
</main>
<?php
require_once('./includes/layout/footer.php');
?>
