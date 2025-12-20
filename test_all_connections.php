<?php

echo "Testing Supabase Connection Pooler...\n\n";

$configs = [
    [
        'name' => 'Pooler with postgres.PROJECT_REF',
        'host' => 'aws-0-ap-southeast-1.pooler.supabase.com',
        'port' => '6543',
        'db'   => 'postgres',
        'user' => 'postgres.abzszbtlhcxmgnysgclo',
        'pass' => 'NnundpS2IdmbaGPk'
    ],
    [
        'name' => 'Pooler with postgres only',
        'host' => 'aws-0-ap-southeast-1.pooler.supabase.com',
        'port' => '6543',
        'db'   => 'postgres',
        'user' => 'postgres',
        'pass' => 'NnundpS2IdmbaGPk'
    ],
    [
        'name' => 'Direct without db prefix',
        'host' => 'abzszbtlhcxmgnysgclo.supabase.co',
        'port' => '5432',
        'db'   => 'postgres',
        'user' => 'postgres',
        'pass' => 'NnundpS2IdmbaGPk'
    ],
    [
        'name' => 'Direct without db prefix - port 6543',
        'host' => 'abzszbtlhcxmgnysgclo.supabase.co',
        'port' => '6543',
        'db'   => 'postgres',
        'user' => 'postgres',
        'pass' => 'NnundpS2IdmbaGPk'
    ]
];

foreach ($configs as $config) {
    echo "========================================\n";
    echo "Testing: " . $config['name'] . "\n";
    echo "Host: {$config['host']}:{$config['port']}\n";
    echo "User: {$config['user']}\n";
    echo "========================================\n";
    
    try {
        $dsn = "pgsql:host={$config['host']};port={$config['port']};dbname={$config['db']}";
        $pdo = new PDO($dsn, $config['user'], $config['pass'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_TIMEOUT => 10
        ]);
        
        echo "✅ CONNECTION SUCCESSFUL!\n";
        
        // Test query
        $stmt = $pdo->query('SELECT version()');
        $version = $stmt->fetchColumn();
        echo "PostgreSQL Version: $version\n\n";
        
        echo "THIS CONFIG WORKS! Update your .env with:\n";
        echo "DB_HOST={$config['host']}\n";
        echo "DB_PORT={$config['port']}\n";
        echo "DB_USERNAME={$config['user']}\n\n";
        
        break; // Stop if successful
        
    } catch (PDOException $e) {
        echo "❌ FAILED: " . $e->getMessage() . "\n\n";
    }
}
