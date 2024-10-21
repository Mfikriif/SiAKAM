<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'id' => 1,
                'name' => 'mahasiswa',
                'email' => 'mahasiswa@gmail.com',
                'password' => '$2y$10$LA64dB4T92MgDlKcBCpruO7XEltIuRclpHtecPB9HYcA.8RsFJbzm',
                'remember_token' => null,
                'created_at' => '2024-09-23 02:51:23',
                'updated_at' => '2024-09-23 02:51:23',
                'mahasiswa' => 1,
                'dekan' => 0,
                'kaprodi' => 0,
                'dosenwali' => 0,
                'akademik' => 0,
            ],
            [
                'id' => 2,
                'name' => 'dekan',
                'email' => 'dekan@gmail.com',
                'password' => '$2y$12$KvdVhhkz5jrw9kQtDLQ9levprovQNNsAGXwOItR7N7xlAfme2P/O2',
                'remember_token' => null,
                'created_at' => '2024-09-23 02:52:36',
                'updated_at' => '2024-09-23 02:52:36',
                'mahasiswa' => 0,
                'dekan' => 1,
                'kaprodi' => 0,
                'dosenwali' => 0,
                'akademik' => 0,
            ],
            [
                'id' => 3,
                'name' => 'kaprodi',
                'email' => 'kaprodi@gmail.com',
                'password' => '$2y$12$N8AK8KcHaD1.CqeqTBe3zelnYV.p4oucHTrLaVKqkCw4lczlnCZPi',
                'remember_token' => null,
                'created_at' => '2024-09-23 03:30:53',
                'updated_at' => '2024-09-23 03:30:53',
                'mahasiswa' => 0,
                'dekan' => 0,
                'kaprodi' => 1,
                'dosenwali' => 0,
                'akademik' => 0,
            ],
            [
                'id' => 4,
                'name' => 'akademik',
                'email' => 'akademik@gmail.com',
                'password' => '$2y$12$onzo1ehPQJPPvkN7kL5xrOx.vwKMVL5tSUSWmhBANThhI667W06He',
                'remember_token' => null,
                'created_at' => '2024-09-23 03:33:34',
                'updated_at' => '2024-09-23 03:33:34',
                'mahasiswa' => 0,
                'dekan' => 0,
                'kaprodi' => 0,
                'dosenwali' => 0,
                'akademik' => 1,
            ],
            [
                'id' => 5,
                'name' => 'dosenwali',
                'email' => 'dosenwali@gmail.com',
                'password' => '$2y$12$e/8.0aNKzo2EAJAPq5lPreXa6FdB6Moqnt5yDIejN73mwMkVO0rGa',
                'remember_token' => null,
                'created_at' => '2024-09-23 03:34:03',
                'updated_at' => '2024-09-23 03:34:03',
                'mahasiswa' => 0,
                'dekan' => 0,
                'kaprodi' => 0,
                'dosenwali' => 1,
                'akademik' => 0,
            ],
            [
                'id' => 6,
                'name' => 'dosenwali2',
                'email' => 'dosenwali2@gmail.com',
                'password' => '$2y$12$pmTv00lYgXGQsgbZLsqcMu9p9JUKxoR9HR5bq.ZtxHU0HmUTqZ/ZO',
                'remember_token' => null,
                'created_at' => '2024-09-23 03:34:03',
                'updated_at' => '2024-09-24 06:03:42',
                'mahasiswa' => 0,
                'dekan' => 0,
                'kaprodi' => 1,
                'dosenwali' => 1,
                'akademik' => 0,
            ],
            [
                'id' => 7,
                'name' => 'dosenwali3',
                'email' => 'dosenwali3@gmail.com',
                'password' => '$2y$12$gOXpGu50/z9i6hqQprFErueWMaFm2SXVvA3TNk24.WSOfncA5YFbO',
                'remember_token' => null,
                'created_at' => '2024-09-23 03:34:03',
                'updated_at' => '2024-09-24 06:53:33',
                'mahasiswa' => 0,
                'dekan' => 1,
                'kaprodi' => 0,
                'dosenwali' => 1,
                'akademik' => 0,
            ],
            [
                'id' => 8,
                'name' => 'Muhammad FIkri Firdaus',
                'email' => 'mfikrif@gmail.com',
                'password' => 'Fikri12345',
                'remember_token' => null,
                'created_at' => '2024-09-23 03:34:03',
                'updated_at' => '2024-09-24 06:53:33',
                'mahasiswa' => 1,
                'dekan' => 0,
                'kaprodi' => 0,
                'dosenwali' => 0,
                'akademik' => 0,
            ],
        ]);
    }
}
