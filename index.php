<?php include_once ("./includes/connection.php") ?>
<?php include_once ("./includes/session.php"); ?>
<?php include_once ("./includes/helpers.php"); ?>
<?php include_once ("./includes/header.php"); ?>

<div class="container mt-5">
  <div class="card-deck row">
    <div class="col-lg-9">
      <div class="row">
        <?php

        $get_all_posts_query = "SELECT 
         posts.id AS post_id, posts.title, 
         users.id AS user_id, users.name, users.profile_image,
         categories.name AS category_name
         FROM posts 
         JOIN users ON posts.user_id = users.id
         JOIN categories ON posts.category_id = categories.id
         WHERE posts.is_draft = 0 AND posts.is_private = 0";

        $execute_get_all_posts_query = mysqli_query($conn, $get_all_posts_query);
        while ($row = mysqli_fetch_assoc($execute_get_all_posts_query)) {
          // print_r($row); uncomment this piece of code for better understanding of incoming data
          ?>
          <div class="col-lg-4 p-2 card-group">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">
                  <?= substr($row['title'], 0, 25); ?>
                  <?= strlen($row['title']) > 25 ? '...' : ''; ?>
                </h5>

                <div class="text-end">
                  <span class="badge bg-light text-dark border">
                    <?= $row['category_name']; ?>
                  </span>
                </div>
                <div class="d-flex mt-4">
                  <div class="author-pic">
                    <img src="./uploads/<?= $row['profile_image'] ?>" alt="Image" class="rounded-circle" width="50"
                      height="50">
                  </div>
                  <div class="d-flex flex-column ms-3 mt-1">
                    <h6 class="text-dark mb-0">
                      <strong>
                        <?= $row['name']; ?>
                      </strong>
                    </h6>
                    <p><small class="text-dark">Created on 12-03-22</small></p>
                  </div>
                </div>
                <a href="single-post.php?id=<?= $row['post_id']; ?>" class="btn btn-dark btn-block w-100 mt-2">
                  Read More
                </a>
              </div>
            </div>
          </div>
          <?php
        }

        ?>

      </div>
    </div>
    <div class="col-lg-3 p-2">
      <div class="card mb-3">
        <div class="card-header bg-dark text-white">Posts By Category</div>
        <ul class="list-group list-group-flush">
          <li class="list-group-item">
            <a href="#">Sports</a>
          </li>
          <li class="list-group-item">
            <a href="#">Gaming</a>
          </li>
          <li class="list-group-item">
            <a href="#">Weather</a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>

<?php include_once ("./includes/footer.php") ?>