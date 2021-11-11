<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class UnferifyUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'unverify:user {userId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Unverifying a user`s email by id';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $user = User::find($this->argument('userId'));
        $user->email_verified_at = null;
        $user->save();
        return true;
    }
}
