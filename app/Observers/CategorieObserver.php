<?php

namespace App\Observers;
use App\Models\Log;
use App\Models\Categories;
use App\Models\User;

class CategorieObserver
{
    protected $log;
    protected $categories;
    protected $users;

    public function __construct(Log $log, User $users)
    {
        $this->log = $log;
        $this->users = $users;
    }

    public function created(Categories $categorie)
    {
        $log = [
            "user_id" => auth()->user()->id ?? 1,
            "activity" => "Categoria cadastrada",
            "data" => json_encode($categorie),
            "type" => "create",
            "model" => "Categorie"
        ];

        $this->log->create($log);
    }

    public function deleted(Categories $categorie)
    {
        $log = [
            "user_id" => auth()->user()->id ?? 1,
            "activity" => "Categoria deletada",
            "data" => json_encode($categorie),
            "type" => "delete",
            "model" => "Categorie"
        ];

        $this->log->create($log);
    }
}
