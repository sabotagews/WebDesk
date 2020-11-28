<?php

class Cuenta extends SQL_MySQL
{

	function __construct( ) {}

	public	function get_cuenta( $cuentaId = '%' ) {

		$aTmp = array( );

		$q = sprintf(" SELECT

								*

							FROM	cuentas

							WHERE 	cuentaId LIKE %s

							ORDER BY cuentaAlias ASC",

						$this->toDBFromUtf8( $cuentaId )

					);
		$rs = $this->ejecuta_query( $q, 'get_cuenta( )' );

		while( $r = $this->get_row( $rs ) ) {

			$aTmp[ $r['cuentaId'] ] = $r;

		}

		return $aTmp;

	}

	public	function set_cuenta( $data ) {

		$q = sprintf(" INSERT INTO cuentas

									( cuentaId	, bancoId	, cuentaAlias	, cuentaNumero	)
							VALUES	( %s		, NULL		, %s			, %s			)

							ON DUPLICATE KEY UPDATE

								cuentaAlias		= VALUES( cuentaAlias	),
								cuentaNumero	= VALUES( cuentaNumero	)		",

							$this->toDBFromUtf8( $data['cuentaId']		),
							$this->toDBFromUtf8( $data['cuentaAlias']	),
							$this->toDBFromUtf8( $data['cuentaNumero']	)

					);
		$this->ejecuta_query( $q, 'set_cuenta( )' );

	}

	public	function delete_cuenta( $cuentaId ) {

		$q = sprintf(" DELETE FROM cuentas WHERE cuentaId = %s ", $this->toDBFromUtf8( $cuentaId ) );
		$this->ejecuta_query( $q, 'delete_cuenta( )' );

	}

}

?>
