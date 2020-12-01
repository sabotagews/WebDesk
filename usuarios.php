<?php
session_start( );

require_once('definitions.php');
if( isset( $_POST['inputEmail'] ) ) {

	require_once( $_SESSION['PATH_INCLUDES_REAL'] . 'classes' . S . 'mysql.cls.php' );
	require_once( $_SESSION['PATH_INCLUDES_REAL'] . 'classes' . S . 'usuario.cls.php' );

	$u = new Usuario( );
	$login = $u->get_login( $_POST['inputEmail'], $_POST['inputPassword'] );

	if( !$login ) {
		header('location: ' . $_SESSION['PATH_HOME'] . '?error=1' );
	}

}
require_once('./includes/layout/header.php');
require_once('./includes/admin/menu-admin.php');
?>
<script type="text/javascript">
window.onload = function( ) {
	get_sucursales_select( );
	get_usuarios( );
}
</script>
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
                    <span class="badge badge-secondary badge-pill" id="contador_usuarios"></span>
                </h4>
                <ul class="list-group mb-3" id="listUsuarios"></ul>
                <hr class="mb-4">
                <button class="btn btn-secondary btn-lg btn-block" type="submit" onclick="limpia_usuario();">Nuevo</button>
            </div>
            <div class="col-md-8 order-md-1">
                <h4 class="mb-3">Datos del usuario</h4>
                <form class="needs-validation" novalidate="" id="form_usuarios" name="form_usuarios">

					<input type="hidden" name="usuarioId" value="0" />

                    <div class="form-row">
						<div class="col-md-6 mb-3">
	                        <label for="sucursalId">Sucursal</label>
	                        <select class="custom-select" id="sucursalId" onchange="" required></select>
	                    </div>
                        <div class="col-md-6 mb-3">
                            <label for="usuarioNombre">Nombre</label>
                            <input type="text" class="form-control" id="usuarioNombre" name="usuarioNombre" placeholder="" value="" required="">
                            <div class="invalid-feedback">
                                El nombre es requerido.
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="usuarioApellido">Apellido</label>
                            <input type="text" class="form-control" id="usuarioApellido" name="usuarioApellido" placeholder="" value="" required="">
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
                            <input type="text" class="form-control" id="usuarioUsername" name="usuarioUsername" placeholder="username" required="">
                            <div class="invalid-feedback" style="width: 100%;">
                                El username es requerido.
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="usuarioPassword">Password</label>
                        <input type="password" class="form-control" id="usuarioPassword" name="usuarioPassword" placeholder="" required="">
                        <div class="invalid-feedback" style="width: 100%;">
                            El password es requerido.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="usuarioEmail">Email</label>
                        <input type="email" class="form-control" id="usuarioEmail" name="usuarioEmail" placeholder="usuario@turismosalomon.com.mx" required="">
                        <div class="invalid-feedback">
                            Por favor ingresa un email v&aacute;lido.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="text">M&oacute;vil</label>
                        <input type="text" class="form-control" id="usuarioMovil" name="usuarioMovil" placeholder="10 d&iacute;gitos sin espacios ni separadores" required="">
                        <div class="invalid-feedback">
                            Por favor ingresa un m&oacute;vil v&aacute;lido.
                        </div>
                    </div>

                    <hr class="mb-4">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="usuarioStatus" name="usuarioStatus">
                        <label class="custom-control-label" for="usuarioStatus">Activo</label>
                    </div>
                    <hr class="mb-4">

                    <div class="d-block my-3">
                        <div class="custom-control custom-radio">
                            <input id="admin" name="usuarioRol" type="radio" class="custom-control-input" value="A" required="">
                            <label class="custom-control-label" for="admin">Administrador</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input id="agent" name="usuarioRol" type="radio" class="custom-control-input" value="" required="">
                            <label class="custom-control-label" for="agent">Agente</label>
                        </div>
                    </div>
                    <hr class="mb-4">
					<div class="form-row">
						<div class="col-6">
							<button style="display: none" id="contenedor_eliminiar" class="btn btn-danger btn-lg btn-block" type="button" onclick="delete_usuario( );">Eliminar</button>
                    	</div>
						<div class="col-6">
							<button class="btn btn-primary btn-lg btn-block" id="submit_usuarios" type="submit">Guardar</button>
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
