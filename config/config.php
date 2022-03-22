<?php
  // Load Sys Config
  $qcon    = "SELECT * FROM reg_conf where con_unit = '$unit'" ;
  $rcon    = mysqli_query($ppdb,$qcon) or die(mysqli_error());
  $rscon   = mysqli_fetch_array($rcon,MYSQLI_ASSOC);
?>
