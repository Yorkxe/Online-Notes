<?php

namespace App\Http\Controllers;

use App\Models\Notes;
use App\Http\Requests\StoreNotesRequest;
use App\Http\Requests\UpdateNotesRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class NotesController extends Controller
{   
    //constraint the store, update, edit, create, destroy method should be logged in to use
    
    /**
     * Display the latest 10 Notes.
     */
    public function index()
    {
        return view('Notes.index', ['Notes' =>Notes::latest()->where('Hide', '=', 0)->paginate(10)]);
    }

    /**
     * Show the form for creating a new note.
     */
    public function create()
    {
        return view('Notes.create');
    }

    /**
     * Store data in db and a newly created note in storage.
     */
    public function store(StoreNotesRequest $request)
    {
        //get the Subject & Content
        $data = request()->validate([
            'Subject' => 'required',
            'Content' => 'required'
        ]);
        // dd($data);
        //get the latest id from database
        $id = DB::table('notes')->max('id');
        $id++;
        $filename = $id.'.txt';
        
        //store the txt file into public
        Storage::disk('public/Notes')->put($filename, $data['Content']);        
        
        //store Subject into database
        Auth()->User()->Notes()->create([
            'Subject' => $data['Subject'],
        ]);

        Auth()->User()->Notes_History()->create([
            'Notes_id' => $id,
            'Move' => 'Create'
        ]);

        Auth()->User()->User_History()->create([
            'Move' => 'Create'
        ]);

        return redirect()->route('Notes.index')->withSuccess('New Notes is added successfully!!');
    }

    /**
     * Display a certain Note.
     */
    public function show($Notes)
    {
        //in case of user manual typing the no-existing Notes
        $Notes = Notes::findOrFail($Notes);
        
        $id = $Notes->id;
        $Views = $Notes->Views;
        $Views++;

        $path = 'C:\xampp\htdocs\Online-Notes\storage\app\public\Notes\\'.$id.'.txt';
        //fopen is a resources type, can't pass to view
        $Content = file_get_contents($path);

        if((Auth()->User()) != null){
            Auth()->User()->Notes()->update([
                'Views' => $Views
            ]);

            Auth()->User()->Notes_History()->create([
                'Notes_id' => $Notes,
                'Move' => 'Show'
            ]);
    
            Auth()->User()->User_History()->create([
                'Move' => 'Show'
            ]);
        }else{
            //because we didn't login, so can't use Auth()->User()            
            DB::transaction(function () use($id, $Views) {

                DB::table('Notes')->
                update([
                    'Views' => $Views
                ]);
                
                DB::table('Notes_History')->
                insert([
                    'user_id' => '0',
                    'Notes_id' => $id,
                    'Move' => 'Show'
                ]);
    
                DB::table('User_History')->
                insert([
                    'user_id' => '0',
                    'Move' => 'Show'
                ]);
            });
        }

        return view('Notes.show', [
            'Notes' => $Notes,
            'Content' => $Content
        ]);
    }

    /**
     * Show the form for editing the specified Note.
     */
    public function edit($Notes)
    {
        $Notes = Notes::findOrFail($Notes);
        $id = $Notes->id;

        $path = 'C:\xampp\htdocs\Online-Notes\storage\app\public\Notes\\'.$id.'.txt';
        //fopen is a resources type, can't pass to view
        $Content = file_get_contents($path);
        
        return view('Notes.edit', [
            'Notes' => $Notes,
            'Content' => $Content
        ]);
    }

    /**
     * Update the specified Note in storage.
     */
    public function update(UpdateNotesRequest $request)
    {
        $id = $request['id'];
        $Subject = $request['Subject'];
        $Content = $request['Content'];
        
        $path = 'C:\xampp\htdocs\Online-Notes\storage\app\public\Notes\\'.$id.'.txt';
        $file = fopen($path, 'r+');
        fwrite($file, $Content);

        Auth()->User()->Notes()->where('id', '=' , $id)->update([
            'Subject' => $Subject,
        ]);

        Auth()->User()->Notes_History()->create([
            'Notes_id' => $id,
            'Move' => 'Update'
        ]);

        Auth()->User()->User_History()->create([
            'Move' => 'Update'
        ]);

        return redirect()->route('Notes.index')->withSuccess('Notes is updated successfully!!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($Notes)
    {
        $Notes = Notes::find($Notes);

        Auth()->User()->Notes()->where('id', '=', $Notes->id)->update([
            'Hide' => 1,
        ]);

        Auth()->User()->Notes_History()->create([
            'Notes_id' => $Notes->id,
            'Move' => 'Delete'
        ]);

        Auth()->User()->User_History()->create([
            'Move' => 'Delete'
        ]);

        return redirect()->back()->withSuccess('Notes is deleted successfully!!');
    }
}
