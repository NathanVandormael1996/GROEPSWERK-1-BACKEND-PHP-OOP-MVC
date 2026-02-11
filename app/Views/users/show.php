<?php
declare(strict_types=1);
?>
<section class="max-w-3xl mx-auto px-6 py-14">
    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-10 shadow-xl">
        <div class="mb-8">
            <h1 class="text-3xl font-black text-white uppercase italic">
                User #<?= $user->getId() ?>
            </h1>
            <p class="text-slate-500 text-sm mt-2">
                Account details
            </p>
        </div>

        <div class="space-y-6">
            <div>
                <span class="block text-xs uppercase tracking-widest text-slate-500 mb-1">Username</span>
                <p class="text-lg font-bold text-white">
                    <?= htmlspecialchars($user->getUsername()) ?>
                </p>
            </div>

            <div>
                <span class="block text-xs uppercase tracking-widest text-slate-500 mb-1">Email</span>
                <p class="text-slate-300">
                    <?= htmlspecialchars($user->getEmail()) ?>
                </p>
            </div>

            <div>
                <span class="block text-xs uppercase tracking-widest text-slate-500 mb-1">Role</span>
                <p class="text-slate-300">
                    <?= htmlspecialchars($user->getRoleName()) ?>
                </p>
            </div>
        </div>

        <div class="mt-12 flex items-center justify-between">
            <a href="<?= BASE_PATH ?>/users"
               class="text-slate-500 hover:text-white text-sm font-bold uppercase">
                ← Back
            </a>

            <?php if ($_SESSION['role_id'] >= 4): ?>
                <div class="flex gap-6">
                    <a href="<?= BASE_PATH ?>/users/<?= $user->getId() ?>/edit"
                       class="text-purple-400 hover:text-purple-200 font-bold uppercase text-sm">
                        Edit
                    </a>

                    <?php if ($_SESSION['role_id'] === 4): ?>
                        <form method="POST"
                              action="<?= BASE_PATH ?>/users/<?= $user->getId() ?>/delete"
                              onsubmit="return confirm('Delete this user?');">
                            <button class="text-red-500 hover:text-red-400 font-bold uppercase text-sm">
                                Delete
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
