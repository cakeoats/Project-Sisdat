<?php
session_start();
require("../../mainconfig.php");
$msg_type = "nothing";

if (isset($_SESSION['user'])) {
	$sess_username = $_SESSION['user']['username'];
	$check_user = mysqli_query($db, "SELECT * FROM users WHERE username = '$sess_username'");
	$data_user = mysqli_fetch_assoc($check_user);
	if (mysqli_num_rows($check_user) == 0) {
		header("Location: ".$cfg_baseurl."logout.php");
	} else {
		if (isset($_GET['id'])) {
			$post_id = $_GET['id'];
			$checkdb_tipe = mysqli_query($db, "SELECT * FROM wallets WHERE id = '$post_id'");
			$datadb_tipe = mysqli_fetch_assoc($checkdb_tipe);
			if (mysqli_num_rows($checkdb_tipe) == 0) {
				header("Location: ".$cfg_baseurl."user/dompet.php");
			} else {
				include("../../lib/header.php");
?>
								<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<div class="card-title">Delete Dompet</div>
								</div>
								<div class="card-body">
									<div class="row">
							         <div class="col-md-12">
								
										<form class="form-horizontal" role="form" method="POST" action="<?php echo $cfg_baseurl; ?>user/dompet.php">
											<input type="hidden" name="id" value="<?php echo $datadb_tipe['id']; ?>">
											<div class="form-group">
												<label class="col-md-2 control-label">Nama Dompet</label>
												<div class="col-md-12">
														<input type="text" name="nama" class="form-control" placeholder="<?php echo $datadb_tipe['name']; ?>" readonly>
												</div>
											</div>
											<a href="<?php echo $cfg_baseurl; ?>user/dompet.php" class="btn btn-info btn-bordered waves-effect w-md waves-light">Kembali ke daftar</a>
											<button type="submit" class="pull-right btn btn-success btn-bordered waves-effect w-md waves-light" name="delete">Hapus</button>
										</form>
									</div>
								</div>
							</div>
						</div>
						<!-- end row -->
<?php
				include("../../lib/footer.php");
			}
		} else {
			header("Location: ".$cfg_baseurl."user/dompet.php");
		}
	}
} else {
	header("Location: ".$cfg_baseurl);
}
?>