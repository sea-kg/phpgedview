<?php
global $gBitSystem;

$gBitSystem->registerPackage( 'phpgedview',  dirname( __FILE__ ).'/' );

if( $gBitSystem->isPackageActive( PHPGEDVIEW_PKG_NAME ) ) {
	$gBitSystem->registerAppMenu( PHPGEDVIEW_PKG_DIR, 'Genealogy', PHPGEDVIEW_PKG_URL.'index.php', 'bitpackage:phpgedview/menu_phpgedview.tpl', PHPGEDVIEW_PKG_NAME );
}

if( !defined( 'PHPGEDVIEW_DB_PREFIX' ) ) {
	$lastQuote = strrpos( BIT_DB_PREFIX, '`' );
	if( $lastQuote != FALSE ) {
		$lastQuote++;
	}
	$prefix = substr( BIT_DB_PREFIX,  $lastQuote );
	define( 'PHPGEDVIEW_DB_PREFIX', $prefix.'pgv_' );
}

$INDEX_DIRECTORY = 'c:\\Data\\';
?>
