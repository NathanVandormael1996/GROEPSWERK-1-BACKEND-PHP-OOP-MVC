<?php
declare(strict_types=1);
?>

<div class="max-w-4xl mx-auto px-4 py-10">
    <div class="mb-10">
        <h1 class="text-4xl font-black uppercase italic text-white tracking-tighter">
            Order #<?= $order->getId() ?>
        </h1>
        <p class="text-slate-500 text-xs mt-1 uppercase tracking-[0.3em]">
            Imperial Order Details
        </p>
    </div>

    <div class="bg-slate-900 border border-slate-800 rounded-xl p-8 space-y-6 shadow-2xl">
        <div>
            <p class="text-[10px] font-bold text-slate-600 uppercase tracking-widest">User ID</p>
            <p class="text-white text-lg font-mono">
                <?= $order->getUserId() ?? 'Guest' ?>
            </p>
        </div>

        <div>
            <p class="text-[10px] font-bold text-slate-600 uppercase tracking-widest">Total Price</p>
            <p class="text-emerald-500 text-2xl font-black font-mono">
                € <?= number_format($order->getTotalPrice(), 2, ',', '.') ?>
            </p>
        </div>

        <div class="grid grid-cols-2 gap-6 pt-6 border-t border-slate-800">
            <div>
                <p class="text-[10px] font-bold text-slate-600 uppercase tracking-widest">Created At</p>
                <p class="text-slate-300"><?= htmlspecialchars($order->getCreatedAt()) ?></p>
            </div>

            <div>
                <p class="text-[10px] font-bold text-slate-600 uppercase tracking-widest">Updated At</p>
                <p class="text-slate-300">
                    <?= $order->getUpdatedAt() ?? '—' ?>
                </p>
            </div>
        </div>
        <div class="pt-6 flex gap-4">
            <a href="/orders" class="px-6 py-2 bg-slate-800 hover:bg-slate-700 text-white text-xs font-bold uppercase tracking-widest transition-all rounded">Return to Inventory</a>
        </div>
    </div>
</div>
