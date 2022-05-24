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
		if (isset($_POST['add'])) {
			$post_nama= $_POST['nama'];

			$post_tipe = $_POST['tipe'];
			
			if (empty($post_nama) || empty($post_tipe) ) {
				$msg_type = "error";
				$msg_content = "<b>Gagal:</b> Mohon mengisi semua input.";
			} else {
				$insert_news = mysqli_query($db, "INSERT INTO categories (user_id, name , type) VALUES ('$sess_username', '$post_nama', '$post_tipe')");
				if ($insert_news == TRUE) {
					$msg_type = "success";
					$msg_content = "<b>Berhasil:</b> Kategori berhasil ditambahkan.<br /><b>Nama:</b> $post_nama<br /><b>Tipe:</b> $post_tipe<br /><b>Tanggal:</b> $date";
				} else {
					$msg_type = "error";
					$msg_content = "<b>Gagal:</b> Error system 1.";
				}
			}
		}

	include("../../lib/header.php");
?>
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<div class="card-title">Add Kategori transaksi</div>
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
											<input type="text" name="nama" class="form-control" placeholder="Nama kategori">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Tipe</label>
												<div class="col-md-12">
													<select class="form-control" name="tipe">
														<option value="0">Pilih Tipe</option>
														<option value="debit">Debit (Pemasukan)</option>
														<option value="kredit">Kredit (Pengeluaran)</option>
													</select>
												</div>
											</div>	
											<br><br>
											<a href="<?php echo $cfg_baseurl; ?>user/kategori.php" class="btn btn-info btn-bordered waves-effect w-md waves-light">Kembali ke daftar</a>
												<button type="submit" class="btn btn-success btn-bordered waves-effect w-md waves-light" name="add">Tambah</button>
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
	header("Location: ".$cfg_baseurl);
}
?>