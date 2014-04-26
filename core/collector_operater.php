<?php

require_once '../includes/application_top.php';
require_once 'dir_handler.php';
require_once 'url_handler.php';
require_once 'curl_transfer.php';
require_once 'collector_core.php';
require_once 'collector_log.php';

$_SESSION['username'] = "root";
$pageURL = $_POST['object_url'];
$collect_type = $_POST['collect_type'];
$collector = new collector_core($pageURL, $collect_type);
$result = $collector->go_collecting();
?>