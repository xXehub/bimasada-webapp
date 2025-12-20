<?php

echo "=== Supabase Connection Troubleshooting ===\n\n";

$project_ref = 'abzszbtlhcxmgnysgclo';
$password = 'NnundpS2IdmbaGPk';
$region = 'ap-southeast-1';

$configs = [
    'Session Pooler (Transaction Mode) - Port 6543' => [
        'host' => "aws-0-$region.pooler.supabase.com",
        'port' => '6543',
        'username' => "postgres.$project_ref",
        'mode' => 'Transaction Mode'
    ],
    'Session Pooler (Session Mode) - Port 5432' => [
        'host' => "aws-0-$region.pooler.supabase.com",
        'port' => '5432',
        'username' => "postgres.$project_ref",
        'mode' => 'Session Mode'
    ],
    'Direct Connection - db prefix' => [
        'host' => "db.$project_ref.supabase.co",
        'port' => '5432',
        'username' => 'postgres',
        'mode' => 'Direct'
    ],
    'Direct Connection - no db prefix' => [
        'host' => "$project_ref.supabase.co",
        'port' => '5432',
        'username' => 'postgres',
        'mode' => 'Direct'
    ],
];

foreach ($configs as $name => $config) {
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "Testing: $name\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "Host: {$config['host']}\n";
    echo "Port: {$config['port']}\n";
    echo "Username: {$config['username']}\n";
    echo "Mode: {$config['mode']}\n\n";
    
    try {
        $dsn = "pgsql:host={$config['host']};port={$config['port']};dbname=postgres;sslmode=require";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_TIMEOUT => 10,
        ];
        
        $pdo = new PDO($dsn, $config['username'], $password, $options);
        
        echo "✅ ✅ ✅ CONNECTION SUCCESSFUL! ✅ ✅ ✅\n\n";
        
        // Test query
        $stmt = $pdo->query('SELECT version()');
        $version = $stmt->fetchColumn();
        echo "PostgreSQL Version:\n$version\n\n";
        
        // Show tables
        $stmt = $pdo->query("SELECT schemaname, tablename FROM pg_tables WHERE schemaname NOT IN ('pg_catalog', 'information_schema') LIMIT 10");
        $tables = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "Sample Tables:\n";
        foreach ($tables as $table) {
            echo "  - {$table['schemaname']}.{$table['tablename']}\n";
        }
        
        echo "\n";
        echo "🎉 USE THIS CONFIGURATION IN .ENV:\n";
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        echo "DB_CONNECTION=pgsql\n";
        echo "DB_HOST={$config['host']}\n";
        echo "DB_PORT={$config['port']}\n";
        echo "DB_DATABASE=postgres\n";
        echo "DB_USERNAME={$config['username']}\n";
        echo "DB_PASSWORD=$password\n";
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
        
        exit(0); // Stop on first success
        
    } catch (PDOException $e) {
        echo "❌ FAILED\n";
        echo "Error: {$e->getMessage()}\n\n";
    }
}

echo "\n";
echo "⚠️  ALL CONNECTION ATTEMPTS FAILED\n\n";
echo "Possible solutions:\n";
echo "1. Check if your Supabase project is fully provisioned and running\n";
echo "2. Verify your database password in Supabase Dashboard\n";
echo "3. Reset password: https://supabase.com/dashboard/project/$project_ref/settings/database\n";
echo "4. Check if you have IPv4 Add-on enabled (required for direct connections)\n";
echo "5. Make sure you're using the correct connection string from Dashboard\n";
