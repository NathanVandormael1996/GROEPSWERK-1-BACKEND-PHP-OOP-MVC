<?php
// database.php
declare(strict_types=1);

return [
    'host'    => 'aws-0-eu-central-1.pooler.supabase.com', // Je Supabase host
    'dbname'  => 'postgres',                               // Bijna altijd 'postgres'
    'user'    => 'postgres.jouw-project',                  // Je username
    'pass'    => '',                        // Je database wachtwoord
    'port'    => '6543',                                   // 6543 (transaction pooler) of 5432
];