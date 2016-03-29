<?php
require_once 'util/config.php';

unset($_SESSION['USER']);
session_destroy();

gotox('index.php');

