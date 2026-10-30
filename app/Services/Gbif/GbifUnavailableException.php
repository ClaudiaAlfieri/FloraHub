<?php

namespace App\Services\Gbif;

use RuntimeException;

/**
 * GBIF could not be reached or answered with an error. It is not the same as "species not found".
 */
class GbifUnavailableException extends RuntimeException {}
