<?php
/**
 * @package Moar\Log\Helpers
 */

namespace Moar\Log\Helpers;

use Moar\Log\ILoggerFactory;

/**
 * A do nothing logger factory.
 *
 * @package Moar\Log\Helpers
 * @copyright 2013 Bryan Davis and contributors. All Rights Reserved.
 */
class NopLoggerFactory implements ILoggerFactory {

  /**
   * Get a logger instance with the given name.
   *
   * @param string $name Name of the logger
   * @return LoggerInterface
   */
  public function getLogger ($name) {
    static $lazy;
    if (null === $lazy) {
      $lazy = new NopLogger();
    }
    return $lazy;
  }

} //end NopLoggerFactory
