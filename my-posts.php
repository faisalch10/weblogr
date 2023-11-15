<?php include_once("./includes/connection.php") ?>
<?php include_once("./includes/session.php"); ?>
<?php include_once("./includes/helpers.php"); ?>
<?php include_once("./includes/header.php"); ?>

<div class="container">
  <div class="row mt-5">
    <div class="col-lg-3">
      <ul class="list-group">
        <a href="profile.php" class="list-group-item list-group-item-action bg-dark text-white">
          <i class="bi bi-person-circle me-2"></i>
          Basic Profile Info</a>
        <a href="my-posts.php" class="list-group-item list-group-item-action">
          <i class="bi bi-card-list me-2"></i> Your Posts
        </a>
      </ul>
    </div>
    <div class="col-lg-9 mt-3 mt-lg-0">
      <div class="table-responsive">
        <table class="table table-bordered">
          <thead class="table-dark">
            <th class="text-center">ID</th>
            <th class="text-center">Title</th>
            <th class="text-center">Draft</th>
            <th class="text-center">Private</th>
            <th class="text-center">Actions</th>
          </thead>
          <tbody>
            <?php
            $user_id = $_SESSION["id"];
            $get_my_posts_query = "SELECT * FROM posts WHERE user_id='$user_id'";
            $execute_get_my_posts_query = mysqli_query($conn, $get_my_posts_query);
            $i = 0;
            while ($row = mysqli_fetch_assoc($execute_get_my_posts_query)) {
              $i++;
              ?>
              <tr class="text-center">
                <td>
                  <?= $i; ?>
                </td>
                <td>
                  <?= $row['title']; ?>
                </td>
                <td>
                  <?php
                  if ($row['is_draft'] === "1") {
                    ?>
                    <i class="bi bi-check-circle-fill h5"></i>
                    <?php
                  } else {
                    ?>
                    <i class="bi bi-x-circle-fill h5"></i>
                    <?php
                  }

                  ?>
                </td>
                <td>
                  <?php
                  if ($row['is_private'] === "1") {
                    ?>
                    <i class="bi bi-check-circle-fill h5"></i>
                    <?php
                  } else {
                    ?>
                    <i class="bi bi-x-circle-fill h5"></i>
                    <?php
                  }

                  ?>
                </td>
                <td>
                  <a href="edit-post.php?id=<?= $row['id'] ?>">
                    <i class="bi bi-pencil-square text-success h4"></i>
                  </a>
                  <a href="delete-post.php?id=<?= $row['id']; ?>">
                    <i class="bi bi-trash3 text-danger h4"></i>
                  </a>
                </td>
              </tr>
              <?php
            }
            ?>
          </tbody>
        </table>
      </div>

    </div>
  </div>
</div>

<?php include_once("./includes/footer.php"); ?>