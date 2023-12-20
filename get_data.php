<?php
include("../../../../../include/fungsi.php");
include("../../../../../include/dbconfig.php");
$regidform      = $_POST['regid'];
$selectedValue  = $_POST['selectedValue'];
$nik            = $_SESSION['nik'];

// echo '$regidform = '. $regidform;
// echo '$selectedValue = '. $selectedValue;
// echo '$nik = '. $nik;

$query1 = "SELECT a.labelid, a.nama_label, b.valueid, b.value_name FROM book_segment_label a
                            LEFT JOIN book_segment_value b ON b.labelid=a.labelid
                            WHERE b.regid='$regidform' AND b.paramid='$selectedValue' ORDER BY a.labelid";
$result1 = mssql_query($query1);

if (mssql_num_rows($result1) > 0) {
    $query = "SELECT a.labelid, a.nama_label, b.valueid, b.value_name FROM book_segment_label a
                            LEFT JOIN book_segment_value b ON b.labelid=a.labelid
                            WHERE b.regid='$regidform' AND b.paramid='$selectedValue' ORDER BY a.labelid";
    $result = mssql_query($query);

} else {
    $query = "SELECT labelid, paramid, nama_label FROM ITDept.dbo.book_segment_label WHERE paramid='$selectedValue' AND deletests=0 ORDER BY labelid";
    $result = mssql_query($query);
}


    $no = 1;
    $no1 = 1;
    $no2 = 1;
    $no3 = 1;
    while ($data = mssql_fetch_assoc($result)) {
        // echo json_encode($row);
?>
<tr id="jancok">
            <td>
                <label><?php echo $data["nama_label"] ?></label>
                <label style="text-align: right;">:</label>
            </td>
            <td>
                <input type='text' value='<?= $data['value_name'] ?>' id="inputan" name='inputan' required>
                <input type='hidden' value='<?= $data['labelid'] ?>' id="labelan" name='labelan'>
                <input type='hidden' value='<?= $data['valueid'] ?>' id="valueid" name='valueid'>
            </td>
</tr>
<?php
    
}
// else {
//     echo "Tidak ada data untuk selectedValue: " . $selectedValue;
// }
?>