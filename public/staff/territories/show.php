<?php require_once('../../../private/initialize.php'); ?>

<?php
if(!isset($_GET['id'])) {
  redirect_to('index.php');
}
$id = u($_GET['id']);
$territory_result = find_territory_by_id($id);
// No loop, only one result
$territory = db_fetch_assoc($territory_result);

$state_result = find_state_by_id($territory['state_id']);
$state = db_fetch_assoc($state_result);
?>

<?php $page_title = 'Staff: Territory of ' . $territory['name']; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
  <a href="../states/show.php?id= <?php echo u($territory['state_id']) ?>" class="btn btn-primary">Back to State Details</a>
  <br />

  <h1><small>State:</small> <?php echo h($state['name']); ?></h1>
  <h1><small>Territory:</small> <?php echo h($territory['name']); ?></h1>

  <table id="territory" class="table">
    <tr>
      <td>Name: </td>
      <td><?php echo h($territory['name']); ?></td>
    </tr>
    <tr>
      <td>State ID: </td>
      <td><?php echo h($territory['state_id']); ?></td>
    </tr>
    <tr>
      <td>Position: </td>
      <td><?php echo h($territory['position']); ?></td>
    </tr>
  </table>

   <?php db_free_result($territory_result); ?>
  <br />
  <a href="edit.php?id=<?php echo u($territory['id']); ?>" class="btn btn-success">Edit</a><br />

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
