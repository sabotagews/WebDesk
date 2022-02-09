<?
session_start( );
define( 'S', '/' );
if( $_SERVER['SERVER_NAME'] == 'webdesk.turismosalomon.com.mx' ) {
	define( 'SSL', 's' );
} else {
	define( 'SSL', 'S' );
}

define('SEPARADOR_FECHA', '/');

$_SESSION['PATH_HOME']			= str_replace( ''     , '', strtolower( 'http' . SSL . '://'. $_SERVER['SERVER_NAME'] ) ) . S;

if( $_SERVER['SERVER_NAME'] == 'localhost' ) {
	$_SESSION['PATH_HOME']			.= 'WebDesk' . S;
}

$_SESSION['PATH_HOME_REAL']		= strtolower( str_replace( '\\', S, realpath( '.' ) ) ) . S;
$_SESSION['PATH_INCLUDES_REAL']	= $_SESSION['PATH_HOME_REAL'] . 'includes/';

$_SESSION['PATH_IMAGES']		= $_SESSION['PATH_HOME'] . 'images/';
$_SESSION['PATH_INCLUDES']		= $_SESSION['PATH_HOME'] . 'includes/';
$_SESSION['PATH_AJAX']			= $_SESSION['PATH_HOME'] . 'includes/ajax/';
$_SESSION['PATH_JS']			= $_SESSION['PATH_HOME'] . 'includes/js/';
$_SESSION['PATH_CSS']			= $_SESSION['PATH_HOME'] . 'includes/css/';
$_SESSION['PATH_LAYOUT']		= $_SESSION['PATH_HOME'] . 'includes/layout/';
$validar_moneda					= '^(?!00+\.00)(?=.{1,9}(\.|$))(?!0(?!\.))\d{1,3}(,\d{3})*(\.\d+)?$';
?>
