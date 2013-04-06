<?php
/**
 * @package Moar\Log
 */

namespace Moar\Log;

use Moar\Log\LoggerFactoryTest\TestFactory;

/**
 * @package Moar\Log
 * @copyright 2013 Bryan Davis and contributors. All Rights Reserved.
 */
class LoggerFactoryTest extends \PHPUnit_Framework_TestCase {

  public function test_unconfigured_gives_nop () {
    $log = LoggerFactory::getLogger('foo');
    $this->assertInstanceof('Moar\Log\Helpers\NopLogger', $log);
  }

  public function test_set_factory () {
    $ifact = new TestFactory();
    LoggerFactory::setILoggerFactory($ifact);
    $this->assertSame($ifact, LoggerFactory::getILoggerFactory());
  }

} //end LoggerFactoryTest

namespace Moar\Log\LoggerFactoryTest;

use Moar\Log\ILoggerFactory;
use Moar\Log\Helpers\NopLogger;

class TestFactory implements ILoggerFactory {
  public function getLogger ($name) {
    return new TestLogger($name);
  }
}

class TestLogger extends NopLogger {
  public $name;
  public function __construct ($name) {
    $this->name = $name;
  }
}
