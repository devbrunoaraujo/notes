<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\Operations;


class MainController extends Controller
{
    public function index()
    {
        //load user and your notes
        $id = session('user.id');
        $notes = User::find($id)->notes()->get()->toArray();

        return view('home', ['notes' => $notes]);
    }

    public function newNote()
    {
        echo "new note";
    }

    public function editNote($id)
    {
        $id = Operations::decryptID($id);
        echo $id;
    }

    public function deleteNote($id)
    {
        $id = Operations::decryptID($id);
        echo $id;
    }

}
