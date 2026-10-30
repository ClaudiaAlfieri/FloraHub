<?php

namespace App\Http\Resources;

use App\Models\Species;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Route;

/**
 * @mixin Species
 */
class SpeciesResource extends JsonResource
{
    /**
     * Transform the species into the API's JSON. Internal fields (id, family_id, image path, deleted_at) are not exposed.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'slug' => $this->slug,
            'scientific_name' => $this->scientific_name,
            'common_name' => $this->common_name,
            'description' => $this->description,
            'care_notes' => $this->care_notes,
            'light' => ['value' => $this->light->value, 'label' => $this->light->label()],
            'watering' => ['value' => $this->watering->value, 'label' => $this->watering->label()],
            'difficulty' => ['value' => $this->difficulty->value, 'label' => $this->difficulty->label()],
            'toxic_to_pets' => $this->toxic_to_pets,
            'image_url' => $this->image_url,
            'gbif_key' => $this->gbif_key,
            'gbif_url' => $this->gbif_url,
            'family' => new FamilyResource($this->whenLoaded('family')),
            // The public page of the species, when the public catalogue exists.
            'url' => Route::has('species.show') ? route('species.show', $this->slug) : null,
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
