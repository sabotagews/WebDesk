<?php
session_start();
require_once('definitions.php');
require_once('./includes/layout/header.php');
require_once('./includes/admin/menu-admin.php');
?>
<main class="container" role="main">
    <div class="container pb-4">
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
                <form class="needs-validation" novalidate="">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="clienteNombre">Nombre</label>
                            <input type="text" class="form-control" id="clienteNombre" placeholder="" value="" required="">
                            <div class="invalid-feedback">
                                El nombre es requerido.
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="clienteApellido">Apellido</label>
                            <input type="text" class="form-control" id="clienteApellido" placeholder="" value="" required="">
                            <div class="invalid-feedback">
                                El apellido es requerido.
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
                            <input type="email" class="form-control" id="clienteMovil" placeholder="10 d&iacute;gitos sin espacios ni separadores" required="">
                            <div class="invalid-feedback">
                                Por favor ingresa un m&oacute;vil v&aacute;lido.
                            </div>
                        </div>
                    </div>
                    <hr class="mb-4">
                    <button class="btn btn-primary btn-lg btn-block" type="submit">Guardar</button>
                </form>
            </div>
        </div>
        <hr>
        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th scope="col" data-sort="string-ins" data-sort-onload="yes">Nombre</th>
                    <th scope="col" data-sort="string-ins">Email</th>
                    <th scope="col" data-sort="int">M&oacute;vil</th>
                    <th scope="col" data-sort="string-ins">Sucursal</th>
                    <th scope="col" data-sort="int">Reservaciones</th>
                </tr>
            </thead>
            <tbody>
                <? for ($i = 0; $i<10; $i++ ) { ?>
                    <tr>
                        <th scope="row"><?= utf8_decode( 'Miguel Gonz&aacute;lez' ); ?></th>
                        <td><a href="miguel@cliente.com">miguel@cliente.com</a></td>
                        <td>4775663245</td>
                        <td><?= utf8_decode( 'Querétaro' ); ?></td>
                        <td>5</td>
                    </tr>
                    <tr>
                        <th scope="row"><?= utf8_decode( 'Laura Jiménez' ); ?></th>
                        <td><a href="laura@cliente.com">laura@cliente.com</a></td>
                        <td>3334564733</td>
                        <td><?= utf8_decode( 'Celaya' ); ?></td>
                        <td>1</td>
                    </tr>
                    <tr>
                        <th scope="row"><?= utf8_decode( 'Arturo Rodríguez' ); ?></th>
                        <td><a href="arturo@cliente.com">arturo@cliente.com</a></td>
                        <td>4424567788</td>
                        <td><?= utf8_decode( 'Irapuato' ); ?></td>
                        <td>2</td>
                    </tr>
                <? } ?>
            </tbody>
        </table>
    </div>
</main>
<?php
require_once('./includes/layout/footer.php');
?>
