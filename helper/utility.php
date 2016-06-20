<?php

/**
 * Utility functions file.
 */

require_once('config/database_config.php');

/**
 * Sanitize data
 *
 * @param  string $input
 * @return string
 */
function sanitize_input($input) {
  $input = trim($input);
  $input = stripslashes($input);
  $input = htmlspecialchars($input);
  return $input;
}

/**
 * Creates a list states.
 *
 * @param  string $state
 * @param  object $db_result_obj
 * @return string
 */
function state_list($state, $db_result_obj) {
  $state_list = '';

  while ($row = mysqli_fetch_assoc($db_result_obj)) {
    $is_selected = '';

      if ($row['name'] === $state) {
        $is_selected = 'selected';
      }

    $state_list .= "<option value='{$row['name']}' $is_selected>{$row['name']}"
      . "</option>";
	}

	return $state_list;
}