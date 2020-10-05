<?php

class Cliente extends SQL_MySQL
{

	function __construct( ) {}

	public	function get_cliente( $clienteId ) {

		$aTmp = array( );

		$q = sprintf(" SELECT

								*

							FROM	clientes

							WHERE 	clienteId LIKE %s	",

						$this->toDBFromUtf8( $clienteId )

					);
		$rs = $this->ejecuta_query( $q, 'get_cliente( )' );

		while( $r = $this->get_row( $rs ) ) {

			$aTmp[ $r['clienteId'] ] = $r;

		}

		return $aTmp;

	}

	public	function set_cliente( $data ) {

		$q = sprintf(" INSERT INTO clientes

									( clienteId	, clienteNombre	, clienteApellido	, clienteEmail	, clienteMovil	)
							VALUES	( %s		, %s			, %s				, %s			, %s			)

							ON DUPLICATE KEY UPDATE

								clienteNombre	= VALUES( clienteNombre		),
								clienteApellido	= VALUES( clienteApellido	),
								clienteEmail	= VALUES( clienteEmail		),
								clienteMovil	= VALUES( clienteMovil		)	",

							$this->toDBFromUtf8( $data['clienteId']						),
							$this->toDBFromUtf8( $data['clienteNombre']					),
							$this->toDBFromUtf8( $data['clienteApellido']				),
							$this->toDBFromUtf8( $data['clienteEmail']		, 'email'	),
							$this->toDBFromUtf8( $data['clienteMovil']					)

					);
		$this->ejecuta_query( $q, 'set_cliente( )' );

	}

	public	function delete_cliente( $clienteId ) {

		$q = sprintf(" DELETE FROM clientes WHERE clienteId = %s ",	$this->toDBFromUtf8( $clienteId )	);
		$this->ejecuta_query( $q, 'delete_cliente( )' );

	}

}

?>
