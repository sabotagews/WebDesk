<?php
session_start( );

require_once( $_SESSION['PATH_INCLUDES_REAL'] . 'classes' . S . 'mysql.cls.php' );
require_once( $_SESSION['PATH_INCLUDES_REAL'] . 'scripts' . S . 'scripts.php' );
require_once( $_SESSION['PATH_INCLUDES_REAL'] . 'classes' . S . 'usuario.cls.php' );
require_once( $_SESSION['PATH_INCLUDES_REAL'] . 'classes' . S . 'sucursal.cls.php' );
require_once( $_SESSION['PATH_INCLUDES_REAL'] . 'classes' . S . 'cliente.cls.php' );

header('Content-type: text/html; charset=iso-8859-1');
?>
<!doctype html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="<?= $_SESSION['PATH_CSS']; ?>jquery-ui.min.css">
		<link rel="stylesheet" href="<?= $_SESSION['PATH_CSS']; ?>bootstrap.min.css">
		<link rel="stylesheet" href="<?= $_SESSION['PATH_CSS']; ?>webdesk.css">
		<link rel="apple-touch-icon" sizes="180x180" href="<?= $_SESSION['PATH_HOME']; ?>WebDesk.svg">
		<link rel="icon" type="image/svg+xml" href="<?= $_SESSION['PATH_HOME']; ?>WebDesk.png">
		<link rel="alternate icon" href="<?= $_SESSION['PATH_HOME']; ?>WebDesk.png">
		<link rel="mask-icon" href="<?= $_SESSION['PATH_HOME']; ?>WebDesk.png">
		<title>WebDesk Turismo Salom&oacute;n</title>
		<script type="text/javascript">

			var AJAX_catalogos_url = '<?= $_SESSION['PATH_AJAX'] . 'catalogos_AJAX.php'; ?>';

			function g( name ) {
				var obj = document.getElementsByName( name );
				if( !obj[ 0 ] ) {
					var obj = document.getElementById( name );
					if( !obj ) {
						alert('No se encuentra el objeto \'' + name + '\' \n\n function g( \'' + name + '\' ) ');
						return false;
					} else {
						return obj;
					}
				} else {
					return obj[ 0 ];
				}
			}
			function ir_a( url, target, submit, _data0, _data1, _data2 ) {

					if( submit ) {

						g('_data0').value	= _data0;
						g('_data1').value	= _data1;
						g('_data2').value	= _data2;

						g('form').action	= url;
						g('form').target	= target;

						g('form').submit( );

					} else {

						g('document').location = url;

					}

			}

			/*Clientes*/
			function limpia_cliente( ) {

				g( 'form_clientes' ).reset( );
				$( '#form_clientes' ).removeClass( 'was-validated' );
				g( 'clienteId' ).value	= '0';

				$('#contenedor_eliminiar').hide( );
				$('#contenedor_nuevo').hide( );

			}
			function get_cliente( clienteId ) {

				var datos			= {};
					datos._data1	= 'cliente->get';
					datos._data2	= clienteId;

				$.ajax(

						{

							url			:	AJAX_catalogos_url	,
							type		:	'POST'				,
							dataType	:	'JSON'				,
							data		:	datos				,
							beforeSend	:	function( ) {}		,
							success		:	function( objJSON ) {

												g('clienteId').value				= objJSON.clienteId;

												g('clienteNombre').value			= objJSON.clienteNombre;
												g('clienteApellido').value			= objJSON.clienteApellido;
												g('clienteEmail').value				= objJSON.clienteEmail;
												g('clienteMovil').value				= objJSON.clienteMovil;

												g('clienteDomicilio').value			= objJSON.clienteDomicilio;
												g('clienteFechaNacimiento').value	= objJSON.clienteFechaNacimiento;

												$('#contenedor_eliminiar').show( );
												$('#contenedor_nuevo').show( );

											}

						}

					);

			}
			function get_clientes( ) {

				g('listClientes').innerHTML = '';

				var datos					= {};
					datos._data1			= 'clientes->get';

				$.ajax(

						{

							url			:	AJAX_catalogos_url	,
							type		:	'POST'				,
							dataType	:	'JSON'				,
							data		:	datos				,
							beforeSend	:	function( ) {}		,
							success		:	function( objJSON ) {

												g('listClientes').innerHTML = objJSON.html;

											}

						}

					);

			}
			function guarda_cliente( ) {

				var datos							= {};
					datos._data1					= 'cliente->set';

					datos.clienteId					= g('clienteId').value;

					datos.clienteNombre				= g('clienteNombre').value;
					datos.clienteApellido			= g('clienteApellido').value;
					datos.clienteEmail				= g('clienteEmail').value;
					datos.clienteMovil				= g('clienteMovil').value;
					datos.clienteDomicilio			= g('clienteDomicilio').value;
					datos.clienteFechaNacimiento	= g('clienteFechaNacimiento').value;

				$.ajax(

						{

							url			:	AJAX_catalogos_url	,
							type		:	'POST'				,
							dataType	:	'JSON'				,
							data		:	datos				,
							beforeSend	:	function( ) {}		,
							success		:	function( objJSON ) {

												get_clientes( );
												limpia_cliente( );

											}

						}

					);

			}
			function delete_cliente( ) {

				if( !confirm( '¿Desea eliminar el cliente?' ) ) return;

				var datos			= {};
					datos._data1	= 'cliente->delete';
					datos.clienteId	= g('clienteId').value;

				$.ajax(

						{

							url			:	AJAX_catalogos_url	,
							type		:	'POST'				,
							dataType	:	'JSON'				,
							data		:	datos				,
							beforeSend	:	function( ) {}		,
							success		:	function( objJSON ) {

												limpia_cliente( );
												get_clientes( );

											}

						}

					);

			}
			/*Clientes*/

			/*Usuarios*/
			function limpia_usuario( ) {

				g( 'form_usuarios' ).reset( );
				$( '#form_usuarios' ).removeClass( 'was-validated' );
				g( 'usuarioId' ).value		= '0';

				$('#contenedor_eliminiar').hide( );

			}
			function get_usuario( usuarioId ) {

				var datos			= {};
					datos._data1	= 'usuario->get';
					datos._data2	= usuarioId;

				$.ajax(

						{

							url			:	AJAX_catalogos_url	,
							type		:	'POST'				,
							dataType	:	'JSON'				,
							data		:	datos				,
							beforeSend	:	function( ) {}		,
							success		:	function( objJSON ) {

												$('#sucursalId').val( objJSON.sucursalId );

												g('usuarioId').value		= objJSON.usuarioId;

												g('usuarioNombre').value	= objJSON.usuarioNombre;
												g('usuarioApellido').value	= objJSON.usuarioApellido;
												g('usuarioUsername').value	= objJSON.usuarioUsername;
												g('usuarioPassword').value	= objJSON.usuarioPassword;
												g('usuarioEmail').value		= objJSON.usuarioEmail;
												g('usuarioMovil').value		= objJSON.usuarioMovil;

												g('usuarioStatus').checked	= objJSON.usuario_status == '0' ? false : true;

												if( objJSON.usuarioRol == 'A' ) {
													document.form_usuarios.usuarioRol[ 0 ].checked	= true;
													document.form_usuarios.usuarioRol[ 1 ].checked	= false;
												} else {
													document.form_usuarios.usuarioRol[ 0 ].checked	= false;
													document.form_usuarios.usuarioRol[ 1 ].checked	= true;
												}

												$('#contenedor_eliminiar').show( );

											}

						}

					);

			}
			function get_usuarios( ) {

				g('listUsuarios').innerHTML = '';

				var datos					= {};
					datos._data1			= 'usuarios->get';

				$.ajax(

						{

							url			:	AJAX_catalogos_url	,
							type		:	'POST'				,
							dataType	:	'JSON'				,
							data		:	datos				,
							beforeSend	:	function( ) {}		,
							success		:	function( objJSON ) {

												g('listUsuarios').innerHTML			= objJSON.html;
												g('contador_usuarios').innerHTML	= objJSON.contador;

											}

						}

					);

			}
			function guarda_usuario( ) {

				var datos					= {};
					datos._data1			= 'usuario->set';
					datos.usuarioId			= g('usuarioId').value;

					datos.sucursalId		= g('sucursalId').value;
					datos.usuarioNombre		= g('usuarioNombre').value;
					datos.usuarioApellido	= g('usuarioApellido').value;
					datos.usuarioUsername	= g('usuarioUsername').value;
					datos.usuarioPassword	= g('usuarioPassword').value;
					datos.usuarioEmail		= g('usuarioEmail').value;
					datos.usuarioMovil		= g('usuarioMovil').value;
					datos.usuarioStatus		= g('usuarioStatus').checked ? '1' : '0';
					datos.usuarioRol		= $('input[name=usuarioRol]:checked').val( );

				$.ajax(

						{

							url			:	AJAX_catalogos_url	,
							type		:	'POST'				,
							dataType	:	'JSON'				,
							data		:	datos				,
							beforeSend	:	function( ) {}		,
							success		:	function( objJSON ) {

												get_usuarios( );
												limpia_usuario( );

											}

						}

					);

			}
			function delete_usuario( ) {

				if( !confirm( '¿Desea eliminar el usuario?' ) ) return;

				var datos			= {};
					datos._data1	= 'usuario->delete';
					datos.usuarioId	= g('usuarioId').value;

				$.ajax(

						{

							url			:	AJAX_catalogos_url	,
							type		:	'POST'				,
							dataType	:	'JSON'				,
							data		:	datos				,
							beforeSend	:	function( ) {}		,
							success		:	function( objJSON ) {

												limpia_usuario( );
												get_usuarios( );

											}

						}

					);

			}
			function get_sucursales_select( ) {

				g('sucursalId').innerHTML = '';

				var datos					= {};
					datos._data1			= 'sucursales->get_select';

				$.ajax(

						{

							url			:	AJAX_catalogos_url	,
							type		:	'POST'				,
							dataType	:	'JSON'				,
							data		:	datos				,
							beforeSend	:	function( ) {}		,
							success		:	function( objJSON ) {

												g('sucursalId').innerHTML = objJSON;

											}

						}

					);

			}
			/*Usuarios*/

			/*Sucursales*/
			function limpia_sucursal( ) {

				g( 'form_sucursales' ).reset( );
				$( '#form_sucursales' ).removeClass( 'was-validated' );
				g( 'sucursalId' ).value	= '0';

				$('#contenedor_eliminiar').hide( );

			}
			function get_sucursal( sucursalId ) {

				var datos			= {};
					datos._data1	= 'sucursal->get';
					datos._data2	= sucursalId;

				$.ajax(

						{

							url			:	AJAX_catalogos_url	,
							type		:	'POST'				,
							dataType	:	'JSON'				,
							data		:	datos				,
							beforeSend	:	function( ) {}		,
							success		:	function( objJSON ) {

												g('sucursalId').value			= objJSON.sucursalId;

												g('sucursalNombre').value		= objJSON.sucursalNombre;
												g('sucursalDomicilio').value	= objJSON.sucursalDomicilio;
												g('sucursalTelefono').value		= objJSON.sucursalTelefono;
												g('sucursalEmail').value		= objJSON.sucursalEmail;

												g('sucursalStatus').checked		= objJSON.sucursalStatus == '0' ? false : true;

												$('#contenedor_eliminiar').show( );

											}

						}

					);

			}
			function get_sucursales( ) {

				g('listSucursales').innerHTML = '';

				var datos					= {};
					datos._data1			= 'sucursales->get';

				$.ajax(

						{

							url			:	AJAX_catalogos_url	,
							type		:	'POST'				,
							dataType	:	'JSON'				,
							data		:	datos				,
							beforeSend	:	function( ) {}		,
							success		:	function( objJSON ) {

												g('listSucursales').innerHTML			= objJSON.html;
												g('contador_sucursales').innerHTML	= objJSON.contador;

											}

						}

					);

			}
			function guarda_sucursal( ) {

				var datos					= {};
					datos._data1			= 'sucursal->set';

					datos.sucursalId		= g('sucursalId').value;

					datos.sucursalNombre	= g('sucursalNombre').value;
					datos.sucursalDomicilio	= g('sucursalDomicilio').value;
					datos.sucursalTelefono	= g('sucursalTelefono').value;
					datos.sucursalEmail		= g('sucursalEmail').value;
					datos.sucursalStatus	= g('sucursalStatus').checked ? '1' : '0';

				$.ajax(

						{

							url			:	AJAX_catalogos_url	,
							type		:	'POST'				,
							dataType	:	'JSON'				,
							data		:	datos				,
							beforeSend	:	function( ) {}		,
							success		:	function( objJSON ) {

												get_sucursales( );
												limpia_sucursal( );

											}

						}

					);

			}
			function delete_sucursal( ) {

				if( !confirm( '¿Desea eliminar el la sucursal?' ) ) return;

				var datos				= {};
					datos._data1		= 'sucursal->delete';
					datos.sucursalId	= g('sucursalId').value;

				$.ajax(

						{

							url			:	AJAX_catalogos_url	,
							type		:	'POST'				,
							dataType	:	'JSON'				,
							data		:	datos				,
							beforeSend	:	function( ) {}		,
							success		:	function( objJSON ) {

												limpia_sucursal( );
												get_sucursales( );

											}

						}

					);

			}
			/*Sucursales*/

			/*Proveedores*/
			function limpia_proveedor( ) {

				g( 'form_Proveedores' ).reset( );
				$( '#form_Proveedores' ).removeClass( 'was-validated' );
				g( 'proveedorId' ).value = '0';

				$('#contenedor_eliminiar').hide( );
				$('#contenedor_cuentas').hide( );

			}
			function get_proveedor( proveedorId ) {

				var datos			= {};
					datos._data1	= 'proveedor->get';
					datos._data2	= proveedorId;

				$.ajax(

						{

							url			:	AJAX_catalogos_url	,
							type		:	'POST'				,
							dataType	:	'JSON'				,
							data		:	datos				,
							beforeSend	:	function( ) {}		,
							success		:	function( objJSON ) {

												g('proveedorId').value			= objJSON.proveedorId;

												g('proveedorRazonSocial').value	= objJSON.proveedorRazonSocial;
												g('proveedorAlias').value		= objJSON.proveedorAlias;
												g('proveedorDomicilio').value	= objJSON.proveedorDomicilio;
												g('proveedorEmail').value		= objJSON.proveedorEmail;
												g('proveedorTelefono').value	= objJSON.proveedorTelefono;

												limpia_proveedor_cuentas( );

												g('listProveedorCuentas').innerHTML = objJSON.cuentasHtml;
												$('#contenedor_cuentas').show( );

												$('#contenedor_eliminiar').show( );

											}

						}

					);

			}
			function get_proveedores( ) {

				g('listProveedores').innerHTML = '';

				var datos			= {};
					datos._data1	= 'proveedores->get';

				$.ajax(

						{

							url			:	AJAX_catalogos_url	,
							type		:	'POST'				,
							dataType	:	'JSON'				,
							data		:	datos				,
							beforeSend	:	function( ) {}		,
							success		:	function( objJSON ) {

												g('listProveedores').innerHTML		= objJSON.html;
												g('contador_Proveedores').innerHTML	= objJSON.contador;

											}

						}

					);

			}
			function guarda_proveedor( ) {

				var datos						= {};
					datos._data1				= 'proveedor->set';

					datos.proveedorId			= g('proveedorId').value;

					datos.proveedorRazonSocial	= g('proveedorRazonSocial').value;
					datos.proveedorAlias		= g('proveedorAlias').value;
					datos.proveedorDomicilio	= g('proveedorDomicilio').value;
					datos.proveedorEmail		= g('proveedorEmail').value;
					datos.proveedorTelefono		= g('proveedorTelefono').value;

				$.ajax(

						{

							url			:	AJAX_catalogos_url	,
							type		:	'POST'				,
							dataType	:	'JSON'				,
							data		:	datos				,
							beforeSend	:	function( ) {}		,
							success		:	function( objJSON ) {

												get_proveedores( );
												limpia_proveedor( );

											}

						}

					);

			}
			function delete_proveedor( ) {

				if( !confirm( '¿Desea eliminar el proveedor?' ) ) return;

				var datos				= {};
					datos._data1		= 'proveedor->delete';
					datos.proveedorId	= g('proveedorId').value;

				$.ajax(

						{

							url			:	AJAX_catalogos_url	,
							type		:	'POST'				,
							dataType	:	'JSON'				,
							data		:	datos				,
							beforeSend	:	function( ) {}		,
							success		:	function( objJSON ) {

												limpia_proveedor( );
												get_proveedores( );

											}

						}

					);

			}

			function limpia_proveedor_cuentas( ) {

				g( 'form_proveedorCuentas' ).reset( );
				$( '#form_proveedorCuentas' ).removeClass( 'was-validated' );
				g( 'proveedorCuentaId' ).value = '0';

			}
			function get_proveedor_cuenta( proveedorCuentaId ) {

				var datos			= {};
					datos._data1	= 'proveedor->cuenta->get';
					datos._data2	= g('proveedorId').value;
					datos._data3	= proveedorCuentaId;

				$.ajax(

						{

							url			:	AJAX_catalogos_url	,
							type		:	'POST'				,
							dataType	:	'JSON'				,
							data		:	datos				,
							beforeSend	:	function( ) {}		,
							success		:	function( objJSON ) {

												g('proveedorCuentaId').value		= objJSON.proveedorCuentaId;

												g('proveedorCuentaAlias').value		= objJSON.proveedorCuentaAlias;
												g('proveedorCuentaNumero').value	= objJSON.proveedorCuentaNumero;

											}

						}

					);

			}
			function guarda_proveedor_cuenta( ) {

				var datos						= {};
					datos._data1				= 'proveedor->cuenta->set';

					datos.proveedorId			= g('proveedorId').value;
					datos.proveedorCuentaId		= g('proveedorCuentaId').value;

					datos.proveedorCuentaAlias	= g('proveedorCuentaAlias').value;
					datos.proveedorCuentaNumero	= g('proveedorCuentaNumero').value;

				$.ajax(

						{

							url			:	AJAX_catalogos_url	,
							type		:	'POST'				,
							dataType	:	'JSON'				,
							data		:	datos				,
							beforeSend	:	function( ) {}		,
							success		:	function( objJSON ) {

												get_proveedor( g('proveedorId').value );
												limpia_proveedor_cuentas( );

											}

						}

					);

			}
			function delete_proveedor_cuenta( proveedorCuentaId ) {

				if( !confirm( '¿Desea eliminar la cuenta del proveedor?' ) ) return;

				var datos					= {};
					datos._data1			= 'proveedor->cuenta->delete';
					datos.proveedorCuentaId	= proveedorCuentaId;

				$.ajax(

						{

							url			:	AJAX_catalogos_url	,
							type		:	'POST'				,
							dataType	:	'JSON'				,
							data		:	datos				,
							beforeSend	:	function( ) {}		,
							success		:	function( objJSON ) {

												get_proveedor( g('proveedorId').value );

											}

						}

					);

			}
			function get_cuentas_proveedor( proveedorId ) {

				var datos					= {};
						datos._data1		= 'proveedor->cuentas->get';
						datos.proveedorId	= proveedorId;

				var obj = g('pagoCuentaDestino');
					obj.innerHTML = '';

				var op           = document.createElement( 'OPTION' );
					op.innerHTML = '';
					op.value     = '';
				obj.appendChild( op );

				$.ajax(

						{

							url			:	AJAX_catalogos_url	,
							type		:	'POST'				,
							dataType	:	'JSON'				,
							data		:	datos				,
							beforeSend	:	function( ) {}		,
							success		:	function( objJSON ) {

												for( var i in objJSON ) {

													var op           = document.createElement( 'OPTION' );
														op.innerHTML = objJSON[ i ].proveedorCuentaAlias;
														op.value     = objJSON[ i ].proveedorCuentaId;
													obj.appendChild( op );

												}

											}

						}

					);

			}
			/*Proveedores*/

			/*Cuentas*/
			function limpia_cuenta( ) {

				g( 'form_cuentas' ).reset( );
				$( '#form_cuentas' ).removeClass( 'was-validated' );
				g( 'cuentaId' ).value = '0';

				$('#btn_eliminar').hide( );

			}
			function get_cuentas( ) {

				var datos			= {};
					datos._data1	= 'cuentas->get';

				$.ajax(

						{

							url			:	AJAX_catalogos_url	,
							type		:	'POST'				,
							dataType	:	'JSON'				,
							data		:	datos				,
							beforeSend	:	function( ) {}		,
							success		:	function( objJSON ) {

												g('listCuentas').innerHTML = objJSON;

											}

						}

					);

			}
			function get_cuenta( cuentaId ) {

				var datos			= {};
					datos._data1	= 'cuenta->get';
					datos._data2	= cuentaId;

				$.ajax(

						{

							url			:	AJAX_catalogos_url	,
							type		:	'POST'				,
							dataType	:	'JSON'				,
							data		:	datos				,
							beforeSend	:	function( ) {}		,
							success		:	function( objJSON ) {

												g('cuentaId').value		= objJSON.cuentaId;

												g('cuentaAlias').value	= objJSON.cuentaAlias;
												g('cuentaNumero').value	= objJSON.cuentaNumero;

												$('#btn_eliminar').show( );

											}

						}

					);

			}
			function guarda_cuenta( ) {

				var datos				= {};
					datos._data1		= 'cuenta->set';

					datos.cuentaId		= g('cuentaId').value;
					datos.cuentaAlias	= g('cuentaAlias').value;
					datos.cuentaNumero	= g('cuentaNumero').value;

				$.ajax(

						{

							url			:	AJAX_catalogos_url	,
							type		:	'POST'				,
							dataType	:	'JSON'				,
							data		:	datos				,
							beforeSend	:	function( ) {}		,
							success		:	function( objJSON ) {

												get_cuentas( );
												limpia_cuenta( );

											}

						}

					);

			}
			function delete_cuenta( ) {

				if( !confirm( '¿Desea eliminar la cuenta bancaria?' ) ) return;

				var datos			= {};
					datos._data1	= 'cuenta->delete';
					datos.cuentaId	= g('cuentaId').value;

				$.ajax(

						{

							url			:	AJAX_catalogos_url	,
							type		:	'POST'				,
							dataType	:	'JSON'				,
							data		:	datos				,
							beforeSend	:	function( ) {}		,
							success		:	function( objJSON ) {

												get_cuentas( );
												limpia_cuenta( );

											}

						}

					);

			}
			/*Cuentas*/

			/*Reservaciones*/
			function get_proveedores_select( ) {

				g('proveedorId').innerHTML = '';

				var datos					= {};
					datos._data1			= 'proveedores->get_select';

				$.ajax(

						{

							url			:	AJAX_catalogos_url	,
							type		:	'POST'				,
							dataType	:	'JSON'				,
							data		:	datos				,
							beforeSend	:	function( ) {}		,
							success		:	function( objJSON ) {

												g('proveedorId').innerHTML = objJSON;

											}

						}

					);

			}
			function get_clientes_select( ) {

				g('clienteId').innerHTML = '';

				var datos					= {};
					datos._data1			= 'clientes->get_select';

				$.ajax(

						{

							url			:	AJAX_catalogos_url	,
							type		:	'POST'				,
							dataType	:	'JSON'				,
							data		:	datos				,
							beforeSend	:	function( ) {}		,
							success		:	function( objJSON ) {

												g('clienteId').innerHTML = objJSON;

											}

						}

					);

			}
			function limpia_reservacion( ) {

				g( 'form_reservacion' ).reset( );
				$( '#form_reservacion' ).removeClass( 'was-validated' );
				g( 'reservacionId' ).value = '0';

				$('#btn_eliminar').hide( );
				$('#btn_nueva').hide( );

			}
			function get_reservaciones( ) {

				g('listReservaciones').innerHTML = '';

				var datos			= {};
					datos._data1	= 'reservaciones->get';

				$.ajax(

						{

							url			:	AJAX_catalogos_url	,
							type		:	'POST'				,
							dataType	:	'JSON'				,
							data		:	datos				,
							beforeSend	:	function( ) {}		,
							success		:	function( objJSON ) {

												g('listReservaciones').innerHTML = objJSON;

											}

						}

					);

			}
			function guarda_reservacion( ) {

				var datos								= {};
					datos._data1						= 'reservacion->set';

					datos.reservacionId					= g('reservacionId').value;
					datos.proveedorId					= g('proveedorId').value;
					datos.clienteId						= g('clienteId').value;
					datos.reservacionServicio			= $('input[name=reservacionServicio]:checked').val( );
					datos.reservacionDestino			= g('reservacionDestino').value;
					datos.reservacionHotel				= g('reservacionHotel').value;
					datos.reservacionPlan				= g('reservacionPlan').value;
					datos.reservacionCheckIn			= g('reservacionCheckIn').value;
					datos.reservacionCheckOut			= g('reservacionCheckOut').value;
					datos.reservacionHabitaciones		= g('reservacionHabitaciones').value;
					datos.reservacionDetalle			= g('reservacionDetalle').value;
					datos.reservacionCoste				= g('reservacionCoste').value;
					datos.reservacionPrecio				= g('reservacionPrecio').value;
					datos.reservacionLocalizadorExterno	= g('reservacionLocalizadorExterno').value;
					datos.reservacionStatusCobro		= $('input[name=reservacionStatusCobro]:checked').val( );
					datos.reservacionStatusPago			= $('input[name=reservacionStatusPago]:checked').val( );

				$.ajax(

						{

							url			:	AJAX_catalogos_url	,
							type		:	'POST'				,
							dataType	:	'JSON'				,
							data		:	datos				,
							beforeSend	:	function( ) {}		,
							success		:	function( objJSON ) {

												if( objJSON.error == 0 ) {

													limpia_reservacion( );
													get_reservaciones( );

													alert('¡Se guardo la reservación [ ' + objJSON.localizador + ' ] correctamente!');

												} else {

													alert( objJSON.error_msg );

												}

											}

						}

					);

			}
			function get_reservacion( reservacionId ) {

				var datos			= {};
					datos._data1	= 'reservacion->get';
					datos._data2	= reservacionId

				$.ajax(

						{

							url			:	AJAX_catalogos_url	,
							type		:	'POST'				,
							dataType	:	'JSON'				,
							data		:	datos				,
							beforeSend	:	function( ) {}		,
							success		:	function( objJSON ) {

												$('#proveedorId').val( objJSON.proveedorId );
												$('#clienteId').val( objJSON.clienteId );
												$('#search').val( objJSON.clienteNombre );
												$('#reservacionHabitaciones').val( objJSON.reservacionHabitaciones );
												$('#reservacionPlan').val( objJSON.reservacionPlan );

												switch( objJSON.reservacionServicio ) {

													<? $i = 0; ?>
													<? foreach( RESERVACION_SERVICIOS as $k => $v ) { ?>

														case '<?= $k; ?>':

																$( "#reservacionServicio<?= $i++; ?>" ).prop( "checked", true );

															break;

													<? } unset( $i ); ?>
												}

												switch( objJSON.reservacionStatusCobro ) {

													<? $i = 0; ?>
													<? foreach( RESERVACION_STATUS_COBRO as $k => $v ) { ?>

														case '<?= $v; ?>':

																$( "#reservacionStatusCobro<?= $i++; ?>" ).prop( "checked", true );

															break;

													<? } unset( $i ); ?>
												}

												switch( objJSON.reservacionStatusPago ) {

													<? $i = 0; ?>
													<? foreach( RESERVACION_STATUS_PAGO as $k => $v ) { ?>

														case '<?= $v; ?>':

																$( "#reservacionStatusPago<?= $i++; ?>" ).prop( "checked", true );

															break;

													<? } unset( $i ); ?>
												}

												g('reservacionId').value					= objJSON.reservacionId;
												g('reservacionDestino').value				= objJSON.reservacionDestino;
												g('reservacionHotel').value					= objJSON.reservacionHotel;
												g('reservacionCheckIn').value				= objJSON.reservacionCheckIn;
												g('reservacionCheckOut').value				= objJSON.reservacionCheckOut;
												$( '#reservacionDetalle ').val( objJSON.reservacionDetalle );
												$( '#reservacionDetallePrint ').html( objJSON.reservacionDetalle );

												tinyMCE.get('reservacionDetalle').setContent( objJSON.reservacionDetalle );

												g('reservacionCoste').value					= objJSON.reservacionCoste;
												g('reservacionPrecio').value				= objJSON.reservacionPrecio;
												g('reservacionLocalizadorExterno').value	= objJSON.reservacionLocalizadorExterno;

												$('#btn_eliminar').show( );
												$('#btn_nueva').show( );

											}

						}

					);

			}
			function delete_reservacion( ) {

				if( !confirm('¿Desea eliinar la reservación?') ) return;

				var datos			= {};
					datos._data1	= 'reservacion->delete';
					datos._data2	= g('reservacionId').value;

					$.ajax(

							{

								url			:	AJAX_catalogos_url	,
								type		:	'POST'				,
								dataType	:	'JSON'				,
								data		:	datos				,
								beforeSend	:	function( ) {}		,
								success		:	function( objJSON ) {

													if( objJSON.error == 0 ) {

														limpia_reservacion( );
														get_reservaciones( );

														alert('¡Se eliminó la reservación correctamente!');

													} else {

														alert( objJSON.error_msg );

													}

												}

							}

						);

			}
			/*Reservaciones*/

			/*Cobros*/
			function get_cobro( cobroId ) {

				var datos			= {};
					datos._data1	= 'cobro->get';
					datos.cobroId	= cobroId;

				$.ajax(

						{

							url			:	AJAX_catalogos_url	,
							type		:	'POST'				,
							dataType	:	'JSON'				,
							data		:	datos				,
							beforeSend	:	function( ) {}		,
							success		:	function( objJSON ) {

												$('#cobroTipo').val( objJSON.cobroTipo );
												$('#cobroCuenta').val( objJSON.cuentaId );

												g('cobroId').value				= objJSON.cobroId;
												g('cobroFechaAplicacion').value	= objJSON.cobroFechaAplicacion;
												g('cobroMonto').value			= objJSON.cobroMonto;
												g('cobroDetalle').value			= objJSON.cobroDetalle;

												$('#btn_nuevo').show( );
												$('#btn_eliminar').show( );

											}

						}

					);

			}
			function get_cobros( reservacionId ) {

				var datos							= {};
					datos._data1				= 'cobros->get';
					datos.reservacionId	= reservacionId;

				$.ajax(

						{

							url					:	AJAX_catalogos_url,
							type				:	'POST'						,
							dataType		:	'TEXT'						,
							data				:	datos							,
							beforeSend	:	function( ) {}		,
							success			:	function( objJSON ) {

												g('listCobros').innerHTML = objJSON;

											}

						}

					);

			}
			function get_reservacion_cobro( reservacionId ) {

				var datos				= {};
					datos._data1		= 'cobro->reservacion->get';
					datos.reservacionId	= reservacionId;

				$.ajax(

						{

							url			:	AJAX_catalogos_url	,
							type		:	'POST'				,
							dataType	:	'JSON'				,
							data		:	datos				,
							beforeSend	:	function( ) {}		,
							success		:	function( objJSON ) {

												g('reservacionId').value				= objJSON.reservacionId;
												g('reservacionLocalizador').innerHTML	= objJSON.reservacionLocalizador;
												g('reservacionSaldo').innerHTML			= objJSON.reservacionSaldoVer;
												g('reservacionProveedor').innerHTML 	= objJSON.proveedorAlias;
												g('proveedorId').value					= objJSON.proveedorId;
												g('clienteId').value					= objJSON.clienteId;
												g('cliente').innerHTML					= objJSON.cliente;
												g('reservacionServicio').innerHTML		= objJSON.reservacionServicioVer;
												g('reservacionDestino').innerHTML		= objJSON.reservacionDestino;
												g('reservacionHotel').innerHTML			= objJSON.reservacionHotel;
												g('reservacionPlan').innerHTML			= objJSON.reservacionPlanVer;
												g('reservacionCheckIn').innerHTML		= objJSON.reservacionCheckIn;
												g('reservacionCheckOut').innerHTML		= objJSON.reservacionCheckOut;
												g('reservacionHabitaciones').innerHTML	= objJSON.reservacionHabitaciones;
												g('reservacionDetalle').innerHTML		= objJSON.reservacionDetalle;
												g('reservacionCoste').innerHTML			= objJSON.reservacionCosteVer;
												g('reservacionPrecio').innerHTML		= objJSON.reservacionPrecioVer;
												g('reservacionStatusCobro').innerHTML	= objJSON.reservacionStatusCobro;
												g('reservacionStatusPago').innerHTML	= objJSON.reservacionStatusPago;

												get_cobros( reservacionId );

												$('#contenedor_reservacion').show( );

											}

						}

					);

			}
			function limpia_cobro( ) {

				g( 'form_cobro' ).reset( );
				$( '#form_cobro' ).removeClass( 'was-validated' );
				g( 'cobroId' ).value = '0';

				$('#btn_eliminar').hide( );
				$('#btn_nuevo').hide( );

			}
			function guarda_cobro( ) {

				var _datos							= {};
						_datos._data1				= 'cobro->set';

						_datos.reservacionId		= g('reservacionId').value;
						_datos.clienteId			= g('clienteId').value;
						_datos.proveedorId			= g('proveedorId').value;
						_datos.cobroId				= g('cobroId').value;
						_datos.cobroFechaAplicacion	= g('cobroFechaAplicacion').value;
						_datos.cobroTipo			= g('cobroTipo').value;
						_datos.cuentaId				= g('cobroCuenta').value;
						_datos.cobroMonto			= g('cobroMonto').value;
						_datos.cobroDetalle			= g('cobroDetalle').value;

				var datos = new FormData( );

				for( var i in _datos ) {
						datos.append( i, _datos[ i ] );
				}

				/*Adjunto archivo*/
				if( g('cobroArchivo').value != '' ) {

					var archivo = g('cobroArchivo').files[ 0 ];
					//var image_name = property.name;
					//var image_extension = image_name.split('.').pop( ).toLowerCase( );

					//if(jQuery.inArray(image_extension,['gif','jpg','jpeg','']) == -1){
					//alert("Invalid image file");
					//}

					datos.append( 'cobroArchivo', archivo );

				}
				/*Adjunto archivo*/

				$.ajax(

						{

							url					:	AJAX_catalogos_url,
							type				:	'POST'						,
							dataType		:	'JSON'						,
							data				:	datos							,
							processData : false							,
							contentType : false							,
							beforeSend	:	function( ) {}		,
							success			:	function( objJSON ) {

												if( objJSON.error == '0' ) {

													alert('¡Se guardo el cobro correctamente!');

													ir_a( './recibo.php', '_blank', true, g('reservacionId').value, objJSON.cobroId, null );

												} else {

													alert( objJSON.error_msg );

												}

												limpia_cobro( );
												get_cobros( g('reservacionId').value );

											}

						}

					);

			}
			function delete_cobro( ) {

				if( !confirm('¿Desea eliminar el cobro a cliente?') ) return;

				var datos				= {};
					datos._data1		= 'cobro->delete';

					datos.reservacionId	= g('reservacionId').value;
					datos.cobroId		= g('cobroId').value;
					datos.clienteId		= g('clienteId').value;
					datos.proveedorId	= g('proveedorId').value;

				$.ajax(

						{

							url			:	AJAX_catalogos_url	,
							type		:	'POST'				,
							dataType	:	'JSON'				,
							data		:	datos				,
							beforeSend	:	function( ) {}		,
							success		:	function( objJSON ) {

												limpia_cobro( );
												get_cobros( g('reservacionId').value );

												if( objJSON.error == '0' ) {

													alert('¡Se elimino el cobro correctamente!');

												} else {

													alert( objJSON.error_msg );

												}

											}

						}

					);

			}
			/*Cobros*/

			/*Pagos*/
			function get_reservacion_pago( reservacionId ) {

				var datos				= {};
					datos._data1		= 'pago->reservacion->get';
					datos.reservacionId	= reservacionId;

				$.ajax(

						{

							url			:	AJAX_catalogos_url	,
							type		:	'POST'				,
							dataType	:	'JSON'				,
							data		:	datos				,
							beforeSend	:	function( ) {}		,
							success		:	function( objJSON ) {

												g('reservacionId').value				= objJSON.reservacionId;
												g('proveedorId').value					= objJSON.proveedorId;
												g('clienteId').value					= objJSON.clienteId;
												g('reservacionLocalizador').innerHTML	= objJSON.reservacionLocalizador;
												g('reservacionSaldo').innerHTML			= objJSON.reservacionSaldoProveedorVer;
												g('reservacionProveedor').innerHTML 	= objJSON.proveedorAlias;
												g('cliente').innerHTML					= objJSON.cliente;
												g('reservacionServicio').innerHTML		= objJSON.reservacionServicioVer;
												g('reservacionDestino').innerHTML		= objJSON.reservacionDestino;
												g('reservacionHotel').innerHTML			= objJSON.reservacionHotel;
												g('reservacionPlan').innerHTML			= objJSON.reservacionPlanVer;
												g('reservacionCheckIn').innerHTML		= objJSON.reservacionCheckIn;
												g('reservacionCheckOut').innerHTML		= objJSON.reservacionCheckOut;
												g('reservacionHabitaciones').innerHTML	= objJSON.reservacionHabitaciones;
												g('reservacionDetalle').innerHTML		= objJSON.reservacionDetalle;
												g('reservacionCoste').innerHTML			= objJSON.reservacionCosteVer;
												g('reservacionPrecio').innerHTML		= objJSON.reservacionPrecioVer;
												g('reservacionStatusCobro').innerHTML	= objJSON.reservacionStatusCobro;
												g('reservacionStatusPago').innerHTML	= objJSON.reservacionStatusPago;

												get_pagos( reservacionId );
												get_cuentas_proveedor( objJSON.proveedorId );

												$('#contenedor_reservacion').show( );

											}

						}

					);

			}
			function get_pago( pagoId ) {

				var datos			= {};
					datos._data1	= 'pago->get';
					datos.pagoId	= pagoId;

				$.ajax(

						{

							url			:	AJAX_catalogos_url	,
							type		:	'POST'				,
							dataType	:	'JSON'				,
							data		:	datos				,
							beforeSend	:	function( ) {}		,
							success		:	function( objJSON ) {

												$('#pagoTipo').val( objJSON.pagoTipo );
												$('#pagoCuenta').val( objJSON.cuentaId );
												$('#pagoCuentaDestino').val( objJSON.proveedorCuentaId );

												g('pagoId').value				= objJSON.pagoId;
												g('pagoFechaAplicacion').value	= objJSON.pagoFechaAplicacion;
												g('pagoMonto').value			= objJSON.pagoMonto;
												g('pagoDetalle').value			= objJSON.pagoDetalle;

												$('#btn_nuevo').show( );
												$('#btn_eliminar').show( );

											}

						}

					);

			}
			function delete_pago( ) {

				if( !confirm('¿Desea eliminar el pago a proveedor?') ) return;

				var datos				= {};
					datos._data1		= 'pago->delete';

					datos.reservacionId	= g('reservacionId').value;
					datos.pagoId		= g('pagoId').value;
					datos.clienteId		= g('clienteId').value;
					datos.proveedorId	= g('proveedorId').value;

				$.ajax(

						{

							url			:	AJAX_catalogos_url	,
							type		:	'POST'				,
							dataType	:	'JSON'				,
							data		:	datos				,
							beforeSend	:	function( ) {}		,
							success		:	function( objJSON ) {

												limpia_pago( );
												get_pagos( g('reservacionId').value );

												if( objJSON.error == '0' ) {

													alert('¡Se elimino el pago correctamente!');

												} else {

													alert( objJSON.error_msg );

												}

											}

						}

					);

			}
			function get_pagos( reservacionId ) {

				var datos				= {};
					datos._data1		= 'pagos->get';
					datos.reservacionId	= reservacionId;

				$.ajax(

						{

							url			:	AJAX_catalogos_url	,
							type		:	'POST'				,
							dataType	:	'TEXT'				,
							data		:	datos				,
							beforeSend	:	function( ) {}		,
							success		:	function( objJSON ) {

												g('listPagos').innerHTML = objJSON;

											}

						}

					);

			}
			function guarda_pago( ) {

				var _datos						= {};
					_datos._data1				= 'pago->set';

					_datos.reservacionId		= g('reservacionId').value;
					_datos.proveedorId			= g('proveedorId').value;
					_datos.clienteId			= g('clienteId').value;
					_datos.pagoId				= g('pagoId').value;
					_datos.pagoFechaAplicacion	= g('pagoFechaAplicacion').value;
					_datos.pagoTipo				= g('pagoTipo').value;
					_datos.cuentaId				= g('pagoCuenta').value;
					_datos.proveedorCuentaId	= g('pagoCuentaDestino').value;
					_datos.pagoMonto			= g('pagoMonto').value;
					_datos.pagoDetalle			= g('pagoDetalle').value;

				var datos = new FormData( );

				for( var i in _datos ) {
						datos.append( i, _datos[ i ] );
				}

				/*Adjunto archivo*/
				if( g('pagoArchivo').value != '' ) {

					var archivo = g('pagoArchivo').files[ 0 ];
					//var image_name = property.name;
					//var image_extension = image_name.split('.').pop( ).toLowerCase( );

					//if(jQuery.inArray(image_extension,['gif','jpg','jpeg','']) == -1){
					//alert("Invalid image file");
					//}

					datos.append( 'pagoArchivo', archivo );

				}
				/*Adjunto archivo*/

				$.ajax(

						{

							url			:	AJAX_catalogos_url	,
							type		:	'POST'				,
							dataType	:	'JSON'				,
							data		:	datos				,
							processData :	false				,
							contentType :	false				,
							beforeSend	:	function( ) {}		,
							success		:	function( objJSON ) {

												if( objJSON.error == '0' ) {

													alert('¡Se guardo el pago correctamente!');

													//ir_a( './recibo.php', '_blank', true, g('reservacionId').value, objJSON.cobroId, null );

												} else {

													alert( objJSON.error_msg );

												}

												limpia_pago( );
												get_pagos( g('reservacionId').value );

											}

						}

					);

			}
			function limpia_pago( ) {

				g( 'form_pago' ).reset( );
				$( '#form_pago' ).removeClass( 'was-validated' );
				g( 'pagoId' ).value = '0';

				$('#btn_eliminar').hide( );
				$('#btn_nuevo').hide( );

			}
			/*Pagos*/

		</script>
	</head>
	<body class="d-flex flex-column h-100">
