<?php

class Reservacion extends SQL_MySQL
{

	function __construct( ) {}


	public	function get_servicio_nombre( $servicio ) {

		switch( strtolower( $servicio ) ) {

			case 'al'	:	$servicio	=	'Alojamiento';				break;
			case 'ch'	:	$servicio	=	'Charter';					break;
			case 'ae'	:	$servicio	=	'A�reo';					break;
			case 'bus'	:	$servicio	=	'Autob�s';					break;
			case 'gpo'	:	$servicio	=	'Grupo';					break;

			default		:	$servicio	=	'!Servicio Desconocido!';	break;

		}

		return $servicio;

	}

	public	function reservaciones_get( $reservacionId = '%' ) {

		$aTmp	= array( );

		$q		= sprintf(" SELECT

									*

								FROM	reservaciones

								WHERE	reservacionId LIKE %s

								ORDER BY reservacionId ASC		",

							$this->toDBFromUtf8( $reservacionId )

						);
		$rs		= $this->ejecuta_query( $q, 'reservaciones_get( )' );

		while( $r = $this->get_row( $rs ) ) {

			$aTmp[ $r['reservacionId'] ] = $r;

			$aTmp[ $r['reservacionId'] ]['reservacionServicioVer']	= toHTML( RESERVACION_SERVICIOS[ $r['reservacionServicio'] ], ''		, true );
			$aTmp[ $r['reservacionId'] ]['reservacionStatusVer']	= toHTML( RESERVACION_STATUS[ $r['reservacionStatus'] ]		, ''		, true );
			$aTmp[ $r['reservacionId'] ]['reservacionCheckInVer']	= toHTML( $r['reservacionCheckIn']							, 'date_num', true );
			$aTmp[ $r['reservacionId'] ]['reservacionCheckOutVer']	= toHTML( $r['reservacionCheckOut']							, 'date_num', true );

		}

		return $aTmp;

	}

	public	function set_reservacion( $data ) {

		$q = sprintf(" INSERT INTO reservaciones

									( reservacionId	, clienteId	, reservacionServicio	, reservacionDestino	, reservacionHotel	, reservacionPlan	, reservacionCheckIn	, reservacionCheckOut	, reservacionHabitaciones	, reservacionObservaciones	, reservacionStatus	)
							VALUES	( %s			, %s		, %s					, %s					, %s				, %s				, %s					, %s					, %s						, %s						, %s				)

							ON DUPLICATE KEY UPDATE

								clienteId					= VALUES( clienteId				 	),
								reservacionServicio			= VALUES( reservacionServicio		),
								reservacionDestino			= VALUES( reservacionDestino		),
								reservacionHotel			= VALUES( reservacionHotel			),
								reservacionPlan				= VALUES( reservacionPlan			),
								reservacionCheckIn			= VALUES( reservacionCheckIn		),
								reservacionCheckOut			= VALUES( reservacionCheckOut		),
								reservacionHabitaciones		= VALUES( reservacionHabitaciones	),
								reservacionObservaciones	= VALUES( reservacionObservaciones	),
								reservacionStatus			= VALUES( reservacionStatus			)	",

							$this->toDBFromUtf8( $data['reservacionId']							),
							$this->toDBFromUtf8( $data['clienteId']								),
							$this->toDBFromUtf8( $data['reservacionServicio']					),
							$this->toDBFromUtf8( $data['reservacionDestino']					),
							$this->toDBFromUtf8( $data['reservacionHotel']						),
							$this->toDBFromUtf8( $data['reservacionPlan']						),
							$this->toDBFromUtf8( $data['reservacionCheckIn']		, 'date'	),
							$this->toDBFromUtf8( $data['reservacionCheckOut']		, 'date'	),
							$this->toDBFromUtf8( $data['reservacionHabitaciones']				),
							$this->toDBFromUtf8( $data['reservacionObservaciones']				),
							$this->toDBFromUtf8( $data['reservacionStatus']						)

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