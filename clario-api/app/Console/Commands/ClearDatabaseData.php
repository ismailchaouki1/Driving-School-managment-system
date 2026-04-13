<?php
// app/Console/Commands/ClearDatabaseData.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ClearDatabaseData extends Command
{
    protected $signature = 'db:clear-data';
    protected $description = 'Clear all data from database tables';

    public function handle()
    {
        if (!$this->confirm('Are you sure you want to delete ALL data? This action cannot be undone!')) {
            $this->info('Operation cancelled.');
            return;
        }

        $this->info('Clearing database tables...');

        // Disable foreign key checks
        Schema::disableForeignKeyConstraints();

        // Truncate tables
        DB::table('payments')->truncate();
        $this->info('✓ Payments table cleared');

        DB::table('driving_sessions')->truncate();
        $this->info('✓ Sessions table cleared');

        DB::table('students')->truncate();
        $this->info('✓ Students table cleared');

        DB::table('instructors')->truncate();
        $this->info('✓ Instructors table cleared');

        DB::table('vehicles')->truncate();
        $this->info('✓ Vehicles table cleared');

        DB::table('users')->truncate();
        $this->info('✓ Users table cleared');

        // Re-enable foreign key checks
        Schema::enableForeignKeyConstraints();

        $this->info('All data has been cleared successfully!');
    }
}
