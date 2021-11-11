<?php

namespace App\Http\Controllers;

use App\Events\TermsPublished;
use App\Models\Terms;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class TermsController extends Controller
{

    private $latestTerms;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','verified']);
        $this->latestTerms = Terms::whereNotNull('publication_date')->orderBy('publication_date', 'DESC')->first();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $terms = Terms::all();

        return view('terms.terms_and_conditions', [
            'terms' => $terms,
            'currentUser' => Auth::user(),
            'latestTerms' => $this->latestTerms
        ]);
    }

    public function createTermsView() {
        return view('terms.create_terms', [
            'currentUser' => Auth::user(),
            'latestTerms' => $this->latestTerms
        ]);
    }

    public function createTerms(Request $request) {

        $newTerms = Terms::create([
            'name' => $request->input()['name'],
            'content' => $request->input()['content'],
            'publication_date' => $request->input()['publication_date'] == "null" ?  null : Carbon::now()
        ]);
        $newTerms->save();

        return redirect()->route('termsAndConditions');
    }

    public function publishTerms($termsId) {
        $terms = Terms::find($termsId);

        $terms->publication_date = Carbon::now();
        $terms->save();
        TermsPublished::dispatch($terms->id);
        return redirect()->route('termsAndConditions');
    }

    public function editTermsView($termsId) {
        $terms = Terms::find($termsId);

        if($terms->publication_date != null) {
            return redirect()->route('termsAndConditions');
        }

        return view('terms.edit_terms', [
            'terms' => $terms,
            'currentUser' => Auth::user(),
            'latestTerms' => $this->latestTerms
        ]);
    }

    public function editTerms(Request $request) {
        $requestData = $request->input();

        $termsToBeUpdated = Terms::find($requestData['id']);
        $termsToBeUpdated->update([
            'name' => $requestData['name'],
            'content' => $requestData['content']
        ]);
        $termsToBeUpdated->save();

        return redirect()->route('termsAndConditions');
    }

    public function deleteTerms($termsId) {
        $termsToBeDeleted = Terms::find($termsId);

        if($termsToBeDeleted->publication_date != null) {
            return redirect()->route('termsAndConditions');
        }

        $termsToBeDeleted->delete();
        return redirect()->route('termsAndConditions');
    }

    public function acceptLatestTerms(Request $request) {
        $userToAcceptNewTerms = User::find($request->input(['0']));

        $userToAcceptNewTerms->accepted_terms_id = Terms::whereNotNull('publication_date')->orderBy('publication_date', 'DESC')->first()->id;
        $userToAcceptNewTerms->save();

        return redirect()->route('home');
    }

    public function acceptedTerms() {

        $currentUser = Auth::user();

        $term = Terms::find($currentUser->accepted_terms_id);

        return view('terms.curently_accepted_terms_and_conditions',[
            'term' => $term,
            'currentUser' => Auth::user(),
            'latestTerms' => $this->latestTerms
        ]);
    }
}
