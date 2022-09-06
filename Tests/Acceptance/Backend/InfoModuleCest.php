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
use TYPO3\CMS\Core\Information\Typo3Version;

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

        $typo3Version = new Typo3Version();
        if ($typo3Version->getMajorVersion() === 10) {
            $name = 'WebInfoJumpMenu';
        } else {
            $name = 'moduleMenu';
        }
        $I->waitForElement('select[name="' . $name . '"]');
        $I->selectOption('select[name="' . $name . '"]', 'Page TSconfig');
        if ($typo3Version->getMajorVersion() === 10) {
            $name = 'SET[tsconf_parts]';
        } else {
            $name = 'tsconf_parts';
        }
        $I->waitForElement('select[name="' . $name . '"]');
        $I->selectOption('select[name="' . $name . '"]', 99);
        $I->see('b13-2cols-with-header-container = EXT:container/Resources/Private/Templates/Container.html');
    }
}
