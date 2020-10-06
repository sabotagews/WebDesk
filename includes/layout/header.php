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
		<title>WebDesk</title>
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

			/*Usuarios*/
			function limpia_usuario( ) {

				g('form_usuarios').reset( );
				g('usuario_id').value		= '0';
				$( '#form_usuarios' ).removeClass( 'was-validated' );

			}
			function get_usuario( usuario_id ) {

				var datos			= {};
					datos._data1	= 'usuario->get';
					datos._data2	= usuario_id;

				$.ajax(

						{

							url			:	AJAX_catalogos_url	,
							type		:	'POST'				,
							dataType	:	'JSON'				,
							data		:	datos				,
							beforeSend	:	function( ) {}		,
							success		:	function( objJSON ) {

												g('usuario_id').value		= objJSON.usuario_id;

												g('usuarioNombre').value	= objJSON.usuario_nombre;
												g('usuarioApellido').value	= objJSON.usuario_apellido;
												g('usuarioUsername').value	= objJSON.usuario_username;
												g('usuarioPassword').value	= objJSON.usuario_password;
												g('usuarioEmail').value		= objJSON.usuario_email;
												g('usuarioMovil').value		= objJSON.usuario_movil;

												g('usuarioStatus').checked	= objJSON.usuario_status == '0' ? false : true;

												if( objJSON.usuario_rol == 'A' ) {
													document.form_usuarios.usuarioRol[ 0 ].checked	= true;
													document.form_usuarios.usuarioRol[ 1 ].checked	= false;
												} else {
													document.form_usuarios.usuarioRol[ 0 ].checked	= false;
													document.form_usuarios.usuarioRol[ 1 ].checked	= true;
												}

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

				var datos				= {};
					datos._data1		= 'usuario->delete';
					datos.usuario_id	= g('usuario_id').value;

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

				g('form_sucursales').reset( );
				g('sucursalId').value	= '0';

			}
			function get_sucursal( sucursal_id ) {

				var datos			= {};
					datos._data1	= 'sucursal->get';
					datos._data2	= sucursal_id;

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

			/*Clientes*/
			function limpia_cliente( ) {

				g('form_clientes').reset( );
				g('clienteId').value	= '0';

			}
			function get_cliente( cliente_id ) {

				var datos			= {};
					datos._data1	= 'cliente->get';
					datos._data2	= cliente_id;

				$.ajax(

						{

							url			:	AJAX_catalogos_url	,
							type		:	'POST'				,
							dataType	:	'JSON'				,
							data		:	datos				,
							beforeSend	:	function( ) {}		,
							success		:	function( objJSON ) {

												g('clienteId').value		= objJSON.clienteId;

												g('clienteNombre').value	= objJSON.clienteNombre;
												g('clienteApellido').value	= objJSON.clienteApellido;
												g('clienteEmail').value		= objJSON.clienteEmail;
												g('clienteMovil').value		= objJSON.clienteMovil;

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

												g('listClientes').innerHTML			= objJSON.html;

											}

						}

					);

			}
			function guarda_cliente( ) {

				var datos					= {};
					datos._data1			= 'cliente->set';

					datos.clienteId			= g('clienteId').value;

					datos.clienteNombre		= g('clienteNombre').value;
					datos.clienteApellido	= g('clienteApellido').value;
					datos.clienteEmail		= g('clienteEmail').value;
					datos.clienteMovil		= g('clienteMovil').value;

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

		</script>
	</head>
	<body>
