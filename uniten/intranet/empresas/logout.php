<?php
require_once '../util/config.php';

unset($_SESSION['EMPRESA']);
session_destroy();

gotox('index.php');

