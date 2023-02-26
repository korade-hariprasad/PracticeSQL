<?php

session_start();

if($_SESSION['showPages']==1){
    $uid = $_SESSION['uid'];
    $name = getData($uid)['uname'];
    $pass = getData($uid)['pass'];
    $conn = mysqli_connect('localhost', $name, $pass, $name);
    showHTML($conn);
}

if(isset($_POST['logout'])){
    $_SESSION['showPages']=0;
    session_destroy();
    header('location:index.php');
}

if(isset($_POST['run'])){
    $query = $_POST['query'];
    try{
        mysqli_query($conn, $query, $r = MYSQLI_STORE_RESULT);
        $op = "Success - ".mysqli_affected_rows($conn)." rows affected.";
        showOutput($op, $query);
    }catch(Exception $e){
        $op = "Failed - ".$e->getMessage();
        showOutput($op, $query);
    }
}

function showHTML($conn){
    echo"
        <div style='display:flex; justify-content:space-evenly;'>
        <div>
        <form action='' method='POST'>
            <input type='text' id='query' name='query' placeholder='your query here' style='width: 600px;' required/>
            <input type='submit' name='run' value='RUN'><br>
            <textarea style='height: 400px; width: 600px;' placeholder='output' id='output' readonly></textarea>
        </form>
        </div>";
    showTables($conn);
    echo"<div>
        <form action='' method='post'>
            <input type='submit' name='logout' value='logout' />
        </form>
        </div>
        </div>
    ";
}

function getData($uid){
    $conn = mysqli_connect('localhost', 'root', '', 'practice_sql');
    $q = "SELECT uname, pass FROM login WHERE uid=$uid;";
    $r = mysqli_query($conn, $q);
    $row = mysqli_fetch_array($r);
    mysqli_close($conn);
    return $row;
}

function showOutput($op, $query){
    echo "
        <script>
            document.getElementById('query').value=\"$query\";
            document.getElementById('output').value=\"$op\";
        </script>
    ";
}

function showTables($conn){
    $q = 'SHOW TABLES';
    $r = mysqli_query($conn, $q);
    echo"<div>
    <table><tr><th>Tables</th></tr>";
    while($row = mysqli_fetch_array($r)){
        echo "<tr><td><a href='showTable.php?tb_name=$row[0]'>$row[0]</a></td></tr>";
    }
    echo"</table></div>";
}

?>