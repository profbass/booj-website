<?php 
if (!empty($_SERVER['REQUEST_URI'])) {
	if ($_SERVER['REQUEST_URI'] == '/careers/' || $_SERVER['REQUEST_URI'] == '/careers' || isset($_REQUEST['utm_source'])) {
		header('Location: /career-portal');
		die();
	}
}