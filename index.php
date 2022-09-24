<?php
//@ini_set('display_errors', 'Off');
/*
 * Author: Coding Mahib
 * Web: codinmahib.weekbly.com
 * email: codingmahib@outlook.com
*/ 

function ext($filename){
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    return $ext;
}
function fileBA($file){
    return $file;
}
function realName($dir, $dat){
    $real = explode($dir,$dat);
    $r = end($real);
    return $r;
}
$config = array(
    'directory' => '/',
    'smtp' => 'none'
);
session_start();
include 'config.php';

if(isset($_SESSION['login'])){
    $id = 1;
}else{
    $id = 2;
}
// Login Function
if(isset($ftp_connect) && $ftp_connect){
    if($id == 2 && isset($_POST['login'])){
        function valid($data){
            $data = trim($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        $uname = valid($_POST['uname']);
        $pass = valid($_POST['pass']);
        
        $ftp_login = ftp_login($ftp_connect,$uname,$pass);
        
        if(!$ftp_login){
            
            echo ('<div class="alert alert-danger">Cannot connect to FTP with user '.$uname.'</div>');
        }else{
            $_SESSION['un'] = $uname;
            $_SESSION['pass'] = $pass;
            $_SESSION['login'] = $ftp_login;
            $id = 1;
        }
    }
}else{
    ?>
    <?php
}
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="description" content="A filemanager that built in php">
<meta name="keywords" content="ftp, filemanager, php">
<title>FTP FILE MANAGER BY CODING MAHIB 1.1</title>

<link href="css/bootstrap.min.css" rel="stylesheet"/>
<link href="css/font-awesome.min.css" rel="stylesheet"/>
<link rel="stylesheet" href="font-awesome/css/all.min.css">
<style>
body{
    margin-top:20px;
    background:#DCDCDC;
}
.card-box {
    padding: 20px;
    border-radius: 3px;
    margin-bottom: 30px;
    background-color: #fff;
}

.file-man-box {
    padding: 20px;
    border: 1px solid #e3eaef;
    border-radius: 5px;
    position: relative;
    margin-bottom: 20px;
    
}

.file-man-box .file-close {
    color: #f1556c;
    position: absolute;
    line-height: 24px;
    font-size: 24px;
    right: 10px;
    top: 10px;
    visibility: hidden
}

.file-man-box .file-img-box {
    line-height: 120px;
    text-align: center
}

.file-man-box .file-img-box img {
    height: 64px
}

.file-man-box .file-download {
    font-size: 32px;
    color: #98a6ad;
    position: absolute;
    right: 10px
}

.file-man-box .file-download:hover {
    color: #313a46
}

.file-man-box .file-man-title {
    padding-right: 25px
}

.file-man-box:hover {
    -webkit-box-shadow: 0 0 24px 0 rgba(0, 0, 0, .06), 0 1px 0 0 rgba(0, 0, 0, .02);
    box-shadow: 0 0 24px 0 rgba(0, 0, 0, .06), 0 1px 0 0 rgba(0, 0, 0, .02)
}

.file-man-box:hover .file-close {
    visibility: visible
}
.text-overflow {
    text-overflow: ellipsis;
    white-space: nowrap;
    display: block;
    width: 100%;
    overflow: hidden;
}
h5 {
    font-size: 15px;
}
.file{
    color: red;
    height: 28px;
    max-width: 85%;
    width: 80%;
    text-align: left;
    margin-top: 28px;
    font-size: 13px;
}
.file p{
    color: red;
    height: 28px;
    max-width: 85%;
    text-align: left;
    margin-top: 28px;
    font-size: 14px;
}
.copy{
    margin-top: 28px;
}
.file-me1{
    border: 3px solid black;
    background: #fff;
}
.file-me2 thead tr th{
    font-size: 15px;
    margin-left: 15px;
}
.file-me2 tbody tr td{
    font-size: 17px;
    color: black; 
    text-align: left;
    margin-bottom: 2px;
}
</style>
</head>
<body>
    <div class"" style="display: none;"><a href="http://ftpfile.com/index.php"></a></div>
<script src="assets/js/jquery.min.js"></script>
<script type="text/javascript">
function download(filename){
    let anchor = document.createElement('a');
    anchor.href = filename;
    anchor.download = filename;

    anchor.click();
}

</script>
<?php

if($id == 2){
    
?>
<form method="post">
<input type="text" name="uname" placeholder="FTP USERNAME" class="form-control"/><br />
<input type="password" name="pass" placeholder="FTP PASSWORD" class="form-control"/>
<br />
<button type="submit" name="login" class="btn btn-primary">Login</button>
</form>
<?php

}else{
    if(isset($notify)){
        echo $notify;
    }
    $uname = $_SESSION['un'];
    $pass = $_SESSION['pass'];
    ftp_login($ftp_connect,$uname,$pass);
    //ftp_put($ftp_connect,'localfile.txt','local.txt',FTP_ASCII);
    
    if(!dirname("trash/".$uname."/")){
        mkdir('trash/'.$uname);
    }
    ?>
    <div class="container" id="menu">
    <br />
    <center>
    <a href="?request=upload" class="btn btn-warning"><i class="fas fa-file-upload"></i> Upload</a>
    <a href="?request=back" class="btn btn-warning">Go Back Directory</a>
    <a href="?request=newFolder" class="btn btn-warning">New Folder</a>
    <br />
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card-box">
    <div class="row">
    <div class="col-lg-6 col-xl-6">
        <h4 class="header-title m-b-30">My Files</h4>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    <div class="file-me1">
    <table class="file-me2">
    
    <thead>
    <tr>
    <th>File Name</th>
    <th>Size</th>
    <th>Actions</th>
    </tr>
    </thead>
    
    <tbody>
    <?php
    if(isset($_GET['directory'])){
        $dir = $_GET['directory'];
        $f = ftp_nlist($ftp_connect,'/'.$dir.'/');
        echo $config['directory'];
        $d = $config['directory'];
        $new = $dir.'/';
        $_SESSION['dir'] = $new;
        echo $new;
    }else{
        if(isset($_SESSION['dir'])){
            $f = ftp_nlist($ftp_connect,$_SESSION['dir']);
        }else{
            $f = ftp_nlist($ftp_connect,'/');
        }
        echo $_SESSION['dir'];
    }
   
    foreach($f as $key=>$dat){
        // CODE OF FILE
        $ext = ext($dat);
        ?>
        
        
        
        <tr>
        <td>
        <?php
        if($ext == ''){
            if(isset($_SESSION['dir'])){
                $fDir = $_SESSION['dir'];
                $file = realName($fDir,$dat);
                ?>
                <a href="?directory=<?php echo $dat; ?>"><i class="fas fa-folder-open"></i></a>
                <?php
                echo '<a href="?directory='.$dat.'">'.$file.'</a>'; 
            }else{
                ?>
                <a href="?directory=<?php echo $dat; ?>"><i class="fas fa-folder-open"></i></a>
                <?php
                echo '<a href="?directory='.$dat.'">'.$dat.'</a>'; 
            }
            
            
        }else{
            if(isset($_SESSION['dir'])){
                $fDir = $_SESSION['dir'];
                $file = realName($fDir,$dat);
                $img = array('png','jpg','jpeg');
                if($ext == 'pdf'){
                    echo '<i class="fas fa-file-pdf"></i> '.$file;
                }elseif($ext == 'docx'){
                    echo '<i class="fas fa-file-word"></i> '.$file;
                }elseif($ext == 'png'){
                    echo '<i class="fas fa-file-image"></i> '.$file;
                }elseif($ext == 'PNG'){
                    echo '<i class="fas fa-file-image"></i> '.$file;
                }elseif($ext == 'jpg'){
                    echo '<i class="fas fa-file-image"></i> '.$file;
                }elseif($ext == 'xlsx'){
                    echo '<i class="fas fa-file-excel"></i> '.$file;
                }elseif($ext == 'jpeg'){
                    echo '<i class="fas fa-file-image"></i> '.$file;
                }elseif($ext == 'pptx'){
                    echo '<i class="fas fa-file-powerpoint"></i> '.$file;
                }elseif($ext == 'html'){
                    echo '<i class="fas fa-file-code"></i> '.$file;
                }elseif($ext == 'php'){
                    echo '<i class="fas fa-file-code"></i> '.$file;
                }elseif($ext == 'py'){
                    echo '<i class="fas fa-file-code"></i> '.$file;
                }else{
                    echo '<i class="fas fa-file"></i> '.$file;
                }
            }else{
                echo $dat;
            }
            ?>
            <?php
        }
        
        ?>
        </td>
        <td>
            <?php
            /*if(!$ext == ''){
                $size = ftp_size($ftp_connect,$dat);
                echo $size;
                
            }*/
            ?>
        </td>
        <td>
            <?php
            if($ext == ''){
                ?>
                <a href="?request=rename&&folder=" class="btn btn-dark">Rename</a>
                <?php
            }else{
                ?>
                <a href="?request=download&&file=<?php echo $dat; ?>" class="btn btn-success"><i class="fas fa-file-download"></i></a>
                <a href="?request=delete&&file=<?php echo $dat; ?>" class="btn btn-danger">Delete</a>
                <?php
            }
            ?>
        
        </td>
        </tr>
        
        <?php
    }
    ?>
    </tbody>
    </table>
    </div>
    </center>
    </div>
    <?php
}if(isset($_GET['request'])){
    
    $r = $_GET['request'];
    if($r == 'upload'){
        ?>
        <br />
        <center>Upload<hr /></center>
        <br />
        <br />
        <form method="post" enctype="multipart/form-data">
        <input type="file" name="uploadFile" class="form-control"/>
        <br />
        <center><button type="submit" class="btn btn-success" name="upload">Upload</button></center>
        </form>
        <?php
        if(isset($_POST['upload'])){
            $file = $_FILES['uploadFile']['tmp_name'];
            $fileName = $_FILES['uploadFile']['name'];
            move_uploaded_file($file,'file/'.$fileName);
            
            
            if(!isset($_SESSION['dir'])){
                ftp_put($ftp_connect,$fileName,'file/'.$fileName);
                ?>
                <script>alert("Uploaded Successfully !!!");</script>
                <?php
                
            }else{
                ftp_put($ftp_connect,$_SESSION['dir'].$fileName,'file/'.$fileName,FTP_BINARY);
            }
        }
    }if($r == 'download'){
        $fileD = $_GET['file'];
        if(!isset($_SESSION['dir'])){
            ?>
            <input type="hidden" name="fiule" id="file" value="<?php echo 'file/'.$fileD; ?>">
            <?php
        }else{
            $dir = $_SESSION['dir'];
            $fileDown = realName($dir,$fileD);
            ?>
            <input type="hidden" name="fiule" id="file" value="<?php echo 'file/'.$fileDown; ?>">
        
            <?php
        }
        
        if(!isset($_SESSION['dir'])){
            if(ftp_get($ftp_connect,'file/'.$fileD,$fileD,FTP_BINARY)){
                ?>
                <script>
                var file = $('#file');
                download(file.val());
                alert("Downloaded");
                
                </script>
                <?php
                //echo ftp_get($ftp_connect,$fileD,$fileD,FTP_BINARY);
            }else{
                ?>
                <script>alert("CANNOT DOWNLOAD THE REQUESTED FILE !!!");</script>
                <?php
            }
        }else{
            
            if(ftp_get($ftp_connect,'file/'.$fileDown,$fileD)){
                ?>
                <script>
                var file = $('#file');
                download(file.val());
                alert("Downloaded");
                
                </script>
                <?php
                //echo ftp_get($ftp_connect,$fileD,$fileD,FTP_BINARY);
            }else{
                ?>
                <script>alert("CANNOT DOWNLOAD THE REQUESTED FILE !!!");</script>
                <?php
            }
        }
        
        
    }if($r == 'delete'){
        $fileDe = $_GET['file'];
        //ftp_get($ftp_connect,)
        //move_uploaded_file()
        if(!isset($_SESSION['dir'])){
            if(ftp_delete($ftp_connect,$fileDe)){
                ?>
                <script>alert("FILE DELETED SUCCESSFULLY")</script>
                <?php
            }
            
            }else{
                ?>
                <script>alert("FILE NOT DELETED BECAUSE A PROBLEM")</script>
                <?php
            }
        }if(isset($_SESSION['dir']) && $r == 'delete'){
            $deleteDir = $_SESSION['dir'];
            if(ftp_delete($ftp_connect, $fileDe)){
                ?>
                <script>alert("FILE DELETED SUCCESSFULLY")</script>
                <?php
            }else{
                ?>
                <script>alert("FILE NOT DELETED BECAUSE A PROBLEM")</script>
                <?php
            }
        }
    if($r == 'back'){
        $_SESSION['dir'] = '/';
        
    }
    if($r == 'newFolder'){
        echo '<form class="form" method="post">Folder Name:<input type="text" name="folder" class="form-control"><button class="btn btn-success" type="submit">Create</button></form>';
        if($_POST['folder']){
            $folder = $_POST['folder'];
            if(isset($_SESSION['dir'])){
                $dir = $_SESSION['dir'];
                //echo $dir.$folder;
                if(ftp_mkdir($ftp_connect,$dir.$folder)){
                    ?>
                    <script>alert("Folder Successfully Created")</script>
                    <?php
                }else{
                    ?>
                    <script>alert("Cannot create a folder")</script>
                    <?php
                }
            }else{
                if(ftp_mkdir($ftp_connect,'/'.$folder)){
                    ?>
                    <script>alert("Folder Successfully Created")</script>
                    <?php
                }else{
                    ?>
                    <script>alert("Cannot create a folder")</script>
                    <?php
                }
            }
        }
    }
}

if(ftp_close($ftp_connect)){
    echo '';
}else{
    echo '     ';
}

?>
<br />
<br />
<center><small class="copy">&copy;Powered by <a href="https://codingmahib.github.io">Coding Mahib <img src="./img/coding_mahib_32x32.png" alt="coding_mahib"> </a></small></center>

</body>
</html>