<?php

declare(strict_types=1);
namespace B13\Container\Tests\Wrapper;

/*
 * This file is part of TYPO3 CMS-based extension "container" by b13.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */


class FunctionalTestCaseSimple extends \TYPO3\TestingFramework\Core\Functional\FunctionalTestCase
{
    /**
     * @var non-empty-string[]
     */
    protected array $testExtensionsToLoad = [
        'typo3conf/ext/container',
    ];

}
