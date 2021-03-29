<?php

class Archivo extends SQL_MySQL
{

	function __construct( ) {}


	function archivo_set( $file, $dir, $nombre ) {

		$ext = explode( '.', $file['name'] );
		$ext = '.' . $ext[ 1 ];

		if( move_uploaded_file ( $file['tmp_name'] , $dir . $nombre . $ext ) ) {

			return $nombre . $ext;

		}

		return false;

	}

}

?>
