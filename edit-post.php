<?php include_once("./includes/connection.php") ?>
<?php include_once("./includes/session.php"); ?>
<?php include_once("./includes/helpers.php"); ?>
<?php include_once("./includes/header.php"); ?>

<?php
if (isset($_POST['submit'])) {
  $update_id = $_GET['id'];
  $title = $_POST['title'];
  $description = $_POST['description'];
  $category_id = $_POST['category_id'];
  $is_draft = isset($_POST['is_draft']) && $_POST['is_draft'] ? 1 : 0;
  $is_private = isset($_POST['is_private']) && $_POST['is_private'] ? 1 : 0;


  if (empty($title) || empty($description) || empty($category_id)) {
    echo '<script type="text/javascript">toastr.error("Please fill all the fields. All fields are mandatory")</script>';

  } else {

    $update_blog_post_query = "UPDATE posts SET title='$title', description='$description', category_id='$category_id', is_draft='$is_draft', is_private='$is_private' WHERE id='$update_id'";
    $execute_update_blog_post_query = mysqli_query($conn, $update_blog_post_query);

    if ($execute_update_blog_post_query) {
      echo '<script type="text/javascript">toastr.success("Post updated successfully")</script>';
    } else {
      $error = mysqli_error($conn);
      echo "Error: $error";
      echo '<script type="text/javascript">toastr.error("Something went wrong while editing blog post")</script>';
    }

  }
}

?>


<?php
$post_id_from_url = $_GET['id'];
$get_post_by_id_query = "SELECT posts.*, categories.*, posts.id AS postId FROM posts
                         LEFT JOIN categories ON posts.category_id = categories.id
                         WHERE posts.id = '$post_id_from_url'";

$execute_get_ad_by_id_query = mysqli_query($conn, $get_post_by_id_query);
$row = mysqli_fetch_assoc($execute_get_ad_by_id_query);
// print_r($row); remove the comment and check the structure of the data

$row_id = $row["postId"];
$row_title = $row["title"];
$row_description = $row["description"];
$row_is_draft = $row['is_draft'];
$row_is_private = $row['is_private'];
$row_category_id = $row["category_id"];

?>


<div class="container">
  <div class="row justify-content-center pt-5">
    <div class="col-lg-5 col-12">
      <a href='profile.php' type="button" class="btn btn-light mt-4">
        <i class="bi bi-arrow-left-circle me-3"></i>Back</a>
      <div class="mt-5">
        <h1 class="text-center">
          <i class="bi bi-pencil me-3"></i>Edit Post
        </h1>
        <form action="edit-post.php?id=<?= $row_id; ?>" method="POST" class="mt-5">
          <div class="input-group mb-3">
            <input name="title" type="text" class="form-control" placeholder="Enter blog post title"
              value="<?= $row_title; ?>" />
          </div>
          <div class="input-group mb-3">
            <input name="description" type="text" class="form-control" placeholder="Enter your blog post description"
              value="<?= $row_description; ?>" />
          </div>

          <div class="input-group mb-3">
            <select class="form-select" name="category_id" aria-label="Default select example">

              <?php
              $get_categories_query = "SELECT * FROM categories";
              $execute_get_categories_query = mysqli_query($conn, $get_categories_query);
              while ($data = mysqli_fetch_array($execute_get_categories_query)) {
                $cat_id = $data['id'];
                $cat_name = $data['name'];
                ?>
                <option value="<?= $cat_id; ?>" <?= ($cat_id == $row_category_id) ? "selected" : ""; ?>>
                  <?= $cat_name ?>
                </option>
                <?php
              }
              ?>
            </select>
          </div>

          <div class="input-group mb-3">
            <div class="form-check form-switch">
              <input <?= $row_is_draft == 1 ? "checked" : ""; ?> name="is_draft" value="1" class="form-check-input"
                type="checkbox">
              <label class="form-check-label">
                Save post as draft
              </label>
            </div>
          </div>

          <div class="input-group mb-3">
            <div class="form-check form-switch">
              <input <?= $row_is_private == 1 ? "checked" : ""; ?> name="is_private" value="1" class="form-check-input"
                type="checkbox">
              <label class="form-check-label">
                Want to make your post private?
              </label>
            </div>
          </div>

          <input name="submit" type="submit" value="Update Blog Post" class="btn btn-dark btn-block w-100 mt-3 mb-3" />

        </form>
      </div>
    </div>
  </div>
</div>

<?php include_once("./includes/footer.php"); ?>