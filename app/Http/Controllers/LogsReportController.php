<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Log;
use App\Http\Resources\LogResource;

class LogsReportController extends UserController
{
    protected $log;
    protected $request;

    public function __construct(Log $log,Request $request)
    {
        $this->log = $log;
        $this->request = $request;
    }

    public function index()
    {
        $data = $this->request->all();

        $logs = $this
        ->log
            ->selectRaw("
                logs.id,
                users.name,
                logs.activity,
                logs.data,
                logs.type,
                logs.model,
                CASE
                    WHEN logs.type = 'create' THEN 'Criado'
                    WHEN logs.type = 'update' THEN 'Atualizado'
                    WHEN logs.type = 'delete' THEN 'Deletado'
                    ELSE 'Nao Registrado'
                END AS type_log,
                DATE_FORMAT(logs.created_at, '%d/%m/%Y-%T') as created_date
                ")
            ->leftJoin("users", "users.id", "=", "logs.user_id");

            $logs->orderBy("logs.created_at", "DESC");
            $logs = $logs->get();

            return response()->json(['status' => 200, 'data' => LogResource::collection($logs), 'message' => 'Registros listados com sucesso.']);
    }
}
