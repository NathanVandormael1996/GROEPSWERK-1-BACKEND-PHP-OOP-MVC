<?php
declare(strict_types=1);
?>
<div class="max-w-2xl mx-auto bg-slate-900 border border-slate-800 p-8 rounded-xl">
    <h2 class="text-2xl font-black text-white uppercase italic mb-8 border-l-4 border-purple-600 pl-4">
        Modify Unit Protocol
    </h2>

    <form action="<?= BASE_PATH ?>/products/<?= $product->getId() ?>/update"
          method="POST"
          class="space-y-6">

        <!-- FACTION (NAME, NOT ID) -->
        <div>
            <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">
                Faction
            </label>

            <select name="faction_name" required
                    class="w-full bg-slate-950 border border-slate-800 p-4 text-white rounded-lg
                           focus:ring-2 focus:ring-purple-600 outline-none transition-all">
                <?php foreach ($factions as $faction): ?>
                    <option value="<?= htmlspecialchars($faction->getName()) ?>"
                            <?= $faction->getName() === $product->getFactionName() ? 'selected' : '' ?>>
                        <?= htmlspecialchars($faction->getName()) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- UNIT NAME -->
        <div>
            <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">
                Unit Designation
            </label>
            <input type="text"
                   name="name"
                   value="<?= htmlspecialchars($product->getName()) ?>"
                   class="w-full bg-slate-950 border border-slate-800 p-4 text-white rounded-lg
                          focus:ring-2 focus:ring-purple-600 outline-none transition-all">
        </div>

        <!-- IMAGE -->
        <div>
            <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">
                Pict-Capture Link (Image URL)
            </label>
            <input type="text"
                   name="image_url"
                   value="<?= htmlspecialchars($product->getImageUrl() ?? '') ?>"
                   class="w-full bg-slate-950 border border-slate-800 p-4 text-white rounded-lg
                          focus:ring-2 focus:ring-purple-600 outline-none transition-all font-mono text-xs"
                   placeholder="https://example.com/image.jpg">
        </div>

        <!-- DESCRIPTION -->
        <div>
            <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">
                Technical Description
            </label>
            <textarea name="description"
                      rows="4"
                      class="w-full bg-slate-950 border border-slate-800 p-4 text-white rounded-lg
                             focus:ring-2 focus:ring-purple-600 outline-none transition-all"><?= htmlspecialchars($product->getDescription()) ?></textarea>
        </div>

        <!-- PRICE + STOCK -->
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">
                    Price (Credits)
                </label>
                <input type="number"
                       step="0.01"
                       name="price"
                       value="<?= $product->getPrice() ?>"
                       class="w-full bg-slate-950 border border-slate-800 p-4 text-white rounded-lg
                              focus:ring-2 focus:ring-purple-600 outline-none transition-all">
            </div>

            <div>
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">
                    Stock Level
                </label>
                <input type="number"
                       name="stock_quantity"
                       value="<?= $product->getStockQuantity() ?>"
                       class="w-full bg-slate-950 border border-slate-800 p-4 text-white rounded-lg
                              focus:ring-2 focus:ring-purple-600 outline-none transition-all">
            </div>
        </div>

        <button type="submit"
                class="w-full bg-emerald-600 hover:bg-emerald-500 text-white font-black py-4
                       rounded-lg uppercase tracking-widest text-xs transition-all shadow-lg
                       shadow-emerald-900/20">
            Commit Changes to Dataslate
        </button>
    </form>
</div>
