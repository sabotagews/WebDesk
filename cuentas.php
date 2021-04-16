<?php
session_start();
require_once( 'definitions.php' );
require_once('./includes/layout/header.php');
require_once('./includes/admin/menu-admin.php');
?>
<script type="text/javascript">
window.onload = function( ) { get_cuentas( ); }
</script>
<main class="container" role="main">

    <div class="py-5 text-center">
        <h2>Cuentas</h2>
        <p class="lead">Catálogo de las cuentas bancarias de Turismo Salomón con las cuales hace los pagos a proveedores y recibr cobros de reservaciones.</p>
    </div>

    <div class="row">
        <div class="col-md-4 order-md-2 mb-4">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-color">Cuentas</span>
                <span class="badge badge-secondary badge-pill" id="contador_Proveedores"></span>
            </h4>
            <ul class="list-group mb-3" id="listCuentas"></ul>
            <hr class="mb-4">
            <button class="btn btn-secondary btn-lg btn-block" type="submit" onclick="limpia_cuenta( );">Nueva</button>
        </div>
        <div class="col-md-8 order-md-1">

			<div id="contenedor_cuentas">
	            <h4 class="mb-3 mt-5">Cuentas Bancarias de Turismo Salomón</h4>
				<form class="needs-validation" novalidate="" id="form_cuentas" name="form_cuentas">
					<input type="hidden" name="cuentaId" value="0" />
	                <hr class="mb-4">
	                <div class="form-row">
	                    <div class="col-md-6 mb-3">
	                        <label for="cuentaBanco1">Banco</label>
	                        <input type="text" class="form-control" id="cuentaAlias" name="cuentaAlias" placeholder="" required="">
	                        <div class="invalid-feedback">
	                            Por favor ingresa un Banco.
	                        </div>
	                    </div>
	                    <div class="col-md-6 mb-3">
	                        <label for="proveedorCuentaNumero1">Número de Cuenta</label>
	                        <input type="number" class="form-control no-spinner" id="cuentaNumero" name="cuentaNumero" placeholder="Solo números" required="">
	                        <div class="invalid-feedback">
	                            Por favor ingresa un número de cuenta válido.
	                        </div>
	                    </div>
	                </div>
	                <div class="form-row">
		                <div class="col-6">
							<button class="btn btn-danger btn-lg btn-block" type="button" onclick="delete_cuenta( );" id="btn_eliminar" style="display: none">Eliminar</button>
		                </div>
		                <div class="col-6">
							<button class="btn btn-primary btn-lg btn-block" type="submit">Guardar</button>
		                </div>
	                </div>
				</form>
			</div>

        </div>
    </div>

</main>
<?php
require_once('./includes/layout/footer.php');
?>
