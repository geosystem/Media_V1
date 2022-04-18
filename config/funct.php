<?php

function tgl($date=null)
{
   //buat array nama hari dalam bahasa Indonesia dengan urutan 1-7
   $array_hari = array(1=>'Senin','Selasa','Rabu','Kamis','Jumat', 'Sabtu','Minggu');
   //buat array nama bulan dalam bahasa Indonesia dengan urutan 1-12
   $array_bulan = array(1=>'Januari','Februari','Maret', 'April', 'Mei', 'Juni','Juli','Agustus',
       'September','Oktober', 'November','Desember');
   if($date == null) {
     //jika $date kosong, makan tanggal yang diformat adalah tanggal hari ini
     $hari = $array_hari[date('N')];
     $tanggal = date ('j');
     $bulan = $array_bulan[date('n')];
     $tahun = date('Y');
   } else {
     //jika $date diisi, makan tanggal yang diformat adalah tanggal tersebut
     $date  = strtotime($date);
     $hari  = $array_hari[date('N',$date)];
     $tanggal = date ('j', $date);
     $bulan = $array_bulan[date('n',$date)];
     $tahun = date('Y',$date);
   }
   //$formatTanggal = $hari . ", " . $tanggal ." ". $bulan ." ". $tahun;
   $formatTanggal = $tanggal ." ". $bulan ." ". $tahun;
   return $formatTanggal;
}

function codeBar($cID,$cSize){
    echo '<span style="color:#000;font-family:"barcode";font-size:'.$cSize.'px">*'.$cID.'*</span>';
    return;
}

function umur($var){
  $tglsekarang = date("Y-m-d");
  $query = "SELECT datediff('$tglsekarang', '$var') as selisih";
  $hasil = mysql_query($query);
  $data = mysql_fetch_array($hasil);
  $tahun = floor($data['selisih']/365);
  $bulan = floor(($data['selisih'] - ($tahun * 365))/30);
  $hari = $data['selisih'] - $bulan * 30 - $tahun * 365;
  return $tahun." thn ".$bulan." bln ".$hari." hr";
}

function rph($angka)
{
  $rupiah="";
  $rp=strlen($angka);
  while ($rp>3)
  {
    $rupiah = ".". substr($angka,-3). $rupiah;
    $s=strlen($angka) - 3;
    $angka=substr($angka,0,$s);
    $rp=strlen($angka);
  }
  $rupiah = "Rp." . $angka . $rupiah . ",00-";
  return $rupiah;
} 

function ztgl($ntgl){
    if($ntgl == '01-01-1970'  OR $ntgl == '1970-01-01')
       { '-'; }  
}

/// Generate Token Code
function crypto_rand_secure($min, $max)
{
    $range = $max - $min;
    if ($range < 1) return $min; // not so random...
    $log = ceil(log($range, 2));
    $bytes = (int) ($log / 8) + 1; // length in bytes
    $bits = (int) $log + 1; // length in bits
    $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
    do {
        $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
        $rnd = $rnd & $filter; // discard irrelevant bits
    } while ($rnd > $range);
    return $min + $rnd;
}

function getToken($length)
{
    $token = "";
    $codeAlphabet = "ABCDEFGHJKLMNPQRSTUVWXYZ";
    $codeAlphabet.= "23456789";
    $max = strlen($codeAlphabet); // edited

    for ($i=0; $i < $length; $i++) {
        $token .= $codeAlphabet[crypto_rand_secure(0, $max-1)];
    }

    return $token;
}


function VidToken($length)
{
    $token = "";
    //$codeAlphabet = "ABCDEFGHJKLMNPQRSTUVWXYZ";
    $codeAlphabet.= "23456789";
    $max = strlen($codeAlphabet); // edited

    for ($i=0; $i < $length; $i++) {
        $token .= $codeAlphabet[crypto_rand_secure(0, $max-1)];
    }

    return $token;
}


function xSize($size) {
    $units = array(' B', ' KB', ' MB', ' GB', ' TB');
    for ($i = 0; $size >= 1024 && $i < 4; $i++) $size /= 1024;
    return round($size, 2).$units[$i];
}

function cutword($string, $max_length){
        if (strlen($string) > $max_length){
            $string = substr($string, 0, $max_length);
            $pos = strrpos($string, " ");
            if($pos === false) {
                    return substr($string, 0, $max_length)."...";
            }
                return substr($string, 0, $pos)."...";
        }else{
            return $string;
        }
    }

function aPass($aPass){
    $pPass = sha1(md5(sha1(md5(base64_encode($aPass)))));
    return $pPass;
}  

function zVid($xVid){
    if($xVid == 0) {$vStat = "<span class='label label-default'>Idle</span>";}
    elseif($xVid == 1) {$vStat = "<span class='label label-info'>Playing</span>";}
    else {$vStat = "<span class='label label-danger'>Played</span>";}
    return $vStat;
}


?>
