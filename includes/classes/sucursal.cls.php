<?php

class Sucursal extends SQL_MySQL
{

	function __construct( ) {}

	public	function get_sucursal( $sucursalId ) {

		$aTmp = array( );

		$q = sprintf(" SELECT

								*

							FROM sucursales

							WHERE 	sucursalId LIKE %s

							ORDER BY sucursalStatus DESC, sucursalNombre",

						$this->toDBFromUtf8( $sucursalId )

					);
		$rs = $this->ejecuta_query( $q, 'get_sucursal( )' );

		while( $r = $this->get_row( $rs ) ) {

			$aTmp[ $r['sucursalId'] ] = $r;

		}

		return $aTmp;

	}

	public	function set_sucursal( $data ) {

		$q = sprintf(" INSERT INTO sucursales

									( sucursalId, sucursalNombre, sucursalDomicilio	, sucursalTelefono	, sucursalEmail	, sucursalStatus	)
							VALUES	( %s		, %s			, %s				, %s				, %s			, %s				)

							ON DUPLICATE KEY UPDATE

								sucursalNombre		= VALUES( sucursalNombre	),
								sucursalDomicilio	= VALUES( sucursalDomicilio	),
								sucursalTelefono	= VALUES( sucursalTelefono	),
								sucursalEmail		= VALUES( sucursalEmail		),
								sucursalStatus		= VALUES( sucursalStatus	)	",

							$this->toDBFromUtf8( $data['sucursalId']					),
							$this->toDBFromUtf8( $data['sucursalNombre']				),
							$this->toDBFromUtf8( $data['sucursalDomicilio']				),
							$this->toDBFromUtf8( $data['sucursalTelefono']				),
							$this->toDBFromUtf8( $data['sucursalEmail']		, 'email'	),
							$this->toDBFromUtf8( $data['sucursalStatus']				)

					);
		$this->ejecuta_query( $q, 'set_sucursal( )' );

	}

	public	function delete_sucursal( $sucursalId ) {

		$q = sprintf(" DELETE FROM sucursales WHERE sucursalId = %s ",	$this->toDBFromUtf8( $sucursalId )	);
		$this->ejecuta_query( $q, 'delete_sucursal( )' );

	}

}

?>
