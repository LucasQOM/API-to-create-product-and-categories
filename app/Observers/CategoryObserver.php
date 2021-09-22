<?php

namespace App\Observers;
use App\Models\Log;
use App\Models\Category;
use App\Models\User;

class CategoryObserver
{
    protected $log;
    protected $categories;
    protected $users;

    public function __construct(Log $log, User $users)
    {
        $this->log = $log;
        $this->users = $users;
    }

    public function created(Category $category)
    {
        $log = [
            "user_id" => auth()->user()->id ?? 1,
            "activity" => "Categoria cadastrada",
            "data" => json_encode($category),
            "type" => "create",
            "model" => "Category"
        ];

        $this->log->create($log);
    }

    public function deleted(Category $category)
    {
        $log = [
            "user_id" => auth()->user()->id ?? 1,
            "activity" => "Categoria deletada",
            "data" => json_encode($category),
            "type" => "delete",
            "model" => "Category"
        ];

        $this->log->create($log);
    }
}
