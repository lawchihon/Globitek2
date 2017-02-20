<?php

  // is_blank('abcd')
  function is_blank($value='') {
    // TODO
    return strlen($value) == 0;
  }

  // has_length('abcd', ['min' => 3, 'max' => 5])
  function has_length($value, $options=array()) {
    // TODO
    $min = isset($options['min']) ? $options['min'] : 1;
    $max = isset($options['max']) ? $options['max'] : 255;

    return strlen($value) >= $min && strlen($value) <= $max;
  }

  // has_valid_email_format('test@test.com')
  function has_valid_email_format($value) {
    // TODO
    return filter_var($value, FILTER_VALIDATE_EMAIL);
  }

  // has_valid_name_character('John')
  function has_valid_name_character($value) {
    return preg_match('/\A[A-Za-z\s\-,\.\']+\Z/', $value);
  }
  
  // has_valid_username_character('lawchihon')
  function has_valid_username_character($value) {
    return preg_match('/\A[A-Za-z0-9\_\.]+\Z/', $value);
  }

  // has_valid_email_character('chlaw@ucsd.edu')
  function has_valid_email_character($value) {
    return preg_match('/\A[A-Za-z0-9\_\@\.\-]+\Z/', $value);
  }
  
  function has_valid_phone_character($value) {
    return preg_match('/\A[0-9\-\(\)\ ]+\Z/', $value);
  }

  function has_valid_position_character($value) {
    return preg_match('/\A[0-9]+\Z/', $value);
  }

  function has_valid_code_character($value) {
    return preg_match('/\A[A-Z]+\Z/', $value);
  }
  
  function has_valid_state_code_character($value) {
    return preg_match('/\A[A-Za-z0-9]+\Z/', $value);
  }

  function has_valid_id_character($value) {
    return preg_match('/\A[0-9]+\Z/', $value);
  }

  function has_unique_username($value, $id=-1) {
    global $db;

    $sql = "SELECT * FROM users WHERE username='$value' AND id!='$id';";
    $result = db_query($db, $sql);
    if($result) {
      return $result->num_rows == 0;
    } else {
      // The SQL INSERT statement failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }

  function has_unique_user_email($value, $id=-1) {
    global $db;

    $sql = "SELECT * FROM users WHERE email='$value' AND id!='$id';";
    $result = db_query($db, $sql);
    if($result) {
      return $result->num_rows == 0;
    } else {
      // The SQL INSERT statement failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }

  function has_unique_sales_email($value, $id=-1) {
    global $db;

    $sql = "SELECT * FROM salespeople WHERE email='$value' AND id!='$id';";
    $result = db_query($db, $sql);
    if($result) {
      return $result->num_rows == 0;
    } else {
      // The SQL INSERT statement failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }
  
  function has_unique_country_name($value, $id=-1) {
    global $db;

    $sql = "SELECT * FROM countries WHERE name='$value' AND id!='$id';";
    $result = db_query($db, $sql);
    if($result) {
      return $result->num_rows == 0;
    } else {
      // The SQL INSERT statement failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }

  function has_unique_country_code($value, $id=-1) {
    global $db;

    $sql = "SELECT * FROM countries WHERE code='$value' AND id!='$id';";
    $result = db_query($db, $sql);
    if($result) {
      return $result->num_rows == 0;
    } else {
      // The SQL INSERT statement failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }

  function has_unique_state_name($value, $country_id, $id=-1) {
    global $db;

    $sql = "SELECT * FROM states WHERE name='$value' AND country_id='$country_id' AND id!='$id';";
    $result = db_query($db, $sql);
    if($result) {
      return $result->num_rows == 0;
    } else {
      // The SQL INSERT statement failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }

  function has_unique_state_code($value, $country_id, $id=-1) {
    global $db;

    $sql = "SELECT * FROM states WHERE code='$value' AND country_id='$country_id' AND id!='$id';";
    $result = db_query($db, $sql);
    if($result) {
      return $result->num_rows == 0;
    } else {
      // The SQL INSERT statement failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }


  function has_unique_territory_name($value, $state_id, $id=-1) {
    global $db;

    $sql = "SELECT * FROM territories WHERE name='$value' AND state_id='$state_id' AND id!='$id';";
    $result = db_query($db, $sql);
    if($result) {
      return $result->num_rows == 0;
    } else {
      // The SQL INSERT statement failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }

  function has_unique_territory_position($value, $state_id, $id=-1) {
    global $db;

    $sql = "SELECT * FROM territories WHERE position='$value' AND state_id='$state_id' AND id!='$id';";
    $result = db_query($db, $sql);
    if($result) {
      return $result->num_rows == 0;
    } else {
      // The SQL INSERT statement failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }

?>
