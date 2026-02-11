<?php
declare(strict_types=1);
?>

<section class="max-w-6xl mx-auto px-6 py-12">
    <div class="flex justify-between items-center mb-10">
        <div>
            <h1 class="text-4xl font-black text-white uppercase italic">Roles</h1>
            <p class="text-slate-500 text-sm mt-1">System access levels</p>
        </div>

        <?php if (isset($_SESSION['role_id']) && $_SESSION['role_id'] >= 4): ?>
            <a href="<?= BASE_PATH ?>/roles/create"
               class="bg-purple-600 hover:bg-purple-500 text-white px-6 py-3 rounded font-black uppercase tracking-widest text-xs">
                Create Role
            </a>
        <?php endif; ?>
    </div>

    <div class="bg-slate-900 border border-slate-800 rounded-xl overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-950 border-b border-slate-800">
            <tr>
                <th class="px-6 py-4 text-left text-xs uppercase tracking-widest text-slate-500">ID</th>
                <th class="px-6 py-4 text-left text-xs uppercase tracking-widest text-slate-500">Name</th>
                <th class="px-6 py-4 text-left text-xs uppercase tracking-widest text-slate-500">Description</th>
                <th class="px-6 py-4 text-right text-xs uppercase tracking-widest text-slate-500">Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($roles as $role): ?>
                <tr class="border-t border-slate-800 hover:bg-slate-800/40 transition">
                    <td class="px-6 py-4 text-slate-400"><?= $role->getId() ?></td>
                    <td class="px-6 py-4 font-bold text-white uppercase">
                        <?= htmlspecialchars($role->getName()) ?>
                    </td>
                    <td class="px-6 py-4 text-slate-400">
                        <?= htmlspecialchars($role->getDescription() ?? '-') ?>
                    </td>
                    <td class="px-6 py-4 text-right space-x-3">
                        <a href="<?= BASE_PATH ?>/roles/<?= $role->getId() ?>"
                           class="text-slate-400 hover:text-white text-xs font-bold uppercase">
                            View
                        </a>

                        <?php if (isset($_SESSION['role_id']) && $_SESSION['role_id'] >= 4): ?>
                            <a href="<?= BASE_PATH ?>/roles/<?= $role->getId() ?>/edit"
                               class="text-purple-400 hover:text-purple-200 text-xs font-bold uppercase">
                                Edit
                            </a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>
