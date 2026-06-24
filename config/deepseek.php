<?php

return [
    'api_key' => env('DEEPSEEK_API_KEY'),
    'api_url' => env('DEEPSEEK_API_URL', 'https://api.deepseek.com/chat/completions'),
    'model' => env('DEEPSEEK_MODEL', 'deepseek-chat'),
    'timeout' => env('DEEPSEEK_TIMEOUT', 30),
];
