<?php

function authenticate(): int
{
    $headers = getallheaders();
    if (!isset($headers['Authorization'])) {
        throw new Exception('Unauthorized', 401);
    }

    $token = str_replace('Bearer ', '', $headers['Authorization']);
    $tokenFile = "tokens/{$token}.txt";

    if (!file_exists($tokenFile)) {
        throw new Exception('Invalid token', 401);
    }

    return (int) file_get_contents($tokenFile); // Return user ID
}
