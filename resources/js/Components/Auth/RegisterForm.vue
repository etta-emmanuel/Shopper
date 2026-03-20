<template>
    <form class="grid gap-4" @submit.prevent="submit">
        <label class="block">
            <span class="mb-2 block text-sm font-medium text-slate-700">Name</span>
            <input
                v-model="registerForm.name"
                type="text"
                class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-slate-950"
                placeholder="Jane Doe"
            />
            <span v-if="registerForm.errors.name" class="mt-2 block text-sm text-rose-600">
                {{ registerForm.errors.name }}
            </span>
        </label>

        <label class="block">
            <span class="mb-2 block text-sm font-medium text-slate-700">Email</span>
            <input
                v-model="registerForm.email"
                type="email"
                class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-slate-950"
                placeholder="jane@example.com"
            />
            <span v-if="registerForm.errors.email" class="mt-2 block text-sm text-rose-600">
                {{ registerForm.errors.email }}
            </span>
        </label>

        <label class="block">
            <span class="mb-2 block text-sm font-medium text-slate-700">Password</span>
            <input
                v-model="registerForm.password"
                type="password"
                class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-slate-950"
                placeholder="Create a password"
            />
            <span v-if="registerForm.errors.password" class="mt-2 block text-sm text-rose-600">
                {{ registerForm.errors.password }}
            </span>
        </label>

        <label class="block">
            <span class="mb-2 block text-sm font-medium text-slate-700">Confirm password</span>
            <input
                v-model="registerForm.password_confirmation"
                type="password"
                class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-slate-950"
                placeholder="Repeat your password"
            />
        </label>

        <button
            type="submit"
            class="inline-flex w-full items-center justify-center rounded-full bg-slate-950 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800"
            :disabled="registerForm.processing"
        >
            {{ registerForm.processing ? 'Creating account...' : 'Sign up' }}
        </button>
    </form>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';

const emit = defineEmits(['success']);

const registerForm = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    registerForm.post('/register', {
        preserveScroll: true,
        onSuccess: () => {
            registerForm.reset();
            emit('success');
        },
    });
};
</script>
