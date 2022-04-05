<?php
$PAGE_TITLE = "MY ALL POSTS";
require_once 'includes/header.inc.php';
?>

<?php
$user_id = $_SESSION["USER_ID"];
$errors = [];

$q = "SELECT * FROM `posts` WHERE `user_id` = '$user_id'";
$result = mysqli_query($connection, $q);

?>


<div class="container">

    <?php
    // Insert Post Alert
    if (isset($_SESSION["POST_CREATE_ID"]) && $_SESSION["POST_CREATE_ID"] != '') : ?>
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <?= showAlert("New Post Created", "success") ?>
                <?php
                // reset inseted post id to NULL
                $_SESSION['POST_CREATE_ID'] = '';
                ?>
            </div>
        </div>
    <?php endif; ?>


    <!-- <div class="col-md-6 offset-md-3 col-sm-12"> -->

    <div class="page-header">
        <h1 id="navbars">Posts</h1>
    </div>
    <div class="row">
        <?php if (mysqli_num_rows($result) > 0) : ?>

            <!-- // output data of each row -->
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>

                <div class="col-lg-5 offset-lg-0 col-md-4 offset-md-0 col-sm-10 offset-sm-1 mb-5">
                    <div class="card">

                        <div class="card-header">
                            <h4 class="card-title text-primary"><?= $row["title"] ?>
                            </h4>
                        </div>
                        <div style="padding:0px 0px 10px 0px; border-radius: 20px;">
                            <img src=<?= '../images/' . $row['image'] ?> height="200px" width="100%" style="object-fit: cover; border-radius: 0px 0px 10px 10px;" />
                        </div>
                        <div class="card-body text-muted">
                            <h6 class="card-subtitle mb-1">Posted by:
                                <?php
                                $data = findWhere('users', 'id', $row["user_id"]);
                                $publisherName = $data['first_name'] . ' ' . $data['last_name'];
                                echo $publisherName;
                                ?>
                            </h6>

                            <p class="small"> Created at :<?= $row["created_at"]; ?>
                            </p>
                        </div>
                        <div class="card-body overflow-hidden">

                            <p class="card-text"><?= $row["body"] ?>
                            </p>
                        </div>
                        <div class="card-footer">
                            <?php
                            $link = str_replace("myPosts.php", "post.php", $_SERVER["PHP_SELF"]);
                            $link .= '?postid=' . $row['id'];
                            ?>
                            <a href="<?= $link ?>" class="card-link text-info">Read
                                more...</a>
                        </div>
                    </div>
                </div>

            <?php endwhile; ?>

        <?php else : ?>

            <div class="col-md-10 offset-md-1 mt-5">
                <div class="jumbotron">
                    <h1 class="display-3">No Public Post</h1>
                    <p class="lead">no public post is avalible.</p>
                    <hr class="my-4">
                    <p class="lead">
                        <a class="btn btn-primary btn-lg" href="createPost.php" role="button">Create Post</a>
                    </p>
                </div>
            </div>
        <?php endif; ?>

    </div>
</div>

<?php require_once 'includes/footer.inc.php' ?>