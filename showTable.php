<?php

session_start();

if($_SESSION['showPages']==1){
    $uid = $_SESSION['uid'];
    $name = getData($uid)['uname'];
    $pass = getData($uid)['pass'];
    $tb_name = $_GET['tb_name'];
    $conn = mysqli_connect('localhost', $name, $pass, $name);
    $q = "SELECT * FROM $tb_name";
    $r = mysqli_query($conn, $q);
    showHTML($r);
}

function showHTML($r){
    echo "<table><tr>";

    for($i = 0; $i < mysqli_num_fields($r); $i++) {
        $field_info = mysqli_fetch_field($r);
        echo "<th>{$field_info->name}</th>";
    }

    while($row=mysqli_fetch_row($r)){
        echo "<tr>";
        foreach($row as $data ) {
            echo "<td>$data</td>";
        }
        echo "</tr>";
    }
    echo"</table>";
}

function getData($uid){
    $conn = mysqli_connect('localhost', 'root', '', 'practice_sql');
    $q = "SELECT uname, pass FROM login WHERE uid=$uid;";
    $r = mysqli_query($conn, $q);
    $row = mysqli_fetch_array($r);
    mysqli_close($conn);
    return $row;
}

?>