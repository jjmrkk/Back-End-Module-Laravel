<?php

use Illuminate\Database\Seeder;

class UserAccessTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('user_access')->insert([
            'user_id' => 1,
            'description' => json_encode(
                [
                    "provision_request"=> [
                        "form_module" => [
                            "access" => true,
                            "functions" => [],
                            "business_units" => [],
                            "projects" => []
                        ],
                        "transaction_module" => [
                            "access" => true,
                            "functions" => [],
                            "business_units" => [],
                            "projects" => []
                        ],
                        "approval_module" => [
                            "access" => true,
                            "functions" => [],
                            "business_units" => [],
                            "projects" => [],
                            "approver" => []
                        ]
                    ],
                    "inventory_management" => [
                        "provision_request_module" =>[
                            "access" => true,
                            "functions" => [],
                            "business_units" => [],
                            "projects" => []
                        ]
                    ],
                    "administrator" => [
                        "user_module" => [
                            "access" => true,
                            "functions" => [
                                "add" => true,
                                "edit" => true,
                                "view" => true,
                                "access" => true,
                                "delete" => true,
                                "search" => true
                            ],
                        ],
                        "business_unit_module" => [
                            "access" => true,
                            "functions" => [],
                            "business_units" => [],
                            "projects" => []
                        ]
                    ]
                ]
            )
        ]);

        DB::table('user_access')->insert([
            'user_id' => 2,
            'description' => json_encode(
                [
                    "provision_request"=> [
                        "form_module" => [
                            "access" => true,
                            "functions" => [],
                            "business_units" => [],
                            "projects" => []
                        ],
                        "transaction_module" => [
                            "access" => true,
                            "functions" => [],
                            "business_units" => [],
                            "projects" => []
                        ],
                        "approval_module" => [
                            "access" => false,
                            "functions" => [],
                            "business_units" => [],
                            "projects" => [],
                            "approver" => []
                        ]
                    ],
                    "inventory_management" => [
                        "provision_request_module" =>[
                            "access" => false,
                            "functions" => [],
                            "business_units" => [],
                            "projects" => []
                        ]
                    ],
                    "administrator" => [
                        "user_module" => [
                            "access" => false,
                            "functions" => [
                                "add" => false,
                                "edit" => false,
                                "view" => false,
                                "access" => false,
                                "delete" => false,
                                "search" => false
                            ],
                        ],
                        "business_unit_module" => [
                            "access" => false,
                            "functions" => [],
                            "business_units" => [],
                            "projects" => []
                        ]
                    ]
                ]
            )
        ]);

        DB::table('user_access')->insert([
            'user_id' => 3,
            'description' => json_encode(
                [
                    "provision_request"=> [
                        "form_module" => [
                            "access" => true,
                            "functions" => [],
                            "business_units" => [],
                            "projects" => []
                        ],
                        "transaction_module" => [
                            "access" => true,
                            "functions" => [],
                            "business_units" => [],
                            "projects" => []
                        ],
                        "approval_module" => [
                            "access" => false,
                            "functions" => [],
                            "business_units" => [],
                            "projects" => [],
                            "approver" => []
                        ]
                    ],
                    "inventory_management" => [
                        "provision_request_module" =>[
                            "access" => false,
                            "functions" => [],
                            "business_units" => [],
                            "projects" => []
                        ]
                    ],
                    "administrator" => [
                        "user_module" => [
                            "access" => false,
                            "functions" => [
                                "add" => false,
                                "edit" => false,
                                "view" => false,
                                "access" => false,
                                "delete" => false,
                                "search" => false
                            ],
                        ],
                        "business_unit_module" => [
                            "access" => false,
                            "functions" => [],
                            "business_units" => [],
                            "projects" => []
                        ]
                    ]
                ]
            )
        ]);

        DB::table('user_access')->insert([
            'user_id' => 4,
            'description' => json_encode(
                [
                    "provision_request"=> [
                        "form_module" => [
                            "access" => true,
                            "functions" => [],
                            "business_units" => [],
                            "projects" => []
                        ],
                        "transaction_module" => [
                            "access" => true,
                            "functions" => [],
                            "business_units" => [],
                            "projects" => []
                        ],
                        "approval_module" => [
                            "access" => false,
                            "functions" => [],
                            "business_units" => [],
                            "projects" => [],
                            "approver" => []
                        ]
                    ],
                    "inventory_management" => [
                        "provision_request_module" =>[
                            "access" => false,
                            "functions" => [],
                            "business_units" => [],
                            "projects" => []
                        ]
                    ],
                    "administrator" => [
                        "user_module" => [
                            "access" => false,
                            "functions" => [
                                "add" => false,
                                "edit" => false,
                                "view" => false,
                                "access" => false,
                                "delete" => false,
                                "search" => false
                            ],
                        ],
                        "business_unit_module" => [
                            "access" => false,
                            "functions" => [],
                            "business_units" => [],
                            "projects" => []
                        ]
                    ]
                ]
            )
        ]);

        DB::table('user_access')->insert([
            'user_id' => 5,
            'description' => json_encode(
                [
                    "provision_request"=> [
                        "form_module" => [
                            "access" => false,
                            "functions" => [],
                            "business_units" => [],
                            "projects" => []
                        ],
                        "transaction_module" => [
                            "access" => false,
                            "functions" => [],
                            "business_units" => [],
                            "projects" => []
                        ],
                        "approval_module" => [
                            "access" => true,
                            "functions" => [],
                            "business_units" => [],
                            "projects" => [],
                            "approver" => []
                        ]
                    ],
                    "inventory_management" => [
                        "provision_request_module" =>[
                            "access" => false,
                            "functions" => [],
                            "business_units" => [],
                            "projects" => []
                        ]
                    ],
                    "administrator" => [
                        "user_module" => [
                            "access" => false,
                            "functions" => [
                                "add" => false,
                                "edit" => false,
                                "view" => false,
                                "access" => false,
                                "delete" => false,
                                "search" => false
                            ],
                        ],
                        "business_unit_module" => [
                            "access" => false,
                            "functions" => [],
                            "business_units" => [],
                            "projects" => []
                        ]
                    ]
                ]
            )
        ]);

        DB::table('user_access')->insert([
            'user_id' => 6,
            'description' => json_encode(
                [
                    "provision_request"=> [
                        "form_module" => [
                            "access" => false,
                            "functions" => [],
                            "business_units" => [],
                            "projects" => []
                        ],
                        "transaction_module" => [
                            "access" => false,
                            "functions" => [],
                            "business_units" => [],
                            "projects" => []
                        ],
                        "approval_module" => [
                            "access" => true,
                            "functions" => [],
                            "business_units" => [],
                            "projects" => [],
                            "approver" => []
                        ]
                    ],
                    "inventory_management" => [
                        "provision_request_module" =>[
                            "access" => false,
                            "functions" => [],
                            "business_units" => [],
                            "projects" => []
                        ]
                    ],
                    "administrator" => [
                        "user_module" => [
                            "access" => false,
                            "functions" => [
                                "add" => false,
                                "edit" => false,
                                "view" => false,
                                "access" => false,
                                "delete" => false,
                                "search" => false
                            ],
                        ],
                        "business_unit_module" => [
                            "access" => false,
                            "functions" => [],
                            "business_units" => [],
                            "projects" => []
                        ]
                    ]
                ]
            )
        ]);

        DB::table('user_access')->insert([
            'user_id' => 7,
            'description' => json_encode(
                [
                    "provision_request"=> [
                        "form_module" => [
                            "access" => false,
                            "functions" => [],
                            "business_units" => [],
                            "projects" => []
                        ],
                        "transaction_module" => [
                            "access" => false,
                            "functions" => [],
                            "business_units" => [],
                            "projects" => []
                        ],
                        "approval_module" => [
                            "access" => true,
                            "functions" => [],
                            "business_units" => [],
                            "projects" => [],
                            "approver" => []
                        ]
                    ],
                    "inventory_management" => [
                        "provision_request_module" =>[
                            "access" => false,
                            "functions" => [],
                            "business_units" => [],
                            "projects" => []
                        ]
                    ],
                    "administrator" => [
                        "user_module" => [
                            "access" => false,
                            "functions" => [
                                "add" => false,
                                "edit" => false,
                                "view" => false,
                                "access" => false,
                                "delete" => false,
                                "search" => false
                            ],
                        ],
                        "business_unit_module" => [
                            "access" => false,
                            "functions" => [],
                            "business_units" => [],
                            "projects" => []
                        ]
                    ]
                ]
            )
        ]);

        DB::table('user_access')->insert([
            'user_id' => 8,
            'description' => json_encode(
                [
                    "provision_request"=> [
                        "form_module" => [
                            "access" => false,
                            "functions" => [],
                            "business_units" => [],
                            "projects" => []
                        ],
                        "transaction_module" => [
                            "access" => false,
                            "functions" => [],
                            "business_units" => [],
                            "projects" => []
                        ],
                        "approval_module" => [
                            "access" => true,
                            "functions" => [],
                            "business_units" => [],
                            "projects" => [],
                            "approver" => []
                        ]
                    ],
                    "inventory_management" => [
                        "provision_request_module" =>[
                            "access" => false,
                            "functions" => [],
                            "business_units" => [],
                            "projects" => []
                        ]
                    ],
                    "administrator" => [
                        "user_module" => [
                            "access" => false,
                            "functions" => [
                                "add" => false,
                                "edit" => false,
                                "view" => false,
                                "access" => false,
                                "delete" => false,
                                "search" => false
                            ],
                        ],
                        "business_unit_module" => [
                            "access" => false,
                            "functions" => [],
                            "business_units" => [],
                            "projects" => []
                        ]
                    ]
                ]
            )
        ]);

        DB::table('user_access')->insert([
            'user_id' => 9,
            'description' => json_encode(
                [
                    "provision_request"=> [
                        "form_module" => [
                            "access" => false,
                            "functions" => [],
                            "business_units" => [],
                            "projects" => []
                        ],
                        "transaction_module" => [
                            "access" => false,
                            "functions" => [],
                            "business_units" => [],
                            "projects" => []
                        ],
                        "approval_module" => [
                            "access" => false,
                            "functions" => [],
                            "business_units" => [],
                            "projects" => [],
                            "approver" => []
                        ]
                    ],
                    "inventory_management" => [
                        "provision_request_module" =>[
                            "access" => true,
                            "functions" => [],
                            "business_units" => [],
                            "projects" => []
                        ],

                        "warehouse_module" =>[
                            "access" => true,
                            "functions" => [],
                            "business_units" => [],
                            "warehouses" => [4,5,6,7,8,9],
                            "projects" => []
                        ]
                    ],
                    "administrator" => [
                        "user_module" => [
                            "access" => false,
                            "functions" => [
                                "add" => false,
                                "edit" => false,
                                "view" => false,
                                "access" => false,
                                "delete" => false,
                                "search" => false
                            ],
                        ],
                        "business_unit_module" => [
                            "access" => false,
                            "functions" => [],
                            "business_units" => [],
                            "projects" => []
                        ]
                    ]
                ]
            )
        ]);

        DB::table('user_access')->insert([
            'user_id' => 10,
            'description' => json_encode(
                [
                    "provision_request"=> [
                        "form_module" => [
                            "access" => false,
                            "functions" => [],
                            "business_units" => [],
                            "projects" => []
                        ],
                        "transaction_module" => [
                            "access" => false,
                            "functions" => [],
                            "business_units" => [],
                            "projects" => []
                        ],
                        "approval_module" => [
                            "access" => false,
                            "functions" => [],
                            "business_units" => [],
                            "projects" => [],
                            "approver" => []
                        ]
                    ],
                    "inventory_management" => [
                        "provision_request_module" =>[
                            "access" => true,
                            "functions" => [],
                            "business_units" => [],
                            "projects" => []
                        ]
                    ],
                    "administrator" => [
                        "user_module" => [
                            "access" => false,
                            "functions" => [
                                "add" => false,
                                "edit" => false,
                                "view" => false,
                                "access" => false,
                                "delete" => false,
                                "search" => false
                            ],
                        ],
                        "business_unit_module" => [
                            "access" => false,
                            "functions" => [],
                            "business_units" => [],
                            "projects" => []
                        ]
                    ]
                ]
            )
        ]);
    }
}
