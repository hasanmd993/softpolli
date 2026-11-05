<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Define standard application permissions
        $permissions = [
            'manage-users' => 'Manage administrators, staff accounts, and role permissions',
            'manage-settings' => 'Configure global site settings, WhatsApp, and social accounts',
            'manage-inquiries' => 'View, update status, and manage client contact inquiries',
            'manage-blog' => 'Create, edit, publish, and delete blog articles',
            'manage-services' => 'Manage services showcase and service category associations',
            'manage-products' => 'Manage flagship products and software platforms',
            'manage-portfolio' => 'Manage case studies, portfolio projects, and galleries',
            'manage-testimonials' => 'Manage verified client endorsements and reviews',
            'manage-pricing' => 'Manage pricing tiers, subscription packages, and features',
            'manage-team' => 'Manage leadership team members and executive credentials',
            'manage-faqs' => 'Manage frequently asked questions and knowledge base',
            'view-activity-logs' => 'Audit system activity logs and compliance history',
        ];

        foreach ($permissions as $name => $description) {
            Permission::firstOrCreate(['name' => $name, 'guard_name' => 'web']);
        }

        // 2. Define standard Roles
        $superAdminRole = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);
        $adminRole = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
        $editorRole = Role::firstOrCreate(['name' => 'Editor', 'guard_name' => 'web']);
        $supportRole = Role::firstOrCreate(['name' => 'Support Agent', 'guard_name' => 'web']);

        // Super Admin gets all permissions
        $superAdminRole->syncPermissions(Permission::all());

        // Admin gets all management permissions except managing users/roles
        $adminRole->syncPermissions([
            'manage-settings',
            'manage-inquiries',
            'manage-blog',
            'manage-services',
            'manage-products',
            'manage-portfolio',
            'manage-testimonials',
            'manage-pricing',
            'manage-team',
            'manage-faqs',
            'view-activity-logs',
        ]);

        // Editor gets content modules
        $editorRole->syncPermissions([
            'manage-blog',
            'manage-services',
            'manage-products',
            'manage-portfolio',
            'manage-testimonials',
            'manage-faqs',
        ]);

        // Support Agent handles inquiries
        $supportRole->syncPermissions([
            'manage-inquiries',
        ]);

        // 3. Assign Super Admin role to existing admin users
        $adminUsers = User::where('is_admin', true)->get();
        foreach ($adminUsers as $user) {
            if (!$user->hasRole('Super Admin')) {
                $user->assignRole($superAdminRole);
            }
        }

        // Also ensure default admin email has Super Admin
        $defaultAdmin = User::where('email', 'admin@softpolli.com')->first();
        if ($defaultAdmin && !$defaultAdmin->hasRole('Super Admin')) {
            $defaultAdmin->assignRole($superAdminRole);
        }
    }
}

