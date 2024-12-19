<?php
//upload.php
include('dbcon.php');
if (isset($_POST["image"])) {
    $data = $_POST["image"];
    $img_array_1 = explode(";", $data);
    $img_array_2 = explode(",", $img_array_1[1]);
    $basedecode = base64_decode($img_array_2[1]);
    $filename = time() . '.jpg';
    file_put_contents("upload/$filename", $basedecode);
    //file_put_contents($filename, $basedecode);
    echo '<img src="' . $filename . '" class="img-thumbnail" />';
    $now = date("Y-m-d H:i:s");
    $sql = "INSERT INTO uploads(file_name, upload_time) VALUES ('$filename','$now')";
    $mysqli->query($sql);
}
