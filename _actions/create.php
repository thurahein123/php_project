<?php

include("../vendor/autoload.php");

use Libs\Database\Mysql;
use Libs\Database\UserTable;
use Helpers\HTTP;

$data = [
    "name" => $_POST['name'] ?? "Unknown",
    "email" => $_POST['email'] ?? "Unknown",
    "phone" => $_POST['phone'] ?? "Unknown",
    "address" => $_POST['address'] ?? "Unknown",
    "password" => md5($_POST['password']),
    "role_id" => "1",
];

$table = new UserTable(new Mysql());

if($table) {
    $table->insert($data);
    HTTP::redirect("/index.php", "registered=true");
} else {
    HTTP::redirect("/register.php", "error=true");
}
