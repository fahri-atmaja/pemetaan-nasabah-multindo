<?php
// ini_set("display_errors", true);
include "../../../../../include/fungsi.php";
include "../../../../../include/dbconfig.php";

// $reg = "170181"; // non group
// $reg = "170133"; // group
$reg 		= $_GET['regid'];
$dataid 	= $_POST['dataid'];
$nik 		= $_SESSION['nik'];
$username 	= $_SESSION['username'];
if ($nik == NULL || $nik == "") {
	header("Refresh:0");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Pemetaan Nasabah</title>
	<link rel="stylesheet" href="<?php echo hostname(); ?>/plugins/sweetalert2/sweetalert2.min.css">
	<script type="text/javascript" src="<?php echo HOSTNAME(); ?>/plugins/sweetalert2/sweetalert2.min.js"></script>
	<script type="text/javascript" src="<?php echo HOSTNAME(); ?>/assets/jquery-loading-overlay-2.1.7/dist/loadingoverlay.min.js"></script>

	<style>
		* {
			font-size: 30px;
		}

		h1 {
			font-size: 20px !important;
			font-weight: 700;
		}

		.table .thead-light th {
			color: #495057;
			background-color: #e9ecef;
			border-color: #dee2e6;
		}

		.table thead th {
			vertical-align: middle !important;
			border-bottom: 2px solid #dee2e6;
		}

		th {
			text-align: inherit;
		}

		.top-body {
			font-size: 12px !important;
			font-weight: bold;
		}

		.top-body td {
			padding: 6px 13px !important;
		}

		.top-body input {
			padding: 13px !important;
			height: 8px !important;
		}

		.top-body select {
			height: 25px !important;
			width: 150px !important;
		}

		.top-body textarea {
			width: 890px;
			margin-bottom: 10px;
		}

		.addrow,
		.deleterow {
			font-weight: bold;
		}

		.bottom-body {
			display: flex;
			justify-content: center;
			align-items: center;
			margin: 10px auto;
		}

		.glyphicon {
			top: 1px;
		}

		input[type=text],
		textarea {
			text-transform: uppercase;
		}

		/* Mengatur margin antar elemen */
		label,
		input {
			margin-bottom: 10px;
		}

		/* Mengatur padding pada sel */
		td {
			padding: 5px;
		}

		/* Mengatur lebar label */
		label {
			width: 120px;
			display: inline-block;
		}

		/* Memberikan margin kiri pada input */
		input[type="text"] {
			margin-left: 10px;
		}

		/* Mengatur border pada input */
		input[type="text"],
		input[type="hidden"] {
			border: 1px solid #ccc;
			padding: 5px;
		}

		/* Mengatur warna latar belakang dan teks pada input readonly */
		input[readonly] {
			background-color: #f9f9f9;
			color: #333;
		}

		/* Mengatur font dan ukuran teks */
		label,
		input {
			font-family: Arial, sans-serif;
			font-size: 24px;
		}

		/* Mengatur padding dan margin pada tr */
		tr {
			margin-bottom: 10px;
		}

		/* Mengatur padding dan margin pada select box */
		select {
			padding: 5px;
			margin: 5px 0;
			border: 1px solid #ccc;
		}

		/* Mengatur lebar select box */
		select {
			width: 150px;
			/* Sesuaikan dengan kebutuhan Anda */
		}

		/* Mengatur font dan ukuran teks pada select box */
		select {
			font-family: Arial, sans-serif;
			font-size: 24px;
		}
	</style>

	<!-- CSS Custom Inputan -->
	<style>
		input[type="text"],
		input[type="hidden"],
		input[readonly] {
			/* Atur gaya dasar untuk semua input */
			height: 25px;
			width: 200px;
			padding-left: 8px;
			margin-left: 5px;
		}

		select {
			/* Atur gaya dasar untuk semua input */
			height: 25px;
			width: 200px;
			border-radius: 4px;
			padding-left: 8px;
			margin-left: 5px;
		}

		textarea {
			/* Atur gaya dasar untuk semua input */
			height: 100px;
			width: 400px;
			border-radius: 4px;
			padding-left: 8px;
			margin-left: 5px;
		}

		label {
			text-align: left;
			/* margin-left: 10px; */
			width: 100px;
		}
	</style>
	<!-- CSS Custom Inputan -->
</head>

<?php

// $load = mssql_query("SELECT a.*, b.parameter as sts_grup, c.segmentid, c.value_name as nama_mitra, 
// d.value_name as alamat_mitra, e.parameter as fin_product
// from ITDept.dbo.book_regAplikasi_segment a
// LEFT JOIN book_segment_param b ON b.nilai=a.sts_acc_group AND b.keterangan='sts.accgroup'
// LEFT JOIN book_segment_value c ON c.regid=a.regid AND c.labelid='1'
// LEFT JOIN book_segment_value d ON d.regid=a.regid AND d.labelid='2'
// LEFT JOIN book_segment_param e ON e.nilai=a.financing_product AND e.keterangan='fin.product'
// where a.regid='$reg' and a.deletests=0");
$load = mssql_query("SELECT a.*, b.parameter as sts_grup, c.value_name, e.parameter as fin_product, f.CustName
from ITDept.dbo.book_regAplikasi_segment a
LEFT JOIN book_segment_param b ON b.nilai=a.sts_acc_group AND b.keterangan='sts.accgroup'
LEFT JOIN book_segment_value c ON c.regid=a.regid
LEFT JOIN book_segment_param e ON e.nilai=a.financing_product AND e.keterangan='fin.product'
LEFT JOIN book_regaplikasi f ON f.regid=a.regid
where a.regid='$reg' and a.deletests=0");
if ($load) {
	$view = mssql_fetch_assoc($load);
} else {
	echo "Data Tidak Ditemukan";
}
?>

<body>
	<div class="container-fluid">
		<!-- Pencarian Group CIF -->
		<div class="panel panel-default">
			<div class="panel-heading">
				<h1 class="text-center">PEMETAAN NASABAH</h1>
				<span id="txt_browser"></span>
			</div>
			<div class="container-fluid">
				<div class="row">
					<div class="col col-lg-8">
						<table class="table-borderless">
							<tbody>
								<form method="post" name="form_group_cif" action="#">
									<tr>
										<td>
											<label>Cari Group CIF</label>
											<label style="text-align: right;">:</label>
										</td>
										<td>
											<input type="text" id="nikreal" name="nikreal" placeholder="Nomor Identitas" maxlength="20" onkeypress='validate(event)' value="<?= $view['no_identitas']; ?>" required>
										</td>
									</tr>
									<tr>
										<td></td>
										<td><button id="create" name="create" style="margin-bottom: 30px; margin-left: 5px;" class="btn btn-primary">PENCARIAN</button></td>
									</tr>
									<!-- Form Group/Non Group CIF -->
									<?php
									// if ($view['group_cif'] != null) {
									include 'form_group_cif.php';
									// } else {
									// 	include 'form_nongroup.php';
									// }
									?>
									<!-- Form Group/Non Group CIF -->
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal" id="modal_cari" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-keyboard="false"></div>
</body>

<script>
	function validate(evt) {
		var theEvent = evt || window.event;
		if (theEvent.type === 'paste') {
			key = event.clipboardData.getData('text/plain');
		} else {
			var key = theEvent.keyCode || theEvent.which;
			key = String.fromCharCode(key);
		}
		var regex = /[0-9]/;
		if (!regex.test(key)) {
			theEvent.returnValue = false;
			if (theEvent.preventDefault) theEvent.preventDefault();
		}
	}
</script>



<script>
	$(document).ready(function() {
		$("#create").click(function(e) {
			e.preventDefault();

			// let regid 		= $("input[name=regid]").val();
			// let custid 		= $("input[name=custid]").val();
			var no_identitas = $("#nikreal").val();
			// var no_identitas = "</?php echo $view['no_identitas']; ?>";

			$.ajax({
				url: "module/booking/order/creditreviewer/pemetaan_nasabah/modal_matching.php",
				method: "POST",
				data: {
					no_identitas: no_identitas
				},
				cache: false,
				success: function(response) {
					$("#modal_cari").modal({
						backdrop: 'static',
						show: true,
						keyboard: false,

					});
					$("#modal_cari").html(response);
				}
			})
		})
	})
</script>

</html>