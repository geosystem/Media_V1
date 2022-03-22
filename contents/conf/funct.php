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

function buatrp($angka)
{
 $jadi = "Rp " . number_format($angka,2,',','.');
return $jadi    ;
}

function terbilang($bilangan) {

  $angka = array('0','0','0','0','0','0','0','0','0','0',
                 '0','0','0','0','0','0');
  $kata = array('','satu','dua','tiga','empat','lima',
                'enam','tujuh','delapan','sembilan');
  $tingkat = array('','ribu','juta','milyar','triliun');

  $panjang_bilangan = strlen($bilangan);

  /* pengujian panjang bilangan */
  if ($panjang_bilangan > 15) {
    $kalimat = "Diluar Batas";
    return $kalimat;
  }

  /* mengambil angka-angka yang ada dalam bilangan,
     dimasukkan ke dalam array */
  for ($i = 1; $i <= $panjang_bilangan; $i++) {
    $angka[$i] = substr($bilangan,-($i),1);
  }

  $i = 1;
  $j = 0;
  $kalimat = "";


  /* mulai proses iterasi terhadap array angka */
  while ($i <= $panjang_bilangan) {

    $subkalimat = "";
    $kata1 = "";
    $kata2 = "";
    $kata3 = "";

    /* untuk ratusan */
    if ($angka[$i+2] != "0") {
      if ($angka[$i+2] == "1") {
        $kata1 = "seratus";
      } else {
        $kata1 = $kata[$angka[$i+2]] . " ratus";
      }
    }

    /* untuk puluhan atau belasan */
    if ($angka[$i+1] != "0") {
      if ($angka[$i+1] == "1") {
        if ($angka[$i] == "0") {
          $kata2 = "sepuluh";
        } elseif ($angka[$i] == "1") {
          $kata2 = "sebelas";
        } else {
          $kata2 = $kata[$angka[$i]] . " belas";
        }
      } else {
        $kata2 = $kata[$angka[$i+1]] . " puluh";
      }
    }

    /* untuk satuan */
    if ($angka[$i] != "0") {
      if ($angka[$i+1] != "1") {
        $kata3 = $kata[$angka[$i]];
      }
    }

    /* pengujian angka apakah tidak nol semua,
       lalu ditambahkan tingkat */
    if (($angka[$i] != "0") OR ($angka[$i+1] != "0") OR
        ($angka[$i+2] != "0")) {
      $subkalimat = "$kata1 $kata2 $kata3 " . $tingkat[$j] . " ";
    }

    /* gabungkan variabe sub kalimat (untuk satu blok 3 angka)
       ke variabel kalimat */
    $kalimat = $subkalimat . $kalimat;
    $i = $i + 3;
    $j = $j + 1;

  }

  /* mengganti satu ribu jadi seribu jika diperlukan */
  if (($angka[5] == "0") AND ($angka[6] == "0")) {
    $kalimat = str_replace("satu ribu","seribu",$kalimat);
  }   
  return trim($kalimat);  
} 

function ePass($zPass){
    $sPass = sha1(md5(md5(sha1($zPass))));
    return $sPass;
}

function aPass($aPass){
    $pPass = sha1(md5(sha1(md5(base64_encode($aPass)))));
    return $pPass;
}

function eCrypt($zCrypt){
    $sCrypt = base64_encode(str_rot13(base64_encode($zCrypt)));
    return $sCrypt;
}

function dCrypt($zdCrypt){
    $sdCrypt = base64_decode(str_rot13(base64_decode($zdCrypt)));
    return $sdCrypt;
}

function fSize($fsize) {
    $units = array(' B', ' KB', ' MB', ' GB', ' TB');
    for ($i = 0; $fsize >= 1024 && $i < 4; $i++) $fsize /= 1024;
    return round($fsize, 2).$units[$i];
}

function zVid($xVid){
    if($xVid == '0') {$vStat = "Idle";}
    elseif($xVid == '1') {$vStat = "Playing";}
    else {$vStat = "Played";}
    return $$vStat;
}

function VidToken($length)
{
    $token = "";
   // $codeAlphabet = "ABCDEFGHJKLMNPQRSTUVWXYZ";
    $codeAlphabet = "23456789";
    $max = strlen($codeAlphabet); // edited

    for ($i=0; $i < $length; $i++) {
        $token .= $codeAlphabet[crypto_rand_secure(0, $max-1)];
    }

    return $token;
}

?>
