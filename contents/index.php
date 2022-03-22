<?php
session_start();

require "../config/orion.php";
require "../config/funct.php";
require_once "../config/getid3/getid3.php";


$dUser  = mysqli_fetch_array(mysqli_query($ppdb,"SELECT * FROM reg_user WHERE usr_login='$_SESSION[slogin]'"));
$unit  = $dUser['usr_unit'];
$page    = base64_decode($_REQUEST['page']);
$act     = base64_decode($_REQUEST['act']);

//$unit    = $yusr['usr_unit'];   

// LOAD CONFIG
$lKonfig = mysqli_fetch_array(mysqli_query($ppdb,"SELECT * FROM reg_konfig"));

if (!isset($_SESSION['slogin']) && $_SESSION['sstat'] != true) 
{ header( "Location: ../" );}

if ($_SESSION['slogin'] != $dUser['usr_login']) 
{ header( "Location: ../" );}

function kGrup($bUser){
    if($bUser == 0) {$kuser = "Administrator"; }
    elseif($bUser == 1) { $kuser = "User Unit"; }
    elseif($bUser == 2) { $kuser = "KSP"; }
    elseif($bUser == 3) { $kuser = "Keuangan"; }
    elseif($bUser == 4) { $kuser = "Ketua III"; }
    else { $kuser = "UNDIFINED"; }
    return $kuser;
  }
  
  function unitx($bUnit){
    if($bUnit == 'yay') {$kunit = "Yayasan";}
    elseif($bUnit == 'kb') {$kunit = "KB";}
    elseif($bUnit == 'tk') {$kunit = "TK";}
    elseif($bUnit == 'sd') {$kunit = "SD";}
    elseif($bUnit == 'smp') {$kunit = "SMP";}
    elseif($bUnit == 'sma') {$kunit = "SMA";}
    else {$bUnit = "UNDIFINED";}
    return $kunit;
  }

?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Digital Announcement | Kampus Santa Angela</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/plugins/clockpicker/clockpicker.css" rel="stylesheet">
    <!-- Toastr style -->
    <link href="css/plugins/toastr/toastr.min.css" rel="stylesheet">

    <!-- Gritter -->
    <link href="js/plugins/gritter/jquery.gritter.css" rel="stylesheet">
    <link href="css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <link href="css/plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet">
    <link href="css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
    <link href="css/faa.css" rel="stylesheet">
    <link href="css/plugins/dataTables/datatables.min.css" rel="stylesheet">
    <link  href="js/plugins/file-input/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script src="js/plugins/file-input/js/fileinput.js" type="text/javascript"></script>
    <script src="js/plugins/file-input/js/plugins/piexif.js" type="text/javascript"></script>
    <script src="js/plugins/file-input/js/plugins/sortable.js" type="text/javascript"></script>
    <script src="js/plugins/file-input/js/fileinput.js" type="text/javascript"></script>
    <script src="js/plugins/file-input/js/locales/fr.js" type="text/javascript"></script>
    <script src="js/plugins/file-input/js/locales/es.js" type="text/javascript"></script>
    <script src="js/plugins/file-input/themes/gly/theme.js" type="text/javascript"></script>
    <script src="js/plugins/file-input/themes/fas/theme.js" type="text/javascript"></script>
    <script src="js/plugins/file-input/themes/explorer-fas/theme.js" type="text/javascript"></script>
    

</head>

<body class="md-skin">
    <div id="wrapper">
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav metismenu" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element"> <span>
                            <img alt="image" class="img-circle" src="img/user.png" />
                             </span>
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"><?php echo $dUser['usr_login']; ?></strong>
                             </span> <span class="text-muted text-xs block">Art Director <b class="caret"></b></span> </span> </a>
                            
                        </div>
                        <div class="logo-element">
                            PDB
                        </div>
                    </li>
                    <?php
                       // SIDEMENU
                       include "sidemenu.php";
                    ?>
                   
                </ul>

            </div>
        </nav>
        <!-- DASHBOARD -->
        
        <?php         
                if($act == "") { include "dashboard.php"; } 
                elseif($act == "rock"){
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
                
                switch($page)
                {                           
                    case 'usermanagement':
                        include "dashboard.php";
                       
                        // LOADING USER LOGIN
                        $qUser  = mysqli_query($ppdb,"SELECT * FROM reg_user ORDER BY usr_idx");
                        if($act=="listuser"){
                            echo "
                                <!-- MODAL BOX UNTUK KONFIGURASI PPDB -->
                                <!-- MODAL BOX  -->
                                <div class='modal inmodal' id='config' tabindex='-1' role='dialog' aria-hidden='true' data-keyboard='false' data-backdrop='static'>
                                    <div class='modal-dialog modal-lg'>
                                        <div class='modal-content animated fadeIn'>
                                            <div class='modal-header'>                                    
                                                <h4 class='modal-title'>Pengelolaan User Login</h4>
                                            </div>
                                            
                                            <div class='modal-body' style='margin-top:-30px'>'
                                                
                                            <div class='row'>
                                            <div class='col-lg-12'>
                                                <div class='table-responsive'>
                                                    <table class='table table-striped table-bordered table-hover dataUser' >
                                                    <thead>
                                                    <tr>
                                                        <th width='5%'>No</th>
                                                        <th>Nama Pemilik</th>
                                                        <th>Akun Login</th>
                                                        <th>Grup User</th>
                                                        <th>Unit</th>
                                                        <th>IP Login</th>
                                                        <th></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>";
                                                    
                                                    $uno=0;
                                                    while($rUser = mysqli_fetch_array($qUser)) {
                                                        $uno++;
                                                        //Cek Status login
                                                        if($rUser['usr_stat'] == 0) { 
                                                            $btnx="btn-default"; $val=1; $slab ="lock";;
                                                        } else {
                                                            $btnx = "btn-warning";$val=0;$slab ="unlock";
                                                        }
                                                        echo"
                                                            <tr>
                                                                <td>$uno</td>
                                                                <td>$rUser[usr_name]</td>
                                                                <td>$rUser[usr_login]</td>
                                                                <td>".kGrup($rUser['usr_grp'])."</td>
                                                                <td>".unitx($rUser['usr_unit'])."</td>
                                                                <td>$rUser[usr_ip]</td>
                                                                <td>
                                                                    <a href='?page=".base64_encode('usermanagement')."&act=".base64_encode("edituser")."&tipe=".base64_encode("useredit")."&uid=".base64_encode($rUser['usr_login'])."' class='btn btn-xs btn-default'><i class='fa fa-pencil'></i></a>
                                                                    <a href='?page=".base64_encode('usermanagement')."&act=".base64_encode("deleteuser")."&unid=".base64_encode($rUser['usr_login'])."' class='btn btn-xs btn-default'><i class='fa fa-times'></i></a>
                                                                    <a href='?page=".base64_encode('usermanagement')."&act=".base64_encode("gantipass")."&uid=".base64_encode($rUser['usr_login'])."' class='btn btn-xs btn-default'><i class='fa fa-key'></i></a>                                  
                                                                    <a href='?page=".base64_encode("usermanagement")."&act=".base64_encode("statlock")."&val=".base64_encode($val)."&ltype=".base64_encode($slab)."&unid=".base64_encode($rUser['usr_login'])."' class='btn btn-xs $btnx'><i class='fa fa-$slab'></i></a>
                                                                </td>
                                                                
                                                            </tr>";
                                                    }        
                                                    echo"
                                                    </tbody>
                                                    <tfoot>
                                                    
                                                    </tfoot>
                                                    </table>
                                                        </div>
                                
                                                    </div>
                                                </div>
                                            </div>
                                            <div class='modal-footer'>
                                                <a href='./' class='btn btn-white'>Tutup</a>       
                                                <a href='?page=dXNlcm1hbmFnZW1lbnQ=&act=bGlzdHVzZXI=' class='btn btn-default'>Refresh</a>                                      
                                                <a href='?page=".base64_encode('usermanagement')."&act=".base64_encode('edituser')."&tipe=".base64_encode("tambah")."' class='btn btn-info'>Tambah User</a>                                      
                                                </div>
                                        </div>
                                    </div>
                                </div>"; 
                        }
                        if($act=="edituser"){
                            $type = base64_decode($_REQUEST['tipe']);
                            $uid  = base64_decode($_REQUEST['uid']);

                            // LAOD USER DATA
                            $uData = mysqli_fetch_array(mysqli_query($ppdb,"SELECT * FROM reg_user WHERE usr_login='$uid'"));

                            if($type == "useredit"){
                                $label = "Edit"; $disb = "disabled='disabled'";      
                                $uExec = "?page=".base64_encode("execusermanagement")."&act=".base64_encode("execedit");                         
                            } elseif($type == "tambah") {
                                $label = "Tambah"; $disb = ""; 
                                $uExec = "?page=".base64_encode("execusermanagement")."&act=".base64_encode("execadd");
                                $uAdd  = "
                                <div class='col-sm-12' style='margin-top:-10px;' id='pwd-container3'>
                                    <div class='form-group'>
                                        <label class='col-sm-3 control-label' style='margin-top:10px;'>Password</label>
                                        <div class='col-sm-9'>
                                            <input type='password' name='pass1' class='form-control example3' minlength='6' required>
                                            <div class='pwstrength_viewport_progress2'></div>                    
                                        </div>
                                    </div>
                                </div>
                                <div class='col-sm-12' style='margin-top:-17px;margin-bottom:15px;'>
                                    <div class='form-group'>
                                        <label class='col-sm-3 control-label'>Konfirmasi</label>
                                        <div class='col-sm-9' style='margin-top:2px;'>
                                            <input type='password' name='pass2' class='form-control' minlength='6' required>                    
                                        </div>
                                    </div>
                                </div>"; 

                            } else {
                                $disb = "disabled='disabled'"; 
                                
                            }
                            
                            echo "
                            
                            <!-- MODAL BOX  -->
                            <div class='modal inmodal' id='config' tabindex='-1' role='dialog' aria-hidden='true' data-keyboard='false' data-backdrop='static'>
                                <div class='modal-dialog modal-lg'>
                                    <div class='modal-content animated fadeIn'>
                                        <div class='modal-header'>                                    
                                            <h4 class='modal-title'>$label Akun Login Sistem PPDB</h4>    
                                        </div>
                                        <div class='modal-body'>
                                            <form role='form' class='form-validation' method='post' action='$uExec' oninput='pass2.setCustomValidity(pass2.value != pass1.value ? \"Password tidak sama, periksa kembali password anda!.\" : \"\")'>  
                                            <div class='row'> ";
                                               echo"
                                                <div class='col-sm-12' style='margin-bottom:5px;'>
                                                    <div class='form-group'>
                                                        <label class='col-sm-3 control-label' style='margin-top:10px;'>Akun Login</label>
                                                        <div class='col-sm-9'>
                                                            <input type='text' name='userlogin' class='form-control' value='$uData[usr_login]' $disb required>
                                                            <input type='hidden' name='userlogin' value='$uData[usr_login]'>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class='col-sm-12' style='margin-bottom:5px;'>
                                                    <div class='form-group'>
                                                        <label class='col-sm-3 control-label' style='margin-top:10px;'>Nama Pemilik</label>
                                                        <div class='col-sm-9'>
                                                            <input type='text' name='username' class='form-control' value='$uData[usr_name]' required>                    
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class='col-sm-12'>
                                                    <div class='form-group'>
                                                    <label class='col-sm-3 control-label' style='margin-top:5px;'>Grup User</label>
                                                    <div class='col-sm-9'>
                                                    <select class='form-control m-b' name='usergrup' required>";                                                      
                                                            echo "<option value='0'"; if( $uData['usr_grp'] ==  0 ) { echo "selected='selected'"; }  echo ">Administrator</option>";        
                                                            echo "<option value='1'"; if( $uData['usr_grp'] ==  1 ) { echo "selected='selected'"; }  echo ">User Unit</option>";        
                                                            echo "<option value='2'"; if( $uData['usr_grp'] ==  2 ) { echo "selected='selected'"; }  echo ">KSP</option>";        
                                                            echo "<option value='3'"; if( $uData['usr_grp'] ==  3 ) { echo "selected='selected'"; }  echo ">Keuangan</option>";        
                                                            echo "<option value='4'"; if( $uData['usr_grp'] ==  4 ) { echo "selected='selected'"; }  echo ">Ketua III</option>";        
                                                        echo"</select>
                                                    </div>
                                                    </div>
                                                </div>

                                                <div class='col-sm-12'  style='margin-top:-10px;'>
                                                    <div class='form-group'>
                                                    <label class='col-sm-3 control-label'>Satuan Pendidikan</label>
                                                    <div class='col-sm-9'>
                                                    <select class='form-control m-b' name='userunit' required>";                                                      
                                                            echo "<option value='kb'"; if( $uData['usr_unit'] == 'kb') { echo "selected='selected'"; }  echo ">KB Santa Angela</option>";        
                                                            echo "<option value='tk'"; if( $uData['usr_unit'] == 'tk') { echo "selected='selected'"; }  echo ">TK Santa Angela</option>";        
                                                            echo "<option value='sd'"; if( $uData['usr_unit'] == 'sd') { echo "selected='selected'"; }  echo ">SD Santa Angela</option>";        
                                                            echo "<option value='smp'"; if( $uData['usr_unit'] == 'smp') { echo "selected='selected'"; }  echo ">SMP Santa Angela</option>";        
                                                            echo "<option value='sma'"; if( $uData['usr_unit'] == 'sma') { echo "selected='selected'"; }  echo ">SMA Santa Angela</option>";        
                                                            echo "<option value='yay'"; if( $uData['usr_unit'] == 'yay') { echo "selected='selected'"; }  echo ">Yayasan</option>";   
                                                        echo"</select>
                                                    </div>
                                                    </div>
                                                </div> 
                                                $uAdd
                                                </div>

                                                <div class='modal-footer'>
                                                   <a href='./' class='btn btn-white'>Tutup</a>
                                                   <a href='?page=".base64_encode('usermanagement')."&act=".base64_encode('listuser')."' class='btn btn-white'>Kembali</a>
                                                   <button type='submit' name='saveconf' class='btn btn-info'>Simpan</button>
                                                </div>    
                                                
                                            </form>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>";
                        } elseif($act=="gantipass") {
                            $uid = base64_decode(mysqli_real_escape_string($ppdb,$_REQUEST['uid']));
                            //$uid = base64_decode($_REQUEST['uid']);
                            //LOAD DATA
                            $pReset = mysqli_fetch_array(mysqli_query($ppdb,"SELECT * FROM reg_user WHERE usr_login = '$uid'"));
                            echo"
                            <!-- MODAL BOX  -->
                            <div class='modal inmodal' id='config' tabindex='-1' role='dialog' aria-hidden='true' data-keyboard='false' data-backdrop='static'>
                                <div class='modal-dialog modal-lg'>
                                    <div class='modal-content animated fadeIn'>
                                        <div class='modal-header'>                                    
                                            <h4 class='modal-title'>Ganti Password Akun Login Sistem PPDB</h4>    
                                        </div>
                                        <div class='modal-body'>
                                            <form role='form' class='form-validation' method='post' action='?page=".base64_encode("execusermanagement")."&act=".base64_encode("gantipass")."' oninput='pass2.setCustomValidity(pass2.value != pass1.value ? \"Password tidak sama, periksa kembali password anda!.\" : \"\")'>  
                                            <div class='row'> ";
                                               echo"
                                                <div class='col-sm-12' style='margin-bottom:5px;'>
                                                    <div class='form-group'>
                                                        <label class='col-sm-3 control-label' style='margin-top:10px;'>Akun Login</label>
                                                        <div class='col-sm-9'>
                                                            <input type='text' class='form-control' value='$pReset[usr_login]' disabled>
                                                            <input type='hidden' name='userlogin'  value='$pReset[usr_login]'>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class='col-sm-12' style='margin-bottom:5px;'>
                                                    <div class='form-group'>
                                                        <label class='col-sm-3 control-label' style='margin-top:10px;'>Nama Pemilik</label>
                                                        <div class='col-sm-9'>
                                                            <input type='text' class='form-control' value='$pReset[usr_name]' disabled>                    
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class='col-sm-12' style='margin-bottom:5px;'>
                                                    <div class='form-group'>
                                                        <label class='col-sm-3 control-label' style='margin-top:10px;'>User Grup</label>
                                                        <div class='col-sm-9'>
                                                            <input type='text' class='form-control' value='".kGrup($pReset['usr_grp'])."' disabled>                    
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class='col-sm-12' style='margin-bottom:5px;'>
                                                    <div class='form-group'>
                                                        <label class='col-sm-3 control-label' style='margin-top:10px;'>Unit</label>
                                                        <div class='col-sm-9'>
                                                            <input type='text' class='form-control' value='".unitx($pReset['usr_unit'])." Santa Angela' disabled>                    
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class='col-sm-12' style='margin-top:0px;' id='pwd-container3'>
                                                <div class='form-group'>
                                                    <label class='col-sm-3 control-label' style='margin-top:10px;'>Password</label>
                                                    <div class='col-sm-9'>
                                                        <input type='password' name='pass1' class='form-control example3' minlength='6' required>
                                                        <div class='pwstrength_viewport_progress2'></div>                    
                                                    </div>
                                                </div>
                                                </div>
                                                <div class='col-sm-12' style='margin-top:-17px;margin-bottom:15px;'>
                                                    <div class='form-group'>
                                                        <label class='col-sm-3 control-label'>Konfirmasi</label>
                                                        <div class='col-sm-9' style='margin-top:2px;'>
                                                            <input type='password' name='pass2' class='form-control' minlength='6' required>                    
                                                        </div>
                                                    </div>
                                                </div>
                                                </div>

                                                <div class='modal-footer'>
                                                   <a href='./' class='btn btn-white'>Tutup</a>
                                                   <a href='?page=".base64_encode('usermanagement')."&act=".base64_encode('listuser')."' class='btn btn-white'>Kembali</a>
                                                   <button type='submit' name='saveconf' class='btn btn-info'>Simpan</button>
                                                </div>    
                                                
                                            </form>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>";                            
                        }  elseif($act=="statlock")   {
                            $lType = base64_decode(mysqli_real_escape_string($ppdb,$_REQUEST['ltype']));
                            $lID   = base64_decode(mysqli_real_escape_string($ppdb,$_REQUEST['unid']));
                            
                            if($lType == "unlock") {
                                echo "
                                <script>
                                    setTimeout(function() {
                                        swal({
                                            html  : true,
                                            title : 'Unlock User',
                                            text  : 'Apakah anda yakin mengubah status UNLOCK user login <strong>$lID</strong>?',
                                            type  : 'warning',
                                            confirmButtonColor : '#f8bb86',
                                            confirmButtonText  : 'Unlock sekarang!',
                                            showCancelButton   : true
                                        }, function() {
                                                window.location = '?page=".base64_encode("execusermanagement")."&act=".base64_encode("slock")."&lgid=".base64_encode($lID)."&xval=".base64_encode(0)."';
                                            
                                        }, 1000);
                                    });                         
                                </script>";  
                                } elseif($lType == "lock") {
                                    echo "
                                    <script>
                                        setTimeout(function() {
                                            swal({
                                                html  : true,
                                                title : 'Lock User',
                                                text  : 'Apakah anda yakin mengubah status LOCK user login <strong>$lID</strong>?',
                                                type  : 'warning',
                                                confirmButtonColor : '#f8bb86',
                                                confirmButtonText  : 'Lock sekarang!',
                                                showCancelButton   : true
                                            }, function() {
                                                 window.location = '?page=".base64_encode("execusermanagement")."&act=".base64_encode("slock")."&lgid=".base64_encode($lID)."&xval=".base64_encode(1)."';
                                                
                                            }, 1000);
                                        });                         
                                    </script>";  
                                }    
                        } elseif($act=="deleteuser") {
                            $lID   = base64_decode(mysqli_real_escape_string($ppdb,$_REQUEST['unid']));
                            if($lID != "geosystem" && $lID != "geostigmata"){
                                echo "
                                <script>
                                    setTimeout(function() {
                                        swal({
                                            html  : true,
                                            title : 'Hapus User',
                                            text  : 'Apakah anda yakin akan menghapus user <strong>$lID</strong>?',
                                            type  : 'warning',Konfigurasi Sistem PPDB
                                            confirmButtonColor : '#f8bb86',
                                            confirmButtonText  : 'Hapus sekarang!',
                                            showCancelButton   : true
                                        }, function() {
                                            window.location = '?page=".base64_encode("execusermanagement")."&act=".base64_encode("hapususer")."&lgid=".base64_encode($lID)."';
                                            
                                        }, 1000);
                                    });                         
                                </script>"; 
                            } else {
                                echo "
                                <script>
                                    setTimeout(function() {
                                        swal({
                                        html  : true,
                                        title : 'Error Hapus User',
                                        text  : 'User login <strong>GEOSYSTEM</strong> tidak dapat dihapus, silakan periksa user login yang akan dihapus!',
                                        type  : 'error',
                                        confirmButtonColor : '#f27474',
                                        confirmButtonText  : 'Kembali',
                                        }, function() {
                                            window.location = '?page=".base64_encode('usermanagement')."&act=".base64_encode('listuser')."';
                                        }, 1000);
                                    });                         
                                </script>";    
                            }
                        }                
                    break;   
                    case 'execusermanagement':
                        include "dashboard.php";
                       
                        if($act == "execedit") {
                            $ladd = "EDIT";
                            $eUser      = mysqli_real_escape_string($ppdb,$_POST['userlogin']);
                            $eName      = mysqli_real_escape_string($ppdb,$_POST['username']);
                            $eGrup      = mysqli_real_escape_string($ppdb,$_POST['usergrup']);
                            $eUnit      = mysqli_real_escape_string($ppdb,$_POST['userunit']);
                            //EXEC EDIT
                            $exEditUser = mysqli_query($ppdb,"UPDATE reg_user SET usr_name='$eName',usr_grp='$eGrup',usr_unit='$eUnit' WHERE usr_login='$eUser' ");
                            echo "
                            <script>
                                setTimeout(function() {
                                    swal({
                                        html  : true,
                                        title : 'Edit User Berhasil',
                                        text  : 'Pembaharuan data akun login berhasil disimpan dalam database!',
                                        type  : 'success',
                                        confirmButtonColor : '#1ab394',
                                        confirmButtonText  : 'Tutup',
                                        showCancelButton   : false
                                    }, function() {
                                            window.location = './';
                                    }, 1000);
                                });                         
                            </script>";   
                         } 
                         elseif($act=="execadd") {  
                            $ladd = "TAMBAH";

                            $yLogin = mysqli_real_escape_string($ppdb,$_POST['userlogin']);
                            $yNama  = mysqli_real_escape_string($ppdb,$_POST['username']);
                            $yGrup  = mysqli_real_escape_string($ppdb,$_POST['usergrup']);
                            $yUnit  = mysqli_real_escape_string($ppdb,$_POST['userunit']);
                            $yPass  = aPass(mysqli_real_escape_string($ppdb,$_POST['pass2']));

                            // INSERT INTO TABLE USER
                            $uInsert  = "INSERT INTO reg_user (usr_login,usr_pass,usr_name,usr_grp,usr_unit,usr_stat)
                                        VALUES('$yLogin','$yPass','$yNama','$yGrup','$yUnit',0)";
                            $uInsExec = mysqli_query($ppdb,$uInsert);
                            
                            echo "
                            <script>
                                setTimeout(function() {
                                    swal({
                                        html  : true,
                                        title : 'Tambah User Berhasil',
                                        text  : 'Pembaharuan data akun login berhasil disimpan dalam database!',
                                        type  : 'success',
                                        confirmButtonColor : '#1ab394',
                                        confirmButtonText  : 'Tutup',
                                        showCancelButton   : false
                                    }, function() {
                                            window.location = './';
                                    }, 1000);
                                });                         
                            </script>";   
                                
                         } elseif($act=="gantipass") {  
                            $reUser = mysqli_real_escape_string($ppdb,$_POST['userlogin']);
                            $rePass = aPass(mysqli_real_escape_string($ppdb,$_POST['pass2']));
                            //EXEC UPDATE PASSWORD
                            $exPassword = mysqli_query($ppdb,"UPDATE reg_user SET usr_pass='$rePass' WHERE usr_login='$reUser'");
                            
                            echo "
                            <script>
                                setTimeout(function() {
                                    swal({
                                        html  : true,
                                        title : 'Ganti Password Berhasil',
                                        text  : 'Pembaharuan password akun login <strong class=\'text-info\'>$reUser</strong> berhasil disimpan dalam database!',
                                        type  : 'success',
                                        confirmButtonColor : '#1ab394',
                                        confirmButtonText  : 'Tutup',
                                        showCancelButton   : false
                                    }, function() {
                                            window.location = './';
                                    }, 1000);
                                });                         
                            </script>";   
                         } elseif($act=="slock") {
                            $lGid = base64_decode(mysqli_real_escape_string($ppdb,$_REQUEST['lgid'])); 
                            $lVal = base64_decode(mysqli_real_escape_string($ppdb,$_REQUEST['xval'])); 
                            if($lVal == 1){ $dStat = "Lock"; $xVal=1; } 
                            else { $dStat = "Unlock"; $xVal=0;}
                            $updStat = mysqli_query($ppdb,"UPDATE reg_user SET usr_stat='$xVal' WHERE usr_login='$lGid'");

                            echo "
                            <script>
                                setTimeout(function() {
                                    swal({
                                        html  : true,
                                        title : 'Status $dStat Berhasil',
                                        text  : 'Status user login <strong class=\'text-info\'>$lGid</strong> berhasil diubah menjadi ".strtoupper($dStat).".',
                                        type  : 'success',
                                        confirmButtonColor : '#1ab394',
                                        confirmButtonText  : 'Tutup',
                                        showCancelButton   : false
                                    }, function() {
                                            window.location = '?page=".base64_encode('usermanagement')."&act=".base64_encode("listuser")."';
                                    }, 1000);
                                });                         
                            </script>";   
                        } elseif($act=="hapususer") {
                            $delGid = base64_decode(mysqli_real_escape_string($ppdb,$_REQUEST['lgid']));  
                            $delExec = mysqli_query($ppdb,"DELETE FROM reg_user WHERE usr_login='$delGid'");
                            echo "
                            <script>
                                setTimeout(function() {
                                    swal({
                                        html  : true,
                                        title : 'Hapus User Berhasil',
                                        text  : 'User login <strong class=\'text-info\'>$delGid</strong> berhasil dihapus dari database.',
                                        type  : 'success',
                                        confirmButtonColor : '#1ab394',
                                        confirmButtonText  : 'Tutup',
                                        showCancelButton   : false
                                    }, function() {
                                            window.location = '?page=".base64_encode('usermanagement')."&act=".base64_encode("listuser")."';
                                    }, 1000);
                                });                         
                            </script>";   
                         }
                    break;
                    case 'logoutpage' :
                        include "dashboard.php";

                        if($act=="logoutconfirm"){
                           echo "
                            <script>
                                setTimeout(function() {
                                    swal({
                                        html  : true,
                                        title : 'Logout Admin',
                                        text  : 'Apakah anda yakin akan keluar dari halaman administrasi?',
                                        type  : 'warning',
                                        confirmButtonColor : '#f8bb86',
                                        confirmButtonText  : 'Logout sekarang!',
                                        showCancelButton   : true
                                    }, function() {
                                            window.location = '?page=".base64_encode("logoutpage")."&act=".base64_encode("logoutexec")."&lgid=".base64_encode($dUser['usr_login'])."';
                                           
                                    }, 1000);
                                });                         
                            </script>";   
                        } elseif($act=="logoutexec"){
                            $lgtID = base64_decode($_REQUEST['lgid']);
                            // RELEASE STATUS LOGIN --> IDLE
                            $lgtUpd = mysqli_query($ppdb,"UPDATE reg_user SET usr_stat=0 WHERE usr_login='$lgtID'");
                            echo "
                            <script>
                                setTimeout(function() {
                                    swal({
                                    html  : true,
                                    title : 'Logout Berhasil',
                                    text  : 'Silakan tunggu sesaat, <strong class=\"text-info faa-flash animated\">halaman sedang dialihkan....</strong>',
                                    type  : 'success',
                                    confirmButtonColor : '#80ba5f',
                                    confirmButtonText  : 'OK',
                                    showCancelButton   : false,  
                                    showConfirmButton   : false,  
                                    showLoaderOnConfirm: true,
                                    timer: 2000  
                                    }, function() {
                                        window.location = '../';
                                    }, 1000);
                                });                         
                            </script>";
                        }
                    break;    
                    case 'passworduser':
                        include "dashboard.php";
                        
                        if($act=="formpassword") {
                            echo"
                            <!-- MODAL BOX  -->
                            <div class='modal inmodal' id='config' tabindex='-1' role='dialog' aria-hidden='true' data-keyboard='false' data-backdrop='static'>
                                <div class='modal-dialog modal-lg'>
                                    <div class='modal-content animated fadeIn'>
                                        <div class='modal-header'>                                    
                                            <h4 class='modal-title'>Ganti Password Akun Login Sistem PPDB</h4>    
                                        </div>
                                        <div class='modal-body'>
                                            <form role='form' class='form-validation' method='post' action='?page=".base64_encode("passworduser")."&act=".base64_encode("execgantipass")."' oninput='pass2.setCustomValidity(pass2.value != pass1.value ? \"Password tidak sama, periksa kembali password anda!.\" : \"\")'>  
                                            <div class='row'> ";
                                               echo"
                                                <div class='col-sm-12' style='margin-bottom:5px;'>
                                                    <div class='form-group'>
                                                        <label class='col-sm-3 control-label' style='margin-top:10px;'>Akun Login</label>
                                                        <div class='col-sm-9'>
                                                            <input type='text' class='form-control' value='$dUser[usr_login]' disabled>
                                                            <input type='hidden' name='userlogin'  value='$dUser[usr_login]'>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class='col-sm-12' style='margin-bottom:5px;'>
                                                    <div class='form-group'>
                                                        <label class='col-sm-3 control-label' style='margin-top:10px;'>Nama Pemilik</label>
                                                        <div class='col-sm-9'>
                                                            <input type='text' class='form-control' value='$dUser[usr_name]' disabled>                    
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class='col-sm-12' style='margin-bottom:5px;'>
                                                    <div class='form-group'>
                                                        <label class='col-sm-3 control-label' style='margin-top:10px;'>User Grup</label>
                                                        <div class='col-sm-9'>
                                                            <input type='text' class='form-control' value='".kGrup($dUser['usr_grp'])."' disabled>                    
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class='col-sm-12' style='margin-bottom:5px;'>
                                                    <div class='form-group'>
                                                        <label class='col-sm-3 control-label' style='margin-top:10px;'>Unit</label>
                                                        <div class='col-sm-9'>
                                                            <input type='text' class='form-control' value='".unitx($dUser['usr_unit'])." Santa Angela' disabled>                    
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class='col-sm-12' style='margin-bottom:5px;'>
                                                    <div class='form-group'>
                                                        <label class='col-sm-3 control-label'style='margin-top:7px;'>Password Lama</label>
                                                        <div class='col-sm-9' >
                                                            <input type='password' name='pass0' class='form-control' required>                    
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class='col-sm-12' style='margin-top:0px;' id='pwd-container3'>
                                                <div class='form-group'>
                                                    <label class='col-sm-3 control-label' style='margin-top:10px;'>Password</label>
                                                    <div class='col-sm-9'>
                                                        <input type='password' name='pass1' class='form-control example3' minlength='6' required>
                                                        <div class='pwstrength_viewport_progress2'></div>                    
                                                    </div>
                                                </div>
                                                </div>
                                                <div class='col-sm-12' style='margin-top:-17px;margin-bottom:15px;'>
                                                    <div class='form-group'>
                                                        <label class='col-sm-3 control-label'>Konfirmasi</label>
                                                        <div class='col-sm-9' style='margin-top:2px;'>
                                                            <input type='password' name='pass2' class='form-control' minlength='6' required>                    
                                                        </div>
                                                    </div>
                                                </div>
                                                </div>

                                                <div class='modal-footer'>
                                                   <a href='./' class='btn btn-white'>Tutup</a>                                                   
                                                   <button type='submit' name='savepass' class='btn btn-info'>Simpan</button>
                                                </div>    
                                                
                                            </form>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>";    
                        } elseif($act=="execgantipass") { 
                            $rstuser      = mysqli_real_escape_string($ppdb,$_POST['userlogin']);
                            $rstpassold   = aPass(mysqli_real_escape_string($ppdb,$_POST['pass0']));
                            $rstpass      = aPass(mysqli_real_escape_string($ppdb,$_POST['pass2']));
                            
                            if($dUser['usr_pass'] == $rstpassold) {                            
                                // SAVE UPDATE PASS
                                if($rstpass != $dUser['usr_pass']){
                                    $pswe = mysqli_query($ppdb,"UPDATE reg_user SET usr_pass='$rstpass' WHERE usr_login='$rstuser'");
                                    echo "
                                    <script>
                                        setTimeout(function() {
                                            swal({
                                                html  : true,
                                                title : 'Update Berhasil',
                                                text  : 'Ganti password user login <strong class=\'text-info\'>$rstuser</strong> berhasil disimpan dalam database.',
                                                type  : 'success',
                                                confirmButtonColor : '#1ab394',
                                                confirmButtonText  : 'Tutup',
                                                showCancelButton   : false
                                            }, function() {
                                                    window.location = './';
                                            }, 1000);
                                        });                         
                                    </script>";   
                                    
                                } else {
                                    echo "
                                    <script>
                                        setTimeout(function() {
                                            swal({
                                            title : 'Error Password',
                                            text  : 'Password baru tidak diperkenankan sama dengan password lama. Silakan gunakan dengan passsword yang lain!',
                                            type  : 'error',
                                            confirmButtonColor : '#f27474',
                                            confirmButtonText  : 'Ulangi',
                                            }, function() {
                                                window.location = '?page=".base64_encode('passworduser')."&act=".base64_encode('formpassword')."';
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
                                            text  : 'Password lama anda tidak sesuai dengan database, silakan periksa password lama anda!',
                                            type  : 'error',
                                            confirmButtonColor : '#f27474',
                                            confirmButtonText  : 'Ulangi',
                                            }, function() {
                                                window.location = '?page=".base64_encode('passworduser')."&act=".base64_encode('formpassword')."';
                                            }, 1000);
                                        });                         
                                    </script>";
                                }    
                        }

                    break; 
                    case "uploadvideo" :
                        include "dashboard.php";
                        if($act == "formuploadvideo"){
                            echo"
                            <!-- MODAL BOX  -->
                            <div class='modal inmodal' id='config' tabindex='-1' role='dialog' aria-hidden='true' data-keyboard='false' data-backdrop='static'>
                                <div class='modal-dialog modal-lg'>
                                    <div class='modal-content animated fadeIn'>
                                        <div class='modal-header'>                                    
                                            <h4 class='modal-title'>Upload Video Kegiatan</h4>    
                                        </div>
                                        <div class='modal-body'>
                                            <form role='form' class='form-validation' enctype='multipart/form-data' method='post' action='?page=".base64_encode("uploadvideo")."&act=".base64_encode("simpanvideo")."' '>  
                                            <div class='row'> ";
                                            if($dUser['usr_unit'] == 'yay') {
                                                echo"                                               
                                                <div class='col-sm-12' style='margin-bottom:5px;'>
                                                    <div class='form-group'>
                                                        <label class='col-sm-3 control-label' style='margin-top:10px;'>Video Unit</label>
                                                        <div class='col-sm-9'>
                                                            <select  class='form-control' name='unit' required>
                                                                <option value=''>- Pilih Unit -</option>
                                                                <option value='TK'>KB-TK</option>
                                                                <option value='SD'>SD</option>
                                                                <option value='SMP'>SMP</option>
                                                                <option value='SMA'>SMA</option>
                                                            </select>    
                                                        </div>
                                                    </div>
                                                </div>"; 
                                                } else {
                                                    echo"                                               
                                                    <div class='col-sm-12' style='margin-bottom:5px;'>
                                                        <div class='form-group'>
                                                            <label class='col-sm-3 control-label' style='margin-top:10px;'>Video Unit</label>
                                                            <div class='col-sm-9'>
                                                                <input type='text' class='form-control'value='".strtoupper($dUser['usr_unit'])."' disabled>
                                                                <input type='hidden'name='unit' value='".strtoupper($dUser['usr_unit'])."'>
                                                            </div>
                                                        </div>
                                                    </div>";
                                                }
                                                
                                                echo"
                                                <div class='col-sm-12' style='margin-bottom:5px;margin-top:20px'>
                                                    
                                                    <div class='file-loading' style='height:60px'> 
                                                        <input id='upload' name='fVideo' type='file' class='file'  
                                                        data-show-upload='false' data-show-caption='true' data-msg-placeholder='file bukti bayar...' data-allowed-file-extensions='[\"mp4\"]'>
                                                    
                                                    </div>
                                                </div>

                                                <script>
                                                $('#upload').fileinput({
                                                    theme: 'gly',
                                                    allowedFileExtensions: ['mp4'],
                                                    previewTemplates: {
                                                        video: '<video class=\"kv-preview-data file-preview-video\" controls=\"\" style=\"width:100%;height:100%;\"><source src=\"{data}\" type=\"{type}\"></video>'
                                                    },
                                                    overwriteInitial: true,
                                                    maxFileSize: 5000000, 
                                                    showRemove: true,
                                                    showUpload: false,
                                                    showZoom: false,
                                                    showDrag: true,
                                                    maxFilesNum: 1,
                                                    video: {width:'150px', height: 'auto'},
                                                    showUploadedThumbs: false,
                                                    dropZoneTitle : 'Drag file video di kotak ini ...',
                                                    allowedFileTypes: ['video'],
                                                    slugCallback: function (filename) {
                                                        return filename.replace('(', '_').replace(']', '_');
                                                    }
                                                });
                                                </script>

                                        
                                                </div>
                                                </div>

                                                <div class='modal-footer'>
                                                <a href='./' class='btn btn-white'>Tutup</a>                                                   
                                                <button type='submit' name='savepass' class='btn btn-info'>Simpan</button>
                                                </div>    
                                                
                                            </form>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>";  
                        } elseif($act == 'simpanvideo'){
                            // Uoload poto galeri
                            $unit       = mysqli_real_escape_string($ppdb, $_POST['unit']);                            
                            $video      = $_FILES['fVideo']['name'];
                            $vid        = str_replace(" ","_",$video);
                            $tfile      = time();
                            $vidname    = $unit.'_'.$tfile.'-'.$vid;
                            $newname    = "../video/$vidname";
                            $copied     = copy($_FILES['fVideo']['tmp_name'], $newname);  

                            //inser into table
                            $insVideo = mysqli_query($ppdb, "INSERT INTO med_video (vid_file,vid_unit,vid_uploader,vid_date) VALUES ('$vidname','$unit', '$_SESSION[slogin]', CURRENT_TIMESTAMP())");

                            echo "
                            <script>
                                setTimeout(function() {
                                    swal({
                                        html  : true,
                                        title : 'Upload Berhasil',
                                        text  : 'Upload file video Satuan Pendidikan $unit berhasil.',
                                        type  : 'success',
                                        confirmButtonColor : '#1ab394',
                                        cancelButtonText   : 'Tutup',
                                        confirmButtonText  : 'Upload lagi',
                                        showCancelButton   : true
                                    }, function() {
                                            window.location = '?page=".base64_encode('uploadvideo')."&act=".base64_encode('formuploadvideo')."';
                                    }, 1000);
                                });                         
                            </script>";                   


                        } elseif($act == "hapusvideo"){
                            $vidID =  base64_decode(mysqli_real_escape_string($ppdb,$_REQUEST['idvid']));
                            $chkVid = mysqli_fetch_array(mysqli_query($ppdb, "SELECT vid_stat,vid_file FROM med_video WHERE vid_id = '$vidID'"));
                            
                            if($chkVid['vid_stat'] == 2 || $chkVid['vid_stat'] == 0){
                                echo "
                                <script>
                                    setTimeout(function() {
                                        swal({
                                            html  : true,
                                            title : 'Hapus Video',
                                            text  : 'Upakah video $chkVid[vid_file] akan dihapus?',
                                            type  : 'warning',                                        
                                            confirmButtonColor : '#f8bb86',
                                            cancelButtonText   : 'Batal',
                                            confirmButtonText  : 'Hapus!',
                                            showCancelButton   : true
                                        }, function() {
                                                window.location = '?page=".base64_encode('uploadvideo')."&act=".base64_encode('exechapusvideo')."&vfile=".base64_encode($chkVid['vid_file'])."&vid=".base64_encode($vidID)."';
                                        }, 1000);
                                    });                         
                                </script>";
                            } else {
                                echo "
                                <script>
                                    setTimeout(function() {
                                        swal({
                                        html: true,
                                        title : 'Error Hapus',
                                        text  : 'Hapus video $chkVid[vid_file] tidak dapat dihapus, status masih <strong class=\"text-danger faa-flash animated\">Idle atau Playing</strong>!',
                                        type  : 'error',
                                        confirmButtonColor : '#f27474',
                                        confirmButtonText  : 'Tutup',
                                        }, function() {
                                            window.location = '?page=".base64_encode('uploadvideo')."&act=".base64_encode('listsvideo')."';
                                        }, 1000);
                                    });                         
                                </script>";}

                        } elseif($act == "exechapusvideo"){       
                            // delete file video dari server
                            $delvidID    = base64_decode(mysqli_real_escape_string($ppdb,$_REQUEST['vid']));
                            $delvidFile  = base64_decode(mysqli_real_escape_string($ppdb,$_REQUEST['vfile']));
                            // delete file
                            unlink("../video/".$delvidFile);
                            $delVid    = mysqli_query($ppdb, "DELETE FROM med_video WHERE vid_id = '$delvidID'"); 
                            echo "
                            <script>
                                setTimeout(function() {
                                    swal({
                                        html  : true,
                                        title : 'Berhasil Hapus',
                                        text  : 'File video <strong class=\"text-info\">$delvidFile</strong> berhasil dihapus.',
                                        type  : 'success',
                                        confirmButtonColor : '#1ab394',
                                        confirmButtonText  : 'Upload lagi',
                                        showCancelButton   : false
                                    }, function() {
                                            window.location = './';
                                    }, 1000);
                                });                         
                            </script>";

                        } elseif($act == "previewvideo"){
                            $vidID =  base64_decode(mysqli_real_escape_string($ppdb,$_REQUEST['idvid']));
                            $playVid = mysqli_fetch_array(mysqli_query($ppdb, "SELECT vid_file FROM med_video WHERE vid_id = '$vidID'"));
                            
                            echo"
                            <!-- MODAL BOX  -->
                            <div class='modal inmodal' id='config' tabindex='-1' role='dialog' aria-hidden='true' data-keyboard='false' data-backdrop='static'>
                                <div class='modal-dialog modal-lg' style='width:70%'>
                                    <div class='modal-content animated fadeIn'>
                                        
                                        <div class='modal-body'>
                                           <video width='70%' controls autoplay>
                                               <source src='../video/$playVid[vid_file]' type='video/mp4'>
                                            </video>
                                        </div>
                                        <div class='modal-footer'><a href='./' class='btn btn-info btn-outline'>Tutup</a></div>  
                                    </div>
                                </div>
                            </div>";    
                        } elseif($act == "updatestatusvideo"){
                            $idv = base64_decode(mysqli_real_escape_string($ppdb,$_REQUEST['idvid']));
                            $stv = base64_decode(mysqli_real_escape_string($ppdb,$_REQUEST['svid']));
                            $xst = base64_decode(mysqli_real_escape_string($ppdb,$_REQUEST['xstat']));

                            if($stv == 1){
                                echo "
                                <script>
                                    setTimeout(function() {
                                        swal({
                                        html: true,
                                        title : 'Gagal Update',
                                        text  : 'File video tidak dapat di-update karena status <strong class=\"text-danger faa-flash animated\">Playing</strong>. Silakan periksa file video yang akan di-update!',
                                        type  : 'error',
                                        confirmButtonColor : '#f27474',
                                        confirmButtonText  : 'Tutup',
                                        }, function() {
                                            window.location = '?page=".base64_encode('uploadvideo')."&act=".base64_encode('listsvideo')."';
                                        }, 1000);
                                    });                         
                                </script>";
                            
                            } else {
                                $updVids = mysqli_query($ppdb, "UPDATE med_video SET vid_stat = '$xst' WHERE vid_id = '$idv'");
                                echo "
                                <script>
                                    setTimeout(function() {
                                        swal({
                                        html: true,
                                        title : 'Update Berhasil',
                                        text  : 'File video berhasil update status. ==  $xst ',
                                        type  : 'success',
                                        confirmButtonColor : '#1ab394',
                                        confirmButtonText  : 'Tutup',
                                        }, function() {
                                            window.location = '?page=".base64_encode('uploadvideo')."&act=".base64_encode('listsvideo')."';
                                        }, 1000);
                                    });                         
                                </script>";
                            }
                        }
                    break;
                    
                    case "createplaylist" :
                        include "dashboard.php";
                       
                        if($act == "listplay"){
                            // Existing item video
                            $chkListx = mysqli_fetch_array(mysqli_query($ppdb,"SELECT COUNT(vid_id) AS jList FROM med_video WHERE vid_stat=0"));
                            if($chkListx['jList'] > 0){
                                $vToken = VidToken(6);
                                echo"
                                <!-- MODAL BOX  -->
                                <div class='modal inmodal' id='config' tabindex='-1' role='dialog' aria-hidden='true' data-keyboard='false' data-backdrop='static'>
                                    <div class='modal-dialog modal-lg' style='width:55%'>
                                        <div class='modal-content animated fadeIn'>
                                            <div class='modal-header'>                                    
                                                <h4 class='modal-title'>Pembuatan Playlist Video</h4>    
                                            </div>
                                            <div class='modal-body'>
                                                <form role='form' class='form-validation' enctype='multipart/form-data' method='post' action='?page=".base64_encode("createplaylist")."&act=".base64_encode("execcreatepl")."' '>  
                                                <div class='row'> ";
                                                echo"
                                                
                                                    <div class='col-sm-12'>
                                                    
                                                        <div class='form-group'>
                                                            <label class='col-sm-3 control-label' style='margin-top:10px;'>Playlist Token</label>
                                                            <div class='col-sm-9'>
                                                                <input type='text' value='$vToken' class='form-control' disabled>  
                                                                <input type='hidden' name='pltoken' value='$vToken'>  
                                                            </div>
                                                        </div>
                                                        <div class='form-group'>
                                                            <label class='col-sm-3 control-label'style='margin-top:15px;'>Nama Playlist</label>
                                                            <div class='col-sm-9' style='margin-top:5px;'>
                                                                <input type='text' value='Profil_Playlist' class='form-control' disabled>  
                                                            </div>
                                                        </div>
                                                        <div class='form-group' >
                                                            <label class='col-sm-3 control-label' style='margin-top:15px;'>Network Drive Letter</label>
                                                            <div class='col-sm-9' style='margin-top:5px;'>
                                                                <select  class='form-control' name='drive' required>
                                                                    <option value='Z' SELECTED>Drive Z://</option>
                                                                    <option value='Y'>Drive Y://</option>
                                                                    <option value='X'>Drive X://</option>
                                                                    <option value='W'>Drive W://</option>
                                                                    <option value='V'>Drive V://</option>
                                                                </select>    
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class='col-sm-12' style='margin-bottom:5px;margin-top:20px'>


                                                        <div class='table-responsive'>                                                    
                                                                <table class='table table-striped table-bordered table-hover' >
                                                                <thead>                            
                                                                <tr>
                                                                    <th width='3%'>No</th>                                
                                                                    <th >Nama FIle Video</th>                                
                                                                    <th >Durasi</th>                                
                                                                    <th >Ukuran</th>                                
                                                                    <th >Tgl. Unggah</th>
                                                                    <th >Uploader</th>
                                                                    <th width='5%'>Unit</th>
                                                                    <th width='2%'>Status</th>
                                                                    <th >Aksi</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>";
                                                                
                                                                
                                                                    // Load data file 
                                                                    $vidListx = mysqli_query($ppdb,"SELECT * FROM med_video WHERE vid_stat =0 ORDER BY vid_id DESC");
                                                                    $no = -1;
                                                                    $jj = 0;
                                                                    while($rsVideox = mysqli_fetch_array($vidListx)){
                                                                        $no++;
                                                                        $jj++;
                                                                        $timeStampx = $rsVideox['vid_date'];
                                                                        // Get File Info by getID3
                                                                        $filex = $rsVideox['vid_file']; 
                                                                        $locx  = "../video/"; 
                                                                        $getID3x = new getID3;
                                                                        $filex = $getID3->analyze($locx.$filex);
                                                                        // Button Conditional
                                                                        if($rsVideox['vid_stat'] == 0  ){
                                                                            $sicox = "fa fa-toggle-on"; $scolorx = "btn-info"; $statsx = 2;
                                                                        } elseif($rsVideox['vid_stat'] == 2){
                                                                            $sicox = "fa fa-toggle-off"; $scolorx = "btn-warning";$stats = 0;
                                                                        } else {$sicox = "fa fa-ban"; $scolorx = "btn-default"; $statsx = 0;}
                                                                    
                                                                        echo "
                                                                        <tr>
                                                                            <td>$jj</td>                                    
                                                                            <td>$rsVideox[vid_file]</td>                                    
                                                                            <td>$filex[playtime_string] menit</td> 
                                                                            <td>".xSize($filex['filesize'])."</td>                                    
                                                                            <td>".date( "m/d/Y H:i:s", strtotime($timeStampx))."</td>
                                                                            <td>$rsVideox[vid_uploader]</td>
                                                                            <td>$rsVideox[vid_unit]</td>
                                                                            <td>".zVid($rsVideox['vid_stat'])."</td>
                                                                            <td>                                                                            
                                                                                <a href='?page=".base64_encode('createplaylist')."&act=".base64_encode('prevvideo')."&idvid=".base64_encode($rsVideox['vid_id'])."' class='btn btn-xs btn-outline btn-info' data-toggle='popover' data-content='Preview file video $rsVideox[vid_file]' title='Data Detail'  data-placement='bottom'><i class='fa fa-play'></i></a>
        
                                                                            </td>
                                                                        </tr>";
                                                                    }
                                                                
                                                                echo"
                                                                </tfoot>
                                                                </table>
                                                            </div>            
                                                        </div>
                                                    </div>
                                                    </div>

                                                    <div class='modal-footer'>
                                                    <a href='./' class='btn btn-white'>Tutup</a>                                                   
                                                    <button type='submit' name='savepass' class='btn btn-info'>Simpan</button>
                                                    </div>    
                                                    
                                                </form>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>";    
                            } else {
                              
                                echo "
                                <script>
                                    setTimeout(function() {
                                        swal({
                                        title : 'Error Playlist',
                                        text  : 'Pembuatan playlist video gagal karena tidak ada video yagn statusnya IDLE. Silahkan unggah video terlebih dahulu atau ubah staus video menjadi IDLE!',
                                        type  : 'error',
                                        confirmButtonColor : '#f27474',
                                        confirmButtonText  : 'Ulangi',
                                        }, function() {
                                            window.location = './';
                                        }, 1000);
                                    });                         
                                </script>";
                            }                        
                        } elseif($act == "prevvideo" ) {
                           
                            $vidIDx =  base64_decode(mysqli_real_escape_string($ppdb,$_REQUEST['idvid']));
                            $playVidx = mysqli_fetch_array(mysqli_query($ppdb, "SELECT vid_file FROM med_video WHERE b.vid_id = '$vidIDx'"));
                            echo"
                            <!-- MODAL BOX  -->
                            <div class='modal inmodal' id='config' tabindex='-1' role='dialog' aria-hidden='true' data-keyboard='false' data-backdrop='static'>
                                <div class='modal-dialog modal-lg' style='width:70%'>
                                    <div class='modal-content'>
                                        
                                        <div class='modal-body'>
                                           <video width='70%' controls autoplay>
                                               <source src='../video/$playVidx[vid_file]' type='video/mp4'>
                                            </video>
                                        </div>
                                        <div class='modal-footer'><a href='?page=".base64_encode("createplaylist")."&act=".base64_encode("listplay")."' class='btn btn-info btn-outline'>Tutup</a></div>  
                                    </div>
                                </div>
                            </div>";    

                        } elseif($act == "previewvideox" ) {
                           
                            $vidIDx  =  base64_decode(mysqli_real_escape_string($ppdb,$_REQUEST['idvid']));
                            $codeplx =  base64_decode(mysqli_real_escape_string($ppdb,$_REQUEST['plcode']));
                            $playVidx = mysqli_fetch_array(mysqli_query($ppdb, "SELECT  vid_file FROM med_video WHERE vid_id = '$vidIDx'"));
                            echo"
                            <!-- MODAL BOX  -->
                            <div class='modal inmodal' id='config' tabindex='-1' role='dialog' aria-hidden='true' data-keyboard='false' data-backdrop='static'>
                                <div class='modal-dialog modal-lg' style='width:70%'>
                                    <div class='modal-content'>
                                        <div class='modal-body'>
                                           <video width='70%' controls autoplay>
                                               <source src='../video/$playVidx[vid_file]' type='video/mp4'>
                                            </video>
                                        </div>
                                        <div class='modal-footer'><a href='?page=".base64_encode("createplaylist")."&act=".base64_encode("detailplaylistvid")."&plcode=".base64_encode($codeplx)."' class='btn btn-info btn-outline'>Tutup</a></div>  
                                    </div>
                                </div>
                            </div>";   
                            
                        } elseif($act == "execcreatepl"){
                            $vTkn = mysqli_real_escape_string($ppdb,$_POST['pltoken']);
                            $vDrv = mysqli_real_escape_string($ppdb,$_POST['drive']);
                            // UPDATE FILE INTO PLAYED IN EXISTING PLAYLIST
                            $pUpdate  = mysqli_query($ppdb,"UPDATE med_video SET vid_stat = 2 WHERE vid_stat = 1");
                            // DELETE EXISTING PLAYLIST
                            $plExist = "../playlist/Profile_Playlist.xspf";
                            if(file_exists($plExist)){
                                 unlink($plExist);
                             }  

                            $file_handle = fopen('../playlist/Profil_Playlist.xspf', 'w');
                            fwrite($file_handle, '<?xml version="1.0" encoding="UTF-8"?>');
                            fwrite($file_handle, "\n");
                            fwrite($file_handle, '<playlist xmlns="http://xspf.org/ns/0/" xmlns:vlc="http://www.videolan.org/vlc/playlist/ns/0/" version="1">');
                            fwrite($file_handle, "\n");
                            fwrite($file_handle, "     <title>Santa Angela Media [ $vTkn ]</title>");
                            fwrite($file_handle, "\n");
                            fwrite($file_handle, '     <trackList>');
                            fwrite($file_handle, "\n");
                            // Load data video from db
                            $jm = 0;
                            $pit = -1;
                            $playList = mysqli_query($ppdb, "SELECT * FROM med_video WHERE vid_stat = 0"); 
                            while($lPlay = mysqli_fetch_array($playList)){
                                $jm++;
                                $pit++;
                                // INSERT PLAYLIST ITEM INTO DB
                                $pInsert = mysqli_query($ppdb,"INSERT INTO med_playlist (pl_file,pl_tgl,pl_code,pl_creator) VALUES ('$lPlay[vid_file]',CURRENT_TIMESTAMP(),'$vTkn','$dUser[usr_login]')");
                                $vFile = $lPlay['vid_file']; 
                                $vLoc  = "../video/"; 
                                $vgetID3 = new getID3;
                                $vFile = $vgetID3->analyze($vLoc.$vFile);
                                $dura = str_replace(".","",$vFile['playtime_seconds']);
                                fwrite($file_handle, '         <track>');
                                fwrite($file_handle, "\n");
                                fwrite($file_handle, "             <location>file:///$vDrv:/$lPlay[vid_file]</location>");
                                fwrite($file_handle, "\n");
                                fwrite($file_handle, "             <duration>$dura</duration>");
                                fwrite($file_handle, "\n");                            
                                fwrite($file_handle, "             <extension application='http://www.videolan.org/vlc/playlist/0'>");                            
                                fwrite($file_handle, "\n");                            
                                fwrite($file_handle, "                     <vlc:id>$pit</vlc:id>");                            
                                fwrite($file_handle, "\n");                            
                                fwrite($file_handle, "              </extension>");                            
                                fwrite($file_handle, "\n");                            
                                fwrite($file_handle, '         </track>');
                                fwrite($file_handle, "\n");
                            }
                            fwrite($file_handle, '        </trackList>');
                            fwrite($file_handle, "\n");
                            fwrite($file_handle, '        <extension application="http://www.videolan.org/vlc/playlist/0">');
                            fwrite($file_handle, "\n");
                            // Create List item
                            $playItem = mysqli_query($ppdb, "SELECT vid_id FROM med_video WHERE vid_stat = 0");  
                            $it = -1;
                            while($rplayItem = mysqli_fetch_array($playItem)){
                                $it++;
                                fwrite($file_handle, "              <vlc:item tid='$it'/>");
                                fwrite($file_handle, "\n");
                            }
                            
                            fwrite($file_handle, "\n");
                            fwrite($file_handle, '           </extension>');
                            fwrite($file_handle, "\n");
                            fwrite($file_handle, '</playlist>');                           
                            
                            fclose($file_handle);

                            $xUpdate  = mysqli_query($ppdb,"UPDATE med_video SET vid_stat = 1 WHERE vid_stat = 0");      
                            
                            echo "
                            <script>
                                setTimeout(function() {
                                    swal({
                                        html  : true,
                                        title : 'Berhasil Create Playlist',
                                        text  : 'Pembuatan playlist berhasil dilakukan dengan jumlah : $jm video dan token playlist : $vTkn.',
                                        type  : 'success',
                                        confirmButtonColor : '#1ab394',
                                        confirmButtonText  : 'Tutup',
                                        showCancelButton   : false
                                    }, function() {
                                            window.location = './';
                                    }, 1000);
                                });                         
                            </script>";   



                        } elseif($act == "daftarlistplay") {
                            $cplay = mysqli_query($ppdb, "SELECT * FROM med_playlist ORDER BY pl_id DESC");
                            echo"
                            <!-- MODAL BOX  -->
                                <div class='modal inmodal' id='config' tabindex='-1' role='dialog' aria-hidden='true' data-keyboard='false' data-backdrop='static'>
                                    <div class='modal-dialog modal-lg'>
                                        <div class='modal-content animated fadeIn'>
                                            <div class='modal-header'>                                    
                                                <h4 class='modal-title'>Video Playlist</h4>    
                                            </div>
                                            <div class='modal-body'>

                                            <div class='table-responsive'>                                                    
                                                    <table class='table table-striped table-bordered table-hover' >
                                                    <thead>                            
                                                    <tr>
                                                        <th width='3%'>No</th>                                
                                                        <th >Token Playlist</th>                                
                                                        <th >Jumlah File</th>                                
                                                        <th >Tanggal Pembuatan</th>                                
                                                        <th >Creator</th>                                                                    
                                                        <th >Aksi</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>";
                                                    
                                                    
                                                        // Load data file 
                                                        $plList = mysqli_query($ppdb,"SELECT * FROM med_playlist  GROUP BY pl_code ORDER BY pl_id DESC");                                                                  
                                                        $jx= 0;
                                                        while($lsPlay = mysqli_fetch_array($plList)){
                                                            $jx++;                            
                                                            $timestampy = $lsPlay['pl_tgl'];
                                                            $jvid = mysqli_fetch_array(mysqli_query($ppdb,"SELECT COUNT(pl_id) AS jvid FROM med_playlist WHERE pl_code = '$lsPlay[pl_code]'"));                                        
                                                            echo "
                                                            <tr>
                                                                <td>$jx</td>                                    
                                                                <td>$lsPlay[pl_code]</td>    
                                                                <td>$jvid[jvid] Video</td>                                    
                                                                <td>".date( "m/d/Y H:i:s", strtotime($lsPlay['pl_tgl']))."</td>
                                                                <td>$lsPlay[pl_creator]</td>                                                                
                                                                <td>                                                                            
                                                                    <a href='?page=".base64_encode('createplaylist')."&act=".base64_encode('detailplaylistvid')."&plcode=".base64_encode($lsPlay['pl_code'])."' class='btn btn-xs btn-outline btn-info' data-toggle='popover' data-content='Data detail playlist video token $lsPlay[pl_code]' title='Data Detail'  data-placement='bottom'><i class='fa fa-list'></i></a>
                                                                </td>
                                                            </tr>";
                                                        }
                                                    
                                                    echo"
                                                    </tfoot>
                                                    </table>
                                                </div> 
                                            </div>
                                            <div class='modal-footer'>
                                                <a href='./' class='btn btn-info btn-outline'>Tutup</a></div>   
                                        </div>
                                    </div>
                                </div>";
                        } elseif($act == "detailplaylistvid") {
                            $plcode = base64_decode($_GET['plcode']);
                            $plLoad = mysqli_query($ppdb,"SELECT  * FROM med_playlist AS a LEFT JOIN med_video AS b ON (a.pl_file = b.vid_file) WHERE a.pl_code = '$plcode'");
                            echo"
                            <!-- MODAL BOX  -->
                                <div class='modal inmodal' id='config' tabindex='-1' role='dialog' aria-hidden='true' data-keyboard='false' data-backdrop='static'>
                                    <div class='modal-dialog modal-lg'>
                                        <div class='modal-content animated fadeIn'>
                                            <div class='modal-header'>                                    
                                                <h4 class='modal-title'>Detail Video Playlist</h4>    
                                            </div>
                                            <div class='modal-body'>

                                            <div class='table-responsive'>       
                                                    <h4 class='text-center text-info'>Token Playlist : $plcode</h4>                                             
                                                    <table class='table table-striped table-bordered table-hover' >
                                                    <thead>                            
                                                    <tr>
                                                        <th width='3%'>No</th>                                
                                                        <th>Nama File</th>                                
                                                        <th>Durasi</th>                                
                                                        <th>Unit</th>                                
                                                        <th>Tgl. Unggah</th>                                                                    
                                                        <th>Aksi</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>";
                                                        // Load data file                           
                                                        $jy= 0;
                                                        while($rsLoad = mysqli_fetch_array($plLoad)){
                                                            $jy++;                     
                                                            // Catch getID3 for video duration
                                                            $files = $rsLoad['vid_file']; 
                                                            $locs  = "../video/";
                                                            $getID3s = new getID3;
                                                            $files = $getID3->analyze($locs.$files);
                                                            
                                                            echo "
                                                            <tr>
                                                                <td>$jy</td>                                    
                                                                <td>$rsLoad[vid_file]</td>    
                                                                <td>$files[playtime_string] menit</td>                                    
                                                                <td>$rsLoad[vid_unit]</td>                                    
                                                                <td>".date( "m/d/Y H:i:s", strtotime($rsLoad['pl_tgl']))."</td>
                                                                <td>                                                                            
                                                                    <a href='?page=".base64_encode('createplaylist')."&act=".base64_encode('previewvideox')."&idvid=".base64_encode($rsLoad['vid_id'])."&plcode=".base64_encode($rsLoad['pl_code'])."' class='btn btn-xs btn-outline btn-info' data-toggle='popover' data-content='Data detail playlist video token $lsPlay[pl_code]' title='Data Detail'  data-placement='bottom'><i class='fa fa-play'></i></a>
                                                                </td>
                                                            </tr>";
                                                        }
                                                    
                                                    echo"
                                                    </tfoot>
                                                    </table>
                                                </div> 
                                            </div>
                                            <div class='modal-footer'>
                                                <a href='./' class='btn btn-info btn-outline'>Tutup</a></div>   
                                        </div>
                                    </div>
                                </div>";

                        }
                    break;
                   
                         
                } 
                ?>
                <div class="footer">
                    <div class="pull-right">
                        Versi : <strong>PPDB v3.0</strong> @ 2022.
                    </div>
                    <div>
                        Bagian Pengembangan Teknologi Informasi<br> <strong><span class="text-primary">Kampus Santa Angela</span></strong>
                    </div>
                </div>
            </div>
        </div>

        </div>
        
        
    </div>

    <!-- Mainly scripts -->
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Flot -->
    <script src="js/plugins/flot/jquery.flot.js"></script>
    <script src="js/plugins/flot/jquery.flot.tooltip.min.js"></script>
    <script src="js/plugins/flot/jquery.flot.spline.js"></script>
    <script src="js/plugins/flot/jquery.flot.resize.js"></script>
    <script src="js/plugins/flot/jquery.flot.pie.js"></script>

    <!-- Peity -->
    <script src="js/plugins/peity/jquery.peity.min.js"></script>
    <script src="js/demo/peity-demo.js"></script>
    <script src="js/plugins/clockpicker/clockpicker.js"></script>
    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>

    <!-- jQuery UI -->
    <script src="js/plugins/jquery-ui/jquery-ui.min.js"></script>

    <!-- GITTER -->
    <script src="js/plugins/gritter/jquery.gritter.min.js"></script>

    <!-- Sparkline -->
    <script src="js/plugins/sparkline/jquery.sparkline.min.js"></script>


    <!-- ChartJS-->
    <script src="js/plugins/chartJs/Chart.min.js"></script>

    <!-- Toastr -->
    <script src="js/plugins/toastr/toastr.min.js"></script>
    <script src="js/plugins/iCheck/icheck.min.js"></script>
    <script src="js/plugins/datapicker/bootstrap-datepicker.js"></script>
    <script src="js/plugins/sweetalert/sweetalert.min.js"></script>
    <script src="js/plugins/dataTables/datatables.min.js"></script>
    <script src="js/plugins/pwstrength/pwstrength-bootstrap.min.js"></script>
    <script src="js/plugins/pwstrength/zxcvbn.js"></script>
        
   
    
    
    <script>
        $(document).ready(function () {
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        });
        
    </script>

    <!-- Page-Level Scripts -->
    <script>
        $(document).ready(function(){
            $('.video-unit').DataTable({
                pageLength: 10,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    {extend: 'print',
                     customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                    }
                    }
                ]
            });
        });
    </script>
    <script>
        var options3 = {};
        options3.ui = {
            container: "#pwd-container3",
            showVerdictsInsideProgressBar: true,
            viewports: {
                progress: ".pwstrength_viewport_progress2"
            }
        };
        options3.common = {
            debug: true,
            usernameField: "#username"
        };
        $('.example3').pwstrength(options3);   
    </script>
    <script>
    $(document).ready(function() {
        $("#input-b6a").fileinput({
            showUpload: false,
            dropZoneEnabled: false,
            maxFileCount: 10,
            inputGroupClass: "input-group-lg"
        });
        $("#input-b6b").fileinput({
            showUpload: false,
            dropZoneEnabled: false,
            maxFileCount: 10,
            inputGroupClass: "input-group-sm"
        });
    });
    </script>
    <script>
        $('[data-toggle="popover"]').popover({
           placement : "left", 
           trigger   : "hover",
           title     : 'Tombol buka / tutup'
       });    
    </script>
    <script>
     $('#config').modal('show'); 
    </script>
</body>
</html>
