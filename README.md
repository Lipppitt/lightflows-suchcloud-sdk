# SuchCloud SDK

This is a PHP SDK prototype for the fictional headless content service called Such Cloud. The SDK is designed to manage documents stored in an SQLite database, partitioned by API keys for different users.

## Features

- Authenticate with an API key.
- Create, retrieve, update, and delete documents.
- Partition data by API key to ensure data isolation between different users.

## Requirements

- PHP 8.2 or higher
- Composer (for managing dependencies)
- SQLite (used as the database in this prototype)

## Installation

### Using Composer

1. **Clone the repository:**

    ```bash
    git clone https://github.com/Lipppitt/lightflows-suchcloud-sdk.git
    cd suchcloud-sdk
    ```

2. **Install dependencies:**

   Make sure you have Composer installed on your machine. Then run:

    ```bash
    composer install
    ```

3. **Set up your environment:**

   This SDK uses an in-memory SQLite database by default. If you want to persist the data, you can specify a file path to the SQLite database when initializing the SDK.

## Usage

### Basic Setup

To start using the SDK, you can initialize it as follows:

```php
require 'vendor/autoload.php';

use Shaun\LightflowsSuchcloudSdk\SuchCloudSdk;

// Initialize the SDK
$sdk = new SuchCloudSdk();

// Authenticate with an API key
$sdk->documents->authenticate('your-api-key');

// Create a document
$documentUuid = $sdk->documents->createDoc([
    'title' => 'Sample Document',
    'slug' => 'sample-document',
    'contents' => ['field1' => 'value1', 'field2' => 'value2']
]);

echo "Document created with uuid: $documentUuid\n";

// Retrieve a document
$document = $sdk->documents->getDoc($documentUuid);
print_r($document);

// Update a document
$sdk->documents->updateDoc($documentId, [
    'title' => 'Updated Title',
    'slug' => 'updated-slug',
    'contents' => ['field1' => 'new value']
]);

// Delete a document
$sdk->documents->deleteDoc($documentId);
echo "Document deleted.\n";
