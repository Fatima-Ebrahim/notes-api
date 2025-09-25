<?php

namespace App\Services;

use App\Repositories\Interfaces\NoteRepositoryInterface;
use App\Services\Interfaces\NoteServiceInterface;

class NoteService implements NoteServiceInterface
{
    protected $noteRepository;

    public function __construct(NoteRepositoryInterface $noteRepository)
    {
        $this->noteRepository = $noteRepository;
    }

    public function getNotes()
    {
        return $this->noteRepository->getAll();
    }

    public function createNote(array $data)
    {
        return $this->noteRepository->create($data);
    }
}
