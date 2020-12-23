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

			$aTmp[ $r['reservacionId'] ]['reservacionServicioVer']	= toHTML( RESERVACION_SERVICIOS[ $r['reservacionServicio'] ], ''		, true );
			$aTmp[ $r['reservacionId'] ]['reservacionStatusCobro']	= toHTML( RESERVACION_STATUS_COBRO[ $r['reservacionStatusCobro'] ]		, ''		, true );
			$aTmp[ $r['reservacionId'] ]['reservacionStatusPago']	= toHTML( RESERVACION_STATUS_PAGO[ $r['reservacionStatusPago'] ]		, ''		, true );
			$aTmp[ $r['reservacionId'] ]['reservacionCheckInVer']	= toHTML( $r['reservacionCheckIn']							, 'date_num', true );
			$aTmp[ $r['reservacionId'] ]['reservacionCheckOutVer']	= toHTML( $r['reservacionCheckOut']							, 'date_num', true );

		}

		return $aTmp;

	}

	public	function set_reservacion( $data ) {

		$q = sprintf(" INSERT INTO reservaciones(
										reservacionId,
										proveedorId,
										clienteId,
										reservacionServicio,
										reservacionDestino,
										reservacionHotel,
										reservacionPlan,
										reservacionCheckIn,
										reservacionCheckOut,
										reservacionHabitaciones,
										reservacionDetalle,
										reservacionCoste,
										reservacionPrecio,
										reservacionUtilidad,
										reservacionLocalizadorExterno,
										reservacionStatusCobro,
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
										%s
									)

							ON DUPLICATE KEY UPDATE

								proveedorId						= VALUES( proveedorId								 		),
								clienteId						= VALUES( clienteId									 		),
								reservacionServicio				= VALUES( reservacionServicio								),
								reservacionDestino				= VALUES( reservacionDestino								),
								reservacionHotel				= VALUES( reservacionHotel									),
								reservacionPlan					= VALUES( reservacionPlan									),
								reservacionCheckIn				= VALUES( reservacionCheckIn								),
								reservacionCheckOut				= VALUES( reservacionCheckOut								),
								reservacionHabitaciones			= VALUES( reservacionHabitaciones							),
								reservacionDetalle				= VALUES( reservacionDetalle								),
								reservacionCoste				= VALUES( reservacionCoste									),
								reservacionPrecio				= VALUES( reservacionPrecio									),
								reservacionUtilidad				= VALUES( reservacionPrecio ) - VALUES( reservacionCoste ),
								reservacionLocalizadorExterno	= VALUES( reservacionLocalizadorExterno						),
								reservacionStatusCobro			= VALUES( reservacionStatusCobro							),
								reservacionStatusPago			= VALUES( reservacionStatusPago								)	",

							$this->toDBFromUtf8( $data['reservacionId']									),
							$this->toDBFromUtf8( $data['proveedorId']									),
							$this->toDBFromUtf8( $data['clienteId']										),
							$this->toDBFromUtf8( $data['reservacionServicio']							),
							$this->toDBFromUtf8( $data['reservacionDestino']							),
							$this->toDBFromUtf8( $data['reservacionHotel']								),
							$this->toDBFromUtf8( $data['reservacionPlan']								),
							$this->toDBFromUtf8( $data['reservacionCheckIn']		, 'date'			),
							$this->toDBFromUtf8( $data['reservacionCheckOut']		, 'date'			),
							$this->toDBFromUtf8( $data['reservacionHabitaciones']						),
							$this->toDBFromUtf8( $data['reservacionDetalle']							),
							$this->toDBFromUtf8( $data['reservacionCoste']								),
							$this->toDBFromUtf8( $data['reservacionPrecio']								),
							$this->toDBFromUtf8( $data['reservacionPrecio'] - $data['reservacionCoste']	),
							$this->toDBFromUtf8( $data['reservacionLocalizadorExterno']					),
							$this->toDBFromUtf8( $data['reservacionStatusCobro']						),
							$this->toDBFromUtf8( $data['reservacionStatusPago']							)

					);
		$this->ejecuta_query( $q, 'set_reservacion( )' );

		return $data['reservacionId'] == '0' ? $this->get_insert_id( ) : $data['reservacionId'];

	}

	public	function delete_reservacion( $reservacionId ) {

		$q = sprintf(" DELETE FROM reservaciones WHERE reservacionId = %s ", $this->toDBFromUtf8( $reservacionId ) );
		$this->ejecuta_query( $q, 'delete_reservacion( )' );

	}

}

?>
