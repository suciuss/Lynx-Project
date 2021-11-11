<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditUserRequest;
use App\Models\Terms;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
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

        $users = User::all();

        return view('home', [
            'users' => $users,
            'currentUser' => Auth::user(),
            'latestTerms' => $this->latestTerms
        ]);
    }


    public function secondPage()
    {
        return view('second_page', [
            'currentUser' => Auth::user(),
            'latestTerms' => $this->latestTerms
        ]);
    }


    public function editUserView($userId) {
        $user = User::find($userId);

        return view('edit_user', [
            'user' => $user,
            'currentUser' => Auth::user(),
            'latestTerms' => $this->latestTerms
        ]);
    }

    public function editUser(EditUserRequest $request) {
        $input = $request->input();
        $user = User::find($input['id']);

        $userOldEmail = $user->email;

        $user->update([
            'name' => $input['name'],
            'email' => $input['email'],
            'phone_number' => $input['phone_number'],
            'password' => Hash::make($input['password'])
        ]);
        $user->save();

        if($user != $userOldEmail){
            $user->email_verified_at = null;
            $user->sendEmailVerificationNotification();
            $user->save();
        }

        return redirect()->route('home');
    }

    public function deleteUser(Request $request) {
        $user = User::find(intval($request->getContent()));
        $user->delete();
    }

    public function unverifyUser(Request $request) {
        $user = User::find(intval($request->getContent()));
        $user->email_verified_at = null;
        $user->save();
    }

}
