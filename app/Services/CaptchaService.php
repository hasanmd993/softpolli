<?php

namespace App\Services;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;

class CaptchaService
{
    /**
     * Generate a new mathematical security challenge.
     */
    public static function generate(): array
    {
        $operations = ['+', '-', 'x'];
        $op = $operations[array_rand($operations)];

        if ($op === '+') {
            $num1 = rand(3, 12);
            $num2 = rand(2, 9);
            $answer = $num1 + $num2;
            $question = "{$num1} + {$num2}";
        } elseif ($op === '-') {
            $num1 = rand(10, 20);
            $num2 = rand(2, 9);
            $answer = $num1 - $num2;
            $question = "{$num1} − {$num2}";
        } else {
            $num1 = rand(2, 6);
            $num2 = rand(2, 5);
            $answer = $num1 * $num2;
            $question = "{$num1} × {$num2}";
        }

        // Store encrypted answer in session
        Session::put('login_captcha_answer', (string) $answer);

        // Also generate an encrypted timestamped token as an extra tamper-proof layer
        $payload = Crypt::encryptString(json_encode([
            'answer' => (string) $answer,
            'time' => time(),
        ]));

        return [
            'question' => $question,
            'token' => $payload,
        ];
    }

    /**
     * Validate the provided captcha answer.
     */
    public static function validate(?string $userAnswer, ?string $token = null): bool
    {
        if ($userAnswer === null || trim($userAnswer) === '') {
            return false;
        }

        $sessionAnswer = Session::get('login_captcha_answer');

        if ($sessionAnswer !== null && trim((string) $userAnswer) === (string) $sessionAnswer) {
            // Once validated, clear session answer to prevent replay
            Session::forget('login_captcha_answer');
            return true;
        }

        // Fallback to decrypting token if session expired or lost
        if ($token) {
            try {
                $decrypted = json_decode(Crypt::decryptString($token), true);
                if (isset($decrypted['answer'], $decrypted['time'])) {
                    // Check token expiration (max 10 minutes)
                    if (time() - $decrypted['time'] <= 600) {
                        return trim((string) $userAnswer) === (string) $decrypted['answer'];
                    }
                }
            } catch (\Throwable) {
                return false;
            }
        }

        return false;
    }
}

