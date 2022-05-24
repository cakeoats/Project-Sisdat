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
			$checkdb_tipe = mysqli_query($db, "SELECT * FROM categories WHERE id = '$post_id'");
			$datadb_tipe = mysqli_fetch_assoc($checkdb_tipe);
			if (mysqli_num_rows($checkdb_tipe) == 0) {
				header("Location: ".$cfg_baseurl."user/kategori.php");
			} else {
				if (isset($_POST['edit'])) {
					$post_nama= $_POST['nama'];

			$post_tipe = $_POST['tipe'];
			
			if (empty($post_nama) || empty($post_tipe) ) {
						$msg_type = "error";
						$msg_content = "<b>Gagal:</b> Mohon mengisi semua input $post_nama.";
					} else {
						$update_tipe = mysqli_query($db, "UPDATE categories SET name = '$post_nama' , type = '$post_tipe' WHERE id = '$post_id'");
						if ($update_tipe == TRUE) {
							$msg_type = "success";
							$msg_content = "<b>Berhasil:</b> Kategori berhasil diubah.";
						} else {
							$msg_type = "error";
							$msg_content = "<b>Gagal:</b> Error system.";
						}
					}
				}
				$checkdb_tipe = mysqli_query($db, "SELECT * FROM categories WHERE id = '$post_id'");
				$datadb_tipe = mysqli_fetch_assoc($checkdb_tipe);
				include("../../lib/header.php");
?>
						<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<div class="card-title">Edit News</div>
								</div>
								<div class="card-body">
									<div class="row">
							         <div class="col-md-12">
									 <?php 
										if ($msg_type == "success") {
										?>
									
										<div class="alert alert-success alert-dismissible fade show" role="alert" >
  <?php echo $msg_content; ?>
</div>
										<?php
										} else if ($msg_type == "error") {
										?>
									
										<div class="alert alert-danger alert-dismissible fade show" role="alert" >
  <?php echo $msg_content; ?>
</div>
										<?php
										} ?>
										<form class="form-horizontal" role="form" method="POST">
										<div class="form-group">
												<label class="col-md-2 control-label">Nama</label>
												<div class="col-md-12">
													<input type="text" name="nama" class="form-control" placeholder="Nama" value="<?php echo $datadb_tipe['name']; ?>">
												</div>
											</div>
												<div class="form-group">
												<label class="col-md-2 control-label">Tipe</label>
												<div class="col-md-12">
													<select class="form-control" name="tipe">
														<option value="<?php echo $datadb_tipe['type']; ?>"><?php echo $datadb_tipe['type']; ?> (Selected)</option>
														<option value="debit">Debit (Pemasukan)</option>
														<option value="kredit">Kredit (Pengeluaran)</option>
													</select>
												</div>
											</div>
											<a href="<?php echo $cfg_baseurl; ?>user/kategori.php" class="btn btn-info btn-bordered waves-effect w-md waves-light">Kembali ke daftar</a>
												<button type="submit" class="btn btn-success btn-bordered waves-effect w-md waves-light" name="edit">Ubah</button>
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
			header("Location: ".$cfg_baseurl."user/kategori.php");
		}
	}
} else {
	header("Location: ".$cfg_baseurl);
}
?>