<?php include_once("./includes/connection.php") ?>
<?php include_once("./includes/session.php"); ?>
<?php include_once("./includes/helpers.php"); ?>

<?php
$comment_id_from_url = $_GET['id'];
$post_id_from_url = $_GET['postId'];
$user_id = $_SESSION['id'];

// * CHECK IF USER ALREADY LIKE THE COMMENT
$check_user_like_exist_query = "SELECT * FROM comment_likes WHERE user_id='$user_id' AND comment_id='$comment_id_from_url' GROUP BY comment_id";
$execute_check_user_like_exist_query = mysqli_query($conn, $check_user_like_exist_query);
$result = mysqli_num_rows($execute_check_user_like_exist_query);

if ($result > 0) {
  // * REMOVE THE LIKE FROM THE COMMENT
  $delete_like_query = "DELETE FROM comment_likes WHERE comment_id='$comment_id_from_url' AND user_id='$user_id'";
  $execute_like_query = mysqli_query($conn, $delete_like_query);
  if ($execute_like_query) {
    redirect_to(0, "single-post.php?id={$post_id_from_url}");
  } else {
    $error = mysqli_error($conn);
    echo "Error: $error";
    echo '<script type="text/javascript">toastr.error("Something went wrong while liking comment")</script>';
  }
} else {
  // * LIKE THE COMMENT
  $add_comment_query = "INSERT INTO comment_likes(comment_id, user_id) VALUES ('$comment_id_from_url', '$user_id')";
  $execute_add_comment_query = mysqli_query($conn, $add_comment_query);
  if ($execute_add_comment_query) {
    redirect_to(0, "single-post.php?id={$post_id_from_url}");
  } else {
    $error = mysqli_error($conn);
    echo "Error: $error";
    echo '<script type="text/javascript">toastr.error("Something went wrong while liking comment")</script>';
  }
}




?>