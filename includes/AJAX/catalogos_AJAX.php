<?php
session_start( );

require_once( $_SESSION['PATH_INCLUDES_REAL'] . 'classes/mysql.cls.php' );
require_once( $_SESSION['PATH_INCLUDES_REAL'] . 'scripts/scripts.php' );
require_once( $_SESSION['PATH_INCLUDES_REAL'] . 'classes/usuario.cls.php' );
require_once( $_SESSION['PATH_INCLUDES_REAL'] . 'classes/sucursal.cls.php' );
require_once( $_SESSION['PATH_INCLUDES_REAL'] . 'classes/cliente.cls.php' );
require_once( $_SESSION['PATH_INCLUDES_REAL'] . 'classes/proveedor.cls.php' );
require_once( $_SESSION['PATH_INCLUDES_REAL'] . 'classes/cuenta.cls.php' );
require_once( $_SESSION['PATH_INCLUDES_REAL'] . 'classes/reservacion.cls.php' );

switch( strtolower( $_POST['_data1'] ) ) {

	/*Usuarios*/
	case 'usuarios->get'				:

					$aTmp = array( );
					$html = '';

					$u			= new Usuario( );
					$usuarios	= $u->get_usuario( '%' );

					foreach( $usuarios as $k => $v ) {

						$class	= $v['usuarioStatus'] ? '' : ' text-muted';
						$rol	= $v['usuarioRol']		== 'A' ? 'Administrador' : 'Agente';

						$html .= '<li class="list-group-item d-flex justify-content-between lh-condensed">';
						$html .= '	<a class="stretched-link" href="#" onclick="get_usuario( \'' . $k . '\' );">';
						$html .= '		<div>';
						$html .= '			<h6 class="my-0' . $class . '">' . utf8_decode( $v['usuarioNombre'] . ' ' . $v['usuarioApellido'] ) . '</h6>';
						$html .= '			<small class="text-muted">' . $rol . '</small>';
						$html .= '		</div>';
						$html .= '	</a>';
						$html .= '</li>';

					}

					$aTmp['html']		= $html;
					$aTmp['contador']	= count( $usuarios );

					echo $u->toAJAX( $aTmp, 'json' );

			break;

	case 'usuario->get'					:

					try {

						$u			= new Usuario( );
						$usuario	= $u->get_usuario( $_POST['_data2'] );

					} catch( Exception $e ) {

						//$u->set_error( 'DB', $e->getMessage( ), $e->getMessage( ), $utf8 = true );

					}

					echo $u->toAJAX( $usuario[ $_POST['_data2'] ], 'json' );

			break;

	case 'usuario->set'					:

					try {

						$u		= new Usuario( );
						$u->set_usuario( $_POST );

					} catch( Exception $e ) {

						//$u->set_error( 'DB', $e->getMessage( ), $e->getMessage( ), $utf8 = true );

					}

					echo $u->toAJAX( true, 'json' );

			break;

	case 'usuario->delete'				:

					try {

						$u		= new Usuario( );
						$u->delete_usuario( $_POST['usuarioId'] );

					} catch( Exception $e ) {

						//$u->set_error( 'DB', $e->getMessage( ), $e->getMessage( ), $utf8 = true );

					}

					echo $u->toAJAX( true, 'json' );

			break;
	/*Usuarios*/

	/*Sucursales*/
	case 'sucursales->get'				:

					$aTmp = array( );
					$html = '';

					$u			= new Sucursal( );
					$sucursales	= $u->get_sucursal( '%' );

					foreach( $sucursales as $k => $v ) {

						$class	= $v['sucursalStatus'] ? '' : ' text-muted';

						$html .= '<li class="list-group-item d-flex justify-content-between lh-condensed">';
						$html .= '	<a class="stretched-link" href="#" onclick="get_sucursal( \'' . $k . '\' );">';
						$html .= '		<div>';
						$html .= '			<h6 class="my-0' . $class . '">' . utf8_decode( $v['sucursalNombre'] ) . '</h6>';
						$html .= '			<small class="text-muted">' . utf8_decode( $v['sucursalEmail'] ) . '</small>';
						$html .= '		</div>';
						$html .= '	</a>';
						$html .= '</li>';

					}

					$aTmp['html']		= $html;
					$aTmp['contador']	= count( $sucursales );

					echo $u->toAJAX( $aTmp, 'json' );

			break;

	case 'sucursal->get'				:

					try {

						$u			= new Sucursal( );
						$sucursal	= $u->get_sucursal( $_POST['_data2'] );

					} catch( Exception $e ) {

						//$u->set_error( 'DB', $e->getMessage( ), $e->getMessage( ), $utf8 = true );

					}

					echo $u->toAJAX( $sucursal[ $_POST['_data2'] ], 'json' );

			break;

	case 'sucursal->set'				:

					try {

						$u		= new Sucursal( );
						$u->set_sucursal( $_POST );

					} catch( Exception $e ) {

						//$u->set_error( 'DB', $e->getMessage( ), $e->getMessage( ), $utf8 = true );

					}

					echo $u->toAJAX( true, 'json' );

			break;

	case 'sucursal->delete'				:

					try {

						$u		= new Sucursal( );
						$u->delete_sucursal( $_POST['sucursalId'] );

					} catch( Exception $e ) {

						//$u->set_error( 'DB', $e->getMessage( ), $e->getMessage( ), $utf8 = true );

					}

					echo $u->toAJAX( true, 'json' );

			break;
	/*Sucursales*/

	/*Clientes*/
	case 'clientes->get'				:

					$aTmp = array( );
					$html = '';

					$u			= new Cliente( );
					$clientes	= $u->get_cliente( '%' );

					foreach( $clientes as $k => $v ) {

						$html .= '<tr onclick="get_cliente( \'' . $k . '\' );" style="cursor: pointer;">';
						$html .= '	<th scope="row">' . utf8_decode( $v['clienteNombre'] ) . ' ' . utf8_decode( $v['clienteApellido'] ) . '</th>';
						$html .= '	<td><a href="mailto:' . utf8_decode( $v['clienteEmail'] ) . '">' . utf8_decode( $v['clienteEmail'] ) . '</a></td>';
						$html .= '	<td>' . utf8_decode( $v['clienteMovil'] ) . '</td>';
						$html .= '	<td>' . utf8_decode( $v['sucursalNombre'] ) . '</td>';
						$html .= '	<td></td>';
						$html .= '</tr>';

					}

					$aTmp['html']		= $html;
					$aTmp['contador']	= count( $clientes );

					echo $u->toAJAX( $aTmp, 'json' );

			break;

	case 'clientes->get_select'			:

				$aTmp = array( );
				$html = '<option></option>';

				$u			= new Cliente( );
				$clientes	= $u->get_cliente( '%' );

				foreach( $clientes as $k => $v ) {

					$html .= '<option value="' . $k . '">' . utf8_decode( $v['clienteNombre'] ) . ' ' . utf8_decode( $v['clienteApellido'] ) . '</option>';

				}

				echo $u->toAJAX( $html, 'json' );

		break;

	case 'cliente->get'					:

					try {

						$u			= new Cliente( );
						$cliente	= $u->get_cliente( $_POST['_data2'] );

					} catch( Exception $e ) {

						//$u->set_error( 'DB', $e->getMessage( ), $e->getMessage( ), $utf8 = true );

					}

					echo $u->toAJAX( $cliente[ $_POST['_data2'] ], 'json' );

			break;

	case 'cliente->set'					:

					try {

						$u		= new Cliente( );
						$u->set_cliente( $_POST );

					} catch( Exception $e ) {

						//$u->set_error( 'DB', $e->getMessage( ), $e->getMessage( ), $utf8 = true );

					}

					echo $u->toAJAX( true, 'json' );

			break;

	case 'cliente->delete'				:

					try {

						$u		= new Cliente( );
						$u->delete_cliente( $_POST['clienteId'] );

					} catch( Exception $e ) {

						//$u->set_error( 'DB', $e->getMessage( ), $e->getMessage( ), $utf8 = true );

					}

					echo $u->toAJAX( true, 'json' );

			break;
	/*Clientes*/

	/*Proveedores*/
	case 'proveedores->get'				:

					$aTmp = array( );
					$html = '';

					$u				= new Proveedor( );
					$proveedores	= $u->get_proveedor( '%' );

					foreach( $proveedores as $k => $v ) {

						$class	= '';//$v['usuario_status'] ? '' : ' text-muted';
						//$rol	= $v['usuario_rol']		== 'A' ? 'Administrador' : 'Agente';

						$html .= '<li class="list-group-item d-flex justify-content-between lh-condensed">';
						$html .= '	<a class="stretched-link" href="#" onclick="get_proveedor( \'' . $k . '\' );">';
						$html .= '		<div>';
						$html .= '			<h6 class="my-0' . $class . '">' . utf8_decode( $v['proveedorAlias'] ) . '</h6>';
						$html .= '			<small class="text-muted">' . $v['proveedorRazonSocial'] . '</small>';
						$html .= '		</div>';
						$html .= '	</a>';
						$html .= '</li>';

					}

					$aTmp['html']		= $html;
					$aTmp['contador']	= count( $proveedores );

					echo $u->toAJAX( $aTmp, 'json' );

			break;

	case 'proveedores->get_select'		:

				$aTmp = array( );
				$html = '<option></option>';

				$u				= new Proveedor( );
				$proveedores	= $u->get_proveedor( '%' );

				foreach( $proveedores as $k => $v ) {

					$html .= '<option value="' . $k . '">' . utf8_decode( $v['proveedorAlias'] ) . '</option>';

				}

				echo $u->toAJAX( $html, 'json' );

		break;

	case 'proveedor->get'				:

					try {

						$u			= new Proveedor( );
						$proveedor	= $u->get_proveedor( $_POST['_data2'] );
						$cuentas	= $u->get_proveedor_cuentas( $_POST['_data2'] );

						$htmlCuentas = '';
						foreach( $cuentas as $k => $v ) {

							$htmlCuentas .= '<tr onclick="get_proveedor_cuenta( \'' . $k . '\' );" style="cursor: pointer;">';
							$htmlCuentas .= '	<th scope="row">' . $v['proveedorCuentaAlias'] . ' ' . $v['proveedorCuentaNumero'] . '</th>';
							$htmlCuentas .= '	<td>' . $v['proveedorCuentaNumero'] . '</td>';
							$htmlCuentas .= '	<td><a onclick="delete_proveedor_cuenta( \'' . $k . '\' );" class="btn btn-outline-danger btn-sm">X</a></td>';
							$htmlCuentas .= '</tr>';

						}

						$proveedor[ $_POST['_data2'] ]['cuentasHtml'] = $htmlCuentas;

					} catch( Exception $e ) {

						//$u->set_error( 'DB', $e->getMessage( ), $e->getMessage( ), $utf8 = true );

					}

					echo $u->toAJAX( $proveedor[ $_POST['_data2'] ], 'json' );

			break;

	case 'proveedor->set'				:

					try {

						$u		= new Proveedor( );
						$u->set_proveedor( $_POST );

					} catch( Exception $e ) {

						//$u->set_error( 'DB', $e->getMessage( ), $e->getMessage( ), $utf8 = true );

					}

					echo $u->toAJAX( true, 'json' );

			break;

	case 'proveedor->delete'			:

					try {

						$u		= new Proveedor( );
						$u->delete_proveedor( $_POST['proveedor_id'] );

					} catch( Exception $e ) {

						//$u->set_error( 'DB', $e->getMessage( ), $e->getMessage( ), $utf8 = true );

					}

					echo $u->toAJAX( true, 'json' );

			break;


	case 'proveedor->cuenta->get'		:

					try {

						$u			= new Proveedor( );
						$cuenta		= $u->get_proveedor_cuentas( $_POST['_data2'], $_POST['_data3'] );

					} catch( Exception $e ) {

						//$u->set_error( 'DB', $e->getMessage( ), $e->getMessage( ), $utf8 = true );

					}

					echo $u->toAJAX( $cuenta[ $_POST['_data3'] ], 'json' );

			break;

	case 'proveedor->cuenta->set'		:

					try {

						$u		= new Proveedor( );
						$u->set_proveedor_cuenta( $_POST );

					} catch( Exception $e ) {

						//$u->set_error( 'DB', $e->getMessage( ), $e->getMessage( ), $utf8 = true );

					}

					echo $u->toAJAX( true, 'json' );

			break;

	case 'proveedor->cuenta->delete'	:

					try {

						$u			= new Proveedor( );
						$cuenta		= $u->delete_proveedor_cuenta( $_POST['proveedorCuentaId'] );

					} catch( Exception $e ) {

						//$u->set_error( 'DB', $e->getMessage( ), $e->getMessage( ), $utf8 = true );

					}

					echo $u->toAJAX( true, 'json' );

			break;
	/*Proveedores*/

	/*Cuentas*/
	case 'cuentas->get'					:

					try {

						$u			= new Cuenta( );
						$cuentas	= $u->get_cuenta( );

						$html = '';
						foreach( $cuentas as $k => $v ) {

							$html .= '<li class="list-group-item d-flex justify-content-between lh-condensed">';
							$html .= '	<a class="stretched-link" href="#" onclick="get_cuenta( \'' . $k . '\' );">';
							$html .= '		<div>';
							$html .= '			<h6 class="my-0">' . $v['cuentaAlias'] . '</h6>';
							$html .= '			<small class="text-muted">' . $v['cuentaNumero'] . '</small>';
							$html .= '		</div>';
							$html .= '	</a>';
							$html .= '</li>';

						}

					} catch( Exception $e ) {

						//$u->set_error( 'DB', $e->getMessage( ), $e->getMessage( ), $utf8 = true );

					}

					echo $u->toAJAX( $html, 'json' );

			break;

	case 'cuenta->get'					:

					try {

						$u			= new Cuenta( );
						$cuenta		= $u->get_cuenta( $_POST['_data2'] );

					} catch( Exception $e ) {

						//$u->set_error( 'DB', $e->getMessage( ), $e->getMessage( ), $utf8 = true );

					}

					echo $u->toAJAX( $cuenta[ $_POST['_data2'] ], 'json' );

			break;

	case 'cuenta->set'					:

					try {

						$u		= new Cuenta( );
						$u->set_cuenta( $_POST );

					} catch( Exception $e ) {

						//$u->set_error( 'DB', $e->getMessage( ), $e->getMessage( ), $utf8 = true );

					}

					echo $u->toAJAX( true, 'json' );

			break;

	case 'cuenta->delete'				:

					try {

						$u			= new Cuenta( );
						$u->delete_cuenta( $_POST['cuentaId'] );

					} catch( Exception $e ) {

						//$u->set_error( 'DB', $e->getMessage( ), $e->getMessage( ), $utf8 = true );

					}

					echo $u->toAJAX( true, 'json' );

			break;
	/*Cuentas*/


	/*Reservaciones*/
	case 'reservaciones->get'			:

					try {

						$html			= '';
						$r				= new Reservacion( );
						$reservaciones	= $r->reservaciones_get( );

						foreach( $reservaciones as $k => $v ) {

							$html .= '<tr onclick="get_reservacion( \'' . $k . '\' );" style="cursor: pointer;">';
							$html .= '	<th scope="row">' . $v['reservacionServicioVer'] . '</th>';
							$html .= '	<td>' . $v['reservacionStatusVer'] . '</td>';
							$html .= '	<td>' . $v['reservacionCheckInVer'] . '</td>';
							$html .= '	<td>' . $v['reservacionCheckOutVer'] . '</td>';
							$html .= '	<td><a onclick="delete_reservacion( \'' . $k . '\' );" class="btn btn-outline-danger btn-sm">X</a></td>';
							$html .= '</tr>';

						}

					} catch( Exception $e ) {

						//$u->set_error( 'DB', $e->getMessage( ), $e->getMessage( ), $utf8 = true );

					}

					echo $r->toAJAX( $html, 'json' );

			break;

	case 'reservacion->set'				:

					try {

						$aTmp = array( );
						$r = new Reservacion( );

						$r->begin( );
							$localizador = $r->set_reservacion( $_POST );
						$r->commit( );

						$aTmp['error']			= '0';
						$aTmp['localizador']	= antepon_ceros( $localizador, LOCALIZADOR_LONGITUD );

					} catch( Exception $e ) {

						$r->rollback( );

						$aTmp['error']			= '1';
						$aTmp['error_msg']		= $e->getMessage( );

						//$u->set_error( 'DB', $e->getMessage( ), $e->getMessage( ), $utf8 = true );

					}

					echo $r->toAJAX( $aTmp, 'json' );

			break;

	case 'reservacion->get'				:

					try {

						$aTmp	= array( );
						$r		= new Reservacion( );
						$aTmp	= $r->reservaciones_get( $_POST['_data2'] );

					} catch( Exception $e ) {

						$r->rollback( );

						$aTmp['error']			= '1';
						$aTmp['error_msg']		= $e->getMessage( );

						//$u->set_error( 'DB', $e->getMessage( ), $e->getMessage( ), $utf8 = true );

					}

					echo $r->toAJAX( $aTmp[ $_POST['_data2'] ], 'json' );

			break;

	case 'reservacion->delete'			:

					try {

						$aTmp	= array( );
						$r		= new Reservacion( );
						$aTmp	= $r->delete_reservacion( $_POST['_data2'] );

						$aTmp['error']			= '0';
						$aTmp['error_msg']		= NULL;

					} catch( Exception $e ) {

						//$r->rollback( );

						$aTmp['error']			= '1';
						$aTmp['error_msg']		= $e->getMessage( );

						//$u->set_error( 'DB', $e->getMessage( ), $e->getMessage( ), $utf8 = true );

					}

					echo $r->toAJAX( $aTmp, 'json' );

			break;
	/*Reservaciones*/

}

?>
