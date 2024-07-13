<?php
require_once('/Applications/XAMPP/vendor/autoload.php');

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

class ChatGPTSearch {
    private $client;
    private $apiKey;

    public function __construct() {
        $this->client = new Client();
        $this->apiKey = $_ENV['OPENAI_API_KEY'];
    }

    public function askChatGPT($prompt) {
        try {
            $response = $this->client->post('https://api.openai.com/v1/chat/completions', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'model' => 'gpt-3.5-turbo',
                    'messages' => [
                        ['role' => 'system', 'content' => 'You are a helpful assistant.'],
                        ['role' => 'user', 'content' => $prompt],
                    ],
                ],
            ]);

            $body = $response->getBody();
            $data = json_decode($body, true);

            return $data['choices'][0]['message']['content'] ?? 'No response from AI.';
        } catch (RequestException $e) {
            return 'Request failed: ' . $e->getMessage();
        }
    }

    public function searchDatabase($query, $value) {
        $dsn = 'mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_DATABASE'] . ';charset=utf8mb4';
        $username = $_ENV['DB_USERNAME'];
        $password = $_ENV['DB_PASSWORD'];

        try {
            $pdo = new PDO($dsn, $username, $password);
            $stmt = $pdo->prepare($query);
            $stmt->execute([$value]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return 'Connection failed: ' . $e->getMessage();
        }
    }
}

// Handle the request and provide response
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userInput = $_POST['search'];

    $search = new ChatGPTSearch();
    $query = "SELECT * FROM counts WHERE neuron_type = ?";
    $results = $search->searchDatabase($query, $userInput);

    if (is_string($results)) {
        $response = $results; // Error message
    } else {
        if ($results) {
            $formattedResults = json_encode($results);
            $prompt = "Here are the search results: $formattedResults. Please provide an analysis or insights based on this data.";
        } else {
            $prompt = "No results found for the query: '$userInput'. Please suggest an alternative query or approach to find relevant data.";
        }

        $response = $search->askChatGPT($prompt);
    }

    echo $response;
}
?>
