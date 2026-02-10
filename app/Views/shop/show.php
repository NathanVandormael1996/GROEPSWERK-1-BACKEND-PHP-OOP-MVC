<?php declare(strict_types=1); ?>

<div class="max-w-5xl mx-auto">
    <a href="<?= BASE_PATH ?>/" class="inline-flex items-center text-xs font-mono text-slate-500 hover:text-white mb-8 transition-colors">
        <span class="mr-2">←</span> RETURN TO SUPPLY DEPOT
    </a>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 bg-slate-900 border border-slate-800 rounded-2xl p-8 shadow-2xl">

        <div class="bg-slate-950 rounded-xl border border-slate-800 flex items-center justify-center min-h-[300px] relative overflow-hidden">
            <?php if (!empty($product->getImageUrl())): ?>
                <img src="<?= htmlspecialchars($product->getImageUrl()) ?>"
                     alt="<?= htmlspecialchars($product->getName()) ?>"
                     class="w-full h-full object-cover absolute inset-0">
            <?php else: ?>
                <span class="text-9xl">📦</span>
            <?php endif; ?>
        </div>

        <div class="flex flex-col justify-center">
            <h1 class="text-4xl font-black text-white italic tracking-tighter mb-2">
                <?= htmlspecialchars($product->getName()) ?>
            </h1>
            <div class="flex items-center gap-4 mb-6">
                <span class="bg-purple-900/30 text-purple-400 text-xs font-bold px-3 py-1 rounded border border-purple-500/30 uppercase tracking-wider">
                    In Stock: <?= $product->getStockQuantity() ?>
                </span>
            </div>

            <div class="prose prose-invert prose-slate mb-8 text-sm leading-relaxed text-slate-300">
                <?= nl2br(htmlspecialchars($product->getDescription())) ?>
            </div>

            <div class="mt-auto border-t border-slate-800 pt-8">
                <div class="flex items-end justify-between mb-4">
                    <span class="text-slate-400 text-xs uppercase font-bold tracking-widest">Requisition Cost</span>
                    <span class="text-3xl font-black text-white">€ <?= number_format((float)$product->getPrice(), 2) ?></span>
                </div>

                <button onclick="alert('System Offline: Logistics functionality pending.')"
                        class="w-full bg-slate-700 hover:bg-slate-600 text-slate-300 font-black py-4 rounded-lg uppercase tracking-widest text-sm transition-all cursor-not-allowed">
                    Authorized Requisition (Offline)
                </button>

                <p class="text-[10px] text-center text-slate-600 font-mono mt-2">
                    *Logistics Spirit Machine is currently under maintenance.
                </p>
            </div>
        </div>
    </div>
</div>