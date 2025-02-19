<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin | File Upload</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/skins.min.css">
    <link type="text/css" href="assets/css/stylesheet.css" rel="stylesheet" media="screen" />
    <script src="assets/js/jquery-2.1.1.min.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="assets/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://www.herbalaxe.com/admin/view/stylesheet/lobibox.min.css" />
    <script src="https://www.herbalaxe.com/admin/view/javascript/lobibox.js"></script>
    <style>
        .loader {
            --c: no-repeat linear-gradient(#374850 0 0);
            background:
                var(--c), var(--c), var(--c),
                var(--c), var(--c), var(--c),
                var(--c), var(--c), var(--c);
            background-size: 16px 16px;
            animation:
                l32-1 1s infinite,
                l32-2 1s infinite;
        }

        @keyframes l32-1 {

            0%,
            100% {
                width: 45px;
                height: 45px
            }

            35%,
            65% {
                width: 65px;
                height: 65px
            }
        }

        @keyframes l32-2 {

            0%,
            40% {
                background-position: 0 0, 0 50%, 0 100%, 50% 100%, 100% 100%, 100% 50%, 100% 0, 50% 0, 50% 50%
            }

            60%,
            100% {
                background-position: 0 50%, 0 100%, 50% 100%, 100% 100%, 100% 50%, 100% 0, 50% 0, 0 0, 50% 50%
            }
        }
    </style>
    <script>
        Lobibox.base.DEFAULTS = $.extend({}, Lobibox.base.DEFAULTS, {
            iconSource: 'fontAwesome'
        });
        Lobibox.notify.DEFAULTS = $.extend({}, Lobibox.notify.DEFAULTS, {
            iconSource: 'fontAwesome'
        });
    </script>
</head>

<body class="skin-blue sidebar-mini fixed" data-spy="scroll" data-target="#scrollspy">
    <!-- Left side column. contains the logo and sidebar -->
    <?php
    include('leftbar.php');
    // Directory where images will be uploaded
    $target_dir = "uploads/";

    // Ensure the uploads directory exists
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // Path to the uploaded file
    $target_file = $target_dir . basename($_FILES["image"]["name"]);

    // Flag to check if the upload is successful
    $uploadOk = 1;

    // Get file extension
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if file is an actual image or fake image
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
             $msg = "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
             $msg = "File is not an image.";
            $uploadOk = 0;
        }
    }

    // Check file size (limit: 5MB)
    if ($_FILES["image"]["size"] > 5000000) {
        $msg = "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats (e.g., jpg, png, jpeg, gif)
    $allowedFormats = array("jpg", "jpeg", "png", "gif");
    if (!in_array($imageFileType, $allowedFormats)) {
        $msg = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $msg = "Sorry, your file was not uploaded.";
        // If everything is ok, try to upload file
    } else {
        $rt= explode(".".$imageFileType,$target_file);
        $target_file = $rt[0].time().".".$imageFileType;
        $status = move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        if ($status) {
             $msg = "The file " . htmlspecialchars(basename($_FILES["image"]["name"])) . " has been uploaded.";
            $sql = "INSERT INTO uploads (url,file_name) values('https://pixelpod.in/admin/".$target_file."','".basename($_FILES["image"]["name"])."')";
            $query = $mysqli->query($sql);
        } else {
             $msg = "Sorry, there was an error uploading your file.";
        }
    }
    ?>
    <!--Content Header (Page header)-->
    <div class="page-header">
    </div>
    <!-- Main content -->
    <div class="content-wrapper">
        <div class="container-fluid" style="background: #ffffff;">
            <form role="form" enctype="multipart/form-data" method="POST" action>
                <div class="form-group" style="display: flex;">
                    <input id="choose-file" class="form-control" type="file" name="image" accept="image/*" style="width: 270px;margin-right:10px;" required>
                    <input class="btn btn-info  form-action" type="submit" value="Upload Image">
                </div>
                <!-- <button type="submit" id="button-assign" name="button-assign" class="btn btn-warning" data-original-title="Click Here to assigned Order">Filter Data</button> -->
            </form>

            <?php
            if ($target_file != "uploads/") {
            ?>
                <div class="block">
                    <label> File : </label> <span> <?=  $msg  ?></span>
                </div>
            <?php 

        } ?>
        
        <div class="row">
            <table class="table table-bordered " style="margin-top: 10px;">
                <thead>
                    <th>#</th>
                    <th>IMG</th>
                    <th>File Name</th>
                    <th>url</th>
                    <th>Date</th>
                </thead>
                <tbody>
                    <?php
                    $sql = "select * FROM  uploads order by id desc";
                    $query = $mysqli->query($sql);
                    $i=1;
                    while($row = $query->fetch_assoc()){
                        ?>
                        <tr>
                            <td><?= $i ?></td>
                            <td><?= $row['file_name'] ?></td>
                            <td><img src="<?= $row['url'] ?>" style="width: 100px;height: 100px;"/></td>
                            <td><a href="<?= $row['url'] ?>" ><?= $row['url'] ?></a ></td>
                            <td><?= $row['created_at'] ?></td>
                        </tr>

                        <?php
                        $i = $i + 1;
                    }
                    ?>
                </tbody>
            </table>
            </div>
        </div>
    </div>

    <?php
    include('footer.php');
    ?>


    <!-- AdminLTE App -->
    <script src="assets/js/main.js"></script>
    <!-- SlimScroll -->
    <script src="assets/js/jquery-slimscroll/jquery.slimscroll.min.js"></script>
</body>

</html>