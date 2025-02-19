<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Manage | BOB</title>
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
        if (!isset($_GET['bob_id']) || $_GET['bob_id'] == '') {
            header('Location: ../admin/carzy-brands.php');
            exit;
        }
        $bob_id = base64_decode($_GET['bob_id']);
        // Prepare an SQL statement
        // Prepare the SQL statement
        include('leftbar.php');
        $stmt = $mysqli->prepare("SELECT bob.*,tbl.brand_name FROM best_of_brands bob join top_brand_list tbl on tbl.id=bob.brand_id WHERE bob.id = ?");

        if ($stmt) {
            // Bind parameters (s = string)
            $stmt->bind_param("s", $bob_id);
            $bob_id = trim(base64_decode($_GET['bob_id']));
            // Execute the query
            $stmt->execute();

            // Get the result
            $result = $stmt->get_result();

            // Close the statement
            $stmt->close();
        } else {
            echo "Error in preparing statement: " . $mysqli->error;
        }

        $bobDetails = $result->fetch_assoc();
        $cardDetails = array();
        if (!empty($bobDetails)) {
            $ids = json_decode($bobDetails['card_details'], true); // Ensure it's an array

            if (is_array($ids) && count($ids) > 0) {
                // Create placeholders (?, ?, ?, ...) based on the array length
                $placeholders = implode(',', array_fill(0, count($ids), '?'));

                // Prepare the SQL statement
                $stmt = $mysqli->prepare("SELECT * FROM best_of_brands_img WHERE id IN ($placeholders)");

                if ($stmt) {
                    // Generate types dynamically (all `i` for integer, `s` for string if needed)
                    $types = str_repeat('i', count($ids)); // Assuming IDs are integers

                    // Bind parameters dynamically
                    $stmt->bind_param($types, ...$ids);

                    // Execute the query
                    $stmt->execute();

                    // Get the result
                    $result = $stmt->get_result();

                    while ($row = $result->fetch_assoc()) {
                        $cardDetails[] = $row; // Process fetched data
                    }

                    // Close the statement
                    $stmt->close();
                } else {
                    echo "Error in preparing statement: " . $mysqli->error;
                }
            } else {
                echo "Invalid or empty ID list.";
            }
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
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"> Heading : <b><i><?= $bobDetails['heading']; ?></b></i> &nbsp; &nbsp; &nbsp; &nbsp; Brand : <b><i><?php echo $bobDetails['brand_name']; ?> </b></i> <i class="btn btn-sm btn-success fa fa-plus"></i></h3>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped dataTable" id="userListDetails">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th class="text-center">Image</th>
                                                <th class="text-center">Redirect</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Created Date</th>
                                                <th class="text-center text-danger">Change</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($cardDetails as $k => $data) {
                                            ?>
                                                <tr>
                                                    <td class="text-center"><?= ($k + 1) ?></td>
                                                    <td class="text-center"><?php
                                                                            if ($data['card_img']) {
                                                                            ?>
                                                            <img src="<?= $data['card_img'] ?>" width="
                                                        50" height="50">
                                                        <?php
                                                                            }
                                                        ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php
                                                        if ($data['redirect']) {
                                                            echo '<textarea col="3" row="3">' . $data['redirect'] . '</textarea>';
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
                                                    <td class="text-center"><?= $data['created_at'] ?></td>
                                                    <td>
                                                        <div class="form-row row align-items-center mb-5" style="margin-top: 3px; margin-bottom: 3px;">
                                                            <div class="col-auto">
                                                                <form action="" id="form-<?= $data['id'] ?>" method="post" enctype="multipart/form-data" action="">
                                                                    <input type="hidden" name="id" value="<?= $data['id'] ?>" />
                                                                    <div class="col-md-5">
                                                                        <input type="file" accept=".jpg, .jpeg, .png" class="form-control" name="imageURL" required>
                                                                    </div>
                                                                    <div class="col-md-5">
                                                                        <input type="text" class="form-control" pattern="https?://.*" name="redirectLink" placeholder="https://xyz.com" required>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <input type="button" onclick="saveImage('form-<?= $data['id'] ?>')" class="btn btn-sm btn-success" name="" value="Save" required>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </td>
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
        $(document).ready(function() {
            $(document).on("blur", "input[name='redirectLink']", function() {
                let url = $(this).val();
                let regex = /^(https?:\/\/)?([a-zA-Z0-9-]+\.)+[a-zA-Z]{2,}(:\d+)?(\/.*)?$/;

                if (!regex.test(url)) {
                    $(this).css("border", "2px solid red");
                    Lobibox.notify('error', {
                        size: 'mini',
                        delayIndicator: false,
                        position: 'top right',
                        msg: 'Please fill URL with a valid format',
                    });
                } else {
                    $(this).css("border", "");
                }
            });
        });

        function saveImage(formId) {
            let form = $("#" + formId)[0]; // Get form by ID
            let formData = new FormData(form); // Create FormData object
            formData.append("target", "replaceIMGbrand"); // Add current timestamp
            formData.append("location", "manage-bob.php");

            $.ajax({
                url: "ajax_response.php", // PHP file to handle the upload
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $("#" + formId + " input[type='button']").val("Saving...").prop("disabled", true);
                },
                success: function(response) {
                    let res = JSON.parse(response);

                    if (res.error) {
                        Lobibox.notify('error', {
                        size: 'mini',
                        delayIndicator: false,
                        position: 'top right',
                        msg: "❌ Error: " + res.msg
                    });
                    } else {
                            Lobibox.notify('success', {
                            size: 'mini',
                            delayIndicator: false,
                            position: 'top right',
                            msg: "✅ Successfully uploaded!"
                        });
                    }

                    $("#" + formId + " input[type='button']").val("Save").prop("disabled", false);
                },
                error: function() {
                    alert("❌ Failed to save. Try again.");
                    $("#" + formId + " input[type='button']").val("Save").prop("disabled", false);
                }
            });
        }
    </script>
</body>

</html>