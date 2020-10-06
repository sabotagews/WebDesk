<?php
session_start();
require_once( 'definitions.php' );
if( isset( $_POST['inputEmail'] ) ) {

	require_once( $_SESSION['PATH_INCLUDES_REAL'] . 'classes' . S . 'mysql.cls.php' );
	require_once( $_SESSION['PATH_INCLUDES_REAL'] . 'classes' . S . 'usuario.cls.php' );

	$u = new Usuario( );
	$login = $u->get_login( $_POST['inputEmail'], $_POST['inputPassword'] );

	if( $login == 1 || $login == 2 ) {
		header('location: ' . $_SESSION['PATH_HOME'] . '?error=' . $login );
	}

}
require_once('./includes/layout/header.php');
require_once('./includes/admin/menu-admin.php');
?>
<main class="container" role="main">
	<div class="mt-5 mx-auto" style="width: 300px;">
		<h1>HOLA <?= $_SESSION['currentUser']['usuario_nombre']; ?>!</h1>
	</div>
</main>
<?php
require_once('./includes/layout/footer.php');
?>
