<?php

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SuperAdmin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Admin::create([
            'name' => 'mohammad',
            'family' => 'Hamzeh',
            'username' => 'mohammad',
            'email' => 'mr.hamze00@gmail.com',
            'phone' => '09903081021',
            'password' => bcrypt('12345678'),
        ]);

        $role = Role::create([
            'name' => 'SuperAdmin',
            'label' => 'SuperAdmin',
            'guard_name' => 'admin',
        ]);

        $default_permissions = [
            ['admin.browse', 'جستجو ادمین'],
            ['admin.read', 'مشاهده ادمین'],
            ['admin.edit', 'ویرایش ادمین'],
            ['admin.add', 'افزودن ادمین'],
            ['admin.delete', 'حذف ادمین'],
            ['admin.disable', 'فعال/غیرفعال سازی ادمین'],
            ['admin.transform', 'انتقال داده های ادمین'],

            ['role.browse', 'جستجو سطح دسترسی'],
            ['role.read', 'مشاهده سطح دسترسی'],
            ['role.edit', 'ویرایش سطح دسترسی'],
            ['role.add', 'افزودن سطح دسترسی'],
            ['role.delete', 'حذف سطح دسترسی'],
            ['role.disable', 'فعال/غیرفعال سازی سطح دسترسی'],
            ['role.transform', 'انتقال داده های سطح دسترسی'],

            ['article.browse', 'جستجو مقالات'],
            ['article.read', 'مشاهده مقالات'],
            ['article.edit', 'ویرایش مقالات'],
            ['article.add', 'افزودن مقالات'],
            ['article.ban', 'مسدود مقالات'],
            ['article.delete', 'حذف مقالات'],

            ['category.browse', 'جستجو دسته بندی ها'],
            ['category.read', 'مشاهده دسته بندی ها'],
            ['category.edit', 'ویرایش دسته بندی ها'],
            ['category.add', 'افزودن دسته بندی ها'],
            ['category.delete', 'حذف دسته بندی ها'],

            ['product.browse', 'جستجو محصولات'],
            ['product.read', 'مشاهده محصولات'],
            ['product.edit', 'ویرایش محصولات'],
            ['product.add', 'افزودن محصولات'],
            ['product.delete', 'حذف محصولات'],

            ['order.browse', 'جستجو سفارش ها'],
            ['order.read', 'مشاهده سفارش ها'],
            ['order.edit', 'ویرایش سفارش ها'],
            ['order.add', 'افزودن سفارش ها'],
            ['order.delete', 'حذف سفارش ها'],

            ['payment.browse', 'جستجو پرداخت ها'],
            ['payment.read', 'مشاهده پرداخت ها'],
            ['payment.edit', 'ویرایش پرداخت ها'],
            ['payment.add', 'افزودن پرداخت ها'],
            ['payment.delete', 'حذف پرداخت ها'],
            
            ['panel_settings.browse', 'جستجو تنظیمات پنل'],
            ['panel_settings.read', 'مشاهده تنظیمات پنل'],
            ['panel_settings.edit', 'ویرایش تنظیمات پنل'],
            ['panel_settings.add', 'افزودن تنظیمات پنل'],
            ['panel_settings.delete', 'حذف تنظیمات پنل'],


        ];

        foreach ($default_permissions as $default_permission) {
            $permission = Permission::create([
                'name' => $default_permission[0],
                'label' => $default_permission[1],
                'guard_name' => 'admin',
            ]);
            $role->givePermissionTo($permission);
        }

        $admin = Admin::where('email', 'mr.hamze00@gmail.com')->first();
        $admin->assignRole('SuperAdmin');
    }
}
