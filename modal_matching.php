<?php
include("../../../../../include/fungsi.php");
include("../../../../../include/dbconfig.php");
$nik = $_SESSION['nik'];
$no_identitas = $_POST["no_identitas"];
?>

<!-- CSS Custom Remove Border Icon SweetAlert2 -->
<style>
    .no-border {
        border: 0;
    }
</style>
<!-- CSS Custom Remove Border Icon SweetAlert2 -->


<!-- CSS Custom Card Boostraps -->
<style>
    .custom-card {
        cursor: pointer;
        transition: box-shadow 0.3s ease;
    }

    .custom-card.selected {
        /* Mengatur warna shadow menjadi merah ketika dipilih */
        box-shadow: 0px 0px 20px 0px rgba(255, 0, 0, 0.75);
    }

    .card {
        position: relative;
        display: flex;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: #fff;
        background-clip: border-box;
        border: 1px solid rgba(0, 0, 0, 0.125);
        border-radius: 0.25rem;
    }

    .card>hr {
        margin-right: 0;
        margin-left: 0;
    }

    .card>.list-group {
        border-top: inherit;
        border-bottom: inherit;
    }

    .card>.list-group:first-child {
        border-top-width: 0;
        border-top-left-radius: calc(0.25rem - 1px);
        border-top-right-radius: calc(0.25rem - 1px);
    }

    .card>.list-group:last-child {
        border-bottom-width: 0;
        border-bottom-right-radius: calc(0.25rem - 1px);
        border-bottom-left-radius: calc(0.25rem - 1px);
    }

    .card>.card-header+.list-group,
    .card>.list-group+.card-footer {
        border-top: 0;
    }

    .card-body {
        flex: 1 1 auto;
        padding: 1rem 1rem;
    }

    .card-title {
        margin-bottom: 0.5rem;
    }

    .card-subtitle {
        margin-top: -0.25rem;
        margin-bottom: 0;
    }

    .card-text:last-child {
        margin-bottom: 0;
    }

    .card-link+.card-link {
        margin-left: 1rem;
    }

    .card-header {
        padding: 0.5rem 1rem;
        margin-bottom: 0;
        background-color: rgba(0, 0, 0, 0.03);
        border-bottom: 1px solid rgba(0, 0, 0, 0.125);
    }

    .card-header:first-child {
        border-radius: calc(0.25rem - 1px) calc(0.25rem - 1px) 0 0;
    }

    .card-footer {
        padding: 0.5rem 1rem;
        background-color: rgba(0, 0, 0, 0.03);
        border-top: 1px solid rgba(0, 0, 0, 0.125);
    }

    .card-footer:last-child {
        border-radius: 0 0 calc(0.25rem - 1px) calc(0.25rem - 1px);
    }

    .card-header-tabs {
        margin-right: -0.5rem;
        margin-bottom: -0.5rem;
        margin-left: -0.5rem;
        border-bottom: 0;
    }

    .card-header-pills {
        margin-right: -0.5rem;
        margin-left: -0.5rem;
    }

    .card-img-overlay {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        padding: 1rem;
        border-radius: calc(0.25rem - 1px);
    }

    .card-img,
    .card-img-top,
    .card-img-bottom {
        width: 100%;
    }

    .card-img,
    .card-img-top {
        border-top-left-radius: calc(0.25rem - 1px);
        border-top-right-radius: calc(0.25rem - 1px);
    }

    .card-img,
    .card-img-bottom {
        border-bottom-right-radius: calc(0.25rem - 1px);
        border-bottom-left-radius: calc(0.25rem - 1px);
    }

    .card-group>.card {
        margin-bottom: 0.75rem;
    }

    @media (min-width: 576px) {
        .card-group {
            display: flex;
            flex-flow: row wrap;
        }

        .card-group>.card {
            flex: 1 0 0%;
            margin-bottom: 0;
        }

        .card-group>.card+.card {
            margin-left: 0;
            border-left: 0;
        }

        .card-group>.card:not(:last-child) {
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }

        .card-group>.card:not(:last-child) .card-img-top,
        .card-group>.card:not(:last-child) .card-header {
            border-top-right-radius: 0;
        }

        .card-group>.card:not(:last-child) .card-img-bottom,
        .card-group>.card:not(:last-child) .card-footer {
            border-bottom-right-radius: 0;
        }

        .card-group>.card:not(:first-child) {
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
        }

        .card-group>.card:not(:first-child) .card-img-top,
        .card-group>.card:not(:first-child) .card-header {
            border-top-left-radius: 0;
        }

        .card-group>.card:not(:first-child) .card-img-bottom,
        .card-group>.card:not(:first-child) .card-footer {
            border-bottom-left-radius: 0;
        }
    }
</style>
<!-- CSS Custom Card Boostraps -->


<!-- CSS Custom Scroll Modal -->
<style>
    .modal-body {
        height: 200px;
        overflow-y: auto;
    }

    @media (min-height: 500px) {
        .modal-body {
            height: 230px;
        }
    }

    @media (min-height: 800px) {
        .modal-body {
            height: 450px;
        }
    }
</style>
<!-- CSS Custom Scroll Modal -->


<style>
    .hrtop {
        border: 2px solid #111F82;
        /* margin: 0 30px; */
    }

    .btn-more {
        border-radius: 20px;
        padding: 10px;

    }

    .pilih {
        background-color: #007ADF;
        color: white;
    }

    #durasiDinamis {
        padding: 5px;
        padding-left: 8px;
    }

    #durasiStatis {
        padding: 5px;
        padding-left: 8px;
    }

    .opacity:hover {
        background-color: #f2f2f2;
        color: black;

    }
</style>

<div class="modal-dialog modal-dialog-scrollable" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action="" name="" method="POST" enctype="">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row">
                    <div class="col-xl-11 col-lg-11">
                        <h2 class="modal-title" style="font-weight: 700; color:#0D062D;">LIST ACCOUNT AKTIF</h2>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity: 1;">
                            <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 100 100">
                                <path d="M36.89,120.49c-3-3.28-6.06-6.18-8.53-9.54-2.32-3.16,1.47-4.27,2.92-5.76,9-9.32,18.16-18.58,27.55-27.54,3.37-3.21,3.3-5.18,0-8.34C49.64,60.5,41,51.07,31.64,42.48c-4.62-4.24-3.82-6.65.28-10.39,3.6-3.28,5.73-6,10.41-.77C51,41,60.66,49.71,69.66,59.07c3,3.1,4.82,3,7.76,0,8.83-9.18,18.27-17.78,26.82-27.2,4.46-4.92,6.86-4,11,.25,3.84,4,4.8,6.23.19,10.45-9.38,8.6-18,18-27.2,26.82-3.36,3.21-3.28,5.13,0,8.31,9.38,9,18.1,18.65,27.71,27.36,5,4.52,2.45,6.72-.9,9.83-3,2.82-5,6.62-9.8,1.31-8.88-9.79-18.71-18.72-27.88-28.26-3-3.14-4.84-3-7.76.07-9.18,9.53-18.65,18.79-28,28.13C40.38,117.32,39.09,118.45,36.89,120.49Z" transform="translate(-27.62 -28.4)" fill="#f34336" />
                            </svg>
                        </button>
                    </div>

                </div>
                <hr class="hrtop">

                <div class="modal-body">
                    <?php
                    $no = 1;
                    $loadmatch = mssql_query("exec book_segment_matching_new $no_identitas");
                    // var_dump($loadmatch);

                    if (mssql_num_rows($loadmatch) > 0) {
                        while ($views = mssql_fetch_assoc($loadmatch)) {
                    ?>
                            <form id="grup_cif_form">
                                <div class="card custom-card" style="margin-top: 0px; margin-bottom:10px; border-color: #428bca;">
                                    <a onclick="ambil_CIFGroup(event)" class="card-block stretched-link" style=" text-decoration:none;">
                                        <div class="card-header" style="background-color: #428bca; color:#fff">
                                            <span style="text-align: left;"><?= $no++ ?></span>
                                        </div>
                                        <div class="card-body" style=" color:black">
                                            <p class="card-text">
                                            <div class="row">
                                                <div class="col-sm-2">
                                                    <span style="text-align: left;">Reg ID</span>
                                                </div>
                                                <div class="col-sm-3">
                                                    <span>: <?= $views['regid']; ?> </span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-2">
                                                    <span style="text-align: left;">CIF Group</span>
                                                </div>
                                                <div class="col-sm-3">
                                                    <input type="hidden" class="form-control" id="custid" value="<?= $views['custid']; ?>" readonly>
                                                    <span style="text-align: left;">: <?= $views['custid']; ?></span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-2">
                                                    <input type="hidden" class="form-control" id="custname" value="<?= $views['custname']; ?>" readonly>
                                                    <span style="text-align: left;">Nama</span>
                                                </div>
                                                <div class="col-sm-3">
                                                    <span style="text-align: left;">: <?= $views['custname']; ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </form>
                        <?php }
                    } else {
                        ?>
                        <script>
                            // START Custom Icon SweetAlert2
                            $(document).ready(function() {
                                Swal.fire({
                                    title: 'Data Tidak Ditemukan',
                                    iconHtml: '<svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" width="100px height=100px" viewBox="0 0 114.02 126.95"><path d="M98.65,70.51A33,33,0,1,1,65.6,103.23,33.06,33.06,0,0,1,98.65,70.51Z" transform="translate(-17.53 -9.53)" fill="#fe5a5a"/><path d="M69.29,130.48c-13,0-25.52.19-38-.07-8.26-.18-13.59-5.52-13.64-13.83q-.26-40.08,0-80.18c.06-8.6,5.56-13.69,14.38-13.84,5.24-.08,9.25.09,12.51-6.12,4.82-9.19,37.13-9.22,42-.06,3.26,6.13,7.18,6.13,12.49,6.2,9.17.11,14.29,5.31,14.48,14.51.18,8.24.19,16.49-.09,24.73,0,1.51,2.17,5.31-2.17,4.63-2.83-.44-6.9,0-6.73-5.11.2-6.24.21-12.49,0-18.73-.14-3.75,1.91-9.19-3.12-10.46s-10.79-2.26-15.78,1.2c-8.79,6.09-31,5.87-40.37-.22-5-3.25-10.77-2.29-15.81-.83-4.55,1.33-2.77,6.41-2.79,9.94-.12,23.23-.07,46.46-.05,69.69,0,9.27.31,9.54,9.85,9.57,6.25,0,12.55.53,18.72-.14C62.15,120.6,66.52,123.09,69.29,130.48Z" transform="translate(-17.53 -9.53)" fill="#fe5a5a"/><path d="M65.07,61.49c-6.74,0-13.48,0-20.23,0-3.34,0-6.26-.83-6.06-4.82.17-3.48,2.93-4.19,5.95-4.19q21,0,42,0c3.07,0,5.66.94,5.7,4.44s-2.5,4.54-5.59,4.55Z" transform="translate(-17.53 -9.53)" fill="#fe5a5a"/><path d="M76.1,70.52c-9.58,14.22-22.75,7.68-34.22,8.54-1.89.14-3.4-2.13-3.09-4.42.39-3,2.48-4.11,5.29-4.11C54.43,70.51,64.78,70.52,76.1,70.52Z" transform="translate(-17.53 -9.53)" fill="#fe5b5b"/><path d="M61.56,88.53c.4,6.82-2.08,10.06-9,9-2.92-.43-6,0-8.93-.14S38.77,96,38.8,93s2.12-4.36,5-4.4C49.69,88.48,55.62,88.53,61.56,88.53Z" transform="translate(-17.53 -9.53)" fill="#fe5c5c"/><path d="M113.26,121.64c-1.35-1.09-2.54-2-3.61-3-3.65-3.35-7-9-11-9.5-4.31-.52-7.1,6.11-10.9,9.25-.57.48-1.07,1-1.62,1.55-1.43,1.28-2.93,2-4.55.34s-.7-3.21.6-4.54c3-3,5.83-6.18,9-9,2.69-2.38,2.8-4.17,0-6.57-3-2.61-5.72-5.57-8.49-8.44-1.38-1.42-3.11-3-1.15-5.07s3.6-.65,5.07.78a91.25,91.25,0,0,1,7.89,8c3.07,3.86,5.35,3.18,8.21-.22a112.55,112.55,0,0,1,8.47-8.45c1.16-1.12,2.57-1.63,4-.41,1.73,1.47,1.37,3.08,0,4.52-3.12,3.23-6.19,6.52-9.5,9.55-2.39,2.18-2.48,3.82,0,6,3.32,3,6.38,6.32,9.51,9.54,1.11,1.15,1.77,2.56.59,4A10.26,10.26,0,0,1,113.26,121.64Z" transform="translate(-17.53 -9.53)" fill="#fefdfd"/><path d="M65,28.34c-3.48,0-7,.22-10.43-.07a4,4,0,0,1-3.79-4.66,3.89,3.89,0,0,1,3.82-3.9c7.2-.17,14.42-.2,21.62-.05A4,4,0,0,1,80.38,24a4.08,4.08,0,0,1-4.19,4.33c-3.72.2-7.46,0-11.19,0Z" transform="translate(-17.53 -9.53)" fill="#fefcfc"/></svg>',
                                    customClass: {
                                        icon: 'no-border'
                                    }
                                }).then((result) => {
                                    // Akan dijalankan setelah pengguna menekan OK
                                    if (result.isConfirmed) {
                                        // Tutup modal atau lakukan aksi lainnya di sini
                                        $('#create').modal('hide');
                                    }
                                });
                            });
                            // END Custom Icon SweetAlert2
                        </script>
                    <?php
                    }

                    ?>
                </div>
            </div>

            <div class="modal-footer text-center">
                <div class="row" class="col text-center d-flex justify-content-center">
                    <button type="button" style="border-radius: 0px;" class="btn btn-lg btn-block btn-primary font-weight-bold" data-dismiss="modal" id="matching">PILIH ACCOUNT</button>
                </div>
            </div>
        </div>
</div>
</form>
</div>
<script>
    function ambil_CIFGroup(event) {
        // Ambil nilai input dari kartu yang diklik
        const nilaiInput = event.currentTarget.querySelector('#custid').value;
        const nilaiInputName = event.currentTarget.querySelector('#custname').value;
        const cards = document.querySelectorAll('.custom-card');

        cards.forEach(function(card) {
            card.addEventListener('click', function(event) {
                // Menghapus kelas 'selected' dari semua kartu
                cards.forEach(function(card) {
                    card.classList.remove('selected');
                });

                // Menambahkan kelas 'selected' pada kartu yang diklik
                card.classList.add('selected');

                // Lakukan operasi dengan nilai input (misalnya, tampilkan dalam alert)
                // console.log('Data diambil: ' + nilaiInput);
                // console.log('Data diambil: ' + nilaiInputName);

                // Ambil nilai input dari kartu yang diklik
                selectedValue = event.currentTarget.querySelector('#custid').value;
                selectedValue2 = event.currentTarget.querySelector('#custname').value;
            });
        });
    }


    $("#matching").click(function(e) {
        e.preventDefault();
        var custidmodal = selectedValue;
        var custnamemodal = selectedValue2;
        var sts_acc_group = "1";
        var sts_grup = "GROUP";

        $.ajax({
            url: "module/booking/order/creditreviewer/pemetaan_nasabah/form_group_cif.php?a=" + custid,
            method: "POST",
            data: {
                custid: custidmodal,
                custname: custnamemodal,
                sts_acc_group: sts_acc_group,
                // sts_grup : sts_grup
            },
            cache: false,
            success: function(response) {
                $('#create').modal('hide');
                console.log('ini custid :' + custidmodal)
                console.log('ini custnmae :' + custnamemodal)
                $('#group_cif').val(custidmodal);
                $('#group_name').val(custnamemodal);
                $('#sts_acc_group').val(sts_acc_group);
                $('#sts_grup').val(sts_grup);
                tampilCif();
            }
        })
    })
</script>