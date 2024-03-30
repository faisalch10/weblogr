<?php include_once ("./includes/connection.php") ?>
<?php include_once ("./includes/session.php"); ?>
<?php include_once ("./includes/helpers.php"); ?>
<?php include_once ("./includes/header.php"); ?>


<!-- CREATE COMMENT -->
<?php
if (isset($_POST['submit'])) {
  $post_id_from_url = $_GET['id'];
  $user_id = $_SESSION['id'];
  $content = $_POST['content'];

  // * CHECK IF USER ALREADY COMMENTED ON THE POST
  $check_user_comment_query = "SELECT * FROM post_comments WHERE user_id='$user_id' AND post_id=' $post_id_from_url'";
  $execute_check_user_comment_query = mysqli_query($conn, $check_user_comment_query);
  $result = mysqli_num_rows($execute_check_user_comment_query);

  if ($result > 0) {
    echo '<script type="text/javascript">toastr.error("You already posted a comment on this post!")</script>';
  } else {

    $create_comment_query = "INSERT INTO post_comments(text, user_id, post_id) VALUES(
  '$content', '$user_id', '$post_id_from_url')";

    $execute_create_comment_query = mysqli_query($conn, $create_comment_query);

    if ($execute_create_comment_query) {
      echo '<script type="text/javascript">toastr.success("Comment added successfully!")</script>';
    } else {
      $error = mysqli_error($conn);
      echo "Error: $error";
      echo '<script type="text/javascript">toastr.error("Something went wrong while editing blog post")</script>';
    }

  }
}
?>

<!-- ADD REPLY -->
<?php
if (isset($_POST['add_reply'])) {
  $user_id = $_SESSION['id'];
  $commentId = $_POST['commentId'];
  // $parentId = !empty($_POST['parentId']) ? $_POST['parentId'] : $commentId;
  $parentId = $commentId;
  $reply_text = $_POST['reply_text'];
  $pId = $_GET['id'];


  $add_reply_query = "INSERT INTO post_comments(parent_id, text, post_id, user_id) VALUES('$parentId', '$reply_text', '$pId', '$user_id')";

  $execute_add_reply_query = mysqli_query($conn, $add_reply_query);

  if ($execute_add_reply_query) {

  } else {
    $error = mysqli_error($conn);
    echo "Error: $error";
    echo '<script type="text/javascript">toastr.error("Something went wrong while liking comment")</script>';
  }
}

?>

<?php
function fetchComments($parent_id = NULL, $level = 0)
{
  global $conn;
  $pId = $_GET['id'];
  $user_id = $_SESSION['id'];

  $sql = "SELECT pc.*, u.username, pc.parent_id,
     COUNT(comment_likes.comment_id) AS total_likes,
        MAX(comment_likes.user_id = $user_id) AS user_likes_comment
        FROM post_comments pc
        JOIN users u ON pc.user_id = u.id
        LEFT JOIN comment_likes ON pc.id = comment_likes.comment_id
        WHERE pc.parent_id " . ($parent_id === NULL ? "IS NULL" : "= $parent_id") . " AND pc.post_id = $pId
        GROUP BY pc.id";

  $result = mysqli_query($conn, $sql);

  if ($result && mysqli_num_rows($result) > 0) {
    while ($row = $result->fetch_assoc()) {

      // print_r($row); better to uncomment to check the structure of data
      echo '<div class="mb-4 mt-2" style="margin-left: ' . ($level * 20) . 'px;">';
      echo '<h6><strong>' . $row['username'] . '</strong> &#x2022; <small style="color:gray"><em>2 mins ago</em></small></h6>';
      // Comment/Reply text
      echo '<p>' . $row['text'] . '</p>';
      echo '<a href="like-unlike-comment.php?id=' . $row['id'] . '&postId=' . $row['post_id'] . '" class="text-dark"><i class="bi ' . ((int) $row['user_likes_comment'] === 1 ? 'bi-hand-thumbs-up-fill' : 'bi-hand-thumbs-up') . '"></i>' . $row['total_likes'] . '</a>';
      echo '<div class=" pt-1">';
      echo '<form action="single-post.php?id=' . $row['post_id'] . '" method="POST" class="row">';
      echo '<div class="col-lg-12 mt-3">';
      echo '<input type="hidden" name="commentId" value="' . $row['id'] . '" />';
      echo '<input type="hidden" name="parentId" value="' . $row['parent_id'] . '" />';
      echo '<div class="input-group">';
      echo '<textarea rows="2" name="reply_text" type="text" class="form-control" placeholder="Enter your reply..."></textarea>';
      echo '</div>';
      echo '</div>';
      echo '<div class="d-flex mt-3">';
      echo '<input type="submit" name="add_reply" class="btn btn-dark w-80 mb-3" value="Add Reply" />';
      echo '</div>';
      echo '</form>';
      echo '</div>';
      fetchComments($row['id'], $level + 1);
      echo '</div>';
    }
  }
}


?>



<?php
$get_id_from_url = $_GET['id'];
$get_post_by_id_query = "SELECT * FROM posts WHERE id='$get_id_from_url'";
$execute_get_post_by_id_query = mysqli_query($conn, $get_post_by_id_query);
$row = mysqli_fetch_assoc($execute_get_post_by_id_query);
$row_title = $row['title'];
$row_description = $row['description'];

?>


<div class="container mt-5">
  <div class="row ck-content pt-5 mb-5">
    <div class="col-lg-9">
      <h1 class="mb-5 single-post-heading">
        <?= $row_title; ?>
      </h1>
      <?= htmlspecialchars_decode(stripslashes($row_description)); ?>
      <div class="clearfix"></div>
      <?php
      // Call the function with the root comments (parent_id is NULL)
      fetchComments();
      ?>

      <hr>
      <div class="mt-2 pt-3">
        <h3><i class="bi bi-chat-dots me-2"></i> Leave a Comment</h3>
        <form action="single-post.php?id=<?= $get_id_from_url; ?>" method="POST" class="row">
          <div class="col-lg-12 mt-3">
            <div class="input-group">
              <textarea rows="6" name="content" type="text" class="form-control"
                placeholder="Enter your comment here.."></textarea>
            </div>
          </div>
          <div class="d-flex mt-3">
            <input type="submit" name="submit" class="btn btn-dark w-80" value="Add Comment" />
          </div>
        </form>
      </div>

    </div>
    <div class="col-lg-3">
      <h1>Hello World</h1>
    </div>
  </div>

  <?php include_once ("./includes/footer.php"); ?>