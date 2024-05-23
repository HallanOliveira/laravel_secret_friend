<?php

namespace App\Adapters\Providers;

use App\Core\Contracts\EmailProvider;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailable;

class EmailLaravel implements EmailProvider
{
    public function __construct(
        protected Mailable $mailable
    ) {
    }

    /**
     * Send email
     *
     * @param string $to
     * @param string $subject
     * @param string|null $content
     * @param string|null $viewName
     * @return void
     */
    public function send(string $to, string $subject, string $content = null, string $viewName = null)
    {
        return Mail::to($to)->send($this->mailable);
    }

    /**
     * Email variables
     *
     * @param object $data
     * @return self
     */
    public function with(object $data): self
    {
        foreach ($data as $field => $value) {
            if (! property_exists($this->mailable, $field)) {
                continue;
            }
            $this->mailable->$field = $value;
        }
        return $this;
    }
}
