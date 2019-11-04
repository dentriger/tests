<?php


namespace App\Http\Controllers;

use App\TestResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class TestController
 * @package App\Http\Controllers
 */
class TestController extends Controller
{
    public function publishTest(Request $request)
    {
        $this->validate($request, [
            'results' => 'json|required'
        ]);

        $user = Auth::user();
        $data = [];
        $data['results'] = $request->input('results');
        $data['userId'] = $user->id;

        $result = TestResult::create($data);

        return response()->json(['success' => true]);
    }


    public function getResults()
    {
        $results = TestResult::with('user')->get();
        return response()->json($results);
    }
}
