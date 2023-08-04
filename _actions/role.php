<?php

include('../vendor/autoload.php');

use Libs\Database\Mysql;
use Libs\Database\UserTable;
use Helpers\Auth;
use Helpers\HTTP;

$table = new UserTable(new Mysql());
$auth = Auth::check();

$id = $_GET['id'];
$role = $_GET['role'];
$table->changeRole($id, $role);

HTTP::redirect("/admin.php");