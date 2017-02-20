<?php
require_once('../../../private/initialize.php');

if(!isset($_GET['id'])) {
  redirect_to('index.php');
}
$id = $_GET['id'];
$states_result = find_state_by_id($id);
// No loop, only one result
$state = db_fetch_assoc($states_result);

// Set default values for all variables the page needs.
$errors = array();

if(is_post_request()) {
  if ($_POST['submit'] == "Cancel") {
    redirect_to('show.php?id=' . u($state['id']));
  }

  // Confirm that values are present before accessing them.
  if(isset($_POST['name'])) { $state['name'] = $_POST['name']; }
  if(isset($_POST['code'])) { $state['code'] = $_POST['code']; }
  if(isset($_POST['country_id'])) { $state['country_id'] = $_POST['country_id']; }

  $result = update_state($state);
  if($result === true) {
    redirect_to('show.php?id=' . u($state['id']));
  } else {
    $errors = $result;
  }
}
?>
<?php $page_title = 'Staff: Edit State ' . $state['name']; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
  <a href="./index.php" class="btn btn-primary">Back to States List</a><br />

  <h1><small>Edit State:</small> <?php echo h($state['name']); ?></h1>

  <!-- TODO add form -->
  <?php echo display_errors($errors); ?>

  <form action="#" method="post">
    <div class="form-group">
      <label>Name:</label>
      <input type="text" name="name" value="<?php echo h($state['name']); ?>" class="form-control" />
    </div>
    <div class="form-group">
      <label>Code:</label>
      <input type="text" name="code" value="<?php echo h($state['code']); ?>" class="form-control" />
    </div>
    <div class="form-group">
      <label>Country ID:</label>
      <input type="text" name="country_id" value="<?php echo h($state['country_id']); ?>" class="form-control" />
    </div>
    <input type="submit" name="submit" value="Update" class="btn btn-success" />
    <input type="submit" name="submit" value="Cancel" class="btn btn-danger" />
  </form>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
