<?php
session_start();
require("mainconfig.php");
$msg_type = "nothing";

if (isset($_SESSION['user'])) {
	header("Location: ".$cfg_baseurl);
} else {
	if (isset($_POST['daftar'])) {
	    $post_password = mysqli_real_escape_string($db, trim($_POST['password']));
		$post_username = mysqli_real_escape_string($db, trim($_POST['username']));
		if (empty($post_username) || empty($post_password)) {
			$msg_type = "error";
			$msg_content = "<b>Gagal:</b> Mohon mengisi data dengan benar.";
		} else {
			$check_user = mysqli_query($db, "SELECT * FROM users WHERE username = '$post_username'");
			if (mysqli_num_rows($check_user) == 1) {
				$msg_type = "error";
				$msg_content = "<b>Gagal:</b> Akun dengan username ini sudah terdaftar.";
			} else {
			   
				if ($post_username == $post_password) {
					$msg_type = "error";
					$msg_content = "<b>Gagal:</b> Username tidak boleh sama dengan password.";
				} else {
	$hash_method = PASSWORD_BCRYPT;
    $hashed_password = password_hash($post_password, $hash_method);

					$insert = mysqli_query($db, "INSERT INTO users (username, password,created_at) VALUES 
													('$post_username', '$hashed_password','$date')");
					if ($insert == TRUE) {
					    $msg_type = "success";
					    $msg_content = "Register Success!<br />Akun anda sudah didaftarkan silahkan login!<br />";
					    header("Location: login.php ");
					} else {
						header("Location: ".$cfg_baseurl);
					}
				}
			} } }
?>
<!DOCTYPE html>

<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>CashFlow</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="assets/images/favicon.png" />
  </head>
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="row w-100 m-0">
          <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
            <div class="card col-lg-4 mx-auto">
              <div class="card-body px-5 py-5">
                <h3 class="card-title text-left mb-3">Daftar</h3>
                  <form method="post">
                      <?php
                    if ($msg_type == "success") {
?>
<div class="alert alert-success" role="alert" >
  <?php echo $msg_content; ?>
</div>
<?php
} else   if ($msg_type == "error") {
?>
<div class="alert alert-danger" role="alert" >
  <?php echo $msg_content; ?>
</div>
<?php
}
?>

                  <div class="form-group">
                    <label>Username</label>
                    <input type="text" class="form-control p_input" name="username">
                  </div>
                  <div class="form-group">
                    <label>Password</label>
                    <input type="text" class="form-control p_input" name="password">
                  </div>
                  <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-block enter-btn" name="daftar">Daftar</button>
                  </div>
                  <p class="sign-up text-center">Sudah punya akun?<a href="<?php echo $cfg_baseurl; ?>login.php"> Login</a></p>
                </form>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
        </div>
        <!-- row ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/hoverable-collapse.js"></script>
    <script src="assets/js/misc.js"></script>
    <script src="assets/js/settings.js"></script>
    <script src="assets/js/todolist.js"></script>
    <!-- endinject -->
  </body>
</html><?php } ?>