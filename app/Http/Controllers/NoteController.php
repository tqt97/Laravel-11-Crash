<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notes = Note::query()
            ->where('user_id', auth()->user()->id)
            ->orderBy('created_at', 'desc')->paginate(6);
        return view('notes.index', ['notes' => $notes]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('notes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'note' => ['required', 'string'],
        ]);
        $data['user_id'] = auth()->user()->id;
        $note = Note::create($data);

        // return redirect()->route('notes.show', ['note' => $note]);
        return to_route('notes.show', ['note' => $note])->with('message', 'Note created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Note $note)
    {
        if($note->user_id !== auth()->user()->id) {
            abort(403);
        }
        return view('notes.show', ['note' => $note]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Note $note)
    {
        return view('notes.edit', ['note' => $note]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Note $note)
    {
        $data = $request->validate([
            'note' => ['required', 'string'],
        ]);
        $note->update($data);

        return to_route('notes.show', ['note' => $note])->with('message', 'Note updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Note $note)
    {
        if($note->user_id !== auth()->user()->id) {
            abort(403);
        }
        $note->delete();
        return to_route('notes.index')->with('message', 'Note deleted successfully');
    }
}
