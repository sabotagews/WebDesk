<?
session_start();
define( 'S', '/' );
$_SESSION['PATH_HOME']		= str_replace( $arrTmp     , '', strtolower( 'http://'.$_SERVER['SERVER_NAME'] ) ) . S;
$_SESSION['PATH_HOME_REAL']	= strtolower( str_replace( '\\', S, realpath( '.' ) ) ) . S;

$_SESSION['PATH_IMAGES']	= $_SESSION['PATH_HOME'] . 'images/';
$_SESSION['PATH_INCLUDES']	= $_SESSION['PATH_HOME'] . 'includes/';
$_SESSION['PATH_JS']		= $_SESSION['PATH_HOME'] . 'includes/js/';
$_SESSION['PATH_CSS']		= $_SESSION['PATH_HOME'] . 'includes/css/';
$_SESSION['PATH_LAYOUT']	= $_SESSION['PATH_HOME'] . 'includes/layout/';
?>
