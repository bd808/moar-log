<?php
/**
 * @package Moar\Log
 */

namespace Moar\Log;

use Psr\Log\LoggerInterface;

/**
 * ILoggerFactory instances manufacture LoggerInterface instances by name.
 *
 * @package Moar\Log
 * @copyright 2013 Bryan Davis and contributors. All Rights Reserved.
 */
interface ILoggerFactory {

  /**
   * Get a logger instance with the given name.
   *
   * @param string $name Name of the logger
   * @return LoggerInterface
   */
  public function getLogger ($name);

} //end ILoggerFactory
