<?php
session_start();
require("mainconfig.php");
$msg_type = "nothing";

if (isset($_SESSION['user'])) {
	$sess_username = $_SESSION['user']['username'];
	$check_user = mysqli_query($db, "SELECT * FROM users WHERE username = '$sess_username'");
	$data_user = mysqli_fetch_assoc($check_user);
	if (mysqli_num_rows($check_user) == 0) {
		header("Location: ".$cfg_baseurl."logout.php");
	} else if ($data_user['status'] == "Suspended") {
		header("Location: ".$cfg_baseurl."logout.php");
	}
$year = date('Y');
$month = date('m');
$day = date('d');

    //bulanan
	$check_trbulanmasuk = mysqli_query($db, "SELECT SUM(amount) AS total FROM transactions WHERE user_id = '$sess_username' AND type= 'debit' AND YEAR(date) = $year AND MONTH(date) = $month");
	$data_bulanmasuk = mysqli_fetch_assoc($check_trbulanmasuk);
    	$check_trbulakeluar = mysqli_query($db, "SELECT SUM(amount) AS total FROM transactions WHERE user_id = '$sess_username' AND type= 'kredit' AND YEAR(date) = $year AND MONTH(date) = $month");
	$data_bulankeluar = mysqli_fetch_assoc($check_trbulakeluar);
    //daily
    $check_trmasuk = mysqli_query($db, "SELECT SUM(amount) AS total FROM transactions WHERE user_id = '$sess_username' AND type= 'debit' AND YEAR(Date) = $year AND MONTH(Date) = $month AND DAY(Date) = $day");
	$data_trmasuk = mysqli_fetch_assoc($check_trmasuk);
	  $check_trkeluar = mysqli_query($db, "SELECT SUM(amount) AS total FROM transactions WHERE user_id = '$sess_username' AND type= 'kredit' AND YEAR(Date) = $year AND MONTH(Date) = $month AND DAY(Date) = $day ");
	$data_trkeluar = mysqli_fetch_assoc($check_trkeluar);
}

if (isset($_SESSION['user'])) {
include("lib/header.php");
?>
            <div class="row">
              <div class="col-12 grid-margin stretch-card">
                <div class="card corona-gradient-card">
                  <div class="card-body py-0 px-0 px-sm-3">
                    <div class="row align-items-center">
                      <div class="col-4 col-sm-3 col-xl-2">
                        <img src="assets/images/dashboard/Group126@2x.png" class="gradient-corona-img img-fluid" alt="">
                      </div>
                      <div class="col-5 col-sm-7 col-xl-8 p-0">
                        <h4 class="mb-1 mb-sm-0">Selamat datang di CashFlow</h4>
                        <p class="mb-0 font-weight-normal d-none d-sm-block">Rekap transaksi harianmu dan lacak kondisi keuanganmu</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                          <h3 class="mb-0">Rp <?php echo number_format($data_bulanmasuk['total'],0,',','.'); ?></h3>
                        </div>
                      </div>
                      <div class="col-3">
                        <div class="icon icon-box-success ">
                          <span class="mdi mdi-arrow-bottom-left icon-item"></span>
                        </div>
                      </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Pemasukan Bulan ini</h6>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                          <h3 class="mb-0">Rp <?php echo number_format($data_trmasuk['total'],0,',','.'); ?></h3>
                        </div>
                      </div>
                      <div class="col-3">
                        <div class="icon icon-box-success">
                          <span class="mdi mdi-arrow-bottom-left icon-item"></span>
                        </div>
                      </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Pemasukan Hari ini</h6>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                          <h3 class="mb-0">Rp <?php echo number_format($data_bulankeluar['total'],0,',','.'); ?></h3>
                        </div>
                      </div>
                      <div class="col-3">
                        <div class="icon icon-box-danger">
                          <span class="mdi mdi-arrow-top-right icon-item"></span>
                        </div>
                      </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Pengeluaran Bulan ini</h6>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                          <h3 class="mb-0">Rp <?php echo number_format($data_trkeluar['total'],0,',','.'); ?></h3>
                        </div>
                      </div>
                      <div class="col-3">
                         <div class="icon icon-box-danger">
                          <span class="mdi mdi-arrow-top-right icon-item"></span>
                        </div>
                      </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Pengeluaran Hari ini</h6>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Dompet anda</h4>
                    <canvas id ="walletgraph" class="transaction-chart"></canvas>
                <?php
													$check_wallets = mysqli_query($db, "SELECT * FROM wallets WHERE user_id = '$sess_username'  ORDER BY id DESC");
													$no = 1;
													while ($data_wallets = mysqli_fetch_assoc($check_wallets)) {
													?>
                    <div class="bg-gray-dark d-flex d-md-block d-xl-flex flex-row py-3 px-4 px-md-3 px-xl-4 rounded mt-3">
                      <div class="text-md-center text-xl-left">
                        <h6 class="mb-1"><?php echo $data_wallets['name']; ?></h6>
                        <p class="text-muted mb-0"><?php echo $data_wallets['last_update']; ?></p>
                      </div>
                      <div class="align-self-center flex-grow text-right text-md-center text-xl-right py-md-2 py-xl-0">
                        <h6 class="font-weight-bold mb-0">Rp<?php echo number_format($data_wallets['balance'],0,',','.'); ?></h6>
                      </div>
                    </div>
                    				<?php
													$no++;
													}
				?>										
					 <div class="bg-gray-dark d-flex d-md-block d-xl-flex flex-row py-3 px-4 px-md-3 px-xl-4 rounded mt-3">
                      <div class="align-self-center flex-grow text-right text-md-center text-xl-right py-md-2 py-xl-0">
                        <a href="<?php echo $cfg_baseurl; ?>user/wallet/add.php" class="btn btn-primary btn-lg btn-block">
                        <i class="mdi mdi-wallet"></i> Tambah Dompet </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex flex-row justify-content-between">
                      <h4 class="card-title mb-1">Transaksi terbaru</h4>
                    </div>
                    <div class="row">
                      <div class="col-12">
					  
                        <div class="preview-list">
                            <?php
													$check_trx = mysqli_query($db, "SELECT * FROM transactions WHERE user_id = '$sess_username'  ORDER BY id DESC LIMIT 5");
													$no = 1;
													while ($data_trx = mysqli_fetch_assoc($check_trx)) {
													        if ($data_trx['type'] == 'kredit') {
												        $badge = 'danger';
												         $icon = 'mdi mdi-arrow-top-right';
												    } else {
												         $badge = 'success';
												         $icon = 'mdi mdi-arrow-bottom-left';
												    }
													?>
                          <div class="preview-item border-bottom">
                            <div class="preview-thumbnail">
                              <div class="preview-icon bg-<?php echo $badge;?>">
                                <i class="<?php echo $icon;?>"></i>
                              </div>
                            </div>
                            <div class="preview-item-content d-sm-flex flex-grow">
                              <div class="flex-grow">
                                <h6 class="preview-subject"><?php echo $data_trx['category']; ?> <?php echo $data_trx['note']; ?></h6>
                                <p class="text-muted mb-0">Rp<?php echo number_format($data_trx['amount'],0,',','.'); ?></p>
                              </div>
                              <div class="mr-auto text-sm-right pt-2 pt-sm-0">
                                <p class="text-muted"><?php echo $data_trx['date']; ?></p>
                                <p class="text-muted mb-0"><?php echo $data_trx['wallet']; ?></p>
                              </div>
                            </div>
                          </div>
                          
                          			<?php
													$no++;
													}
				?>		                         
                          </div>
                      <br>
					  <div class="text-md-center">
                              <a href="<?php echo $cfg_baseurl; ?>user/add/debit.php"  class="btn btn-success btn-lg ">
                        <i class="mdi mdi-plus"></i> Pemasukan </a>
						 <a href="<?php echo $cfg_baseurl; ?>user/add/kredit.php" class="btn btn-danger btn-lg ">
                        <i class="mdi mdi-minus"></i> Pengeluaran </a>
						 </div>  
					   </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
  <?php
include("lib/footer.php");
} else {
// jika tidak ada session login tampilkan landing
	header("Location: https://miamoe.my.id/login.php");
}
	$check_wallets = mysqli_query($db, "SELECT * FROM wallets WHERE user_id = '$sess_username'  ORDER BY id DESC");
	$check_walletss = mysqli_query($db, "SELECT * FROM wallets WHERE user_id = '$sess_username'  ORDER BY id DESC");
		$check_total = mysqli_query($db, "SELECT SUM(balance) AS total FROM wallets WHERE user_id = '$sess_username'");
	$data_total= mysqli_fetch_assoc($check_total);
?>

<script  type="text/javascript">
 var areaData = {
        labels: [<?php while ($p = mysqli_fetch_array($check_wallets)) { echo '"' . $p['name'] . '",';}?>],
        datasets: [{
            data: [<?php while ($q = mysqli_fetch_array($check_walletss)) { echo '' . $q['balance'] . ',';}?>],
            backgroundColor: [
              "#141228","#2e3442","#e35d5e","#f1ca7f","#b7d2cd","#8fb9aa"
            ] 
          }
        ]
      };
      var areaOptions = {
        responsive: true,
        maintainAspectRatio: true,
        segmentShowStroke: false,
        cutoutPercentage: 70,
        elements: {
          arc: {
              borderWidth: 0
          }
        },      
        legend: {
          display: false
        },
        tooltips: {
          enabled: true
        }
      }
      var transactionhistoryChartPlugins = {
        beforeDraw: function(chart) {
          var width = chart.chart.width,
              height = chart.chart.height,
              ctx = chart.chart.ctx;
      
          ctx.restore();
          var fontSize = 1;
          ctx.font = fontSize + "rem sans-serif";
          ctx.textAlign = 'left';
          ctx.textBaseline = "middle";
          ctx.fillStyle = "#ffffff";
      
          var text = "Rp <?php echo number_format($data_total['total'],0,',','.'); ?>", 
              textX = Math.round((width - ctx.measureText(text).width) / 2),
              textY = height / 2.4;
      
          ctx.fillText(text, textX, textY);

          ctx.restore();
          var fontSize = 0.75;
          ctx.font = fontSize + "rem sans-serif";
          ctx.textAlign = 'left';
          ctx.textBaseline = "middle";
          ctx.fillStyle = "#6c7293";

          var texts = "Total", 
              textsX = Math.round((width - ctx.measureText(text).width) / 1.93),
              textsY = height / 1.7;
      
          ctx.fillText(texts, textsX, textsY);
          ctx.save();
        }
      }
      
      var ctx = document.getElementById("walletgraph").getContext("2d");
      var myPieChart = new Chart(ctx, {
        type: 'doughnut',
        data: areaData,
        options: areaOptions,
        plugins: transactionhistoryChartPlugins
              });
</script>
    
    
    
    
    
