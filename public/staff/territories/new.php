<?php
require_once('../../../private/initialize.php');

if(!isset($_GET['state_id'])) {
  redirect_to('index.php');
}
$state_id = u($_GET['state_id']);

// Set default values for all variables the page needs.
$errors = array();

$territory = array(
  'name' => '',
  'state_id' => $state_id,
  'country_id' => ''
);

if(is_post_request()) {

  // Confirm that values are present before accessing them.
  if(isset($_POST['name'])) { $territory['name'] = $_POST['name']; }
  if(isset($_POST['position'])) { $territory['position'] = $_POST['position']; }

  $result = insert_territory($territory);
  if($result === true) {
    $new_id = db_insert_id($db);
    redirect_to('show.php?id=' . u($new_id));
  } else {
    $errors = $result;
  }
}

?>
<?php $page_title = 'Staff: New Territory'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
  <a href="../states/show.php?id=<?php echo u($state_id); ?>" class="btn btn-primary">Back to State Details</a><br />

  <h1>New Territory</h1>

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
    <input type="submit" name="submit" value="Create" class="btn btn-success" />
  </form>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
