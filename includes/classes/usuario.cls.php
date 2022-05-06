<?php

class Usuario extends SQL_MySQL
{

	function __construct( ) {}

	public	function get_login( $login, $pass ) {

		$q = sprintf(" SELECT

								*

							FROM usuarios

							WHERE 	usuarioUsername	= %s	AND
									usuarioPassword	= %s",

						$this->toDBFromUtf8( $login ),
						$this->toDBFromUtf8( $pass 	)

					);
		$r = $this->ejecuta_query( $q, 'get_login( )' );

		if( $r = $this->get_row( $r ) ) {
			if( $r['usuarioStatus'] == '1' ) {
				$_SESSION['currentUser'] = $r;
				return $r;
			} else {
				return '2';
			}
		} else {
			return '1';
		}

	}

	public	function get_usuario( $usuarioId ) {

		$aTmp = array( );

		$q = sprintf(" SELECT

								*

							FROM usuarios

							WHERE 	usuarioId LIKE %s

							AND usuarioEliminado IS NULL

							ORDER BY usuarioRol DESC, usuarioStatus DESC, usuarioNombre",

						$this->toDBFromUtf8( $usuarioId )

					);
		$rs = $this->ejecuta_query( $q, 'get_usuario( )' );

		while( $r = $this->get_row( $rs ) ) {

			$aTmp[ $r['usuarioId'] ] = $r;

		}

		return $aTmp;

	}

	public	function set_usuario( $data ) {

		$q = sprintf(" INSERT INTO usuarios

									( usuarioId	, sucursalId, usuarioNombre	, usuarioApellido	, usuarioUsername	, usuarioPassword	, usuarioEmail	, usuarioMovil	, usuarioStatus	, usuarioRol	)
							VALUES	( %s		, %s		, %s			, %s				, %s				, %s				, %s			, %s			, %s			, %s			)

							ON DUPLICATE KEY UPDATE

								sucursalId		= VALUES( sucursalId 		),
								usuarioNombre	= VALUES( usuarioNombre		),
								usuarioApellido	= VALUES( usuarioApellido	),
								usuarioUsername	= VALUES( usuarioUsername	),
								usuarioPassword	= VALUES( usuarioPassword	),
								usuarioEmail	= VALUES( usuarioEmail		),
								usuarioMovil	= VALUES( usuarioMovil		),
								usuarioStatus	= VALUES( usuarioStatus		),
								usuarioRol		= VALUES( usuarioRol		)	",

							$this->toDBFromUtf8( $data['usuarioId']						),
							$this->toDBFromUtf8( $data['sucursalId']					),
							$this->toDBFromUtf8( $data['usuarioNombre']					),
							$this->toDBFromUtf8( $data['usuarioApellido']				),
							$this->toDBFromUtf8( $data['usuarioUsername']				),
							$this->toDBFromUtf8( $data['usuarioPassword']				),
							$this->toDBFromUtf8( $data['usuarioEmail']		, 'email'	),
							$this->toDBFromUtf8( $data['usuarioMovil']					),
							$this->toDBFromUtf8( $data['usuarioStatus']					),
							$this->toDBFromUtf8( $data['usuarioRol']					)

					);
		$this->ejecuta_query( $q, 'get_usuario( )' );

	}

	public	function delete_usuario( $usuarioId ) {

		$q = sprintf(" UPDATE usuarios SET usuarioEliminado = 1 WHERE usuarioId = %s ",	$this->toDBFromUtf8( $usuarioId )	);
		$this->ejecuta_query( $q, 'delete_usuario( ): Baja lógica' );

	}

}

?>
