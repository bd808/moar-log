<?php
/**
 * @package Moar\Log\Helpers
 */

namespace Moar\Log\Helpers;

/**
 * @package Moar\Log\Helpers
 * @copyright 2013 Bryan Davis and contributors. All Rights Reserved.
 */
class NopLoggerFactoryTest extends \PHPUnit_Framework_TestCase {

  public function test_loggers_are_singleton () {
    $fact = new NopLoggerFactory();
    $foo = $fact->getLogger('foo');
    $bar = $fact->getLogger('bar');
    $this->assertSame($foo, $bar);
  }

} //end NopLoggerFactoryTest
