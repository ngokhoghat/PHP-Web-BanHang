<?php
include '../config/funtion.php';
$data =  getdata();
foreach ($data as $key => $value) {
    echo $value.',';
}
?>