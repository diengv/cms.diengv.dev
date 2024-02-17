<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'team_create',
            ],
            [
                'id'    => 18,
                'title' => 'team_edit',
            ],
            [
                'id'    => 19,
                'title' => 'team_show',
            ],
            [
                'id'    => 20,
                'title' => 'team_delete',
            ],
            [
                'id'    => 21,
                'title' => 'team_access',
            ],
            [
                'id'    => 22,
                'title' => 'asset_management_access',
            ],
            [
                'id'    => 23,
                'title' => 'asset_category_create',
            ],
            [
                'id'    => 24,
                'title' => 'asset_category_edit',
            ],
            [
                'id'    => 25,
                'title' => 'asset_category_show',
            ],
            [
                'id'    => 26,
                'title' => 'asset_category_delete',
            ],
            [
                'id'    => 27,
                'title' => 'asset_category_access',
            ],
            [
                'id'    => 28,
                'title' => 'asset_location_create',
            ],
            [
                'id'    => 29,
                'title' => 'asset_location_edit',
            ],
            [
                'id'    => 30,
                'title' => 'asset_location_show',
            ],
            [
                'id'    => 31,
                'title' => 'asset_location_delete',
            ],
            [
                'id'    => 32,
                'title' => 'asset_location_access',
            ],
            [
                'id'    => 33,
                'title' => 'asset_status_create',
            ],
            [
                'id'    => 34,
                'title' => 'asset_status_edit',
            ],
            [
                'id'    => 35,
                'title' => 'asset_status_show',
            ],
            [
                'id'    => 36,
                'title' => 'asset_status_delete',
            ],
            [
                'id'    => 37,
                'title' => 'asset_status_access',
            ],
            [
                'id'    => 38,
                'title' => 'asset_create',
            ],
            [
                'id'    => 39,
                'title' => 'asset_edit',
            ],
            [
                'id'    => 40,
                'title' => 'asset_show',
            ],
            [
                'id'    => 41,
                'title' => 'asset_delete',
            ],
            [
                'id'    => 42,
                'title' => 'asset_access',
            ],
            [
                'id'    => 43,
                'title' => 'assets_history_access',
            ],
            [
                'id'    => 44,
                'title' => 'task_management_access',
            ],
            [
                'id'    => 45,
                'title' => 'task_status_create',
            ],
            [
                'id'    => 46,
                'title' => 'task_status_edit',
            ],
            [
                'id'    => 47,
                'title' => 'task_status_show',
            ],
            [
                'id'    => 48,
                'title' => 'task_status_delete',
            ],
            [
                'id'    => 49,
                'title' => 'task_status_access',
            ],
            [
                'id'    => 50,
                'title' => 'task_tag_create',
            ],
            [
                'id'    => 51,
                'title' => 'task_tag_edit',
            ],
            [
                'id'    => 52,
                'title' => 'task_tag_show',
            ],
            [
                'id'    => 53,
                'title' => 'task_tag_delete',
            ],
            [
                'id'    => 54,
                'title' => 'task_tag_access',
            ],
            [
                'id'    => 55,
                'title' => 'task_create',
            ],
            [
                'id'    => 56,
                'title' => 'task_edit',
            ],
            [
                'id'    => 57,
                'title' => 'task_show',
            ],
            [
                'id'    => 58,
                'title' => 'task_delete',
            ],
            [
                'id'    => 59,
                'title' => 'task_access',
            ],
            [
                'id'    => 60,
                'title' => 'tasks_calendar_access',
            ],
            [
                'id'    => 61,
                'title' => 'category_access',
            ],
            [
                'id'    => 62,
                'title' => 'cms_taxonomy_create',
            ],
            [
                'id'    => 63,
                'title' => 'cms_taxonomy_edit',
            ],
            [
                'id'    => 64,
                'title' => 'cms_taxonomy_show',
            ],
            [
                'id'    => 65,
                'title' => 'cms_taxonomy_delete',
            ],
            [
                'id'    => 66,
                'title' => 'cms_taxonomy_access',
            ],
            [
                'id'    => 67,
                'title' => 'cms_term_create',
            ],
            [
                'id'    => 68,
                'title' => 'cms_term_edit',
            ],
            [
                'id'    => 69,
                'title' => 'cms_term_show',
            ],
            [
                'id'    => 70,
                'title' => 'cms_term_delete',
            ],
            [
                'id'    => 71,
                'title' => 'cms_term_access',
            ],
            [
                'id'    => 72,
                'title' => 'cms_term_taxonomy_create',
            ],
            [
                'id'    => 73,
                'title' => 'cms_term_taxonomy_edit',
            ],
            [
                'id'    => 74,
                'title' => 'cms_term_taxonomy_show',
            ],
            [
                'id'    => 75,
                'title' => 'cms_term_taxonomy_delete',
            ],
            [
                'id'    => 76,
                'title' => 'cms_term_taxonomy_access',
            ],
            [
                'id'    => 77,
                'title' => 'cms_term_relationship_create',
            ],
            [
                'id'    => 78,
                'title' => 'cms_term_relationship_edit',
            ],
            [
                'id'    => 79,
                'title' => 'cms_term_relationship_show',
            ],
            [
                'id'    => 80,
                'title' => 'cms_term_relationship_delete',
            ],
            [
                'id'    => 81,
                'title' => 'cms_term_relationship_access',
            ],
            [
                'id'    => 82,
                'title' => 'post_access',
            ],
            [
                'id'    => 83,
                'title' => 'cms_post_create',
            ],
            [
                'id'    => 84,
                'title' => 'cms_post_edit',
            ],
            [
                'id'    => 85,
                'title' => 'cms_post_show',
            ],
            [
                'id'    => 86,
                'title' => 'cms_post_delete',
            ],
            [
                'id'    => 87,
                'title' => 'cms_post_access',
            ],
            [
                'id'    => 88,
                'title' => 'cms_conten_type_create',
            ],
            [
                'id'    => 89,
                'title' => 'cms_conten_type_edit',
            ],
            [
                'id'    => 90,
                'title' => 'cms_conten_type_show',
            ],
            [
                'id'    => 91,
                'title' => 'cms_conten_type_delete',
            ],
            [
                'id'    => 92,
                'title' => 'cms_conten_type_access',
            ],
            [
                'id'    => 93,
                'title' => 'cms_content_metum_create',
            ],
            [
                'id'    => 94,
                'title' => 'cms_content_metum_edit',
            ],
            [
                'id'    => 95,
                'title' => 'cms_content_metum_show',
            ],
            [
                'id'    => 96,
                'title' => 'cms_content_metum_delete',
            ],
            [
                'id'    => 97,
                'title' => 'cms_content_metum_access',
            ],
            [
                'id'    => 98,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
