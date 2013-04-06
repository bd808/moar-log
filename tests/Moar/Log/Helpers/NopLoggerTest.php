<?php
/**
 * @package Moar\Log\Helpers
 */

namespace Moar\Log\Helpers;

/**
 * @package Moar\Log\Helpers
 * @copyright 2013 Bryan Davis and contributors. All Rights Reserved.
 */
class NopLoggerTest extends \PHPUnit_Framework_TestCase {

  public function test_nop () {
    $log = new NopLogger();
    $log->emergency("This shouldn't go anywhere.");
    $this->assertTrue(true);
  }

} //end NopLoggerTest
