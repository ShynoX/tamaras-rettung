<?php
	DEFINE( 'KEY_HASH', '994a97b3e1e85878aee2702b48549a37' );
	DEFINE( 'FILE_HASH', '68f264d9a908f93e8ffea4fb8e77e799' );

	$stKeyFile       = NULL;
	$stEncryptedFile = NULL;

	$aDir = array_diff( scandir( dirname( __FILE__ ) . '/files' ), Array( '.',
	                                                                      '..' ) );
	foreach( $aDir as $stFile ) {
		if( !is_readable( dirname( __FILE__ ) . '/files/' . $stFile ) )
			continue;

		if( $stKeyFile == NULL && md5( file_get_contents( dirname( __FILE__ ) . '/files/' . $stFile ) ) == KEY_HASH )
			$stKeyFile = $stFile;
		if( $stEncryptedFile == NULL && md5( file_get_contents( dirname( __FILE__ ) . '/files/' . $stFile ) ) == FILE_HASH )
			$stEncryptedFile = $stFile;

		if( $stKeyFile != NULL && $stEncryptedFile != NULL )
			break;
	}

	if( $stKeyFile == NULL )
		exit( '[-] Could not find matching key file! <br>' );
	else
		echo( '[+] Key File: ' . $stKeyFile . '<br>' );

	if( $stEncryptedFile == NULL )
		exit( '[-] Could not find matching encrypted file! <br>' );
	else
		echo( '[+] Encrypted File' . $stEncryptedFile . "<br>" );


	/*
	 * Decrypt file using RSA Key
	 */
	$stDecryptedMessage = NULL;
	openssl_private_decrypt( file_get_contents( dirname( __FILE__ ) . '/files/' . $stEncryptedFile ),
	                         $stDecryptedMessage,
	                         file_get_contents( dirname( __FILE__ ) . '/files/' . $stKeyFile ) );

	echo( '[+] RESULT: ' . $stDecryptedMessage );
?>