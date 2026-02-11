<?php
declare(strict_types=1);
?>

<section class="max-w-3xl mx-auto px-6 py-12">
    <div class="bg-slate-900 border border-slate-800 rounded-xl p-10">
        <h1 class="text-3xl font-black text-white uppercase italic mb-6">
            Role #<?= $role->getId() ?>
        </h1>

        <div class="space-y-4 text-slate-300">
            <div>
                <span class="block text-xs uppercase tracking-widest text-slate-500">Name</span>
                <p class="font-bold text-lg"><?= htmlspecialchars($role->getName()) ?></p>
            </div>

            <div>
                <span class="block text-xs uppercase tracking-widest text-slate-500">Description</span>
                <p><?= nl2br(htmlspecialchars($role->getDescription() ?? '—')) ?></p>
            </div>
        </div>

        <div class="mt-10 flex justify-between items-center">
            <a href="<?= BASE_PATH ?>/roles"
               class="text-slate-500 hover:text-white text-sm font-bold uppercase">
                Back
            </a>

            <?php if (isset($_SESSION['role_id']) && $_SESSION['role_id'] >= 4): ?>
                <div class="flex gap-4">
                    <a href="<?= BASE_PATH ?>/roles/<?= $role->getId() ?>/edit"
                       class="text-purple-400 hover:text-purple-200 font-bold uppercase text-sm">
                        Edit
                    </a>

                    <?php if ($_SESSION['role_id'] === 4): ?>
                        <form method="POST" action="<?= BASE_PATH ?>/roles/<?= $role->getId() ?>/delete"
                              onsubmit="return confirm('Delete this role?');">
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
