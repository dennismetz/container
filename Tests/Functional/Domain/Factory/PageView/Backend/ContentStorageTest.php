<?php

namespace B13\Container\Tests\Functional\Domain\Factory\PageView\Backend;

/*
 * This file is part of TYPO3 CMS-based extension "container" by b13.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

use B13\Container\Domain\Factory\Database;
use B13\Container\Domain\Factory\PageView\Backend\ContentStorage;
use B13\Container\Tests\Wrapper\FunctionalTestCaseWorkspaces;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Context\WorkspaceAspect;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class ContentStorageTest extends FunctionalTestCaseWorkspaces
{
    /**
     * @test
     */
    public function getContainerChildrenReturnsAllLiveChildrenInDraftWorkspace(): void
    {
        $this->importCSVDataSet(ORIGINAL_ROOT . 'typo3conf/ext/container/Tests/Functional/Domain/Factory/PageView/Backend/Fixture/ContentStorage/localizedContainerChildElementsHasSortingOfDefaultChildElements.csv');

        $workspaceAspect = GeneralUtility::makeInstance(WorkspaceAspect::class, 1);
        $database = GeneralUtility::makeInstance(Database::class);
        $context = GeneralUtility::makeInstance(Context::class);
        $context->setAspect('workspace', $workspaceAspect);
        $contentStorage = GeneralUtility::makeInstance(ContentStorage::class, $database, $context);
        $containerRecord = ['uid' => 1, 'pid' => 1];
        $children = $contentStorage->getContainerChildren($containerRecord, 0);
        self::assertSame(2, count($children));
    }

    /**
     * @test
     */
    public function getContainerChildrenReturnsAllLiveChildrenInLiveWorkspace(): void
    {
        $this->importCSVDataSet(ORIGINAL_ROOT . 'typo3conf/ext/container/Tests/Functional/Domain/Factory/PageView/Backend/Fixture/ContentStorage/localizedContainerChildElementsHasSortingOfDefaultChildElements.csv');
        $workspaceAspect = GeneralUtility::makeInstance(WorkspaceAspect::class, 0);
        $database = GeneralUtility::makeInstance(Database::class);
        $context = GeneralUtility::makeInstance(Context::class);
        $context->setAspect('workspace', $workspaceAspect);
        $contentStorage = GeneralUtility::makeInstance(ContentStorage::class, $database, $context);
        $containerRecord = ['uid' => 1, 'pid' => 1];
        $children = $contentStorage->getContainerChildren($containerRecord, 0);
        self::assertSame(2, count($children));
    }

    /**
     * @test
     */
    public function deletedChildInWorkspaceReturnsChildInLiveWorkspace(): void
    {
        $this->importCSVDataSet(ORIGINAL_ROOT . 'typo3conf/ext/container/Tests/Functional/Domain/Factory/PageView/Backend/Fixture/ContentStorage/deletedChildInWorkspace.csv');

        $workspaceAspect = GeneralUtility::makeInstance(WorkspaceAspect::class, 0);
        $database = GeneralUtility::makeInstance(Database::class);
        $context = GeneralUtility::makeInstance(Context::class);
        $context->setAspect('workspace', $workspaceAspect);
        $contentStorage = GeneralUtility::makeInstance(ContentStorage::class, $database, $context);
        $containerRecord = ['uid' => 1, 'pid' => 1];
        $children = $contentStorage->getContainerChildren($containerRecord, 0);
        self::assertSame(1, count($children));
    }

    /**
     * @test
     */
    public function deletedChildInWorkspaceReturnsNoChildInDraftWorkspace(): void
    {
        $this->importCSVDataSet(ORIGINAL_ROOT . 'typo3conf/ext/container/Tests/Functional/Domain/Factory/PageView/Backend/Fixture/ContentStorage/deletedChildInWorkspace.csv');

        $workspaceAspect = GeneralUtility::makeInstance(WorkspaceAspect::class, 1);
        $database = GeneralUtility::makeInstance(Database::class);
        $context = GeneralUtility::makeInstance(Context::class);
        $context->setAspect('workspace', $workspaceAspect);
        $contentStorage = GeneralUtility::makeInstance(ContentStorage::class, $database, $context);
        $containerRecord = ['uid' => 1, 'pid' => 1];
        $children = $contentStorage->getContainerChildren($containerRecord, 0);
        self::assertSame(0, count($children));
    }
}
