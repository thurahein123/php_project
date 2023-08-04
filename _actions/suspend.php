<?php

include("../vendor/autoload.php");

use Libs\Database\Mysql;
use Libs\Database\UserTable;
use Helpers\Auth;
use Helpers\HTTP;

$auth = Auth::check();

$table = new UserTable(new Mysql());
$id = $_GET['id'];

$table->suspend($id);

HTTP::redirect("/admin.php");