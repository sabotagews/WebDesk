<?php
session_start( );

require_once( $_SESSION['PATH_INCLUDES_REAL'] . 'classes/mysql.cls.php' );
require_once( $_SESSION['PATH_INCLUDES_REAL'] . 'scripts/scripts.php' );
require_once( $_SESSION['PATH_INCLUDES_REAL'] . 'classes/usuario.cls.php' );

switch( strtolower( $_POST['_data1'] ) ) {

	/*Usuarios*/
	case 'usuarios->get'	:

					$aTmp = array( );
					$html = '';

					$u			= new Usuario( );
					$usuarios	= $u->get_usuario( '%' );

					foreach( $usuarios as $k => $v ) {

						$class	= $v['usuario_status'] ? '' : ' text-muted';
						$rol	= $v['usuario_rol']		== 'A' ? 'Administrador' : 'Agente';

						$html .= '<li class="list-group-item d-flex justify-content-between lh-condensed">';
						$html .= '	<a class="stretched-link" href="#" onclick="get_usuario( \'' . $k . '\' );">';
						$html .= '		<div>';
						$html .= '			<h6 class="my-0' . $class . '">' . utf8_decode( $v['usuario_nombre'] . ' ' . $v['usuario_apellido'] ) . '</h6>';
						$html .= '			<small class="text-muted">' . $rol . '</small>';
						$html .= '		</div>';
						$html .= '	</a>';
						$html .= '</li>';

					}

					$aTmp['html']		= $html;
					$aTmp['contador']	= count( $usuarios );

					echo $u->toAJAX( $aTmp, 'json' );

			break;

	case 'usuario->get'		:

					try {

						$u			= new Usuario( );
						$usuario	= $u->get_usuario( $_POST['_data2'] );

					} catch( Exception $e ) {

						//$u->set_error( 'DB', $e->getMessage( ), $e->getMessage( ), $utf8 = true );

					}

					echo $u->toAJAX( $usuario[ $_POST['_data2'] ], 'json' );

			break;

	case 'usuario->set'		:

					try {

						$u		= new Usuario( );
						$u->set_usuario( $_POST );

					} catch( Exception $e ) {

						//$u->set_error( 'DB', $e->getMessage( ), $e->getMessage( ), $utf8 = true );

					}

					echo $u->toAJAX( true, 'json' );

			break;

	case 'usuario->delete'	:

					try {

						$u		= new Usuario( );
						$u->delete_usuario( $_POST['usuario_id'] );

					} catch( Exception $e ) {

						//$u->set_error( 'DB', $e->getMessage( ), $e->getMessage( ), $utf8 = true );

					}

					echo $u->toAJAX( true, 'json' );

			break;
	/*Usuarios*/

}

?>
