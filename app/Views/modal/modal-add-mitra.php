<?php

use App\Libraries\Library;

$Nama = '';
$JenisMitraID = '';
$TingkatID = '';
$Kontak = '';
$Alamat = '';

$MitraID =  $_POST['mitraid'];
if (!empty($MitraID)) {
    $qeu = querySelect('', 'mitra', 'NA="N" AND MitraID="' . $MitraID . '"')->getRow();
    $Nama = $qeu->Nama;
    $JenisMitraID = $qeu->JenisMitraID;
    $TingkatID = $qeu->TingkatID;
    $Kontak = $qeu->Kontak;
    $Alamat = $qeu->Alamat;
}
?>

<form action="<?= route_to('save.mitra'); ?>" method="post" id="form-acara">
    <?= csrf_field() ?>
    <div class="modal-body pb-0">
        <div class="form-group">
            <label class="text-black">Nama</label>
            <input type="text" name="Nama" class="form-control" value="<?= $Nama; ?>" placeholder="Nama">
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="" class="text-black">Jenis Mitra</label>
                    <select name="JenisMitraID" id="JenisMitraID" class="form-control">
                        <option value="">[Pilih]</option>
                        <?= Library::Option('mitra_jenis', 'JenisMitraID', $JenisMitraID, 'Nama'); ?>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="" class="text-black">Tingkatan</label>
                    <select name="TingkatID" id="TingkatID" class="form-control">
                        <option value="">[Pilih]</option>
                        <?= Library::Option('kerma_tingkat', 'TingkatID', $TingkatID, 'Nama'); ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="text-black">Kontak</label>
            <input type="text" name="Kontak" class="form-control" value="<?= $Kontak; ?>" placeholder="Kontak">
        </div>
        <div class="form-group">
            <label class="text-black">Alamat</label>
            <textarea class="form-control" name="Alamat" rows="4"><?= $Alamat; ?></textarea>
        </div>
    </div>
    <input type="hidden" name="MitraID" value="<?= $MitraID; ?>">
    <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" id="simpanData" class="btn btn-sm btn-primary">Simpan Data</button>
    </div>
</form>
<script>
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
</script>