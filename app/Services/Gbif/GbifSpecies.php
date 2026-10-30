<?php

namespace App\Services\Gbif;

/**
 * A species found on GBIF, normalised: the application never uses GBIF's JSON directly.
 */
final readonly class GbifSpecies
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public int $usageKey,
        public string $canonicalName,
        public string $scientificName,
        public ?string $family,
        public string $rank,
        public string $matchType,
        public int $confidence,
    ) {}

    /**
     * Create the species from the normalised array kept in the cache.
     *
     * @param  array{usage_key: int, canonical_name: string, scientific_name: string, family: string|null, rank: string, match_type: string, confidence: int}  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            usageKey: $data['usage_key'],
            canonicalName: $data['canonical_name'],
            scientificName: $data['scientific_name'],
            family: $data['family'],
            rank: $data['rank'],
            matchType: $data['match_type'],
            confidence: $data['confidence'],
        );
    }

    /**
     * Whether the match is uncertain and the administrator should check it carefully.
     */
    public function isUncertain(): bool
    {
        return $this->matchType !== 'EXACT' || $this->confidence < 90;
    }

    /**
     * The species' page on the GBIF website.
     */
    public function url(): string
    {
        return self::urlFor($this->usageKey);
    }

    /**
     * The page on the GBIF website of the species with the given key.
     */
    public static function urlFor(int $usageKey): string
    {
        return 'https://www.gbif.org/species/'.$usageKey;
    }
}
