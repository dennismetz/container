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

class InfoModuleCest
{

    /**
     * @param BackendTester $I
     */
    public function _before(BackendTester $I)
    {
        $I->loginAs('admin');
    }

    /**
     * @param BackendTester $I
     * @param PageTree $pageTree
     */
    public function canSeeContainerPageTsConfig(BackendTester $I, PageTree $pageTree)
    {
        $I->click('Info');
        $I->waitForElement('#typo3-pagetree-tree .nodes .node');
        $pageTree->openPath(['home', 'pageWithContainer-6']);
        $I->wait(0.2);
        $I->switchToContentFrame();
        $I->waitForElement('select[name="WebInfoJumpMenu"]');
        $I->selectOption('select[name="WebInfoJumpMenu"]', 'Page TSconfig');
        $I->waitForElement('select[name="SET[tsconf_parts]"]');
        $I->selectOption('select[name="SET[tsconf_parts]"]', 99);
        $I->see('b13-2cols-with-header-container = EXT:container/Resources/Private/Templates/Container.html');
    }
}
