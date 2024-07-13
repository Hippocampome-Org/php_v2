<?php
require_once('/Applications/XAMPP/vendor/autoload.php');
require './chatgpt_search.php';

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
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Results</title>
</head>
<body>
    <h1>Search Results</h1>
    <?php if (!empty($response)): ?>
        <p><?php echo nl2br(htmlspecialchars($response)); ?></p>
    <?php else: ?>
        <p>No response from ChatGPT.</p>
    <?php endif; ?>
    <a href="index.php">Back to Search</a>
</body>
</html>
