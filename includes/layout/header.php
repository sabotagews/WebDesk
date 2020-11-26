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
			function get_clientes_select( ) {

				g('reservacionCliente').innerHTML = '';

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

												g('reservacionCliente').innerHTML = objJSON.html;

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

												g('usuarioId').value		= objJSON.usuarioId;

												g('usuarioNombre').value	= objJSON.usuarioNombre;
												g('usuarioApellido').value	= objJSON.usuarioApellido;
												g('usuarioUsername').value	= objJSON.usuarioUsername;
												g('usuarioPassword').value	= objJSON.usuarioPassword;
												g('usuarioEmail').value		= objJSON.usuarioEmail;
												g('usuarioMovil').value		= objJSON.usuarioMovil;

												g('usuarioStatus').checked	= objJSON.usuario_status == '0' ? false : true;

												if( objJSON.usuario_rol == 'A' ) {
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

					datos.usuario_id		= g('usuario_id').value;

					datos.usuario_nombre	= g('usuarioNombre').value;
					datos.usuario_apellido	= g('usuarioApellido').value;
					datos.usuario_username	= g('usuarioUsername').value;
					datos.usuario_password	= g('usuarioPassword').value;
					datos.usuario_email		= g('usuarioEmail').value;
					datos.usuario_movil		= g('usuarioMovil').value;
					datos.usuario_status	= g('usuarioStatus').checked ? '1' : '0';
					datos.usuario_rol		= $('input[name=usuarioRol]:checked').val()

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
			/*Proveedores*/
		</script>
	</head>
	<body>
