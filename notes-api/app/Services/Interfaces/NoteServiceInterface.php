<?php
namespace App\Services\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface NoteServiceInterface
{
    public function getNotes();
    public function createNote(array $data);
}
