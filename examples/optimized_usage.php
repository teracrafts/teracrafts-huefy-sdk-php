<?php

declare(strict_types=1);

/**
 * Example: Using Huefy PHP SDK with Enhanced Architecture
 * 
 * This example demonstrates how the PHP SDK automatically uses Huefy's
 * optimized architecture for enhanced security and performance.
 */

require_once __DIR__ . '/../vendor/autoload.php';

use Huefy\SDK\HuefyClient;
use Huefy\SDK\Config\HuefyConfig;
use Huefy\SDK\Models\EmailProvider;

// The SDK automatically uses Huefy's optimized architecture
// No additional configuration needed for standard usage

try {
    // Create client - automatically uses secure optimized routing
    $client = new HuefyClient('your-api-key');
    
    // Or with custom configuration
    $config = new HuefyConfig(
        timeout: 30.0,
        connectTimeout: 10.0
    );
    $configuredClient = new HuefyClient('your-api-key', $config);
    
    // The PHP SDK automatically handles secure API communication
    // through the optimized proxy architecture
    $response = $client->sendEmail(
        templateKey: 'welcome-email',
        recipient: 'john@example.com',
        data: [
            'name' => 'John Doe',
            'company' => 'Acme Corp',
            'activationLink' => 'https://app.example.com/activate/12345'
        ],
        provider: EmailProvider::SES
    );
    
    echo "Email sent successfully!\n";
    echo "Message ID: " . $response->getMessageId() . "\n";
    echo "Provider used: " . $response->getProvider()->value . "\n";
    
    // Check API health through optimized routing
    $health = $client->healthCheck();
    echo "API Health: " . $health->getStatus() . "\n";
    
    // Send bulk emails efficiently
    $bulkRequests = [
        [
            'templateKey' => 'welcome-email',
            'recipient' => 'user1@example.com',
            'data' => ['name' => 'User 1']
        ],
        [
            'templateKey' => 'welcome-email',
            'recipient' => 'user2@example.com',
            'data' => ['name' => 'User 2'],
            'provider' => EmailProvider::SENDGRID
        ]
    ];
    
    $bulkResponse = $client->sendBulkEmails($bulkRequests);
    echo "Bulk emails sent: " . count($bulkResponse->getResults()) . " emails\n";
    
} catch (Exception $error) {
    echo "Failed to send email: " . $error->getMessage() . "\n";
    if ($error instanceof \Huefy\SDK\Exceptions\HuefyException) {
        echo "Error code: " . $error->getCode() . "\n";
    }
}

/*
 * Benefits of Huefy's optimized architecture:
 * 1. Security: Enterprise-grade encryption and secure routing
 * 2. Performance: Intelligent routing and caching optimizations  
 * 3. Reliability: Built-in failover and redundancy systems
 * 4. Consistency: Uniform behavior across all SDK languages
 * 5. Scalability: Automatic load balancing and resource optimization
 */