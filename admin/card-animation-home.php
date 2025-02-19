<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Card | Home</title>
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
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="assets/bootstrap-datepicker.min.css">
    <!-- Bootstrap 3.3.7 -->
    <script src="assets/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://www.herbalaxe.com/admin/view/stylesheet/lobibox.min.css" />
    <script src="https://www.herbalaxe.com/admin/view/javascript/lobibox.js"></script>
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
    <div class="wrapper">
        <!-- Left side column. contains the logo and sidebar -->
        <?php
        include('leftbar.php');
        if (isset($_POST['addNew'])) {
            $filePath = '';
            if ($_FILES['newicon']['name']) {
                $targetDir = "uploads/companyIcons/";
                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0777, true); // Create the directory with full permissions
                }
                $fileExtension = strtolower(pathinfo($_FILES["newicon"]["name"], PATHINFO_EXTENSION));
                $newFileName = "com_" . time() . "." . $fileExtension;
                $targetFile = $targetDir . $newFileName;
                $uploadOk = 1;


                if ($fileExtension != "jpg" && $fileExtension != "jpeg" && $fileExtension != "png") {
                    echo  json_encode(['error' => true, 'msg' => 'Only jpg,jpeg,png allow!']);
                    exit;
                    $uploadOk = 0;
                }

                if ($uploadOk) {
                    if (move_uploaded_file($_FILES["newicon"]["tmp_name"], $targetFile)) {
                        $filePath = "http://localhost/crazzyoffer.in/admin/" . $targetFile;
                    }
                }
            }
            $q = 'INSERT INTO card_animation_home (card_name, image_url, tracking_url, description) VALUES ("' . trim($_POST['name']) . '", "' . $filePath . '", "' . trim($_POST['redirect']) . '", "' . trim($_POST['desc']) . '")';
            $mysqli->query($q);
            $mysqli->close();
            header('Location: ../admin/card-animation-home.php');
        } else if (isset($_GET['add']) && $_GET['add']) {
        ?>
            <div class="content-wrapper">
                <!-- Main content -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped dataTable" id="userListDetails">
                                            <tbody>
                                                <tr>
                                                    <th colspan="3" class="text-center">Fill the Card Details</th>
                                                </tr>
                                                <form action="" method="post" enctype="multipart/form-data">
                                                    <tr>
                                                        <th style="width: 200px !important" class="text-center">Card Name</th>
                                                        <td style="width: 300px !important" class="text-center"><input class="form-control" type="text" name="name" id="" placeholder="enter name" required></td>
                                                    </tr>
                                                    <tr>
                                                        <th style="width: 200px !important" class="text-center">Image URL</th>
                                                        <td class="text-center"> <input class="form-control" style="width: 300px !important" type="file" name="newicon" id="newicon" required /> </td>
                                                    </tr>
                                                    <tr>
                                                        <th style="width: 200px !important" class="text-center">Redirect Link</th>
                                                        <td class="text-center"><input class="form-control" style="width: 300px !important" type="text" name="redirect" id="" required /></td>
                                                    </tr>
                                                    <tr>
                                                        <th style="width: 200px !important" class="text-center">Desc</th>
                                                        <td class="text-center"><textarea class="form-control" name="desc" id="" cols="25" rows="2"></textarea></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" class="text-center"><button type="submit" name="addNew" class="btn btn-primary">Save</button></td>
                                                    </tr>
                                                </form>
                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.content -->
            </div>
        <?php
        } else if (isset($_POST['changeSave'])) {
            $filePath = '';
            if ($_FILES['newicon']['name']) {
                $targetDir = "uploads/companyIcons/";
                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0777, true); // Create the directory with full permissions
                }
                $fileExtension = strtolower(pathinfo($_FILES["newicon"]["name"], PATHINFO_EXTENSION));
                $newFileName = "com_" . time() . "." . $fileExtension;
                $targetFile = $targetDir . $newFileName;
                $uploadOk = 1;


                if ($fileExtension != "jpg" && $fileExtension != "jpeg" && $fileExtension != "png") {
                    echo  json_encode(['error' => true, 'msg' => 'Only jpg,jpeg,png allow!']);
                    exit;
                    $uploadOk = 0;
                }

                if ($uploadOk) {
                    if (move_uploaded_file($_FILES["newicon"]["tmp_name"], $targetFile)) {
                        $filePath = "http://localhost/crazzyoffer.in/admin/" . $targetFile;
                    }
                }
            }
            $carouselId = $_POST['carouselId'];
            $is_avail = $mysqli->query("SELECT * FROM `card_animation_home` WHERE id ='$carouselId'");

            if ($is_avail->num_rows > 0) {
                if ($filePath != '') {
                    $q = 'update card_animation_home set image_url	 = "' . $filePath . '" where id = "' . $carouselId . '" ';
                    $mysqli->query($q);
                } else {
                    if (isset($_POST['name']) && trim($_POST['name']) != '') {
                        $q = 'update card_animation_home set card_name = "' . trim($_POST['name']) . '" where id = "' . $carouselId . '" ';
                        $mysqli->query($q);
                    }
                    if (isset($_POST['desc']) && trim($_POST['desc']) != '') {
                        $q = 'update card_animation_home set description = "' . trim($_POST['desc']) . '" where id = "' . $carouselId . '" ';
                        $mysqli->query($q);
                    }
                    if (isset($_POST['redirect']) && trim($_POST['redirect']) != '') {
                        $q = 'update card_animation_home set tracking_url = "' . trim($_POST['redirect']) . '" where id = "' . $carouselId . '" ';
                        $mysqli->query($q);
                    }
                    if(isset($_POST['status']) && trim($_POST['status']) !=''){
                        $q = 'update card_animation_home set status = "'.trim($_POST['status']).'" where id = "'.$carouselId.'" ';
                        $mysqli->query($q);
                    }
                }
            }
            $mysqli->close();
            header('Location: ../admin/card-animation-home.php');
            exit;
        } else if (isset($_GET['change']) && $_GET['change']) {
            $deviceid = $mysqli->query("SELECT * FROM `card_animation_home` WHERE status =1 AND id =" . trim($_GET['com']));
            $cardData = $deviceid->fetch_assoc();

        ?>
            <div class="content-wrapper">
                <!-- Main content -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped dataTable" id="userListDetails">
                                            <tbody>
                                                <tr>
                                                    <th colspan="3" class="text-center">Card Details</th>
                                                </tr>
                                                <form action="" method="post" enctype="multipart/form-data">
                                                    <input type="hidden" name="carouselId" value="<?= $_GET['com'] ?>">
                                                    <tr>
                                                        <th style="width: 200px !important" class="text-center">Card Name</th>
                                                        <td class="text-center"><?= $cardData['card_name'] ?></td>
                                                        <td style="width: 300px !important" class="text-center"><input class="form-control" type="text" name="name" id="" placeholder="enter new name"></td>
                                                    </tr>
                                                    <tr>
                                                        <th style="width: 200px !important" class="text-center">Redirect Link</th>
                                                        <td class="text-center"><?= $cardData['tracking_url'] ?></td>
                                                        <td style="width: 300px !important" class="text-center"><input class="form-control" type="text" name="redirect" id="" placeholder="https://Google.com"></td>
                                                    </tr>
                                                    <tr>
                                                        <th style="width: 200px !important" class="text-center">Image</th>
                                                        <td class="text-center"> <?php
                                                                                    if ($cardData['image_url']) {
                                                                                    ?>
                                                                <img src="<?= $cardData['image_url'] ?>" width="
                                                        50" height="50">
                                                            <?php
                                                                                    }
                                                            ?>
                                                        </td>
                                                        <td class="text-center"> <input class="form-control" style="width: 300px !important" type="file" name="newicon" id="newicon" /> </td>
                                                    </tr>
                                                    <tr>
                                                        <th style="width: 200px !important" class="text-center">Status</th>
                                                        <td class="text-center"><?= ($cardData['status']=='1' ? 'Active' : 'Deactive') ?></td>
                                                        <td style="width: 300px !important" class="text-center">
                                                            <select name="status" class="form-control" id="">
                                                                <option value="1" <?= ($cardData['status']=='1' ? 'selected':'') ?>>Active</option>
                                                                <option value="0" <?= ($cardData['status']=='0' ? 'selected':'') ?>>Deactive</option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th style="width: 200px !important" class="text-center">Desc</th>
                                                        <td class="text-center"><?= ($cardData['description'] ? $cardData['description'] : 'NA') ?></td>
                                                        <td class="text-center"><textarea class="form-control" name="desc" id="" cols="25" rows="2"></textarea></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" class="text-center"><button type="submit" name="changeSave" class="btn btn-primary">Save</button></td>
                                                    </tr>
                                                </form>
                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.content -->
            </div>
        <?php
        } else if (!isset($_GET['change']) && !isset($_GET['add'])) {
            if (isset($_GET['filter_date_start'])) {
                $fromDate = $_GET['filter_date_start'];
            } else {
                $fromDate = date('Y-m-d', strtotime('-90 days'));
            }

            if (isset($_GET['filter_date_end'])) {
                $toDate = $_GET['filter_date_end'];
            } else {
                $toDate = date('Y-m-d');
            }
            $sqlq = " DATE(created_at) BETWEEN DATE('" . $fromDate . "') AND DATE('" . $toDate . "')  ";

            $cardData = array();


            $deviceid = $mysqli->query("SELECT * FROM `card_animation_home` WHERE $sqlq ORDER BY id DESC");
            while ($deviceids = $deviceid->fetch_assoc()) {
                $cardData[] =  $deviceids;
            }

        ?>
            <div class="content-wrapper">
                <!--Content Header (Page header)-->
                <div class="page-header">
                    <!-- <div class="container-fluid">
                    <h1>Device-ID List</h1>
                </div> -->
                </div>
                <!-- Main content -->
                <div class="container-fluid">
                    <form role="form" enctype="multipart/form-data" method="GET" action="">
                        <table class="table table-bordered table-hover" style="background-color:#fff">
                            <thead>
                                <tr>
                                    <td>
                                        <div class="input-group date">
                                            <input type="text" name="filter_date_start" placeholder="YYYY-MM-DD" id="input-date-start" value="<?php if (isset($fromDate)) {
                                                                                                                                                    echo $fromDate;
                                                                                                                                                } ?>" class="form-control">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group date">
                                            <input type="text" name="filter_date_end" value="<?php if (isset($toDate)) {
                                                                                                    echo $toDate;
                                                                                                } ?>" placeholder="YYYY-MM-DD" id="input-date-end" class="form-control">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                                            </span>
                                        </div>
                                    </td>


                                    <td>
                                        <button type="submit" id="button-assign" name="button-assign" class="btn btn-sm btn-warning" data-original-title="Click Here to assigned Order">Filter Data</button>
                                    </td>
                                    <td>
                                        <a href="http://localhost/crazzyoffer.in/admin/card-animation-home.php?add=true" rel="noopener noreferrer"><button type="button" id="button-export" class="btn btn-success btn-sm"></i>ADD CARD</button></a>
                                    </td>
                                </tr>
                            </thead>
                        </table>
                    </form>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="panel panel-default">
                                <!-- <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-list"></i> Device-ID Reports</h3>
                            </div> -->
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped dataTable" id="userListDetails">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Sr No</th>
                                                    <th class="text-center">Card</th>
                                                    <th class="text-center">Image</th>
                                                    <th class="text-center">Status</th>
                                                    <th class="text-center">Redirect</th>
                                                    <th class="text-center">Description</th>
                                                    <th class="text-center">Created Date</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($cardData as $k => $data) {
                                                ?>
                                                    <tr>
                                                        <td class="text-center"><?= ($k + 1) ?></td>
                                                        <td class="text-center"><?= $data['card_name'] ?></td>
                                                        <td class="text-center"><?php
                                                                                if ($data['image_url']) {
                                                                                ?>
                                                                <img src="<?= $data['image_url'] ?>" width="
                                                        50" height="50">
                                                            <?php
                                                                                }
                                                            ?>
                                                        </td>
                                                        <td class="text-center">
                                                            <?php
                                                            if ($data['status']) {
                                                                echo '<span class="text-success">Active</span>';
                                                            } else {
                                                                echo '<span class="text-danger">Inactive</span>';
                                                            }
                                                            ?>
                                                        </td>
                                                        <td class="text-center">
                                                            <?php
                                                            if ($data['tracking_url']) {
                                                                echo '<a href="' . $data['tracking_url'] . '">Redirect Page</a>';
                                                            }
                                                            ?>
                                                        </td>
                                                        <td class="text-center"><?= ($data['description'] ? $data['description']  : 'NA') ?></td>
                                                        <td class="text-center"><?= $data['created_at'] ?></td>
                                                        <td class="text-center"><a class="btn btn-sm btn-info" href="http://localhost/crazzyoffer.in/admin/card-animation-home.php?change=true&com=<?= $data['id'] ?>">Change</a></td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.content -->
            </div>
        <?php
        }
        include('footer.php');
        ?>
    </div>
    <!-- AdminLTE App -->
    <script src="assets/js/main.js"></script>
    <!-- SlimScroll -->
    <script src="assets/js/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <!-- bootstrap datepicker -->
    <script src="assets/bootstrap-datepicker.min.js"></script>

    <style>
    </style>
    <script type="text/javascript">
    </script>
</body>

</html>