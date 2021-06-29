<?php

class Reservacion extends SQL_MySQL
{

	function __construct( ) {}


	public	function reservaciones_get( $reservacionId = '%' ) {

		$aTmp	= array( );

		$q		= sprintf(" SELECT

									r.*																	,
									CONCAT( c.clienteNombre, ' ', c.clienteApellido )	AS clienteNombre

								FROM	reservaciones	r,
										clientes		c

								WHERE	r.reservacionId LIKE %s	AND

										r.clienteId	= c.clienteId

								ORDER BY r.reservacionId ASC		",

							$this->toDBFromUtf8( $reservacionId )

						);
		$rs		= $this->ejecuta_query( $q, 'reservaciones_get( )' );

		while( $r = $this->get_row( $rs ) ) {

			$aTmp[ $r['reservacionId'] ] = $r;

			//$aTmp[ $r['reservacionId'] ]['reservacionDetalle']					= toHTML( $r['reservacionDetalle']									, 'tinyMCE' );

			$aTmp[ $r['reservacionId'] ]['reservacionCoste']					= toHTML( $r['reservacionCoste']									, 'monetario' );
			$aTmp[ $r['reservacionId'] ]['reservacionPrecio']					= toHTML( $r['reservacionPrecio']									, 'monetario' );

			$aTmp[ $r['reservacionId'] ]['reservacionGastosCancelacionCoste']	= toHTML( $r['reservacionGastosCancelacionCoste']					, 'monetario' );
			$aTmp[ $r['reservacionId'] ]['reservacionGastosCancelacionPrecio']	= toHTML( $r['reservacionGastosCancelacionPrecio']					, 'monetario' );

			$aTmp[ $r['reservacionId'] ]['reservacionCheckIn']					= toHTML( $r['reservacionCheckIn']									, 'date_num' );
			$aTmp[ $r['reservacionId'] ]['reservacionCheckOut']					= toHTML( $r['reservacionCheckOut']									, 'date_num' );

			$aTmp[ $r['reservacionId'] ]['reservacionServicioVer']				= toHTML( RESERVACION_SERVICIOS[ $r['reservacionServicio'] ]		, ''		, true );
			$aTmp[ $r['reservacionId'] ]['reservacionStatusCobro']				= toHTML( RESERVACION_STATUS_COBRO[ $r['reservacionStatusCobro'] ]	, ''		, true );
			$aTmp[ $r['reservacionId'] ]['reservacionStatusPago']				= toHTML( RESERVACION_STATUS_PAGO[ $r['reservacionStatusPago'] ]	, ''		, true );
			$aTmp[ $r['reservacionId'] ]['reservacionCheckInVer']				= toHTML( $r['reservacionCheckIn']									, 'date_num', true );
			$aTmp[ $r['reservacionId'] ]['reservacionCheckOutVer']				= toHTML( $r['reservacionCheckOut']									, 'date_num', true );

		}

		return $aTmp;

	}

	public	function set_reservacion( $data ) {

		$utilidad = $this->toDBFromUtf8( $data['reservacionPrecio'], 'monetario', false ) - $this->toDBFromUtf8( $data['reservacionCoste'], 'monetario', false );

		$q = sprintf(" INSERT INTO reservaciones(
													reservacionId						,
													usuarioId							,
													proveedorId							,
													clienteId							,
													reservacionServicio					,
													reservacionDestino					,
													reservacionHotel					,
													reservacionPlan						,
													reservacionCheckIn					,
													reservacionCheckOut					,
													reservacionHabitaciones				,
													reservacionDetalle					,
													reservacionCoste					,
													reservacionPrecio					,
													reservacionUtilidad					,
													reservacionLocalizadorExterno		,
													reservacionPorPagar					,
													reservacionPorCobrar				,
													reservacionStatusCobro				,
													reservacionStatusPago
												)
										VALUES	(
													%s,
													%s,
													%s,
													%s,
													%s,
													%s,
													%s,
													%s,
													%s,
													%s,
													%s,
													%s,
													%s,
													%s,
													%s,
													%s,
													%s,
													%s,
													%s,
													%s
												)

							ON DUPLICATE KEY UPDATE

								proveedorId							= VALUES( proveedorId							 			),
								clienteId							= VALUES( clienteId								 			),
								reservacionServicio					= VALUES( reservacionServicio								),
								reservacionDestino					= VALUES( reservacionDestino								),
								reservacionHotel					= VALUES( reservacionHotel									),
								reservacionPlan						= VALUES( reservacionPlan									),
								reservacionCheckIn					= VALUES( reservacionCheckIn								),
								reservacionCheckOut					= VALUES( reservacionCheckOut								),
								reservacionHabitaciones				= VALUES( reservacionHabitaciones							),
								reservacionDetalle					= VALUES( reservacionDetalle								),
								reservacionCoste					= VALUES( reservacionCoste									),
								reservacionPrecio					= VALUES( reservacionPrecio									),
								reservacionUtilidad					= VALUES( reservacionPrecio ) - VALUES( reservacionCoste	),
								reservacionLocalizadorExterno		= VALUES( reservacionLocalizadorExterno						),
								reservacionGastosCancelacionCoste	= %s														 ,
								reservacionGastosCancelacionPrecio	= %s														 ,
								reservacionStatusCobro				= VALUES( reservacionStatusCobro							),
								reservacionStatusPago				= VALUES( reservacionStatusPago								)	",

							$this->toDBFromUtf8( $data['reservacionId']										),
							$this->toDBFromUtf8( $_SESSION['currentUser']['usuarioId']						),
							$this->toDBFromUtf8( $data['proveedorId']										),
							$this->toDBFromUtf8( $data['clienteId']											),
							$this->toDBFromUtf8( $data['reservacionServicio']								),
							$this->toDBFromUtf8( $data['reservacionDestino']								),
							$this->toDBFromUtf8( $data['reservacionHotel']									),
							$this->toDBFromUtf8( $data['reservacionPlan']									),
							$this->toDBFromUtf8( $data['reservacionCheckIn']				, 'date'		),
							$this->toDBFromUtf8( $data['reservacionCheckOut']				, 'date'		),
							$this->toDBFromUtf8( $data['reservacionHabitaciones']							),

							"'" . addslashes( $data['reservacionDetalle'] ) . "'"							 ,

							$this->toDBFromUtf8( $data['reservacionCoste']					, 'monetario'	),
							$this->toDBFromUtf8( $data['reservacionPrecio']					, 'monetario'	),
							$this->toDBFromUtf8( $utilidad													),
							$this->toDBFromUtf8( $data['reservacionLocalizadorExterno']						),
							$this->toDBFromUtf8( $data['reservacionCoste']					, 'monetario'	),
							$this->toDBFromUtf8( $data['reservacionPrecio']					, 'monetario'	),
							$this->toDBFromUtf8( $data['reservacionStatusCobro']							),
							$this->toDBFromUtf8( $data['reservacionStatusPago']								),

							$this->toDBFromUtf8( $data['reservacionGastosCancelacionCoste']	, 'monetario'	), //ON DUPLICATE KEY
							$this->toDBFromUtf8( $data['reservacionGastosCancelacionPrecio'], 'monetario'	)  //ON DUPLICATE KEY

					);
		$this->ejecuta_query( $q, 'set_reservacion( )' );

		return $data['reservacionId'] == '0' ? $this->get_insert_id( ) : $data['reservacionId'];

	}

	public	function actualiza_saldos( $clienteId, $proveedorId, $reservacionId ) {

		//Status reservacion
		$q = sprintf(" SELECT

								reservacionStatusCobro,
								reservacionStatusPago

							FROM reservaciones

							WHERE reservacionId = %s ",

						$this->toDBFromUtf8( $reservacionId	)

					);
		$rs = $this->ejecuta_query( $q, 'actualiza_saldos( )' );
		$r  = $this->get_row( $rs );

		$coste	= $r['reservacionStatusPago']	== STATUS_CANCELADA ? 'reservacionGastosCancelacionCoste'	: 'reservacionCoste';
		$precio	= $r['reservacionStatusCobro']	== STATUS_CANCELADA ? 'reservacionGastosCancelacionPrecio'	: 'reservacionPrecio';

		//Reservación
		$q = sprintf(" UPDATE reservaciones SET

												reservacionPorPagar		= %s - ( SELECT SUM( pagoMonto	) FROM proveedorEdoCta	WHERE reservacionId = %s ),
												reservacionPorCobrar	= %s - ( SELECT SUM( cobroMonto	) FROM clienteEdoCta	WHERE reservacionId = %s )

										WHERE reservacionId = %s ",

							$coste								 ,
							$this->toDBFromUtf8( $reservacionId	),

							$precio								 ,
							$this->toDBFromUtf8( $reservacionId	),

							$this->toDBFromUtf8( $reservacionId	)

					);
		$this->ejecuta_query( $q, 'actualiza_saldos( )' );

// TODO: switch por reservacion para calcular suma contra coste o gastos de cancelacion
		//Cliente
		$q = sprintf(" UPDATE clientes SET

											clienteEdoCta = ( SELECT SUM( reservacionPrecio ) FROM reservaciones WHERE clienteId = %s ) - ( SELECT SUM( cobroMonto ) FROM clienteEdoCta WHERE clienteId = %s )

										WHERE clienteId = %s ",

							$this->toDBFromUtf8( $clienteId	),
							$this->toDBFromUtf8( $clienteId	),
							$this->toDBFromUtf8( $clienteId	)

					);
		//$this->ejecuta_query( $q, 'actualiza_saldos( )' );

// TODO: switch por reservacion para calcular suma contra precio o gastos de cancelacion
		//Proveedor
		$q = sprintf(" UPDATE proveedores SET

											proveedorEdoCta = ( SELECT SUM( reservacionCoste ) FROM reservaciones WHERE proveedorId = %s ) - ( SELECT SUM( pagoMonto ) FROM proveedorEdoCta WHERE proveedorId = %s )

										WHERE proveedorId = %s ",

							$this->toDBFromUtf8( $proveedorId	),
							$this->toDBFromUtf8( $proveedorId	),
							$this->toDBFromUtf8( $proveedorId	)

					);
		//$this->ejecuta_query( $q, 'actualiza_saldos( )' );

	}

	public	function delete_reservacion( $reservacionId ) {

		$q = sprintf(" DELETE FROM reservaciones WHERE reservacionId = %s ", $this->toDBFromUtf8( $reservacionId ) );
		$this->ejecuta_query( $q, 'delete_reservacion( )' );

	}

	public	function verifica_status_pago( $reservacionId ) {

			$q  = sprintf(" SELECT

									reservacionCoste	,
									reservacionPorPagar

								FROM reservaciones

								WHERE reservacionId = %s ",

							$this->toDBFromUtf8( $reservacionId )

						);
			$rs = $this->ejecuta_query( $q, 'verifica_status_pago( )' );
			$r = $this->get_row( $rs );

			if( ( float ) $r['reservacionPorPagar'] == ( float ) $r['reservacionCoste'] ) {

				//Sin pagos, CONFIRMADA
				$statusPago = 0;

			} else
			if( ( float ) $r['reservacionPorPagar'] <= 0 ) {

				//Sin adeudo o saldo a favor, PAGADA
				$statusPago = 2;

			} else {

				//Pago parcial, CON PAGO
				$statusPago = 1;

			}

			$q = sprintf(" UPDATE

									reservaciones

								SET reservacionStatusPago = %s

								WHERE reservacionId = %s		",

							$this->toDBFromUtf8( $statusPago	),
							$this->toDBFromUtf8( $reservacionId	)

						);
			$rs = $this->ejecuta_query( $q, 'verifica_status_pago( UPDATE reservaciones )' );

	}

	public	function verifica_status_cobro( $reservacionId ) {

			$q  = sprintf(" SELECT

									reservacionPrecio	,
									reservacionPorCobrar

								FROM reservaciones

								WHERE reservacionId = %s ",

							$this->toDBFromUtf8( $reservacionId )

						);
			$rs = $this->ejecuta_query( $q, 'verifica_status_cobro( )' );
			$r = $this->get_row( $rs );

			if( ( float ) $r['reservacionPorCobrar'] == ( float ) $r['reservacionPrecio'] ) {

				//Sin cobros, COTIZACION
				$statusCobro = 0;

			} else
			if( ( float ) $r['reservacionPorCobrar'] <= 0 ) {

				//Sin adeudo o saldo a favor, COBRADA
				$statusCobro = 2;

			} else {

				//Cobro parcial, CON ANTICIPO
				$statusCobro = 1;

			}

			$q = sprintf(" UPDATE

									reservaciones

								SET reservacionStatusCobro = %s

								WHERE reservacionId = %s		",

							$this->toDBFromUtf8( $statusCobro	),
							$this->toDBFromUtf8( $reservacionId	)

						);
			$rs = $this->ejecuta_query( $q, 'verifica_status_cobro( UPDATE reservaciones )' );


	}

}

?>
