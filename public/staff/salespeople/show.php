<?php
require_once('../../../private/initialize.php');

if(!isset($_GET['id'])) {
  redirect_to('index.php');
}
$id = $_GET['id'];
$salespeople_result = find_salesperson_by_id($id);
// No loop, only one result
$salesperson = db_fetch_assoc($salespeople_result);

if(is_post_request()) {
  if ($_POST['submit'] == "Edit") {
    redirect_to('edit.php?id=' . u($salesperson['id']));
  } elseif ($_POST['submit'] == "Delete") {
    redirect_to('delete.php?id=' . u($salesperson['id']));
  }
}
?>

<?php $page_title = 'Staff: Salesperson ' . h($salesperson['first_name']) . " " . h($salesperson['last_name']); ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
  <a href="./index.php" class="btn btn-primary">Back to Salespeople List</a><br />

  <h1><small>Salesperson:</small> <?php echo h($salesperson['first_name']) . " " . h($salesperson['last_name']); ?></h1>

  <table id="salesperson" class="table">
    <tr>
      <td>Name: </td>
      <td><?php echo h($salesperson['first_name']) . " " . h($salesperson['last_name']); ?></td>
    </tr>
    <tr>
      <td>Phone: </td>
      <td><?php echo h($salesperson['phone']); ?></td>
    </tr>
    <tr>
      <td>Email: </td>
      <td><?php echo h($salesperson['email']); ?></td>
    </tr>
  </table>

  <?php db_free_result($salespeople_result); ?>

  <form action="#" method="post">
    <input type="submit" name="submit" value="Edit" class="btn btn-success">
    <input type="submit" name="submit" value="Delete" class="btn btn-danger">
  </form>
</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
