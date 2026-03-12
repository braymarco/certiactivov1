<?php

namespace App\Jobs;

use AllowDynamicProperties;
use App\Models\SignatureRequest;
use App\Services\OCRService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

#[AllowDynamicProperties]
class SignatureAIVerifierJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(SignatureRequest $signatureRequest)
    {
        $this->signatureRequestId = $signatureRequest->id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $signatureRequest = SignatureRequest::find($this->signatureRequestId);
        $checkData = OCRService::verifySignatureRequest($signatureRequest);
        if ($checkData) {
            $signatureRequest->histories->create([
                'description' => "Verificación exitosa"
            ]);
        } else {
            $signatureRequest->histories->create([
                'description' => "Ciertos datos no parecen correctos"
            ]);
        }
    }
}
