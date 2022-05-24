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
			$checkdb_tipe = mysqli_query($db, "SELECT * FROM transactions WHERE id = '$post_id'");
			$datadb_tipe = mysqli_fetch_assoc($checkdb_tipe);
			if (mysqli_num_rows($checkdb_tipe) == 0) {
				header("Location: ".$cfg_baseurl."user/transaksi.php");
			} else {
			    
			    if (isset($_POST['delete'])) {
				$post_dompet = $datadb_tipe['wallet_id'];
				$post_jumlah =  $datadb_tipe['amount'];
			    	if ($datadb_tipe['type'] == 'debit' ){
				    $update_wallet = mysqli_query($db, "UPDATE wallets SET balance = balance-$post_jumlah WHERE id = '$post_dompet'");
			    	} else 	if ($datadb_tipe['type'] == 'kredit' ){
				     $update_wallet = mysqli_query($db, "UPDATE wallets SET balance = balance+$post_jumlah WHERE id = '$post_dompet'");
				            }
				     if ($update_wallet == TRUE) {       
				$delete_service = mysqli_query($db, "DELETE FROM transactions WHERE id = '$post_id'");
				     } else {
				         	$msg_type = "error";
					$msg_content = "<b>Gagal:</b> dihapus saldo tidak dikembalikan.";
				     }
				if ($delete_service == TRUE) {
					$msg_type = "success";
					$msg_content = "<b>Berhasil:</b> dihapus.";
				} 
		}
	
				include("../../lib/header.php");
?>
								<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<div class="card-title">Delete Transaksi</div>
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
											<input type="hidden" name="id" value="<?php echo $datadb_tipe['id']; ?>">
											<div class="form-group">
												<label class="col-md-2 control-label">Transaksi</label>
												<div class="col-md-12">
														<input type="text" name="nama" class="form-control" placeholder="<?php echo $datadb_tipe['category']; ?> - Rp<?php echo $datadb_tipe['amount']; ?> <?php echo $datadb_tipe['created_at']; ?>" readonly>
												</div>
											</div>
											<a href="<?php echo $cfg_baseurl; ?>user/transaksi.php" class="btn btn-info btn-bordered waves-effect w-md waves-light">Kembali ke daftar</a>
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
			header("Location: ".$cfg_baseurl."user/transaksi.php");
		}
	}
} else {
	header("Location: ".$cfg_baseurl);
}
?>