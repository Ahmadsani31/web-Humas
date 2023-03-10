<?= $this->extend('_template/_app') ?>

<?= $this->section('contentBody') ?>
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-black">Kerja Sama</h1>
    <p class="mb-4">Kelola data Kerja Sama</p>
    <!-- DataTales Example -->
    <div class="card border-left-success shadow h-100 mb-4">
        <!-- <?php
                // if (session()->getFlashdata()) {
                //     if (session()->getFlashdata('success')) {
                //         echo '<div class="alert alert-info mt-4 ml-3 mr-3">';
                //         echo  session()->getFlashdata('success');
                //         echo '</div>';
                //     } elseif (session()->getFlashdata('errors')) {
                //         echo '<div class="alert alert-danger bg-danger border-0 alert-dismissible fade show mt-4 ml-3 mr-3">';
                //         echo '<ul class="mt-0 mb-0" style="color:#FFF;">';
                //         foreach (session()->getFlashdata('errors') as $key => $pesan) {
                //             echo '<li>' . $pesan . '</li>';
                //         }
                //         echo '</ul>';
                //         echo '</div>';
                //     }
                // }
                ?>
        <div class="card-header">
            <form action="<?= route_to('kerma/importExcel'); ?>" method="post" enctype="multipart/form-data">
                <input type="file" name="FileExcel">
                <button type="submit" class="btn btn-sm btn-secondary">Upload Excel</button>
                <a href="#" class="badge badge-info"><i class="fa fa-download"></i> Download Format Upload Excel</a>
            </form>
        </div> -->
        <div class="card-header py-3 ">
            <form id="formKerma" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="row  mt-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <select class="form-control" name="JenisMitraID" id="JenisMitraID">
                                <option value="">[Jenis Mitra]</option>
                                <?= App\Libraries\Library::Option('mitra_jenis', 'JenisMitraID', '', 'Nama'); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <select class="form-control" name="JenisDokumenID" id="JenisDokumenID">
                                <option value="">[Jenis Dokument]</option>
                                <?= Option('jenis_dokument', 'DokumentID', '', 'Nama'); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <select class="form-control" name="TingkatID" id="TingkatID">
                                <option value="">[Tingkat]</option>
                                <?= App\Libraries\Library::Option('kerma_tingkat', 'TingkatID', '', 'Nama'); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <select class="form-control" name="UnitID" id="UnitID">
                                <option value="">[Unit]</option>
                                <?= Option2('simpeg_posisi_jabatan', 'PosisiID', '', 'Nama', 'WHERE a.NA="N"'); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <select class="form-control" name="StatusID" id="StatusID">
                                <option value="">[Status]</option>
                                <?= App\Libraries\Library::OptCreate(['STA', 'STB', 'STC'], ['Akan Mulai', 'Sedang Berjalan', 'Expired'], ''); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <button type="button" class="btn-block btn btn-sm btn-primary shadow-sm modal-cre" id="add-kerma" kermaid="0" judul="Tambah data kerma"><i class="fas fa-upload fa-sm text-white-50"></i> Tambah Data</button>
                    </div>
                    <div class="col">
                        <button type="button" onclick="lapAkreditas()" class="btn-block btn btn-sm btn-info shadow-sm"><i class="fas fa-upload fa-sm text-white-50"></i> Laporan Akreditasi</button>
                    </div>
                    <div class="col">
                        <button type="button" onclick="lapLldikti()" class="btn-block btn btn-sm btn-info shadow-sm"><i class="fas fa-upload fa-sm text-white-50"></i> Laporan LLDIKTI X</button>
                    </div>
                    <div class="col">
                        <button type="button" onclick="lapMatriks()" class="btn-block btn btn-sm btn-info shadow-sm"><i class="fas fa-upload fa-sm text-white-50"></i> Laporan Matriks</button>
                    </div>
                </div>

            </form>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered text-black" id="Dtabel" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No Dokumen</th>
                            <th>Jenis Dokumen</th>
                            <th>Mitra</th>
                            <th>Tingkat</th>
                            <th>Jenis Mitra</th>
                            <th>Unit</th>
                            <th>Unit Terkait</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Status</th>
                            <th>Bidang</th>
                            <th>Ruang Lingkup</th>
                            <th>Judul</th>

                            <th>Manfaat</th>
                            <th>PeranKontribusi</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<?= $this->endSection() ?>
<?= $this->section('contentJS') ?>
<script type="text/javascript">
    var Dtabel;

    $("#JenisMitraID").change(function() {
        Dtabel.ajax.reload(null, false);

    });
    $("#JenisDokumenID").change(function() {
        Dtabel.ajax.reload(null, false);
    });
    $("#TingkatID").change(function() {
        Dtabel.ajax.reload(null, false);
    });
    $("#UnitID").change(function() {
        Dtabel.ajax.reload(null, false);
    });
    $("#StatusID").change(function() {
        Dtabel.ajax.reload(null, false);
    });


    var Dtabel = $('#Dtabel').DataTable({
        processing: true,
        serverSide: true,
        order: [], //init datatable not ordering
        ajax: {
            url: '<?php echo site_url('server-side') ?>',
            method: 'POST',
            data: function(d) {
                d.datatable = 'kerma';
                d.JenisMitraID = $('#JenisMitraID').val();
                d.JenisDokumenID = $('#JenisDokumenID').val();
                d.TingkatID = $('#TingkatID').val();
                d.UnitID = $('#UnitID').val();
                d.StatusID = $('#StatusID').val();
            },
        },
        columnDefs: [{
            className: "align-middle text-center",
            targets: ['_all'],
        }, {
            searchable: false,
            orderable: false,
            targets: 0,
        }],
        columns: [{
            data: "no",
        }, {
            data: "NoDokumen",
        }, {
            data: "JenisDokumen",
        }, {
            data: "NamaMitra",
        }, {
            data: "NamaTingkat",
        }, {
            data: "NamaJenisMitra",
        }, {
            data: "UnitID",
        }, {
            data: "UnitTerkaitID",
        }, {
            data: "TglMulai",
        }, {
            data: "TglSelesai",
        }, {
            data: "Status",
        }, {
            data: "NamaBidang",
        }, {
            data: "LingkupID",
        }, {
            width: "20%",
            data: "JudulKegiatan",
        }, {
            data: "Manfaat",
        }, {
            data: "PeranKontribusi",
        }, {
            data: 'Button',
        }],
    });

    function lapAkreditas() {

        var form = $("#formKerma")[0];

        $.ajax({
            url: "<?= route_to('kerma-cetak.akreditasi'); ?>",
            method: 'POST',
            enctype: 'multipart/form-data',
            data: new FormData(form),
            processData: false,
            contentType: false,
            cache: false,
            success: function(data, textStatus) {

                window.open('data:application/vnd.ms-excel,' + encodeURIComponent(data));
                // window.open(data);
            },
        })
    }

    function lapLldikti() {

        var form = $("#formKerma")[0];

        $.ajax({
            url: "<?= route_to('kerma-cetak.lldikti'); ?>",
            method: 'POST',
            enctype: 'multipart/form-data',
            data: new FormData(form),
            processData: false,
            contentType: false,
            cache: false,
            success: function(data, textStatus) {
                window.open('data:application/vnd.ms-excel,' + encodeURIComponent(data));
                // window.open(data);
            },
        })
    }

    function lapMatriks() {

        var form = $("#formKerma")[0];

        $.ajax({
            url: "<?= route_to('kerma-cetak.matriks'); ?>",
            method: 'POST',
            enctype: 'multipart/form-data',
            data: new FormData(form),
            processData: false,
            contentType: false,
            cache: false,
            success: function(data, textStatus) {
                window.open('data:application/vnd.ms-excel,' + encodeURIComponent(data));
                // window.open(data);
            },
        })
    }
</script>
<?= $this->endSection() ?>