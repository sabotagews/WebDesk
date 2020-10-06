<?php

class Usuario extends SQL_MySQL
{

	function __construct( ) {}

	public	function get_login( $login, $pass ) {

		$q = sprintf(" SELECT

								*

							FROM usuarios

							WHERE 	usuario_username	= %s	AND
									usuario_password	= %s		",

						$this->toDBFromUtf8( $login ),
						$this->toDBFromUtf8( $pass 	)

					);
		$r = $this->ejecuta_query( $q, 'get_login( )' );

		if( $r = $this->get_row( $r ) ) {
			
			$_SESSION['currentUser'] = $r;
			return $r;
		}

		return NULL;

	}

	public	function get_usuario( $usuario_id ) {

		$aTmp = array( );

		$q = sprintf(" SELECT

								*

							FROM usuarios

							WHERE 	usuario_id LIKE %s
							
							ORDER BY usuario_status DESC, usuario_nombre",

						$this->toDBFromUtf8( $usuario_id )

					);
		$rs = $this->ejecuta_query( $q, 'get_usuario( )' );

		while( $r = $this->get_row( $rs ) ) {

			$aTmp[ $r['usuario_id'] ] = $r;

		}

		return $aTmp;

	}

	public	function set_usuario( $data ) {

		$q = sprintf(" INSERT INTO usuarios

									( usuario_id, usuario_nombre, usuario_apellido	, usuario_username	, usuario_password	, usuario_email , usuario_movil	, usuario_status, usuario_rol	)
							VALUES	( %s		, %s			, %s				, %s				, %s				, %s			, %s			, %s			, %s			)

							ON DUPLICATE KEY UPDATE

								usuario_nombre		= VALUES( usuario_nombre	),
								usuario_apellido	= VALUES( usuario_apellido	),
								usuario_username	= VALUES( usuario_username	),
								usuario_password	= VALUES( usuario_password	),
								usuario_email		= VALUES( usuario_email		),
								usuario_movil		= VALUES( usuario_movil		),
								usuario_status		= VALUES( usuario_status	),
								usuario_rol			= VALUES( usuario_rol		)	",

							$this->toDBFromUtf8( $data['usuario_id']					),
							$this->toDBFromUtf8( $data['usuario_nombre']				),
							$this->toDBFromUtf8( $data['usuario_apellido']				),
							$this->toDBFromUtf8( $data['usuario_username']				),
							$this->toDBFromUtf8( $data['usuario_password']				),
							$this->toDBFromUtf8( $data['usuario_email']		, 'email'	),
							$this->toDBFromUtf8( $data['usuario_movil']					),
							$this->toDBFromUtf8( $data['usuario_status']				),
							$this->toDBFromUtf8( $data['usuario_rol']					)

					);
		$this->ejecuta_query( $q, 'get_usuario( )' );

	}

	public	function delete_usuario( $usuario_id ) {

		$q = sprintf(" DELETE FROM usuarios WHERE usuario_id = %s ",	$this->toDBFromUtf8( $usuario_id )	);
		$this->ejecuta_query( $q, 'delete_usuario( )' );

	}

}

?>
