<?php
/**
 * @package Moar\Log\Monolog
 */

namespace Moar\Log\Monolog;

use Monolog\Handler\TestHandler;

/**
 * @package Moar\Log\Monolog
 * @copyright 2013 Bryan Davis and contributors. All Rights Reserved.
 */
class IntegrationTest extends \PHPUnit_Framework_TestCase {

  /**
   * @var TestHandler
   */
  protected $rootHandler;

  public function setUp () {
    // create a monolog logger factory
    $logFactory = new LoggerFactory();

    // configure the default logger
    $root = $logFactory->getDafaultLogger();
    $this->rootHandler = new TestHandler();
    $root->pushHandler($this->rootHandler);

    // configure a sub handler that limits messages
    $foobar = $logFactory->getLogger('foo.bar');
    $foobar->setLevel(\Monolog\Logger::NOTICE);

    // attach the factory
    \Moar\Log\LoggerFactory::setILoggerFactory($logFactory);
  } //end setUp

  protected function getLogger ($name) {
    return \Moar\Log\LoggerFactory::getLogger($name);
  }

  public function test_basic_operations () {
    $log = $this->getLogger(__METHOD__);

    $this->assertInstanceOf('Moar\Log\Monolog\HierarchialLogger', $log);

    $log->debug("message");
    $this->assertTrue($this->rootHandler->hasDebug("message"));
  }

  public function test_squelch_at_level () {
    $log = $this->getLogger('foo.bar.baz');

    $log->debug("message");
    $this->assertFalse($this->rootHandler->hasDebug("message"));

    $log->info("message");
    $this->assertFalse($this->rootHandler->hasInfo("message"));

    $log->warning("message");
    $this->assertTrue($this->rootHandler->hasWarning("message"));
  }

} //end IntegrationTest
