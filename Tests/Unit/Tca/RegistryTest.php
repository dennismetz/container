<?php

declare(strict_types=1);
namespace B13\Container\Tests\Unit\Tca;

/*
 * This file is part of TYPO3 CMS-based extension "container" by b13.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

use B13\Container\Tca\Registry;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class RegistryTest extends \B13\Container\Tests\Wrapper\UnitTestCase
{

    /**
     * @test
     */
    public function getAllAvailableColumnsReturnsEmptyArrayIfNoContainerConfigured(): void
    {
        $registry = GeneralUtility::makeInstance(Registry::class);
        $columns = $registry->getAllAvailableColumns();
        self::assertSame([], $columns);
    }

    /**
     * @test
     */
    public function getPageTsStringReturnsEmptyStringIfNoContainerConfigured(): void
    {
        $registry = GeneralUtility::makeInstance(Registry::class);
        $res = $registry->getPageTsString('');
        self::assertSame('', $res, 'empty string should be returned');
    }
}
