<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP (PDO)</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

</head>

<body>

    <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="userModal">Add User</h1>
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
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#userModal">Add User</button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <!-- Preview รูปภาพก่อนการ Upload ลง Database -->
    <script>
        let profileInput = document.getElementById('profileInput');
        let previewProfile = document.getElementById('previewProfile');

        profileInput.onchange = evt => {
            const [file] = profileInput.files;
            // ถ้ามีการเพิ่มรูปเข้ามา
            if(file){
                // ให้แสดงรูปภาพ
                previewProfile.src = URL.createObjectURL(file);
            }
        }
    </script>



</body>

</html>