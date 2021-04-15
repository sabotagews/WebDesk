<?php
session_start( );

define( 'S', '/' );

require_once( $_SESSION['PATH_INCLUDES_REAL'] . 'classes/mysql.cls.php' );
require_once( $_SESSION['PATH_INCLUDES_REAL'] . 'scripts/scripts.php' );
require_once( $_SESSION['PATH_INCLUDES_REAL'] . 'classes/usuario.cls.php' );
require_once( $_SESSION['PATH_INCLUDES_REAL'] . 'classes/sucursal.cls.php' );
require_once( $_SESSION['PATH_INCLUDES_REAL'] . 'classes/cliente.cls.php' );
require_once( $_SESSION['PATH_INCLUDES_REAL'] . 'classes/proveedor.cls.php' );
require_once( $_SESSION['PATH_INCLUDES_REAL'] . 'classes/cuenta.cls.php' );
require_once( $_SESSION['PATH_INCLUDES_REAL'] . 'classes/reservacion.cls.php' );
require_once( $_SESSION['PATH_INCLUDES_REAL'] . 'classes/reporte.cls.php' );
require_once( $_SESSION['PATH_INCLUDES_REAL'] . 'classes/cobro.cls.php' );
require_once( $_SESSION['PATH_INCLUDES_REAL'] . 'classes/pago.cls.php' );
require_once( $_SESSION['PATH_INCLUDES_REAL'] . 'classes/archivo.cls.php' );

switch( strtolower( $_POST['_data1'] ) ) {


	/*Usuarios*/
	case 'sucursales->get_select'		:

				$aTmp = array( );
				$html = '<option></option>';

				$u			= new Sucursal( );
				$sucursales	= $u->get_sucursal( '%' );

				foreach( $sucursales as $k => $v ) {

					$html .= '<option value="' . $k . '">' . utf8_decode( $v['sucursalNombre'] ) . '</option>';

				}

				echo $u->toAJAX( $html, 'json' );

		break;

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
						$html .= '	<td>' . utf8_decode( $v['conteoReservaciones'] ) . '</td>';
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

						$html .= '<li class="list-group-item d-flex justify-content-between lh-condensed">';
						$html .= '	<a class="stretched-link" href="#" onclick="get_proveedor( \'' . $k . '\' );">';
						$html .= '		<div>';
						$html .= '			<h6 class="my-0">' . utf8_decode( $v['proveedorAlias'] ) . ' [ ' . antepon_ceros( $v['conteoReservaciones'], 2 ) . ' ]' . '</h6>';
						$html .= '			<small class="text-muted">' . $v['proveedorRazonSocial'] . ' -> ' . $v['totalSaldo'] . '</small>';
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

	case 'proveedor->cuentas->get'		:

						try {

							$p				= new Proveedor( );
							$cuentas	= $p->get_proveedor_cuentas( $_POST['proveedorId'], '%' );

						} catch( Exception $e ) {

							//$u->set_error( 'DB', $e->getMessage( ), $e->getMessage( ), $utf8 = true );

						}

						echo $p->toAJAX( $cuentas, 'json' );

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
							$html .= '	<th scope="row">' . antepon_ceros( $v['reservacionId'], 3 ) . '</th>';
							$html .= '	<td>' . $v['reservacionServicioVer'] . '</td>';
							$html .= '	<td>' . $v['reservacionStatusCobro'] . '</td>';
							$html .= '	<td>' . $v['reservacionStatusPago'] . '</td>';
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
							$r->actualiza_saldos( $_POST['clienteId'], $_POST['proveedorId'], $_POST['reservacionId'] );
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


	/*Cobros*/
	case 'pago->reservacion->get'		:
	case 'cobro->reservacion->get'		:

					$aTmp	= array( );
					$r		= new Cobro( );
					$aTmp	= $r->get_reservacion( $_POST['reservacionId'] );

					echo $r->toAJAX( $aTmp, 'json' );

			break;
	case 'cobro->set'					:

					try {

						$aTmp	= array( );
						$r		= new Cobro( );
						$res	= new Reservacion( );

						$r->begin( );

							$cobroId = $r->set_cobro( $_POST );

							if( isset( $_FILES['cobroArchivo'] ) ) {

								$f				= new Archivo( );
								$archivo	= $f->archivo_set( $_FILES['cobroArchivo'], $_SESSION['PATH_HOME_REAL'] . S . 'cobros' . S, antepon_ceros( $cobroId, 4 ) );

								if( $archivo ) {

									$r->set_cobro_archivo( $cobroId, $archivo );

								}

							}

							$r->actualiza_acumulados( $_POST['reservacionId'] );
							$res->actualiza_saldos( $_POST['clienteId'], $_POST['proveedorId'], $_POST['reservacionId'] );

						$r->commit( );
						//$r->rollback( );

						$aTmp['cobroId']	= $cobroId;
						$aTmp['error']		= '0';

					} catch( Exception $e ) {

						$r->rollback( );

						$aTmp['error']		= '1';
						$aTmp['error_msg']	= $e->getMessage( );

					}

					echo $r->toAJAX( $aTmp, 'json' );

			break;
	case 'cobros->get'					:

					$r		= new Cobro( );
					$cobros	= $r->get_cobros( $_POST['reservacionId'] );

					$html  = '';
					$html .= '<thead class="thead-dark">';
					$html .= '	<tr>';
					$html .= '		<th scope="col" data-sort="int" data-sort-onload="yes">Consecutivo</th>';
					$html .= '		<th scope="col" data-sort="string-ins">Fecha Aplicación</th>';
					$html .= '		<th scope="col" data-sort="string-ins">Tipo</th>';
					$html .= '		<th scope="col" data-sort="string-ins">Monto</th>';
					$html .= '		<th scope="col" data-sort="int">Saldo</th>';
					$html .= '		<th scope="col" data-sort="int">Recibo</th>';
					$html .= '	</tr>';
					$html .= '</thead>';

					foreach( $cobros as $k => $v ) {

						$html .= '<tr onclick="get_cobro( \'' . $k . '\' );" style="cursor: pointer;">';
						$html .= '	<th scope="row">' . antepon_ceros( $v['cobroConsecutivo'], 2 ) . '</th>';
						$html .= '	<th>' . $v['cobroFechaAplicacion' ] . '</th>';
						$html .= '	<th>' . COBRO_TIPOS[ $v['cobroTipo'] ] . '</th>';
						$html .= '	<td>$ ' . number_format( $v['cobroMonto'], 2 ) . '</td>';
						$html .= '	<td>$ ' . number_format($v['saldoFinal'], 2 ) . '</td>';
						$html .= '	<td><a href="#" onclick="javascript: ir_a( \'./recibo.php\', \'_blank\', true, \'' . $_POST['reservacionId'] . '\', \'' . $k . '\' , null );">Recibo</a></td>';
						$html .= '</tr>';

					}

					echo $r->toAJAX( $html, 'text' );

			break;
	case 'cobro->get'					:

					$r		= new Cobro( );
					$cobro	= $r->get_cobro( $_POST['cobroId'] );

					echo $r->toAJAX( $cobro, 'json' );

			break;
	case 'cobro->delete'				:

					try {

						$aTmp	= array( );
						$r		= new Cobro( );
						$res	= new Reservacion( );

						$r->begin( );
							$r->cobro_delete( $_POST );
							$r->actualiza_acumulados( $_POST['reservacionId'] );
							$res->actualiza_saldos( $_POST['clienteId'], $_POST['proveedorId'], $_POST['reservacionId'] );
						$r->commit( );

						$aTmp['error'] = '0';

					} catch( Exception $e ) {

						$r->rollback( );

						$aTmp['error']		= '1';
						$aTmp['error_msg']	= $e->getMessage( );

					}

					echo $r->toAJAX( $aTmp, 'json' );

			break;
	/*Cobros*/


	/*Pagos*/
	case 'pago->set'					:

					try {

						$aTmp	= array( );
						$r		= new Pago( );
						$res	= new Reservacion( );

						$r->begin( );

							$pagoId = $r->set_pago( $_POST );

							if( isset( $_FILES['pagoArchivo'] ) ) {

								$f				= new Archivo( );
								$archivo	= $f->archivo_set( $_FILES['pagoArchivo'], $_SESSION['PATH_HOME_REAL'] . S . 'pagos' . S, antepon_ceros( $pagoId, 4 ) );

								if( $archivo ) {

									$r->set_pago_archivo( $pagoId, $archivo );

								}

							}

							$r->actualiza_acumulados( $_POST['reservacionId'] );
							$res->actualiza_saldos( $_POST['clienteId'], $_POST['proveedorId'], $_POST['reservacionId'] );

						$r->commit( );
						//$r->rollback( );

						$aTmp['pagoId']	= $pagoId;
						$aTmp['error']	= '0';

					} catch( Exception $e ) {

						$r->rollback( );

						$aTmp['error']		= '1';
						$aTmp['error_msg']	= $e->getMessage( );

					}

					echo $r->toAJAX( $aTmp, 'json' );

			break;



	case 'pagos->get'					:

					$r		= new Pago( );
					$pagos	= $r->get_pagos( $_POST['reservacionId'] );

					$html  = '';
					$html .= '<thead class="thead-dark">';
					$html .= '	<tr>';
					$html .= '		<th scope="col" data-sort="int" data-sort-onload="yes">Consecutivo</th>';
					$html .= '		<th scope="col" data-sort="string-ins">Fecha Aplicación</th>';
					$html .= '		<th scope="col" data-sort="string-ins">Tipo</th>';
					$html .= '		<th scope="col" data-sort="string-ins">Monto</th>';
					$html .= '		<th scope="col" data-sort="int">Saldo</th>';
					//$html .= '		<th scope="col" data-sort="int">Recibo</th>';
					$html .= '	</tr>';
					$html .= '</thead>';

					foreach( $pagos as $k => $v ) {

						$html .= '<tr onclick="get_pago( \'' . $k . '\' );" style="cursor: pointer;">';
						$html .= '	<th scope="row">' . antepon_ceros( $v['pagoConsecutivo'], 2 ) . '</th>';
						$html .= '	<th>' . $v['pagoFechaAplicacion' ] . '</th>';
						$html .= '	<th>' . PAGO_TIPOS[ $v['pagoTipo'] ] . '</th>';
						$html .= '	<td>$ ' . number_format( $v['pagoMonto'], 2 ) . '</td>';
						$html .= '	<td>$ ' . number_format($v['saldoFinal'], 2 ) . '</td>';
						//$html .= '	<td><a href="#" onclick="javascript: ir_a( \'./recibo.php\', \'_blank\', true, \'' . $_POST['reservacionId'] . '\', \'' . $k . '\' , null );">Recibo</a></td>';
						$html .= '</tr>';

					}

					echo $r->toAJAX( $html, 'text' );

			break;
	case 'pago->get'					:

					$r		= new Pago( );
					$pago	= $r->get_pago( $_POST['pagoId'] );

					echo $r->toAJAX( $pago, 'json' );

			break;
	case 'pago->delete'					:

					try {

						$aTmp	= array( );
						$r		= new Pago( );
						$res	= new Reservacion( );

						$r->begin( );
							$r->pago_delete( $_POST );
							$r->actualiza_acumulados( $_POST['reservacionId'] );
							$res->actualiza_saldos( $_POST['clienteId'], $_POST['proveedorId'], $_POST['reservacionId'] );
						$r->commit( );

						$aTmp['error'] = '0';

					} catch( Exception $e ) {

						$r->rollback( );

						$aTmp['error']		= '1';
						$aTmp['error_msg']	= $e->getMessage( );

					}

					echo $r->toAJAX( $aTmp, 'json' );

			break;
	/*Pagos*/


	/*Autocomplete*/
	case 'reservacion->search'			:

					$r			= new Reporte( );
					$resultado	= $r->reservaciones_search( $_POST['search'] );

					echo $r->toAJAX( $resultado, 'json' );

			break;

	case 'cliente->search'				:

					$r			= new Reporte( );
					$resultado	= $r->cliente_search( $_POST['search'] );

					echo $r->toAJAX( $resultado, 'json' );

			break;
	/*Autocomplete*/


}

?>
