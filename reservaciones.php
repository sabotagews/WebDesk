<?php
session_start();
require_once( 'definitions.php' );
require_once('./includes/layout/header.php');
require_once('./includes/admin/menu-admin.php');
?>
<main class="container" role="main">
    <div class="py-5 text-center">
        <h2>Reservaciones</h2>
        <p class="lead">Formulario para carga de una cotización o reservación.</p>
    </div>

    <div class="row">
        <div class="col order-md-1">
            <h4 class="mb-3">Datos de la Reservación</h4>
            <form class="needs-validation" novalidate="" id="form_Reservacion" name="form_Reservacion" onsubmit="">
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="reservacionCliente">Cliente</label>
                        <select class="custom-select" id="reservacionCliente">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                        </select>
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
            </form>
        </div>
    </div>
</main>
<?php
require_once('./includes/layout/footer.php');
?>
