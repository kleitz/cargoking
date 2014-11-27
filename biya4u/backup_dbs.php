<?php

######################################################################
## MySQL Backup Script v2.1 - May 3, 2007
######################################################################
## For more documentation and new versions, please visit:
## http://www.dagondesign.com/articles/automatic-mysql-backup-script/
## -------------------------------------------------------------------
## Created by Dagon Design (www.dagondesign.com).
## Much credit goes to Oliver Mueller (oliver@teqneers.de)
## for contributing additional features, fixes, and testing.
######################################################################

######################################################################
## Usage Instructions
######################################################################
## This script requires two files to run:
##     backup_dbs.php        - Main script file
##     backup_dbs_config.php - Configuration file
## Be sure they are in the same directory.
## -------------------------------------------------------------------
## Do not edit the variables in the main file. Use the configuration
## file to change your settings. The settings are explained there.
## -------------------------------------------------------------------
## A few methods to run this script:
## - php /PATH/backup_dbs.php
## - BROWSER: http://domain/PATH/backup_dbs.php
## - ApacheBench: ab "http://domain/PATH/backup_dbs.php"
## - lynx http://domain/PATH/backup_dbs.php
## - wget http://domain/PATH/backup_dbs.php
## - crontab: 0 3  * * *     root  php /PATH/backup_dbs.php
## -------------------------------------------------------------------
## For more information, visit the website given above.
######################################################################

error_reporting( E_ALL );

// Initialize default settings
$MYSQL_PATH = '/usr/bin';
$MYSQL_HOST = 'localhost';
$MYSQL_USER = 'root';
$MYSQL_PASSWD = 'password';
$BACKUP_DEST = '/db_backups';
$BACKUP_TEMP = '/tmp/backup_temp';
$VERBOSE = true;
$BACKUP_NAME = 'mysql_backup_' . date('Y-m-d');
$LOG_FILE = $BACKUP_NAME . '.log';
$ERR_FILE = $BACKUP_NAME . '.err';
$COMPRESSOR = 'bzip2';
$EMAIL_BACKUP = false;
$DEL_AFTER = false;
$EMAIL_FROM = 'Backup Script';
$EMAIL_SUBJECT = 'SQL Backup for ' . date('Y-m-d') . ' at ' . date('H:i');
$EMAIL_ADDR = 'user@domain.com';
$ERROR_EMAIL = 'user@domain.com';
$ERROR_SUBJECT = 'ERROR: ' . $EMAIL_SUBJECT;
$EXCLUDE_DB = 'information_schema';
$MAX_EXECUTION_TIME = 18000;
$USE_NICE = 'nice -n 19';
$FLUSH = false;
$OPTIMIZE = false;

// Load configuration file
$current_path = dirname(__FILE__);
if( file_exists( $current_path.'/backup_dbs_config.php' ) ) {
	require( $current_path.'/backup_dbs_config.php' );
} else {
	echo 'No configuration file [backup_dbs_config.php] found. Please check your installation.';
	exit;
}

################################
# functions
################################
/**
 * Write normal/error log to a file and output if $VERBOSE is active
 * @param string	$msg
 * @param boolean	$error
 */
function writeLog( $msg, $error = false ) {

	// add current time and linebreak to message
	$fileMsg = date( 'Y-m-d H:i:s: ') . trim($msg) . "\n";

	// switch between normal or error log
	$log = ($error) ? $GLOBALS['f_err'] : $GLOBALS['f_log'];

	if ( !empty( $log ) ) {
		// write message to log
		fwrite($log, $fileMsg);
	}

	if ( $GLOBALS['VERBOSE'] ) {
		// output to screen
		echo $msg . "\n";
		flush();
	}
} // function

/**
 * Checks the $error and writes output to normal and error log.
 * If critical flag is set, execution will be terminated immediately
 * on error.
 * @param boolean	$error
 * @param string	$msg
 * @param boolean	$critical
 */
function error( $error, $msg, $critical = false ) {

	if ( $error ) {
		// write error to both log files
		writeLog( $msg );
		writeLog( $msg, true );

		// terminate script if this error is critical
		if ( $critical ) {
			die( $msg );
		}

		$GLOBALS['error']	= true;
	}
} // function



################################
# main
################################

// set header to text/plain in order to see result correctly in a browser
header( 'Content-Type: text/plain; charset="UTF-8"' );
header( 'Content-disposition: inline' );

// set execution time limit
if( ini_get( 'max_execution_time' ) < $MAX_EXECUTION_TIME ) {
	set_time_limit( $MAX_EXECUTION_TIME );
}

// initialize error control
$error = false;

// guess and set host operating system
if( strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN' ) {
	$os			= 'unix';
	$backup_mime	= 'application/x-tar';
	$BACKUP_NAME	.= '.tar';
} else {
	$os			= 'windows';
	$backup_mime	= 'application/zip';
	$BACKUP_NAME	.= '.zip';
}


// create directories if they do not exist
if( !is_dir( $BACKUP_DEST ) ) {
	$success = mkdir( $BACKUP_DEST );
	error( !$success, 'Backup directory could not be created in ' . $BACKUP_DEST, true );
}
if( !is_dir( $BACKUP_TEMP ) ) {
	$success = mkdir( $BACKUP_TEMP );
	error( !$success, 'Backup temp directory could not be created in ' . $BACKUP_TEMP, true );
}

// prepare standard log file
$log_path = $BACKUP_DEST . '/' . $LOG_FILE;
($f_log = fopen($log_path, 'w')) || error( true, 'Cannot create log file: ' . $log_path, true );

// prepare error log file
$err_path = $BACKUP_DEST . '/' . $ERR_FILE;
($f_err = fopen($err_path, 'w')) || error( true, 'Cannot create error log file: ' . $err_path, true );

// Start logging
writeLog( "Executing MySQL Backup Script v1.4" );
writeLog( "Processing Databases.." );


################################
# DB dumps
################################
$excludes	= array();
if( trim($EXCLUDE_DB) != '' ) {
	$excludes	= array_map( 'trim', explode( ',', $EXCLUDE_DB ) );
}

// Loop through databases
$db_conn	= @mysql_connect( $MYSQL_HOST, $MYSQL_USER, $MYSQL_PASSWD ) or error( true, mysqli_error(), true );
$db_result	= mysql_list_dbs($db_conn);
$db_auth	= " --host=\"$MYSQL_HOST\" --user=\"$MYSQL_USER\" --password=\"$MYSQL_PASSWD\"";
while ($db_row = mysqli_fetch_object$db_result)) {
	$db = $db_row->Database;

	if( in_array( $db, $excludes ) ) {
		// excluded DB, go to next one
		continue;
	}

	// dump db
	unset( $output );
	exec( "$MYSQL_PATH/mysqldump $db_auth --opt $db 2>&1 >$BACKUP_TEMP/$db.sql", $output, $res);
	if( $res > 0 ) {
		error( true, "DUMP FAILED\n".implode( "\n", $output) );
	} else {
		writeLog( "Dumped DB: " . $db );

		if( $OPTIMIZE ) {
			unset( $output );
			exec( "$MYSQL_PATH/mysqlcheck $db_auth --optimize $db 2>&1", $output, $res);
			if( $res > 0 ) {
				error( true, "OPTIMIZATION FAILED\n".implode( "\n", $output) );
			} else {
				writeLog( "Optimized DB: " . $db );
			}
		} // if
	} // if

	// compress db
	unset( $output );
	if( $os == 'unix' ) {
		exec( "$USE_NICE $COMPRESSOR $BACKUP_TEMP/$db.sql 2>&1" , $output, $res );
	} else {
		exec( "zip -mj $BACKUP_TEMP/$db.sql.zip $BACKUP_TEMP/$db.sql 2>&1" , $output, $res );
	}
	if( $res > 0 ) {
		error( true, "COMPRESSION FAILED\n".implode( "\n", $output) );
	} else {
		writeLog( "Compressed DB: " . $db );
	}

	if( $FLUSH ) {
		unset( $output );
		exec("$MYSQL_PATH/mysqladmin $db_auth flush-tables 2>&1", $output, $res );
		if( $res > 0 ) {
			error( true, "Flushing tables failed\n".implode( "\n", $output) );
		} else {
			writeLog( "Flushed Tables" );
		}
	} // if

} // while

mysqli_free_result($db_result);
mysqli_close($db_conn);


################################
# Archiving
################################

// TAR the files
writeLog( "Archiving files.. " );
chdir( $BACKUP_TEMP );
unset( $output );
if( $os	== 'unix' ) {
	exec("cd $BACKUP_TEMP ; $USE_NICE tar cf $BACKUP_DEST/$BACKUP_NAME * 2>&1", $output, $res);
} else {
	exec("zip -j -0 $BACKUP_DEST/$BACKUP_NAME * 2>&1", $output, $res);
}
if ( $res > 0 ) {
	error( true, "FAILED\n".implode( "\n", $output) );
} else {
	writeLog( "Backup complete!" );
}

// first error check, so we can add a message to the backup email in case of error
if ( $error ) {
	$msg	= "\n*** ERRORS DETECTED! ***";
	if( $ERROR_EMAIL ) {
		$msg	.= "\nCheck your email account $ERROR_EMAIL for more information!\n\n";
	} else {
		$msg	.= "\nCheck the error log {$err_path} for more information!\n\n";
	}

	writeLog( $msg );
}


################################
# post processing
################################

// do we email the backup file?
if ($EMAIL_BACKUP) {
	writeLog( "Emailing backup to " . $EMAIL_ADDR . " .. " );

	$headers = "From: " . $EMAIL_FROM . " <root@localhost>";
	// Generate a boundary string
	$rnd_str = md5(time());
	$mime_boundary = "==Multipart_Boundary_x{$rnd_str}x";

	// Add headers for file attachment
	$headers .= "\nMIME-Version: 1.0\n" .
		"Content-Type: multipart/mixed;\n" .
		" boundary=\"{$mime_boundary}\"";

	// Add a multipart boundary above the plain message
	$body = "This is a multi-part message in MIME format.\n\n" .
		"--{$mime_boundary}\n" .
		"Content-Type: text/plain; charset=\"iso-8859-1\"\n" .
		"Content-Transfer-Encoding: 7bit\n\n" .
		file_get_contents($log_path) . "\n\n";

	// make Base64 encoding for file data
	$data = chunk_split(base64_encode(file_get_contents($BACKUP_DEST.'/'.$BACKUP_NAME)));

	// Add file attachment to the message
	$body .= "--{$mime_boundary}\n" .
		"Content-Type: {$backup_mime};\n" .
		" name=\"{$BACKUP_NAME}\"\n" .
		"Content-Disposition: attachment;\n" .
		" filename=\"{$BACKUP_NAME}\"\n" .
		"Content-Transfer-Encoding: base64\n\n" .
		$data . "\n\n" .
		"--{$mime_boundary}--\n";

	$res = mail( $EMAIL_ADDR, $EMAIL_SUBJECT, $body, $headers );
	if ( !$res ) {
		error( true, 'FAILED to email mysql dumps.' );
	}
}


// do we delete the backup file?
if ( $DEL_AFTER && $EMAIL_BACKUP ) {
	writeLog( "Deleting file.. " );

	if ( file_exists( $BACKUP_DEST.'/'.$BACKUP_NAME ) ) {
		$success = unlink( $BACKUP_DEST.'/'.$BACKUP_NAME );
		error( !$success, "FAILED\nUnable to delete backup file" );
	}
}

// see if there were any errors to email
if ( ($ERROR_EMAIL) && ($error) ) {
	writeLog( "\nThere were errors!" );
	writeLog( "Emailing error log to " . $ERROR_EMAIL . " .. " );

	$headers = "From: " . $EMAIL_FROM . " <root@localhost>";
	$headers .= "MIME-Version: 1.0\n";
	$headers .= "Content-Type: text/plain; charset=\"iso-8859-1\";\n";
	$body = "\n".file_get_contents($err_path)."\n";

	$res = mail( $ERROR_EMAIL, $ERROR_SUBJECT, $body, $headers );
	if( !$res ) {
		error( true, 'FAILED to email error log.' );
	}
}


################################
# cleanup / mr proper
################################

// close log files
fclose($f_log);
fclose($f_err);

// if error log is empty, delete it
if( !$error ) {
	unlink( $err_path );
}

// delete the log files if they have been emailed (and del_after is on)
if ( $DEL_AFTER && $EMAIL_BACKUP ) {
        if ( file_exists( $log_path ) ) {
                $success = unlink( $log_path );
                error( !$success, "FAILED\nUnable to delete log file: ".$log_path );
        }
        if ( file_exists( $err_path ) ) {
                $success = unlink( $err_path );
                error( !$success, "FAILED\nUnable to delete error log file: ".$err_path );
        }
}

// remove files in temp dir
if ($dir = @opendir($BACKUP_TEMP)) {
	while (($file = readdir($dir)) !== false) {
		if (!is_dir($file)) {
			unlink($BACKUP_TEMP.'/'.$file);
		}
	}
}
closedir($dir);

// remove temp dir
rmdir($BACKUP_TEMP);

?>
