<?php

namespace App\Controllers\Thoughts;

use App\Controllers\BaseController;

class Thoughts extends BaseController
{
    public function onSubmit()
    {
        try {
            // Get user input
            $input = $this->request->getPost('userInp');
            $input = trim(strip_tags($input));

            $guide = $this->request->getPost('voice');
            $guide = trim(strip_tags($guide));
            
            if (empty($input)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Please provide some input'
                ]);
            }

            // Get API key - UPDATE THIS WITH YOUR NEW API KEY
            $apiKey = getenv('GEMINI_API_KEY') ?: 'YOUR_NEW_API_KEY_HERE';
            
            if (empty($apiKey) || $apiKey === 'YOUR_NEW_API_KEY_HERE') {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'API key not configured'
                ]);
            }

            $voiceDescriptions = [
                'Healer' => 'You should act as the Healer — gentle, nurturing, empathetic. Your tone is soft and compassionate, like a caring friend who soothes emotional wounds.',
                'Warrior' => 'You should act as the Warrior — bold, fearless, and motivating. You speak with courage, strength, and confidence, inspiring resilience.',
                'Dreamer' => 'You should act as the Dreamer — imaginative, hopeful, and poetic. Your tone is dreamy, uplifting, and full of wonder.',
                'Sage' => 'You should act as the Sage — wise, grounded, and reflective. You offer deep insight with calm, timeless wisdom.'
            ];

            $guideTone = $voiceDescriptions[$guide] ?? '';


            // Updated model name and URL
            $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=' . $apiKey;

            $postData = [
                'contents' => [
                    [
                        'parts' => [
                                        [
                                            'text' => $guideTone . "\n\nA user is feeling: " . $input . 
                                                ". Respond with a famous inspirational quote that reflects this emotion with your unique character. " . 
                                                "Then offer 2–3 sentences of personal encouragement that embody your voice.\n\n" . 
                                                "Format the reply exactly like this:\n" . 
                                                "\"Quote text here\" – Author Name<br><br>Personal encouragement message here.\n\n" . 
                                                "Use <br><br> for line breaks. Keep it under 50 words. Let your tone shine clearly through your message."
                                        ]
                                    ]

                    ]
                ]
            ];

            // Make API request
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json'
            ]);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            curl_close($ch);

            // Handle cURL errors
            if ($curlError) {
                log_message('error', "cURL Error: $curlError");
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Network error occurred'
                ]);
            }

            // Handle HTTP errors
            if ($httpCode !== 200) {
                log_message('error', "Gemini API error: HTTP $httpCode | Response: $response");
                
                $errorMessage = 'API request failed';
                if ($httpCode === 400) {
                    $errorMessage = 'Invalid API key or request format';
                } elseif ($httpCode === 404) {
                    $errorMessage = 'Model not found - check model name';
                } elseif ($httpCode === 429) {
                    $errorMessage = 'Rate limit exceeded - please try again later';
                }
                
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => $errorMessage
                ]);
            }

            // Parse response
            $data = json_decode($response, true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                log_message('error', 'JSON decode error: ' . json_last_error_msg());
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Invalid response format'
                ]);
            }

            // Check if response has expected structure
            if (!isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                log_message('error', 'Unexpected API response structure: ' . $response);
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Unexpected response format'
                ]);
            }

            $message = trim($data['candidates'][0]['content']['parts'][0]['text']);

            return $this->response->setJSON([
                'status' => 'success',
                'message' => $message
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Thoughts Controller Error: ' . $e->getMessage());
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'An error occurred while processing your request'
            ]);
        }
    }

// Open browser on your deployed domain
// Then run:
//document.cookie = "my_device_id=dev_girish_123; path=/; max-age=" + 60 * 60 * 24 * 365;


    public function visitCount()
    {
        try {
            $this->db = \Config\Database::connect();
            log_message('debug', 'Connected to DB');

            $builder = $this->db->table('motivationvisitcount');

            $cookieName = 'my_device_id';
            $devIdentifier = 'dev_girish_123';

            $request = \Config\Services::request();
            $cookieValue = $request->getCookie($cookieName);

            if ($cookieValue === $devIdentifier) {
                log_message('debug', "Visit skipped for dev identifier");
                return $this->response->setJSON(['message' => 'Dev visit ignored']);
            }

            // 👇 Always use WHERE to avoid full table update
            $builder->where('id', 1);
            $row = $builder->get()->getRow();
            $currentCount = $row ? $row->site_hits : 0;

            if ($row) {
                $builder->where('id', 1)->set('site_hits', $currentCount + 1)->update();
                log_message('info', "Visit count updated to " . ($currentCount + 1));
            } else {
                $builder->insert(['site_hits' => 1]);
                log_message('info', "Visit count initialized to 1");
            }

            return $this->response->setJSON(['visits' => $currentCount + 1]);

        } catch (\Throwable $e) {
            log_message('error', 'VisitCount Error: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON(['error' => 'Visit count failed']);
        }
    }


}