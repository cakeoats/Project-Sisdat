<?php
session_start();
require("../mainconfig.php");
$msg_type = "nothing";
if (isset($_SESSION['user'])) {
	$sess_username = $_SESSION['user']['username'];
	$check_user = mysqli_query($db, "SELECT * FROM users WHERE username = '$sess_username'");
	$data_user = mysqli_fetch_assoc($check_user);
	if (mysqli_num_rows($check_user) == 0) {
		header("Location: ".$cfg_baseurl."logout.php");
	} else {
		if (isset($_POST['delete'])) {
			$post_sid = $_POST['id'];
			$checkdb_service = mysqli_query($db, "SELECT * FROM wallets WHERE id = '$post_sid'");
			if (mysqli_num_rows($checkdb_service) == 0) {
				$msg_type = "error";
				$msg_content = "<b>Gagal:</b> Kategori tidak ditemukan.";
			} else {
				$delete_service = mysqli_query($db, "DELETE FROM wallets WHERE id = '$post_sid'");
				if ($delete_service == TRUE) {
					$msg_type = "success";
					$msg_content = "<b>Berhasil:</b> dihapus.";
				}
			}
		}

	include("../lib/header.php");
?>
				

							<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<div class="card-title">Daftar Dompet</div>
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
										}
										?>
										<div class="col-md-6">
											<a href="<?php echo $cfg_baseurl; ?>user/wallet/add.php" class="pull-right btn btn-info"><i class="mdi mdi-plus"></i> Tambah</a>
										</div> 
										<br><br>
									
										<div class="col-md-6">
											<form method="GET">
											    <div class="form-group">
                      <div class="input-group">
                        <input type="text" class="form-control" placeholder="Nama kategori" name="search" aria-label="Nama kategori" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                          <button type="submit" class="btn btn-sm btn-primary" type="button">Cari</button>
                        </div>
                      </div>
                    </div>
											</form>
										</div>
										<br>
										
										<div class="clearfix"></div>
										<br />
										<div class="col-md-12 table-responsive">
											<table class="table table-striped table-bordered table-hover m-0">
												<thead>
													<tr>
														<th>Nama</th>
														<th>Saldo</th>
														<th>Last Update</th>
														<th>Created At</th>
														<th>Aksi</th>
													</tr>
												</thead>
												<tbody>
												<?php
// start paging config
if (isset($_GET['search'])) {
	$search = $_GET['search'];
	$query_list = "SELECT * FROM wallets WHERE name LIKE '%$search%' AND user_id = '$sess_username' ORDER BY id ASC"; // edit
} else {
	$query_list = "SELECT * FROM wallets WHERE user_id = '$sess_username' ORDER BY id ASC"; // edit
}
$records_per_page = 30; // edit

$starting_position = 0;
if(isset($_GET["page_no"])) {
	$starting_position = ($_GET["page_no"]-1) * $records_per_page;
}
$new_query = $query_list." LIMIT $starting_position, $records_per_page";
$new_query = mysqli_query($db, $new_query);
// end paging config
												while ($data_show = mysqli_fetch_assoc($new_query)) {
												    
												    if ($data_show['type'] == 'kredit') {
												        $badge = 'danger';
												    } else {
												         $badge = 'success';
												    }
												?>
													<tr>
													
															<td><?php echo $data_show['name']; ?></td>
															
															<td>Rp<?php echo number_format($data_show['balance'],0,',','.'); ?></td>
															
															<td><?php echo $data_show['last_update']; ?></td>
															
															<td><?php echo $data_show['created_at']; ?></td>
															
														<td align="center">
														<a href="<?php echo $cfg_baseurl; ?>user/wallet/delete.php?id=<?php echo $data_show['id']; ?>" class="btn  btn-danger"><i class="mdi mdi-delete"></i></a>
															<a href="<?php echo $cfg_baseurl; ?>user/wallet/edit.php?id=<?php echo $data_show['id']; ?>" class="btn btn-warning"><i class="mdi mdi-table-edit"></i></a>
														</td>
													</tr>
												<?php
												}
												?>
												</tbody>
											</table>
										</div><br><br>
																<div class="col-md-12">
									<ul class="pagination pagination-split">
<?php
// start paging link
$url = "https://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
$query_list = mysqli_query($db, $query_list);
$total_no_of_records = mysqli_num_rows($query_list);
if($total_no_of_records > 0) {
    if (isset($_GET['search']) AND isset($_GET['status'])) {
        if (!empty($_GET['search']) OR !empty($_GET['status'])) {
	        $post_data = "&status=".$_GET['status']."&search=".$_GET['search'];
        } else {
            $post_data = "";
        }
	} else if (isset($_GET['search']) AND isset($_GET['category'])) {
	    if (!empty($_GET['search']) OR !empty($_GET['category'])) {
	        $post_data = "&category=".$_GET['category']."&search=".$_GET['search'];
	    } else {
	        $post_data = "";
		}
	} else if (isset($_GET['search'])) {
		if (!empty($_GET['search'])) {
	        $post_data = "&search=".$_GET['search'];
	    } else {
	        $post_data = "";
		}
	} else {
	    $post_data = "";
	}
	$total_no_of_pages = ceil($total_no_of_records/$records_per_page);
	$current_page = 1;
	if(isset($_GET["page"])) {
		$current_page = $_GET["page"];
	}
	if($current_page != 1) {
		$previous = $current_page-1;
	?>  
	    <li class="page-item"><a class="page-link" href="<?php echo $url."?page=1.$post_data"; ?>">&lsaquo; First</a></li>
		<li class="page-item"><a class="page-link" href="<?php echo $url."?page=".$previous.$post_data; ?>" aria-label="Previous"><span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span></a></li>
	<?php 
	}
	$jumlah_number = 2;
	$start_number = ($current_page > $jumlah_number)? $current_page - $jumlah_number : 1;
	$end_number = ($current_page < ($total_no_of_pages - $jumlah_number))? $current_page + $jumlah_number : $total_no_of_pages;
	for($i=$start_number; $i<=$end_number; $i++) {
	    if($i==$current_page) {
	?>
	    <li class="page-item active"><a class="page-link" href="<?php echo $url."?page=".$i.$post_data; ?>"><?php echo $i; ?></a></li>
	<?php } else { ?>
		<li class="page-item"><a class="page-link" href="<?php echo $url."?page=".$i.$post_data; ?>"><?php echo $i; ?></a></li>
	<?php }
	}
	if($current_page!=$total_no_of_pages) {
		$next = $current_page+1;
	?>
	    <li class="page-item"><a class="page-link" href="<?php echo $url."?page=".$next.$post_data; ?>" aria-label="Next"><span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span></a></li>
		<li class="page-item"><a class="page-link" href="<?php echo $url."?page=".$total_no_of_pages.$post_data; ?>">Last &rsaquo;</a></li>
	<?php
	}
}
// end paging link
?>
</ul></div>
									</div>
								</div>
							</div>
						</div>
						<!-- end row -->
<?php
	include("../lib/footer.php");
	}
} else {
	header("Location: ".$cfg_baseurl);
}
?>