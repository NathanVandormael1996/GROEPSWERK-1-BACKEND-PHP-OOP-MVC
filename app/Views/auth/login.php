<?php
declare(strict_types=1);
?>
<section class="min-h-[80vh] flex items-center justify-center py-20 px-4">
    <div class="w-full max-w-md bg-slate-900 border border-slate-800 rounded-2xl shadow-2xl p-8 border-t-4 border-t-purple-600">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-black text-white uppercase tracking-widest italic">Inquisition Login</h2>
            <p class="text-slate-500 text-xs mt-2 font-bold tracking-widest uppercase">Identify yourself, citizen.</p>
        </div>

        <?php if (isset($_GET['error'])): ?>
            <div class="bg-red-900/20 border border-red-800 text-red-500 text-[10px] p-4 rounded-lg mb-6 font-black uppercase tracking-widest text-center">
                Access Denied: Invalid Identification
            </div>
        <?php endif; ?>

        <form action="/login" method="POST" class="space-y-6">
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Data-Slate ID (Email)</label>
                <input type="email" name="email" placeholder="inquisitor@imperium.com"
                       class="w-full bg-slate-950 border border-slate-800 rounded-lg p-4 text-white focus:ring-2 focus:ring-purple-600 outline-none transition-all placeholder:text-slate-800" required>
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Coded Key (Password)</label>
                <input type="password" name="password" placeholder="••••••••"
                       class="w-full bg-slate-950 border border-slate-800 rounded-lg p-4 text-white focus:ring-2 focus:ring-purple-600 outline-none transition-all placeholder:text-slate-800" required>
            </div>

            <button type="submit" class="w-full bg-purple-600 hover:bg-purple-500 text-white font-black py-4 rounded-lg shadow-lg shadow-purple-900/20 transition-all uppercase tracking-[0.2em] text-xs">
                Verify Credentials
            </button>
        </form>
    </div>
</section>