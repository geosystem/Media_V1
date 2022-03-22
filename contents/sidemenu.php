<li class="active"><a href="./"><i class="fa fa-laptop"></i> <span class="nav-label">Video List</span></a><li>
<li><a href="?page=<?php echo base64_encode('uploadvideo');?>&act='<?php echo base64_encode('formuploadvideo'); ?>"><i class="fa fa-cloud-upload"></i> <span class="nav-label">Upload Video</span></span></a></li>
<li><a href="?page=<?php echo base64_encode('createplaylist');?>&act='<?php echo base64_encode('daftarlistplay'); ?>"><i class="fa fa-list"></i> <span class="nav-label">Video Playlist</span></span></a></li>
<?php
        if($dUser['usr_unit'] == 'yay'){
             echo"<li><a href='?page=".base64_encode('createplaylist')."&act=".base64_encode('listplay')."'><i class='fa fa-video-camera'></i> <span class='nav-label'>Create Playlist</span></span></a></li>";  
        } else {echo "";}      
       
    ?>



<li><a href="#"><i class="fa fa-gears"></i> <span class="nav-label">Admin Tools</span><span class="fa arrow"></span></a>
  <ul class="nav nav-second-level collapse">
    <?php
        if($dUser['usr_unit'] == 'yay'){
             echo"<li><a href='?page=".base64_encode('usermanagement')."&act=".base64_encode("listuser")."'>User Management</a></li> ";  
        } else {echo "";}      
       
    ?>

    <li><a href="?page=<?php echo base64_encode('passworduser');?>&act=<?php echo base64_encode("formpassword")?>">Ganti Password</a></li>
  </ul>
</li>
<li class="special_link">
    <a href="?page=<?php echo base64_encode('logoutpage');?>&act='<?php echo base64_encode('logoutconfirm'); ?>"><i class="fa fa-sign-out"></i> <span class="nav-label">Logout</span></a>
</li>


