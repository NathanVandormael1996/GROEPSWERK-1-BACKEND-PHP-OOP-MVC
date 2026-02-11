<?php
declare(strict_types=1);
?>
<section class="max-w-7xl mx-auto px-6 py-14">
    <div class="flex items-end justify-between mb-10">
        <div>
            <h1 class="text-4xl font-black text-white uppercase italic">Users</h1>
            <p class="text-slate-500 text-sm mt-2">
                Manage application users
            </p>
        </div>

        <?php if ($_SESSION['role_id'] >= 4): ?>
            <a href="<?= BASE_PATH ?>/users/create"
               class="bg-purple-600 hover:bg-purple-500 transition
                      text-white px-6 py-3 rounded-lg
                      font-black uppercase tracking-widest text-xs">
                + New User
            </a>
        <?php endif; ?>
    </div>

    <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden shadow-xl">
        <table class="w-full text-sm">
            <thead class="bg-slate-950 border-b border-slate-800">
            <tr>
                <th class="px-6 py-4 text-left text-xs uppercase tracking-widest text-slate-500">ID</th>
                <th class="px-6 py-4 text-left text-xs uppercase tracking-widest text-slate-500">User</th>
                <th class="px-6 py-4 text-left text-xs uppercase tracking-widest text-slate-500">Email</th>
                <th class="px-6 py-4 text-left text-xs uppercase tracking-widest text-slate-500">Role</th>
                <th class="px-6 py-4 text-right text-xs uppercase tracking-widest text-slate-500">Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($users as $user): ?>
                <tr class="border-t border-slate-800 hover:bg-slate-800/40 transition">
                    <td class="px-6 py-4 text-slate-500"><?= $user->getId() ?></td>
                    <td class="px-6 py-4 font-bold text-white uppercase">
                        <?= htmlspecialchars($user->getUsername()) ?>
                    </td>
                    <td class="px-6 py-4 text-slate-400">
                        <?= htmlspecialchars($user->getEmail()) ?>
                    </td>
                    <td class="px-6 py-4 text-slate-400">
                        <?= htmlspecialchars($user->getRoleName()) ?>
                    </td>
                    <td class="px-6 py-4 text-right space-x-4">
                        <a href="<?= BASE_PATH ?>/users/<?= $user->getId() ?>"
                           class="text-slate-400 hover:text-white text-xs font-bold uppercase">
                            View
                        </a>

                        <?php if ($_SESSION['role_id'] >= 4): ?>
                            <a href="<?= BASE_PATH ?>/users/<?= $user->getId() ?>/edit"
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
