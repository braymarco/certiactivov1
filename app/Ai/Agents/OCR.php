<?php

namespace App\Ai\Agents;

use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\Conversational;
use Laravel\Ai\Contracts\HasTools;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Messages\Message;
use Laravel\Ai\Messages\MessageRole;
use Laravel\Ai\Promptable;
use Laravel\Ai\Providers\Provider;
use Stringable;


use Laravel\Ai\Attributes\MaxSteps;
use Laravel\Ai\Attributes\MaxTokens;
use Laravel\Ai\Attributes\Model;
use Laravel\Ai\Attributes\Temperature;
use Laravel\Ai\Attributes\Timeout;
use Laravel\Ai\Enums\Lab;

#[Provider(Lab::OpenAI )]
#[Model('qwen-vl-ocr')]
#[MaxTokens(2048)]
#[Timeout(120)]
class OCR implements Agent, Conversational, HasTools
{
    use Promptable;


    public function __construct( )
    {

    }


    /**
     * Get the instructions that the agent should follow.
     */
    public function instructions(): Stringable|string
    {
        return '';
    }

    /**
     * Get the list of messages comprising the conversation so far.
     *
     * @return Message[]
     */
    public function messages(): iterable
    {

        return [];
    }

    /**
     * Get the tools available to the agent.
     *
     * @return Tool[]
     */
    public function tools(): iterable
    {
        return [];
    }
}
