<template>
    <div class="min-h-screen bg-[linear-gradient(160deg,#fff7ed_0%,#ffedd5_24%,#f8fafc_65%,#e2e8f0_100%)] text-slate-950">
        <div v-if="mobileSidebarOpen" class="fixed inset-0 z-40 bg-slate-950/55 backdrop-blur-sm md:hidden" @click="mobileSidebarOpen = false"></div>

        <div class="relative flex min-h-screen">
            <div
                class="fixed inset-y-0 left-0 z-50 transition duration-300 md:static"
                :class="[
                    mobileSidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0',
                    sidebarCollapsed ? 'w-72 md:w-24' : 'w-72',
                ]"
            >
                <Navbar :collapsed="sidebarCollapsed" @navigate="mobileSidebarOpen = false" />
            </div>

            <div class="flex min-h-screen min-w-0 flex-1 flex-col">
                <header class="sticky top-0 z-30 border-b border-slate-200/70 bg-white/70 px-4 py-4 backdrop-blur md:px-8">
                    <div class="flex items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <button
                                type="button"
                                class="flex h-11 w-11 items-center justify-center rounded-2xl border border-slate-200 bg-white text-slate-700 transition hover:border-slate-950 md:hidden"
                                @click="mobileSidebarOpen = true"
                            >
                                ≡
                            </button>
                            <button
                                type="button"
                                class="hidden h-11 items-center justify-center rounded-2xl border border-slate-200 bg-white px-4 text-sm font-semibold text-slate-700 transition hover:border-slate-950 md:inline-flex"
                                @click="sidebarCollapsed = !sidebarCollapsed"
                            >
                                {{ sidebarCollapsed ? 'Expand' : 'Collapse' }}
                            </button>
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-slate-500">Workspace</p>
                                <p class="text-sm text-slate-700">Shared shell with reusable auth access</p>
                            </div>
                        </div>

                        <div class="relative">
                            <button
                                type="button"
                                class="flex h-12 w-12 items-center justify-center rounded-full border border-slate-200 bg-slate-950 text-white shadow-lg transition hover:scale-105"
                                @click="toggleProfile"
                            >
                                <span class="text-sm font-black">
                                    {{ authUser ? initials(authUser.name) : 'UI' }}
                                </span>
                            </button>

                            <div
                                v-if="showProfileMenu && authUser"
                                class="absolute right-0 top-16 z-30 w-72 rounded-3xl border border-slate-200 bg-white p-5 shadow-[0_30px_90px_rgba(15,23,42,0.18)]"
                            >
                                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-slate-500">Signed in</p>
                                <p class="mt-2 text-lg font-bold text-slate-950">{{ authUser.name }}</p>
                                <p class="text-sm text-slate-600">{{ authUser.email }}</p>

                                <div class="mt-5 grid gap-3">
                                    <button
                                        type="button"
                                        class="inline-flex w-full items-center justify-center rounded-full border border-slate-300 bg-white px-4 py-3 text-sm font-semibold text-slate-800 transition hover:border-slate-950"
                                        @click="showProfileMenu = false"
                                    >
                                        Close menu
                                    </button>
                                    <button
                                        type="button"
                                        class="inline-flex w-full items-center justify-center rounded-full bg-slate-950 px-4 py-3 text-sm font-semibold text-white transition hover:bg-slate-800"
                                        :disabled="logoutForm.processing"
                                        @click="logout"
                                    >
                                        Sign out
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>

                <main class="min-w-0 flex-1 px-4 py-6 md:px-8 md:py-8">
                    <slot />
                </main>
            </div>
        </div>

        <AuthModal />
    </div>
</template>

<script setup>
import { computed, ref } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import AuthModal from '../Components/Auth/AuthModal.vue';
import Navbar from '../Components/Navbar.vue';
import { useAuthModal } from '../Composables/useAuthModal';

const page = usePage();
const authUser = computed(() => page.props.auth?.user ?? null);
const authType = authUser.value?.type;
const logoutForm = useForm({});
const mobileSidebarOpen = ref(false);
const showProfileMenu = ref(false);
const sidebarCollapsed = ref(false);

const { openAuth } = useAuthModal();

const initials = (name) =>
    name
        ?.split(' ')
        .filter(Boolean)
        .slice(0, 2)
        .map((part) => part[0]?.toUpperCase())
        .join('') || 'UI';

const toggleProfile = () => {
    if (authUser.value) {
        showProfileMenu.value = !showProfileMenu.value;
        return;
    }

    openAuth('login');
};

const logout = () => {
    logoutForm.post('/logout', {
        preserveScroll: true,
        onSuccess: () => {
            showProfileMenu.value = false;
        },
    });
};
</script>
