<?php

if (isset($_POST)) {

    // $mysqli = new mysqli('localhost', 'root', '', 'zypern_video_watchers');
    $mysqli = new mysqli('sql419.your-server.de', 'nordzyu_1', 'fCK1fvR4hsb2bCMU', 'nordzyu_db1');
    if ($mysqli->connect_errno) {
        throw new RuntimeException('mysqli connection error: ' . $mysqli->connect_error);
    }
    $name = $_POST["user-name"];
    $email = $_POST["user-email"];
    $phone = $_POST["user-phone"];
    $whatsapp = $_POST["user-whatsapp"];
    $message = $_POST["user-message"];
    $query = "INSERT INTO `additional_info` ( `name`, `email`, `phone`, `whatsapp`, `message`) VALUES ( '$name', '$email', '$phone','$whatsapp', '$message');";

    $result = $mysqli->query($query);
    echo '{"result":"ok"}';
}
