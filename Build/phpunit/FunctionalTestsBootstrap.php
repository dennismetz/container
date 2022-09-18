<?php
/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use TYPO3\CMS\Core\Information\Typo3Version;

call_user_func(function () {
    if ((new Typo3Version())->getMajorVersion() < 11) {
        class_alias(\B13\Container\Tests\Wrapper\FunctionalTestCaseV10::class, \B13\Container\Tests\Wrapper\FunctionalTestCase::class);
        class_alias(\B13\Container\Tests\Wrapper\FunctionalTestCaseContentDefenderV10::class, \B13\Container\Tests\Wrapper\FunctionalTestCaseContentDefender::class);
        class_alias(\B13\Container\Tests\Wrapper\FunctionalTestCaseWorkspacesV10::class, \B13\Container\Tests\Wrapper\FunctionalTestCaseWorkspaces::class);
        class_alias(\B13\Container\Tests\Wrapper\FunctionalTestCaseSimpleV10::class, \B13\Container\Tests\Wrapper\FunctionalTestCaseSimple::class);
        class_alias(\B13\Container\Tests\Wrapper\FunctionalTestCaseFrontendV10::class, \B13\Container\Tests\Wrapper\FunctionalTestCaseFrontend::class);
    }
    $testbase = new \TYPO3\TestingFramework\Core\Testbase();
    $testbase->defineOriginalRootPath();
    $testbase->createDirectory(ORIGINAL_ROOT . 'typo3temp/var/tests');
    $testbase->createDirectory(ORIGINAL_ROOT . 'typo3temp/var/transient');
});
