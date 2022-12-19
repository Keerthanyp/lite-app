<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Auth facade gives us access to logged in user
        // $userId = Auth::user()->id; or
        // $userId = Auth::id();

        //using eloquent to retrieve the data:
        // $notes = Note::where('user_id', $userId)->get(); or

        // $notes = Note::where('user_id', Auth::id())->get();

        // to use pagination in the listing use paginate instead of get method
        // $notes = Note::where('user_id', Auth::id())->latest('updated_at')->paginate(3);

        // return view('notes.index');

        // passing the notes variable inside the view function or by adding "with" helper method
        // return view('notes.index, $notes) or

        //eloquent relations:
        // $notes = Auth::user()->notes()->latest('updated_at')->paginate(5);
        $notes = Note::whereBelongsTo(Auth::user())->latest('updated_at')->paginate(5);
        return view('notes.index')->with('notes', $notes);

        // $notes = Note::where('user_id', Auth::id())->latest('updated_at')->get(); //to display the last updated data
        // dd($notes);

        // using the collection method- to display specific data:
        // $notes->each(function($notes){
        //     dd($notes->text);
        // });
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('notes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:120',
            'text' => 'required',
        ]);

        // 1st method
        // $note= new Note([
        //     'user_id' =>Auth::id(),
        //     'title' => $request->title,
        //     'text' =>$request->text
        // ]);
        // $note->save();

        // 2nd method: will automatically create object and save
        // Note::create([
        //     'uuid' => Str::uuid(),
        //     'user_id' => Auth::id(),
        //     'title' => $request->title,
        //     'text' => $request->text,
        // ]);

        // 3rd method using relations:
        Auth::user()->notes()->create([
            'uuid' => Str::uuid(),
            'title' => $request->title,
            'text' => $request->text,
        ]);
        //

        return to_route('notes.index'); //route syntax added in laravel9
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($uuid)
    // {
    // using uuid instead of id because the id number would be displayed in  the url, so using uuid as a slug to hide the number of ids
    // $note = Note::where('uuid', $uuid)->where('user_id', Auth::id())->firstOrFail();

    // $note = Note::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
    // return view('notes.show')->with('note', $note);
    // }

    //route model binding: injecting model
    // instead of uuid, whole model can be used to display the data, no need to query
    public function show(Note $note)
    {
        //to authorize: gates can be used or in a simple way:
        // if ($note->user_id != Auth::id()) {
        //     return abort(403);
        // }

        if (!$note->user->is(Auth::user())) {
            return abort(403);
        }
        return view('notes.show')->with('note', $note);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Note $note)
    {
        // if ($note->user_id != Auth::id()) {
        //     return abort(403);
        // }
        if (!$note->user->is(Auth::user())) {
            return abort(403);
        }
        return view('notes.edit')->with('note', $note);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Note $note)
    {
        $request->validate([
            'title' => 'required|max:120',
            'text' => 'required',
        ]);
        // if ($note->user_id != Auth::id()) {
        //     return abort(403);
        // }
        if (!$note->user->is(Auth::user())) {
            return abort(403);
        }
        $note->update([
            'title' => $request->title,
            'text' => $request->text,
        ]);
        return to_route('notes.show', $note)->with('success', 'Note updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Note $note)
    {
        if ($note->user_id != Auth::id()) {
            return abort(403);
        }
        $note->delete();

        return to_route('notes.index')->with('success', 'Note was moved to trash');
    }
}
