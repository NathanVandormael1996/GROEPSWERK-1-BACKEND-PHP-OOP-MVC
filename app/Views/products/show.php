<?php
declare(strict_types=1);
?>
<div class="max-w-4xl mx-auto p-6 bg-slate-900 border border-slate-800 rounded-xl shadow-2xl">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div>
            <img src="<?= htmlspecialchars($product->getImageUrl()) ?>" alt="Unit Image" class="rounded-lg border-2 border-purple-600/30">
        </div>
        <div class="space-y-4">
            <h1 class="text-4xl font-black uppercase italic text-white tracking-tighter"><?= htmlspecialchars($product->getName()) ?></h1>
            <span class="inline-block px-3 py-1 bg-purple-900/50 text-purple-400 text-xs font-bold rounded-full uppercase">Faction ID: <?= $product->getFactionId() ?></span>
            <p class="text-slate-400 leading-relaxed"><?= nl2br(htmlspecialchars($product->getDescription())) ?></p>
            <div class="text-3xl font-mono text-emerald-500">€ <?= number_format($product->getPrice(), 2) ?></div>
            <div class="text-xs text-slate-500 uppercase font-bold tracking-widest">Stock: <?= $product->getStockQuantity() ?> units</div>

            <div class="pt-6 flex gap-4">
                <a href="/products" class="px-6 py-2 bg-slate-800 hover:bg-slate-700 text-white text-xs font-bold uppercase tracking-widest transition-all rounded">Return to Inventory</a>
            </div>
        </div>
    </div>
</div>