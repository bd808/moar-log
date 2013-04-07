<?php
/**
 * @package Moar\Log\Monolog
 */

namespace Moar\Log\Monolog;

use Moar\Log\Helpers\HierarchicalLoggerFactory;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

/**
 * Logger factory for Monolog instances.
 *
 * @package Moar\Log\Monolog
 * @copyright 2013 Bryan Davis and contributors. All Rights Reserved.
 */
class LoggerFactory extends HierarchicalLoggerFactory {

  /**
   * @var Logger
   */
  protected $root;

  /**
   * Get the default logger.
   *
   * Must return the same logger instance on each call.
   *
   * @return LoggerInterface
   */
  public function getDafaultLogger () {
    if (null === $this->root) {
      $this->root = new HierarchialLogger(null);
    }
    return $this->root;
  } //end getDafaultLogger

  /**
   * Create a new LoggerInterface instance.
   *
   * @param string $name Name of new logger
   * @param LoggerInterface $parent Closest known ancestor logger
   * @return LoggerInterface Logger
   */
  protected function newLogger ($name, LoggerInterface $parent) {
    $logger = $parent;
    if ($parent instanceof HierarchialLogger) {
      $logger = new HierarchialLogger($name);
      $logger->setParent($parent);
    }
    return $logger;
  } //end newLogger

} //end MonologLoggerFactory
