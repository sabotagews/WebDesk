<?php
session_start();
require_once('definitions.php');
require_once('./includes/layout/header.php');
require_once('./includes/admin/menu-admin.php');
?>
<main class="container" role="main">
    <div class="container pb-4">
        <div class="py-5 text-center">
            <h2>Usuarios</h2>
            <p class="lead">Son los colaboradores de Turismo Salom&oacute;n que podr&aacute;n hacer uso de la plataforma y ser&aacute;n distinguidos seg&uacute;n su rol: <strong>Administrador o Agente.</strong></p>
        </div>
        <div class="row">
            <div class="col-md-4 order-md-2 mb-4">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-color">Usuarios</span>
                    <span class="badge badge-secondary badge-pill">5</span>
                </h4>
                <ul class="list-group mb-3">
                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                        <a class="stretched-link" href="#">
                            <div>
                                <h6 class="my-0"><?= utf8_decode( 'América Salomón' ); ?></h6>
                                <small class="text-muted">Aministrador</small>
                            </div>
                        </a>
                    </li>
                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                        <a class="stretched-link" href="#">
                            <div>
                                <h6 class="my-0"><?= utf8_decode( 'Elizabeth Salomón' ); ?></h6>
                                <small class="text-muted">Aministrador</small>
                            </div>
                        </a>
                    </li>
                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                        <a class="stretched-link" href="#">
                            <div>
                                <h6 class="my-0"><?= utf8_decode( 'Paulina López' ); ?></h6>
                                <small class="text-muted">Agente</small>
                            </div>
                        </a>
                    </li>
                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                        <a class="stretched-link" href="#">
                            <div>
                                <h6 class="my-0 text-muted">Carlos Morales</h6>
                                <small class="text-muted">Agente</small>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-md-8 order-md-1">
                <h4 class="mb-3">Datos del usuario</h4>
                <form class="needs-validation" novalidate="">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="usuarioNombre">Nombre</label>
                            <input type="text" class="form-control" id="usuarioNombre" placeholder="" value="" required="">
                            <div class="invalid-feedback">
                                El nombre es requerido.
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="usuarioApellido">Apellido</label>
                            <input type="text" class="form-control" id="usuarioApellido" placeholder="" value="" required="">
                            <div class="invalid-feedback">
                                El apellido es requerido.
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="usuarioUsername">Username</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">@</span>
                            </div>
                            <input type="text" class="form-control" id="usuarioUsername" placeholder="Username" required="">
                            <div class="invalid-feedback" style="width: 100%;">
                                El username es requerido.
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="usuarioPassword">Password</label>
                        <input type="password" class="form-control" id="usuarioPassword" placeholder="" required="">
                        <div class="invalid-feedback" style="width: 100%;">
                            El password es requerido.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="usuarioEmail">Email</label>
                        <input type="email" class="form-control" id="usuarioEmail" placeholder="tu@dominio.com" required="">
                        <div class="invalid-feedback">
                            Por favor ingresa un email válido.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="usuarioMovil">M&oacute;vil</label>
                        <input type="email" class="form-control" id="usuarioMovil" placeholder="tu@dominio.com" required="">
                        <div class="invalid-feedback">
                            Por favor ingresa un email válido.
                        </div>
                    </div>

                    <hr class="mb-4">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="usuarioStatus">
                        <label class="custom-control-label" for="usuarioStatus">Activo</label>
                    </div>
                    <hr class="mb-4">

                    <div class="d-block my-3">
                        <div class="custom-control custom-radio">
                            <input id="credit" name="rolUsuario" type="radio" class="custom-control-input" required="">
                            <label class="custom-control-label" for="credit">Administrador</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input id="debit" name="rolUsuario" type="radio" class="custom-control-input" checked="" required="">
                            <label class="custom-control-label" for="debit">Agente</label>
                        </div>
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
