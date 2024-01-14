<?php
require_once 'config/connectdb.php';

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $deletestmt = $conn->query("DELETE FROM users WHERE id = $delete_id");
    $deletestmt->execute();

    if ($deletestmt) {
        echo "<script>alert('Data has been Deleted Successfully');</script>";
        $_SESSION['success'] = "Data has been Deleted Successfully";
        header("refresh:1; url=index.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP (PDO)</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>

    <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add User</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="insert.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="firstname" class="col-form-label">First Name : </label>
                            <input type="text" class="form-control" name="firstname" require>
                        </div>
                        <div class="mb-3">
                            <label for="lastname" class="col-form-label">Last Name : </label>
                            <input type="text" class="form-control" name="lastname" require>
                        </div>
                        <div class="mb-3">
                            <label for="position" class="col-form-label">Position : </label>
                            <input type="text" class="form-control" name="position" require>
                        </div>
                        <div class="mb-3">
                            <label for="Profile" class="col-form-label">Profile : </label>
                            <input type="file" class="form-control" name="profile" id="profileInput" require>
                            <br>
                            <img width="100%" id="previewProfile" alt="">
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success" name="submit">Submit</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>


    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <h1>CRUD Bootstrap5 </h1>
            </div>
            <div class="col-md-6 d-flex justify-content-end">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#userModal"><i class="fa-solid fa-user-plus"></i> Add User</button>
            </div>
        </div>
        <hr>

        <!-- แสดง Alert บันทึกสำเร็จ -->
        <?php if (isset($_SESSION['success'])) { ?>
            <div class="alert alert-success">
                <?php
                // แสดง Alert บันทึกสำเร็จ
                echo $_SESSION['success'];
                // เมื่อ Refresh หน้าจอให้ Alert หายไป 
                unset($_SESSION['success']);
                ?>
            </div>
        <?php } ?>

        <!-- แสดง Alert บันทึกไม่สำเร็จ -->
        <?php if (isset($_SESSION['error'])) { ?>
            <div class="alert alert-danger">
                <?php
                // แสดง Alert บันทึกไม่สำเร็จ
                echo $_SESSION['error'];
                // เมื่อ Refresh หน้าจอให้ Alert หายไป 
                unset($_SESSION['error']);
                ?>
            </div>
        <?php } ?>

        <!-- ========== Start Show Users ========== -->

        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Search User">
            <button class="btn btn-outline-secondary" type="button" id="search">Search</button>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Firstname</th>
                    <th scope="col">Lastname</th>
                    <th scope="col">Position</th>
                    <th scope="col">Profile</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stmt = $conn->query("SELECT * FROM users");
                $stmt->execute();
                $users = $stmt->fetchAll();

                // ถ้าไม่มีข้อมูล Users
                if (!$users) {
                    echo "<tr><td colspan='6' class='text-center'>No Users Found</td></tr>";
                } else {
                    foreach ($users as $user) {


                ?>
                        <tr>
                            <th scope="row"><?php echo $user['id'] ?></th>
                            <td><?php echo $user['firstname'] ?></td>
                            <td><?php echo $user['lastname'] ?></td>
                            <td><?php echo $user['position'] ?></td>
                            <td width="100px"><img width="100%" src="uploads/<?php echo $user['profile'] ?>" class="rounded" alt=""></td>
                            <td>
                                <a class="btn btn-warning" href="update.php?id=<?php echo $user['id']; ?>">Update</a>
                                <a class="btn btn-danger" href="?delete=<?php echo $user['id']; ?>" onclick="return confirm('Are you sure you want to delete?');">Delete</a>
                            </td>
                    <?php }
                }
                    ?>
            </tbody>
        </table>
    </div>
    <!-- ========== End Show Users ========== -->




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <!-- Preview รูปภาพก่อนการ Upload ลง Database -->
    <script>
        let profileInput = document.getElementById('profileInput');
        let previewProfile = document.getElementById('previewProfile');

        profileInput.onchange = evt => {
            const [file] = profileInput.files;
            // ถ้ามีการเพิ่มรูปเข้ามา
            if (file) {
                // ให้แสดงรูปภาพ
                previewProfile.src = URL.createObjectURL(file);
            }
        }
    </script>



</body>

</html>