<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TodoController extends Controller
{
    public function create(Request $request)
    {
        $todo = new Todo();

        $todo->name = $request->input('name');
        $todo->desc = $request->input('desc');
        $todo->done = $request->input('done');

        if($request->file('file') != null) {
        $file = $request->file('file')->store('/');
            }
        else {
            return response()->json(['error' => 'is null']);
        }

        $todo->file = $file;

        $todo->save();
        return response()->json($todo);
    }

    public function delete($id) {
        Todo::where('id', $id)->delete();
    }


    public function __invoke()
    {
        dd('main');
    }

    public function getTodos () {
        return Todo::all();
    }

    public function update(Request $request) {
        $todo = Todo::find($request->id);
        if($request->input('name') != '')  {
            $todo->name = $request->input('name');
            $todo->save();
        }
        else {
            return ["result" => "Geen nieuwe naam opgegeven."];
        }
        if($request->input('desc') != '') {
            $todo->desc = $request->input('desc');
            $todo->save();
        }
        else {
            return ["result" => "Geen nieuwe beschrijving opgegeven."];
        }
        return ["result" => "Update request ontvangen."];
    }

    public function markComplete(Request $request) {
        $todo = Todo::find($request->id);
        $todo->done = $request->input('done');
        $todo->save();
    }
}

