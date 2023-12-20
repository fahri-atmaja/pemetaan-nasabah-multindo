<?php
if(!empty($_POST['custid'])){
$custid = $_POST['custid'];
}else{
$custid = $view['group_cif'];
}
?>
<form method="post" name="form_group_cif" action="updatePemetaan.php">
    <table>
        <tbody>
            <tr>
                <td>
                    <label>Status Akun Grup</label>
                    <input type="hidden" name="regid" id="regid" class="form-control" value="<?= $view['regid']; ?>" readonly>
                    <input type="hidden" name="no_identitas" id="no_identitas" class="form-control" value="<?= $view['no_identitas']; ?>" readonly>
                    <input type="hidden" name="sts_acc_group" id="sts_acc_group" class="form-control" value="<?= $view['sts_acc_group']; ?>" readonly>
                    <input type="text" name="sts_grup" id="sts_grup" class="form-control" value="<?= $view['sts_grup']; ?>" readonly>
                </td>
            </tr>
            <tr>
                <td>
                    <label>Status Nasabah | cek : <?= $view['sts_nasabah'] ?></label>
                    <select name="sts_nasabah" id="sts_nasabah" class="form-control" onchange="tampilkanInput()">
                        <?php 
                        $loadsts = mssql_query("SELECT nilai,parameter FROM book_segment_param WHERE keterangan='sts.nasabah' AND nilai='$view[sts_nasabah]'");
                        $co = mssql_fetch_assoc($loadsts); ?>
                        <option name="sts_nasabah" value="<?= $co['nilai'] ?>"><?= $co['parameter']; ?></option>
                        <?php
                        $loadstsnas = mssql_query("SELECT nilai,parameter FROM book_segment_param WHERE keterangan='sts.nasabah' AND nilai!='$view[sts_nasabah]'");
                        while($com = mssql_fetch_assoc($loadstsnas)){ ?>
                            <option name="sts_nasabah" value="<?= $com['nilai'] ?>"><?= $com['parameter']; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </td>
            </tr>

            <?php
            $regidform = $view['regid'];
            $dinamis = mssql_query("SELECT a.labelid, a.nama_label, b.value_name FROM book_segment_label a
            LEFT JOIN book_segment_value b ON b.labelid=a.labelid
            WHERE b.regid='$regidform'");
            $counter = 1;
            if($hitung = mssql_num_rows($dinamis) > 0){
                while($tampilinput = mssql_fetch_assoc($dinamis)){ 
            ?>
                <tr id="inputContainer<?= $counter ?>" style="display:none;">
                    <td>
                        <label><?= $tampilinput['nama_label'] ?></label>
                        <input type="hidden" name="labelan<?= $counter ?>" id="labelan<?= $counter ?>" class="form-control" value="<?= $tampilinput['labelid'] ?>">
                        <input type="text" name="inputan<?= $counter ?>" id="inputan<?= $counter ?>" class="form-control" value="<?= $tampilinput['value_name'] ?>">
                    </td>
                </tr>
            <?php
                    $counter++;
                }
            }
            ?>
            <tr>
                <td>
                <label>Financing Product</label>
                <select name="financing_product" id="financing_product" class="form-control">
                    <?php 
                    $loadfin = mssql_query("SELECT nilai,parameter FROM book_segment_param WHERE keterangan='fin.product' AND nilai='$view[financing_product]'");
                    $cofin = mssql_fetch_assoc($loadfin); ?>
                    <option name="financing_product" value="<?= $cofin['nilai'] ?>"><?= $cofin['parameter']; ?></option>
                    <?php
                    $loadstsfin = mssql_query("SELECT nilai,parameter FROM book_segment_param WHERE keterangan='fin.product' AND nilai!='$view[financing_product]'");
                    while($comfin = mssql_fetch_assoc($loadstsfin)){ ?>
                        <option name="financing_product" value="<?= $comfin['nilai'] ?>"><?= $comfin['parameter']; ?></option>
                    <?php
                    }
                    ?>
                </select>
                </td>
            </tr>
            <tr>
                <td>
                    <label>Grup Usaha</label>
                    <input type="text" name="grup_usaha" id="grup_usaha" class="form-control" value="<?= $view['grup_usaha']; ?>">
                </td>
            </tr>
            <tr>
                <td>
                    <label>Bidang Usaha</label>
                    <input type="text" name="bidang_usaha" id="bidang_usaha" class="form-control" value="<?= $view['bidang_usaha']; ?>">
                </td>
            </tr>
            <tr>
                <td>
                    <button type="submit" name="updatePemetaan" id="updatePemetaan" class="button btn-primary">Update</button>
                </td>
            </tr>
        </tbody>
    </table>
</form>
<script type="text/javascript">
    function tampilkanInput() {
        var sts_nasabah = document.getElementById("sts_nasabah").value;
        <?php
        for ($i = 1; $i < $counter; $i++) {
        ?>
            var inputContainer<?= $i ?> = document.getElementById("inputContainer<?= $i ?>");
            if (sts_nasabah == '2') {
                inputContainer<?= $i ?>.style.display = "table-row";
            } else {
                inputContainer<?= $i ?>.style.display = "none";
            }
        <?php
        }
        ?>
    }
    tampilkanInput();
$(document).ready(function() {
    $(document).on("click", "button[name=updatePemetaan]", function(e) {
                e.preventDefault();
        
                let regid = $("input[name='regid']").val();
                let no_identitas = $("input[name='no_identitas']").val();
				let group_cif = $("input[name='group_cif']").val();
				let sts_acc_group = $("input[name='sts_acc_group']").val();
				let sts_nasabah = $("select[name='sts_nasabah']").val();
				let inputan = [];
                $("input[name^='inputan']").each(function() {
                    inputan.push($(this).val());
                });
                let labelan = [];
                $("input[name^='labelan']").each(function() {
                    labelan.push($(this).val());
                });
				let financing_product = $("select[name='financing_product']").val();
				let grup_usaha = $("input[name='grup_usaha']").val();
                let bidang_usaha = $("input[name='bidang_usaha']").val();
                

				let formData = new FormData();
				formData.append('act', 'updatePemetaan');
                formData.append('regid', regid);
                formData.append('no_identitas', no_identitas);
				formData.append('group_cif', group_cif);
				formData.append('sts_acc_group', sts_acc_group);
				formData.append('sts_nasabah', sts_nasabah);
				for (let i = 0; i < inputan.length; i++) {
                    formData.append('inputan[]', inputan[i]);
                }
                for (let i = 0; i < labelan.length; i++) {
                    formData.append('labelan[]', labelan[i]);
                }
				formData.append('financing_product', financing_product);
				formData.append('grup_usaha', grup_usaha);
                formData.append('bidang_usaha', bidang_usaha);

				Swal.fire({
					title: 'Apakah Anda Yakin? GADDD',
					text: "Anda akan mengupdate Pemetaan Nasabah!",
					icon: 'warning',
					showCancelButton: true,
					cancelButtonText: "Batalkan",
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Ya, Lanjutkan!'
				}).then((result) => {
					if (result.isConfirmed) {
						$.ajax({
							url: "module/booking/order/creditreviewer/pemetaan_nasabah/script.php",
							method: "POST",
							data: formData,
							dataType: "JSON",
							enctype: 'multipart/form-data',
							cache: false,
							processData: false,
							contentType: false,
							beforeSend: function() {
								$.LoadingOverlay("show");

							},
							success: function(response) {
								$.LoadingOverlay("hide");
								console.log(response);
								if (response.status == "OK") {
									Swal.fire({
										icon: 'success',
										title: 'Berhasil',
										text: response.pesan,
									})
								} else {
									Swal.fire({
										icon: 'error',
										title: 'Oops...',
										text: response.pesan,
									}).then(() => {})
								}
							}
						});
					}
				})
			});
        })
</script>