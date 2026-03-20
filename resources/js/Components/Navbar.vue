<template>
    <aside
        class="flex h-full flex-col border-r border-white/10 bg-slate-950 text-white"
        :class="collapsed ? 'md:w-24' : 'md:w-72'"
    >
        <div class="flex items-center gap-3 border-b border-white/10 px-5 py-6">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-amber-300 via-orange-400 to-rose-500 text-sm font-black text-slate-950">
                SH
            </div>
            <div v-if="!collapsed" class="min-w-0">
                <p class="text-xs font-semibold uppercase tracking-[0.32em] text-amber-300">Shopper</p>
                <p class="mt-1 text-sm text-white/65">Retail workspace</p>
            </div>
        </div>

        <nav class="flex-1 px-4 py-6">
            <p v-if="!collapsed" class="px-3 text-xs font-semibold uppercase tracking-[0.28em] text-white/40">Navigation</p>

            <div class="mt-3 space-y-2">
                <Link
                    v-for="item in items"
                    :key="item.label"
                    :href="item.href"
                    class="flex items-center gap-3 rounded-2xl px-3 py-3 text-sm font-medium transition"
                    :class="isActive(item.href) ? 'bg-white/10 text-white' : 'text-white/70 hover:bg-white/5 hover:text-white'"
                    @click="$emit('navigate')"
                >
                    <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-white/10 text-xs font-bold text-amber-300">
                        {{ item.icon }}
                    </span>
                    <div v-if="!collapsed" class="min-w-0">
                        <p>{{ item.label }}</p>
                        <p class="text-xs text-white/45">{{ item.copy }}</p>
                    </div>
                </Link>
            </div>
        </nav>

        <div v-if="!collapsed" class="m-4 rounded-[1.75rem] border border-white/10 bg-white/5 p-4">
            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-white/40">Status</p>
            <p class="mt-3 text-lg font-semibold">Auth modal is global now.</p>
            <p class="mt-2 text-sm leading-6 text-white/60">
                Any page using the shared layout can trigger login or signup without re-implementing the UI.
            </p>
        </div>
    </aside>
</template>

<script setup>
import { computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';

defineEmits(['navigate']);

defineProps({
    collapsed: {
        type: Boolean,
        default: false,
    },
});

const page = usePage();
const authUser = computed(() => page.props.auth?.user ?? null);

const items = computed(() => {
    const links = [
        {
            copy: 'Landing and dashboard overview',
            href: '/',
            icon: 'HM',
            label: 'Home',
        },
    ];

    if (authUser.value) {
        links.push({
            copy: 'Catalog and user admin snapshot',
            href: '/admin/dashboard',
            icon: 'AD',
            label: 'Admin',
        });
    }

    return links;
});

const isActive = (href) => page.url === href || page.url.startsWith(`${href}#`);
</script>
