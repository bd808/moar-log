<?php
/**
 * @package Moar\Log
 */

namespace Moar\Log;

use Moar\Log\Helpers\NOPLoggerFactory;
use Psr\Log\LoggerInterface;

/**
 * Logger instance factory.
 *
 * The pattern suggested by PSR-3 is for all objects desiring to log messages
 * to implement the Psr\Log\LoggerAwareInterface interface so that a Logger
 * instance can be provided via dependency injection or other object wiring
 * means. Moar finds this pattern to be less than desirable since we prefer
 * explicit over implicit DI wiring and also believe that any and all objects
 * should use logging.
 *
 * Moar prefers to use a factory pattern for creating Logger instances, but we
 * don't want to couple our code to any particular PSR-3 implementation at the
 * factory level. This class and it's associated interfaces provide a SPI that
 * can be used to bind any PSR-3 compliant logging system to a Moar
 * application. The API for this is taken from the SLF4J project.
 *
 * @package Moar\Log
 * @copyright 2013 Bryan Davis and contributors. All Rights Reserved.
 */
class LoggerFactory {

  /**
   * Get a logger instance with the given name.
   *
   * @param string $name Name of the logger
   * @return LoggerInterface
   */
  public static function getLogger ($name) {
    $factory = self::getILoggerFactory();
    return $factory->getLogger($name);
  }

  /**
   * Get the currently configured ILoggerFactory.
   *
   * @return ILoggerFactory Logger factory
   */
  public static function getILoggerFactory () {
    static $nop;
    if (null === self::$factory) {
      if (null == $nop) {
        $nop = new NOPLoggerFactory();
      }
      return $nop;
    }
    return self::$factory;
  }

  /**
   * Set the IloggerFactory to use for crating logger instances.
   *
   * @param ILoggerFactory $factory Factory instance
   * @return void
   */
  public static function setILoggerFactory ($factory) {
    self::$factory = $factory;
  }

  /**
   * Logger factory implementation.
   * @var ILoggerFactory
   */
  private static $factory;

  /**
   * Construction of utility class is not allowed.
   */
  private function __construct () {
    // no-op
  }

} //end LoggerFactory
