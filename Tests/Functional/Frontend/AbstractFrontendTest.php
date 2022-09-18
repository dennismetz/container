<?php

namespace B13\Container\Tests\Functional\Frontend;

/*
 * This file is part of TYPO3 CMS-based extension "container" by b13.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

use B13\Container\Tests\Wrapper\FunctionalTestCaseFrontend;

abstract class AbstractFrontendTest extends FunctionalTestCaseFrontend
{

    /**
     * @param string $string
     * @return string
     */
    protected function prepareContent(string $string): string
    {
        $lines = explode("\n", $string);
        $notEmpty = [];
        foreach ($lines as $line) {
            if (trim($line) !== '') {
                $notEmpty[] = trim($line);
            }
        }
        $content = implode('', $notEmpty);
        $content = preg_replace('/<div id="container-start"><\/div>(.*)<div id="container-end"><\/div>/', '$1', $content);
        return $content;
    }
}
