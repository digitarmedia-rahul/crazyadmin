<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Best of Brands | Home</title>
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

        if (isset($_POST['addNew']) && $_POST['addNew'] == 'Save') {
            if ($_FILES['imageURL']['name']) {
                $targetDir = "uploads/bob/";

                // Ensure the upload directory exists
                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }

                // Initialize the array
                $insertedIds = array();
                foreach ($_FILES['imageURL']['name'] as $key => $originalName) {
                    $carouselLink = ''; 
                    $fileExtension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
                    $newFileName = "BOB_" . time() . rand(10000, 99999) . "." . $fileExtension;
                    $targetFile = $targetDir . $newFileName;

                    // Validate file type
                    if (!in_array($fileExtension, ['jpg', 'jpeg', 'png'])) {
                        echo json_encode(['error' => true, 'msg' => 'Only JPG, JPEG, PNG files are allowed!']);
                        exit;
                    }

                    // Upload the file if valid
                    if (move_uploaded_file($_FILES["imageURL"]["tmp_name"][$key], $targetFile)) {
                        $carouselLink= "http://148.135.136.15/crazyadmin/admin/" . $targetFile;
                        $redirectLink= $_POST['redirectLink'][$key];
                    }
                    $q = "INSERT INTO best_of_brands_img (brand_id, heading, card_img, redirect, created_by, created_at) VALUES ('" . trim($_POST['brand']) . "', '" . trim($_POST['heading']) . "', '" . $carouselLink . "', '" . $redirectLink . "', '" . $_SESSION['ADMINUSERID'] . "', '" . date('Y-m-d H:i:s') . "')";
                    $mysqli->query($q);
                    $insertedIds [] = $mysqli->insert_id;
                    unset($redirectLink, $carouselLink);
                }
            }
            $q = "INSERT INTO best_of_brands (brand_id, heading, card_details, created_by, created_at) VALUES ('" . trim($_POST['brand']) . "', '" . trim($_POST['heading']) . "', '" . json_encode($insertedIds) . "', '" . $_SESSION['ADMINUSERID'] . "', '" . date('Y-m-d H:i:s') . "')";
            $mysqli->query($q);
            $mysqli->close();
            header('Location: ../admin/carzy-brands.php');
        } else if (isset($_GET['add']) && $_GET['add']) {
        ?>
            <div class="content-wrapper">
                <!-- Main content -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="card">
                                        <h3 class="text-center mb-4">Fill the Best of Brand</h3>
                                        <form id="brandForm" action="" method="POST" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label for="brandSelect">Select a Brand</label>
                                                <select name="brand" id="" class="form-control" required>
                                                    <option value="" selected>Select a Brand</option>
                                                    <?php
                                                    $dbData = $mysqli->query("SELECT id, brand_name FROM `top_brand_list` ORDER BY brand_name ASC");
                                                    while ($brandListData = $dbData->fetch_assoc()) {
                                                        echo '<option value="' . $brandListData['id'] . '">' . $brandListData['brand_name'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-row row align-items-center mb-5" style="margin-top: 3px; margin-bottom: 3px;">
                                                <div class="col-md-12">
                                                    <input type="text" name="heading" class="form-control" placeholder="Enter Heading" id="" />
                                                </div>
                                            </div>
                                            <div class="form-row row align-items-center mb-5" style="margin-top: 3px; margin-bottom: 3px;">
                                                <div class="col-md-4">
                                                    <label for="">Crazy Logo</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="">Redirect URL</label>
                                                </div>
                                                <div class="col-md-2 text-right">
                                                </div>
                                            </div>
                                            <div id="dynamicFields">
                                                <div class="form-row row align-items-center mb-5" style="margin-top: 3px; margin-bottom: 3px;">
                                                    <div class="col-md-4">
                                                        <input type="file" accept=".jpg, .jpeg, .png" class="form-control" name="imageURL[]" required>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input type="text" class="form-control" name="redirectLink[]" placeholder="Redirect Link" required>
                                                    </div>
                                                    <div class="col-md-2 text-right">
                                                        <button type="button" class="btn btn-success addRow">+</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 text-center">
                                                <input type="submit" name="addNew" class="btn btn-primary btn-block" value="Save">
                                            </div>
                                        </form>
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

            $brandData = array();


            $deviceid = $mysqli->query("SELECT bob.*,tpl.brand_name FROM `best_of_brands`  bob join top_brand_list tpl on tpl.id=bob.brand_id ORDER BY bob.id DESC");
            while ($deviceids = $deviceid->fetch_assoc()) {
                $brandData[] =  $deviceids;
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
                                        <a href="http://148.135.136.15/crazyadmin/admin/carzy-brands.php?add=true" rel="noopener noreferrer"><button type="button" id="button-export" class="btn btn-success btn-sm"></i>ADD BOB</button></a>
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
                                                    <th class="text-center">Brand</th>
                                                    <th class="text-center">Heading</th>
                                                    <th class="text-center">Status</th>
                                                    <th class="text-center">Created Date</th>
                                                    <th class="text-center">Action on Card Details</th>
                                                    <!-- <th class="text-center">Action</th> -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($brandData as $k => $data) {
                                                ?>
                                                    <tr>
                                                        <td class="text-center"><?= ($k + 1) ?></td>
                                                        <td class="text-center"><?= $data['brand_name'] ?></td>
                                                        <td class="text-center"><?= $data['heading'] ?></td>
                                                        <td class="text-center">
                                                            <?php
                                                            if ($data['status']) {
                                                                echo '<span class="text-success">Active</span>';
                                                            } else {
                                                                echo '<span class="text-danger">Inactive</span>';
                                                            }
                                                            ?>
                                                        </td>
                                                        <td class="text-center"><?= $data['created_at'] ?></td>
                                                        <td class="text-center">
                                                            <a class="btn btn-sm btn-info"  href="manage-bob.php?bob_id=<?= base64_encode($data['id']) ?>" rel="noopener noreferrer"><i class="fa fa-eye"></i></a>
                                                        </td>

                                                        <!-- <td class="text-center"><a class="btn btn-sm btn-warning" href="http://148.135.136.15/crazyadmin/admin/carzy-brands.php?change=true&com=<?= $data['id'] ?>">Change</a></td> -->
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
    <!-- Button to trigger modal -->

    <!-- Bootstrap Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-12">
                        <table class=" table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Redirect Link</th>
                                </tr>
                            </thead>
                            <tbody id="card_details"></tbody>
                        </table>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
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
        $(document).ready(function() {
            // Add a new row
            $('#dynamicFields').on('click', '.addRow', function() {
                let newRow = `
                <div class="form-row row align-items-center mb-5" style="margin-top: 3px; margin-bottom: 3px;">
                    <div class="col-md-4">
                        <input type="file" accept=".jpg, .jpeg, .png" class="form-control" name="imageURL[]" required>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="redirectLink[]" placeholder="Redirect Link" required>
                    </div>
                    <div class="col-md-2 text-right">
                        <button type="button" class="btn btn-danger removeRow">-</button>
                    </div>
                </div>`;
                $('#dynamicFields').append(newRow);
            });

            // Remove a row
            $('#dynamicFields').on('click', '.removeRow', function() {
                $(this).closest('.form-row').remove();
            });

            // Handle form submission
            // $('#brandForm').on('submit', function (e) {
            //     e.preventDefault();
            //     alert('Form submitted!');
            // });
        });

        function showdetails(datas, tt) {
            let dataArray = JSON.parse(atob(datas));
            $("#modalTitle").text(atob(tt));
            $.each(dataArray, function(index, item) {
                let imageURL = item[0]; // First value (Image URL)
                let redirectLink = item[1]; // Second value (Redirect Link)


                // Append to the output div
                $("#card_details").html(`
                    <tr>
                        <td>
                            <img src="${imageURL}" alt="Uploaded Image" width="100">
                        </td>
                        <td>
                            <a href="${redirectLink}" target="_blank">${redirectLink}</a>
                        </td>
                    </tr>
                `);
            });
            $("#myModal").modal("show");
        }
    </script>
</body>

</html>