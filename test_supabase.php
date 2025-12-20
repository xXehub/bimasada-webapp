<?php

echo "Testing Supabase PostgreSQL Connection...\n\n";

$host = '104.18.38.10'; // Using IPv4 instead of hostname
$port = '5432';
$db   = 'postgres';
$user = 'postgres';
$pass = 'NnundpS2IdmbaGPk';

echo "Connection details:\n";
echo "Host: $host\n";
echo "Port: $port\n";
echo "Database: $db\n";
echo "User: $user\n\n";

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$db";
    echo "Attempting connection with DSN: $dsn\n\n";
    
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_TIMEOUT => 10
    ]);
    
    echo "✅ CONNECTION SUCCESSFUL!\n\n";
    
    // Test query
    $stmt = $pdo->query('SELECT version()');
    $version = $stmt->fetchColumn();
    echo "PostgreSQL Version: $version\n";
    
} catch (PDOException $e) {
    echo "❌ CONNECTION FAILED!\n\n";
    echo "Error Code: " . $e->getCode() . "\n";
    echo "Error Message: " . $e->getMessage() . "\n\n";
    
    // Try alternative connection methods
    echo "Trying alternative hosts...\n\n";
    
    $alternatives = [
        'aws-0-ap-southeast-1.pooler.supabase.com' => '6543',
        'abzszbtlhcxmgnysgclo.supabase.co' => '5432',
    ];
    
    foreach ($alternatives as $alt_host => $alt_port) {
        echo "Trying: $alt_host:$alt_port\n";
        try {
            $dsn = "pgsql:host=$alt_host;port=$alt_port;dbname=$db";
            $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_TIMEOUT => 5]);
            echo "✅ Connected to $alt_host!\n\n";
            break;
        } catch (PDOException $e2) {
            echo "❌ Failed: " . $e2->getMessage() . "\n\n";
        }
    }
}
