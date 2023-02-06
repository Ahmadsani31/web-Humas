<?= $this->extend('_template/_app') ?>

<?= $this->section('contentBody') ?>
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-black">Kerja Sama</h1>
    <p class="mb-4">Kelola data Kerja Sama</p>
    <!-- DataTales Example -->
    <div class="card border-left-success shadow h-100 mb-4">
        <div class="card-header py-3 ">
            <div class="row  mt-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <select class="form-control" id="MitraID">
                            <option value="">[Jenis Mitra]</option>
                            <?= App\Libraries\Library::Option('mitra', 'MitraID', '', 'Nama'); ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <select class="form-control" id="JenisDokumenID">
                            <option value="">[Jenis Dokument]</option>
                            <?= App\Libraries\Library::OptCreate(['MOU', 'MOA', 'IA'], ['MOU', 'MOA', 'IA'], ''); ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <select class="form-control" id="TingkatID">
                            <option value="">[Tingkat]</option>
                            <?= App\Libraries\Library::Option('kerma_tingkat', 'TingkatID', '', 'Nama'); ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <select class="form-control" id="UnitID">
                            <option value="">[Unit]</option>
                            <?= Option2('simpeg_posisi_jabatan', 'PosisiID', '', 'Nama', 'WHERE a.NA="N"'); ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <select class="form-control" id="StatusID">
                            <option value="">[Status]</option>
                            <?= App\Libraries\Library::OptCreate(['STA', 'STB', 'STC'], ['Akan Mulai', 'Sedang Berjalan', 'Expired'], ''); ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <button class="btn-block btn btn-sm btn-primary shadow-sm modal-cre" id="add-kerma" kermaid="0" judul="Tambah data kerma"><i class="fas fa-upload fa-sm text-white-50"></i> Tambah Data</button>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered text-black" id="Dtabel" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No Dokumen</th>
                            <th>Jenis Dokumen</th>
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

    $("#MitraID").change(function() {
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
                d.MitraID = $('#MitraID').val();
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
            data: "JenisDokumenID",
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
            data: "NamaLingkup",
        }, {
            data: "JudulKegiatan",
        }, {
            data: "Manfaat",
        }, {
            data: "PeranKontribusi",
        }, {
            data: 'Button',
        }],
    });
</script>
<?= $this->endSection() ?>