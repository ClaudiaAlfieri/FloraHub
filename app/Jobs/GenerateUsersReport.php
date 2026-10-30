<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\UsersReportReady;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Throwable;

class GenerateUsersReport implements ShouldQueue
{
    use Queueable;

    /**
     * The number of times the job may be attempted.
     */
    public int $tries = 2;

    /**
     * Create a new job instance, sent through the default queue.
     */
    public function __construct(
        public User $requestedBy,
    ) {
        $this->onQueue('default');
    }

    /**
     * Generate the PDF, store it on the private disk and notify the administrator who asked for it.
     */
    public function handle(): void
    {
        $users = User::with('roles')->orderBy('name')->get();

        $pdf = Pdf::loadView('pdf.users', ['users' => $users])->output();

        $path = 'reports/users-'.now()->format('Y-m-d-His').'.pdf';

        Storage::disk('local')->put($path, $pdf);

        Log::info('Users report generated', ['path' => $path]);

        $this->requestedBy->notify(new UsersReportReady($path));
    }

    /**
     * Handle a job that failed after all its attempts.
     */
    public function failed(Throwable $exception): void
    {
        Log::error('Users report failed', ['exception' => $exception::class]);
    }
}
