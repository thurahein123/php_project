<?php

include("../vendor/autoload.php");

use Libs\Database\Mysql;
use Libs\Database\UserTable;
use Helpers\Auth;
use Helpers\HTTP;

$auth = Auth::check();
$table = new UserTable(new Mysql());

$name = $_FILES['photo']['name'];
$tmp = $_FILES['photo']['tmp_name'];
$type = $_FILES['photo']['type'];
$error = $_FILES['photo']['error'];

if($error) {
    header("location: ../profile.php?error=file");
    exit();
}

if($type === "image/jpeg" or $type === "image/png") {

    $table->updatePhoto($name, $auth->id);

    move_uploaded_file($tmp, "photos/$name");

    $auth->photo = $name;

    HTTP::redirect("/profile.php");
} else {
    HTTP::redirect("/profile.php", "error=type");
}