<?php

namespace App\Http\Resources\Api\Projects;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResourceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->uuid,
            'type_name' => $this->type_name,
            'name' => $this->name,
            'method' => $this->method,
            'endpoint' => $this->endpoint,
            'uptime' => $this->uptime,
            'settings' => $this->settings,
            'checked_at' => $this->checked_at,
        ];
    }
}
