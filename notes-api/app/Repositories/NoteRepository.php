<?php
namespace App\Repositories;

use App\Models\Note;
use App\Repositories\Interfaces\NoteRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class NoteRepository implements NoteRepositoryInterface
{
    public function getAll()
    {
        return Note::latest()->get();
    }

    public function create(array $data)
    {
        return Note::query()->create($data);
    }
}
