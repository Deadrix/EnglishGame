<?php
session_start();
$_SESSION = array();
header("Location: /src/vue/rules.php");
