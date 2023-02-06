<!DOCTYPE html>
<html lang="en">
<?= $this->include('_template/_header') ?>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?= $this->include('_template/_sidebar') ?>

        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?= $this->include('_template/_navbar') ?>
                <!-- End of Topbar -->
                <input type="hidden" name="" id="base_url" value="<?= base_url(); ?>">
                <!-- Begin Page Content -->
                <?= $this->renderSection('contentBody'); ?>

                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?= $this->include('_template/_footer') ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <!-- Modal-->
    <?= $this->include('_template/_modal') ?>
    <?= $this->include('_template/_js') ?>

</body>

</html>