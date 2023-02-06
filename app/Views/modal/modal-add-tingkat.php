<?php
helper('query_helper');
$Nama  = '';
$TingkatID =  $_POST['tingkatid'];
if (!empty($TingkatID)) {
    $qeu = querySelect('', 'kerma_tingkat', 'NA="N" AND TingkatID="' . $TingkatID . '"')->getRow();
    $Nama  = $qeu->Nama;
}
?>

<form action="<?= route_to('save.tingkat'); ?>" method="post" id="form-acara">
    <?= csrf_field() ?>
    <div class="modal-body pb-0">
        <div class="form-group">
            <label class="text-black">Nama</label>
            <input type="text" name="Nama" class="form-control" value="<?= $Nama; ?>" placeholder="Nama">
        </div>
    </div>
    <input type="hidden" name="TingkatID" value="<?= $TingkatID; ?>">
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