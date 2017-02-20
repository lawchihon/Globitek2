<?php
require_once('../../../private/initialize.php');

if(!isset($_GET['id'])) {
  redirect_to('index.php');
}
$id = $_GET['id'];
$territories_result = find_territory_by_id($id);
// No loop, only one result
$territory = db_fetch_assoc($territories_result);
// Set default values for all variables the page needs.
$errors = array();

if(is_post_request()) {
  // Confirm that values are present before accessing them.
  if ($_POST['submit'] == "Cancel") {
    redirect_to('show.php?id=' . u($territory['id']));
  }
  if(isset($_POST['name'])) { $territory['name'] = $_POST['name']; }
  if(isset($_POST['position'])) { $territory['position'] = $_POST['position']; }

  $result = update_territory($territory);
  if($result === true) {
    redirect_to('show.php?id=' . u($territory['id']));
  } else {
    $errors = $result;
  }
}
?>
<?php $page_title = 'Staff: Edit Territory ' . $territory['name']; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
  <a href="../states/show.php?id=<?php echo u($territory["state_id"]); ?>" class="btn btn-primary">Back to State Details</a><br />

  <h1><small>Edit Territory:</small> <?php echo h($territory['name']); ?></h1>

  <!-- TODO add form -->
  <?php echo display_errors($errors); ?>

  <form action="#" method="post">
    <div class="form-group">
      <label>Name:</label>
      <input type="text" name="name" value="<?php echo h($territory['name']); ?>" class="form-control" />
    </div>
    <div class="form-group">
      <label>Position:</label>
      <input type="text" name="position" value="<?php echo h($territory['position']); ?>" class="form-control" />
    </div>
    <input type="submit" name="submit" value="Update" class="btn btn-success" />
    <input type="submit" name="submit" value="Cancel" class="btn btn-danger" />
  </form>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
