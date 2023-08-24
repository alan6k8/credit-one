<?php

declare(strict_types=1);

use Alan6k8\CreditOne\Repository\ModuleFunctionRepository;
use Alan6k8\CreditOne\Repository\ModuleFunctionAccessRightRepository;
use Alan6k8\CreditOne\Repository\UserRepository;
use Alan6k8\CreditOne\Service\User\ModuleFunctionAccessResolver;

require __DIR__ . '/../vendor/autoload.php';

/*
 * As there is no template engine, I'll simply echo in this file.
 * Also, there is no DI package nor I am going to implement factories to keep it simple.
 */

echo<<<EOT
<html>
    <head>
        <style>
            .success { color: green; }
            .danger { color: red; }
        </style>
    </head>
    <body>
EOT;


// process POST request on form submission
if (isset($_POST['process'])) {
    // just a simple input validation as there is select in the GUI it might not be needed, but as an example
    $username = (string)($_POST['username'] ?? '');
    if ($username === '') {
        throw new InvalidArgumentException('Missing mandatory param: username');
    }
    $moduleFunctionName = (string)($_POST['function'] ?? '');
    if ($moduleFunctionName === '') {
        throw new InvalidArgumentException('Missing mandatory param: function');
    }

    $accessResolver = new ModuleFunctionAccessResolver(
        new UserRepository(),
        new ModuleFunctionRepository(),
        new ModuleFunctionAccessRightRepository(),
    );

    try {
        $isAuthorized = $accessResolver->resolve($username, $moduleFunctionName);
        if ($isAuthorized) {
            echo "<div class =\"success\">User {$username} has access to {$moduleFunctionName}</div><br>";
        } else {
            echo "<div class=\"danger\">User {$username} does not have access to {$moduleFunctionName}</div><br>";
        }
    } catch (Throwable $e) {
        echo '<div class="danger">';
        echo "Failed to tell whether user {$username} has access to {$moduleFunctionName}<br>";
        echo 'Reason: ' . $e->getMessage();
        echo '</div><br>';
    }
}

// form (used simple indentation just to make it easier to read)
$userRepo = new UserRepository();
$moduleFunctionsRepo = new ModuleFunctionRepository();

echo '
    <form method="post" action="">
        <label for="username">Username:</label>
        <select name="username" id="username">';
    foreach ($userRepo->findAll() as $user) {
        $selected = isset($username) && $username === $user->username ? 'selected="selected" ' : '';
        echo "<option {$selected}value=\"{$user->username}\">{$user->username}</option>";
    }
echo '
        </select>
        <label for="function">Function:</label>
        <select name="function" id="function">';
    foreach ($moduleFunctionsRepo->findAll() as $moduleFunction) {
        $selected = isset($username) && $moduleFunctionName === $moduleFunction->name ? 'selected="selected" ' : '';
        echo "<option {$selected}value=\"{$moduleFunction->name}\">{$moduleFunction->name}</option>";
    }
echo '
        </select>
        <input type="submit" name="process" value="Check Access">
    </form>
</body>
</html>';