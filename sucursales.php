<?php
session_start();
require_once('definitions.php');
require_once('./includes/layout/header.php');
require_once('./includes/admin/menu-admin.php');
?>
<main class="container" role="main">
    <div class="container pb-4">
        <div class="py-5 text-center">
            <h2>Sucursales</h2>
            <p class="lead">
                Gestiona los datos de las diferentes <strong>sucursales</strong>, para fines de despliegue en cupones de servicio, cotizaciones, notificaciones de correo, y reportes de movimientos y ventas.
            </p>
        </div>
        <div class="row">
            <div class="col-md-4 order-md-2 mb-4">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-color">Sucursales</span>
                    <span class="badge badge-secondary badge-pill">4</span>
                </h4>
                <ul class="list-group mb-3">
                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                        <a class="stretched-link" href="#">
                            <div>
                                <h6 class="my-0"><?= utf8_decode( 'Celaya' ); ?></h6>
                                <small class="text-muted">celaya@turismosalomon.com.mx</small>
                            </div>
                        </a>
                    </li>
                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                        <a class="stretched-link" href="#">
                            <div>
                                <h6 class="my-0"><?= utf8_decode( 'Querétaro' ); ?></h6>
                                <small class="text-muted">queretaro@turismosalomon.com.mx</small>
                            </div>
                        </a>
                    </li>
                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                        <a class="stretched-link" href="#">
                            <div>
                                <h6 class="my-0"><?= utf8_decode( 'Irapuato' ); ?></h6>
                                <small class="text-muted">irapuato@turismosalomon.com.mx</small>
                            </div>
                        </a>
                    </li>
                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                        <a class="stretched-link" href="#">
                            <div>
                                <h6 class="my-0 text-muted"><?= utf8_decode( 'Salamanca' ); ?></h6>
                                <small class="text-muted">salamanca@turismosalomon.com.mx</small>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-md-8 order-md-1">
                <h4 class="mb-3">Datos de la Sucursal</h4>
                <form class="needs-validation" novalidate="">

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
                        <input type="password" class="form-control" id="sucursalTelefono" placeholder="" required="">
                        <div class="invalid-feedback" style="width: 100%;">
                            El tel&eacute;fono es requerido.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email">Email de la sucursal</label>
                        <input type="email" class="form-control" id="usuarioEmail" placeholder="sucursal@turismosalomon.com.mx" required="">
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
                    <button class="btn btn-primary btn-lg btn-block" type="submit">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</main>
<?php
require_once('./includes/layout/footer.php');
?>
