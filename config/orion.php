  <?php
  /**
   * Created by GeoSystem.
   * User: Andreas
   * Date: 03/07/2018
   * Time: 22.43
   */  
   //error_reporting(0);
   //session_start();
   //session_cache_expire(0);
   //session_cache_limiter(0);
   //set_time_limit(0);
  
   
   date_default_timezone_set('Asia/Jakarta');
  
   
   //$uri = $_SERVER['HTTP_REFERER'];
   $uri = $_SERVER['REQUEST_URI'];
   $pageurl = explode("/",$uri);
   if($uri=='/') {
       $homeurl = "http://".$_SERVER['HTTP_HOST'];
       (isset($pageurl[1])) ? $pg = $pageurl[1] : $pg = '';
       (isset($pageurl[2])) ? $ac = $pageurl[2] : $ac = '';
       (isset($pageurl[3])) ? $id = $pageurl[3] : $id = 0;
   } else {
       $homeurl = "http://".$_SERVER['HTTP_HOST']."/".$pageurl[1];
       (isset($pageurl[2])) ? $pg = $pageurl[2] : $pg = '';
       (isset($pageurl[3])) ? $ac = $pageurl[3] : $ac = '';
       (isset($pageurl[4])) ? $id = $pageurl[4] : $id = 0;
   } 
  
   $khost = "localhost";
   $kdb   = "media";
   $kuser = "root";
   $kpass = "[arint0k0]";
   $ppdb  = mysqli_connect($khost,$kuser,$kpass,$kdb);
   mysqli_select_db($ppdb,$kdb);
   

  if(mysqli_connect_errno())
  { 
      $errorc = "<div class='col-md-12 alert alert-danger'> <strong class='faa-flash animated'><i class='fa fa-warning'></i> DATABASE NOT CONNECTED...!!</strong> Error connection : <strong></strong></div>";
      $btcon  = "disabled";
  }
  ?>