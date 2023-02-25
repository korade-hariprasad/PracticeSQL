<?php

$conn = mysqli_connect('localhost', 'root', '', 'practice_sql');

if(isset($_POST['l_submit']))   login($_POST['l_name'], $_POST['l_pass'], $conn);

if(isset($_POST['r_submit']))   register($_POST['r_name'], $_POST['r_pass'], $conn);

showHTML();

function showHTML(){
    echo"
    <h3>Login</h3>
    <form action='' method='post'>
        <input type='text' id='l_name' name='l_name' placeholder='username' required /><br>
        <input type='password' id='l_pass' name='l_pass' placeholder='password' required /><br>
        <input type='submit' name='l_submit' value='login'>
    </form>
    <h3>Register</h3>
    <form action='' method='post'>
        <input type='text' id='r_name' name='r_name' placeholder='username' required /><br>
        <input type='password' id='r_pass' name='r_pass' placeholder='password' required /><br>
        <input type='submit' name='r_submit' value='Register'>
    </form>
    ";
}

function login($name, $pass, $conn){
    if(!checkName($name, $conn)){
        $q = "SELECT pass FROM login WHERE uname='$name';";
        if(mysqli_fetch_array(mysqli_query($conn, $q))['pass']==$pass){
            header('location:home.php');
        }else
            showAlert("Incorrect Password for user $name");
    }else
        showAlert("No user found with username $name");
}

function register($name, $pass, $conn){
    if(checkName($name, $conn)){
        $q = "INSERT INTO login (uname, pass) VALUES ('$name', '$pass');";
        if(mysqli_query($conn, $q)) showAlert("User Created, please login again to continue.");
    }else
        showAlert("Username already exists, please select another username");
}

function showAlert($msg){
    echo "<script>window.alert('$msg');</script>";
}

function checkName($name, $conn){
    $q = "SELECT uname FROM login;";
    $r = mysqli_query($conn, $q);
    $ctr=0;
    $names = array();
    while($row = mysqli_fetch_array($r)){
        $names[$ctr] = $row['uname'];
        $ctr++;
    }
    if(in_array($name, $names)) return false;   else return true;
}

?>