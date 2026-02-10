<?php
declare(strict_types=1);
?>
    <div class="max-w-2xl mx-auto bg-slate-900 border border-slate-800 p-8 rounded-xl relative overflow-hidden">
    <div class="absolute top-0 left-0 w-1 h-full bg-yellow-600"></div>

    <div class="flex justify-between items-center mb-8 pl-4">
        <h2 class="text-2xl font-black text-white uppercase italic">Update Protocol</h2>
        <span class="text-xs font-mono text-slate-500">SUBJECT: <?= htmlspecialchars($faction->getName()) ?></span>
    </div>

    <form action="<?= BASE_PATH ?>/factions/<?= $faction->getId() ?>/update" method="POST" class="space-y-6">

        <div>
            <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">
                Faction Designation
            </label>
            <input type="text" name="name" value="<?= htmlspecialchars($faction->getName()) ?>" required
                   class="w-full bg-slate-950 border border-slate-700 focus:border-yellow-600 text-white p-4 rounded-lg outline-none transition-all font-bold">
        </div>

        <div>
            <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">
                Archives Data
            </label>
            <textarea name="description" rows="6" required
                      class="w-full bg-slate-950 border border-slate-700 focus:border-yellow-600 text-slate-300 p-4 rounded-lg outline-none transition-all"><?= htmlspecialchars($faction->getDescription()) ?></textarea>
        </div>

        <div class="flex items-center justify-end gap-4 pt-4 border-t border-slate-800">
            <a href="<?= BASE_PATH ?>/factions" class="text-slate-500 hover:text-white text-xs font-bold uppercase tracking-widest transition-colors">
                Abort
            </a>
            <button type="submit" class="bg-yellow-600 hover:bg-yellow-500 text-black font-black py-3 px-8 rounded-lg uppercase tracking-widest text-xs transition-all shadow-lg shadow-yellow-900/20">
                Commit Updates
            </button>
        </div>
    </form>
    </div><?php
