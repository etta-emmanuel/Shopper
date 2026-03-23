<script setup>
    import { useForm, usePage } from '@inertiajs/vue3';

    const emit = defineEmits(['success']);

    const page = usePage();

    const loginForm = useForm({
        email: '',
        password: '',
        remember: false,
    });

    const submit = () => {
        loginForm.post('/sign-in', {
            preserveScroll: true,
            onSuccess: () => {
                loginForm.reset('password');
                emit('success');
            },
        });
    };
</script>

<template>
    <form class="space-y-4" @submit.prevent="submit">
        <label class="block">
            <span class="mb-2 block text-sm font-medium text-slate-700">Email</span>
            <input
                v-model="loginForm.email"
                type="email"
                class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-slate-950"
                placeholder="jane@example.com"
            />
            <span v-if="loginForm.errors.email" class="mt-2 block text-sm text-rose-600">
                {{ loginForm.errors.email }}
            </span>
        </label>

        <label class="block">
            <span class="mb-2 block text-sm font-medium text-slate-700">Password</span>
            <input
                v-model="loginForm.password"
                type="password"
                class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-slate-950"
                placeholder="Your password"
            />
            <span v-if="loginForm.errors.password" class="mt-2 block text-sm text-rose-600">
                {{ loginForm.errors.password }}
            </span>
            <span v-if="page.props.errors?.login" class="mt-2 block text-sm text-rose-600">
                {{ page.props.errors.login }}
            </span>
        </label>

        <label class="flex items-center gap-3 text-sm text-slate-600">
            <input v-model="loginForm.remember" type="checkbox" class="h-4 w-4 rounded border-slate-300" />
            Keep me signed in
        </label>

        <button
            type="submit"
            class="inline-flex w-full items-center justify-center rounded-full bg-slate-950 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800"
            :disabled="loginForm.processing"
        >
            {{ loginForm.processing ? 'Logging in...' : 'Login' }}
        </button>
    </form>
</template>

