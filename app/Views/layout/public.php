<?php
declare(strict_types=1);

$isAdmin = isset($_SESSION['role_id']) && $_SESSION['role_id'] >= 3;
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Warhammer 40k Inventory') ?></title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;700;900&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        mono: ['JetBrains Mono', 'monospace'],
                    },
                    colors: {
                        // Je kunt hier eventueel je eigen Warhammer-kleuren toevoegen
                        'warhammer-dark': '#0b0f19',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-slate-950 text-slate-300 font-sans antialiased min-h-screen flex flex-col selection:bg-purple-500 selection:text-white">

<?php if ($isAdmin): ?>

    <div class="flex min-h-screen">

        <?php require __DIR__ . '/../partials/sidebar.php'; ?>

        <main class="flex-1 md:ml-64 bg-slate-950 min-h-screen flex flex-col">
            <header class="bg-slate-900 border-b border-slate-800 p-4 flex justify-between items-center md:hidden sticky top-0 z-50">
                <span class="font-black italic text-white">WAR<span class="text-purple-600">HAMMER</span> CMD</span>
                <div class="text-xs font-mono text-slate-500">Mobile View</div>
            </header>

            <div class="p-6 md:p-12 max-w-7xl w-full mx-auto">
                <?= $content ?>
            </div>

            <footer class="mt-auto border-t border-slate-900 p-6 text-center text-[10px] text-slate-600 font-mono">
                SECURE TERMINAL // AUTHORIZED ACCESS ONLY
            </footer>
        </main>
    </div>

<?php else: ?>

    <nav class="bg-slate-900/80 border-b border-slate-800 sticky top-0 z-50 backdrop-blur-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">

                <div class="flex items-center">
                    <a href="<?= BASE_PATH ?>/" class="text-2xl font-black text-white italic tracking-tighter hover:text-purple-500 transition-colors mr-10">
                        WAR<span class="text-purple-600">HAMMER</span>
                    </a>

                    <div class="hidden md:flex space-x-1">
                        <a href="<?= BASE_PATH ?>/" class="text-slate-300 hover:text-white hover:bg-slate-800 px-3 py-2 rounded-md text-xs font-bold uppercase tracking-widest transition-all">Home</a>
                        <a href="<?= BASE_PATH ?>/products" class="text-slate-300 hover:text-white hover:bg-slate-800 px-3 py-2 rounded-md text-xs font-bold uppercase tracking-widest transition-all">Armory</a>
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <div class="hidden md:flex flex-col items-end mr-2">
                            <span class="text-xs font-bold text-white"><?= htmlspecialchars($_SESSION['username']) ?></span>
                            <span class="text-[10px] text-slate-500 font-mono">Operative</span>
                        </div>
                        <form action="<?= BASE_PATH ?>/logout" method="POST" class="inline">
                            <button type="submit" class="bg-red-500/10 hover:bg-red-600 text-red-500 hover:text-white border border-red-500/20 px-4 py-2 rounded text-xs font-bold uppercase tracking-widest transition-all">
                                Logout
                            </button>
                        </form>
                    <?php else: ?>
                        <a href="<?= BASE_PATH ?>/login" class="text-slate-300 hover:text-white font-bold text-xs uppercase tracking-widest">Login</a>
                        <a href="<?= BASE_PATH ?>/register" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded text-xs font-bold uppercase tracking-widest shadow-lg shadow-purple-900/20 transition-all">Enlist</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-grow">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <?= $content ?>
        </div>
    </main>

    <footer class="bg-slate-900 border-t border-slate-800 mt-auto">
        <div class="max-w-7xl mx-auto py-12 px-4 text-center">
                <span class="block text-2xl font-black text-slate-700 italic tracking-tighter">
                    WAR<span class="text-slate-600">HAMMER</span>
                </span>
            <p class="text-slate-500 text-xs font-mono mt-2">
                &copy; 40,000 AD Imperial Armory.
            </p>
        </div>
    </footer>

<?php endif; ?>

</body>
</html>