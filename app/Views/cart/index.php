<?php
declare(strict_types=1);
?>
<div class="max-w-4xl mx-auto">
    <div class="flex items-center justify-between mb-8 border-b border-slate-800 pb-4">
        <h1 class="text-3xl font-black text-white italic uppercase tracking-widest">
            Requisition Manifest <span class="text-purple-600">(Cart)</span>
        </h1>
        <span class="text-slate-500 font-mono text-xs">LOGISTICS TERMINAL // ACTIVE</span>
    </div>

    <?php if (isset($_GET['error'])): ?>
        <div class="bg-red-900/20 border border-red-800 text-red-400 p-4 rounded-lg mb-6 flex items-center gap-3 animate-pulse">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
            </svg>
            <div>
                <strong class="font-bold uppercase text-xs tracking-widest block">Logistics Error</strong>
                <span class="text-sm font-mono"><?= htmlspecialchars($_GET['error']) ?></span>
            </div>
        </div>
    <?php endif; ?>

    <?php if (empty($cartItems)): ?>
        <div class="text-center py-20 bg-slate-900/50 rounded-xl border border-dashed border-slate-800">
            <span class="text-6xl mb-4 block">📦</span>
            <p class="text-slate-400 font-mono mb-6">Manifest is empty. No supplies requested.</p>
            <a href="<?= BASE_PATH ?>/" class="bg-slate-800 hover:bg-purple-600 text-white font-bold py-3 px-6 rounded uppercase tracking-widest text-xs transition-all">
                Return to Armory
            </a>
        </div>
    <?php else: ?>
        <div class="bg-slate-900 border border-slate-800 rounded-xl overflow-hidden mb-8 shadow-2xl">
            <table class="w-full text-left">
                <thead class="bg-slate-950 text-slate-500 text-[10px] uppercase tracking-widest font-black border-b border-slate-800">
                <tr>
                    <th class="p-4">Supply Item</th>
                    <th class="p-4 text-center">Qty</th>
                    <th class="p-4 text-right">Unit Cost</th>
                    <th class="p-4 text-right">Total</th>
                    <th class="p-4"></th>
                </tr>
                </thead>
                <tbody class="divide-y divide-slate-800 text-slate-300 text-sm">
                <?php foreach ($cartItems as $item): ?>
                    <tr class="hover:bg-slate-800/50 transition-colors group">
                        <td class="p-4 font-bold text-white flex items-center gap-3">
                            <?php if (!empty($item['product']->getImageUrl())): ?>
                                <img src="<?= htmlspecialchars($item['product']->getImageUrl()) ?>" class="w-10 h-10 object-cover rounded border border-slate-700">
                            <?php else: ?>
                                <div class="w-10 h-10 bg-slate-800 rounded flex items-center justify-center text-xs">📦</div>
                            <?php endif; ?>
                            <?= htmlspecialchars($item['product']->getName()) ?>
                        </td>
                        <td class="p-4 text-center font-mono">
                                <span class="bg-slate-950 px-3 py-1 rounded border border-slate-800">
                                    <?= $item['quantity'] ?>
                                </span>
                        </td>
                        <td class="p-4 text-right font-mono text-slate-500">
                            € <?= number_format((float)$item['product']->getPrice(), 2) ?>
                        </td>
                        <td class="p-4 text-right font-mono text-purple-400 font-bold">
                            € <?= number_format($item['line_total'], 2) ?>
                        </td>
                        <td class="p-4 text-right">
                            <form action="<?= BASE_PATH ?>/cart/remove/<?= $item['product']->getId() ?>" method="POST">
                                <button class="text-slate-600 hover:text-red-500 transition-colors" title="Discard Item">
                                    X
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
                <tfoot class="bg-slate-950 border-t border-slate-800">
                <tr>
                    <td colspan="3" class="p-4 text-right text-slate-500 font-bold uppercase text-xs tracking-widest">Total Requisition Cost</td>
                    <td class="p-4 text-right font-black text-xl text-white">€ <?= number_format($totalPrice, 2) ?></td>
                    <td></td>
                </tr>
                </tfoot>
            </table>
        </div>

        <div class="flex justify-between items-center">
            <a href="<?= BASE_PATH ?>/" class="text-slate-500 hover:text-white text-xs font-bold uppercase tracking-widest flex items-center gap-2">
                <span>←</span> Continue Browsing
            </a>

            <form action="<?= BASE_PATH ?>/orders/create" method="POST">
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-500 text-white font-black py-4 px-8 rounded-lg uppercase tracking-widest text-sm shadow-lg shadow-emerald-900/20 transition-all flex items-center gap-2">
                    <span>Confirm Requisition</span>
                </button>
            </form>
        </div>
    <?php endif; ?>
</div>