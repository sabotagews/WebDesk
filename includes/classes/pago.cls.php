<?php

class pago extends SQL_MySQL
{

	function __construct( ) {}


	public	function get_consecutivo( $reservacionId, $pagoId ) {

			if( $reservacionId == 0 ) return 1;

			if( $pagoId != 0 ) {

				$q	= sprintf(" SELECT

									pagoConsecutivo

									FROM	pagos

									WHERE	pagoId	= %s			",

								$this->toDBFromUtf8( $pagoId )

							);
				$rs = $this->ejecuta_query( $q, 'get_consecutivo( )' );
				$r = $this->get_row( $rs );

				return $r['pagoConsecutivo'] - 1;

			}

			$q	= sprintf(" SELECT

								IF( MAX( pagoConsecutivo ) IS NULL, 0, MAX( pagoConsecutivo ) ) AS consecutivo

								FROM	pagos

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

								SUM( pagoMonto ) AS acumulado

							FROM	pagos

							WHERE	reservacionId	= %s			",

						$this->toDBFromUtf8( $reservacionId )

					);
		$rs = $this->ejecuta_query( $q, 'get_acumulado( )' );
		$r = $this->get_row( $rs );

		return $r['acumulado'];

	}

	public	function get_saldo( $reservacionId, $pagoConsecutivo ) {

		if( $pagoConsecutivo == 0 ) {

			$q	= sprintf(" SELECT reservacionCoste FROM reservaciones WHERE reservacionId = %s ", $this->toDBFromUtf8( $reservacionId ) );
			$rs	= $this->ejecuta_query( $q, 'get_saldo( )' );
			$r	= $this->get_row( $rs );

			return $r['reservacionCoste'];

		} else {

			$q	= sprintf(" SELECT saldoFinal FROM pagos WHERE reservacionId = %s AND pagoConsecutivo = %s ",

							$this->toDBFromUtf8( $reservacionId		),
							$this->toDBFromUtf8( $pagoConsecutivo	)

						);
			$rs = $this->ejecuta_query( $q, 'get_saldo( )' );
			$r = $this->get_row( $rs );

			return $r['saldoFinal'];

		}

	}

	public	function set_pago( $data ) {

		$pagoConsecutivo	= $this->get_consecutivo( $data['reservacionId'], $data['pagoId'] );
		$pagoAcumulado		= $this->get_acumulado( $data['reservacionId'] ) + $data['pagoMonto'];
		$saldoInicial		= $this->get_saldo( $data['reservacionId'], $pagoConsecutivo );
		$saldoFinal			= $saldoInicial - $data['pagoMonto'];

		$q = sprintf(" INSERT INTO pagos

									  ( usuarioId	, pagoId , reservacionId	, cuentaId	, proveedorCuentaId	, pagoConsecutivo	, pagoFecha, pagoFechaAplicacion	, pagoTipo	, pagoMonto, pagoDetalle	, acumulado	, saldoInicial	, saldoFinal	)
								VALUES( %s			, %s		, %s			, %s		, %s				, %s				, %s		, %s					, %s		, %s		, %s			, %s		, %s			, %s			)

							ON DUPLICATE KEY UPDATE

								usuarioId			= %s							 ,
								cuentaId			= VALUES( cuentaId				),
								proveedorCuentaId	= VALUES( proveedorCuentaId 	),
								pagoFechaAplicacion	= VALUES( pagoFechaAplicacion	),
								pagoTipo			= VALUES( pagoTipo				),
								pagoMonto			= VALUES( pagoMonto				),
								pagoDetalle			= VALUES( pagoDetalle			),
								acumulado			= VALUES( acumulado				),
								saldoInicial		= VALUES( saldoInicial			),
								saldoFinal			= VALUES( saldoFinal			)	",

							$this->toDBFromUtf8( $_SESSION['currentUser']['usuarioId']	),
							$this->toDBFromUtf8( $data['pagoId']						),
							$this->toDBFromUtf8( $data['reservacionId']					),
							$this->toDBFromUtf8( $data['cuentaId']						),
							$this->toDBFromUtf8( $data['proveedorCuentaId']				),
							$this->toDBFromUtf8( $pagoConsecutivo + 1					),
							$this->get_sysTimeStamp( )									 ,
							$this->toDBFromUtf8( $data['pagoFechaAplicacion']			),
							$this->toDBFromUtf8( $data['pagoTipo']						),
							$this->toDBFromUtf8( $data['pagoMonto']						),
							'"' . $data['pagoDetalle']	. '"'							,
							$this->toDBFromUtf8( $pagoAcumulado							),
							$this->toDBFromUtf8( $saldoInicial							),
							$this->toDBFromUtf8( $saldoFinal							),

							$this->toDBFromUtf8( $_SESSION['currentUser']['usuarioId']	) //ON DUPLICATE KEY

					);
		//echo '<pre>';print_r( $q );echo '</pre>';die;
		$this->ejecuta_query( $q, 'set_pago( )' );

		$pagoId = $this->get_insert_id( );

		$this->set_saldos( $data['reservacionId'], $data['pagoId'] );
		$this->descuenta_saldo_proveedor( $data, $pagoId, $pagoAcumulado );

		return $pagoId;

	}

	public	function get_pagos( $reservacionId ) {

		$aTmp	= array( );
		$q		= sprintf(" SELECT

									pagoId				,
									pagoConsecutivo		,
									pagoFechaAplicacion	,
									pagoTipo			,
									pagoMonto			,
									pagoDetalle			,
									acumulado			,
									saldoFinal

								FROM	pagos

								WHERE		reservacionId	= %s	",

							$this->toDBFromUtf8( $reservacionId )

						);
		$rs = $this->ejecuta_query( $q, 'get_pagos( )' );

		while( $r = $this->get_row( $rs ) ) {

			$aTmp[ $r['pagoId'] ] = $r;

		}

		return $aTmp;

	}

	public	function get_pago( $pagoId ) {

		$q		= sprintf(" SELECT

									*

								FROM	pagos

								WHERE	pagoId	= %s	",

							$this->toDBFromUtf8( $pagoId )

						);
		$rs = $this->ejecuta_query( $q, 'get_pago( )' );

		$aTmp = $this->get_row( $rs );
		$aTmp['pagoFechaAplicacion'] = toHTML( $aTmp['pagoFechaAplicacion'], 'date_num' );


		return $aTmp;

	}

	public	function set_saldos( $reservacionId ) {

		$primero					= true;
		$pagoConsecutivo	= 1;
		$acumulado				= 0;
		$saldoAnterior		= $this->get_saldo( $reservacionId, 0 );

		$q = sprintf(" SELECT

												pagoId		,
												pagoMonto

											FROM	pagos

											WHERE	reservacionId	 = %s

											ORDER BY pagoConsecutivo	ASC		",

											$this->toDBFromUtf8( $reservacionId	)

										);
		$rs = $this->ejecuta_query( $q, 'set_saldos( )' );

		while( $r = $this->get_row( $rs ) ) {

			$saldoInicial		= $saldoAnterior;
			$acumulado			+= $r['pagoMonto'];
			$saldoFinal			= $saldoInicial - $r['pagoMonto'];
			$saldoAnterior	= $saldoFinal;

			$q = sprintf(" UPDATE pagos

											SET	pagoConsecutivo	= %s,
													acumulado					= %s,
													saldoInicial			= %s,
													saldoFinal				= %s

											WHERE pagoId = %s				",

									$this->toDBFromDB( $pagoConsecutivo++	),
									$this->toDBFromDB( $acumulado						),
									$this->toDBFromDB( $saldoInicial				),
									$this->toDBFromDB( $saldoFinal					),
									$this->toDBFromDB( $r['pagoId']				)

								);
			$this->ejecuta_query( $q, 'set_saldos( )' );

		}

			$q = sprintf(" UPDATE reservaciones SET	reservacionPorCobrar	= %s WHERE reservacionId = %s				",

									$this->toDBFromDB( $saldoFinal		),
									$this->toDBFromDB( $reservacionId	)

								);
			$this->ejecuta_query( $q, 'set_saldos( reservaciones )' );

	}

	public	function set_pago_archivo( $pagoId, $archivo ) {

		$q = sprintf(" UPDATE pagos SET pagoArchivo = '%s' WHERE pagoId = '%s' ", $archivo, $pagoId );
		$this->ejecuta_query( $q, 'set_pago_archivo( )' );

	}

	public	function actualiza_acumulados( $reservacionId ) {

		$acumulado = 0;

		$q = sprintf(" SELECT

								cuentaId		,
								reservacionId	,
								proveedorId		,
								pagoId			,
								pagoTipo		,
								pagoMonto

							FROM proveedorEdoCta

							WHERE reservacionId = %s

							ORDER BY pagoId ASC ",

						$this->toDBFromUtf8( $reservacionId )

					);
		$rs = $this->ejecuta_query( $q, 'actualiza_acumulados( )' );

		while( $r = $this->get_row( $rs ) ) {

			$acumulado += $r['pagoMonto'];

			$q = sprintf(" UPDATE proveedorEdoCta SET pagoAcumulado = %s WHERE pagoId = %s ", $acumulado, $r['pagoId'] );
			$this->ejecuta_query( $q, 'actualiza_acumulados( )' );

			$aTmp = $r;
			$aTmp['pagoAcumulado'] = $acumulado;

			$this->abona_a_cuenta( $aTmp );

		}

	}

	public	function descuenta_saldo_proveedor( $data, $pagoId, $pagoAcumulado ) {

		$q			= sprintf(" SELECT proveedorId FROM reservaciones WHERE reservacionId = %s ", $this->toDBFromUtf8( $data['reservacionId']	) );
		$r			= $this->ejecuta_query( $q, 'descuenta_saldo_proveedor( clienteId )' );
		$r			= $this->get_row( $r );
		$proveedorId	= $r['proveedorId'];

		$q = sprintf(" INSERT INTO proveedorEdoCta	( proveedorId	, cuentaId	, reservacionId	, pagoId	, pagoTipo	,pagoMonto	, pagoAcumulado	)
		 								VALUES  	( %s			, %s		, %s			, %s		, %s		, %s		, %s			)

							ON DUPLICATE KEY UPDATE	pagoTipo		= VALUES( pagoTipo		),
													pagoMonto		= VALUES( pagoMonto		),
													pagoAcumulado	= VALUES( pagoAcumulado	)	",

											$this->toDBFromUtf8( $proveedorId				),
											$this->toDBFromUtf8( $data['proveedorCuentaId']	),
											$this->toDBFromUtf8( $data['reservacionId']		),
											$this->toDBFromUtf8( $pagoId					),
											$this->toDBFromUtf8( $data['pagoTipo']			),
											$this->toDBFromUtf8( $data['pagoMonto']		),
											$this->toDBFromUtf8( $pagoAcumulado			)

								);
			$this->ejecuta_query( $q, 'descuenta_saldo_proveedor( )' );

	}

	public	function abona_a_cuenta( $data ) {

		$q = sprintf(" INSERT INTO cuentaDetalle( cuentaId	, reservacionId	, proveedorId	, pagoId	, pagoTipo	, pagoMonto	, pagoAcumulado	)
		 								VALUES	( %s		, %s			, %s			, %s		, %s		, %s		, %s			)

							ON DUPLICATE KEY UPDATE	pagoTipo 		= VALUES( pagoTipo		),
													pagoMonto		= VALUES( pagoMonto		),
													pagoAcumulado	= VALUES( pagoAcumulado	)	",

											$this->toDBFromUtf8( $data['cuentaId']			),
											$this->toDBFromUtf8( $data['reservacionId']		),
											$this->toDBFromUtf8( $data['proveedorId']		),
											$this->toDBFromUtf8( $data['pagoId']			),
											$this->toDBFromUtf8( $data['pagoTipo']			),
											$this->toDBFromUtf8( $data['pagoMonto']			),
											$this->toDBFromUtf8( $data['pagoAcumulado']		)

								);
			$this->ejecuta_query( $q, 'abona_a_cuenta( )' );

	}

	public	function pago_delete( $data ) {

		$q = sprintf(" DELETE FROM proveedorEdoCta WHERE pagoId = %s ", $data['pagoId'] );
		$this->ejecuta_query( $q, 'pago_delete( )' );

		$q = sprintf(" DELETE FROM cuentaDetalle WHERE pagoId = %s ", $data['pagoId'] );
		$this->ejecuta_query( $q, 'pago_delete( )' );

		$q = sprintf(" DELETE FROM pagos WHERE pagoId = %s ", $data['pagoId'] );
		$this->ejecuta_query( $q, 'pago_delete( )' );

	}

}

?>
