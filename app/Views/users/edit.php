<?php
declare(strict_types=1);
?>
<section class="max-w-xl mx-auto px-6 py-14">
    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-10 shadow-xl">
        <h1 class="text-3xl font-black text-purple-500 uppercase italic mb-10">
            Edit User
        </h1>

        <form method="POST"
              action="<?= BASE_PATH ?>/users/<?= $user->getId() ?>/update"
              class="space-y-8">

            <div>
                <label class="block text-xs uppercase tracking-widest text-slate-500 mb-2">
                    Email
                </label>
                <input type="email" name="email" required
                       value="<?= htmlspecialchars($user->getEmail()) ?>"
                       class="w-full bg-slate-950 border border-slate-700 rounded-lg p-4 text-white">
            </div>

            <div>
                <label class="block text-xs uppercase tracking-widest text-slate-500 mb-2">
                    New Password (optional)
                </label>
                <input type="password" name="password"
                       class="w-full bg-slate-950 border border-slate-700 rounded-lg p-4 text-white">
            </div>

            <div>
                <label class="block text-xs uppercase tracking-widest text-slate-500 mb-2">
                    Role
                </label>

                <select name="role_name" required
                        class="w-full bg-slate-950 border border-slate-700 rounded-lg p-4 text-white">
                    <?php foreach ($roles as $role): ?>
                        <option value="<?= htmlspecialchars($role->getName()) ?>">
                            <?= ucfirst(htmlspecialchars($role->getName())) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="flex justify-between pt-6">
                <a href="<?= BASE_PATH ?>/users"
                   class="text-slate-500 hover:text-white font-bold uppercase text-sm">
                    Cancel
                </a>

                <button type="submit"
                        class="bg-purple-600 hover:bg-purple-500 transition
                               text-white px-8 py-3 rounded-lg
                               font-black uppercase tracking-widest text-xs">
                    Update
                </button>
            </div>
        </form>
    </div>
</section>
