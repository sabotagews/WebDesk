<?php

define('S'							, '/' );
define('R'							, chr( 13 ) );
define('RJS'						, chr( 10 ) );
define('SEPARADOR_FECHA'			, '/');

define('DELAY_XHR'					, 1 ); //Segundos
define('LOCALIZADOR_LONGITUD'		, 3 ); //Caracteres

define('RESERVACION_HABITACIONES'	, 5 );
define('PLAN_ALIMENTOS'				, array( 'EP' => 'Europeo', 'CD' => 'Con Desayuno', 'TI' => 'Todo Incluido' ) );
define('RESERVACION_SERVICIOS'		, array( 'AL' => 'Alojamiento', 'CH' => 'Charter', 'AE' => 'Aéreo', 'BUS' => 'Autobús', 'PQ' => 'Paquete', 'GPO' => 'Grupo' ) );
define('RESERVACION_STATUS'			, array( '0' => 'Cotización', '1' => 'Confirmada', '2' => 'Pagada', '3' => 'Cobrada' ) );


if( $_SERVER['SERVER_NAME'] == 'localhost' ) {

	define('DB_HOSTNAME'	, 'localhost'				);
	define('DB_USERNAME'	, 'root'					);
	define('DB_PASSWORD'	, 'XSmotif7'				);
	define('DB_DATABASE'	, 'WebDesk'					);
	define('DEBUGGER'		, true						);

} else {

	define('DB_HOSTNAME'	, 'localhost'				);
	define('DB_USERNAME'	, 'turismosalo_webdeskuser'	);
	define('DB_PASSWORD'	, '211506WebDesk0310'		);
	define('DB_DATABASE'	, 'turismosalo_webdesk'		);
	define('DEBUGGER'		, true						);

}

try {

	date_default_timezone_set('America/Mexico_City');

	$_SQL_CONSULTAS	= array( );
	$__db			= new MySQLi( DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE );

	if( $__db->connect_error ) {

		throw new Exception( 'Conexion DB: ' . $__db->connect_error );

	}

	$desface			= new DateTime( );
	$desface_minutos	= $desface->getOffset( ) / 60;
	$desface_horas		= floor( $desface_minutos / 60 );

	$q					= sprintf(" SET time_zone = '%s:00'; ", $desface_horas );

	if (!$__db->set_charset('utf8')) {
		exit();
	}

	$__db->query( $q );

} catch( Exception $e ) {

	die( $e->getMessage( ) );

}

class SQL_MySQL {

	function __construct( ) {

		$this->consultas	= array( );
		$this->last_query	= '';

	}

	public	function cerrar_conexion( &$conexion ) {

				$conexion->close( );

				return NULL;

	}

	public	static	function ejecuta_query( $q, $tabla_error ) {

		global $__db;

		//$this->last_query	= $q;
		$r					= $__db->query( $q );

		if( $r ) {

			if( DEBUGGER ) {

				SQL_MySQL::debugger_add_query( $q );

			}

			return $r;

		} else {

			if( DEBUGGER ) {

				SQL_MySQL::debugger_add_query( 'ERROR:&nbsp;<b>'.$q.'</b><br />' . SQL_MySQL::get_error( ) );

			}

			throw new Exception( $q . chr( 13 ) .  $__db->error . chr( 13 ) . $tabla_error );

		}

	}

	public	static	function begin( ) {

				global $__db;

				$__db->begin_transaction( );

	}

	public	static function commit( ) {

				global $__db;

				$__db->commit( );

	}

	public	static	function rollback( ) {

				global $__db;

				$__db->rollback( );

	}

	public	static	function rows( $record_set ) {

		return $record_set->num_rows;

	}

	public	static	function get_row( $record_set ) {

		return $record_set->fetch_assoc( );

	}

	public	static	function get_insert_id( ) {

			global $__db;

			return $__db->insert_id;

	}

	public	static	function get_sysTimeStamp( ) {

				return 'NOW( )';

	}

	public	static	function get_sysDate( ) {

				return 'CURDATE( )';

	}

	private	static	function debugger_add_query( $query ) {

			global $_SQL_CONSULTAS;

			$_SQL_CONSULTAS[ ] = $query;

	}

	public	function debugger( ) {

		if( is_array( $this->consultas ) ) {
			echo 'N&deg; de consultas: '. count( $this->consultas ).'<br />';
			echo '<pre><hr />';
				foreach( $this->consultas as $k => $v ) {
					echo $k + 1 . ' - ';
					print_r( $v );
					echo '<hr />';
				}
				echo '</pre>';
		}

		$this->consultas = array( );

	}

	public	function get_last_query( ) {

						return $this->last_query;

	}

	public	static function get_curdate( ) {

						$q = sprintf(" SELECT DATE_FORMAT( %s, '%s' ) AS tiempo" , SQL_MySQL::get_sysTimeStamp( ), FORMATO_MYSQL_DATETIME_LOG );

						$tiempo = SQL_MySQL::ejecuta_query( $q, 'SQL_MySQL::get_curdate( )' );
						$tiempo = SQL_MySQL::get_row( $tiempo );

						return $tiempo['tiempo'];

	}

	public	static	function get_error( ) {

						return $__db->error;

	}

	public	static	function get_num_fields( $rs ) {

						return $rs->field_count;

	}

	public static function get_affected_rows( ) {

						global $__db;

						return $__db->affected_rows;

	}

	public	static	function get_fetch_field( $rs ) {

						return $rs->fetch_field( );

	}

	public	function get_num_dia_de_la_semana( $fecha ) {

				$d	= new DateTime( $fecha );

				switch( strtolower( $d->format( 'D' ) ) ) {

					case 'sun'	: return 1; break;
					case 'mon'	: return 2; break;
					case 'tue'	: return 3; break;
					case 'wed'	: return 4; break;
					case 'thu'	: return 5; break;
					case 'fri'	: return 6; break;
					case 'sat'	: return 7; break;

				}

	}

	public	static	function limpia_lista_db( $v, $num_caracteres = 1 ) {

			return substr( $v, 0, strlen( $v ) - $num_caracteres );

	}

	public	function reset_autoincrement( $tabla ) {

			$this->ejecuta_query( sprintf(" ALTER TABLE %s AUTO_INCREMENT = 1; ", $this->toDBFromDB( $tabla, '', $entrecomillado = false ) ), " ERROR: ALTER TABLE ->reset_autoincrement( ) ");

	}

	public	static	function get_array_record_set( $rs, $row, $utf8 = false ) {

				$aTmp = array( );

				for( $i = 0; $i < SQL_MySQL::get_num_fields( $rs ); $i++ ) {

					$f = SQL_MySQL::get_fetch_field( $rs );

					//$row[ $f->name ] = trim( $row[ $f->name ] );

					if( $utf8 ) {

						if( $utf8 == 'utf8_encode' ) {

							$aTmp[ $f->name ] = utf8_encode( $row[ $f->name ] );

						}

						if( $utf8 == 'utf8_decode' ) {

							$aTmp[ $f->name ] = utf8_decode( $row[ $f->name ] );

						}

					} else {

						$aTmp[ $f->name ] = $row[ $f->name ];

					}

				}

				//Regresa el indice al primer campo
				$rs->field_seek( 0 );

				return $aTmp;

	}


	public	static	function toDBFromForm( $v, $t = '', $entrecomillado = true ) {

			global $__db;

			$v = trim( $__db->real_escape_string( $v ) );

			switch( strtolower( $t ) ) {

				case 'int'				: $v = ( int ) $v;							break;

				case 'float'			: $v = ( float ) $v;						break;

				case 'query'			: 											break;

				case 'tarifa_publica'	: ceil( $v );								break;

				case 'email'			: $v = strtolower( $v );					break;

				case 'nombre'			: $v = ucwords( strtolower( $v ) );			break;

				case 'titulo'			: $v = ucwords( $v );						break;

				case 'texto'			: $v = ucfirst( $v );						break;

				case 'aerolinea'		:
				case 'hotel'			:
				case 'destino'			: $v = ucwords( strtolower( $v ) );			break;

				case 'abreviatura'		: $v = strtoupper( $v );					break;

				case 'password'			: $v = strtolower( md5( $v ) );				break;
				case 'user'				: $v = strtolower( $v );					break;

				case 'localizador'		:
				case 'rfc'				:
				case 'rs'				: $v = strtoupper( $v );					break;

				case 'date'				:

											if( $v == '' ) return 'NULL';

											$v = explode( SEPARADOR_FECHA, $v );

											$v[ 1 ] = SQL_MySQL::convierteMes( strtolower( $v[ 1 ] ), 'txt->int' );

											if( strlen( $v[ 2 ] ) == 2 )
												$v[ 2 ] = '20' . $v[ 2 ];

											$v = implode( SEPARADOR_FECHA, array_reverse( $v ) );

																					break;

				case 'date_int'			: $v = explode( SEPARADOR_FECHA, $v );

											$v[ 1 ] = SQL_MySQL::convierteMes( strtolower( $v[ 1 ] ), 'txt->int' );

											if( strlen( $v[ 2 ] ) == 2 )
												$v[ 2 ] = '20' . $v[ 2 ];

											$v = implode( '', array_reverse( $v ) );


																					break;

			}

			if( $entrecomillado ) {

				$v = ( $v != NULL && $v != '' ) ? "'" . $v . "'" : 'NULL';

			}

			return $v;

	}

	public	static	function toDBFromUtf8( $v, $t = '', $entrecomillado = true ) {

			global $__db;

			$v = strtoupper( $__db->real_escape_string( trim( utf8_decode( $v ) ) ) );

			switch( strtolower( $t ) ) {

				case 'email'			: $v = strtolower( $v );									break;

				case 'date'				:

								$v = explode( SEPARADOR_FECHA, $v );
								$v = implode( '-', array_reverse( $v ) );

							break;
				//
				// case 'date_num'			: $v = implode( SEPARADOR_FECHA, array_reverse( explode( '-', $v ) ) );	break;
				//
				// case 'num_date_txt'		:
				//
				// 						$y	= substr( $v, 0, 4 );
				// 						$m	= SQL_MySQL::convierteMes( substr( $v, 4, 2 ), 'int->txt' );
				// 						$d	= substr( $v, 6, 2 );
				//
				// 						$v	= $d . '-' . $m . '-' . $y;
				//
				// 					break;

			}

			if( $entrecomillado ) {

				$v = ( $v != NULL && $v != '' ) ? "'" . $v . "'" : 'NULL';

			}

			return $v;

	}

	public	static	function toDBFromDB( $v, $t = '', $entrecomillado = true ) {

		global $__db;

		$v = $__db->real_escape_string( trim( $v ) );

		switch( strtolower( $t ) ) {

		}

		if( $entrecomillado ) {

			$v = ( $v != NULL && $v != '' ) ? "'" . $v . "'" : 'NULL';

		}

		return $v;

	}

	public	static	function toAJAX( $v, $type = 'json', $utf8_encode = false, $aplicar = false ) {

			switch( strtolower( $type ) ) {

				case 'json'			:

							if( $utf8_encode ) {

								return json_encode( utf8_encode_recursive( $v, $aplicar ) );

							} else {

								return json_encode( $v );

							}

						break;

				case 'date'			:


							$v = explode( SEPARADOR_FECHA, $v );

							$v[ 1 ] = SQL_MySQL::convierteMes( strtolower( $v[ 1 ] ), 'int->txt' );

							if( $utf8_encode ) {

								return utf8_encode( implode( SEPARADOR_FECHA, array_reverse( $v ) ) );

							} else {

								return implode( SEPARADOR_FECHA, array_reverse( $v ) );
							}

						break;

				case 'txt'			:
				case 'text'			:

							if( $utf8_encode ) {

								return utf8_encode_recursive( $v, $aplicar );

							} else {

								return $v;

							}

						break;

			}

	}

	public	static	function convierteMes( $mes, $tipo ) {

		switch( strtolower( $tipo ) ) {

			case 'int->txt'	:

							switch( $mes ) {

								case '01' : $mes = 'ENE'; break;
								case '02' : $mes = 'FEB'; break;
								case '03' : $mes = 'MAR'; break;
								case '04' : $mes = 'ABR'; break;
								case '05' : $mes = 'MAY'; break;
								case '06' : $mes = 'JUN'; break;
								case '07' : $mes = 'JUL'; break;
								case '08' : $mes = 'AGO'; break;
								case '09' : $mes = 'SEP'; break;
								case '10' : $mes = 'OCT'; break;
								case '11' : $mes = 'NOV'; break;
								case '12' : $mes = 'DIC'; break;

							}

						break;

			case 'txt->int'	:

							switch( strtolower( $mes ) ) {

								case 'ene' : $mes = '01'; break;
								case 'feb' : $mes = '02'; break;
								case 'mar' : $mes = '03'; break;
								case 'abr' : $mes = '04'; break;
								case 'may' : $mes = '05'; break;
								case 'jun' : $mes = '06'; break;
								case 'jul' : $mes = '07'; break;
								case 'ago' : $mes = '08'; break;
								case 'sep' : $mes = '09'; break;
								case 'oct' : $mes = '10'; break;
								case 'nov' : $mes = '11'; break;
								case 'dic' : $mes = '12'; break;

							}

						break;

		}

		return $mes;

	}

	public	static function get_date_add( $fecha, $dias ) {

							$d	= new DateTime( $fecha );

							if( $dias > 0 ) {

								$d->add( new DateInterval( 'P' . abs( $dias ) . 'D' ) );

							} else {

								$d->sub( new DateInterval( 'P' . abs( $dias ) . 'D' ) );

							}

							$a = array( );

							switch( strtolower( $d->format( 'D' ) ) ) {

								case 'sun'	: $a['dia_semana'] = 'D';	break;
								case 'mon'	: $a['dia_semana'] = 'L';	break;
								case 'tue'	: $a['dia_semana'] = 'M';	break;
								case 'wed'	: $a['dia_semana'] = 'X';	break;
								case 'thu'	: $a['dia_semana'] = 'J';	break;
								case 'fri'	: $a['dia_semana'] = 'V';	break;
								case 'sat'	: $a['dia_semana'] = 'S';	break;

							}

							$a['fecha']	= $d->format('Y-m-d');

							return $a;

	}

	public	static function get_date_diff( $fecha_a, $fecha_b ) {

					$d0			= new DateTime( $fecha_b );
					$d1			= new DateTime( $fecha_a );
					$interval	= $d0->diff( $d1 );

					return $interval->format('%a');

	}

}
?>
