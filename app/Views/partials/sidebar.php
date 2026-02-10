<?php
declare(strict_types=1);
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] < 3) return;
?>

<aside class="w-64 bg-slate-950 border-r border-slate-800 hidden md:flex flex-col h-screen fixed left-0 top-0 overflow-y-auto">
    <div class="p-6 border-b border-slate-800">
        <h1 class="text-2xl font-black text-white italic tracking-tighter">
            <span class="text-purple-600">WAR</span>HAMMER
            <span class="block text-xs text-slate-500 font-mono mt-1 tracking-widest">COMMAND CENTER</span>
        </h1>
    </div>

    <nav class="flex-1 p-4 space-y-2">

        <div class="text-[10px] font-black text-slate-600 uppercase tracking-widest px-4 mb-2 mt-4">Logistics</div>

        <a href="<?= BASE_PATH ?>/products"
           class="flex items-center gap-3 px-4 py-3 text-sm font-bold text-slate-400 hover:text-white hover:bg-slate-900 rounded-lg transition-all <?= strpos($_SERVER['REQUEST_URI'], '/products') !== false ? 'bg-slate-900 text-purple-400 border-l-2 border-purple-500' : '' ?>">
            <span>📦</span> Inventory (Products)
        </a>

        <a href="<?= BASE_PATH ?>/factions"
           class="flex items-center gap-3 px-4 py-3 text-sm font-bold text-slate-400 hover:text-white hover:bg-slate-900 rounded-lg transition-all <?= strpos($_SERVER['REQUEST_URI'], '/factions') !== false ? 'bg-slate-900 text-purple-400 border-l-2 border-purple-500' : '' ?>">
            <span>⚔️</span> Alliances (Factions)
        </a>

        <?php if ($_SESSION['role_id'] === 4): // Alleen Admins ?>
            <div class="text-[10px] font-black text-slate-600 uppercase tracking-widest px-4 mb-2 mt-6">Administration</div>

            <a href="<?= BASE_PATH ?>/users"
               class="flex items-center gap-3 px-4 py-3 text-sm font-bold text-slate-400 hover:text-white hover:bg-slate-900 rounded-lg transition-all">
                <span>👥</span> Personnel (Users)
            </a>
        <?php endif; ?>
    </nav>

    <div class="p-4 border-t border-slate-800 bg-slate-900/50">
        <div class="flex items-center gap-3 mb-4 px-2">
            <div class="w-8 h-8 rounded bg-purple-600 flex items-center justify-center text-white font-bold text-xs">
                <?= substr($_SESSION['username'] ?? 'A', 0, 1) ?>
            </div>
            <div>
                <div class="text-sm font-bold text-white"><?= htmlspecialchars($_SESSION['username'] ?? 'Officer') ?></div>
                <div class="text-xs text-slate-500">Level <?= $_SESSION['role_id'] ?> Access</div>
            </div>
        </div>
        <form action="<?= BASE_PATH ?>/logout" method="POST">
            <button type="submit" class="w-full text-center py-2 text-xs font-bold text-red-400 hover:text-red-300 bg-red-950/30 hover:bg-red-900/50 rounded border border-red-900/50 transition-all uppercase tracking-wider">
                Terminate Session
            </button>
        </form>
    </div>
</aside>