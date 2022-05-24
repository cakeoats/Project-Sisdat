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
			$post_dompet= $_POST['dompet'];
			$post_category = $_POST['category'];
			$post_jumlah = $_POST['jumlah'];
			$post_note = $_POST['note'];
			
		$check_wallet = mysqli_query($db, "SELECT * FROM wallets WHERE id = '$post_dompet'");
		$data_wallet = mysqli_fetch_assoc($check_wallet);
			$name_wallet = $data_wallet['name'];
			
			$update= date('Y-m-d H:i:s');
			if (empty($post_dompet) || empty($post_category) || empty($post_jumlah)) {
				$msg_type = "error";
				$msg_content = "<b>Gagal:</b> Mohon mengisi semua input.";
			} else {
			    
			    $update_wallet = mysqli_query($db, "UPDATE wallets SET balance = balance+$post_jumlah WHERE id = '$post_dompet'");
			    
				if ($update_wallet == TRUE) {
				$insert_debit = mysqli_query($db, "INSERT INTO transactions (user_id, wallet_id,wallet , amount,note,type,category,date) VALUES ('$sess_username', '$post_dompet', '$name_wallet', '$post_jumlah','$post_note', 'debit','$post_category',' $update')");
				}
				if ($insert_debit == TRUE) {
					$msg_type = "success";
					$msg_content = "<b>Berhasil:</b> Transaksi Debit berhasil ditambahkan.<br /><b>Jumlah:</b> $post_jumlah<br /><b>Dompet:</b> $name_wallet<br /><b>Tanggal:</b> $update";
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
									<div class="card-title">Tambah Transaksi Debit</div>
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
												<label class="col-md-2 control-label">Dompet</label>
												<div class="col-md-12">
											<select class="form-control" name="dompet">
														<option value="0">Pilih salah satu...</option>
														<?php
														$check_wall = mysqli_query($db, "SELECT * FROM wallets WHERE user_id ='$sess_username' ORDER BY name ASC");
														while ($data_wall = mysqli_fetch_assoc($check_wall)) {
														?>
														<option value="<?php echo $data_wall['id']; ?>"><?php echo $data_wall['name']; ?></option>
														<?php
														}
														?> 	</select>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Kategori</label>
												<div class="col-md-12">
										<select class="form-control" name="category">
														<option value="0">Pilih salah satu...</option>
														<?php
														$check_cat = mysqli_query($db, "SELECT * FROM categories WHERE user_id ='$sess_username' AND type = 'debit' ORDER BY name ASC");
														while ($data_cat = mysqli_fetch_assoc($check_cat)) {
														?>
														<option value="<?php echo $data_cat['name']; ?>"><?php echo $data_cat['name']; ?></option>
														<?php
														}
														?>
													</select>
												</div>
											</div>
												<div class="form-group">
												<label class="col-md-2 control-label">Jumlah</label>
												<div class="col-md-12">
											<input type="number" name="jumlah" class="form-control" placeholder="Jumlah">
												</div>
											</div>
												<div class="form-group">
												<label class="col-md-2 control-label">Note</label>
												<div class="col-md-12">
											<input type="text" name="note" class="form-control" placeholder="Ex : Makan siang">
												</div>
											</div>
											<br><br>
											<a href="<?php echo $cfg_baseurl; ?>user/transaksi.php" class="btn btn-info btn-bordered waves-effect w-md waves-light">Kembali ke daftar</a>
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