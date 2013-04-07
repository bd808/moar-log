<?php
/**
 * @package Moar\Log\Helpers
 */

namespace Moar\Log\Helpers;

/**
 * @package Moar\Log\Helpers
 * @copyright 2013 Bryan Davis and contributors. All Rights Reserved.
 */
class Util {

  /**
   * Normalize a given logger name.
   *
   * Removes characters other than letters, digits and periods. Underscores
   * and backslashes are converted to periods. This results in names which can
   * easily be used for hierarical logger configurations.
   *
   * @param mixed $name Logger name or class to create name for
   * @return string Normalized name
   */
  public static function normalizeName ($name) {
    if (is_object($name)) {
      $name = get_class($name);
    } else {
      $name = (string) $name;
    }

    // strip all non-normal characters from input
    $name = preg_replace('/[^\w\.\\\\]+/', '', $name);
    // convert namespace delimiters to periods
    $name = preg_replace('/[\\_]/', '.', $name);

    return $name;
  } //end normalizeName

} //end Util
