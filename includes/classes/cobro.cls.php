<?php

class Cobro extends SQL_MySQL
{

	function __construct( ) {}


	public	function get_reservacion( $reservacionId ) {

		$q	= sprintf(" SELECT

								p.proveedorAlias			,
								CONCAT(
										c.clienteNombre		,
										' '					,
										c.clienteApellido

									  ) AS cliente			,
								r.*	,
								( SELECT saldoFinal FROM cobros WHERE reservacionId = r.reservacionId ORDER BY cobroConsecutivo DESC LIMIT 0, 1 ) AS reservacionSaldo

							FROM	reservaciones	r,
									clientes		c,
									proveedores		p

							WHERE		r.reservacionId	= %s			AND

										/*Join*/
										r.proveedorId	= p.proveedorId	AND
										r.clienteId		= c.clienteId			",

						$this->toDBFromUtf8( $reservacionId )

					);
		$rs = $this->ejecuta_query( $q, 'get_reservacion( )' );
		$r = $this->get_row( $rs );

		$r['reservacionServicioVer']	= RESERVACION_SERVICIOS[ $r['reservacionServicio'] ];
		$r['reservacionPlanVer']		= PLAN_ALIMENTOS[ $r['reservacionPlan'] ];
		$r['reservacionStatusVer']		= RESERVACION_STATUS[ $r['reservacionStatus'] ];
		$r['reservacionLocalizador']	= antepon_ceros( $r['reservacionId'], LOCALIZADOR_LONGITUD );
		$r['reservacionCosteVer']		= '$ '. number_format( $r['reservacionCoste'] , 2 );
		$r['reservacionPrecioVer']		= '$ '. number_format( $r['reservacionPrecio'] , 2 );
		$r['reservacionSaldoVer']		= '$ '. number_format( $r['reservacionSaldo'] , 2 );

		return $r;

	}

	public	function get_cobros( $reservacionId ) {

		$aTmp	= array( );
		$q		= sprintf(" SELECT

									cobroConsecutivo	,
									cobroTipo			,
									cobroMonto			,
									cobroDetalle		,
									saldoFinal

								FROM	cobros

								WHERE		reservacionId	= %s	",

							$this->toDBFromUtf8( $reservacionId )

						);
		$rs = $this->ejecuta_query( $q, 'get_cobros( )' );

		while( $r = $this->get_row( $rs ) ) {

			$aTmp[ $r['cobroConsecutivo'] ] = $r;

		}

		return $aTmp;

	}

	public	function get_cobro( $cobroId ) {

		$q		= sprintf(" SELECT

									*

								FROM	cobros

								WHERE	cobroId	= %s	",

							$this->toDBFromUtf8( $cobroId )

						);
		$rs = $this->ejecuta_query( $q, 'get_cobro( )' );

		return $this->get_row( $rs );

	}


	public	function get_consecutivo( $reservacionId ) {

		if( $reservacionId == 0 ) return 1;

		$q	= sprintf(" SELECT

							IF( MAX( cobroConsecutivo ) IS NULL, 0, MAX( cobroConsecutivo ) ) AS consecutivo

							FROM	cobros

							WHERE	reservacionId	= %s			",

						$this->toDBFromUtf8( $reservacionId )

					);
		$rs = $this->ejecuta_query( $q, 'get_consecutivo( )' );
		$r = $this->get_row( $rs );

		return $r['consecutivo'];

	}

	public	function get_acumulado( $reservacionId ) {

		if( $reservacionId == 0 ) return 0;

		$q	= sprintf(" SELECT

								SUM( cobroMonto ) AS acumulado

							FROM	cobros

							WHERE	reservacionId	= %s			",

						$this->toDBFromUtf8( $reservacionId )

					);
		$rs = $this->ejecuta_query( $q, 'get_acumulado( )' );
		$r = $this->get_row( $rs );

		return $r['acumulado'];

	}

	public	function get_saldo( $reservacionId, $cobroConsecutivo ) {

		if( $cobroConsecutivo == 0 ) {

			$q	= sprintf(" SELECT reservacionPrecio FROM reservaciones WHERE reservacionId = %s ", $this->toDBFromUtf8( $reservacionId ) );
			$rs	= $this->ejecuta_query( $q, 'get_saldo( )' );
			$r	= $this->get_row( $rs );

			return $r['reservacionPrecio'];

		} else {

			$q	= sprintf(" SELECT saldoFinal FROM cobros WHERE reservacionId = %s AND cobroConsecutivo = %s ",

							$this->toDBFromUtf8( $reservacionId		),
							$this->toDBFromUtf8( $cobroConsecutivo	)

						);
			$rs = $this->ejecuta_query( $q, 'get_saldo( )' );
			$r = $this->get_row( $rs );

			return $r['saldoFinal'];

		}

	}

	public	function set_cobro( $data ) {

		$cobroConsecutivo	= $this->get_consecutivo( $data['reservacionId'] );
		$cobroAcumulado		= $this->get_acumulado( $data['reservacionId'] ) + $data['cobroMonto'];
		$saldoInicial		= $this->get_saldo( $data['reservacionId'], $cobroConsecutivo );
		$saldoFinal			= $saldoInicial - $data['cobroMonto'];

		$q = sprintf(" INSERT INTO cobros

									( cobroId	, reservacionId	, cobroConsecutivo	, cobroTipo	, cobroMonto, cobroDetalle	, acumulado	, saldoInicial	, saldoFinal	)
							VALUES	( %s		, %s			, %s				, %s		, %s		, %s			, %s		, %s			, %s			)

							ON DUPLICATE KEY UPDATE

								cobroConsecutivo	= VALUES( cobroConsecutivo	),
								cobroTipo			= VALUES( cobroTipo			),
								cobroMonto			= VALUES( cobroMonto		),
								cobroDetalle		= VALUES( cobroDetalle		),
								acumulado			= VALUES( acumulado			),
								saldoInicial		= VALUES( saldoInicial		),
								saldoFinal			= VALUES( saldoFinal		)	",

							$this->toDBFromUtf8( $data['cobroId']		),
							$this->toDBFromUtf8( $data['reservacionId']	),
							$this->toDBFromUtf8( $cobroConsecutivo + 1	),
							$this->toDBFromUtf8( $data['cobroTipo']		),
							$this->toDBFromUtf8( $data['cobroMonto']	),
							$this->toDBFromUtf8( $data['cobroDetalle']	),
							$this->toDBFromUtf8( $cobroAcumulado		),
							$this->toDBFromUtf8( $saldoInicial			),
							$this->toDBFromUtf8( $saldoFinal			)

					);
		$this->ejecuta_query( $q, 'set_cobro( )' );

	}

}

?>
