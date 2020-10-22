<?php
include_once 'database.php'; 
$database = new Connection();
$db = $database->openConnection();
?>
<table class="table table-striped table-bordered zero-configuration" id="table-category">
    <thead>
        <tr>
            <th>#</th>
            <th>Profile Image</th>
            <th>Username</th>
            <th>Email</th>
            <th>Created At</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sth = $db->prepare("SELECT id,username,email,device_type,profile_image,notification_status,created_at FROM status_users WHERE role='0'");
        $sth->execute();
        $result = $sth->fetchAll();
        $i = 1;
        foreach ($result as $key => $value) {
        ?>
        <tr id="dataid<?php echo $value['id']; ?>">
            <td><?php echo $i; ?></td>
            <td>
                <?php
                if ($value['profile_image'] == "") {
                ?>
                    <img src="images/profile/user-avatar.png">
                <?php
                } else {
                ?>
                    <img class="mr-3" src="images/profile/<?php echo $value['profile_image']; ?>" style="border-radius: 50%; width: 80px; height:80px">
                <?php
                }
                ?>
            </td>
            <td><?php echo $value['username']; ?></td>
            <td><?php echo $value['email']; ?></td>
            <td><?php echo $value['created_at']; ?></td>
            <td>
                <a href="javascript:void(0)" class="badge badge-danger" onclick="DeleteData('<?php echo $value['id']; ?>')">Delete</a>
                <a href="profile.php?id=<?php echo $value['id']; ?>" class="badge badge-info">View</a>
            </td>
        </tr>
        <?php
        $i++;
        }
        ?>
    </tbody>
</table>