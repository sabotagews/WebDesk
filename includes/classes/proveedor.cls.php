<?php

class Proveedor extends SQL_MySQL
{

	function __construct( ) {}

	public	function get_proveedor( $proveedorId ) {

		$aTmp = array( );

		$q = sprintf(" SELECT

								*

							FROM	proveedores

							WHERE 	proveedorId LIKE %s

							ORDER BY proveedorAlias ASC",

						$this->toDBFromUtf8( $proveedorId )

					);
		$rs = $this->ejecuta_query( $q, 'get_proveedor( )' );

		while( $r = $this->get_row( $rs ) ) {

			$aTmp[ $r['proveedorId'] ] = $r;

		}

		return $aTmp;

	}

	public	function set_proveedor( $data ) {

		$q = sprintf(" INSERT INTO proveedores

									( proveedorId	, proveedorRazonSocial	, proveedorAlias	, proveedorDomicilio	, proveedorEmail, proveedorTelefono	)
							VALUES	( %s			, %s					, %s				, %s					, %s			, %s				)

							ON DUPLICATE KEY UPDATE

								proveedorRazonSocial	= VALUES( proveedorRazonSocial	),
								proveedorAlias			= VALUES( proveedorAlias		),
								proveedorDomicilio		= VALUES( proveedorDomicilio	),
								proveedorEmail			= VALUES( proveedorEmail		),
								proveedorTelefono		= VALUES( proveedorTelefono		)		",

							$this->toDBFromUtf8( $data['proveedorId']						),
							$this->toDBFromUtf8( $data['proveedorRazonSocial']				),
							$this->toDBFromUtf8( $data['proveedorAlias']					),
							$this->toDBFromUtf8( $data['proveedorDomicilio']				),
							$this->toDBFromUtf8( $data['proveedorEmail']		, 'email'	),
							$this->toDBFromUtf8( $data['proveedorTelefono']					)

					);
		$this->ejecuta_query( $q, 'set_proveedor( )' );

	}

	public	function delete_proveedor( $proveedorId ) {

		$q = sprintf(" DELETE FROM proveedores WHERE proveedorId = %s ",	$this->toDBFromUtf8( $proveedorId )	);
		$this->ejecuta_query( $q, 'delete_proveedor( )' );

	}


	public	function get_proveedor_cuentas( $proveedorId, $proveedorCuentaId = '%' ) {

		$aTmp = array( );

		$q = sprintf(" SELECT

								*

							FROM	proveedorCuentas

							WHERE 	proveedorId			LIKE %s	AND
									proveedorCuentaId	LIKE %s

							ORDER BY proveedorCuentaAlias ASC		",

						$this->toDBFromUtf8( $proveedorId		),
						$this->toDBFromUtf8( $proveedorCuentaId	)

					);
		$rs = $this->ejecuta_query( $q, 'get_proveedor_cuentas( )' );

		while( $r = $this->get_row( $rs ) ) {

			$aTmp[ $r['proveedorCuentaId'] ] = $r;

		}

		return $aTmp;

	}

	public	function set_proveedor_cuenta( $data ) {

		$q = sprintf(" INSERT INTO proveedorCuentas

									( proveedorCuentaId	, proveedorId	, bancoId	, proveedorCuentaAlias	, proveedorCuentaNumero	)
							VALUES	( %s				, %s			, NULL		, %s					, %s					)

							ON DUPLICATE KEY UPDATE

								proveedorCuentaAlias	= VALUES( proveedorCuentaAlias	),
								proveedorCuentaNumero	= VALUES( proveedorCuentaNumero	)		",

							$this->toDBFromUtf8( $data['proveedorCuentaId']		),
							$this->toDBFromUtf8( $data['proveedorId']			),
							$this->toDBFromUtf8( $data['proveedorCuentaAlias']	),
							$this->toDBFromUtf8( $data['proveedorCuentaNumero']	)

					);
		$this->ejecuta_query( $q, 'set_proveedor_cuenta( )' );

	}

	public	function delete_proveedor_cuenta( $cuentaId ) {

		$q = sprintf(" DELETE FROM proveedorCuentas WHERE proveedorCuentaId = %s ",	$this->toDBFromUtf8( $cuentaId ) );
		$this->ejecuta_query( $q, 'delete_proveedor_cuenta( )' );

	}

}

?>
