<?php
declare(strict_types=1);
?>

<div class="max-w-7xl mx-auto px-4 py-10">
    <div class="flex justify-between items-center mb-12">
        <div>
            <h1 class="text-4xl font-black uppercase italic text-white tracking-tighter">Armory Inventory</h1>
            <p class="text-slate-500 text-xs mt-1 uppercase tracking-[0.3em]">Imperial Logistics Record</p>
        </div>

        <?php if (isset($_SESSION['role_id']) && $_SESSION['role_id'] >= 3): ?>
            <a href="products/create" class="bg-purple-600 hover:bg-purple-500 text-white text-[10px] font-black py-3 px-6 rounded uppercase tracking-widest transition-all">
                Forge New Unit
            </a>
        <?php endif; ?>
    </div>

    <?php if (isset($_GET['success'])): ?>
        <div class="bg-emerald-900/20 border border-emerald-800 text-emerald-500 text-[10px] p-4 rounded mb-8 font-black uppercase tracking-widest text-center">
            Logistics Update: Operation Successful
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php foreach ($products as $product): ?>
            <div class="bg-slate-900 border border-slate-800 rounded-xl overflow-hidden group hover:border-purple-600/50 transition-all duration-300 shadow-2xl">
                <div class="h-48 overflow-hidden bg-slate-950 relative">
                    <img src="<?= htmlspecialchars($product->getImageUrl() ?: 'https://via.placeholder.com/400x300?text=No+Image') ?>"
                         alt="<?= htmlspecialchars($product->getName()) ?>"
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500 opacity-80 group-hover:opacity-100">
                </div>

                <div class="p-6 space-y-4">
                    <h3 class="text-xl font-black text-white uppercase italic tracking-tight"><?= htmlspecialchars($product->getName()) ?></h3>
                    <p class="text-slate-500 text-sm line-clamp-2 leading-relaxed">
                        <?= htmlspecialchars($product->getDescription()) ?>
                    </p>

                    <div class="flex justify-between items-end pt-4 border-t border-slate-800">
                        <div>
                            <p class="text-[10px] font-bold text-slate-600 uppercase tracking-widest">Price</p>
                            <p class="text-emerald-500 font-mono font-bold text-lg">€ <?= number_format($product->getPrice(), 2, ',', '.') ?></p>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] font-bold text-slate-600 uppercase tracking-widest">Stock</p>
                            <p class="text-white font-bold <?= $product->getStockQuantity() < 5 ? 'text-red-500' : '' ?>">
                                <?= $product->getStockQuantity() ?> Units
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-2 mt-6">
                        <a href="products/<?= $product->getId() ?>"
                           class="bg-slate-800 hover:bg-slate-700 text-white text-[10px] font-black py-3 text-center rounded uppercase tracking-widest transition-colors">
                            View Data
                        </a>

                        <?php if (isset($_SESSION['role_id']) && $_SESSION['role_id'] >= 3): ?>
                            <a href="products/<?= $product->getId() ?>/edit"
                               class="bg-purple-900/30 hover:bg-purple-600 text-purple-400 hover:text-white text-[10px] font-black py-3 text-center rounded uppercase tracking-widest transition-all border border-purple-900">
                                Modify
                            </a>
                        <?php endif; ?>
                    </div>

                    <?php if (isset($_SESSION['role_id']) && $_SESSION['role_id'] === 4): ?>
                        <form action="products/<?= $product->getId() ?>/delete" method="POST" onsubmit="return confirm('Exterminatus? This unit will be purged.');">
                            <button type="submit" class="w-full mt-2 text-[10px] font-black text-red-900 hover:text-red-500 uppercase tracking-widest transition-colors">
                                Purge Unit (Delete)
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>