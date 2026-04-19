<?php

return [
    'items' => [
        [
            'key' => 'dashboard',
            'label' => 'navigation.dashboard',
            'icon' => 'dashboard',
            'route' => 'dashboard',
            'active' => ['dashboard'],
        ],
        [
            'key' => 'operations',
            'label' => 'navigation.operations',
            'icon' => 'layers',
            'children' => [
                [
                    'key' => 'calendar',
                    'label' => 'navigation.exam_calendar',
                    'icon' => 'calendar',
                    'route' => 'demo.calendar',
                    'active' => ['demo.calendar'],
                ],
                [
                    'key' => 'halls',
                    'label' => 'navigation.halls_management',
                    'icon' => 'building',
                    'route' => 'demo.halls',
                    'active' => ['demo.halls'],
                ],
                [
                    'key' => 'invigilators',
                    'label' => 'navigation.invigilators',
                    'icon' => 'shield-users',
                    'route' => 'demo.invigilators',
                    'active' => ['demo.invigilators'],
                ],
                [
                    'key' => 'planning',
                    'label' => 'navigation.planning',
                    'icon' => 'calendar',
                    'children' => [
                        [
                            'key' => 'planning_midterm',
                            'label' => 'navigation.midterm_plan',
                            'icon' => 'dot',
                            'route' => 'demo.planning.midterm',
                            'active' => ['demo.planning.midterm'],
                        ],
                        [
                            'key' => 'planning_final',
                            'label' => 'navigation.final_plan',
                            'icon' => 'dot',
                            'route' => 'demo.planning.final',
                            'active' => ['demo.planning.final'],
                        ],
                    ],
                ],
            ],
        ],
        [
            'key' => 'users_access',
            'label' => 'navigation.users_access',
            'icon' => 'users',
            'any_permissions' => ['view users', 'manage roles'],
            'children' => [
                [
                    'key' => 'users_list',
                    'label' => 'navigation.users_list',
                    'icon' => 'user',
                    'permission' => 'view users',
                    'route' => 'demo.users.list',
                    'active' => ['demo.users.list'],
                ],
                [
                    'key' => 'roles_permissions',
                    'label' => 'navigation.roles_permissions',
                    'icon' => 'key',
                    'permission' => 'manage roles',
                    'route' => 'demo.roles.permissions',
                    'active' => ['demo.roles.permissions'],
                ],
            ],
        ],
        [
            'key' => 'reports',
            'label' => 'navigation.reports',
            'icon' => 'layers',
            'children' => [
                [
                    'key' => 'reports_daily',
                    'label' => 'navigation.daily_reports',
                    'icon' => 'dot',
                    'route' => 'demo.reports.daily',
                    'active' => ['demo.reports.daily'],
                ],
                [
                    'key' => 'reports_summary',
                    'label' => 'navigation.summary_reports',
                    'icon' => 'dot',
                    'route' => 'demo.reports.summary',
                    'active' => ['demo.reports.summary'],
                ],
            ],
        ],
        [
            'key' => 'account',
            'label' => 'navigation.account',
            'icon' => 'settings',
            'children' => [
                [
                    'key' => 'profile',
                    'label' => 'navigation.profile',
                    'icon' => 'user',
                    'route' => 'profile',
                    'active' => ['profile'],
                ],
                [
                    'key' => 'security',
                    'label' => 'navigation.security',
                    'icon' => 'lock',
                    'url' => '/profile#security',
                ],
            ],
        ],
    ],
];
