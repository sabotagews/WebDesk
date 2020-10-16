<?php
session_start();
require_once( 'definitions.php' );
require_once('./includes/layout/header.php');
require_once('./includes/admin/menu-admin.php');
?>
<main class="container" role="main">
    <div class="container pb-4">
        <div class="py-5 text-center">
            <h2>Proveedores</h2>
            <p class="lead">Catálogo de los proveedores a quienes Turismo Salomón compra los distintos servicios turísticos, información general, cuentas bancarias, porcentajes de comisión.</p>
        </div>
        
        <div class="row">
            <div class="col-md-4 order-md-2 mb-4">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-color">Proveedores</span>
                    <span class="badge badge-secondary badge-pill" id="contador_Proveedores"></span>
                </h4>
                <ul class="list-group mb-3" id="listProveedores"></ul>
                <hr class="mb-4">
                <button class="btn btn-secondary btn-lg btn-block" type="submit" onclick="limpia_proveedor();">Nuevo</button>
            </div>
            <div class="col-md-8 order-md-1">
                <h4 class="mb-3">Datos del Proveedor</h4>
                <form class="needs-validation" novalidate="" id="form_Proveedores" name="form_Proveedores" onsubmit="event.preventDefault( );guarda_proveedor( );">
					<input type="hidden" name="proveedor_id" value="0" />
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="proveedorRazonSocial">Razón Social</label>
                            <input type="text" class="form-control" id="proveedorRazonSocial" name="proveedorRazonSocial" placeholder="" value="" required="">
                            <div class="invalid-feedback">
                                La Razón Social es requerida.
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="proveedorAlias">Alias</label>
                            <input type="text" class="form-control" id="proveedorAlias" name="proveedorAlias" placeholder="" value="" required="">
                            <div class="invalid-feedback">
                                El Alias es requerido.
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="proveedorDomicilio">Domicilio</label>
                        <input type="text" class="form-control" id="proveedorDomicilio" name="proveedorDomicilio" placeholder="" value="" required="">
                        <div class="invalid-feedback">
                            El Domicilio es requerido.
                        </div>
                    </div>
                    <div class="form-row">
	                    <div class="col-md-6 mb-3">
	                        <label for="proveedorEmail">Email</label>
	                        <input type="email" class="form-control" id="proveedorEmail" name="proveedorEmail" placeholder="proveedor@turismosalomon.com.mx" required="">
	                        <div class="invalid-feedback">
	                            Por favor ingresa un email v&aacute;lido.
	                        </div>
	                    </div>
	                    <div class="col-md-6 mb-3">
	                        <label for="proveedorTelefono">Teléfono</label>
	                        <input type="number" class="form-control no-spinner" id="proveedorTelefono" name="proveedorTelefono" placeholder="10 d&iacute;gitos sin espacios o separadores" required="">
	                        <div class="invalid-feedback">
	                            Por favor ingresa un teléfono v&aacute;lido.
	                        </div>
	                    </div>
                    </div>
                    
                    <hr class="mb-4">
                    <button class="btn btn-primary btn-lg btn-block" type="submit">Guardar</button>
                    <hr class="mb-5">
                    <h4 class="mb-3 mt-5">Cuentas Bancarias del Proveedor</h4>
                    <table class="table table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col" data-sort="string-ins" data-sort-onload="yes">Banco</th>
                                <th scope="col">Cuenta</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="listProveedorCuentas">
                            <? for( $i=0; $i<5; $i++ ) { ?>
                                <? $r = mt_rand(100000000, 999999999); ?>
                                <tr onclick="get_proveedorcuenta( '' );" style="cursor: pointer;">
                                    <th scope="row">BBVA <?= $r; ?></th>
                                    <td><?= $r; ?></td>
                                    <td><a href="" class="btn btn-outline-danger btn-sm">X</a></td>
                                </tr>
                            <? } ?>
                        </tbody>
                    </table>
                    
                    <hr class="mb-4">
                    <div class="form-row">
						<div class="col-md-6 mb-3">
	                  		<label for="proveedorCuentaBanco1">Banco</label>
                            <input type="text" class="form-control" id="proveedorCuentaBanco1" name="proveedorCuentaBanco1" placeholder="" required="">
                            <div class="invalid-feedback">
                                Por favor ingresa un Banco.
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="proveedorCuentaNumero1">Número de Cuenta</label>
                            <input type="number" class="form-control no-spinner" id="proveedorCuentaNumero1" name="proveedorCuentaNumero1" placeholder="Solo números" required="">
                            <div class="invalid-feedback">
                                Por favor ingresa un número de cuenta válido.
                            </div>
                        </div>
                    </div>
                    <div class="clearfix">
                        <a class="btn btn-outline-primary float-right">Agregar Nueva Cuenta</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
<?php
require_once('./includes/layout/footer.php');
?>
