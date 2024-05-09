<?php

namespace Phpsa\FilamentAuthentication\Commands;

use Illuminate\Console\Command;

class UpdateUserPasswordToUpdatedCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'filament-authentication:set-passwords-changed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install script for Filament Authentication password renewal updates';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->line('*********************************');
        $this->line('*     FILAMENT AUTHENTICATION     *');
        $this->line('*********************************');

        config('filament-authentication.models.User')::whereDoesntHave('renewables')->get()->each(function ($user) {
            $user->renewables()->create([
            ]);
        });

        $this->components->info('Thank you!');

        return static::SUCCESS;
    }
}
