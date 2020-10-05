<?
function utf8_encode_recursive( $a ) {

	if( is_array( $a ) ) {

		foreach( $a as $k => $v ) {

			if( is_array( $v ) ) {

				$a[ $k ] = utf8_encode_recursive( $v );

			} else {
				$a[ $k ] = utf8_encode( $v );
			}

		}

	} else {

		if( is_object( $a ) ) {

			$vars = array_keys( get_object_vars( $a ) );

			foreach( $vars as $k => $v ) {

				eval('$a->' . $v . ' = utf8_encode_recursive( $a->' . $v . ' );');

			}

		} else {

			$a = utf8_encode( $a );

		}

	}

	return $a;

}
function utf8_decode_recursive( $a, $aplicar = false ) {

	if( is_array( $a ) ) {

		foreach( $a as $k => $v ) {

			if( is_array( $v ) ) {

				$a[ $k ] = utf8_decode_recursive( $v );

			} else {

				if( $aplicar ) {

					eval( '$a[ $k ] = utf8_decode( ' . $aplicar . '( $v ) );' );

				} else {

					$a[ $k ] = utf8_decode( $v );

				}

			}

		}

	} else {

		if( is_object( $a ) ) {

			$vars = array_keys( get_object_vars( $a ) );

			foreach( $vars as $k => $v ) {

				eval('$a->' . $v . ' = utf8_decode_recursive( $a->' . $v . ' );');

			}

		} else {

			if( $aplicar ) {

				eval( '$a = utf8_decode( ' . $aplicar . '( $v ) );' );

			} else {

				$a = utf8_decode( $a );

			}

		}

	}

	return $a;

}

function fixObj( &$obj ) {
	//if( !is_object( $obj ) && gettype( $obj ) == 'object' ) {
		return unserialize( serialize( $obj ) );
	//}
	//return $obj;
}

function antepon_ceros( $numero, $formato, $prefijo = '' ) {

	for( $i = 0 ; $i < $formato - strlen( $numero ); $i++ ) {

		$text .= '0';

	}

	return $prefijo . $text . $numero;

}
function toHTML( $v, $t = '', $ajax = false ) {

	switch( strtolower( $t ) ) {

		case 'charter_pax'							:

							if( $v == '0' ) {

								return '';

							} else {

								return $v;

							}

						break;


		case 'charter_pax_total'					:
		case 'charter_pago_total'					:

							if( $v == 0 ) {

								return '';

							} else {

								$v = $v == '' ? 0 : $v;
								$v = number_format( $v, 2, '.', ',' );

							}

						break;

		case 'numero_de_tarteja_oculto'				:

							$v = 'XXXX-XXXX-XXXX-' . substr( $v, -4 );

						break;

		case 'numero_de_tarteja_ultimos_digitos'	:

							$v = substr( $v, -4 );

						break;

		case 'date_num'								:

							$v = implode( SEPARADOR_FECHA, array_reverse( explode( SEPARADOR_FECHA, $v ) ) );
						//break;
		case 'date'									:
		case 'datecompleto'							:
		case 'datemesdia'							:
		case 'date_paquete_salida'					:

							$v = explode( SEPARADOR_FECHA, $v );

							switch( $v[ 1 ] ) {

								case '01' : $v[ 1 ] = 'ENE'; break;
								case '02' : $v[ 1 ] = 'FEB'; break;
								case '03' : $v[ 1 ] = 'MAR'; break;
								case '04' : $v[ 1 ] = 'ABR'; break;
								case '05' : $v[ 1 ] = 'MAY'; break;
								case '06' : $v[ 1 ] = 'JUN'; break;
								case '07' : $v[ 1 ] = 'JUL'; break;
								case '08' : $v[ 1 ] = 'AGO'; break;
								case '09' : $v[ 1 ] = 'SEP'; break;
								case '10' : $v[ 1 ] = 'OCT'; break;
								case '11' : $v[ 1 ] = 'NOV'; break;
								case '12' : $v[ 1 ] = 'DIC'; break;

							}

							if( $t != 'dateCompleto' ) {

								$v[ 0 ] = substr( $v[ 0 ], 2 );

							}

							if( $t == 'dateMesDia' ) {

								unset( $v[ 0 ] );

							}

							$v = implode( SEPARADOR_FECHA, array_reverse( $v ) );

						break;

		case 'datetime'								:
		case 'datetimecompleto'						:

							$time = explode( ' ', $v );
							$v    = $time[ 0 ];
							$time = $time[ 1 ];

							$v = explode( SEPARADOR_FECHA, $v );

							switch( $v[ 1 ] ) {

								case '01' : $v[ 1 ] = 'ENE'; break;
								case '02' : $v[ 1 ] = 'FEB'; break;
								case '03' : $v[ 1 ] = 'MAR'; break;
								case '04' : $v[ 1 ] = 'ABR'; break;
								case '05' : $v[ 1 ] = 'MAY'; break;
								case '06' : $v[ 1 ] = 'JUN'; break;
								case '07' : $v[ 1 ] = 'JUL'; break;
								case '08' : $v[ 1 ] = 'AGO'; break;
								case '09' : $v[ 1 ] = 'SEP'; break;
								case '10' : $v[ 1 ] = 'OCT'; break;
								case '11' : $v[ 1 ] = 'NOV'; break;
								case '12' : $v[ 1 ] = 'DIC'; break;

							}

							if( $t != 'datetimeCompleto' )
								$v[ 0 ] = substr( $v[ 0 ], 2 );

							$v = implode( SEPARADOR_FECHA, array_reverse( $v ) ) . ' ' . $time;

						break;

		case 'horario_vuelo'						:

							$time = explode( ':', $v );

							$v = $time[0] . ':' . $time[1];

						break;

		case 'monetario'							:

							$v = $v == '' ? 0 : $v;
							$v = number_format( $v, 2, '.', ',' );

						break;

		case 'moneda_expo'							:

									$v = ceil( $v );

									if( $v == 0 ) {

										return LEYENDA_NO_APLICA;

									}


						break;

		case 'porcentaje'							:

									$v = number_format( $v, 2, '.', ',' );
									$v .= '%';

						break;

		case 'tarifa_neta_sin_descuento'			:
		case 'tarifa_publica_sin_descuento'			:

									if( $v != '' ) {

										if( $v > 0 ) {

											if( $_SESSION['usuario']['rol_id'] != USER_ROL_ID_ADMINISTRADOR ) {
													$v = INCREMENTAR_TARIFAS ? $v + INCREMENTO_DE_TARIFAS : $v;
											}
											if(strpos(strtolower( $t ), 'publica') !== false){
												$v = number_format( $v, 0, '', '' );
											}

										} else {

											$v = '';

										}

									} else {

										return LEYENDA_NO_APLICA;

									}

								return '<span class="descuento">' . $v . '</span><br />';

						break;

		case 'tarifa_neta'							:
		case 'tarifa_publica'						:

									if( $v != '' ) {

										if( $v > 0 ) {

											if( $_SESSION['usuario']['rol_id'] != USER_ROL_ID_ADMINISTRADOR ) {
													$v = INCREMENTAR_TARIFAS ? $v + INCREMENTO_DE_TARIFAS : $v;
											}
											if(strpos(strtolower( $t ), 'publica') !== false){
												$v = number_format( $v, 0, '', '' );
											}


										} else {

											$v = '';

										}

									} else {

										return LEYENDA_NO_APLICA;

									}

						break;

		case 'tarifa_neta_mnr_input'				:
		case 'tarifa_neta_jr_input'				:
		case 'tarifa_publica_mnr_input'				:
		case 'tarifa_publica_jr_input'				:

									if( $v != '' ) {

										if(strpos(strtolower( $t ), 'publica') !== false){
											$v = number_format( $v, 0, '', '' );
										}

									} else {

										return '';

									}

						break;

		case 'tarifa_neta_mnr_sc'				:
		case 'tarifa_publica_mnr_sc'				:

									if( $v['edad_menor_sin_cargo'] != '' ) {
										return 0;
									} else {
										return LEYENDA_NO_APLICA;
									}

						break;

		case 'tarifa_neta_mnr_sin_descuento'		:
		case 'tarifa_neta_jr_sin_descuento'		:
		case 'tarifa_publica_mnr_sin_descuento'		:
		case 'tarifa_publica_jr_sin_descuento'		:

									if( $v != '' ) {

										if( $_SESSION['usuario']['rol_id'] != USER_ROL_ID_ADMINISTRADOR ) {
												$v = INCREMENTAR_TARIFAS ? $v + INCREMENTO_DE_TARIFAS : $v;
										}
										if(strpos(strtolower( $t ), 'publica') !== false){
											$v = number_format( $v, 0, '', '' );
										}

									} else {

										return LEYENDA_NO_APLICA;

									}

								return '<span class="descuento">' . $v . '</span><br />';

						break;


		case 'tarifa_neta_mnr'					:
		case 'tarifa_neta_jr'					:
		case 'tarifa_publica_mnr'					:
		case 'tarifa_publica_jr'					:

									if( $v != '' ) {

										if( $_SESSION['usuario']['rol_id'] != USER_ROL_ID_ADMINISTRADOR ) {
												$v = INCREMENTAR_TARIFAS ? $v + INCREMENTO_DE_TARIFAS : $v;
										}
										if(strpos(strtolower( $t ), 'publica') !== false){
											$v = number_format( $v, 0, '', '' );
										}

									} else {

										return LEYENDA_NO_APLICA;

									}

						break;

		case 'edad_mnr_sc'							:

									if( $v['edad_menor_con_cargo'] != '' ) {

										if( $v['edad_menor_sin_cargo'] != '' ) {

											$v = '0' . SEPARADOR_EDAD_MENORES . ( $v['edad_menor_con_cargo'] - 1 );

										} else {

											if( $v['edad_menor_con_cargo'] != '0' ) {

												$v = '0' . SEPARADOR_EDAD_MENORES . ( $v['edad_menor_con_cargo'] - 1 );

											} else {

												return LEYENDA_NO_APLICA;

											}

										}

									} else {

										if( $v['edad_junior'] != '' ) {

											$v = '0' . SEPARADOR_EDAD_MENORES . ( $v['edad_junior'] - 1 );

										} else {

											if( $v['edad_adulto'] != '' ) {

												$v = '0' . SEPARADOR_EDAD_MENORES . ( $v['edad_adulto'] - 1 );

											} else {

												return LEYENDA_NO_APLICA;

											}

										}

									}

						break;

		case 'edad_mnr_cc'							:

									if( $v['edad_menor_con_cargo'] != '' ) {

										if( $v['edad_junior'] == '' ) {

											$v = $v['edad_menor_con_cargo'] . SEPARADOR_EDAD_MENORES . ( (int) $v['edad_adulto'] - 1 );

										} else {

											$v = $v['edad_menor_con_cargo'] . SEPARADOR_EDAD_MENORES . ( $v['edad_junior'] - 1 );

										}

									} else {

										return LEYENDA_NO_APLICA;

									}

						break;

		case 'edad_jr'								:

									if( $v['edad_junior'] != '' ) {

										$v = $v['edad_junior'] . SEPARADOR_EDAD_MENORES . ( $v['edad_adulto'] - 1 );

									} else {

										return LEYENDA_NO_APLICA;

									}

						break;

		case 'tarifa_base'							:

									if( $v > 0 ) {

										$v = round( $v, 0 );

									} else {

										return '';//'<span class="comentario">-</span>';

									}

						break;

		case 'tarifa_nota_input'					:

									return stripcslashes( $v );

						break;

		case 'observaciones'						:
		case 'tarifa_nota'							:

									$v = stripcslashes( $v );

						break;

		case 'contador_alfabetico'					:

									$v = utf8_decode( chr( ( int ) $v + 64 ) );

						break;
		case 'html_title' 							:

									$buscar     = array( chr( 10 )	,  chr( 13 ) );
									$v = str_replace( $buscar, array(' / ',''), htmlspecialchars( $v , ENT_QUOTES, 'ISO-8859-1' ) );

									return $ajax ? utf8_encode( $v ) : $v;

						break;

	}

	$buscar     = array( chr( 10 )	,  chr( 13 )	, urldecode( '%0D' ) );
	$reemplazar = array( '<br />'	, ''	 		, ' '                );

	$v = str_replace( $buscar, $reemplazar, htmlspecialchars( $v , ENT_QUOTES, 'ISO-8859-1' ) );

	if( $ajax ) {

		$v = utf8_encode( $v );

	}

	return $v;

}

function debugger( ) {

	echo '<div id="debugger_container" style="display: inline-block; background: #333; margin: 20px 10px; padding: 20px; color:#fff; border-radius: 5px; z-index:1;">';
	echo '<div id="dbg_info" style="text-align: left; font-weight: bold; color: #999; overflow: visible;">PHP Debugger versi&oacute;n 1.3 Balleza Web Studio &copy;</div><br />';
	echo '<div id="debugger">';

			//Debugger encabezado
			echo '<div id="dbg_encabezado">';

			global $_TIEMPO_INICIO;
			global $_SQL_CONSULTAS;
			global $_HotelBeds_REQUEST;

			echo '</div>';

			//Consultas
			if( count( $_SQL_CONSULTAS ) ) {

				echo '<hr /><span style="font-weight: bold; color: #C60;">CONSULTAS</span>';
				echo '<pre>';
					print_r( $_SQL_CONSULTAS );
				echo '</pre>';

			}
			//Post
			if( count( $_POST ) ) {

				echo '<hr /><span style="font-weight: bold; color: #C60;">POST</span>';
				echo '<pre>';
					print_r( $_POST );
				echo '</pre>';

			}
			//Files
			if( count( $_FILES ) ) {

				echo '<tr><td>';
				echo '<hr /><span style="font-weight: bold; color: #C60;">FILES</span>';
				echo '<pre>';
					print_r( $_FILES );
				echo '</pre>';
				echo '<hr />';
				echo '</td></tr>';

			}
			//Session
			if( count( $_SESSION ) ) {

				$tmp = $_SESSION;

				echo '<tr><td>';
				echo '<hr /><span style="font-weight: bold; color: #C60;">SESSION</span>';
				echo '<pre>';
					print_r( $tmp );
				echo '</pre>';
				echo '</td></tr>';

			}

			echo '<hr /><span style="font-weight: bold; color: #C60;">PHP Version: ' . phpversion( ) . ', DB HOST: ' . DB_HOSTNAME . ', DB: ' . DB_DATABASE . '</span>';
			echo '<br /><span style="font-weight: bold; color: #C60;">Memoria usada: ' . round( memory_get_usage( ) / 1024 / 1024, 2 ) . ' MB de ' . round( memory_get_peak_usage( ) / 1024 / 1024, 2 ) . ' MB</span>';
			echo '</div>';
	echo '</div>';
	echo '</div>';

}
?>
