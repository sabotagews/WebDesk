<?php
session_start();
require_once('definitions.php');
require_once('./includes/layout/header.php');
require_once('./includes/admin/menu-admin.php');
?>
<script type="text/javascript">
    window.onload = function() {
        get_clientes( );
    }

</script>
<main class="container" role="main">
    <div class="py-5 text-center">
        <h2>Clientes</h2>
        <p class="lead">Cat&aacute;logo hist&oacute;rico con los datos de los pasajeros que han sido registrados ya sea por cotizaci&oacute;n o reservaci&oacute;n efectiva, permitir&aacute; dar seguimiento efectivo, prospecci&oacute;n a futuro y contacto v&iacute;a <strong>Tel&eacute;fono, Email y WhatsApp.</strong></p>
    </div>
    <form class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="search" placeholder="Buscar cliente" aria-label="Buscar">
        <button class="btn btn-primary my-2 my-sm-0 loupe" type="submit">Buscar</button>
    </form>
    <hr class="mb-4">
    <div class="row">
        <div class="col-md-12">
            <h4 class="mb-3">Informaci&oacute;n del cliente</h4>
            <form id="form_clientes" class="needs-validation" novalidate="">
                <input type="hidden" name="clienteId" value="0" />
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="clienteNombre">Nombre(s)</label>
                        <input type="text" class="form-control" id="clienteNombre" placeholder="" value="" required="">
                        <div class="invalid-feedback">
                            El nombre es requerido.
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="clienteApellido">Apellidos</label>
                        <input type="text" class="form-control" id="clienteApellido" placeholder="" value="" required="">
                        <div class="invalid-feedback">
                            Los apellidos son requerido.
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="clienteEmail">Email</label>
                        <input type="email" class="form-control" id="clienteEmail" placeholder="cliente@dominio.com" required="">
                        <div class="invalid-feedback">
                            Por favor ingresa un email v&aacute;lido.
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="clienteMovil">M&oacute;vil</label>
                        <input type="text" class="form-control" id="clienteMovil" placeholder="10 d&iacute;gitos sin espacios ni separadores" required="">
                        <div class="invalid-feedback">
                            Por favor ingresa un m&oacute;vil v&aacute;lido.
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-9 mb-3">
                        <label for="clienteDomicilio">Domicilio</label>
                        <input type="text" class="form-control" id="clienteDomicilio">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="clienteFechaNacimiento">Fecha de Nacimiento</label>
                        <input type="date" class="form-control" id="clienteFechaNacimiento">
                    </div>
                </div>
                <hr class="mb-4">
                <div class="form-row">
                    <div style="display: none" class="col-2" id="contenedor_eliminiar">
                        <button class="btn btn-danger btn-lg btn-block" type="button" onclick="delete_cliente( );">Eliminar</button>
                    </div>
                    <div style="display: none" class="col-2" id="contenedor_nuevo">
                        <button class="btn btn-secondary btn-lg btn-block" type="button" onclick="limpia_cliente( );">Nuevo</button>
                    </div>
                    <div class="col-8">
                        <button class="btn btn-primary btn-lg btn-block" type="submit">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <hr>
    <table class="table table-striped table-hover">
        <thead class="thead-dark">
            <tr>
                <th scope="col" data-sort="string-ins" data-sort-onload="yes">Nombre</th>
                <th scope="col" data-sort="string-ins">Email</th>
                <th scope="col" data-sort="int">M&oacute;vil</th>
                <th scope="col" data-sort="int">Reservaciones</th>
            </tr>
        </thead>
        <tbody id="listClientes"></tbody>
    </table>

</main>
<?php
require_once('./includes/layout/footer.php');
?>
