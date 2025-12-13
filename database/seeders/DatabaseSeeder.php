<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Project;
use App\Models\Task;
use App\Models\Comment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $mainUser = User::create([
            'name' => 'Muhammad Yasyfi',
            'email' => 'yasyfi7@gmail.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'is_admin' => true,
        ]);

        $adminUser = User::create([
            'name' => 'Admin Apexio',
            'email' => 'admin@apexio.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'is_admin' => true,
        ]);

        $teamNames = [
            'Michael Renatto', 'Mutia Putri', 'Sarah Designer',
            'Budi Frontend', 'Andi Backend', 'Citra QA',
            'Dewi Marketing', 'Eko DevOps', 'Fajar Mobile',
            'Gita HR', 'Hadi Finance', 'Indah Content',
            'Joko Security', 'Kevin UI', 'Lina UX'
        ];

        $teamUsers = [];
        foreach($teamNames as $name) {
            $teamUsers[] = User::create([
                'name' => $name,
                'email' => strtolower(str_replace(' ', '.', $name)) . '@apexio.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'is_admin' => false,
            ]);
        }

        $projectsData = [
            ['name' => 'Apexio Development (Final)', 'desc' => 'Finalisasi fitur dan persiapan presentasi UAS.'],
            ['name' => 'E-Commerce Revamp', 'desc' => 'Redesain UI/UX marketplace klien TokoMaju.'],
            ['name' => 'Internal HR System', 'desc' => 'Sistem absensi dan payroll karyawan berbasis web.'],
            ['name' => 'Mobile App Logistics', 'desc' => 'Aplikasi mobile untuk tracking armada logistik.'],
            ['name' => 'Server Migration AWS', 'desc' => 'Migrasi database on-premise ke cloud AWS RDS.'],
            ['name' => 'Security Audit Q4', 'desc' => 'Penetration testing dan perbaikan celah keamanan.'],
            ['name' => 'Rebranding Identity', 'desc' => 'Pembuatan logo baru dan brand guideline korporat.'],
            ['name' => 'Social Media Campaign', 'desc' => 'Konten Instagram dan TikTok untuk launching produk.'],
            ['name' => 'SEO Optimization', 'desc' => 'Audit keyword dan perbaikan meta tags website.'],
            ['name' => 'Event Tech Summit', 'desc' => 'Persiapan booth dan materi presentasi pameran.'],
            ['name' => 'Q4 Financial Report', 'desc' => 'Rekap laporan keuangan akhir tahun perusahaan.'],
            ['name' => 'Client Onboarding PT A', 'desc' => 'Setup akun dan training untuk klien baru.'],
            ['name' => 'Data Warehouse Build', 'desc' => 'Sentralisasi data penjualan dari berbagai cabang.'],
            ['name' => 'AI Chatbot Integration', 'desc' => 'Implementasi CS otomatis menggunakan OpenAI API.'],
            ['name' => 'Legacy System Update', 'desc' => 'Refactoring kode backend sistem lama.'],
        ];

        $priorities = ['low', 'medium', 'high', 'critical'];

        foreach ($projectsData as $index => $data) {
            $owner = ($index % 3 == 0) ? $mainUser : $teamUsers[array_rand($teamUsers)];

            $project = Project::create([
                'name' => $data['name'],
                'description' => $data['desc'],
                'owner_id' => $owner->id,
                'created_at' => now()->subDays(rand(10, 60)),
            ]);

            $project->members()->attach($mainUser->id, ['role' => 'Admin']);

            $randomMembers = collect($teamUsers)->random(rand(4, 7));
            foreach($randomMembers as $member) {
                if(!$project->members()->where('user_id', $member->id)->exists()){
                    $project->members()->attach($member->id, ['role' => 'Member']);
                }
            }

            for ($i = 0; $i < rand(4, 6); $i++) {
                $assignee = (rand(0, 1)) ? $mainUser : $teamUsers[array_rand($teamUsers)];
                $task = Task::create([
                    'project_id' => $project->id,
                    'title' => 'Tugas Selesai ' . ($i + 1) . ' - ' . substr($data['name'], 0, 10),
                    'description' => 'Tugas ini sudah diselesaikan bulan lalu.',
                    'status' => 'Done',
                    'priority' => $priorities[array_rand($priorities)],
                    'assignee_id' => $assignee->id,
                    'due_date' => now()->subDays(rand(10, 30)),
                    'created_at' => now()->subDays(40),
                ]);

                if(rand(0,1)) {
                    Comment::create([
                        'task_id' => $task->id,
                        'user_id' => $mainUser->id,
                        'body' => 'Pekerjaan yang bagus, terima kasih.',
                        'created_at' => now()->subDays(5),
                    ]);
                }
            }

            for ($i = 0; $i < rand(2, 4); $i++) {
                $prio = (rand(0,1)) ? 'critical' : 'high';
                Task::create([
                    'project_id' => $project->id,
                    'title' => 'URGENT: ' . ($i + 1) . ' ' . $data['name'],
                    'description' => 'Tugas ini sudah melewati deadline dan harus segera dikerjakan.',
                    'status' => 'In-Progress',
                    'priority' => $prio,
                    'assignee_id' => $mainUser->id,
                    'due_date' => now()->subDays(rand(1, 5)),
                    'created_at' => now()->subDays(10),
                ]);
            }

            for ($i = 0; $i < rand(3, 5); $i++) {
                Task::create([
                    'project_id' => $project->id,
                    'title' => 'Review Progress ' . ($i + 1),
                    'description' => 'Deadline tugas ini adalah hari ini atau besok.',
                    'status' => 'To-Do',
                    'priority' => 'high',
                    'assignee_id' => $mainUser->id,
                    'due_date' => now()->addHours(rand(1, 24)),
                    'created_at' => now()->subDays(2),
                ]);
            }

            for ($i = 0; $i < rand(4, 7); $i++) {
                $assignee = (rand(0, 1)) ? $mainUser : $teamUsers[array_rand($teamUsers)];
                Task::create([
                    'project_id' => $project->id,
                    'title' => 'Pengembangan Fitur ' . ($i + 1),
                    'description' => 'Tugas untuk pengembangan tahap selanjutnya.',
                    'status' => 'To-Do',
                    'priority' => $priorities[array_rand($priorities)],
                    'assignee_id' => $assignee->id,
                    'due_date' => now()->addDays(rand(5, 14)),
                    'created_at' => now()->subDays(1),
                ]);
            }
        }
    }
}