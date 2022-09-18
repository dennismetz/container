<?php

declare(strict_types=1);
namespace B13\Container\Tests\Functional\Backend\Grid;

/*
 * This file is part of TYPO3 CMS-based extension "container" by b13.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

use B13\Container\Backend\Grid\ContainerGridColumn;
use B13\Container\Domain\Model\Container;
use B13\Container\Tests\Wrapper\FunctionalTestCaseSimple;
use TYPO3\CMS\Backend\View\PageLayoutContext;

class ContainerGridColumnTest extends FunctionalTestCaseSimple
{
    /**
     * @test
     */
    public function getNewContentUrlContainsUidOfLiveWorkspaceAsContainerParent(): void
    {
        $container = new Container(['uid' => 2, 't3ver_oid' => 1], []);
        $pageLayoutContext = $this->getMockBuilder(PageLayoutContext::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getPageId'])
            ->getMock();
        $pageLayoutContext->expects(self::any())->method('getPageId')->willReturn(3);
        $containerGridColumn = $this->getAccessibleMock(ContainerGridColumn::class, ['foo'], [], '', false);
        $containerGridColumn->_set('container', $container);
        $containerGridColumn->_set('context', $pageLayoutContext);
        $newContentUrl = $containerGridColumn->getNewContentUrl();
        self::assertStringContainsString('tx_container_parent=1', $newContentUrl, 'should container uid of live workspace record');
    }
}
