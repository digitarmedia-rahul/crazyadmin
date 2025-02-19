<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin | Dashboard</title>
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
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="assets/bootstrap-datepicker.min.css">

  <script src="assets/js/datetimepicker/moment.js" type="text/javascript"></script>
  <script src="assets/js/datetimepicker/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
  <link href="assets/css/datetimepicker/bootstrap-datetimepicker.min.css" type="text/css" rel="stylesheet" media="screen" />

</head>

<body class="skin-blue sidebar-mini fixed" data-spy="scroll" data-target="#scrollspy">
  <div class="wrapper">
    <!-- Left side column. contains the logo and sidebar -->
    <?php
    include('leftbar.php');
    ?>
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="page-header">
        <div class="container-fluid">
          <div class="pull-right">

          </div>
        </div>
      </div>
      <!-- Main content -->
      <div class="container-fluid">

        <form role="form" enctype="multipart/form-data" method="GET" action>
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
                  <button type="submit" id="button-assign" name="button-assign" class="btn btn-warning" data-original-title="Click Here to assigned Order">Filter Data</button>
                </td>
                <td>
                  <button type="button" id="button-export" class="btn btn-success btn-sm"><i class="fa fa-download"></i>Sheet</button>
                </td>
              </tr>
            </thead>
          </table>
        </form>

        <div class="row">
          <div class="col-md-6 col-sm-6">
            <div class="panel panel-default">
              <div class="panel-body">

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

  <!-- Include Required Prerequisites -->
  <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
  <!-- Include Date Range Picker -->
  <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
  <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
  <!-- bootstrap datepicker -->
  <script src="assets/bootstrap-datepicker.min.js"></script>
  <style>
  </style>
  <script type="text/javascript">
    //Date picker
    $('#input-date-start').datepicker({
      autoclose: true,
      format: 'yyyy-mm-dd'
    })

    $('#input-date-end').datepicker({
      autoclose: true,
      format: 'yyyy-mm-dd'
    })

    $('#button-export').on('click', function() {
      url = '';

      var filter_date_start = $('input[name=\'filter_date_start\']').val();
      if (filter_date_start) {
        url += '&filter_date_start=' + encodeURIComponent(filter_date_start);
      }

      var filter_date_end = $('input[name=\'filter_date_end\']').val();
      if (filter_date_end) {
        url += '&filter_date_end=' + encodeURIComponent(filter_date_end);
      }

      location = 'export.php?' + url;
    });
  </script>
</body>

</html>