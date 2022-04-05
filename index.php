<?php
// Page Title
$PAGE_TITLE = "HOME";

require_once "includes/header.inc.php";
?>
<?php

$q = "SELECT * FROM `posts` WHERE `visible`=1 ORDER BY `created_at` DESC";
$result = mysqli_query($connection, $q);

function findWhere($table, $field, $value, ?int $visible = 1, ?int $userId = null)
{
  global $connection;
  if ($visible == 1) {
    $q = "SELECT * FROM `$table` WHERE $field= $value";
  } else {
    $q = "SELECT * FROM `$table` WHERE $field= '$value' AND `user_id` = '$userId'";
  }
  $result = mysqli_query($connection, $q);
  if (mysqli_num_rows($result) > 0) {
    return mysqli_fetch_assoc($result);
  } else {
    return mysqli_error($connection);
  }
}


?>

<section class="jumbotron text-center">
  <div class="container">
    <h1 class="jumbotron-heading">PHP Blog</h1>
    <p>
      <a href="login.php" class="btn btn-info my-2">Sign in</a>
      <a href="register.php" class="btn btn-outline-secondary my-2">Join now</a>
    </p>
  </div>

  <div class='row'>

    <?php if (mysqli_num_rows($result) > 0) : ?>

      <!-- // output data of each row -->
      <?php while ($row = mysqli_fetch_assoc($result)) : ?>

        <div class="col-lg-3 offset-lg-0 col-md-4 offset-md-0 col-sm-10 offset-sm-1 mb-5">
          <div class="card">

            <div class="card-header">
              <h4 class="card-title text-primary"><?= $row["title"] ?>
              </h4>
            </div>
            <div style="padding:0px 0px 10px 0px; border-radius: 20px;">
              <img src=<?php echo './images/' . $row['image'] ?> height="200px" width="100%" style="object-fit: cover; border-radius: 0px 0px 10px 10px" />
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
          </div>
        </div>

      <?php endwhile; ?>

    <?php else : ?>
      <div class="col-md-10 offset-md-1 mt-5">
        <div class="jumbotron">
          <h1 class="display-3">No Public Post</h1>
        </div>
      </div>

    <?php endif; ?>
  </div>


</section>

<style>
  .btn {
    width: 150px;
    font-size: 20px;
  }
</style>

<?php require_once "includes/footer.inc.php"; ?>