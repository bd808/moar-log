<?php
/**
 * @package Moar\Log\Monolog
 */

namespace Moar\Log\Monolog;

/**
 * @package Moar\Log\Monolog
 * @copyright 2013 Bryan Davis and contributors. All Rights Reserved.
 */
class LoggerFactoryTest extends \PHPUnit_Framework_TestCase {

  public function test_example_usage () {
    $logFactory = new LoggerFactory();
    $root = $logFactory->getDafaultLogger();
    // configure the logger
    //
    \Moar\Log\LoggerFactory::setILoggerFactory($logFactory);

    $fooLog = \Moar\Log\LoggerFactory::getLogger('foo.bar.baz');
    $this->assertInstanceOf('Moar\Log\Monolog\HierarchialLogger', $fooLog);
    $this->assertEquals('foo.bar.baz', $fooLog->getName());
  } //end test_example_usage

} //end LoggerFactoryTest
