<template>
    <aside
        class="flex h-full flex-col border-r border-white/10 bg-slate-950 text-white"
        :class="collapsed ? 'md:w-24' : 'md:w-72'"
    >
        <div class="flex items-center gap-3 border-b border-white/10 px-5 py-6">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-linear-to-br from-amber-300 via-orange-400 to-rose-500 text-sm font-black text-slate-950">
                SH
            </div>
            <div v-if="!collapsed" class="min-w-0">
                <p class="text-xs font-semibold uppercase tracking-[0.32em] text-amber-300">Shopper</p>
                <p class="mt-1 text-sm text-white/65">Retail workspace</p>
            </div>
        </div>

        <nav class="flex-1 px-4 py-6">
            <p v-if="!collapsed" class="px-3 text-xs font-semibold uppercase tracking-[0.28em] text-white/40">Navigation</p>
            <div v-if="!collapsed" class="mt-6 inline-flex rounded-full bg-amber-100 px-4 py-2 text-sm font-semibold text-amber-900">
                {{ date }} • {{ time }}
            </div>

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
                        <i :class="[item.icon, 'text-lg']"></i>
                    </span>
                    <div v-if="!collapsed" class="min-w-0">
                        <p>{{ item.label }}</p>
<!--                        <p class="text-xs text-white/45">{{ item.copy }}</p>-->
                    </div>
                </Link>
            </div>
        </nav>

        <div :class="['m-4 rounded-[1.75rem] border border-white/10 bg-white/5 p-4', showLogout]"
        >
            <button
                type="button"
                class="inline-flex w-full items-center justify-center rounded-full bg-slate-950 px-4 py-3 text-sm font-semibold text-white transition hover:bg-slate-800"
                :class="collapsed ? 'text-xs' : ''"
                :disabled="logoutForm.processing"
                @click="logout"
            >
                Sign out
            </button>
        </div>
    </aside>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue';
import { Link, usePage, useForm} from '@inertiajs/vue3';

defineEmits(['navigate']);

defineProps({
    collapsed: {
        type: Boolean,
        default: false,
    },
});

const page = usePage();
const date = ref('');
const time = ref('');
onMounted(() => {
    const now = new Date();
    time.value = now.toLocaleTimeString();
    date.value = now.toDateString();
});
const authUser = computed(() => page.props.auth?.user ?? null);
const showLogout = computed(() => authUser.value ? '' : 'hidden');
const items = computed(() => page.props.navItems ?? []);
const logoutForm = useForm({});

const logout = () => {
    logoutForm.post('/logout', {
        preserveScroll: true,
        onSuccess: () => {
            window.location.reload();
            toast.show;
        },
    });
};

const isActive = (href) => page.url === href || page.url.startsWith(`${href}#`);
</script>
