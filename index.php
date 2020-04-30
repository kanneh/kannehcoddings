<?php
	require_once 'config.php';
        if(!defined('DB_DATABASE')){
            header("Location:installer/");
            exit();
        }
	require_once 'main.php';
