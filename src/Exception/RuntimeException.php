<?php

declare(strict_types=1);

namespace OAuth2\Exception;

class RuntimeException extends \RuntimeException implements ExceptionInterface
{
    /**
     * @var array
     */
    protected $messages;

    /**
     * @return array
     */
    public function getMessages()
    {
        if ($this->messages === null) {
            $this->messages = [$this->getMessage()];
        }

        return $this->messages;
    }

    public function withMessages(array $messages)
    {
        $this->messages = $messages;

        return $this;
    }
}
