<?php
declare(strict_types=1);
?>
<div class="space-y-6">
    <div class="flex justify-between items-center border-b border-slate-800 pb-6">
        <div>
            <h1 class="text-3xl font-black text-white uppercase italic tracking-wider">
                <span class="text-purple-600">Alliance</span> Registry
            </h1>
            <p class="text-slate-500 text-xs font-mono mt-1">Authorized Factions of the 41st Millennium</p>
        </div>

        <?php if (isset($_SESSION['role_id']) && $_SESSION['role_id'] >= 3): ?>
            <a href="<?= BASE_PATH ?>/factions/create"
               class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-6 rounded-lg uppercase tracking-widest text-xs transition-all shadow-lg shadow-purple-900/20 flex items-center gap-2">
                <span>+ Initialize New Faction</span>
            </a>
        <?php endif; ?>
    </div>

    <?php if (isset($_GET['success'])): ?>
        <div class="bg-emerald-900/30 border border-emerald-800 text-emerald-400 p-4 rounded-lg text-sm font-mono animate-pulse">
            > SYSTEM ALERT: Database updated successfully.
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($factions as $faction): ?>
            <div class="bg-slate-900 border border-slate-800 rounded-xl p-6 hover:border-purple-600/50 transition-all group flex flex-col h-full relative overflow-hidden">

                <div class="absolute top-0 right-0 w-16 h-16 bg-gradient-to-bl from-slate-800/50 to-transparent -mr-8 -mt-8 rounded-full"></div>

                <div class="flex justify-between items-start mb-4 relative z-10">
                    <h3 class="text-xl font-bold text-white group-hover:text-purple-400 transition-colors">
                        <?= htmlspecialchars($faction->getName()) ?>
                    </h3>
                </div>

                <p class="text-slate-400 text-sm mb-6 line-clamp-3 flex-grow">
                    <?= htmlspecialchars($faction->getDescription()) ?>
                </p>

                <div class="flex gap-2 mt-auto pt-4 border-t border-slate-800">
                    <a href="<?= BASE_PATH ?>/factions/<?= $faction->getId() ?>"
                       class="flex-1 text-center bg-slate-800 hover:bg-slate-700 text-white py-2 rounded text-xs uppercase font-bold transition-colors">
                        Inspect
                    </a>

                    <?php if (isset($_SESSION['role_id']) && $_SESSION['role_id'] >= 3): ?>
                        <a href="<?= BASE_PATH ?>/factions/<?= $faction->getId() ?>/edit"
                           class="px-3 flex items-center bg-slate-800 hover:bg-purple-900/50 text-purple-400 hover:text-purple-300 border border-slate-700 hover:border-purple-500 rounded text-xs transition-colors" title="Edit Protocol">
                            ✎
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>