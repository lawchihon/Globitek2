<?php
require_once('../../../private/initialize.php');

if(!isset($_GET['id'])) {
  redirect_to('index.php');
}
$salespeople_result = find_salesperson_by_id($_GET['id']);
// No loop, only one result
$salesperson = db_fetch_assoc($salespeople_result);

// Set default values for all variables the page needs.
$errors = array();

if(is_post_request()) {
  if ($_POST['submit'] == "No") {
    redirect_to('show.php?id=' . u($salesperson['id']));
  }

  $result = delete_salesperson($salesperson);
  if($result === true) {
    redirect_to('./index.php');
  } else {
    $errors = $result;
  }
}
?>
<?php $page_title = 'Staff: Delete Salesperson ' . h($salesperson['first_name']) . " " . h($salesperson['last_name']); ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
  <a href="index.php" class="btn btn-primary">Back to User Detail</a><br />

  <h1><small>Delete Salesperson:</small> <?php echo h($salesperson['first_name']) . " " . h($salesperson['last_name']); ?></h1>

  <?php echo display_errors($errors); ?>

  <form action="#" method="post" style="text-align: center;">
    <label>Are you sure you want to permanently delete the salesperson:
    <?php echo h($salesperson['first_name']) . " " . h($salesperson['last_name']); ?></label>
    <br />
    <input type="submit" name="submit" value="Yes" class="btn btn-success" />
    <input type="submit" name="submit" value="No" class="btn btn-danger" />
  </form>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
