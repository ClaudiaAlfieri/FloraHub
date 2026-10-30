<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin User
 */
class UserResource extends JsonResource
{
    /**
     * Transform the authenticated user into the API's JSON. Only what the user needs: no id, email, password or 2FA data.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'premium' => false,
            'member_since' => $this->created_at?->toIso8601String(),
        ];
    }
}
