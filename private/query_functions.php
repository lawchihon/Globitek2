<?php

  //
  // COUNTRY QUERIES
  //

  // Find all countries, ordered by name
  function find_all_countries() {
    global $db;
    $sql = "SELECT * FROM countries ORDER BY name ASC;";
    $country_result = db_query($db, $sql);
    return $country_result;
  }

  //
  // STATE QUERIES
  //

  // Find all states, ordered by name
  function find_all_states() {
    global $db;
    $sql = "SELECT * FROM states ";
    $sql .= "ORDER BY name ASC;";
    $state_result = db_query($db, $sql);
    return $state_result;
  }

  // Find all states, ordered by name
  function find_states_for_country_id($country_id=0) {
    global $db;
    $sql = "SELECT * FROM states ";
    $sql .= "WHERE country_id='" . db_escape($db, $country_id) . "' ";
    $sql .= "ORDER BY name ASC;";
    $state_result = db_query($db, $sql);
    return $state_result;
  }

  // Find state by ID
  function find_state_by_id($id=0) {
    global $db;
    $sql = "SELECT * FROM states ";
    $sql .= "WHERE id='" . db_escape($db, $id) . "';";
    $state_result = db_query($db, $sql);
    return $state_result;
  }

  function validate_state($state, $errors=array()) {
    // TODO add validations
    if (is_blank($state['name'])) {
      $errors[] = "Name cannot be blank.";
    } elseif (!has_length($state['name'], array('min' => 2, 'max' => 255))) {
      $errors[] = "Name must be between 2 and 255 characters.";
    } elseif (!has_valid_name_character($state['name'])) {
      $errors[] = "Name must contain only whitelisted characters: A-Z, a-z, spaces, and -,.'";
    }

    if (is_blank($state['code'])) {
      $errors[] = "Code cannot be blank.";
    } elseif (!has_length($state['code'], array('min' => 2, 'max' => 255))) {
      $errors[] = "Code must be 2 characters.";
    } elseif (!has_valid_state_code_character($state['code'])) {
      $errors[] = "Code must contain only whitelisted characters: A-Z";
    }

    if (is_blank($state['country_id'])) {
      $errors[] = "Country ID cannot be blank.";
    } elseif (!has_length($state['country_id'], array('max' => 255))) {
      $errors[] = "Country ID must be less than 255 characters.";
    } elseif (!has_valid_id_character($state['country_id'])) {
      $errors[] = "Country ID must contain only whitelisted characters: 0-9";
    }

    return $errors;
  }

  // Add a new state to the table
  // Either returns true or an array of errors
  function insert_state($state) {
    global $db;

    $errors = validate_state($state);
    if (!has_unique_state_name($state['name'], $state['country_id'])) {
      $errors[] = "Name must be unique.";
    }
    if (!has_unique_state_code($state['code'], $state['country_id'])) {
      $errors[] = "Code must be unique.";
    }

    if (!empty($errors)) {
      return $errors;
    }

    $sql = "INSERT INTO states ";
    $sql .= "(name, code, country_id) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $state['name']) . "',";
    $sql .= "'" . db_escape($db, $state['code']) . "',";
    $sql .= "'" . db_escape($db, $state['country_id']) . "'";
    $sql .= ");";
    // For INSERT statments, $result is just true/false
    $result = db_query($db, $sql);
    if($result) {
      return true;
    } else {
      // The SQL INSERT statement failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }

  // Edit a state record
  // Either returns true or an array of errors
  function update_state($state) {
    global $db;

    $errors = validate_state($state);
    if (!has_unique_state_name($state['name'], $state['country_id'], $state['id'])) {
      $errors[] = "Name must be unique.";
    }
    if (!has_unique_state_code($state['code'], $state['country_id'], $state['id'])) {
      $errors[] = "Code must be unique.";
    }

    if (!empty($errors)) {
      return $errors;
    }

    $sql = "UPDATE states SET ";
    $sql .= "name='" . db_escape($db, $state['name']) . "', ";
    $sql .= "code='" . db_escape($db, $state['code']) . "', ";
    $sql .= "country_id='" . db_escape($db, $state['country_id']) . "' ";
    $sql .= "WHERE id='" . db_escape($db, $state['id']) . "' ";
    $sql .= "LIMIT 1;";
    // For update_state statments, $result is just true/false
    $result = db_query($db, $sql);
    if($result) {
      return true;
    } else {
      // The SQL UPDATE statement failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }

  //
  // TERRITORY QUERIES
  //

  // Find all territories, ordered by state_id
  function find_all_territories() {
    global $db;
    $sql = "SELECT * FROM territories ";
    $sql .= "ORDER BY state_id ASC, position ASC;";
    $territory_result = db_query($db, $sql);
    return $territory_result;
  }

  // Find all territories whose state_id (foreign key) matches this id
  function find_territories_for_state_id($state_id=0) {
    global $db;
    $sql = "SELECT * FROM territories ";
    $sql .= "WHERE state_id='" . db_escape($db, $state_id) . "' ";
    $sql .= "ORDER BY position ASC;";
    $territory_result = db_query($db, $sql);
    return $territory_result;
  }

  // Find territory by ID
  function find_territory_by_id($id=0) {
    global $db;
    $sql = "SELECT * FROM territories ";
    $sql .= "WHERE id='" . db_escape($db, $id) . "';";
    $territory_result = db_query($db, $sql);
    return $territory_result;
  }

  function validate_territory($territory, $errors=array()) {
    // TODO add validations
    if (is_blank($territory['name'])) {
      $errors[] = "Name cannot be blank.";
    } elseif (!has_length($territory['name'], array('min' => 2, 'max' => 255))) {
      $errors[] = "Name must be between 2 and 255 characters.";
    } elseif (!has_valid_name_character($territory['name'])) {
      $errors[] = "Name must contain only whitelisted characters: A-Z, a-z, spaces, and -,.'";
    }

    if (is_blank($territory['state_id'])) {
      $errors[] = "State ID cannot be blank.";
    } elseif (!has_length($territory['state_id'], array('max' => 255))) {
      $errors[] = "State ID must be less than 255 characters.";
    } elseif (!has_valid_id_character($territory['state_id'])) {
      $errors[] = "State ID must contain only whitelisted characters: 0-9";
    }

    if (is_blank($territory['position'])) {
      $errors[] = "Position cannot be blank.";
    } elseif (!has_length($territory['position'], array('max' => 255))) {
      $errors[] = "Position must be less than 255 characters.";
    } elseif (!has_valid_position_character($territory['position'])) {
      $errors[] = "Position must contain only whitelisted characters: 0-9";
    }

    return $errors;
  }

  // Add a new territory to the table
  // Either returns true or an array of errors
  function insert_territory($territory) {
    global $db;

    $errors = validate_territory($territory);
    if (!has_unique_territory_name($territory['name'], $territory['state_id'])) {
      $errors[] = "Name must be unique.";
    }
    if (!has_unique_territory_position($territory['position'], $territory['state_id'])) {
      $errors[] = "Position must be unique.";
    }

    if (!empty($errors)) {
      return $errors;
    }

    $sql = "INSERT INTO territories ";
    $sql .= "(name, state_id, position) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $territory['name']) . "',";
    $sql .= "'" . db_escape($db, $territory['state_id']) . "',";
    $sql .= "'" . db_escape($db, $territory['position']) . "'";
    $sql .= ");";
    // For INSERT statments, $result is just true/false
    $result = db_query($db, $sql);
    if($result) {
      return true;
    } else {
      // The SQL INSERT territoryment failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }

  // Edit a territory record
  // Either returns true or an array of errors
  function update_territory($territory) {
    global $db;

    $errors = validate_territory($territory);
    if (!has_unique_territory_name($territory['name'], $territory['state_id'], $territory['id'])) {
      $errors[] = "Name must be unique.";
    }
    if (!has_unique_territory_position($territory['position'], $territory['state_id'], $territory['id'])) {
      $errors[] = "Position must be unique.";
    }

    if (!empty($errors)) {
      return $errors;
    }

    $sql = "UPDATE territories SET ";
    $sql .= "name='" . db_escape($db, $territory['name']) . "', ";
    $sql .= "state_id='" . db_escape($db, $territory['state_id']) . "', ";
    $sql .= "position='" . db_escape($db, $territory['position']) . "' ";
    $sql .= "WHERE id='" . db_escape($db, $territory['id']) . "' ";
    $sql .= "LIMIT 1;";
    // For update_territory statments, $result is just true/false
    $result = db_query($db, $sql);
    if($result) {
      return true;
    } else {
      // The SQL UPDATE territoryment failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }

  //
  // SALESPERSON QUERIES
  //

  // Find all salespeople, ordered last_name, first_name
  function find_all_salespeople() {
    global $db;
    $sql = "SELECT * FROM salespeople ";
    $sql .= "ORDER BY last_name ASC, first_name ASC;";
    $salespeople_result = db_query($db, $sql);
    return $salespeople_result;
  }

  // To find salespeople, we need to use the join table.
  // We LEFT JOIN salespeople_territories and then find results
  // in the join table which have the same territory ID.
  function find_salespeople_for_territory_id($territory_id=0) {
    global $db;
    $sql = "SELECT * FROM salespeople ";
    $sql .= "LEFT JOIN salespeople_territories
              ON (salespeople_territories.salesperson_id = salespeople.id) ";
    $sql .= "WHERE salespeople_territories.territory_id='" . db_escape($db, $territory_id) . "' ";
    $sql .= "ORDER BY last_name ASC, first_name ASC;";
    $salespeople_result = db_query($db, $sql);
    return $salespeople_result;
  }

  // Find salesperson using id
  function find_salesperson_by_id($id=0) {
    global $db;
    $sql = "SELECT * FROM salespeople ";
    $sql .= "WHERE id='" . db_escape($db, $id) . "';";
    $salespeople_result = db_query($db, $sql);
    return $salespeople_result;
  }

  function validate_salesperson($salesperson, $errors=array()) {
    if (is_blank($salesperson['first_name'])) {
      $errors[] = "First name cannot be blank.";
    } elseif (!has_length($salesperson['first_name'], array('min' => 2, 'max' => 255))) {
      $errors[] = "First name must be between 2 and 255 characters.";
    } elseif (!has_valid_name_character($salesperson['first_name'])) {
      $errors[] = "First name must contain only whitelisted characters: A-Z, a-z, spaces, and -,.'";
    }

    if (is_blank($salesperson['last_name'])) {
      $errors[] = "Last name cannot be blank.";
    } elseif (!has_length($salesperson['last_name'], array('min' => 2, 'max' => 255))) {
      $errors[] = "Last name must be between 2 and 255 characters.";
    } elseif (!has_valid_name_character($salesperson['last_name'])) {
      $errors[] = "Last name must contain only whitelisted characters: A-Z, a-z, spaces, and -,.'";
    }

    if (is_blank($salesperson['phone'])) {
      $errors[] = "Phone cannot be blank.";
    } elseif (!has_length($salesperson['phone'], array('max' => 255))) {
      $errors[] = "Phone must be less than 255 characters.";
    } elseif (!has_valid_phone_character($salesperson['phone'])) {
      $errors[] = "Phone must contain only the whitelisted characters: 0-9, spaces, and ()-";
    }

    if (is_blank($salesperson['email'])) {
      $errors[] = "Email cannot be blank.";
    } elseif (!has_valid_email_format($salesperson['email'])) {
      $errors[] = "Email must be a valid format.";
    } elseif (!has_valid_email_character($salesperson['email'])) {
      $errors[] = "Email must contain only the whitelisted characters: A-Z, a-z, 0-9, and @._-";
    }

    return $errors;
  }

  // Add a new salesperson to the table
  // Either returns true or an array of errors
  function insert_salesperson($salesperson) {
    global $db;

    $errors = validate_salesperson($salesperson);
    if (!has_unique_sales_email($salesperson['email'])) {
      $errors[] = "Email must be unique.";
    }

    if (!empty($errors)) {
      return $errors;
    }

    $sql = "INSERT INTO salespeople ";
    $sql .= "(first_name, last_name, phone, email) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $salesperson['first_name']) . "',";
    $sql .= "'" . db_escape($db, $salesperson['last_name']) . "',";
    $sql .= "'" . db_escape($db, $salesperson['phone']) . "',";
    $sql .= "'" . db_escape($db, $salesperson['email']) . "'";
    $sql .= ");";
    // For INSERT statments, $result is just true/false
    $result = db_query($db, $sql);
    if($result) {
      return true;
    } else {
      // The SQL INSERT statement failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }

  // Edit a salesperson record
  // Either returns true or an array of errors
  function update_salesperson($salesperson) {
    global $db;

    $errors = validate_salesperson($salesperson);
    if (!has_unique_sales_email($salesperson['email'], $salesperson['id'])) {
      $errors[] = "Email must be unique.";
    }

    if (!empty($errors)) {
      return $errors;
    }

    $sql = "UPDATE salespeople SET ";
    $sql .= "first_name='" . db_escape($db, $salesperson['first_name']) . "', ";
    $sql .= "last_name='" . db_escape($db, $salesperson['last_name']) . "', ";
    $sql .= "phone='" . db_escape($db, $salesperson['phone']) . "', ";
    $sql .= "email='" . db_escape($db, $salesperson['email']) . "' ";
    $sql .= "WHERE id='" . db_escape($db, $salesperson['id']) . "' ";
    $sql .= "LIMIT 1;";
    // For update_salesperson statments, $result is just true/false
    $result = db_query($db, $sql);
    if($result) {
      return true;
    } else {
      // The SQL UPDATE statement failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }

  // To find territories, we need to use the join table.
  // We LEFT JOIN salespeople_territories and then find results
  // in the join table which have the same salesperson ID.
  function find_territories_by_salesperson_id($id=0) {
    global $db;
    $sql = "SELECT * FROM territories ";
    $sql .= "LEFT JOIN salespeople_territories
              ON (territories.id = salespeople_territories.territory_id) ";
    $sql .= "WHERE salespeople_territories.salesperson_id='" . db_escape($db, $id) . "' ";
    $sql .= "ORDER BY territories.name ASC;";
    $territories_result = db_query($db, $sql);
    return $territories_result;
  }

  function delete_salesperson($salesperson) {
    global $db;

    #$errors = validate_salesperson($salesperson);
    if (!empty($errors)) {
      return $errors;
    }

    $sql = "DELETE FROM salespeople ";
    $sql .= "WHERE first_name='" . db_escape($db, $salesperson['first_name']) . "' AND ";
    $sql .= "last_name='" . db_escape($db, $salesperson['last_name']) . "' AND ";
    $sql .= "phone='" . db_escape($db, $salesperson['phone']) . "' AND ";
    $sql .= "email='" . db_escape($db, $salesperson['email']) . "' AND ";
    $sql .= "id='" . db_escape($db, $salesperson['id']) . "' ";
    $sql .= "LIMIT 1;";
    // For delete_salesperson statments, $result is just true/false
    $result = db_query($db, $sql);
    if($result) {
      return true;
    } else {
      // The SQL UPDATE statement failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }

  //
  // USER QUERIES
  //

  // Find all users, ordered last_name, first_name
  function find_all_users() {
    global $db;
    $sql = "SELECT * FROM users ";
    $sql .= "ORDER BY last_name ASC, first_name ASC;";
    $users_result = db_query($db, $sql);
    return $users_result;
  }

  // Find user using id
  function find_user_by_id($id=0) {
    global $db;
    $sql = "SELECT * FROM users WHERE id='" . db_escape($db, $id) . "' LIMIT 1;";
    $users_result = db_query($db, $sql);
    return $users_result;
  }

  function validate_user($user, $errors=array()) {
    if (is_blank($user['first_name'])) {
      $errors[] = "First name cannot be blank.";
    } elseif (!has_length($user['first_name'], array('min' => 2, 'max' => 255))) {
      $errors[] = "First name must be between 2 and 255 characters.";
    } elseif (!has_valid_name_character($user['first_name'])) {
      $errors[] = "First name must contain only whitelisted characters: A-Z, a-z, spaces, and -,.'";
    }

    if (is_blank($user['last_name'])) {
      $errors[] = "Last name cannot be blank.";
    } elseif (!has_length($user['last_name'], array('min' => 2, 'max' => 255))) {
      $errors[] = "Last name must be between 2 and 255 characters.";
    } elseif (!has_valid_name_character($user['last_name'])) {
      $errors[] = "Last name must contain only whitelisted characters: A-Z, a-z, spaces, and -,.'";
    }

    if (is_blank($user['email'])) {
      $errors[] = "Email cannot be blank.";
    } elseif (!has_valid_email_format($user['email'])) {
      $errors[] = "Email must be a valid format.";
    } elseif (!has_valid_email_character($user['email'])) {
      $errors[] = "Email must contain only the whitelisted characters: A-Z, a-z, 0-9, and @._-";
    }

    if (is_blank($user['username'])) {
      $errors[] = "Username cannot be blank.";
    } elseif (!has_length($user['username'], array('max' => 255))) {
      $errors[] = "Username must be less than 255 characters.";
    } elseif (!has_valid_username_character($user['username'])) {
      $errors[] = "Username must contain only the whitelisted characters: A-Z, a-z, 0-9, and _.";
    }

    return $errors;
  }

  // Add a new user to the table
  // Either returns true or an array of errors
  function insert_user($user) {
    global $db;

    $errors = validate_user($user);
    if (!has_unique_username($user['username'])) {
      $errors[] = "Username must be unique.";
    }
    if (!has_unique_user_email($user['email'])) {
      $errors[] = "Email must be unique.";
    }
    
    if (!empty($errors)) {
      return $errors;
    }

    $created_at = date("Y-m-d H:i:s");
    $sql = "INSERT INTO users ";
    $sql .= "(first_name, last_name, email, username, created_at) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $user['first_name']) . "',";
    $sql .= "'" . db_escape($db, $user['last_name']) . "',";
    $sql .= "'" . db_escape($db, $user['email']) . "',";
    $sql .= "'" . db_escape($db, $user['username']) . "',";
    $sql .= "'" . db_escape($db, $created_at) . "'";
    $sql .= ");";
    // For INSERT statments, $result is just true/false
    $result = db_query($db, $sql);
    if($result) {
      return true;
    } else {
      // The SQL INSERT statement failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }

  // Edit a user record
  // Either returns true or an array of errors
  function update_user($user) {
    global $db;

    $errors = validate_user($user);
    if (!has_unique_username($user['username'], $user['id'])) {
      $errors[] = "Username must be unique.";
    }
    if (!has_unique_user_email($user['email'], $user['id'])) {
      $errors[] = "Email must be unique.";
    }

    if (!empty($errors)) {
      return $errors;
    }

    $sql = "UPDATE users SET ";
    $sql .= "first_name='" . db_escape($db, $user['first_name']) . "', ";
    $sql .= "last_name='" . db_escape($db, $user['last_name']) . "', ";
    $sql .= "email='" . db_escape($db, $user['email']) . "', ";
    $sql .= "username='" . db_escape($db, $user['username']) . "' ";
    $sql .= "WHERE id='" . db_escape($db, $user['id']) . "' ";
    $sql .= "LIMIT 1;";
    // For update_user statments, $result is just true/false
    $result = db_query($db, $sql);
    if($result) {
      return true;
    } else {
      // The SQL UPDATE statement failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }

  function delete_user($user) {
    global $db;

    $errors = validate_user($user);
    if (!empty($errors)) {
      return $errors;
    }

    $sql = "DELETE FROM users ";
    $sql .= "WHERE first_name='" . db_escape($db, $user['first_name']) . "' AND ";
    $sql .= "last_name='" . db_escape($db, $user['last_name']) . "' AND ";
    $sql .= "email='" . db_escape($db, $user['email']) . "' AND ";
    $sql .= "username='" . db_escape($db, $user['username']) . "' AND ";
    $sql .= "id='" . db_escape($db, $user['id']) . "' ";
    $sql .= "LIMIT 1;";
    // For delete_user statments, $result is just true/false
    $result = db_query($db, $sql);
    if($result) {
      return true;
    } else {
      // The SQL UPDATE statement failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }

  //
  // COUNTRY QUERIES
  //

  // Find country using id
  function find_country_by_id($id=0) {
    global $db;
    $sql = "SELECT * FROM countries WHERE id='" . db_escape($db, $id) . "' LIMIT 1;";
    $users_result = db_query($db, $sql);
    return $users_result;
  }

  function validate_country($country, $errors=array()) {
    if (is_blank($country['name'])) {
      $errors[] = "Name cannot be blank.";
    } elseif (!has_length($country['name'], array('min' => 2, 'max' => 255))) {
      $errors[] = "Name must be between 2 and 255 characters.";
    } elseif (!has_valid_name_character($country['name'])) {
      $errors[] = "Name must contain only whitelisted characters: A-Z, a-z, spaces, and -,.'";
    }

    if (is_blank($country['code'])) {
      $errors[] = "Code cannot be blank.";
    } elseif (!has_length($country['code'], array('min' => 2, 'max' => 255))) {
      $errors[] = "Code must be a valid format.";
    } elseif (!has_valid_code_character($country['code'])) {
      $errors[] = "Code must contain only the whitelisted characters: A-Z";
    }

    return $errors;
  }

  // Add a new country to the table
  // Either returns true or an array of errors
  function insert_country($country) {
    global $db;

    $errors = validate_country($country);
    if (!has_unique_country_name($country['name'])) {
      $errors[] = "Name must be unique.";
    }
    if (!has_unique_country_code($country['code'])) {
      $errors[] = "Code must be unique.";
    }

    if (!empty($errors)) {
      return $errors;
    }

    $sql = "INSERT INTO countries ";
    $sql .= "(name, code) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $country['name']) . "',";
    $sql .= "'" . db_escape($db, $country['code']) . "'";
    $sql .= ");";
    // For INSERT statments, $result is just true/false
    $result = db_query($db, $sql);
    if($result) {
      return true;
    } else {
      // The SQL INSERT statement failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }

  // Edit a country record
  // Either returns true or an array of errors
  function update_country($country) {
    global $db;

    $errors = validate_country($country);
    if (!has_unique_country_name($country['name'], $country['id'])) {
      $errors[] = "Name must be unique.";
    }
    if (!has_unique_country_code($country['code'], $country['id'])) {
      $errors[] = "Code must be unique.";
    }

    if (!empty($errors)) {
      return $errors;
    }

    $sql = "UPDATE countries SET ";
    $sql .= "name='" . db_escape($db, $country['name']) . "', ";
    $sql .= "code='" . db_escape($db, $country['code']) . "' ";
    $sql .= "WHERE id='" . db_escape($db, $country['id']) . "' ";
    $sql .= "LIMIT 1;";
    // For update_user statments, $result is just true/false
    $result = db_query($db, $sql);
    print_r($country);
    if($result) {
      return true;
    } else {
      // The SQL UPDATE statement failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }

?>
