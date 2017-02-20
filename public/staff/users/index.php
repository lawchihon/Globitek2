<?php require_once('../../../private/initialize.php'); ?>

<?php $page_title = 'Staff: Users'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
  <a href="../index.php" class="btn btn-primary">Back to Menu</a><br />

  <h1>Users</h1>

  <a href="new.php" class="btn btn-success">Add a User</a><br />
  <br />

  <?php
    $users_result = find_all_users();

    echo "<table id=\"users\" class=\"table\">";
    echo "<tr class=\"active\">";
    echo "<th>First name</th>";
    echo "<th>Last name</th>";
    echo "<th>Username</th>";
    echo "<th></th>";
    echo "<th></th>";
    echo "<th></th>";
    echo "</tr>";
    while($user = db_fetch_assoc($users_result)) {
      echo "<tr>";
      echo "<td>" . $user['first_name'] . "</td>";
      echo "<td>" . $user['last_name'] . "</td>";
      echo "<td>" . $user['username'] . "</td>";
      echo "<td>";
      echo "<a href=\"show.php?id=" . $user['id'] . "\" class=\"btn btn-info\">Show</a>";
      echo "</td>";
      echo "<td>";
      echo "<a href=\"edit.php?id=" . $user['id'] . "\" class=\"btn btn-success\">Edit</a>";
      echo "</td>";
      echo "<td>";
      echo "<a href=\"delete.php?id=" . $user['id'] . "\" class=\"btn btn-danger\">Delete</a>";
      echo "</td>";
      echo "</tr>";
    } // end while $user
    db_free_result($users_result);
    echo "</table>"; // #$users
  ?>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
