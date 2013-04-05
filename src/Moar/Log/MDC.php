<?php
/**
 * @package Moar\Log
 */

namespace Moar\Log;


/**
 * Based on the org.apache.log4j.MDC class, a MDC is a
 * collection of (name, value) pairs that add useful diagnostic information to
 * a log event.
 *
 * This is especially useful in a interleaved logging context as
 * when a web server handles multiple connections near-simultaneously. The
 * diagnostic context can be used to give a distinctive stamp to each message
 * associated with a particular request.
 *
 * @package Moar\Log
 * @copyright 2013 Bryan Davis and contributors. All Rights Reserved.
 */
class MDC {

  /**
   * MDC key for putServerHostname().
   * @var string
   */
  const KEY_SERVER_HOSTNAME = 'svr';

  /**
   * MDC key for putRemoteAddress().
   * @var string
   */
  const KEY_REMOTE_ADDR = 'ip';

  /**
   * MDC key for putVhost().
   * @var string
   */
  const KEY_VHOST = 'vhost';

  /**
   * @var MDC
   */
  protected static $singleton = null;


  /**
   * Context data
   * @var array
   */
  protected $map;


  /**
   * Constructor.
   * @param array $data Initial data
   */
  public function __construct ($data = null) {
    if (null == $data) {
      $data = array();
    }
    $this->map = $data;
  }


  /**
   * Get the context identified by the given key.
   *
   * @param string $key Key
   * @return mixed Context
   */
  public function get ($key) {
    if (isset($this->map[$key])) {
      return $this->map[$key];
    }
    return null;
  }


  /**
   * Put a value into the current context.
   *
   * @param string $key Key
   * @param mixed $value Context value
   * @return MDC Self
   */
  public function put ($key, $value) {
    $this->map[$key] = $value;
    return $this;
  }


  /**
   * Remove the context identified by the given key.
   *
   * @param string $key Key
   * @return MDC Self
   */
  public function remove ($key) {
    unset($this->map[$key]);
    return $this;
  }


  /**
   * Remove all data from context.
   * @return MDC Self
   */
  public function clear () {
    $this->map = array();
    return $this;
  }


  /**
   * Add server hostname minus domain (eg "example.com") into this logging
   * context.
   * @return MDC Self
   */
  public function putServerHostname () {
    return $this->put(self::KEY_SERVER_HOSTNAME,
        implode('.', array_slice(explode('.', php_uname('n')), 0, -2)));
  }


  /**
   * Add remote user's ip address to this logging context if available.
   * @return MDC Self
   */
  public function putRemoteAddress () {
    if (isset($_SERVER['REMOTE_ADDR'])) {
      $this->put(self::KEY_REMOTE_ADDR, $_SERVER['REMOTE_ADDR']);
    }
    return $this;
  }


  /**
   * Add apache vhost name to this logging context if available.
   * @return MDC Self
   */
  public function putVhost () {
    if (isset($_SERVER['HTTP_HOST'])) {
      $this->put(self::KEY_VHOST, $_SERVER['HTTP_HOST']);
    }
    return $this;
  }


  /**
   * Put commonly desirable keys (ip, vhost) in this logging context.
   * @return MDC Self
   */
  public function putCommonKeys () {
    return $this->putVhost()
        ->putRemoteAddress();
  }


  /**
   * Get the current context as a hashtable.
   *
   * This method is intended to be used by friendly classes. Normal userspace
   * code typically won't have a need for direct access to the underlying
   * context.
   *
   * @return array context
   */
  public function getContext () {
    return $this->map;
  }


  /**
   * Human readable string.
   * @return string
   */
  public function __toString () {
    return self::formatMDC($this->map);
  }

  /**
   * Format a context as a space separated key=value string.
   *
   * @param array $ctxData Context data
   * @return string Formatted data
   */
  public static function formatMDC ($ctxData) {
    if ($ctxData) {
      // add context data as a series of space separated key=value pairs
      $stack = array();
      foreach ($ctxData as $key => $value) {
        $stack[] = "{$key}={$value}";
      }
      $ctx = implode(' ', $stack);
    } else {
      $ctx = '';
    }

    return $ctx;
  } //end formatMDC

  /**
   * Get the "default" shared MDC.
   *
   * Php can typically be considered a shared-nothing, single-threaded
   * container. As such you usually don't need to worry about all of the
   * thread-local isolation issues that you would have in a Java Servlet
   * container or another multitenant hosting container.
   *
   * @return MDC Shared context
   */
  public static function defaultMDC () {
    if (null == self::$singleton) {
      self::$singleton = new MDC();
    }
    return self::$singleton;
  }

} //end MDC
