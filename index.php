<?php include "admin/includes/header.php"; ?>
<?php if (!$session->is_signed_in()) {
    redirect("login.php");
} ?>


<div class="row">

    <!-- Blog Entries Column -->
    <div class="col-md-12">


        <!-- Blog Sidebar Widgets Column -->
        <div class="col-md-4">


            <?php include "admin/includes/side_nav.php"; ?>



        </div>
        <!-- /.row -->

        <?php include "admin/includes/footer.php"; ?>