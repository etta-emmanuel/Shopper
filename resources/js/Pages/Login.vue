<template>
    <div class="mx-auto max-w-xl">
        <div class="rounded-[2rem] border border-white/70 bg-white/85 p-8 shadow-[0_30px_90px_rgba(15,23,42,0.08)] backdrop-blur">
            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-slate-500">Account access</p>
            <h1 class="mt-3 text-4xl font-black tracking-[-0.04em] text-slate-950">Login</h1>
            <p class="mt-3 text-sm leading-7 text-slate-600">
                This page uses the same reusable auth form component as the global modal.
            </p>

            <LoginForm class="mt-8" />
        </div>
    </div>
</template>

<script setup>
import LoginForm from '../Components/Auth/LoginForm.vue';
import AppLayout from '../Layouts/AppLayout.vue';

defineOptions({
    layout: AppLayout,
});
</script>
