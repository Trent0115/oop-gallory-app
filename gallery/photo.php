<?php include "../includes/header.php"; ?>

<?php
require_once "../admin/includes/init.php";

if (empty($_GET['id'])) {
    redirect("../admin/index.php");
}

$photo = Photo::find_by_id($_GET['id']);

$author   = "";
$body     = "";
$comments = Comment::find_the_comments($photo->id);

if (isset($_POST['submit'])) {
    $author = trim($_POST['author']);
    $body   = trim($_POST['body']);

    $new_comment = Comment::create_comment($photo->id, $author, $body);

    if ($new_comment && $new_comment->save()) {
        redirect("../admin/includes/photo.php?id={$photo->id}");
    } else {
        $message = "there was a problem savinng";
    }
}

?>

<div class="row">
    <div class="col-lg-12 row">

        <!-- Blog Post -->

        <!-- Title -->
        <h1><?php echo $photo->title; ?></h1>

        <!-- Author -->
        <p class="lead">
            by <a href="#">Trenton Smith</a>
        </p>

        <hr>

        <!-- Date/Time -->
        <p><span class="glyphicon glyphicon-time"></span> Posted on August 24, 2013 at 9:00 PM</p>

        <hr>

        <!-- Preview Image -->
        <img class="picture img-responsive" src="../admin/<?php echo $photo->picture_path(); ?>" alt="">
        o
        <hr>

        <!-- Post Content -->
        <p class="lead"><?php echo $photo->caption; ?></p>
        <p><?php echo $photo->description; ?></p>

        <hr>

        <!-- Blog Comments -->

        <!-- Comments Form -->



        <div class="well">
            <h4>Leave a Comment:</h4>
            <form role="form" method="post">
                <div class="form-group">
                    <input type="text" name="author" class="form-control">
                </div>
                <div class="form-group">
                    <textarea name="body" class="form-control" rows="3"></textarea>
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>

        <hr>

        <!-- Posted Comments -->




        ` <?php foreach ($comments as $comment) : ?>


            <!-- Comment -->


        <?php endforeach; ?>

    </div>

    <!-- Blog Sidebar Widgets Column -->
    <!-- <div class="col-md-4"> -->





    <!-- 
    </div> -->

</div>

<?php include "../includes/footer.php"; ?>