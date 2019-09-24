<?php


namespace App\Http\Controllers;

use App\StudentUser;
use App\TeacherUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function login(Request $request)
    {
        $this->validate($request, [
            'name' => 'string|required',
            'surname' => 'string|required',
            'password' => 'string|required_without:group',
            'group' => 'integer|required_without:password'
        ]);

        if ($request->has('password')) {
            return $this->teacherLogin($request);
        }

        $userData = [];

        $userData['name'] = $request->input('name');
        $userData['surname'] = $request->input('surname');
        $userData['group'] = $request->input('group');

        $user = StudentUser::firstOrCreate($userData);

        return response()->json(['status' => true, 'apiToken' => $user->getAuthToken()]);
    }

    public function teacherLogin(Request $request)
    {
        $user = TeacherUser::where([
            'name' => $request->input('name'),
            'surname' => $request->input('surname')
        ])->first();

        if ($user && Hash::check($request->input('password'), $user->password)) {
            return response()->json(['status' => true, 'apiToken' => $user->getAuthToken()]);
        }

        return response()->json(['status' => false, 'message' => 'Invalid credentials'], 401);
    }

    public function register()
    {
        TeacherUser::create(['name' => 'Admin', 'surname' => 'Admin', 'password' => app('hash')->make('123')]);

        return response()->json(['status' => true]);
    }

    public function getUser()
    {
        return response()->json([Auth::user()]);
    }
}