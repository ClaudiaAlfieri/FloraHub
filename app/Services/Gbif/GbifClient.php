<?php

namespace App\Services\Gbif;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Looks up plant species on GBIF (Global Biodiversity Information Facility), a public API without a key.
 */
class GbifClient
{
    /**
     * Create a new class instance. The values come from config/services.php (see AppServiceProvider).
     */
    public function __construct(
        protected string $baseUrl,
        protected int $timeout,
        protected int $cacheTtl,
    ) {}

    /**
     * Find the plant species that best matches the scientific name, or null when GBIF does not know it.
     *
     * The answer, including "not found", is cached. A failure is not cached, so the next lookup tries again.
     *
     * @throws GbifUnavailableException
     */
    public function match(string $scientificName): ?GbifSpecies
    {
        $name = trim($scientificName);

        // The cache only keeps arrays (objects are not unserialised) and never keeps null: false means "not found".
        $data = Cache::remember('gbif:match:'.Str::slug($name), $this->cacheTtl, fn () => $this->requestMatch($name) ?? false);

        return $data === false ? null : GbifSpecies::fromArray($data);
    }

    /**
     * Ask GBIF for the species and normalise the answer.
     *
     * @return array{usage_key: int, canonical_name: string, scientific_name: string, family: string|null, rank: string, match_type: string, confidence: int}|null
     *
     * @throws GbifUnavailableException
     */
    protected function requestMatch(string $name): ?array
    {
        try {
            $response = Http::baseUrl($this->baseUrl)
                ->acceptJson()
                ->timeout($this->timeout)
                ->retry(2, 200)
                ->get('species/match', ['name' => $name, 'kingdom' => 'Plantae']);
        } catch (ConnectionException|RequestException $exception) {
            Log::warning('GBIF request failed', [
                'status' => $exception instanceof RequestException ? $exception->response->status() : null,
                'exception' => $exception::class,
            ]);

            throw new GbifUnavailableException('GBIF is unavailable.', previous: $exception);
        }

        // An unknown name does not return NONE: GBIF answers HIGHERRANK with the kingdom (Plantae).
        $matchType = $response->json('matchType', 'NONE');

        if (in_array($matchType, ['NONE', 'HIGHERRANK'], true) || $response->json('usageKey') === null) {
            return null;
        }

        return [
            'usage_key' => (int) $response->json('usageKey'),
            'canonical_name' => (string) $response->json('canonicalName'),
            'scientific_name' => (string) $response->json('scientificName'),
            'family' => $response->json('family'),
            'rank' => (string) $response->json('rank'),
            'match_type' => (string) $matchType,
            'confidence' => (int) $response->json('confidence', 0),
        ];
    }
}
