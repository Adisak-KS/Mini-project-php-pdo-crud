<?php

    require_once 'config/connectdb.php';

    // เมื่อมีการกดปุ่ม Summit 
    if(isset($_POST['submit'])) {
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $position = $_POST['position'];
        $profile = $_FILES['profile'];

        // ชนิดไฟล์ที่อนุญาตให้ upload 
        $allow = array('jpg', 'jpeg', 'png');

        // แยกชื่อไฟล์ ออกจากนามสกุลของไฟล์ด้วย .
        $extension = explode(".", $profile['name']);

        // แปลงนามสกุลของไฟล์ให้เป็นพิมพ์เล็ก
        $fileActExt = strtolower(end($extension));

        // Random ชื่อไฟล์ให้ไม่ซ้ำกัน
        $fileNew = rand() .".". $fileActExt;

        // ให้อัปโหลดไฟล์ ไปที่โฟร์เดอร์ uploads
        $filePath = "uploads/".$fileNew;

        // เช็คว่านามสกุลไฟล์ ตรงกับที่ได้อนุญาตไหม
        if(in_array($fileActExt, $allow)) {

            // เช็คขนาดรูปภาพ
            if($profile['size'] > 0 && $profile['error'] == 0){
                if (move_uploaded_file($profile['tmp_name'], $filePath)) {
                    $sql = $conn->prepare("INSERT INTO users(firstname, lastname, position, profile) VALUE (:firstname, :lastname, :position, :profile)");
                    $sql->bindParam(":firstname", $firstname);
                    $sql->bindParam(":lastname", $lastname);
                    $sql->bindParam(":position", $position);
                    $sql->bindParam(":profile", $fileNew);
                    $sql->execute();

                    // หาก Execute เรียบร้อย ไม่มีข้อผิดพลาด
                    if($sql){
                        $_SESSION["success"] = "Data has been inserted Successfully";
                        header("location: index.php");
                    }else{
                        $_SESSION["error"] = "Data has not been inserted Successfully";
                        header("location: index.php");
                    }
                }else{
                    $_SESSION["error"] = "Data has not been inserted Successfully";
                    header("location: index.php");
                }
            }
        }
    }
?>
