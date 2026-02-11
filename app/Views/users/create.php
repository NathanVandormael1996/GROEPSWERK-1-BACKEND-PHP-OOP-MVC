<section class="max-w-xl mx-auto px-6 py-14">
    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-10 shadow-xl">
        <h1 class="text-3xl font-black text-purple-500 uppercase italic mb-10">
            Create User
        </h1>

        <form method="POST" action="<?= BASE_PATH ?>/users/store" class="space-y-8">
            <div>
                <label class="block text-xs uppercase tracking-widest text-slate-500 mb-2">
                    Email
                </label>
                <input type="email" name="email" required
                       class="w-full bg-slate-950 border border-slate-700 rounded-lg p-4 text-white">
            </div>

            <div>
                <label class="block text-xs uppercase tracking-widest text-slate-500 mb-2">
                    Password
                </label>
                <input type="password" name="password" required
                       class="w-full bg-slate-950 border border-slate-700 rounded-lg p-4 text-white">
            </div>

            <div>
                <label class="block text-xs uppercase tracking-widest text-slate-500 mb-2">
                    Role
                </label>
                <select name="role_name" required
                        class="w-full bg-slate-950 border border-slate-700 rounded-lg p-4 text-white">
                    <option value="klant">Klant</option>
                    <option value="admin">Admin</option>
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
                    Create
                </button>
            </div>
        </form>
    </div>
</section>
