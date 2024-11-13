<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use illuminate\support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        \App\Models\User::factory(1)->create();

        $admin = Admin::create(['name' => 'admin', 'email' => 'admin@admin.com', 'email_verified_at' => now(), 'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'remember_token' => Str::random(10), 'created_at' => now()]);

        $role = Role::create(['name' => 'admin', 'guard_name' => 'admin']);

        $role = Role::where('name', 'admin')->first();

        Permission::create(['name' => 'add_admin', 'guard_name' => 'admin', 'display_name' => 'إضافة ادمن', 'group_name' => 'Admins']);
        $role->givePermissionTo('add_admin');
        Permission::create(['name' => 'edit_admin', 'guard_name' => 'admin', 'display_name' => 'تعديل ادمن', 'group_name' => 'Admins']);
        $role->givePermissionTo('edit_admin');
        Permission::create(['name' => 'delete_admin', 'guard_name' => 'admin', 'display_name' => 'حذف ادمن', 'group_name' => 'Admins']);
        $role->givePermissionTo('delete_admin');
        Permission::create(['name' => 'view_admin', 'guard_name' => 'admin', 'display_name' => 'اظهار ادمن', 'group_name' => 'Admins']);
        $role->givePermissionTo('view_admin');
        Permission::create(['name' => 'add_role', 'guard_name' => 'admin', 'display_name' => 'إضافة دور', 'group_name' => 'Roles']);
        $role->givePermissionTo('add_role');
        Permission::create(['name' => 'edit_role', 'guard_name' => 'admin', 'display_name' => 'تعديل دور', 'group_name' => 'Roles']);
        $role->givePermissionTo('edit_role');
        Permission::create(['name' => 'delete_role', 'guard_name' => 'admin', 'display_name' => 'حذف دور', 'group_name' => 'Roles']);
        $role->givePermissionTo('delete_role');
        Permission::create(['name' => 'view_role', 'guard_name' => 'admin', 'display_name' => 'اظهار دور', 'group_name' => 'Roles']);
        $role->givePermissionTo('view_role');
        Permission::create(['name' => 'add_user', 'guard_name' => 'admin', 'display_name' => 'إضافة مستخدم', 'group_name' => 'Users']);
        $role->givePermissionTo('add_user');
        Permission::create(['name' => 'edit_user', 'guard_name' => 'admin', 'display_name' => 'تعديل مستخدم', 'group_name' => 'Users']);
        $role->givePermissionTo('edit_user');
        Permission::create(['name' => 'delete_user', 'guard_name' => 'admin', 'display_name' => 'حذف مستخدم', 'group_name' => 'Users']);
        $role->givePermissionTo('delete_user');
        Permission::create(['name' => 'view_user', 'guard_name' => 'admin', 'display_name' => 'اظهار مستخدم', 'group_name' => 'Users']);
        $role->givePermissionTo('view_user');
        Permission::create(['name' => 'add_invoice', 'guard_name' => 'admin', 'display_name' => 'إضافة فاتورة', 'group_name' => 'Invoices']);
        $role->givePermissionTo('add_invoice');
        Permission::create(['name' => 'edit_invoice', 'guard_name' => 'admin', 'display_name' => 'تعديل فاتورة', 'group_name' => 'Invoices']);
        $role->givePermissionTo('edit_invoice');
        Permission::create(['name' => 'delete_invoice', 'guard_name' => 'admin', 'display_name' => 'حذف فاتورة', 'group_name' => 'Invoices']);
        $role->givePermissionTo('delete_invoice');
        Permission::create(['name' => 'view_invoice', 'guard_name' => 'admin', 'display_name' => 'اظهار فاتورة', 'group_name' => 'Invoices']);
        $role->givePermissionTo('view_invoice');
        Permission::create(['name' => 'add_exchange_store', 'guard_name' => 'admin', 'display_name' => 'إضافة مخزن الصرف', 'group_name' => 'Exchange Stores']);
        $role->givePermissionTo('add_exchange_store');
        Permission::create(['name' => 'edit_exchange_store', 'guard_name' => 'admin', 'display_name' => 'تعديل مخزن الصرف', 'group_name' => 'Exchange Stores']);
        $role->givePermissionTo('edit_exchange_store');
        Permission::create(['name' => 'delete_exchange_store', 'guard_name' => 'admin', 'display_name' => 'حذف مخزن الصرف', 'group_name' => 'Exchange Stores']);
        $role->givePermissionTo('delete_exchange_store');
        Permission::create(['name' => 'view_exchange_store', 'guard_name' => 'admin', 'display_name' => 'اظهار مخزن الصرف', 'group_name' => 'Exchange Stores']);
        $role->givePermissionTo('view_exchange_store');
        Permission::create(['name' => 'add_item', 'guard_name' => 'admin', 'display_name' => 'إضافة صنف', 'group_name' => 'Items']);
        $role->givePermissionTo('add_item');
        Permission::create(['name' => 'edit_item', 'guard_name' => 'admin', 'display_name' => 'تعديل صنف', 'group_name' => 'Items']);
        $role->givePermissionTo('edit_item');
        Permission::create(['name' => 'delete_item', 'guard_name' => 'admin', 'display_name' => 'حذف صنف', 'group_name' => 'Items']);
        $role->givePermissionTo('delete_item');
        Permission::create(['name' => 'view_item', 'guard_name' => 'admin', 'display_name' => 'اظهار صنف', 'group_name' => 'Items']);
        $role->givePermissionTo('view_item');
        Permission::create(['name' => 'add_unit', 'guard_name' => 'admin', 'display_name' => 'إضافة وحدة', 'group_name' => 'Units']);
        $role->givePermissionTo('add_unit');
        Permission::create(['name' => 'edit_unit', 'guard_name' => 'admin', 'display_name' => 'تعديل وحدة', 'group_name' => 'Units']);
        $role->givePermissionTo('edit_unit');
        Permission::create(['name' => 'delete_unit', 'guard_name' => 'admin', 'display_name' => 'حذف وحدة', 'group_name' => 'Units']);
        $role->givePermissionTo('delete_unit');
        Permission::create(['name' => 'view_unit', 'guard_name' => 'admin', 'display_name' => 'اظهار وحدة', 'group_name' => 'Units']);
        $role->givePermissionTo('view_unit');
        Permission::create(['name' => 'add_discount', 'guard_name' => 'admin', 'display_name' => 'إضافة خصم', 'group_name' => 'Discounts']);
        $role->givePermissionTo('add_discount');
        Permission::create(['name' => 'edit_discount', 'guard_name' => 'admin', 'display_name' => 'تعديل خصم', 'group_name' => 'Discounts']);
        $role->givePermissionTo('edit_discount');
        Permission::create(['name' => 'delete_discount', 'guard_name' => 'admin', 'display_name' => 'حذف خصم', 'group_name' => 'Discounts']);
        $role->givePermissionTo('delete_discount');
        Permission::create(['name' => 'view_discount', 'guard_name' => 'admin', 'display_name' => 'اظهار خصم', 'group_name' => 'Discounts']);
        $role->givePermissionTo('view_discount');
        Permission::create(['name' => 'add_product', 'guard_name' => 'admin', 'display_name' => 'إضافة منتج', 'group_name' => 'Products']);
        $role->givePermissionTo('add_product');
        Permission::create(['name' => 'edit_product', 'guard_name' => 'admin', 'display_name' => 'تعديل منتج', 'group_name' => 'Products']);
        $role->givePermissionTo('edit_product');
        Permission::create(['name' => 'delete_product', 'guard_name' => 'admin', 'display_name' => 'حذف منتج', 'group_name' => 'Products']);
        $role->givePermissionTo('delete_product');
        Permission::create(['name' => 'view_product', 'guard_name' => 'admin', 'display_name' => 'اظهار منتج', 'group_name' => 'Products']);
        $role->givePermissionTo('view_product');
        Permission::create(['name' => 'view_activity_log', 'guard_name' => 'admin', 'display_name' => 'اظهار سجل النشاطات', 'group_name' => 'activity_logs']);
        $role->givePermissionTo('view_activity_log');


        $admin->assignRole($role);

    }
}
