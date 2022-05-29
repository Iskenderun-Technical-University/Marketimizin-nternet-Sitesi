<?php

ob_start();
session_start();

$config = require 'src/config.php';
global $config;

$db = require 'src/db.php';
global $db;
