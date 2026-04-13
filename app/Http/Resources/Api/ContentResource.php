<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContentResource extends JsonResource
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
            'type' => $this->type,
            'title' => $this->title,
            'version' => $this->version,
            'repo' => $this->repo . "/sso/verify?ticket=" . $this->token
        ];
    }
}
