<?php
// Load autoloader
require_once __DIR__ . '/vendor/autoload.php';

// Load config
$config = require __DIR__ . '/config/app.php';

// Create connection using PDO
try {
    $dsn = "pgsql:host={$config['database']['host']};port={$config['database']['port']};dbname={$config['database']['database']}";
    $conn = new PDO($dsn, $config['database']['username'], $config['database']['password']);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Check if table exists
    $checkQuery = "SELECT EXISTS (SELECT FROM information_schema.tables WHERE table_name = 'fokus_riset')";
    $result = $conn->query($checkQuery)->fetch(PDO::FETCH_ASSOC);
    
    if ($result['exists'] === 't' || $result['exists'] === true) {
        echo "✓ Tabel 'fokus_riset' sudah ada.\n";
    } else {
        // Create table
        $createSQL = "CREATE TABLE IF NOT EXISTS fokus_riset (
            id_fokus SERIAL PRIMARY KEY,
            judul VARCHAR(150) NOT NULL,
            deskripsi TEXT,
            ikon VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        
        $conn->exec($createSQL);
        echo "✓ Tabel 'fokus_riset' berhasil dibuat.\n";
    }
    
    // Check if table has data
    $countQuery = "SELECT COUNT(*) as count FROM fokus_riset";
    $countResult = $conn->query($countQuery)->fetch(PDO::FETCH_ASSOC);
    echo "✓ Jumlah data fokus riset: " . $countResult['count'] . "\n";
    
} catch (PDOException $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    exit(1);
}
