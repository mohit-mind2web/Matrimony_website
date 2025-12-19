<?php 

define('APPROOT',dirname(__DIR__));
require_once APPROOT .'/../vendor/autoload.php';
use Dotenv\Dotenv;
$dotenv=Dotenv::createImmutable(APPROOT . '/..');
$dotenv->load();