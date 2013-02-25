<?php 
if (!empty($_SERVER['REQUEST_URI'])) {
	if ($_SERVER['REQUEST_URI'] == '/careers/' || $_SERVER['REQUEST_URI'] == '/careers') {
		header('Location: /career-portal');
		die();
	}
}