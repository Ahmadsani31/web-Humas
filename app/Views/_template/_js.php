    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url('assets'); ?>/vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url('assets'); ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url('assets'); ?>/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url('assets'); ?>/js/sb-admin-2.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="<?= base_url('assets'); ?>/js/extend.js"></script>

    <!-- Page level plugins -->
    <script src="<?= base_url('assets'); ?>/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= base_url('assets'); ?>/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="<?= base_url('assets'); ?>/js/sweetalert2.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.min.js"></script>
    <script src="<?= base_url('assets'); ?>/datepicker/js/bootstrap-datetimepicker.min.js"></script>
    <script src="<?= base_url('assets'); ?>/js/select2.min.js"></script>
    <script src="<?= base_url('assets'); ?>/js/bs-custom-file-input.min.js"></script>

    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script>
        $('.select2-aksi').select2({});
        $(document).ready(function() {
            bsCustomFileInput.init()
        })
        // Enable pusher logging - don't include this in production
        // Pusher.logToConsole = false;

        // var pusher = new Pusher('f33770f7120db2f928aa', {
        //     cluster: 'ap1'
        // });

        // var channel = pusher.subscribe('my-channel');
        // channel.bind('my-event', function(data) {
        //     alert(JSON.stringify(data));
        // });
    </script>
    <?= $this->renderSection('contentJS'); ?>