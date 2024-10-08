<?php

namespace App\Http\Controllers;

use App\Models\Notes;
use App\Http\Requests\StoreNotesRequest;
use App\Http\Requests\UpdateNotesRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        if(Auth::User()->authority > 2){
            return redirect()->route('Notes.index',
            ['Notes' =>Notes::latest()->where('Hide', '=', 0)->paginate(10)])
            ->withErrors(['error' => 'You have no access to create Notes']);
        }
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
            'Content' => 'required',
            'Image' => 'image|mimes:jpeg,jpg,png,gif',
        ]);

        //get the latest id from database
        $id = DB::table('notes')->max('id');
        $id++;
        $filename = $id.'.txt';

        //store the txt file and Notes_Image into public
        Storage::disk('public/Notes')->put($filename, $data['Content']);

        if(isset($data['Image'])){
            $Image = request('Image')->store('Notes_Image', 'public');

            Auth()->User()->Notes()->create([
                'Subject' => $data['Subject'],
                'Image' => $Image
            ]);
        }else{
            Auth()->User()->Notes()->create([
                'Subject' => $data['Subject'],
                //if the user didn't import a image, take the default.png
                'Image' => 'default.png'
            ]);

        }

        Auth()->User()->Notes_History()->create([
            'Notes_id' => $id,
            'Move' => 'Create'
        ]);

        Auth()->User()->User_History()->create([
            'Move' => 'Create_Notes',
            'Notes_id' => $id
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
        // dd($Views);
        $path = 'C:\xampp\htdocs\Online-Notes\storage\app\public\Notes\\'.$id.'.txt';
        //fopen is a resources type, can't pass to view
        $Content = file_get_contents($path);

        if((Auth()->User()) != null){
            DB::table('Notes')->where('id', '=', $id)->
            update([
                'Views' => $Views
            ]);

            Auth()->User()->Notes_History()->create([
                'Notes_id' => $id,
                'Move' => 'Read'
            ]);
    
            Auth()->User()->User_History()->create([
                'Move' => 'Read_Notes',
                'Notes_id' => $id
            ]);
        }else{
            //because we didn't login, so can't use Auth()->User()            

            DB::table('Notes')->where('id', '=', $id)->
            update([
                'Views' => $Views
            ]);
            
            DB::table('Notes_History')->
            insert([
                'user_id' => 0,
                'Notes_id' => $id,
                'Move' => 'Read'
            ]);

            DB::table('User_History')->
            insert([
                'user_id' => '0',
                'Move' => 'Read_Notes',
                'Notes_id' => $id
            ]);
        }

        return view('Notes.show', [
            'Notes' => [
                'creator' => app('App\Models\User')->find($Notes->user_id),
                'Subject' => $Notes->Subject,
                'Views' => $Notes->Views,
                'created_at' => $Notes->created_at,
                'updated_at' => $Notes->updated_at,
            ],
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

        if(Auth::User() != $id){
            return redirect()->route('Notes.index',
            ['Notes' =>Notes::latest()->where('Hide', '=', 0)->paginate(10)])
            ->withErrors(['error' => 'You have no access to edit other\'s Note']);
        }

        $Image = $Notes->Image;

        $path_Notes = 'C:\xampp\htdocs\Online-Notes\storage\app\public\Notes\\'.$id.'.txt';
        //fopen is a resources type, can't pass to view
        $Content = file_get_contents($path_Notes);
        
        $path_Image = 'C:\xampp\htdocs\Online-Notes\storage\app\public\Notes_Image\\'.$Image;

        return view('Notes.edit', [
            'Notes' => $Notes,
            'Content' => $Content,
            'Image' => $path_Image
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

        if( isset($request['Image']) ){
            $Image = request('Image')->store('Notes_Image', 'public');

            Auth()->User()->Notes()->where('id', '=' , $id)->update([
                'Subject' => $Subject,
                'Image' => $Image
            ]);    
        }else{
            Auth()->User()->Notes()->where('id', '=' , $id)->update([
                'Subject' => $Subject,
            ]);    
        }

        Auth()->User()->Notes_History()->create([
            'Notes_id' => $id,
            'Move' => 'Update'
        ]);

        Auth()->User()->User_History()->create([
            'Move' => 'Update_Notes',
            'Notes_id' => $id
        ]);

        return redirect()->route('Notes.index')->withSuccess('Notes is updated successfully!!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($Notes)
    {
        $Notes = Notes::find($Notes);
        $id  = $Notes->id;

        if(Auth::User() != $Notes->user_id){
            return redirect()->route('Notes.index',
            ['Notes' =>Notes::latest()->where('Hide', '=', 0)->paginate(10)])
            ->withErrors(['error' => 'You have no access to delete other\'s Notes']);
        }

        Auth()->User()->Notes()->where('id', '=', $id)->update([
            'Hide' => 1,
        ]);

        Auth()->User()->Notes_History()->create([
            'Notes_id' => $id,
            'Move' => 'Delete'
        ]);

        Auth()->User()->User_History()->create([
            'Move' => 'Delete_Notes',
            'Notes_id' => $id
        ]);

        return redirect()->back()->withSuccess('Notes is deleted successfully!!');
    }
}
