<?php
/**
 * @package Moar\Log
 */

namespace Moar\Log;


/**
 * @package Moar\Log
 * @copyright 2013 Bryan Davis and contributors. All Rights Reserved.
 */
class MDCTest extends \PHPUnit_Framework_TestCase {

  public function test_singleton () {
    $a = MDC::defaultMDC();
    $b = MDC::defaultMDC();

    $this->assertSame($a, $b);
  } //end test_singleton

  public function test_shared_array_access () {
    $a = MDC::defaultMDC();
    $b = MDC::defaultMDC();

    $a->put('test', 'test');

    $this->assertEquals('test', $a->get('test'));
    $this->assertEquals('test', $b->get('test'));
    $this->assertSame($a->get('test'), $b->get('test'));

    $b->put('tset', 'tset');

    $this->assertEquals('tset', $b->get('tset'));
    $this->assertEquals('tset', $a->get('tset'));
    $this->assertSame($b->get('tset'), $a->get('tset'));
  } //end test_shared_array_access

  public function test_remove () {
    $fixture = new MDC();
    $fixture->put('a', 1);
    $this->assertEquals(1, $fixture->get('a'));
    $fixture->remove('a');
    $this->assertNull($fixture->get('a'));
  } //end test_remove

  public function test_clear () {
    $expect = array(
        'foo' => 'foo',
        'bar' => 'bar',
        'baz' => 'baz',
      );

    $fixture = new MDC($expect);
    foreach ($expect as $key => $value) {
      $this->assertNotNull($fixture->get($key));
    }

    $fixture->clear();
    $this->assertEmpty($fixture->getContext());
  } //end test_clear

  public function test_common_keys () {
    $_SERVER['REMOTE_ADDR'] = 'REMOTE_ADDR';
    $_SERVER['HTTP_HOST'] = 'HTTP_HOST';

    $fixture = new MDC();
    $fixture->putCommonKeys();
    $this->assertEquals('REMOTE_ADDR', $fixture->get(MDC::KEY_REMOTE_ADDR));
    $this->assertEquals('HTTP_HOST', $fixture->get(MDC::KEY_VHOST));
  } //end test_common_keys


  public function test_tostring () {
    $fixture = new MDC();

    $fixture->put('a', 'a');
    $this->assertEquals('a=a', (string) $fixture);

    $fixture->put('b', 'b');
    $this->assertEquals('a=a b=b', (string) $fixture);
  } //end test_tostring


} //end MDCTest
