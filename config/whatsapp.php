<?php

return [
    'enabled'   => env('WHATSAPP_ENABLED', false), // false = modo seco (só loga)
    'base_url'  => env('WHATSAPP_BASE_URL'),       // ex.: https://api.sua-evolution.com
    'api_key'   => env('WHATSAPP_API_KEY'),
    'instance'  => env('WHATSAPP_INSTANCE'),       // instância da Evolution API
];