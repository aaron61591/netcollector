<?php

require_once 'configure.php';
if (!ini_get('session.auto_start')) {
    session_start();
}
?>