<?php

declare(strict_types=1);
namespace B13\Container\Tests\Functional\Datahandler\DefaultLanguage;

/*
 * This file is part of TYPO3 CMS-based extension "container" by b13.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

use B13\Container\Tests\Functional\Datahandler\DatahandlerTest;

class ContainerTest extends DatahandlerTest
{

    /**
     * @test
     */
    public function deleteContainerDeleteChildren(): void
    {
        $this->importCSVDataSet(ORIGINAL_ROOT . 'typo3conf/ext/container/Tests/Functional/Datahandler/DefaultLanguage/Fixtures/Container/delete_container.csv');
        $cmdmap = [
            'tt_content' => [
                1 => [
                    'delete' => 1,
                ],
            ],
        ];
        $this->dataHandler->start([], $cmdmap, $this->backendUser);
        $this->dataHandler->process_cmdmap();
        $row = $this->fetchOneRecord('uid', 1);
        self::assertSame(1, $row['deleted']);
        $row = $this->fetchOneRecord('uid', 2);
        self::assertSame(1, $row['deleted']);
    }

    /**
     * @test
     */
    public function moveContainerAfterElementMovesChildren(): void
    {
        $this->importCSVDataSet(ORIGINAL_ROOT . 'typo3conf/ext/container/Tests/Functional/Datahandler/DefaultLanguage/Fixtures/Container/move_container_after_element.csv');
        $cmdmap = [
            'tt_content' => [
                1 => [
                    'move' => [
                        'action' => 'paste',
                        'target' => -4,
                        'update' => [
                            'colPos' => 0,
                            'sys_language_uid' => 0,

                        ],
                    ],
                ],
            ],
        ];

        $this->dataHandler->start([], $cmdmap, $this->backendUser);
        $this->dataHandler->process_datamap();
        $this->dataHandler->process_cmdmap();
        $child = $this->fetchOneRecord('uid', 2);
        self::assertSame(1, $child['pid']);
        self::assertSame(1, $child['tx_container_parent']);
        self::assertSame(200, $child['colPos']);
        self::assertSame(0, $child['sys_language_uid']);
        $container = $this->fetchOneRecord('uid', 1);
        self::assertTrue($child['sorting'] > $container['sorting'], 'moved child is sorted before container');
    }

    /**
     * @test
     */
    public function moveContainerToOtherPageAtTopMovesChildren(): void
    {
        $this->importCSVDataSet(ORIGINAL_ROOT . 'typo3conf/ext/container/Tests/Functional/Datahandler/DefaultLanguage/Fixtures/Container/move_container_other_page_on_top.csv');
        $cmdmap = [
            'tt_content' => [
                1 => [
                    'move' => [
                        'action' => 'paste',
                        'target' => 3,
                        'update' => [
                            'colPos' => 0,
                            'sys_language_uid' => 0,

                        ],
                    ],
                ],
            ],
        ];
        $this->dataHandler->start([], $cmdmap, $this->backendUser);
        $this->dataHandler->process_cmdmap();
        $child = $this->fetchOneRecord('uid', 2);
        self::assertSame(3, $child['pid']);
        self::assertSame(1, $child['tx_container_parent']);
        self::assertSame(200, $child['colPos']);
        self::assertSame(0, $child['sys_language_uid']);
        $container = $this->fetchOneRecord('uid', 1);
        self::assertTrue($child['sorting'] > $container['sorting'], 'moved child is sorted before container');
    }

    /**
     * @test
     */
    public function copyContainerToOtherPageAtTopCopiesChildren(): void
    {
        $this->importCSVDataSet(ORIGINAL_ROOT . 'typo3conf/ext/container/Tests/Functional/Datahandler/DefaultLanguage/Fixtures/Container/copy_container_other_page_on_top.csv');
        $cmdmap = [
            'tt_content' => [
                1 => [
                    'copy' => [
                        'action' => 'paste',
                        'target' => 3,
                        'update' => [
                            'colPos' => 0,
                        ],
                    ],
                ],
            ],
        ];
        $this->dataHandler->start([], $cmdmap, $this->backendUser);
        $this->dataHandler->process_cmdmap();
        $copiedRecord = $this->fetchOneRecord('t3_origuid', 1);
        $child = $this->fetchOneRecord('t3_origuid', 2);
        self::assertSame(3, $child['pid']);
        self::assertSame($copiedRecord['uid'], $child['tx_container_parent']);
        self::assertSame(200, $child['colPos']);
        self::assertSame(0, $child['sys_language_uid']);
        self::assertTrue($child['sorting'] > $copiedRecord['sorting'], 'copied child is sorted before container');
    }

    /**
     * @test
     */
    public function copyContainerToOtherPageAfterElementCopiesChildren(): void
    {
        $this->importCSVDataSet(ORIGINAL_ROOT . 'typo3conf/ext/container/Tests/Functional/Datahandler/DefaultLanguage/Fixtures/Container/copy_container_other_page_after_element.csv');
        $cmdmap = [
            'tt_content' => [
                1 => [
                    'copy' => [
                        'action' => 'paste',
                        'target' => -14,
                        'update' => [
                            'colPos' => 0,
                        ],
                    ],
                ],
            ],
        ];
        $this->dataHandler->start([], $cmdmap, $this->backendUser);
        $this->dataHandler->process_cmdmap();
        $copiedRecord = $this->fetchOneRecord('t3_origuid', 1);
        $child = $this->fetchOneRecord('t3_origuid', 2);
        self::assertSame(3, $child['pid']);
        self::assertSame($copiedRecord['uid'], $child['tx_container_parent']);
        self::assertSame(200, $child['colPos']);
        self::assertTrue($child['sorting'] > $copiedRecord['sorting'], 'copied child is sorted before container');
        $targetElement = $this->fetchOneRecord('uid', 14);
        self::assertTrue($child['sorting'] > $targetElement['sorting'], 'copied child is sorted before target element');
    }

    /**
     * @test
     */
    public function moveContainerToOtherPageAfterElementMovesChildren(): void
    {
        $this->importCSVDataSet(ORIGINAL_ROOT . 'typo3conf/ext/container/Tests/Functional/Datahandler/DefaultLanguage/Fixtures/Container/move_container_other_page_after_element.csv');
        $cmdmap = [
            'tt_content' => [
                1 => [
                    'move' => [
                        'action' => 'paste',
                        'target' => -14,
                        'update' => [
                            'colPos' => 0,
                            'sys_language_uid' => 0,

                        ],
                    ],
                ],
            ],
        ];
        $this->dataHandler->start([], $cmdmap, $this->backendUser);
        $this->dataHandler->process_cmdmap();
        $child = $this->fetchOneRecord('uid', 2);
        self::assertSame(3, $child['pid']);
        self::assertSame(1, $child['tx_container_parent']);
        self::assertSame(200, $child['colPos']);
        $container = $this->fetchOneRecord('uid', 1);
        self::assertTrue($child['sorting'] > $container['sorting'], 'moved child is sorted before container');
    }

    /**
     * @test
     */
    public function copyContainerKeepsSortingOfChildren(): void
    {
        $this->importCSVDataSet(ORIGINAL_ROOT . 'typo3conf/ext/container/Tests/Functional/Datahandler/DefaultLanguage/Fixtures/Container/copy_container_keeps_sorting.csv');
        $cmdmap = [
            'tt_content' => [
                1 => [
                    'copy' => [
                        'action' => 'paste',
                        'target' => 3,
                        'update' => [
                            'colPos' => 0,
                        ],
                    ],
                ],
            ],
        ];
        $this->dataHandler->start([], $cmdmap, $this->backendUser);
        $this->dataHandler->process_cmdmap();
        $child = $this->fetchOneRecord('t3_origuid', 2);
        $secondChild = $this->fetchOneRecord('t3_origuid', 5);
        self::assertTrue($child['sorting'] < $secondChild['sorting']);
        $container = $this->fetchOneRecord('uid', 1);
        self::assertTrue($child['sorting'] > $container['sorting'], 'moved child is sorted before container');
    }
}
