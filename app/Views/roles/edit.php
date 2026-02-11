<?php
declare(strict_types=1);
?>

<section class="max-w-xl mx-auto px-6 py-12">
    <div class="bg-slate-900 border border-slate-800 rounded-xl p-10">
        <h1 class="text-3xl font-black text-purple-500 uppercase italic mb-8">
            Edit Role
        </h1>

        <form method="POST" action="<?= BASE_PATH ?>/roles/<?= $role->getId() ?>/update" class="space-y-6">
            <div>
                <label class="block text-xs uppercase tracking-widest text-slate-500 mb-2">
                    Name
                </label>
                <input type="text" name="name" required
                       value="<?= htmlspecialchars($role->getName()) ?>"
                       class="w-full bg-slate-950 border border-slate-700 rounded p-4 text-white">
            </div>

            <div>
                <label class="block text-xs uppercase tracking-widest text-slate-500 mb-2">
                    Description
                </label>
                <textarea name="description" rows="4"
                          class="w-full bg-slate-950 border border-slate-700 rounded p-4 text-white"><?= htmlspecialchars($role->getDescription() ?? '') ?></textarea>
            </div>

            <div class="flex justify-between pt-6">
                <a href="<?= BASE_PATH ?>/roles"
                   class="text-slate-500 hover:text-white font-bold uppercase text-sm">
                    Cancel
                </a>

                <button type="submit"
                        class="bg-purple-600 hover:bg-purple-500 text-white px-6 py-3 rounded font-black uppercase text-sm">
                    Update
                </button>
            </div>
        </form>
    </div>
</section>
