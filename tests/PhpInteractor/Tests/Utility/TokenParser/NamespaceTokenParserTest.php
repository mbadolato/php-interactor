<?php

/**
 * This file is part of the PhpInteractor package
 *
 * @package    PhpInteractor
 * @author     Mark Badolato <mbadolato@cybernox.com>
 * @copyright  Copyright (c) CyberNox Technologies. All rights reserved.
 * @license    http://www.opensource.org/licenses/MIT MIT License
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpInteractor\Tests\Utility\TokenParser;

use PhpInteractor\Utility\TokenParser\NamespaceTokenParser;

class NamespaceTokenParserTest extends \PHPUnit_Framework_TestCase
{
    const GOOD_CLASS        = 'GoodInteractor1';
    const GOOD_NAMESPACE    = 'PhpInteractor\Tests\Interactor';
    const BAD_CLASS         = 'NoClassDefined';
    const BAD_NAMESPACE     = 'NoNamespaceDefined';

    /** @test */
    public function namespaceFound()
    {
        $namespace = NamespaceTokenParser::parse($this->getTokensForFile(self::GOOD_CLASS));
        $this->assertEquals(self::GOOD_NAMESPACE, $namespace);
    }

    /** @test */
    public function classNameNotFound()
    {
        $namespace = NamespaceTokenParser::parse($this->getTokensForFile(self::BAD_NAMESPACE));
        $this->assertEquals('', $namespace);
    }

    private function getFileContents($filename)
    {
        return file_get_contents(sprintf("%s/../../Interactor/%s.php", __DIR__, $filename));
    }

    private function getTokensForFile($filename)
    {
        return token_get_all($this->getFileContents($filename));
    }
}
