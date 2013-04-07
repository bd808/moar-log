<?php
/**
 * @package Moar\Log\Monolog
 */

namespace Moar\Log\Monolog;

use Monolog\Logger;

/**
 * Subclass of Monolog log channel designed for hierarchical logging.
 *
 * Monolog keeps it's handler and processor chains in protected members. We
 * extend the Logger class so that we can get access to another Loggers
 * chains. This allows us to copy the chains of a parent handler.
 *
 * @package Moar\Log\Monolog
 * @copyright 2013 Bryan Davis and contributors. All Rights Reserved.
 */
class HierarchialLogger extends Logger {

  /**
   * @var int
   */
  protected $level = Logger::DEBUG;

  /**
   * Set this logger's parent logger.
   *
   * @param HierarchialLogger $parent Parent logger
   * @return void
   */
  public function setParent (Logger $parent) {
    $this->handlers = $parent->handlers;
    $this->processors = $parent->processors;
    $this->level = $parent->level;
  }

  /**
   * Sets minimum logging level at which this channel will emit.
   *
   * @param int $level Level
   * @return void
   */
  public function setLevel ($level) {
    $this->level = $level;
  }

  public function isHandling ($level) {
    if ($level >= $this->level) {
      return parent::isHandling($level);
    }
    return false;
  }

  public function addRecord ($level, $message, array $context = array()) {
    if ($level >= $this->level) {
      return parent::addRecord($level, $message, $context);
    }
    return false;
  }

} //end HierarchialLogger
