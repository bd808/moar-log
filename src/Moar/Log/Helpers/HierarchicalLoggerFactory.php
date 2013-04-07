<?php
/**
 * @package Moar\Log\Helpers
 */

namespace Moar\Log\Helpers;

use Moar\Log\ILoggerFactory;
use Psr\Log\LoggerInterface;

/**
 * Helper for creating hierarchically organized logger instances.
 *
 * @package Moar\Log\Helpers
 * @copyright 2013 Bryan Davis and contributors. All Rights Reserved.
 */
abstract class HierarchicalLoggerFactory implements ILoggerFactory {

  /**
   * Logger instance cache.
   * @var array
   */
  protected $logs;

  /**
   * Register a LoggerInterface instance.
   *
   * @param string $name Logger name
   * @param LoggerInterface $logger Logger
   * @return void
   */
  public function register ($name, LoggerInterface $logger) {
    $name = Util::normalizeName($name);
    $this->logs[$name] = $logger;
  } //end register

  /**
   * Get the default logger.
   *
   * Must return the same logger instance on each call.
   *
   * @return LoggerInterface
   */
  abstract public function getDafaultLogger ();

  /**
   * Create a new LoggerInterface instance.
   *
   * @param string $name Name of new logger
   * @param LoggerInterface $parent Closest known ancestor logger
   * @return LoggerInterface Logger
   */
  abstract protected function newLogger ($name, LoggerInterface $parent);

  /**
   * @param string $name Name of new logger
   * @return LoggerInterface Parent logger
   */
  protected function findParent ($name) {
    $name = Util::normalizeName($name);
    $parts = explode('.', $name);
    while (!isset($this->logs[$name]) && !empty($parts)) {
      array_pop($parts);
      $name = implode('.', $parts);
    }
    if (isset($this->logs[$name])) {
      return $this->logs[$name];
    } else {
      return $this->getDafaultLogger();
    }
  } //end findParent

  /**
   * Get a logger instance with the given name.
   *
   * @param string $name Name of the logger
   * @return LoggerInterface
   */
  public function getLogger ($name) {
    if (!isset($this->logs[$name])) {
      $this->logs[$name] = $this->newLogger($name, $this->findParent($name));
    }
    return $this->logs[$name];
  } //end getLogger

} //end NopLoggerFactory
