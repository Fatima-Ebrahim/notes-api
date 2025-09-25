<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNoteRequest;
use App\Services\Interfaces\NoteServiceInterface;

class NoteController extends Controller
{
    protected $noteService;

    public function __construct(NoteServiceInterface $noteService)
    {
        $this->noteService = $noteService;
    }


    public function index()
    {
        $notes = $this->noteService->getNotes();
        return response()->json($notes);
    }

    public function store(StoreNoteRequest $request)
    {
        $note = $this->noteService->createNote($request->validated());

        return response()->json($note, 201);
    }
}
