<?php

include "../../../../../include/dbconfig.php";
include "../../../../../include/fungsi.php";

$nomor_identitas = $_POST['nomor_identitas'];
	$query= mssql_query("SELECT a.*, b.parameter as sts_grup, c.value_name as nama_mitra, 
			d.value_name as alamat_mitra, e.parameter as fin_product
			from ITDept.dbo.book_regAplikasi_segment a
			LEFT JOIN book_segment_param b ON b.nilai=a.sts_acc_group AND b.keterangan='sts.accgroup'
			LEFT JOIN book_segment_value c ON c.regid=a.regid AND c.labelid='1'
			LEFT JOIN book_segment_value d ON d.regid=a.regid AND d.labelid='2'
			LEFT JOIN book_segment_param e ON e.nilai=a.financing_product AND e.keterangan='fin.product'
			where a.regid='$reg' and a.deletests=0 and no_identitas = '$nomor_identitas'");
	if(mssql_num_rows($query) > 0){
		$view = mssql_fetch_assoc($load);
	}else{
		echo "DATA TIDAK DITEMUKAN";
	}

?>