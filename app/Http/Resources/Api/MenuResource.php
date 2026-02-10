<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'menu_name'     => $this->menu_name,
            'display_order' => $this->display_order,
            'is_active'     => $this->is_active,

            'module'        => new ModulResource($this->whenLoaded('modul_mgt')),
            'content'       => new ContentResource($this->whenLoaded('content_mgt')),
        ];
    }
}
