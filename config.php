<?php
/*
 * Author: Coding Mahib
 * Web: https://codingmahib.weekbly.com/
 * Email: codingmahib@outlook.com
 */
$ftp_host = '127.0.0.1';
$ftp_port = 21;

$ftp_connect = ftp_connect($ftp_host,$ftp_port);
if(!$ftp_connect){
    echo '<div class="alert alert-danger">Connection Failed</div>';
}else{
    if(isset($_SESSION['login'])){
        ?>
        <nav class="navbar-dark bg-dark lg-dark"><div class="navbar-brand">FTP FILE MANAGER</div><ul><li class="navbar-item active"><a href="logout.php" class="navbar-link active">Log Out</a></li></ul></nav>
        <?php
    }else{
        ?>
        <script>alert("Login First")</script>
        <?php
    }
}

?>