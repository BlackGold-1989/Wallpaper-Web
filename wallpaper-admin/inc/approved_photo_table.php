<?php
include_once 'database.php'; 
$database = new Connection();
$db = $database->openConnection();
?>

<table class="table table-striped table-bordered zero-configuration" id="table-product">
    <thead>
        <tr>
            <th>#</th>
            <th>Image</th>
            <th>Uploaded By</th>
            <th>Category Name</th>
            <th>Created at</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sth = $db->prepare("SELECT gp.id,gp.image,gp.status,gp.created_at,gc.category,su.username
            FROM status_wallpapers AS gp
            INNER JOIN status_category AS gc ON gp.cat_id=gc.id
            INNER JOIN status_users AS su ON gp.user_id=su.id WHERE gp.status='1'");
        $sth->execute();
        $result = $sth->fetchAll();
        $i = 1;
        foreach ($result as $key => $value) {
        ?>
        <tr id="dataid<?php echo $value['id']; ?>">
            <td><?php echo $i; ?></td>
            <td><img src="images/wallpapers/<?php echo $value['image']; ?>" style="max-width: 120px; max-height: 120px;"></td>
            <td><?php echo $value['username']; ?></td>
            <td><?php echo $value['category']; ?></td>
            <td><?php echo $value['created_at']; ?></td>
            <td><a href="javascript:void(0)" data-toggle="modal" class="badge badge-primary"
                onclick="GetData('<?php echo $value['id']; ?>')">Edit</a>
                <a href="javascript:void(0)" class="badge badge-danger" onclick="DeleteData('<?php echo $value['id']; ?>')">Delete</a>
                <?php
                if ($value['status'] == "0") {
                ?> 
                    <button type="button" onClick="WallpaperStatus('<?php echo $value['id']; ?>','1')" class="badge badge-warning">Pending</button>
                <?php
                } elseif ($value['status'] == "1") {
                ?>
                    <button type="button" onClick="WallpaperStatus('<?php echo $value['id']; ?>','2')" class="badge badge-success">Approved</button>
                <?php
                } else {
                ?>
                    <button type="button" onClick="WallpaperStatus('<?php echo $value['id']; ?>','1')" class="badge badge-danger">Rejected</button>
                <?php
                }
                ?>
            </td>
        </tr>
        <?php
        $i++;
        }
        ?>
    </tbody>
</table>