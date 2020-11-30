<?php

class Reporte extends SQL_MySQL
{

	function __construct( ) {}


	public	function reservaciones_search( $search ) {

		$search	= '%' . ltrim( trim( $search ), '0' ) . '%';

		$aTmp	= array( );

		$q		= sprintf(" SELECT

									r.reservacionId												,
									CONCAT( c.clienteNombre, ' ', c.clienteApellido ) AS cliente

								FROM	reservaciones	r,
										clientes		c

								WHERE		(
												r.reservacionId 	LIKE %s	OR
												c.clienteNombre		LIKE %s	OR
												c.clienteApellido	LIKE %s
											)									AND

											/*Join*/
											r.clienteId	= c.clienteId

								ORDER BY	c.clienteApellido 	ASC	,
											c.clienteNombre		ASC	,
											r.reservacionId				",

							$this->toDBFromUtf8( $search ),
							$this->toDBFromUtf8( $search ),
							$this->toDBFromUtf8( $search )

						);//echo '<pre>';print_r( $q );echo '</pre>';
		$rs = $this->ejecuta_query( $q, 'reservaciones_search( )' );

		while( $r = $this->get_row( $rs ) ) {

			$a						= array( );
			$a['reservacionId'] 	= $r['reservacionId'];
			$a['busquedaResultado']	= antepon_ceros( $r['reservacionId'], LOCALIZADOR_LONGITUD ) . ' - ' . $r['cliente'];

			$aTmp[ ] = $a;

		}

		return $aTmp;

	}

}

?>
