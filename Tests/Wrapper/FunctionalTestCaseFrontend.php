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


use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

class FunctionalTestCaseFrontend extends FunctionalTestCase
{
    /**
     * @var non-empty-string[]
     */
    protected array $coreExtensionsToLoad = ['core', 'frontend', 'workspaces', 'fluid_styled_content'];

    /**
     * @var array<string, non-empty-string>
     */
    protected array $pathsToLinkInTestInstance = [
        'typo3conf/ext/container/Build/sites' => 'typo3conf/sites',
    ];

    /**
     * @var non-empty-string[]
     */
    protected array $testExtensionsToLoad = [
        'typo3conf/ext/container',
        'typo3conf/ext/container_example',
    ];

}
