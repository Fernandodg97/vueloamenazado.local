<?php
echo json_encode([
    'status' => 'ok',
    'port' => getenv('PORT'),
    'php' => PHP_VERSION,
    'db_host' => getenv('DB_HOST') ? 'set' : 'missing',
]);
