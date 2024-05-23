<?php

namespace App\Core\Contracts;

interface EmailProvider
{

    /**
     * Email variables
     *
     * @param object $data
     * @return self
     */
    public function with(object $data): self;

    /**
     * Send email
     *
     * @param string $to
     * @param string $subject
     * @param string|null $content
     * @param string|null $viewName
     * @return void
     */
    public function send(string $to, string $subject, ?string $content = null);

}
