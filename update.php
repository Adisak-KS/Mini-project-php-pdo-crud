<?php
require_once 'config/connectdb.php';

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $position = $_POST['position'];
    $profile = $_FILES['profile'];

    $profile2 = $_POST['profile2'];
    $upload = $_FILES['profile']['name'];

    if ($upload != '') {
        // ชนิดไฟล์ที่อนุญาตให้ upload 
        $allow = array('jpg', 'jpeg', 'png');

        // แยกชื่อไฟล์ ออกจากนามสกุลของไฟล์ด้วย .
        $extension = explode(".", $profile['name']);

        // แปลงนามสกุลของไฟล์ให้เป็นพิมพ์เล็ก
        $fileActExt = strtolower(end($extension));

        // Random ชื่อไฟล์ให้ไม่ซ้ำกัน
        $fileNew = rand() . "." . $fileActExt;

        // ให้อัปโหลดไฟล์ ไปที่โฟร์เดอร์ uploads
        $filePath = "uploads/" . $fileNew;

        if (in_array($fileActExt, $allow)) {
            // เช็คขนาดรูปภาพ
            if ($profile['size'] > 0 && $profile['error'] == 0) {
                move_uploaded_file($profile['tmp_name'], $filePath);
            }
        }
    } else {
        $fileNew = $profile2;
    }

    $sql = $conn->prepare("UPDATE users SET firstname = :firstname, lastname = :lastname, position = :position, profile = :profile WHERE id = :id");
    $sql->bindParam(":id", $id);
    $sql->bindParam(":firstname", $firstname);
    $sql->bindParam(":lastname", $lastname);
    $sql->bindParam(":position", $position);
    $sql->bindParam(":profile", $fileNew);
    $sql->execute();


     // หาก Execute เรียบร้อย ไม่มีข้อผิดพลาด
     if($sql){
        $_SESSION["success"] = "Data has been Updated Succesfully";
        header("location: index.php");
    }else{
        $_SESSION["error"] = "Data has not been Updated Succesfully";
        header("location: index.php");
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
    <style>
        .container {
            max-width: 550px;
        }
    </style>
</head>

<body>


    <div class="container mt-5">
        <h1>Update Data</h1>
        <hr>
        <form action="update.php" method="POST" enctype="multipart/form-data">
            <?php
            // อ้างอิง id ที่จะดึงข้อมูลมา 
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $stmt = $conn->query("SELECT * FROM users WHERE id = $id");
                $stmt->execute();
                $data = $stmt->fetch();
            }
            ?>

            <input type="text" readonly class="form-control-plaintext" name="id" value="<?php echo $data['id']; ?>" require>
            <div class="mb-3">
                <label for="firstname" class="col-form-label">First Name : </label>
                <input type="text" class="form-control" name="firstname" value="<?php echo $data['firstname']; ?>" require>

                <input type="hidden" class="form-control" name="profile2" value="<?php echo $data['profile']; ?>" require>
            </div>
            <div class="mb-3">
                <label for="lastname" class="col-form-label">Last Name : </label>
                <input type="text" class="form-control" name="lastname" value="<?php echo $data['lastname']; ?>" require>
            </div>
            <div class="mb-3">
                <label for="position" class="col-form-label">Position : </label>
                <input type="text" class="form-control" name="position" value="<?php echo $data['position']; ?>" require>
            </div>
            <div class="mb-3">
                <label for="Profile" class="col-form-label">Profile : </label>
                <input type="file" class="form-control" name="profile" id="profileInput">
                <br>
                <img width="100%" src="uploads/<?php echo $data['profile']; ?>" id="previewProfile" alt="">
            </div>

            <div class="modal-footer">
                <a type="button" class="btn btn-secondary me-1" href="index.php">Go Back</a>
                <button type="submit" class="btn btn-success" name="update">Update</button>
            </div>
        </form>




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