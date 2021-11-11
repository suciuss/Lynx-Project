<?php

namespace App\Http\Controllers;

use App\Models\Terms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontController extends Controller
{


    private $latestTerms;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->latestTerms = Terms::whereNotNull('publication_date')->orderBy('publication_date', 'DESC')->first();
    }


    public function showTerms() {

        $term = Terms::whereNotNull('publication_date')->orderBy('publication_date', 'DESC')->first();

        return view('terms.latest_terms_and_conditions',[
            'term' => $term,
            'currentUser' => Auth::user(),
            'latestTerms' => $this->latestTerms
        ]);
    }
}
