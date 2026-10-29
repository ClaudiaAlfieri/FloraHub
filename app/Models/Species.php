<?php

namespace App\Models;

use App\Enums\Difficulty;
use App\Enums\Light;
use App\Enums\Watering;
use Database\Factories\SpeciesFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

/**
 * @property int $id
 * @property int $family_id
 * @property string $scientific_name
 * @property string $common_name
 * @property string $slug
 * @property string|null $description
 * @property Light $light
 * @property Watering $watering
 * @property Difficulty $difficulty
 * @property bool $toxic_to_pets
 * @property string|null $care_notes
 * @property string|null $image
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read string|null $image_url
 * @property-read Family $family
 */
#[Fillable([
    'family_id', 'scientific_name', 'common_name', 'slug', 'description',
    'light', 'watering', 'difficulty', 'toxic_to_pets', 'care_notes', 'image',
])]
class Species extends Model
{
    /** @use HasFactory<SpeciesFactory> */
    use HasFactory, SoftDeletes;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'light' => Light::class,
            'watering' => Watering::class,
            'difficulty' => Difficulty::class,
            'toxic_to_pets' => 'boolean',
        ];
    }

    /**
     * The family the species belongs to, even when the family is soft deleted.
     *
     * @return BelongsTo<Family, $this>
     */
    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class)->withTrashed();
    }

    /**
     * The public URL of the species' image, or null when it has no image.
     *
     * @return Attribute<string|null, never>
     */
    protected function imageUrl(): Attribute
    {
        return Attribute::get(
            fn (): ?string => $this->image ? Storage::disk('public')->url($this->image) : null,
        );
    }
}
