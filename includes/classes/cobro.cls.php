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
		$r['reservacionStatusCobro']	= RESERVACION_STATUS_COBRO[ $r['reservacionStatusCobro'] ];
		$r['reservacionStatusPago']		= RESERVACION_STATUS_PAGO[ $r['reservacionStatusPago'] ];
		$r['reservacionLocalizador']	= antepon_ceros( $r['reservacionId'], LOCALIZADOR_LONGITUD );
		$r['reservacionCosteVer']		= '$ '. number_format( $r['reservacionCoste'] , 2 );
		$r['reservacionPrecioVer']		= '$ '. number_format( $r['reservacionPrecio'] , 2 );
		$r['reservacionSaldoVer']		= '$ '. number_format( $r['reservacionSaldo'] , 2 );

		return $r;

	}

	public	function get_cobros( $reservacionId ) {

		$aTmp	= array( );
		$q		= sprintf(" SELECT

									cobroId							,
									cobroConsecutivo		,
									cobroFechaAplicacion,
									cobroTipo						,
									cobroMonto					,
									cobroDetalle				,
									saldoFinal

								FROM	cobros

								WHERE		reservacionId	= %s	",

							$this->toDBFromUtf8( $reservacionId )

						);
		$rs = $this->ejecuta_query( $q, 'get_cobros( )' );

		while( $r = $this->get_row( $rs ) ) {

			$aTmp[ $r['cobroId'] ] = $r;

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


	public	function get_consecutivo( $reservacionId, $cobroId ) {

		if( $reservacionId == 0 ) return 1;

		if( $cobroId != 0 ) {

			$q	= sprintf(" SELECT

								cobroConsecutivo

								FROM	cobros

								WHERE	cobroId	= %s			",

							$this->toDBFromUtf8( $cobroId )

						);
			$rs = $this->ejecuta_query( $q, 'get_consecutivo( )' );
			$r = $this->get_row( $rs );

			return $r['cobroConsecutivo'] - 1;

		}

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

	public	function set_saldos( $reservacionId ) {

		$primero					= true;
		$cobroConsecutivo	= 1;
		$acumulado				= 0;
		$saldoAnterior		= $this->get_saldo( $reservacionId, 0 );

		$q = sprintf(" SELECT

												cobroId		,
												cobroMonto

											FROM	cobros

											WHERE	reservacionId	 = %s

											ORDER BY cobroConsecutivo	ASC		",

											$this->toDBFromUtf8( $reservacionId	)

										);
		$rs = $this->ejecuta_query( $q, 'set_saldos( )' );

		while( $r = $this->get_row( $rs ) ) {

			$saldoInicial		= $saldoAnterior;
			$acumulado			+= $r['cobroMonto'];
			$saldoFinal			= $saldoInicial - $r['cobroMonto'];
			$saldoAnterior	= $saldoFinal;

			$q = sprintf(" UPDATE cobros

											SET	cobroConsecutivo	= %s,
													acumulado					= %s,
													saldoInicial			= %s,
													saldoFinal				= %s

											WHERE cobroId = %s				",

									$this->toDBFromDB( $cobroConsecutivo++	),
									$this->toDBFromDB( $acumulado						),
									$this->toDBFromDB( $saldoInicial				),
									$this->toDBFromDB( $saldoFinal					),
									$this->toDBFromDB( $r['cobroId']				)

								);
			$this->ejecuta_query( $q, 'set_saldos( )' );

		}

			$q = sprintf(" UPDATE reservaciones SET	reservacionPorCobrar	= %s WHERE reservacionId = %s				",

									$this->toDBFromDB( $saldoFinal		),
									$this->toDBFromDB( $reservacionId	)

								);
			$this->ejecuta_query( $q, 'set_saldos( reservaciones )' );

	}

	public	function set_cobro( $data ) {

		$cobroConsecutivo	= $this->get_consecutivo( $data['reservacionId'], $data['cobroId'] );
		$cobroAcumulado		= $this->get_acumulado( $data['reservacionId'] ) + $data['cobroMonto'];
		$saldoInicial			= $this->get_saldo( $data['reservacionId'], $cobroConsecutivo );
		$saldoFinal				= $saldoInicial - $data['cobroMonto'];

		$q = sprintf(" INSERT INTO cobros

										( cobroId	, reservacionId	, cobroConsecutivo	, cobroFecha, cobroFechaAplicacion, cobroTipo	, cuentaId, cobroMonto, cobroDetalle	, acumulado	, saldoInicial	, saldoFinal	)
							VALUES( %s			, %s						, %s								, %s				, %s									, %s				, %s			, %s				, %s						, %s				, %s						, %s					)

							ON DUPLICATE KEY UPDATE

								cobroFechaAplicacion	= VALUES( cobroFechaAplicacion	),
								cobroTipo							= VALUES( cobroTipo							),
								cobroMonto						= VALUES( cobroMonto						),
								cobroDetalle					= VALUES( cobroDetalle					),
								acumulado							= VALUES( acumulado							),
								saldoInicial					= VALUES( saldoInicial					),
								saldoFinal						= VALUES( saldoFinal						)	",

							$this->toDBFromUtf8( $data['cobroId']								),
							$this->toDBFromUtf8( $data['reservacionId']					),
							$this->toDBFromUtf8( $cobroConsecutivo + 1					),
							$this->get_sysTimeStamp( )							 						 ,
							$this->toDBFromUtf8( $data['cobroFechaAplicacion']	),
							$this->toDBFromUtf8( $data['cobroTipo']							),
							$this->toDBFromUtf8( $data['cuentaId']							),
							$this->toDBFromUtf8( $data['cobroMonto']						),
							'"' . $data['cobroDetalle']	. '"'										,
							$this->toDBFromUtf8( $cobroAcumulado								),
							$this->toDBFromUtf8( $saldoInicial									),
							$this->toDBFromUtf8( $saldoFinal										)

					);
		$this->ejecuta_query( $q, 'set_cobro( )' );

		$cobroId = $this->get_insert_id( );

		$this->set_saldos( $data['reservacionId'], $data['cobroId'] );
		$this->abona_a_cuenta( $data, $cobroId, $cobroAcumulado );
		$this->descuenta_saldo_cliente( $data, $cobroId, $cobroAcumulado );

		return $cobroId;

	}

	public	function set_cobro_archivo( $cobroId, $archivo ) {

		$q = sprintf(" UPDATE cobros SET cobroArchivo = '%s' WHERE cobroId = '%s' ", $archivo, $cobroId );
		$this->ejecuta_query( $q, 'set_cobro_archivo( )' );

	}

	public	function descuenta_saldo_cliente( $data, $cobroId, $cobroAcumulado ) {

		$q					= sprintf(" SELECT clienteId FROM reservaciones WHERE reservacionId = %s ", $this->toDBFromUtf8( $data['reservacionId']	) );
		$r					= $this->ejecuta_query( $q, 'descuenta_saldo_cliente( clienteId )' );
		$r					= $this->get_row( $r );
		$clienteId	= $r['clienteId'];

		$q = sprintf(" INSERT INTO clienteEdoCta( clienteId , cuentaId	, reservacionId	, cobroId	, cobroTipo	,cobroMonto	, cobroAcumulado	)
		 																	VALUES( %s				, %s				, %s						, %s			, %s				, %s				, %s							)	",

											$this->toDBFromUtf8( $clienteId							),
											$this->toDBFromUtf8( $data['cuentaId']			),
											$this->toDBFromUtf8( $data['reservacionId']	),
											$this->toDBFromUtf8( $cobroId								),
											$this->toDBFromUtf8( $data['cobroTipo']			),
											$this->toDBFromUtf8( $data['cobroMonto']		),
											$this->toDBFromUtf8( $cobroAcumulado				)

								);
			$this->ejecuta_query( $q, 'descuenta_saldo_cliente( )' );

			$q = sprintf(" SELECT SUM( cobroMonto ) AS acumulado FROM clienteEdoCta WHERE clienteId = %s ", $this->toDBFromUtf8( $clienteId ) );
			$r = $this->ejecuta_query( $q, 'descuenta_saldo_cliente( SUM )' );
			$r = $this->get_row( $r );
			$edoCtaAcumulado = $r['acumulado'];

			$q = sprintf(" UPDATE clientes SET clienteEdoCta = %s WHERE clienteId = %s ", $this->toDBFromUtf8( $edoCtaAcumulado ), $this->toDBFromUtf8( $clienteId ) );
			$this->ejecuta_query( $q, 'descuenta_saldo_cliente( update cliente )' );

	}

	public	function abona_a_cuenta( $data, $cobroId, $cobroAcumulado ) {

		$q = sprintf(" INSERT INTO cuentaDetalle( cuentaId	, reservacionId	, cobroId	, cobroTipo	,cobroMonto, cobroAcumulado	)
		 																	VALUES( %s				, %s						, %s			, %s				, %s				, %s						)	",

											$this->toDBFromUtf8( $data['cuentaId']			),
											$this->toDBFromUtf8( $data['reservacionId']	),
											$this->toDBFromUtf8( $cobroId								),
											$this->toDBFromUtf8( $data['cobroTipo']			),
											$this->toDBFromUtf8( $data['cobroMonto']		),
											$this->toDBFromUtf8( $cobroAcumulado				)

								);
			$this->ejecuta_query( $q, 'abona_a_cuenta( )' );


	}

	public	function cobro_delete( $data ) {

		$q = sprintf(" DELETE FROM cobros WHERE cobroId = %s ", $data['cobroId'] );
		$this->ejecuta_query( $q, 'cobro_delete( )' );

		$this->set_saldos( $data['reservacionId'], $data['cobroId'] );

	}

}

?>
