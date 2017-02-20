<?php require_once('../../private/initialize.php'); ?>

<?php $page_title = 'Staff: Menu'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
  <h1>Menu</h1>
  <ul class="list-group">
    <li class="list-group-item">
      <h3><a href="users/index.php">Users</a></h3>
    </li>
    <li class="list-group-item">
      <h3><a href="salespeople/index.php">Salespeople</a></h3>
    </li>
    <li class="list-group-item">
      <h3><a href="countries/index.php">Countries</a></h3>
    </li>
    <li class="list-group-item">
      <h3><a href="states/index.php">States &amp; Territories</a></h3>
    </li>
  </ul>
</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
