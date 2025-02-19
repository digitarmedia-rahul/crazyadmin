<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Administration</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <script type="text/javascript" src="assets/js/jquery.min.js"></script>
  <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
  <link href="assets/css/bootstrap.css" type="text/css" rel="stylesheet" />
  <link href="assets/font-awesome/css/font-awesome.min.css" type="text/css" rel="stylesheet" />
  <link type="text/css" href="assets/css/stylesheet.css" rel="stylesheet" media="screen" />
</head>

<body>
  <?php
  if (isset($_GET['error'])) {
    $error = $_GET['error'];
    if ($error == 1) {
      echo '<p class="alert alert-danger">Error Logging In!</p>';
    }
    if ($error == 2) {
      echo '<p class="alert alert-danger">Account Locked!</p>';
    }
  }
  ?>
  <div id="container">
    <header id="header" class="navbar navbar-static-top">
      <div class="container-fluid">
        <div id="header-logo" class="navbar-header"><a href="#" class="navbar-brand"></a></div>
        <a href="#" id="button-menu" class="hidden-md hidden-lg"><span class="fa fa-bars"></span></a>
      </div>
    </header>
    <div id="content">
      <div class="container-fluid"><br />
        <br />
        <div class="row">
          <div class="col-sm-offset-4 col-sm-4">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h1 class="panel-title"><i class="fa fa-lock"></i> Please enter your login details.</h1>
              </div>
              <div class="panel-body">
                <form action="includes/admin_login_validate.php" method="post" enctype="multipart/form-data">
                  <div class="form-group">
                    <label for="input-username">Username</label>
                    <div class="input-group"><span class="input-group-addon"><i class="fa fa-user"></i></span>
                      <input type="text" name="username" placeholder="Username" id="input-username" class="form-control" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="input-password">Password</label>
                    <div class="input-group"><span class="input-group-addon"><i class="fa fa-lock"></i></span>
                      <input type="password" name="password" placeholder="Password" id="input-password" class="form-control" />
                    </div>
                  </div>
                  <div class="text-right">
                    <button type="submit" name="submit" class="btn btn-primary"><i class="fa fa-key"></i> Login</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <footer id="footer">
      <a href="https://eduacademy.co.in">eduacademy.co.in</a> &copy; 2009-2021 All Rights Reserved.<br />
    </footer>
  </div>
</body>

</html>