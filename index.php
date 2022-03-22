<?php
session_start();
include "config/orion.php";
include "config/funct.php";
?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Digital Annoucenvement Santa Angela</title>

    <link href="contents/css/bootstrap.min.css" rel="stylesheet">
    <link href="contents/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="contents/css/animate.css" rel="stylesheet">
    <link href="contents/css/style.css" rel="stylesheet">
    <link href="contents/css/faa.css" rel="stylesheet">
    <link href="contents/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="favicon.ico">

</head>

<body class="gray-bg"> 
    <div class="row">
    <div class="col-md-4" style="height:100vh;background:#D5F5E3">
           <div class="row">
              <div class="col-md-12" style="margin-top:60px">
                 <center>
                    <img src="contents/img/logo-login.png">
                    <h3 style="margin-top:20px;">Kampus Santa Angela Bandung</h3>
                    <h2 style="margin-top:-5px;" class=>Digital Announcement</h2>
                    <?php echo $errorc ?>
                    <div class="col-md-2"></div>
                    <div class="col-md-8">  
                      <?php
                      //-------- AKSES LOGIN -------//
                      
                      if(isset($_POST['adminpage'])){  
                           // Catch submit variable
                           $zuser = mysqli_real_escape_string($ppdb,$_POST['xuser']);
                           $zpass = mysqli_real_escape_string($ppdb,aPass($_POST['xpass']));  
                           $xx = aPass("[arint0k0]");                           
                           // Cari data user
                           $cUser = mysqli_num_rows(mysqli_query($ppdb,"SELECT usr_login FROM reg_user WHERE usr_login ='$zuser'"));
                           $iUser = mysqli_fetch_array(mysqli_query($ppdb,"SELECT usr_login,usr_pass,usr_stat,usr_tgl,usr_ip FROM reg_user WHERE usr_login ='$zuser'"));

                           // Cek eksitinsi user
                           if($cUser < 1) {
                               echo "
                               <script>
                                    setTimeout(function() {
                                        swal({
                                            html  : true,
                                            title : 'Error Login',
                                            text  : 'User login <strong>$zuser</strong> tidak ditemukan, silakan periksa kembali user login anda!',
                                            type  : 'error',
                                            confirmButtonColor : '#f27474',
                                            confirmButtonText  : 'Ulangi',
                                            showCancelButton   : false, 
                                        }, function() {
                                                window.location = './';
                                        }, 1000);
                                    });                         
                                </script>";
                           } else {
                               if($iUser['usr_pass'] == $zpass){                                   
                                    // Get IP Address
                                    $ipv = $_SERVER['SERVER_NAME'];
                                    $ip  = gethostbyname($_SERVER['SERVER_NAME']);                
                                    // Create Session
                                    $_SESSION['slogin'] = $zuser ;
                                    $_SESSION['sstat']  = true;


                                    //CHECK STATUS USER
                                    $uChk   = mysqli_fetch_array(mysqli_query($ppdb,"SELECT usr_stat FROM reg_user WHERE usr_login='$zuser'"));
                                    if($uChk['usr_stat'] == 0) {                                      
                                    
                                        // Update status login
                                        $xupd = mysqli_query($ppdb,"UPDATE reg_user SET usr_stat=1,usr_ip='$ip',usr_via='$ipv',usr_tgl=CURDATE() WHERE usr_login='$zuser'");
                                                    
                                        echo "
                                        <script>
                                            setTimeout(function() {
                                                swal({
                                                html  : true,
                                                title : 'Login Berhasil',
                                                text  : 'Silakan tunggu sesaat, <strong class=\"text-info faa-flash animated\">halaman sedang dialihkan....</strong>',
                                                type  : 'success',
                                                confirmButtonColor : '#80ba5f',
                                                confirmButtonText  : 'OK',
                                                showCancelButton   : false,  
                                                showConfirmButton   : false,  
                                                showLoaderOnConfirm: true,
                                                timer: 2000  
                                                }, function() {
                                                    window.location = 'contents';
                                                }, 1000);
                                            });                         
                                        </script>";
                                    } else {                                           
                                        echo "
                                        <script>
                                                setTimeout(function() {
                                                    swal({
                                                        html  : true,
                                                        title : 'Error Login',
                                                        text  : 'User login <strong>$zuser</strong> sudah aktif dikomputer lain, silakan periksa kembali user login anda atau hubungi System Administrator!',
                                                        type  : 'error',
                                                        confirmButtonColor : '#f27474',
                                                        confirmButtonText  : 'Ulangi',
                                                        showCancelButton   : false, 
                                                    }, function() {
                                                            window.location = './';
                                                    }, 1000);
                                                });                         
                                            </script>";
                                    }    
                                   
                               } else {
                                   echo "
                                   <script>
                                        setTimeout(function() {
                                            swal({
                                            title : 'Error Password',
                                            text  : 'Password anda masukkan tidak sesuai dengan database, silakan periksa password anda!',
                                            type  : 'error',
                                            confirmButtonColor : '#f27474',
                                            confirmButtonText  : 'Ulangi',
                                            }, function() {
                                                window.location = './';
                                            }, 1000);
                                        });                         
                                    </script>";
                               }
                           }
                      }    
                      ?>

                      <hr> 
                      <form method="post" onsubmit="return submitUserForm();">    
                         <div class="input-group">
                            <span class="input-group-addon bg-primary"><i class="glyphicon glyphicon-user"></i></span>
                            <input type="text" class="form-control" name="xuser" placeholder="Username login" $fdis required>
                          </div>
                          <div class="input-group" style="margin-top:10px">
                            <span class="input-group-addon bg-primary"><i class="glyphicon glyphicon-lock"></i></span>
                            <input type="password" class="form-control" name="xpass" placeholder="Password login" required>
                          </div><br>
                         
                         <div id="g-recaptcha-error" style="padding-bottom:5px;padding-top:10px"></div>
                         <button type="submit" name="adminpage" class="btn btn-primary">Login Admin</button> 
                         <a href="" class="btn btn-default">Reset</a>  
                       </form>     
                    </div>
                    <div class="col-md-2"></div>  
                 </center>
              </div>
           </div> 
           <div class="row">
              <div class="col-md-1"  class="logobot"></div>
              <div class="col-md-10"  class="logobot">
              <center>
                <hr>
                <strong style="color:#1ab394">Bagian Pengembangan Teknologi Informasi</strong><br>
                <span>&copy; 2022</span><span> Kampus Santa Angela Bandung</span>
              <center>  
              </div>
              <div class="col-md-1"  class="logobot"></div>
           </div>
       </div>   
    
       <div class="col-md-8" class="bxside">
          <div class="logobot">
            <div class="row">
              
              <div class="col-md-12">
              <img src="contents/img/login_bg.png" class="img-fluid" style="position:absolute;width:95%;height:auto;margin-top:120px" >
                  <h2  style="margin-top:50px;margin-left:50px;"><span  class="txshad">KAMPUS SANTA ANGELA BANDUNG</h2>  
                  <h3 style="margin-left:50px;"><span  class="txshad">Digital Announcement PPDB Kampus Santa Angela.</span></h3><hr>
              </div>
            </div>
          </div>
       </div>
        
    </div>     
</body>

 <script src="contents/js/plugins/sweetalert/sweetalert.min.js"></script>
</html>
