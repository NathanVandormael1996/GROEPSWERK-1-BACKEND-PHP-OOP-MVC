<?php
declare(strict_types=1);

$isAdmin = isset($_SESSION['role_id']) && $_SESSION['role_id'] >= 3;
?>
    <!DOCTYPE html>
    <html lang="en" class="scroll-smooth">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= htmlspecialchars($title ?? 'Warhammer 40k') ?></title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;900&display=swap" rel="stylesheet">
    </head>
<body class="bg-slate-950 text-slate-300 font-sans antialiased min-h-screen flex flex-col">

<?php if ($isAdmin): ?>
    <div class="flex min-h-screen">
    <?php
    // Let op: check of dit pad klopt op jouw pc!
    require __DIR__ . '/../partials/sidebar.php';
    ?>
    <main class="flex-1 md:ml-64 bg-slate-950 min-h-screen flex flex-col">
    <div class="p-6 md:p-12 max-w-7xl w-full mx-auto">

<?php else: ?>
    <nav class="bg-slate-900/80 border-b border-slate-800 sticky top-0 z-50 backdrop-blur-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="<?= BASE_PATH ?>/" class="text-2xl font-black text-white italic tracking-tighter mr-10">
                        WAR<span class="text-purple-600">HAMMER</span>
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <span class="text-xs font-bold text-white"><?= htmlspecialchars($_SESSION['username'] ?? 'User') ?></span>
                        <form action="<?= BASE_PATH ?>/logout" method="POST" class="inline">
                            <button type="submit" class="bg-red-500/10 hover:bg-red-600 text-red-500 hover:text-white border border-red-500/20 px-4 py-2 rounded text-xs font-bold uppercase transition-all">Logout</button>
                        </form>
                    <?php else: ?>
                        <a href="<?= BASE_PATH ?>/login" class="text-slate-300 hover:text-white font-bold text-xs uppercase">Login</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
    <main class="flex-grow">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
<?php endif; ?>