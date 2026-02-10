<?php
declare(strict_types=1);
?>
<div class="text-center mb-12 relative">
    <div class="absolute inset-0 bg-purple-600/5 blur-3xl rounded-full"></div>
    <h1 class="relative text-5xl font-black text-white italic tracking-tighter mb-4">
        IMPERIAL <span class="text-purple-600">SUPPLY</span>
    </h1>
    <p class="relative text-slate-400 max-w-2xl mx-auto font-mono text-sm">
        Authorized equipment for loyal citizens of the Imperium. <br>
        <span class="text-xs text-slate-600">Note: Failure to report pricing errors is heresy.</span>
    </p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    <?php if (empty($products)): ?>
        <div class="col-span-full text-center py-12 border border-dashed border-slate-800 rounded-xl">
            <p class="text-slate-500 font-mono">No supply data found in the archives.</p>
        </div>
    <?php else: ?>
        <?php foreach ($products as $product): ?>
            <div class="group bg-slate-900 border border-slate-800 rounded-xl overflow-hidden hover:border-purple-600 transition-all shadow-lg hover:shadow-purple-900/20 flex flex-col">

                <div class="h-48 bg-slate-950 flex items-center justify-center relative overflow-hidden border-b border-slate-800">
                    <?php if (!empty($product->getImageUrl())): ?>
                        <img src="<?= htmlspecialchars($product->getImageUrl()) ?>"
                             alt="<?= htmlspecialchars($product->getName()) ?>"
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    <?php else: ?>
                        <span class="text-6xl group-hover:scale-110 transition-transform duration-500">📦</span>
                    <?php endif; ?>

                    <div class="absolute top-2 right-2 bg-slate-900/80 backdrop-blur text-purple-400 text-[10px] font-mono border border-purple-500/30 px-2 py-1 rounded">
                        MK-<?= $product->getId() ?>
                    </div>
                </div>

                <div class="p-6 flex flex-col flex-grow">
                    <h3 class="text-xl font-bold text-white group-hover:text-purple-400 transition-colors mb-2">
                        <?= htmlspecialchars($product->getName()) ?>
                    </h3>

                    <p class="text-slate-400 text-sm mb-6 flex-grow line-clamp-3">
                        <?= htmlspecialchars(substr($product->getDescription() ?? '', 0, 80)) ?>...
                    </p>

                    <div class="flex justify-between items-center pt-4 border-t border-slate-800">
                        <span class="text-xl font-black text-white">
                            € <?= number_format((float)$product->getPrice(), 2) ?>
                        </span>

                        <div class="flex gap-2">
                            <form action="<?= BASE_PATH ?>/cart/add/<?= $product->getId() ?>" method="POST">
                                <button type="submit" class="bg-purple-600 hover:bg-purple-500 text-white font-bold py-2 px-4 rounded text-[10px] uppercase tracking-widest transition-all shadow-lg shadow-purple-900/20 flex items-center gap-1">
                                    <span>+</span> Cart
                                </button>
                            </form>

                            <a href="<?= BASE_PATH ?>/shop/product/<?= $product->getId() ?>"
                               class="bg-transparent border border-slate-600 text-slate-300 hover:border-white hover:text-white font-bold py-2 px-3 rounded text-[10px] uppercase tracking-widest transition-all">
                                Inspect
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>