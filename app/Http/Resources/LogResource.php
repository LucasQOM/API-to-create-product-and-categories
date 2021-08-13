<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class LogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $created_at = Carbon::parse($this->created_at);
        $updated_at = Carbon::parse($this->updated_at);

        return [
        'id' => $this->id,
        'name' => $this->name,
        'activity' => $this->activity,
        'data' => $this->data,
        'type' => $this->type,
        'model' => $this->model,
        'created_at' => $created_at->format('d-m-Y H:i:s'),
        'updated_at' => $updated_at->format('d-m-Y H:i:s')
        ];
    }
}
