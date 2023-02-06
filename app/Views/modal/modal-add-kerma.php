<?php

$Nama = '';
$TingkatID = '';
$Manfaat = '';
$JudulKegiatan = '';
$LingkupID = '';
$BidangID = '';
$PeranKontribusi = '';
$JenisDokumenID = '';
$UnitID = '';
$UnitTerkaitID = '';
$TglMulai = '';
$TglSelesai = '';
$FileDokumen = 'Pilih file . . .';
$href = '';
$class = 'danger';
$required = 'required';
$NoDokumen = '';
$MitraID = '';
$KermaID =  $_POST['kermaid'];
if (!empty($KermaID)) {
    $qeu = querySelect('', 'kerma', 'NA="N" AND KermaID="' . $KermaID . '"')->getRow();
    $TingkatID = $qeu->TingkatID;
    $BidangID = $qeu->BidangID;
    $LingkupID = $qeu->LingkupID;
    $JudulKegiatan = $qeu->JudulKegiatan;
    $Manfaat = $qeu->Manfaat;
    $PeranKontribusi = $qeu->PeranKontribusi;
    $JenisDokumenID = $qeu->JenisDokumenID;
    $UnitID = $qeu->UnitID;
    $UnitTerkaitID = $qeu->UnitTerkaitID;
    $TglMulai = $qeu->TglMulai;
    $TglSelesai = $qeu->TglSelesai;
    $FileDokumen = $qeu->FileDokumen;
    $MitraID = $qeu->MitraID;
    $NoDokumen = $qeu->NoDokumen;

    $class = 'danger';
    $required = '';
    $href = base_url() . '/assets/files/document/' . $JenisDokumenID . '/' . $FileDokumen;
    if ($FileDokumen) {
        $class = 'primary';
    }
}


?>

<form action="<?= route_to('save.kerma'); ?>" method="post" id="form-acara">
    <?= csrf_field() ?>
    <div class="modal-body pb-0">
        <div class="form-group">
            <label for="" class="text-black">Nomor Dokumen</label>
            <input type="text" name="NoDokumen" class="form-control" value="<?= $NoDokumen; ?>" placeholder="nomor dokumen">
        </div>
        <div class="form-group">
            <label for="" class="text-black">Jenis Dokument</label>
            <select name="JenisDokumenID" id="JenisDokumenID" class="form-control select2-aksi" style="width: 100%;">
                <option value="">[Pilih]</option>
                <?= App\Libraries\Library::OptCreate(['MOU', 'MOA', 'IA'], ['MOU', 'MOA', 'IA'], $JenisDokumenID); ?>
            </select>
        </div>
        <div class="form-group">
            <label class="text-black">Judul Kegiatan</label>
            <textarea name="JudulKegiatan" id="" class="form-control" cols="30" rows="2" placeholder="Kegiatan kerma"><?= $JudulKegiatan; ?></textarea>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="" class="text-black">Unit</label>
                    <select name="UnitID" id="UnitID" class="form-control select2-aksi" style="width: 100%;">
                        <option value="">[Pilih]</option>
                        <?= Option2('simpeg_posisi_jabatan', 'PosisiID', $UnitID, 'Nama', 'WHERE a.NA="N"'); ?>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="" class="text-black">Unit Terkait Lainnya</label>
                    <select name="UnitTerkaitID[]" id="UnitTerkaitID" class="form-control select2-aksi" multiple="multiple" style="width: 100%;">
                        <option value="">[Pilih]</option>
                        <?= Option2Multiple('simpeg_posisi_jabatan', 'PosisiID', $UnitTerkaitID, 'Nama', 'WHERE a.NA="N"'); ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="" class="text-black">Tanggal Mulai</label>
                    <input type="text" name="TglMulai" class="form-control tanggal" value="<?= $TglMulai; ?>" placeholder="Tanggal mulai">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="" class="text-black">Tanggal Selesai</label>
                    <input type="text" name="TglSelesai" class="form-control tanggal" value="<?= $TglSelesai; ?>" placeholder="Tanggal selesai">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="" class="text-black">Mitra</label>
                    <select name="MitraID" id="MitraID" class="form-control select2-aksi" style="width: 100%;">
                        <option value="">[Pilih]</option>
                        <?= Option('mitra', 'MitraID', $MitraID, 'Nama'); ?>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="" class="text-black">Tingkatan</label>
                    <select name="TingkatID" id="TingkatID" class="form-control select2-aksi" style="width: 100%;">
                        <option value="">[Pilih]</option>
                        <?= Option('kerma_tingkat', 'TingkatID', $TingkatID, 'Nama'); ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="" class="text-black">Bidang</label>
                    <select name="BidangID" id="BidangID" class="form-control select2-aksi" style="width: 100%;">
                        <option value="">[Pilih]</option>
                        <?= Option('kerma_bidang', 'BidangID', $BidangID, 'Nama'); ?>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="" class="text-black">Ruang Lingkup</label>
                    <select name="LingkupID[]" id="LingkupID" class="form-control select2-aksi" multiple="multiple" style="width: 100%;">
                        <option value="">[Pilih]</option>
                        <?= Option2Multiple('kerma_ruang_lingkup', 'LingkupID', $LingkupID, 'Nama'); ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="text-black">Peran Kontribusi</label>
            <textarea class="form-control" name="PeranKontribusi" rows="2" placeholder="Peran kontribusi kerma"><?= $PeranKontribusi; ?></textarea>
        </div>
        <div class="form-group">
            <label class="text-black">Manfaat</label>
            <textarea class="form-control" name="Manfaat" rows="2" placeholder="Manfaat kerma"><?= $Manfaat; ?></textarea>
        </div>
        <div class="form-group">
            <div class="input-group is-invalid">
                <div class="custom-file">
                    <input type="file" name="FileDokumen" class="custom-file-input" id="validatedInputGroupCustomFile" <?= $required; ?>>
                    <label class="custom-file-label" for="validatedInputGroupCustomFile"><?= $FileDokumen; ?></label>
                </div>
                <div class="input-group-append">
                    <a href="<?= $href; ?>" class="btn btn-sm btn-<?= $class; ?>"><i class="fa fa-file-pdf p-1"></i></a>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="KermaID" value="<?= $KermaID; ?>">
    <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" id="simpanData" class="btn btn-sm btn-primary">Simpan Data</button>
    </div>
</form>
<script>
    $(document).ready(function() {
        bsCustomFileInput.init()
    })
    $(document).ready(function() {
        $('#form-acara').submit(function(e) {
            e.preventDefault();
            var form = this;
            $.ajax({
                url: $(form).attr('action'),
                method: $(form).attr('method'),
                enctype: 'multipart/form-data',
                data: new FormData(form),
                processData: false,
                contentType: false,
                cache: false,
                success: function(data, textStatus) {
                    Dtabel.ajax.reload(null, false);
                    if (data.param > 0) {
                        $("#myModals").modal("hide");
                        Swal.fire({
                            icon: 'success',
                            title: textStatus,
                            text: data.pesan,
                            showConfirmButton: false,
                            timer: 1500
                        })
                    } else {
                        var pesan = '';
                        Object.keys(data.pesan).forEach(function(key) {
                            pesan += data.pesan[key] + ", ";
                        });
                        Swal.fire({
                            icon: 'error',
                            title: 'Kesalahan !',
                            text: pesan,
                        })
                    }
                    // console.log(data);
                    // console.log(textStatus);
                },
                error: function(jqXHR, textStatus, error) {
                    Swal.fire({
                        icon: textStatus,
                        title: 'Kesalahan !',
                        text: jqXHR.responseJSON.message,
                    })
                }
            })
        });
    });

    // $('#UnitTerkaitID').select2({
    //     placeholder: '--- Search User ---',
    //     ajax: {
    //         method: 'POST',
    //         url: '<?php echo base_url('select2/simpeg_posisi_jabatan'); ?>',
    //         dataType: 'json',
    //         delay: 250,
    //         processResults: function(data) {
    //             return {
    //                 results: data
    //             };
    //         },
    //         cache: true
    //     }
    // });
    $('.select2-aksi').select2({});
    $('.tanggal').datetimepicker({
        "allowInputToggle": true,
        "showClose": true,
        "showClear": true,
        "showTodayButton": true,
        "format": "YYYY-MM-DD",
    });
</script>