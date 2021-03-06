<?php
session_start( );

if( !isset( $_SESSION['currentUser'] ) ) header('location: ./ ');

require_once('definitions.php');
require_once('./includes/layout/header.php');
require_once('./includes/admin/menu-admin.php');
?>
<script type="text/javascript">
window.onload = function( ) { get_sucursales( ); }
</script>
<main class="container" role="main">
    <div class="container pb-4">
        <div class="py-5 text-center">
            <h2>Sucursales</h2>
            <p class="lead">
                Gestiona los datos de las diferentes <strong>sucursales</strong>, para fines de despliegue en cupones de servicio, cotizaciones, notificaciones de correo, y reportes de movimientos y ventas.
            </p>
        </div>
        <div class="form-row">
            <div class="col-md-4 order-md-2 mb-4">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-color">Sucursales</span>
                    <span class="badge badge-secondary badge-pill" id="contador_sucursales"></span>
                </h4>
                <ul class="list-group mb-3" id="listSucursales"></ul>
                <hr class="mb-4">
                <button class="btn btn-secondary btn-lg btn-block" type="submit" onclick="limpia_sucursal();">Nueva</button>
            </div>
            <div class="col-md-8 order-md-1">
                <h4 class="mb-3">Datos de la Sucursal</h4>
                <form class="needs-validation" id="form_sucursales" novalidate="">
					<input type="hidden" name="sucursalId" value="0" />
                    <div class="mb-3">
                        <label for="sucursalNombre">Nombre de la Sucursal</label>
                        <input type="text" class="form-control" id="sucursalNombre" placeholder="" value="" required="">
                        <div class="invalid-feedback">
                            El nombre de la sucursal es requerido.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="sucursalDomicilio">Domicilio</label>
                        <input type="text" class="form-control" id="sucursalDomicilio" placeholder="" value="" required="">
                        <div class="invalid-feedback">
                            El domicilio de la sucursal es requerido.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="sucursalTelefono">Tel&eacute;fono</label>
                        <input type="text" class="form-control" id="sucursalTelefono" placeholder="" required="">
                        <div class="invalid-feedback" style="width: 100%;">
                            El tel&eacute;fono es requerido.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email">Email de la sucursal</label>
                        <input type="email" class="form-control" id="sucursalEmail" placeholder="sucursal@turismosalomon.com.mx" required="">
                        <div class="invalid-feedback">
                            Por favor ingresa un email v&aacute;lido.
                        </div>
                    </div>

                    <hr class="mb-4">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="sucursalStatus">
                        <label class="custom-control-label" for="sucursalStatus">Activo</label>
                    </div>
                    <hr class="mb-4">
					<div class="form-row">
						<div class="col-6">
							<button style="display: none" id="contenedor_eliminiar" class="btn btn-danger btn-lg btn-block" type="button" onclick="delete_sucursal( );">Eliminar</button>
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
