<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Note;
use Illuminate\Http\Request;
use App\Services\Operations;

class MainController extends Controller
{
    public function index()
    {
        //load user and your notes
        $id = session('user.id');
        $notes = User::find($id)->notes()->whereNull('deleted_at')->get()->toArray();

        return view('home', ['notes' => $notes]);
    }

    public function newNote()
    {   
        //show view new_note
        return view('new_note');
    }

    public function newNoteSubmit(Request $request)
    {   
        //validate request
        $request->validate(
            //rules
            [
                'text_title' => 'required|min:3|max:200',
                'text_note' => 'required|min:3|max:3000'

            ],
            
            //error messages
            [
                'text_title.required' => 'O título é obrigatório',
                'text_note.required' => 'O texto é obrigatório',
                'text_title.min' => 'Titulo deve ter no mínimo :min caracteres',
                'text_title.max' => 'Titulo deve ter no máximo :max caracteres',
                'text_note.min' => 'Texto deve ter no mínimo :min caracteres',
                'text_note.max' => 'Texto deve ter no máximo :max caracteres'
            ]
        );
        //get user id
        $id = session('user.id');
        
        //create new note
        $note = new Note();
        $note->user_id = $id;
        $note->title = $request->text_title;
        $note->text = $request->text_note;
        $note->save();

        //redirect to home
        return redirect()->route('home');
         
    }

    public function editNote($id)
    {
        $id = Operations::decryptID($id);
       
        //load note
        $note = Note::find($id);

        //show view edit note
        return view('edit_note', ['note' => $note]);
    }

    public function editNoteSubmit(Request $request)
    {
        //validate request
        $request->validate(
            //rules
            [
                'text_title' => 'required|min:3|max:200',
                'text_note' => 'required|min:3|max:3000'

            ],
            
            //error messages
            [
                'text_title.required' => 'O título é obrigatório',
                'text_note.required' => 'O texto é obrigatório',
                'text_title.min' => 'Titulo deve ter no mínimo :min caracteres',
                'text_title.max' => 'Titulo deve ter no máximo :max caracteres',
                'text_note.min' => 'Texto deve ter no mínimo :min caracteres',
                'text_note.max' => 'Texto deve ter no máximo :max caracteres'
            ]
        );

        //check if id exists
        if($request->note_id == null){
          return redirect()->route('home');
        }

        //desencrypt id
        $id = Operations::decryptID($request->note_id);
        
        //load note
        $note = Note::find($id);
        $note->title = $request->text_title;
        $note->text = $request->text_note;
        $note->save();

        //redirect to home
        return redirect()->route('home');
    }

    public function deleteNote($id)
    {
        $id = Operations::decryptID($id);

        $note = Note::find($id);
        return view('delete_note', [ 'note' => $note ]);
       
        
    }

    public function deleteNoteConfirm($id)
    {
        $id = Operations::decryptID($id);
       
        //load note
        $note = Note::find($id);

        /*hard delete
        $note->delete();
        */

        /*soft delete with alter date
        $note->deleted_at = date('Y-m-d H:i:s');
        $note->save();
        */
        
        //delete with trait in model SoftDeletes
        //$note->delete();

        //force delete with trait SofDeletes
        $note->forceDelete();
    
        
        //redirect to home
        return redirect()->route('home');

    }

}
