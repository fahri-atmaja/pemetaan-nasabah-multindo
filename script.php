<?php
include_once("../../../../../include/fungsi.php");
include_once("../../../../../include/dbconfig.php");

$act = $_POST['act'] ? $_POST['act'] : $_GET['act'];
$nik = $_SESSION['nik'];
switch ($act) {
    case 'updatePemetaan':
        $pesan = "";
        $log = "";
        $error = 0;
        $status = "";
        $error_variables = array();
        $segmentid           = $_POST['segmentid'];
        $regidpost           = $_POST['regidpost'];
        $nikreal             = $_POST['nikreal'];
        $group_cif           = $_POST['group_cif'];
        $sts_acc_group       = $_POST['sts_acc_group'];
        $sts_nasabah_real    = $_POST['sts_nasabah_real'];
        $sts_nasabah         = $_POST['sts_nasabah'];
        $inputan             = $_POST['inputan'];
        $labelan             = $_POST['labelan'];
        $valueid             = $_POST['valueid'];
        $financing_product   = $_POST['financing_product'];
        $grup_usaha          = $_POST['grup_usaha'];
        $bidang_usaha        = $_POST['bidang_usaha'];
        $createdate          = getDate();

        $variables = array(
            'segmentid', 'regidpost', 'nikreal', 'group_cif', 'sts_acc_group',
            'sts_nasabah_real', 'sts_nasabah', 'inputan', 'labelan', 'valueid',
            'financing_product', 'grup_usaha', 'bidang_usaha', 'createdate'
        );

        foreach ($variables as $var) {
            if (empty($$var)) {
                $error_variables[] = $var;
            }
        }
        
        if (
            empty($segmentid) || empty($regidpost) || empty($nikreal) || empty($group_cif) ||
            empty($sts_acc_group) || empty($sts_nasabah_real) || empty($sts_nasabah) ||
            empty($financing_product) ||
            empty($grup_usaha) || empty($bidang_usaha) || empty($createdate)
        ) {
            $error++;
            $pesan = "Gagal! Cek data tidak boleh kosong!!.";
            $log = "Error: The following variables are empty: " . implode(", ", $error_variables);
            $status = "ERROR";
        } else {
        // echo '$inputan ='.$inputan;
        $query_simpulan = "UPDATE  ITDept.dbo.book_regAplikasi_segment SET
                                        no_identitas = '$nikreal',
                                        group_cif = '$group_cif',
                                        sts_acc_group = '$sts_acc_group',
                                        sts_nasabah = '$sts_nasabah_real',
                                        financing_product = '$financing_product',
                                        grup_usaha = '$grup_usaha',
                                        bidang_usaha = '$bidang_usaha',
                                        lastupdate = getdate() ,
                                        lastuser = '$nik'
                                WHERE regid = '$regidpost'";

        if (!empty($inputan) && !empty($labelan)) {
            foreach ($inputan as $key => $input_value) {
                if (isset($labelan[$key])) {
                    $label_value = $labelan[$key];
                    $id_value = $valueid[$key];
                    if($id_value!=''){
                    $queryupdate= "UPDATE ITDept.dbo.book_segment_value 
                    SET value_name='$input_value',paramid='$sts_nasabah' WHERE valueid='$id_value'";
                    }else{
                    $queryupdate= "INSERT INTO ITDept.dbo.book_segment_value(segmentid, value_name,paramid,labelid,regid,deletests,createdate,createuser) 
                    VALUES('$segmentid','$input_value',
                    '$sts_nasabah','$label_value','$regidpost','0',getdate(),'$nik')"; 
                    }
                    $qupdate= mssql_query($queryupdate);
                    }
                }
            }  
        $exec_simpulan = mssql_query($query_simpulan);

        if (!$exec_simpulan ) {
            $error++;
            $pesan = "GAGAL UPDATE DATA PEMETAAN NASABAH.";
            $log = mssql_get_last_message();
            $status = $queryupdate;
        } else {
            $pesan = "BERHASIL UPDATE DATA PEMETAAN NASABAH";
            $log .= $queryupdate;
            $status = "OK";
        }
    }
        $response = array(
            "pesan" => $pesan,
            "log" => $log,
            "status" => "$status"
        );
        echo json_encode($response);
        break;
}

