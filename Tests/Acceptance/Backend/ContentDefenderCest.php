<?php

declare(strict_types=1);
namespace B13\Container\Tests\Acceptance\Backend;

/*
 * This file is part of TYPO3 CMS-based extension "container" by b13.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

use B13\Container\Tests\Acceptance\Support\BackendTester;
use B13\Container\Tests\Acceptance\Support\PageTree;

class ContentDefenderCest
{

    /**
     * @param BackendTester $I
     */
    public function _before(BackendTester $I)
    {
        $I->loginAs('admin');
    }

    /**
     * @group content_defender
     */
    public function canCreateChildIn2ColsContainerWithNoContentDefenderRestrictionsDefined(BackendTester $I, PageTree $pageTree): void
    {
        $I->click('Page');
        $I->waitForElement('#typo3-pagetree-tree .nodes .node');
        $pageTree->openPath(['home', 'pageWithDifferentContainers']);
        $I->wait(0.5);
        $I->switchToContentFrame();
        $I->waitForElement('#element-tt_content-300 [data-colpos="300-200"]');
        $I->click('Content', '#element-tt_content-300 [data-colpos="300-200"]');
        $I->switchToIFrame();
        $I->waitForElement('.modal-dialog');
        $I->waitForText('Header Only');
        $I->see('Header Only');
        $I->see('Table');
    }

    /**
     * @group content_defender
     */
    public function doNotSeeNotAllowedContentElementsInNewContentElementWizard(BackendTester $I, PageTree $pageTree): void
    {
        $I->click('Page');
        $I->waitForElement('#typo3-pagetree-tree .nodes .node');
        $pageTree->openPath(['home', 'pageWithContainer-3']);
        $I->wait(0.5);
        $I->switchToContentFrame();
        $I->waitForElement('#element-tt_content-800 [data-colpos="800-200"]');
        $I->click('Content', '#element-tt_content-800 [data-colpos="800-200"]');
        $I->switchToIFrame();
        $I->waitForElement('.modal-dialog');
        $I->waitForText('Header Only');
        $I->dontSee('Table');
    }

    /**
     * @group content_defender
     */
    public function doNotSeeNotAllowedContentElementsInCTypeSelectBoxWhenCreateNewElement(BackendTester $I, PageTree $pageTree)
    {
        $I->click('Page');
        $I->waitForElement('#typo3-pagetree-tree .nodes .node');
        $pageTree->openPath(['home', 'pageWithContainer-4']);
        $I->wait(0.5);
        $I->switchToContentFrame();
        $I->waitForElement('#element-tt_content-801 [data-colpos="801-200"]');
        $I->click('Content', '#element-tt_content-801 [data-colpos="801-200"]');
        $I->switchToIFrame();
        $I->waitForElement('.modal-dialog');
        $I->waitForText('Header Only');
        $I->click('Header Only');
        $I->switchToContentFrame();
        $I->wait(0.5);
        $I->see('textmedia', 'select');
        $I->dontSee('Table', 'select');
    }

    /**
     * @group content_defender
     */
    public function doNotSeeNotAllowedContentElementsInCTypeSelectBoxWhenEditAnElement(BackendTester $I, PageTree $pageTree)
    {
        $I->click('Page');
        $I->waitForElement('#typo3-pagetree-tree .nodes .node');
        $pageTree->openPath(['home', 'contentTCASelectCtype']);
        $I->wait(0.5);
        $I->switchToContentFrame();
        $I->waitForElement('#element-tt_content-502 a[title="Edit"]');
        $I->click('#element-tt_content-502 a[title="Edit"]');
        $I->waitForElement('#EditDocumentController');
        $I->see('textmedia', 'select');
        $I->dontSee('Table', 'select');
    }

    /**
     * @group content_defender
     */
    public function canSeeNewContentButtonIfMaxitemsIsNotReached(BackendTester $I, PageTree $pageTree)
    {
        $I->click('Page');
        $I->waitForElement('#typo3-pagetree-tree .nodes .node');
        $pageTree->openPath(['home', 'contentDefenderMaxitems']);
        $I->wait(0.5);
        $I->switchToContentFrame();
        $I->waitForElement('#element-tt_content-402 [data-colpos="402-202"]');
        $I->see('Content', '#element-tt_content-402 [data-colpos="402-202"]');
    }

    /**
     * @group content_defender
     */
    public function canNotSeeNewContentButtonIfMaxitemsIsReached(BackendTester $I, PageTree $pageTree)
    {
        $I->click('Page');
        $I->waitForElement('#typo3-pagetree-tree .nodes .node');
        $pageTree->openPath(['home', 'contentDefenderMaxitems']);
        $I->wait(0.5);
        $I->switchToContentFrame();
        $I->waitForElement('#element-tt_content-401 [data-colpos="401-202"]');
        $I->dontSee('Content', '#element-tt_content-401 [data-colpos="401-202"]');
    }
}
