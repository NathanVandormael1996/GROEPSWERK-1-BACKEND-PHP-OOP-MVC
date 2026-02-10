<?php
declare(strict_types=1);
?>
<!doctype html>
<html lang="nl" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?= htmlspecialchars($title ?? 'Warhammer Armory') ?></title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        // Custom Warhammer-achtige kleuren toevoegen indien gewenst
                    }
                }
            }
        }
    </script>
</head>
<body class="min-h-screen bg-slate-950 text-slate-100 font-sans tracking-tight">

<nav class="border-b border-slate-900 bg-slate-950/50 backdrop-blur-md sticky top-0 z-50">
    <div class="max-w-6xl mx-auto px-4 h-16 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <div class="w-2 h-8 bg-purple-600"></div>
            <span class="font-black italic tracking-tighter uppercase text-xl">Warhammer Armory</span>
        </div>
        <div class="flex items-center gap-6 text-xs font-bold uppercase tracking-widest text-slate-400">
            <a href="/products" class="hover:text-purple-400 transition-colors">Inventory</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <span class="text-slate-600">|</span>
                <span class="text-emerald-500"><?= htmlspecialchars($_SESSION['role'] ?? '') ?></span>
                <a href="/logout" class="text-red-900 hover:text-red-500 transition-colors">Log Out</a>
            <?php else: ?>
                <a href="/login" class="text-purple-400">Login</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<main>
    <?= $content ?>
</main>

<footer class="py-12 border-t border-slate-900 text-center">
    <p class="text-slate-600 text-xs uppercase tracking-[0.2em]">
        &copy; 2026 ADEPTUS MECHANICUS - DATA-SLATE RECORD
    </p>
</footer>

</body>
</html>