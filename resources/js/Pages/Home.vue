<template>
    <div class="space-y-8">
        <section class="grid gap-8 xl:grid-cols-[1.15fr_0.85fr]">
            <div class="rounded-[2rem] border border-white/70 bg-white/85 p-8 shadow-[0_30px_90px_rgba(15,23,42,0.08)] backdrop-blur xl:p-10">
                <p class="inline-flex rounded-full border border-amber-300 bg-amber-50 px-4 py-1 text-xs font-semibold uppercase tracking-[0.28em] text-amber-800">
                    Shopper home
                </p>

                <h1 class="mt-5 max-w-4xl text-5xl font-black leading-none tracking-[-0.055em] text-balance sm:text-6xl">
                    A simpler front door for the shopper workspace.
                </h1>

                <p class="mt-6 max-w-2xl text-base leading-8 text-slate-700 sm:text-lg">
                    {{ message }}
                </p>

                <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                    <button
                        v-if="!authUser"
                        type="button"
                        class="inline-flex items-center justify-center rounded-full bg-slate-950 px-6 py-3 text-sm font-semibold text-white transition hover:bg-slate-800"
                        @click="openAuth('register')"
                    >
                        Create account
                    </button>
                    <Link
                        v-else-if="authUser.type === 'admin'"
                        href="/dashboard"
                        class="inline-flex items-center justify-center rounded-full bg-slate-950 px-6 py-3 text-sm font-semibold text-white transition hover:bg-slate-800"
                    >
                        Open dashboard
                    </Link>
                    <button
                        v-else
                        type="button"
                        class="inline-flex items-center justify-center rounded-full bg-slate-950 px-6 py-3 text-sm font-semibold text-white transition hover:bg-slate-800"
                        @click="reloadHome"
                    >
                        Reload home
                    </button>

                    <button
                        type="button"
                        class="inline-flex items-center justify-center rounded-full border border-slate-300 bg-white px-6 py-3 text-sm font-semibold text-slate-800 transition hover:border-slate-950"
                        @click="authUser ? reloadHome() : openAuth('login')"
                    >
                        {{ authUser ? 'Refresh page' : 'Login' }}
                    </button>
                </div>
            </div>

            <div class="grid gap-6">
                <section class="rounded-[2rem] bg-slate-950 p-7 text-white shadow-[0_30px_90px_rgba(15,23,42,0.16)]">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-amber-300">Shared access</p>
                            <h2 class="mt-2 text-2xl font-bold">One auth entry point</h2>
                        </div>
                        <span class="rounded-full bg-white/10 px-3 py-1 text-xs font-medium text-white/80">
                            {{ authUser ? 'Signed in' : 'Guest' }}
                        </span>
                    </div>

                    <div class="mt-6 space-y-4">
                        <div
                            v-for="(item, index) in highlights"
                            :key="item.title"
                            class="rounded-3xl border border-white/10 bg-white/5 p-4"
                        >
                            <div class="flex items-start gap-4">
                                <span class="flex h-9 w-9 items-center justify-center rounded-full bg-amber-400 text-sm font-bold text-slate-950">
                                    0{{ index + 1 }}
                                </span>
                                <div>
                                    <p class="font-semibold">{{ item.title }}</p>
                                    <p class="mt-1 text-sm leading-6 text-white/70">{{ item.copy }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="rounded-[2rem] border border-white/70 bg-white/85 p-7 shadow-[0_30px_90px_rgba(15,23,42,0.08)] backdrop-blur">
                    <p class="text-xs font-semibold uppercase tracking-[0.28em] text-slate-500">Today</p>
                    <h2 class="mt-2 text-2xl font-bold text-slate-950">Clean workspace state</h2>
                    <p class="mt-4 text-sm leading-7 text-slate-700">
                        The home page is now intentionally light. Catalog summaries, user listings, and management actions live on
                        the dashboard instead of crowding the landing screen.
                    </p>
                    <div class="mt-6 inline-flex rounded-full bg-amber-100 px-4 py-2 text-sm font-semibold text-amber-900">
                        {{ date }}
                    </div>
                </section>
            </div>
        </section>

        <section class="grid gap-6 lg:grid-cols-3">
            <article
                v-for="panel in panels"
                :key="panel.title"
                class="rounded-[2rem] border border-white/70 bg-white/85 p-7 shadow-[0_30px_90px_rgba(15,23,42,0.08)] backdrop-blur"
            >
                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-slate-500">{{ panel.eyebrow }}</p>
                <h3 class="mt-3 text-2xl font-bold tracking-[-0.03em] text-slate-950">{{ panel.title }}</h3>
                <p class="mt-4 text-sm leading-7 text-slate-700">{{ panel.copy }}</p>
            </article>
        </section>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import { Link, router, usePage } from '@inertiajs/vue3';
import AppLayout from '../Layouts/AppLayout.vue';
import { useAuthModal } from '../Composables/useAuthModal';

defineOptions({
    layout: AppLayout,
});

defineProps({
    message: {
        type: String,
        default: '',
    },
    date: {
        type: String,
        default: '',
    },
});

const page = usePage();
const authUser = computed(() => page.props.auth?.user ?? null);
const { openAuth } = useAuthModal();

const highlights = computed(() => [
    {
        title: 'Global auth modal',
        copy: 'Login and signup are now shared across the full app shell instead of being recreated on each page.',
    },
    {
        title: 'Dashboard for heavy work',
        copy: 'Admin-specific analytics, listings, and management actions have been moved away from the homepage.',
    },
    {
        title: 'Cleaner first impression',
        copy: 'This screen now behaves like a calmer landing page while the rest of the app handles operations.',
    },
]);

const panels = computed(() => [
    {
        copy: 'Use the sidebar and shared layout to move between shopper pages without rebuilding the same chrome.',
        eyebrow: 'Navigation',
        title: 'Reusable shell',
    },
    {
        copy: 'Guests can authenticate from anywhere, while signed-in users keep the same profile entry point across the app.',
        eyebrow: 'Access',
        title: 'Consistent auth',
    },
    {
        copy: authUser.value?.type === 'admin'
            ? 'Your dashboard remains the place for products, users, and operational summaries.'
            : 'Customers stay on the home experience while admin-only operational tools stay out of the way.',
        eyebrow: 'Focus',
        title: 'Right content, right place',
    },
]);

const reloadHome = () => {
    router.reload({ only: ['message', 'date'] });
};
</script>
