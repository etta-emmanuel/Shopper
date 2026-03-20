<template>
    <Teleport to="body">
        <div
            v-if="showAuthModal && !authUser"
            class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/65 px-4 backdrop-blur-sm"
        >
            <div class="absolute inset-0" @click="closeAuth"></div>

            <div class="relative w-full max-w-xl rounded-[2rem] border border-white/50 bg-white p-7 shadow-[0_30px_100px_rgba(15,23,42,0.24)]">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.28em] text-slate-500">Account access</p>
                        <h2 class="mt-2 text-3xl font-bold tracking-[-0.04em] text-slate-950">
                            {{ authMode === 'login' ? 'Welcome back' : 'Create your account' }}
                        </h2>
                    </div>
                    <button
                        type="button"
                        class="flex h-10 w-10 items-center justify-center rounded-full border border-slate-200 text-slate-500 transition hover:border-slate-950 hover:text-slate-950"
                        @click="closeAuth"
                    >
                        X
                    </button>
                </div>

                <div class="mt-6 inline-flex rounded-full border border-slate-200 bg-slate-100 p-1">
                    <button
                        type="button"
                        class="rounded-full px-4 py-2 text-sm font-semibold transition"
                        :class="authMode === 'login' ? 'bg-slate-950 text-white' : 'text-slate-600'"
                        @click="openAuth('login')"
                    >
                        Login
                    </button>
                    <button
                        type="button"
                        class="rounded-full px-4 py-2 text-sm font-semibold transition"
                        :class="authMode === 'register' ? 'bg-slate-950 text-white' : 'text-slate-600'"
                        @click="openAuth('register')"
                    >
                        Sign up
                    </button>
                </div>

                <LoginForm v-if="authMode === 'login'" class="mt-6" @success="closeAuth" />
                <RegisterForm v-else class="mt-6" @success="closeAuth" />
            </div>
        </div>
    </Teleport>
</template>

<script setup>
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import LoginForm from './LoginForm.vue';
import RegisterForm from './RegisterForm.vue';
import { useAuthModal } from '../../Composables/useAuthModal';

const page = usePage();
const authUser = computed(() => page.props.auth?.user ?? null);
const { authMode, closeAuth, openAuth, showAuthModal } = useAuthModal();
</script>
