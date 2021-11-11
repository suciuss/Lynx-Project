<?php

namespace App\Console\Commands;

use App\Models\Terms;
use App\Models\User;
use Illuminate\Console\Command;

class DeleteOldTerms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete-old:terms';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete all old terms and conditions(published that are not accepted by any user)';

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
        $users = User::all();
        $terms = Terms::whereNotNull('publication_date')->get();

        foreach ($terms as $term) {
            $termToDeleteFlag = false;
            foreach ($users as $user) {
                if ($term->id == $user->accepted_terms_id) {
                    $termToDeleteFlag = true;
                }
            }
            if ($termToDeleteFlag == false) {
                $term->delete();
            }
        }
        return true;
    }
}
