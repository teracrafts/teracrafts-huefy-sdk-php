<?php

declare(strict_types=1);

namespace Huefy\SDK\Models;

use InvalidArgumentException;

/**
 * Response model for a successful email send operation.
 *
 * This class represents the response received after successfully sending
 * an email through the Huefy API. It contains the message ID for tracking
 * and the email provider that was used.
 *
 * @example
 * ```php
 * use Huefy\SDK\Models\SendEmailResponse;
 * use Huefy\SDK\Models\EmailProvider;
 *
 * $response = new SendEmailResponse(
 *     messageId: 'msg_abc123def456',
 *     provider: EmailProvider::SENDGRID,
 *     status: 'sent'
 * );
 *
 * echo "Email sent with ID: " . $response->getMessageId();
 * ```
 *
 * @author Huefy Team
 * @since 1.0.0
 */
class SendEmailResponse
{
    private bool $success;
    private string $message;
    private string $messageId;
    private EmailProvider $provider;

    /**
     * Create a new email response.
     *
     * @param bool $success Whether the email was sent successfully
     * @param string $message Human-readable status message
     * @param string $messageId Unique message identifier
     * @param EmailProvider $provider The provider that sent the email
     */
    public function __construct(
        bool $success,
        string $message,
        string $messageId,
        EmailProvider $provider
    ) {
        $this->success = $success;
        $this->message = $message;
        $this->messageId = $messageId;
        $this->provider = $provider;
    }

    /**
     * Check if the email was sent successfully.
     *
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->success;
    }

    /**
     * Get the status message.
     *
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * Get the message ID.
     *
     * @return string
     */
    public function getMessageId(): string
    {
        return $this->messageId;
    }

    /**
     * Get the email provider that was used.
     *
     * @return EmailProvider
     */
    public function getProvider(): EmailProvider
    {
        return $this->provider;
    }

    /**
     * Convert the response to an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'success' => $this->success,
            'message' => $this->message,
            'messageId' => $this->messageId,
            'provider' => $this->provider->value,
        ];
    }

    /**
     * Create a response from an array.
     *
     * @param array<string, mixed> $data
     *
     * @return self
     *
     * @throws InvalidArgumentException If required fields are missing or invalid
     */
    public static function fromArray(array $data): self
    {
        if (!isset($data['success']) || !is_bool($data['success'])) {
            throw new InvalidArgumentException('success is required and must be a boolean');
        }

        if (!isset($data['message']) || !is_string($data['message'])) {
            throw new InvalidArgumentException('message is required and must be a string');
        }

        if (!isset($data['messageId']) || !is_string($data['messageId'])) {
            throw new InvalidArgumentException('messageId is required and must be a string');
        }

        if (!isset($data['provider']) || !is_string($data['provider'])) {
            throw new InvalidArgumentException('provider is required and must be a string');
        }

        $provider = EmailProvider::tryFrom($data['provider']);
        if ($provider === null) {
            throw new InvalidArgumentException(sprintf('Invalid provider: %s', $data['provider']));
        }

        return new self(
            success: $data['success'],
            message: $data['message'],
            messageId: $data['messageId'],
            provider: $provider
        );
    }
}
