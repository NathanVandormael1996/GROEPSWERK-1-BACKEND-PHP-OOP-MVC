<?php
declare(strict_types=1);
?>

<section class="py-12 px-4">
    <div class="max-w-3xl mx-auto bg-slate-900 border border-slate-800 rounded-2xl shadow-2xl p-10">
        <header class="mb-10 text-center">
            <h1 class="text-3xl font-black text-purple-500 italic uppercase tracking-widest">Forge New Unit</h1>
            <p class="text-slate-500 mt-2">Add new unit to the fray!</p>
        </header>

        <form action="/products/store" method="POST" class="space-y-6">
            <div class="space-y-2">
                <label class="text-xs font-black text-slate-500 uppercase tracking-widest ml-1">Unit Designation</label>
                <input type="text" name="name" placeholder="ex. Primaris Aggressors"
                       class="w-full bg-slate-950 border border-slate-700 rounded-lg p-4 text-white focus:ring-2 focus:ring-purple-600 focus:border-transparent outline-none transition-all placeholder:text-slate-700" required>
            </div>

            <div class="space-y-2">
                <label class="text-xs font-black text-slate-500 uppercase tracking-widest ml-1">Lore & Specifications</label>
                <textarea name="description" rows="4" placeholder="Give a glorious description of the unit..."
                          class="w-full bg-slate-950 border border-slate-700 rounded-lg p-4 text-white focus:ring-2 focus:ring-purple-600 focus:border-transparent outline-none transition-all placeholder:text-slate-700" required></textarea>
            </div>

            <div class="grid grid-cols-2 gap-8">
                <div class="space-y-2">
                    <label class="text-xs font-black text-slate-500 uppercase tracking-widest ml-1">Credits (Price)</label>
                    <input type="number" name="price" step="0.01" placeholder="0.00"
                           class="w-full bg-slate-950 border border-slate-700 rounded-lg p-4 text-white focus:ring-2 focus:ring-purple-600 outline-none" required>
                </div>
                <div class="space-y-2">
                    <label class="text-xs font-black text-slate-500 uppercase tracking-widest ml-1">Ammunition (Stock)</label>
                    <input type="number" name="stock_quantity" placeholder="0"
                           class="w-full bg-slate-950 border border-slate-700 rounded-lg p-4 text-white focus:ring-2 focus:ring-purple-600 outline-none" required>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-8">
                <div class="space-y-2">
                    <label class="text-xs font-black text-slate-500 uppercase tracking-widest ml-1">Faction ID</label>
                    <input type="number" name="faction_id" placeholder="bv. 1"
                           class="w-full bg-slate-950 border border-slate-700 rounded-lg p-4 text-white focus:ring-2 focus:ring-purple-600 outline-none" required>
                </div>
                <div class="space-y-2">
                    <label class="text-xs font-black text-slate-500 uppercase tracking-widest ml-1">Image URL</label>
                    <input type="text" name="image_url" placeholder="url/naar/foto.jpg"
                           class="w-full bg-slate-950 border border-slate-700 rounded-lg p-4 text-white focus:ring-2 focus:ring-purple-600 outline-none">
                </div>
            </div>

            <div class="pt-8 flex flex-col gap-4">
                <button type="submit" class="w-full bg-purple-600 hover:bg-purple-500 text-white font-black py-4 rounded-lg shadow-lg transition-all uppercase tracking-widest">
                    Confirm Deployment
                </button>
                <a href="/products" class="text-center text-slate-600 hover:text-red-500 text-sm font-bold uppercase tracking-widest transition-colors">
                    Abandon Mission
                </a>
            </div>
        </form>
    </div>
</section>