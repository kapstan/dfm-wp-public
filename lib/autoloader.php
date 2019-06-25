<?php
/**
 * Autoloader for plugin dependencies.
 *
 * @since      1.0.0
 * @package    dfm-wp-public
 * @subpackage dfm-wp-public/lib
 * @author     Ian Kaplan <ian.c.kaplan@protonmail.com>
 */

namespace DFM\Lib;

/**
 * Automatically loads specified class files.
 *
 * Looks at fully-qualified class name, splits path,
 * and creates a new path string reflective of the class file's
 * location in the fs.
 *
 * @since      1.0.0
 * @package    dfm-wp-public
 * @subpackage dfm-wp-public/lib
 * @param      function The handler describing the autoloader we're registering.
 */
spl_autoload_register(
	function( $file_name ) {
		$file_path = explode( '\\', $file_name );

		if ( isset( $file_path[ count( $file_path ) - 1 ] ) ) :
			$class_file = strtolower( $file_path[ count( $file_path ) - 1 ] );
			$class_file = str_ireplace( '_', '-', $class_file );
			$class_file = "class-$class_file.php";
		endif;

		$fq_path = trailingslashit( dirname( dirname( __FILE__ ) ) );

		for ( $i = 1; $i < count( $file_path ) - 1; $i++ ) :
			$dir      = strtolower( $file_path[ $i ] );
			$fq_path .= trailingslashit( $dir );
		endfor;

		$fq_path .= $class_file;

		if ( file_exists( $fq_path ) ) :
			include_once( $fq_path );
		endif;
	}
);
