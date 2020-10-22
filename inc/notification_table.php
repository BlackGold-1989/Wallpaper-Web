<?php
include_once 'database.php'; 
$database = new Connection();
$db = $database->openConnection();
?>
<table class="table table-striped table-bordered zero-configuration" id="table-category">
    <thead>
        <tr>
            <th>#</th>
            <th>Title</th>
            <th>Message</th>
            <th>Created At</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sth = $db->prepare("SELECT id,title,message,created_at FROM status_notification");
        $sth->execute();
        $result = $sth->fetchAll();
        $i = 1;
        foreach ($result as $key => $value) {
        ?>
        <tr id="dataid<?php echo $value['id']; ?>">
            <td><?php echo $i; ?></td>
            <td><?php echo $value['title']; ?></td>
            <td><?php echo $value['message']; ?></td>
            <td><?php echo $value['created_at']; ?></td>
            <td>
                <a href="javascript:void(0)" class="badge badge-danger" onclick="Resend('<?php echo $value['id']; ?>')">Resend</a>
            </td>
        </tr>
        <?php
        $i++;
        }
        ?>
    </tbody>
</table>