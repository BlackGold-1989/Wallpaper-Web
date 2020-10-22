<?php
include_once 'database.php'; 
$database = new Connection();
$db = $database->openConnection();
$myWallpapersql = $db->prepare("SELECT sw.id, sw.user_id, sw.image, sw.wallpaper_color,sw.wallpaper_height, sw.views, sw.likes, sw.status, sc.category, su.username,su.profile_image
    FROM status_wallpapers AS sw 
    INNER JOIN status_category as sc ON sw.cat_id=sc.id
    INNER JOIN status_users as su ON sw.user_id=su.id
    WHERE sw.user_id = '".$_GET['id']."'");
$myWallpapersql->execute();
$myData = $myWallpapersql->fetchAll();
?>
<div class="row">
<?php
foreach ($myData as $value) {
?>
<div class="col-md-6 col-lg-3">
    <div class="card">
        <?php
        if ($value['image'] != "") {
        ?>
            <img class="img-fluid" src="images/wallpapers/<?php echo $value['image']; ?>" style="max-height: 255px; min-height: 255px;" >
        <?php 
        } else {
        ?>
            <img class="img-fluid" src="images/255x255.png" style="max-height: 255px; min-height: 255px;" >
        <?php
        }
        ?>
        <div class="card-footer">
            <p class="card-text d-inline">
                <span class="text-success"><i class="icon-like"></i> <?php echo $value['likes']; ?></span> <span class="text-warning"><i class="icon-eye"></i> <?php echo $value['views']; ?></span>
            </p>
            <?php
            if ($value['status'] == "0") {
            ?> 
                <button type="button" onClick="WallpaperStatus('<?php echo $value['id']; ?>','1')" class="btn mb-2 btn-sm btn-warning float-right">Pending</button>
            <?php
            } elseif ($value['status'] == "1") {
            ?>
                <button type="button" onClick="WallpaperStatus('<?php echo $value['id']; ?>','2')" class="btn mb-2 btn-sm btn-success float-right">Approved</button>
            <?php
            } else {
            ?>
                <button type="button" onClick="WallpaperStatus('<?php echo $value['id']; ?>','1')" class="btn mb-2 btn-sm btn-danger float-right">Rejected</button>
            <?php
            }
            ?>
        </div>
    </div>
</div>
<?php
}
?>
</div>