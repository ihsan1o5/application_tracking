<?php

	ob_start();
	session_start();
	header('Location: applypage.php');
	session_destroy();

?>