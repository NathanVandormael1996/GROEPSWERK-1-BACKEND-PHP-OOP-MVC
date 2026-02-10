<?php
declare(strict_types=1);
?>

<div class="max-w-7xl mx-auto px-4 py-10">
    <div class="flex justify-between items-center mb-12">
        <div>
            <h1 class="text-4xl font-black uppercase italic text-white tracking-tighter">
                Orders
            </h1>
            <p class="text-slate-500 text-xs mt-1 uppercase tracking-[0.3em]">
                Imperial Transaction Log
            </p>
        </div>

        <?php if (isset($_SESSION['role_id']) && $_SESSION['role_id'] >= 3): ?>
            <a href="<?= BASE_PATH ?>/orders/create"
               class="bg-emerald-600 hover:bg-emerald-500 text-white text-[10px] font-black py-3 px-6 rounded uppercase tracking-widest transition-all">
                Add Order
            </a>
        <?php endif; ?>
    </div>

    <?php if (isset($_GET['success'])): ?>
        <div class="bg-emerald-900/20 border border-emerald-800 text-emerald-500 text-[10px] p-4 rounded mb-8 font-black uppercase tracking-widest text-center">
            Order Status Updated Successfully
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php foreach ($orders as $order): ?>
            <div class="bg-slate-900 border border-slate-800 rounded-xl p-6 hover:border-purple-600/50 transition-all duration-300 shadow-2xl">

                <div class="space-y-4">
                    <h3 class="text-xl font-black text-white uppercase tracking-tight">
                        Order #<?= $order->getId() ?>
                    </h3>

                    <div class="text-slate-400 text-sm space-y-1">
                        <p>
                            <span class="uppercase text-[10px] tracking-widest text-slate-600">User ID</span><br>
                            <?= $order->getUserId() ?? 'Guest' ?>
                        </p>

                        <p>
                            <span class="uppercase text-[10px] tracking-widest text-slate-600">Created At</span><br>
                            <?= htmlspecialchars($order->getCreatedAt()) ?>
                        </p>
                    </div>

                    <div class="pt-4 border-t border-slate-800 flex justify-between items-end">
                        <div>
                            <p class="text-[10px] font-bold text-slate-600 uppercase tracking-widest">Total Price</p>
                            <p class="text-emerald-500 font-mono font-bold text-lg">
                                € <?= number_format($order->getTotalPrice(), 2, ',', '.') ?>
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-2 mt-6">
                        <a href="orders/<?= $order->getId() ?>"
                           class="bg-slate-800 hover:bg-slate-700 text-white text-[10px] font-black py-3 text-center rounded uppercase tracking-widest transition-colors">
                            View Order
                        </a>

                        <?php if (isset($_SESSION['role_id']) && $_SESSION['role_id'] >= 3): ?>
                            <a href="orders/<?= $order->getId() ?>/edit"
                               class="bg-purple-900/30 hover:bg-purple-600 text-purple-400 hover:text-white text-[10px] font-black py-3 text-center rounded uppercase tracking-widest transition-all border border-purple-900">
                                Modify
                            </a>
                        <?php endif; ?>
                    </div>

                    <?php if (isset($_SESSION['role_id']) && $_SESSION['role_id'] === 4): ?>
                        <form action="orders/<?= $order->getId() ?>/delete" method="POST"
                              onsubmit="return confirm('Purge this order permanently?');">
                            <button type="submit"
                                    class="w-full mt-2 text-[10px] font-black text-red-900 hover:text-red-500 uppercase tracking-widest transition-colors">
                                Delete Order
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
