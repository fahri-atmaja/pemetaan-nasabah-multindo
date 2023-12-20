<?php
if (!empty($_POST['custid'])) {
    $custid = $_POST['custid'];
} else {
    $custid = $view['group_cif'];
}

if (!empty($_POST['custname'])) {
    $custname = $_POST['custname'];
} else {
    $loadname = mssql_query("SELECT CustName FROM book_regaplikasi WHERE custid='$view[group_cif]'");
    $namecif = mssql_fetch_assoc($loadname);
    $custname = $namecif['CustName'];
}

if (!empty($_POST['sts_acc_group'])) {
    $sts_acc_group = $_POST['sts_acc_group'];
} else {
    $sts_acc_group = $view['sts_acc_group'];
}

if (!empty($_POST['sts_grup'])) {
    $sts_grup = $_POST['sts_grup'];
} else {
    $sts_grup = $view['sts_grup'];
}
?>

<tr>
    <td>
        <label>Nama Nasabah</label>
        <label style="text-align: right;">:</label>
    </td>
    <td><input type="text" name="nama_nasabah" id="nama_nasabah" value="<?= $view['CustName'] ?>" readonly></td>
</tr>
<tr id="inputCif" style="display:none;">
    <td>
        <label>Group Cif</label>
        <label style="text-align: right;">:</label>
    </td>
    <td>
        
        <input type="hidden" name="regidpost" id="regidpost" value="<?= $view['regid']; ?>" readonly>
        <input type="hidden" name="no_identitas" id="no_identitas" value="<?= $view['no_identitas']; ?>" readonly>
        <input type="text" name="group_cif" id="group_cif" value="<?= $view['group_cif']; ?>" readonly>
    </td>
</tr>
<tr id="nameCif" style="display:none;">
    <td>
        <label>Nama Group</label>
        <label style="text-align: right;">:</label>
    </td>
    <td><input type="text" name="group_name" id="group_name" value="<?= $custname?>" readonly></td>
</tr>
<tr>
    <td>
        <label>Status Akun Grup</label>
        <label style="text-align: right;">:</label>
    </td>
    <td>
    <input type="hidden" name="segmentid" id="segmentid" value="<?= $view['segmentid']; ?>" readonly>
    <input type="hidden" name="sts_acc_group" id="sts_acc_group" value="<?= $sts_acc_group; ?>" onchange="tampilCif()" readonly>
    <input type="text" name="sts_grup" id="sts_grup" value="<?= $sts_grup; ?>" onchange="tampilCif()" readonly>
    </td>
</tr>
<tr id="status_nasabah">
    <td>
        <label>Status Nasabah</label>
        <label style="text-align: right;">:</label>
    </td>
    <td>
        <select name="sts_nasabah" id="sts_nasabah" required>
            <?php
            $loadsts = mssql_query("SELECT paramid,nilai,parameter FROM book_segment_param WHERE keterangan='sts.nasabah' 
            AND nilai='$view[sts_nasabah]'");
            $co = mssql_fetch_assoc($loadsts); ?>
            <option name="sts_nasabah" value="<?= $co['paramid'] ?>" nilai="<?= $co['nilai'] ?>"><?= $co['parameter']; ?></option>
            <?php
            $loadstsnas = mssql_query("SELECT paramid,nilai,parameter FROM book_segment_param WHERE keterangan='sts.nasabah'");
            while ($com = mssql_fetch_assoc($loadstsnas)) { ?>
                <option name="sts_nasabah" value="<?= $com['paramid'] ?>" nilai="<?= $com['nilai'] ?>"><?= $com['parameter']; ?></option>
            <?php
            }
            ?>
        </select>
    </td>
</tr>
<input type="hidden" name="input-text" id="input-text" value="<?= $view['sts_nasabah']; ?>"></td>
<tr>
    <td>
        <label>Financing Product</label>
        <label style="text-align: right;">:</label>
    </td>
    <td>
        <select name="financing_product" id="financing_product" required>
            <?php
            $loadfin = mssql_query("SELECT nilai,parameter FROM book_segment_param WHERE keterangan='fin.product' AND nilai='$view[financing_product]'");
            $cofin = mssql_fetch_assoc($loadfin); ?>
            <option name="financing_product" value="<?= $cofin['nilai'] ?>"><?= $cofin['parameter']; ?></option>
            <?php
            $loadstsfin = mssql_query("SELECT nilai,parameter FROM book_segment_param WHERE keterangan='fin.product'");
            while ($comfin = mssql_fetch_assoc($loadstsfin)) { ?>
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
        <label style="text-align: right;">:</label>
    </td>
    <td>
        <textarea name="grup_usaha" id="grup_usaha" rows="4" cols="50" maxlength="250"><?= $view['grup_usaha']; ?></textarea>
    </td>
</tr>
<tr>
    <td>
        <label>Bidang Usaha</label>
        <label style="text-align: right;">:</label>
    </td>
    <td>
        <textarea name="bidang_usaha" id="bidang_usaha" rows="4" cols="50" maxlength="250"><?= $view['bidang_usaha']; ?></textarea>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <button type="submit" style="margin-bottom: 50px; margin-left: 5px; " name="updatePemetaan" id="updatePemetaan" class="btn btn-primary" style="font-weight: bold;">UPDATE</button>
    </td>
</tr>
</tbody>
</table>
</form>
<script>
    $(document).ready(function() {
        var selectedValue = $('#sts_nasabah').val(); // Dapatkan nilai terpilih saat halaman dimuat
        // Fungsi untuk memuat elemen dinamis
        let regid = $("input[name='regidpost']").val();
        function loadDynamicElements(selectedValue) {
            $.ajax({
                type: 'POST',
                url: "module/booking/order/creditreviewer/pemetaan_nasabah/get_data.php",
                data: {
                    selectedValue: selectedValue,
                    regid : regid,
                },
                dataType: 'html',
                success: function(data) {
                    // $('#dynamicForm').html(data);

                    // Membuat elemen <tr> baru dengan data respons

                    $('#jancok').remove();
                    var newRow = $(data);
                    // newRow.attr('id', 'jancok'); // Beri ID baru pada elemen baru
                    
                    // Memasukkan elemen <tr> baru setelah elemen dengan ID "status_nasabah"
                    $('#status_nasabah').closest('tr').after(newRow);
                }
            });
        }

        // Panggil fungsi untuk memuat elemen dinamis pada saat halaman dimuat
        loadDynamicElements(selectedValue);
        function resetView() {
        // Reset tampilan di sini sesuai kebutuhan
        // Contoh: Menghapus elemen dengan ID "jancok"
        $('#jancok').remove();
    }
        // Tambahkan event listener untuk perubahan pada select box
        $('#sts_nasabah').on('change', function() {
            var selectedValue = $(this).val();
            var selectedText = $(this).find('option:selected').attr('nilai'); // Mengambil nilai dari atribut 'nilai'
            $('#input-text').val(selectedText);
            resetView(); 
            loadDynamicElements(selectedValue);
        });
    });
</script>
<script type="text/javascript">
    document.getElementById("grup_usaha").addEventListener("input", function() {
        if (this.value.length > 250) {
            this.value = this.value.slice(0, 250);
        }
    });
    document.getElementById("bidang_usaha").addEventListener("input", function() {
        if (this.value.length > 250) {
            this.value = this.value.slice(0, 250);
        }
    });

    function tampilCif() {
        var sts_acc_group = document.getElementById("sts_acc_group").value;
        console.log("Nilai sts_acc_group:", sts_acc_group);

        var inputCif = document.getElementById("inputCif");

        if (sts_acc_group == "1") {
            inputCif.style.display = "table-row";
            nameCif.style.display = "table-row";
        } else {
            inputCif.style.display = "none";
            nameCif.style.display = "none";
        }
    }
    tampilCif();

    $(document).ready(function() {
        $(document).on("click", "button[name=updatePemetaan]", function(e) {
            e.preventDefault();
            let segmentid = $("input[name='segmentid']").val();
            let regidpost = $("input[name='regidpost']").val();
            let nikreal = $("input[name='nikreal']").val();
            let group_cif = $("input[name='group_cif']").val();
            let sts_acc_group = $("input[name='sts_acc_group']").val();
            let sts_nasabah_real = $("input[name='input-text']").val();
            let sts_nasabah = $("select[name='sts_nasabah']").val();
            let inputan = [];
            $("input[name^='inputan']").each(function() {
                inputan.push($(this).val());
            });
            let labelan = [];
            $("input[name^='labelan']").each(function() {
                labelan.push($(this).val());
            });
            let valueid = [];
            $("input[name^='valueid']").each(function() {
                valueid.push($(this).val());
            });
            let financing_product = $("select[name='financing_product']").val();
            let grup_usaha = $("textarea[name='grup_usaha']").val();
            let bidang_usaha = $("textarea[name='bidang_usaha']").val();

            if (sts_nasabah_real === '2' && inputan.some(item => item === '')) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Semua inputan harus diisi'
            });
            return;
            }

            let formData = new FormData();
            formData.append('act', 'updatePemetaan');
            formData.append('segmentid', segmentid);
            formData.append('regidpost', regidpost);
            formData.append('nikreal', nikreal);
            formData.append('group_cif', group_cif);
            formData.append('sts_acc_group', sts_acc_group);
            formData.append('sts_nasabah_real', sts_nasabah_real);
            formData.append('sts_nasabah', sts_nasabah);
            for (let i = 0; i < inputan.length; i++) {
                formData.append('inputan[]', inputan[i]);
            }
            for (let i = 0; i < labelan.length; i++) {
                formData.append('labelan[]', labelan[i]);
            }
            for (let i = 0; i < valueid.length; i++) {
                formData.append('valueid[]', valueid[i]);
            }
            formData.append('financing_product', financing_product);
            formData.append('grup_usaha', grup_usaha);
            formData.append('bidang_usaha', bidang_usaha);

            Swal.fire({
                title: 'Apakah Anda Yakin?',
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
