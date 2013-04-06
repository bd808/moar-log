<?php
/**
 * @package Moar\Log\Helpers
 */

namespace Moar\Log\Helpers;

use Psr\Log\AbstractLogger;

/**
 * A do nothing logger.
 *
 * @package Moar\Log\Helpers
 * @copyright 2013 Bryan Davis and contributors. All Rights Reserved.
 */
class NopLogger extends AbstractLogger {

  /**
   * Silently swallow log messages.
   *
   * @param mixed $level
   * @param string $message
   * @param array $context
   * @return void
   */
  public function log ($level, $message, array $context=null) {
    // no-op
  }

} //end NopLogger
