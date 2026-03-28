<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Permission;
use App\Models\PermissionGroup;
use App\Models\Role;
use App\Models\User;
use App\Models\Business;
use App\Models\Sale;
use App\Models\Kampanye;
use App\Models\Prospek;
use App\Models\ProspekTimeline;
use App\Models\Activity;
use App\Models\Referral;
use App\Models\Pengajuan;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🌱 Starting seed...');

        // =====================
        // PERMISSIONS
        // =====================
        $modules = [
            'Dashboard', 'Kampanye', 'Laporan Sales', 'Referral',
            'Form Pengajuan', 'Pengaturan', 'Manajemen User', 'Activity Log',
        ];
        $actions = ['access', 'create', 'update', 'delete'];

        foreach ($modules as $moduleName) {
            $pageSlug = strtolower(str_replace(' ', '-', $moduleName));
            if ($moduleName === 'Pengaturan') $pageSlug = 'pengaturan-sistem';

            foreach ($actions as $action) {
                $permissionName = $moduleName . ' ' . ucfirst($action);
                Permission::updateOrCreate(
                    ['name' => $permissionName],
                    ['page' => $pageSlug, 'action' => $action]
                );
            }
        }

        $allPermissions = Permission::all();

        // =====================
        // PERMISSION GROUPS
        // =====================
        $allPermIds = $allPermissions->pluck('id')->toArray();
        $salesPermIds = $allPermissions
            ->whereIn('page', ['dashboard', 'laporan-sales', 'form-pengajuan'])
            ->pluck('id')
            ->toArray();

        $adminGroup = PermissionGroup::updateOrCreate(['name' => 'Admin Group']);
        $adminGroup->permissions()->sync($allPermIds);

        $supervisorGroup = PermissionGroup::updateOrCreate(['name' => 'Supervisor Group']);
        $supervisorGroup->permissions()->sync($allPermIds);

        $salesGroup = PermissionGroup::updateOrCreate(['name' => 'Sales Group']);
        $salesGroup->permissions()->sync($salesPermIds);

        // =====================
        // ROLES
        // =====================
        $adminRole = Role::updateOrCreate(
            ['name' => 'Admin'],
            ['level' => 100, 'permission_group_id' => $adminGroup->id]
        );
        $supervisorRole = Role::updateOrCreate(
            ['name' => 'Supervisor'],
            ['level' => 50, 'permission_group_id' => $supervisorGroup->id]
        );
        $staffRole = Role::updateOrCreate(
            ['name' => 'Staff Sales'],
            ['level' => 10, 'permission_group_id' => $salesGroup->id]
        );

        // =====================
        // USERS
        // =====================
        User::updateOrCreate(
            ['email' => 'admin@asitatech.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('admin123'),
                'phone_number' => '081234567890',
                'address' => 'Jakarta Pusat',
                'role_id' => $adminRole->id,
                'status' => true,
                'has_2fa' => false,
                'created_at' => '2023-01-15',
            ]
        );

        User::updateOrCreate(
            ['email' => 'supervisor@asitatech.com'],
            [
                'name' => 'Budi Santoso',
                'password' => Hash::make('supervisor123'),
                'phone_number' => '081234567890',
                'address' => 'Jakarta Pusat',
                'role_id' => $supervisorRole->id,
                'status' => true,
                'has_2fa' => false,
                'created_at' => '2023-01-15',
            ]
        );

        $staffUser = User::updateOrCreate(
            ['email' => 'staff@asitatech.com'],
            [
                'name' => 'Staff Sales',
                'password' => Hash::make('staff123'),
                'role_id' => $staffRole->id,
                'status' => true,
                'has_2fa' => false,
            ]
        );

        // =====================
        // BUSINESS
        // =====================
        $business = Business::updateOrCreate(
            ['id' => 1],
            [
                'name' => 'Asita Tech',
                'address' => 'Jakarta',
                'phone_number' => '08123456789',
                'email' => 'contact@asitatech.com',
                'status' => 'active',
                'pic_id' => $staffUser->id,
            ]
        );

        // =====================
        // SALES
        // =====================
        if (Sale::count() === 0) {
            Sale::insert([
                ['business_id' => $business->id, 'amount' => 5000000, 'description' => 'Software License', 'status' => 'Completed', 'created_at' => '2024-01-10', 'updated_at' => now()],
                ['business_id' => $business->id, 'amount' => 2500000, 'description' => 'Monthly Maintenance', 'status' => 'Completed', 'created_at' => '2024-02-15', 'updated_at' => now()],
                ['business_id' => $business->id, 'amount' => 12000000, 'description' => 'Custom Feature Development', 'status' => 'Completed', 'created_at' => '2024-02-28', 'updated_at' => now()],
            ]);
        }

        // =====================
        // KAMPANYES
        // =====================
        if (Kampanye::count() === 0) {
            Kampanye::insert([
                ['name' => 'Campaign Q1', 'channel' => 'Instagram', 'type' => 'Video', 'schedule' => now(), 'status' => 'active', 'notes' => 'Initial campaign', 'pic_id' => $staffUser->id, 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'Promo Lebaran 2024', 'channel' => 'Instagram', 'type' => 'Foto', 'schedule' => now(), 'status' => 'Terjadwal', 'notes' => 'Posting di stories dan feed', 'pic_id' => $staffUser->id, 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'Email Blast - Fitur Baru', 'channel' => 'Email', 'type' => 'Web', 'schedule' => now(), 'status' => 'Terjadwal', 'notes' => '', 'pic_id' => $staffUser->id, 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'WhatsApp Follow Up Merchant', 'channel' => 'WhatsApp', 'type' => 'Artikel', 'schedule' => now(), 'status' => 'draft', 'notes' => '', 'pic_id' => $staffUser->id, 'created_at' => now(), 'updated_at' => now()],
            ]);
        }

        // =====================
        // PROSPEK
        // =====================
        if (Prospek::count() === 0) {
            $prospek = Prospek::create([
                'name' => 'John Doe',
                'phone_number' => '08129876543',
                'business_name' => 'Doe Store',
                'address' => 'Bandung',
                'status' => 'new',
                'schedule' => now(),
                'notes' => 'First contact',
                'pic_id' => $staffUser->id,
            ]);

            ProspekTimeline::create([
                'prospek_id' => $prospek->id,
                'message' => 'Called customer, interested',
                'schedule' => now(),
                'pic_id' => $staffUser->id,
            ]);
        }

        // =====================
        // ACTIVITY LOG
        // =====================
        if (Activity::count() === 0) {
            Activity::create([
                'user' => 'admin@asitatech.com',
                'module' => 'Seeder',
                'action' => 'CREATE',
                'description' => 'Initial database seed',
                'ip_address' => '127.0.0.1',
                'result' => 'SUCCESS',
            ]);
        }

        // =====================
        // REFERRAL
        // =====================
        if (Referral::count() === 0) {
            Referral::create([
                'recruiter_name' => 'Partner A',
                'referral_code' => 'REF123',
                'commission_value' => '10%',
                'commission_type' => 'percentage',
                'participant' => 20,
                'active_participant' => 10,
                'total_commission' => '2000000',
                'status' => 'active',
            ]);
        }

        // =====================
        // PENGAJUAN
        // =====================
        if (Pengajuan::count() === 0) {
            $pengajuanData = [
                ['name' => 'PT Maju Jaya', 'phone_number' => '081234567890', 'email' => 'jane@example.com', 'address' => 'Jl. Sudirman No. 123, Jakarta', 'status' => 'Diterima'],
                ['name' => 'Toko Berkah Abadi', 'phone_number' => '081234567891', 'email' => 'berkah@example.com', 'address' => 'Jl. Gatot Subroto No. 45, Bandung', 'status' => 'Perlu Verifikasi'],
                ['name' => 'UD Sejahtera', 'phone_number' => '081234567892', 'email' => 'sejahtera@example.com', 'address' => 'Jl. Ahmad Yani No. 78, Surabaya', 'status' => 'Disetujui'],
                ['name' => 'PT Maju Jaya', 'phone_number' => '081234567890', 'email' => 'jane@example.com', 'address' => 'Jl. Sudirman No. 123, Jakarta', 'status' => 'diterima'],
            ];

            foreach ($pengajuanData as $data) {
                Pengajuan::create(array_merge($data, [
                    'business_id' => $business->id,
                    'pic_id' => $staffUser->id,
                ]));
            }
        }

        $this->command->info('✅🌱 Seed completed successfully');
    }
}
