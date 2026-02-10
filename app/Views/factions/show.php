<?php
declare(strict_types=1);
?>
<div class="max-w-4xl mx-auto">
    <a href="<?= BASE_PATH ?>/factions" class="inline-flex items-center text-xs font-mono text-slate-500 hover:text-purple-400 mb-6 transition-colors">
        <span class="mr-2">←</span> RETURN TO REGISTRY
    </a>

    <div class="bg-slate-900 border border-slate-800 rounded-xl overflow-hidden relative">
        <div class="bg-slate-950 p-8 border-b border-slate-800 flex justify-between items-start">
            <div>
                <h1 class="text-4xl font-black text-white uppercase italic tracking-tighter mb-2">
                    <?= htmlspecialchars($faction->getName()) ?>
                </h1>
                <div class="flex gap-4 text-xs font-mono text-slate-500">
                    <span>ESTABLISHED: <?= htmlspecialchars($faction->getCreatedAt() ?? 'Unknown') ?></span>
                </div>
            </div>

            <?php if (isset($_SESSION['role_id']) && $_SESSION['role_id'] >= 3): ?>
                <div class="flex gap-2">
                    <a href="<?= BASE_PATH ?>/factions/<?= $faction->getId() ?>/edit"
                       class="bg-slate-800 hover:bg-purple-600 text-white px-4 py-2 rounded text-xs font-bold uppercase tracking-widest transition-all">
                        Update Data
                    </a>

                    <?php if ($_SESSION['role_id'] === 4):?>
                        <form action="<?= BASE_PATH ?>/factions/<?= $faction->getId() ?>/delete" method="POST"
                              onsubmit="return confirm('CONFIRM EXTERMINATUS? This action cannot be undone.');">
                            <button type="submit" class="bg-red-900/20 hover:bg-red-600 text-red-500 hover:text-white border border-red-900/50 px-4 py-2 rounded text-xs font-bold uppercase tracking-widest transition-all">
                                Purge
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="p-8">
            <h3 class="text-sm font-bold text-purple-500 uppercase tracking-widest mb-4 border-b border-purple-900/30 pb-2 w-max">
                Lore / Description
            </h3>
            <div class="prose prose-invert prose-slate max-w-none text-slate-300 leading-relaxed">
                <?= nl2br(htmlspecialchars($faction->getDescription())) ?>
            </div>
        </div>

        <div class="bg-slate-950 p-4 border-t border-slate-800 text-[10px] text-slate-600 font-mono text-right">
            LAST UPDATE: <?= htmlspecialchars($faction->getUpdatedAt() ?? 'N/A') ?> // TERMINAL 40K
        </div>
    </div>
</div>