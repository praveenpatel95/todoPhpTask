<?php

namespace Core;

class AuthMiddleware
{
    private function getAuthToken(): ?string
    {
        $headers = getallheaders();
        if (isset($headers['Authorization'])) {
            $authHeader = $headers['Authorization'];
            if (strpos($authHeader, 'Bearer ') === 0) {
                return substr($authHeader, 7);
            }
        }
        return null;
    }

    private function validateToken(string $token): ?int
    {
        $tokenFile = "tokens/{$token}.txt";
        if (file_exists($tokenFile)) {
            return (int) file_get_contents($tokenFile);
        }
        return null;
    }

    public function handle(): bool
    {
        $token = $this->getAuthToken();

        if (!$token) {
            http_response_code(401);
            echo json_encode(['message' => 'No authentication token provided']);
            return false;
        }

        $userId = $this->validateToken($token);

        if (!$userId) {
            http_response_code(401);
            echo json_encode(['message' => 'Invalid or expired token']);
            return false;
        }

        // Store the user ID in a global variable or request context
        $_REQUEST['user_id'] = $userId;
        return true;
    }
}