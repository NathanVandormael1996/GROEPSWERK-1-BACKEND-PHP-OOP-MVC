<?php
declare(strict_types=1);
?>
<div class="max-w-2xl mx-auto bg-slate-900 border border-slate-800 p-8 rounded-xl relative overflow-hidden">
    <div class="absolute top-0 left-0 w-1 h-full bg-purple-600"></div>

    <h2 class="text-2xl font-black text-white uppercase italic mb-8 pl-4">Initialize New Faction</h2>

    <form action="<?= BASE_PATH ?>/factions/store" method="POST" class="space-y-6">
        <div>
            <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">
                Faction Designation <span class="text-red-500">*</span>
            </label>
            <input type="text" name="name" required
                   class="w-full bg-slate-950 border border-slate-700 focus:border-purple-500 text-white p-4 rounded-lg outline-none transition-all placeholder-slate-700 font-bold"
                   placeholder="e.g. ADEPTUS ASTARTES">
        </div>

        <div>
            <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">
                Archives Data / Lore <span class="text-red-500">*</span>
            </label>
            <textarea name="description" rows="6" required
                      class="w-full bg-slate-950 border border-slate-700 focus:border-purple-500 text-slate-300 p-4 rounded-lg outline-none transition-all placeholder-slate-700"
                      placeholder="Enter historical records..."></textarea>
        </div>

        <div class="flex items-center justify-end gap-4 pt-4 border-t border-slate-800">
            <a href="<?= BASE_PATH ?>/factions" class="text-slate-500 hover:text-white text-xs font-bold uppercase tracking-widest transition-colors">
                Cancel Protocol
            </a>
            <button type="submit" class="bg-emerald-600 hover:bg-emerald-500 text-white font-black py-3 px-8 rounded-lg uppercase tracking-widest text-xs transition-all shadow-lg shadow-emerald-900/20">
                Register Alliance
            </button>
        </div>
    </form>
</div>