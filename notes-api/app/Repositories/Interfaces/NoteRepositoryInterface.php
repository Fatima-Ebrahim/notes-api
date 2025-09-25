<?php
namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface NoteRepositoryInterface
{
    public function getAll();
    public function create(array $data);
}
