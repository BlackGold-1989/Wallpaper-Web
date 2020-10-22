<?php
include_once 'database.php'; 
$database = new Connection();
$db = $database->openConnection();
?>
<table class="table table-striped table-bordered zero-configuration" id="table-category">
    <thead>
        <tr>
            <th>#</th>
            <th>Image</th>
            <th>Category Name</th>
            <th>Created At</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sth = $db->prepare("SELECT id,category,image,created_at FROM status_category");
        $sth->execute();
        $result = $sth->fetchAll();
        $i = 1;
        foreach ($result as $key => $value) {
        ?>
        <tr id="dataid<?php echo $value['id']; ?>">
            <td><?php echo $i; ?></td>
            <td><img src="images/category/<?php echo $value['image']; ?>" style="max-width: 120px; max-height: 120px;"></td>
            <td><?php echo $value['category']; ?></td>
            <td><?php echo $value['created_at']; ?></td>
            <td><a href="javascript:void(0)" class="badge badge-primary" data-toggle="modal"
                onclick="GetData('<?php echo $value['id']; ?>')">Edit</a>
                <a href="javascript:void(0)" class="badge badge-danger" onclick="DeleteData('<?php echo $value['id']; ?>')">Delete</a>
            </td>
        </tr>
        <?php
        $i++;
        }
        ?>
    </tbody>
</table>