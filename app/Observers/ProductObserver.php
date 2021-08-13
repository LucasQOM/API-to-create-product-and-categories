<?php

namespace App\Observers;
use App\Models\Log;
use App\Models\Products;
use App\Models\User;

class ProductObserver
{

    protected $log;
    protected $products;
    protected $users;

    public function __construct(Log $log, User $users)
    {
        $this->log = $log;
        $this->users = $users;
    }

    public function created(Products $product)
    {
        $log = [
            "user_id" => auth()->user()->id ?? 1,
            "activity" => "Produto cadastrado",
            "data" => json_encode($product),
            "type" => "create",
            "model" => "Product"
        ];

        $this->log->create($log);
    }

    public function deleted(Products $product)
    {
        $log = [
            "user_id" => auth()->user()->id ?? 1,
            "activity" => "Produto deletado",
            "data" => json_encode($product),
            "type" => "delete",
            "model" => "Product"
        ];

        $this->log->create($log);
    }
}
