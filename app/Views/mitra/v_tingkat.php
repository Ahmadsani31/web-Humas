<?= $this->extend('_template/_app') ?>

<?= $this->section('contentBody') ?>
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-black">Tingkat</h1>
    <p class="mb-4">Kelola data tingkat</p>

    <!-- DataTales Example -->
    <div class="card border-left-success shadow mb-4">
        <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Datatable Tingkat</h6>
            <button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm modal-cre" id="add-tingkat" tingkatid="0" judul="Tambah data Tingkat"><i class="fas fa-upload fa-sm text-white-50"></i> Tambah Data</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered text-black" id="Dtabel" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
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
    var Dtabel = $("#Dtabel").DataTable({
        ajax: {
            url: "<?= base_url(); ?>/datatable",
            type: "POST",
            data: function(d) {
                d.datatable = 'tingkat';
            },
        },
        columnDefs: [{
            className: "align-middle text-center",
            targets: ['_all'],
        }, {
            searchable: false,
            orderable: false,
            targets: 0,
        }, {
            targets: -1,
            data: "aksi",
            searchable: false,
            orderable: false,
            render: function(data) {

                btn = '<button class="btn btn-sm btn-primary btn-sm modal-cre mr-1 mb-1" tingkatid="' + data.TingkatID + '" id="add-tingkat" Judul="Update data tingkat"><i class="fas fa-edit"></i></button>&nbsp;';
                btn += '<button class="btn btn-sm btn-danger btn-sm mr-1 mb-1 modal-hapus-cre" id="' + data.TingkatID + '" table="kerma_tingkat"><i class="fas fa-trash"></i></button>&nbsp;';
                return btn;
            },
        }],
        columns: [{
            data: null,
        }, {
            data: "Nama",
        }, {
            data: null,
        }],
    });
    //nomor otomatis colomn 0

    Dtabel.on("order.dt search.dt", function() {
        Dtabel.column(0, {
            search: "applied",
            order: "applied",
        }).nodes().each(function(cell, i) {
            cell.innerHTML = i + 1 + ".";
        });
    }).draw();
</script>
<?= $this->endSection() ?>