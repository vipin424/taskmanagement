<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Define 20 sample tasks to be inserted into the database
        for ($i = 1; $i <= 20; $i++) {
            Task::create([
                'title' => 'Task ' . $i,
                'description' => 'This is the description for Task ' . $i,
                'due_date' => Carbon::now()->addDays(rand(1, 30)), // Set due date randomly within the next 30 days
                'status' => 'Pending',
            ]);
        }
    }
}
