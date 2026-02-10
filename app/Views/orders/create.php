<?php
declare(strict_types=1);
?>

<div class="max-w-xl mx-auto px-4 py-10">
    <h1 class="text-4xl font-black uppercase italic text-white tracking-tighter mb-8">
        Create Order
    </h1>

    <form action="<?= BASE_PATH ?>/orders/store" method="POST"
          class="bg-slate-900 border border-slate-800 rounded-xl p-8 space-y-6 shadow-2xl">

        <div>
            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">
                User ID (optional)
            </label>
            <input type="number" name="user_id"
                   class="w-full bg-slate-950 border border-slate-800 text-white px-4 py-3 rounded focus:outline-none focus:border-purple-600">
        </div>

        <div>
            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">
                Total Price (€)
            </label>
            <input type="number" step="0.01" name="total_price" required
                   class="w-full bg-slate-950 border border-slate-800 text-white px-4 py-3 rounded focus:outline-none focus:border-purple-600">
        </div>

        <div class="pt-6 border-t border-slate-800 flex justify-end gap-4">
            <a href="<?= BASE_PATH ?>/orders"
               class="text-slate-400 hover:text-white text-[10px] font-black uppercase tracking-widest">
                Cancel
            </a>

            <button type="submit"
                    class="bg-emerald-600 hover:bg-emerald-500 text-white text-[10px] font-black py-3 px-6 rounded uppercase tracking-widest transition-all">
                Create Order
            </button>
        </div>
    </form>
</div>
