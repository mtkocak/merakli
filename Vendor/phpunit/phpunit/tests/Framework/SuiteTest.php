<?php
/**
 * PHPUnit
 *
 * Copyright (c) 2001-2014, Sebastian Bergmann <sebastian@phpunit.de>.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the name of Sebastian Bergmann nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @package    PHPUnit
 * @author     Sebastian Bergmann <sebastian@phpunit.de>
 * @copyright  2001-2014 Sebastian Bergmann <sebastian@phpunit.de>
 * @license    http://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
 * @link       http://www.phpunit.de/
 * @since      File available since Release 2.0.0
 */

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . '_files' . DIRECTORY_SEPARATOR . 'BeforeAndAfterTest.php';
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . '_files' . DIRECTORY_SEPARATOR . 'BeforeClassAndAfterClassTest.php';
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . '_files' . DIRECTORY_SEPARATOR . 'DataProviderSkippedTest.php';
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . '_files' . DIRECTORY_SEPARATOR . 'DataProviderIncompleteTest.php';
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . '_files' . DIRECTORY_SEPARATOR . 'InheritedTestCase.php';
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . '_files' . DIRECTORY_SEPARATOR . 'NoTestCaseClass.php';
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . '_files' . DIRECTORY_SEPARATOR . 'NoTestCases.php';
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . '_files' . DIRECTORY_SEPARATOR . 'NotPublicTestCase.php';
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . '_files' . DIRECTORY_SEPARATOR . 'NotVoidTestCase.php';
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . '_files' . DIRECTORY_SEPARATOR . 'OverrideTestCase.php';
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . '_files' . DIRECTORY_SEPARATOR . 'RequirementsClassBeforeClassHookTest.php';

/**
 *
 *
 * @package    PHPUnit
 * @author     Sebastian Bergmann <sebastian@phpunit.de>
 * @copyright  2001-2014 Sebastian Bergmann <sebastian@phpunit.de>
 * @license    http://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
 * @link       http://www.phpunit.de/
 * @since      Class available since Release 2.0.0
 * @covers     PHPUnit_Framework_TestSuite
 */
class Framework_SuiteTest extends PHPUnit_Framework_TestCase
{
    protected $result;

    protected function setUp()
    {
        $this->result = new PHPUnit_Framework_TestResult;
    }

    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite;

        $suite->addTest(new Framework_SuiteTest('testAddTestSuite'));
        $suite->addTest(new Framework_SuiteTest('testInheritedTests'));
        $suite->addTest(new Framework_SuiteTest('testNoTestCases'));
        $suite->addTest(new Framework_SuiteTest('testNoTestCaseClass'));
        $suite->addTest(new Framework_SuiteTest('testNotExistingTestCase'));
        $suite->addTest(new Framework_SuiteTest('testNotPublicTestCase'));
        $suite->addTest(new Framework_SuiteTest('testNotVoidTestCase'));
        $suite->addTest(new Framework_SuiteTest('testOneTestCase'));
        $suite->addTest(new Framework_SuiteTest('testShadowedTests'));
        $suite->addTest(new Framework_SuiteTest('testBeforeClassAndAfterClassAnnotations'));
        $suite->addTest(new Framework_SuiteTest('testBeforeAnnotation'));
        $suite->addTest(new Framework_SuiteTest('testSkippedTestDataProvider'));
        $suite->addTest(new Framework_SuiteTest('testIncompleteTestDataProvider'));
        $suite->addTest(new Framework_SuiteTest('testRequirementsBeforeClassHook'));
        $suite->addTest(new Framework_SuiteTest('testDontSkipInheritedClass'));

        return $suite;
    }

    public function testAddTestSuite()
    {
        $suite = new PHPUnit_Framework_TestSuite(
            'OneTestCase'
        );

        $suite->run($this->result);

        $this->assertEquals(1, count($this->result));
    }

    public function testInheritedTests()
    {
        $suite = new PHPUnit_Framework_TestSuite(
            'InheritedTestCase'
        );

        $suite->run($this->result);

        $this->assertTrue($this->result->wasSuccessful());
        $this->assertEquals(2, count($this->result));
    }

    public function testNoTestCases()
    {
        $suite = new PHPUnit_Framework_TestSuite(
            'NoTestCases'
        );

        $suite->run($this->result);

        $this->assertTrue(!$this->result->wasSuccessful());
        $this->assertEquals(1, $this->result->failureCount());
        $this->assertEquals(1, count($this->result));
    }

    /**
     * @expectedException PHPUnit_Framework_Exception
     */
    public function testNoTestCaseClass()
    {
        $suite = new PHPUnit_Framework_TestSuite('NoTestCaseClass');
    }

    public function testNotExistingTestCase()
    {
        $suite = new Framework_SuiteTest('notExistingMethod');

        $suite->run($this->result);

        $this->assertEquals(0, $this->result->errorCount());
        $this->assertEquals(1, $this->result->failureCount());
        $this->assertEquals(1, count($this->result));
    }

    public function testNotPublicTestCase()
    {
        $suite = new PHPUnit_Framework_TestSuite(
            'NotPublicTestCase'
        );

        $this->assertEquals(2, count($suite));
    }

    public function testNotVoidTestCase()
    {
        $suite = new PHPUnit_Framework_TestSuite(
            'NotVoidTestCase'
        );

        $this->assertEquals(1, count($suite));
    }

    public function testOneTestCase()
    {
        $suite = new PHPUnit_Framework_TestSuite(
            'OneTestCase'
        );

        $suite->run($this->result);

        $this->assertEquals(0, $this->result->errorCount());
        $this->assertEquals(0, $this->result->failureCount());
        $this->assertEquals(1, count($this->result));
        $this->assertTrue($this->result->wasSuccessful());
    }

    public function testShadowedTests()
    {
        $suite = new PHPUnit_Framework_TestSuite(
            'OverrideTestCase'
        );

        $suite->run($this->result);

        $this->assertEquals(1, count($this->result));
    }

    public function testBeforeClassAndAfterClassAnnotations()
    {
        $suite = new PHPUnit_Framework_TestSuite(
            'BeforeClassAndAfterClassTest'
        );

        BeforeClassAndAfterClassTest::resetProperties();
        $suite->run($this->result);

        $this->assertEquals(1, BeforeClassAndAfterClassTest::$beforeClassWasRun, "@beforeClass method was not run once for the whole suite.");
        $this->assertEquals(1, BeforeClassAndAfterClassTest::$afterClassWasRun, "@afterClass method was not run once for the whole suite.");
    }

    public function testBeforeAnnotation()
    {
        $test = new PHPUnit_Framework_TestSuite(
            'BeforeAndAfterTest'
        );

        BeforeAndAfterTest::resetProperties();
        $result = $test->run();

        $this->assertEquals(2, BeforeAndAfterTest::$beforeWasRun);
        $this->assertEquals(2, BeforeAndAfterTest::$afterWasRun);
    }

    public function testSkippedTestDataProvider()
    {
        $suite = new PHPUnit_Framework_TestSuite('DataProviderSkippedTest');

        $suite->run($this->result);

        $this->assertEquals(3, $this->result->count());
        $this->assertEquals(1, $this->result->skippedCount());
    }

    public function testIncompleteTestDataProvider()
    {
        $suite = new PHPUnit_Framework_TestSuite('DataProviderIncompleteTest');

        $suite->run($this->result);

        $this->assertEquals(3, $this->result->count());
        $this->assertEquals(1, $this->result->notImplementedCount());
    }

    public function testRequirementsBeforeClassHook()
    {
        $suite = new PHPUnit_Framework_TestSuite(
            'RequirementsClassBeforeClassHookTest'
        );

        $suite->run($this->result);

        $this->assertEquals(0, $this->result->errorCount());
        $this->assertEquals(1, $this->result->skippedCount());
    }

    public function testDontSkipInheritedClass()
    {
        $suite = new PHPUnit_Framework_TestSuite(
            'DontSkipInheritedClass'
        );

        $dir = dirname(__DIR__) . DIRECTORY_SEPARATOR . '_files' . DIRECTORY_SEPARATOR . 'Inheritance' . DIRECTORY_SEPARATOR;

        $suite->addTestFile($dir . 'InheritanceA.php');
        $suite->addTestFile($dir . 'InheritanceB.php');
        $result = $suite->run();
        $this->assertEquals(2, count($result));

    }
}
