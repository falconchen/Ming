<?php

switch($_SERVER['HTTP_HOST']) {
	
	case 'ming.cellmean.com':
		require 'ming.cellmean.com.php';
	break; 
	case 'lilian.cellmean.com':
		require 'lilian.cellmean.com.php';
	break; 
	case 'ming.diyhub.net':
	default:
		require 'ming.diyhub.net.php';	
}
