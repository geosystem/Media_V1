<?php
$upStatus = $lKonfig['kon_upload'];
$vidUnit = strtoupper($dUser['usr_unit']);
if($dUser['usr_unit'] == 'yay'){
    $vFilter = "";
} else {
    $vFilter = " WHERE vid_unit = '$vidUnit' ";
}

?>

<div id="page-wrapper" class="gray-bg dashbard-1">
        <div class="row border-bottom">
        <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
            
        </div>
            <ul class="nav navbar-top-links navbar-right">
                <li>
                    <span class="m-r-sm text-muted welcome-message">Multimedia Kampus Santa Angela</span>
                </li>
                <li>
                    <a href="login.html">
                        <i class="fa fa-sign-out"></i> Log out
                    </a>
                </li>
                
            </ul>

        </nav>
        </div>
           
        <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Data Unggah Video Kegiatan Satuan Pendidikan</h2>
                    <h4>Digital Announcement Kampus Santa Angela</h4>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content">
            <div class="row">
              <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="p-sm">
                        <h3>Video Kegiatan Satuan Pendidikan <a href="./" class="btn btn-primary btn-sm pull-right"><i class="fa fa-refresh"></i> Refresh Page</a></h3> 
                                            
                    </div>
                    
                    <div class="ibox-content">
                        <div class="table-responsive">                                                    
                            <table class="table table-striped table-bordered table-hover video-unit" >
                            <thead>                            
                            <tr>
                                <th width="3%">No</th>                                
                                <th >Nama FIle Video</th>                                
                                <th >Durasi</th>                                
                                <th >Ukuran</th>                                
                                <th >Tgl. Unggah</th>
                                <th >Uploader</th>
                                <th width="5%">Unit</th>
                                <th width="2%">Status</th>
                                <th >Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            
                            <?php
                                // Load data file 
                                $vidList = mysqli_query($ppdb,"SELECT * FROM med_video $vFilter ORDER BY vid_id DESC");
                                $no = -1;
                                $xjj=0;
                                while($rsVideo = mysqli_fetch_array($vidList)){
                                    $no++;
                                    $xjj++;
                                    $timeStamp = $rsVideo['vid_date'];
                                    // Get File Info by getID3
                                    $file = $rsVideo['vid_file']; 
                                    $loc  = "../video/"; //path to your video file it could also be music not only video
                                    $getID3 = new getID3;
                                    $file = $getID3->analyze($loc.$file);
                                    // Button Conditional
                                    if($rsVideo['vid_stat'] == 0  ){
                                        $sico = "fa fa-toggle-on"; $scolor = "btn-info"; $stats = 2;
                                    } elseif($rsVideo['vid_stat'] == 2){
                                        $sico = "fa fa-toggle-off"; $scolor = "btn-warning";$stats = 0;
                                    } else {$sico = "fa fa-ban"; $scolor = "btn-default"; $stats = 0;}
                                   
                                    echo "
                                    <tr>
                                        <td>$xjj</td>                                    
                                        <td>$rsVideo[vid_file]</td>                                    
                                        <td>$file[playtime_string] menit</td> 
                                        <td>".xSize($file['filesize'])."</td>                                    
                                        <td>".date( "m/d/Y H:i:s", strtotime($timeStamp))."</td>
                                        <td>$rsVideo[vid_uploader]</td>
                                        <td>$rsVideo[vid_unit]</td>
                                        <td>".zVid($rsVideo['vid_stat'])."</td>
                                        <td>";
                                        if($dUser['usr_unit'] == 'yay') {
                                            echo"
                                            <a href='?page=".base64_encode('uploadvideo')."&act=".base64_encode('updatestatusvideo')."&idvid=".base64_encode($rsVideo['vid_id'])."&svid=".base64_encode($rsVideo['vid_stat'])."&xstat=".base64_encode($stats)."' class='btn btn-xs btn-outline $scolor' data-toggle='popover' data-content='Ubah Status file video $rsVideo[vid_file]' title='Data Detail'  data-placement='bottom'><i class='$sico'></i></a>
                                            <a href='?page=".base64_encode('uploadvideo')."&act=".base64_encode('previewvideo')."&idvid=".base64_encode($rsVideo['vid_id'])."' class='btn btn-xs btn-outline btn-info' data-toggle='popover' data-content='Hapus file video $rsVideo[vid_file]' title='Data Detail'  data-placement='bottom'><i class='fa fa-play'></i></a>
                                            <a href='?page=".base64_encode('uploadvideo')."&act=".base64_encode('hapusvideo')."&idvid=".base64_encode($rsVideo['vid_id'])."' class='btn btn-xs btn-outline btn-danger' data-toggle='popover' data-content='Hapus file video $rsVideo[vid_file]' title='Data Detail'  data-placement='bottom'><i class='fa fa-times'></i></a>";
                                        } else {
                                            echo "<a href='?page=".base64_encode('uploadvideo')."&act=".base64_encode('previewvideo')."&idvid=".base64_encode($rsVideo['vid_id'])."' class='btn btn-xs btn-outline btn-info' data-toggle='popover' data-content='Hapus file video $rsVideo[vid_file]' title='Data Detail'  data-placement='bottom'><i class='fa fa-play'></i></a>";
                                        }
                                        echo"    
                                        </td>
                                    </tr>";
                                }
                            ?>
                            
                            </tfoot>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
            </div>
        </div>