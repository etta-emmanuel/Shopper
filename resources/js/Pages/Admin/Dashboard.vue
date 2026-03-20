<template>
    <div class="space-y-8">
        <section class="grid gap-8 xl:grid-cols-[1.05fr_0.95fr]">
            <div class="rounded-[2rem] border border-white/70 bg-white/85 p-8 shadow-[0_30px_90px_rgba(15,23,42,0.08)] backdrop-blur">
                <p class="inline-flex rounded-full border border-amber-300 bg-amber-50 px-4 py-1 text-xs font-semibold uppercase tracking-[0.28em] text-amber-800">
                    Admin dashboard
                </p>
                <h1 class="mt-5 max-w-4xl text-5xl font-black leading-none tracking-[-0.055em] text-balance sm:text-6xl">
                    Keep products, users, and storefront assets in one clear view.
                </h1>
                <p class="mt-6 max-w-2xl text-base leading-8 text-slate-700 sm:text-lg">
                    This page runs inside the shared app layout, so navigation, profile access, and auth modal behavior stay
                    consistent with the rest of the app.
                </p>

                <div class="mt-10 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                    <div
                        v-for="card in cards"
                        :key="card.label"
                        class="rounded-3xl border border-slate-200/70 bg-white/90 p-5"
                    >
                        <p class="text-3xl font-black tracking-[-0.04em] text-slate-950">{{ card.value }}</p>
                        <p class="mt-2 text-sm text-slate-600">{{ card.label }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded-[2rem] bg-slate-950 p-7 text-white shadow-[0_30px_90px_rgba(15,23,42,0.16)]">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.28em] text-amber-300">Overview</p>
                        <h2 class="mt-2 text-2xl font-bold">What is seeded now</h2>
                    </div>
                    <span class="rounded-full bg-white/10 px-3 py-1 text-xs font-medium text-white/80">Live data</span>
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
            </div>
        </section>

        <section class="grid gap-8 xl:grid-cols-2">
            <div class="rounded-[2rem] border border-white/70 bg-white/85 p-7 shadow-[0_30px_90px_rgba(15,23,42,0.08)] backdrop-blur">
                <div class="flex items-end justify-between gap-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.28em] text-slate-500">Products</p>
                        <h2 class="mt-2 text-3xl font-bold tracking-[-0.03em] text-slate-950">Recent catalog entries</h2>
                    </div>
                    <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-900">
                        {{ recentProducts.length }} shown
                    </span>
                </div>

                <div class="mt-6 space-y-3">
                    <div
                        v-for="product in recentProducts"
                        :key="product.id"
                        class="flex items-center gap-4 rounded-3xl border border-slate-200/80 bg-white/90 p-4"
                    >
                        <div class="flex h-16 w-16 shrink-0 items-center justify-center overflow-hidden rounded-3xl bg-slate-100">
                            <img
                                v-if="product.image"
                                :src="product.image"
                                :alt="product.name"
                                class="h-full w-full object-cover"
                            />
                            <span v-else class="text-xs font-semibold uppercase tracking-[0.28em] text-slate-400">No img</span>
                        </div>

                        <div class="min-w-0 flex-1">
                            <p class="truncate font-semibold text-slate-950">{{ product.name }}</p>
                            <p class="truncate text-sm text-slate-600">{{ product.slug }}</p>
                        </div>

                        <div class="text-right">
                            <p class="text-sm font-semibold text-slate-950">{{ currency(product.base_price) }}</p>
                            <p class="text-xs text-slate-500">Discount: {{ currency(product.discount) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="rounded-[2rem] border border-white/70 bg-white/85 p-7 shadow-[0_30px_90px_rgba(15,23,42,0.08)] backdrop-blur">
                <div class="flex items-end justify-between gap-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.28em] text-slate-500">Users</p>
                        <h2 class="mt-2 text-3xl font-bold tracking-[-0.03em] text-slate-950">Recent people</h2>
                    </div>
                    <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-900">
                        {{ recentUsers.length }} shown
                    </span>
                </div>

                <div class="mt-6 space-y-3">
                    <div
                        v-for="user in recentUsers"
                        :key="user.id"
                        class="flex items-center gap-4 rounded-3xl border border-slate-200/80 bg-white/90 p-4"
                    >
                        <div class="flex h-14 w-14 shrink-0 items-center justify-center overflow-hidden rounded-3xl bg-gradient-to-br from-amber-300 to-orange-500 text-sm font-black text-slate-950">
                            <img
                                v-if="user.image"
                                :src="user.image"
                                :alt="user.name"
                                class="h-full w-full object-cover"
                            />
                            <span v-else>{{ initials(user.name) }}</span>
                        </div>

                        <div class="min-w-0 flex-1">
                            <p class="truncate font-semibold text-slate-950">{{ user.name }}</p>
                            <p class="truncate text-sm text-slate-600">{{ user.email }}</p>
                        </div>

                        <p class="text-right text-xs text-slate-500">{{ user.created_at }}</p>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import AppLayout from '../../Layouts/AppLayout.vue';

defineOptions({
    layout: AppLayout,
});

const props = defineProps({
    recentProducts: {
        type: Array,
        default: () => [],
    },
    recentUsers: {
        type: Array,
        default: () => [],
    },
    stats: {
        type: Object,
        default: () => ({
            averageBasePrice: 0,
            discountedProducts: 0,
            products: 0,
            users: 0,
        }),
    },
});

const cards = computed(() => [
    { label: 'Products in catalog', value: `${props.stats.products}` },
    { label: 'Registered users', value: `${props.stats.users}` },
    { label: 'Discounted products', value: `${props.stats.discountedProducts}` },
    { label: 'Average base price', value: currency(props.stats.averageBasePrice) },
]);

const highlights = computed(() => [
    {
        title: 'Products now have a real catalog table',
        copy: 'Each product carries a name, slug, base price, and a discount value with a default of zero.',
    },
    {
        title: 'Images are polymorphic',
        copy: 'The same image model can now attach to users, products, and any future model through morph relations.',
    },
    {
        title: 'Seed data is richer',
        copy: 'Factories and seeders now produce products, users, and attached images so the dashboard has meaningful content.',
    },
]);

const initials = (name) =>
    name
        ?.split(' ')
        .filter(Boolean)
        .slice(0, 2)
        .map((part) => part[0]?.toUpperCase())
        .join('') || 'UI';

const currency = (value) =>
    new Intl.NumberFormat('en-US', {
        currency: 'USD',
        style: 'currency',
    }).format(Number(value || 0));
</script>
