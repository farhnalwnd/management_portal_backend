<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuResource extends JsonResource
{
    protected ?string $token = null;

    public function setToken(?string $token): self
    {
        $this->token = $token;

        return $this;
    }

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
            // 'display_order' => $this->display_order,
            'is_active'     => $this->is_active,

            'module'        => new ModulResource($this->whenLoaded('modul_mgt')),
            'content'       => $this->whenLoaded('content_mgt', function () {
                return (new ContentResource($this->content_mgt))->setToken($this->token);
            }),
        ];
    }
}
