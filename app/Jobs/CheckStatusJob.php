<?php

namespace App\Jobs;

use App\Exceptions\NotFoundException;
use App\Facades\SignatureRequestFacade;
use App\Facades\UanatacaFacade;
use App\Helpers\Uanataca\Enum\EstadoSolicitud;
use App\Helpers\Uanataca\Exceptions\ClientException;
use App\Helpers\Uanataca\Exceptions\ForbiddenException;
use App\Helpers\Uanataca\Exceptions\MethodNotAllowedException;
use App\Helpers\Uanataca\Exceptions\ServerException;
use App\Helpers\Uanataca\Exceptions\UnauthorizedException;
use App\Models\UanatacaRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckStatusJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        SignatureRequestFacade::checkAllStatus();
    }
}
