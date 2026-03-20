<template>
    <div class="space-y-8">
        <section class="grid gap-8 xl:grid-cols-[1.1fr_0.9fr]">
            <div class="rounded-[2rem] border border-white/70 bg-white/80 p-8 shadow-[0_30px_90px_rgba(15,23,42,0.08)] backdrop-blur xl:p-10">
                <p class="inline-flex rounded-full border border-amber-300 bg-amber-50 px-4 py-1 text-xs font-semibold uppercase tracking-[0.28em] text-amber-800">
                    Shopper control center
                </p>

                <h1 class="mt-5 max-w-4xl text-5xl font-black leading-none tracking-[-0.055em] text-balance sm:text-6xl">
                    Premium storefront energy, now inside a reusable app shell.
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
                    <button
                        v-else
                        type="button"
                        class="inline-flex items-center justify-center rounded-full bg-slate-950 px-6 py-3 text-sm font-semibold text-white transition hover:bg-slate-800"
                        @click="scrollToManager"
                    >
                        Manage users
                    </button>
                    <button
                        type="button"
                        class="inline-flex items-center justify-center rounded-full border border-slate-300 bg-white px-6 py-3 text-sm font-semibold text-slate-800 transition hover:border-slate-950"
                        @click="authUser ? refreshUsers() : openAuth('login')"
                    >
                        {{ authUser ? 'Refresh data' : 'Login' }}
                    </button>
                </div>

                <div class="mt-10 grid gap-4 sm:grid-cols-3">
                    <div
                        v-for="stat in stats"
                        :key="stat.label"
                        class="rounded-3xl border border-slate-200/70 bg-white/90 p-5"
                    >
                        <p class="text-3xl font-black tracking-[-0.04em] text-slate-950">{{ stat.value }}</p>
                        <p class="mt-2 text-sm text-slate-600">{{ stat.label }}</p>
                    </div>
                </div>
            </div>

            <div class="grid gap-6">
                <section class="rounded-[2rem] bg-slate-950 p-7 text-white shadow-[0_30px_90px_rgba(15,23,42,0.16)]">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-amber-300">Shared access</p>
                            <h2 class="mt-2 text-2xl font-bold">Global auth modal</h2>
                        </div>
                        <span class="rounded-full bg-white/10 px-3 py-1 text-xs font-medium text-white/80">
                            {{ authUser ? 'Authenticated' : 'Guest' }}
                        </span>
                    </div>

                    <div class="mt-6 space-y-4">
                        <div
                            v-for="(step, index) in highlights"
                            :key="step.title"
                            class="rounded-3xl border border-white/10 bg-white/5 p-4"
                        >
                            <div class="flex items-start gap-4">
                                <span class="flex h-9 w-9 items-center justify-center rounded-full bg-amber-400 text-sm font-bold text-slate-950">
                                    0{{ index + 1 }}
                                </span>
                                <div>
                                    <p class="font-semibold">{{ step.title }}</p>
                                    <p class="mt-1 text-sm leading-6 text-white/70">{{ step.copy }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="rounded-[2rem] border border-white/70 bg-white/80 p-7 shadow-[0_30px_90px_rgba(15,23,42,0.08)] backdrop-blur">
                    <div class="flex items-end justify-between gap-4">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-slate-500">Today</p>
                            <h2 class="mt-2 text-2xl font-bold text-slate-950">System snapshot</h2>
                        </div>
                        <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-900">
                            {{ date }}
                        </span>
                    </div>

                    <div v-if="selectedUser" class="mt-6">
                        <div class="flex items-center gap-4">
                            <div class="flex h-16 w-16 items-center justify-center rounded-3xl bg-gradient-to-br from-amber-300 via-orange-400 to-rose-500 text-lg font-black text-slate-950">
                                {{ initials(selectedUser.name) }}
                            </div>
                            <div class="min-w-0">
                                <p class="truncate text-2xl font-bold text-slate-950">{{ selectedUser.name }}</p>
                                <p class="truncate text-sm text-slate-600">{{ selectedUser.email }}</p>
                            </div>
                        </div>

                        <div class="mt-6 rounded-3xl bg-slate-950/[0.04] p-4 text-sm leading-7 text-slate-700">
                            The user detail card is still being hydrated through the API. The difference now is that auth and
                            navigation live in the shared layout instead of this page.
                        </div>
                    </div>
                    <p v-else class="mt-6 text-sm text-slate-600">
                        No users yet. Sign up or create the first record from the manager below.
                    </p>
                </section>
            </div>
        </section>

        <section
            id="manager"
            class="grid gap-8 xl:grid-cols-[0.92fr_1.08fr]"
        >
            <div class="rounded-[2rem] border border-white/70 bg-white/80 p-7 shadow-[0_30px_90px_rgba(15,23,42,0.08)] backdrop-blur">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.28em] text-slate-500">Workspace access</p>
                        <h2 class="mt-2 text-3xl font-bold tracking-[-0.03em] text-slate-950">
                            {{ authUser ? 'Signed-in workspace' : 'Authentication required' }}
                        </h2>
                    </div>
                    <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-900">
                        {{ authUser ? 'Ready' : 'Guest mode' }}
                    </span>
                </div>

                <div class="mt-6 rounded-3xl border border-slate-200/80 bg-white/90 p-5">
                    <template v-if="authUser">
                        <p class="text-sm text-slate-600">Signed in as</p>
                        <p class="mt-2 text-2xl font-bold text-slate-950">{{ authUser.name }}</p>
                        <p class="text-sm text-slate-600">{{ authUser.email }}</p>
                        <p class="mt-4 text-sm leading-7 text-slate-700">
                            This page can still create, inspect, update, and delete users through the JSON API, but the profile
                            icon and auth flow are now reusable across the full app layout.
                        </p>
                    </template>

                    <template v-else>
                        <p class="text-sm leading-7 text-slate-700">
                            The profile icon in the shared layout opens the auth modal from anywhere. Use it here too when a guest
                            needs to continue into a protected workflow.
                        </p>

                        <div class="mt-5 flex flex-col gap-3 sm:flex-row">
                            <button
                                type="button"
                                class="inline-flex items-center justify-center rounded-full bg-slate-950 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800"
                                @click="openAuth('login')"
                            >
                                Login
                            </button>
                            <button
                                type="button"
                                class="inline-flex items-center justify-center rounded-full border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-800 transition hover:border-slate-950"
                                @click="openAuth('register')"
                            >
                                Sign up
                            </button>
                        </div>
                    </template>
                </div>

                <div class="mt-6 rounded-3xl bg-slate-950 p-5 text-white">
                    <div class="flex items-center justify-between gap-4">
                        <p class="text-lg font-semibold">User API status</p>
                        <button
                            type="button"
                            class="rounded-full bg-white/10 px-3 py-1 text-xs font-semibold text-white/85"
                            :disabled="loadingUsers"
                            @click="refreshUsers"
                        >
                            {{ loadingUsers ? 'Refreshing...' : 'Refresh' }}
                        </button>
                    </div>
                    <p class="mt-3 text-sm leading-7 text-white/70">
                        Uses `/api/users` for list refreshes and user mutations while the layout handles shared app chrome.
                    </p>
                    <p v-if="apiNotice" class="mt-4 text-sm font-medium text-amber-300">{{ apiNotice }}</p>
                </div>
            </div>

            <div class="rounded-[2rem] border border-white/70 bg-white/80 p-7 shadow-[0_30px_90px_rgba(15,23,42,0.08)] backdrop-blur">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.28em] text-slate-500">User manager</p>
                        <h2 class="mt-2 text-3xl font-bold tracking-[-0.03em] text-slate-950">
                            {{ formModeLabel }}
                        </h2>
                    </div>
                    <button
                        v-if="isEditing"
                        type="button"
                        class="inline-flex items-center justify-center rounded-full border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-800 transition hover:border-slate-950"
                        @click="resetUserForm"
                    >
                        Cancel edit
                    </button>
                </div>

                <form class="mt-6 grid gap-4 md:grid-cols-2" @submit.prevent="saveUser">
                    <label class="block">
                        <span class="mb-2 block text-sm font-medium text-slate-700">Name</span>
                        <input
                            v-model="userForm.name"
                            type="text"
                            class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-slate-950"
                            :disabled="!authUser || userForm.processing"
                            placeholder="Jane Doe"
                        />
                        <span v-if="userForm.errors.name" class="mt-2 block text-sm text-rose-600">
                            {{ userForm.errors.name }}
                        </span>
                    </label>

                    <label class="block">
                        <span class="mb-2 block text-sm font-medium text-slate-700">Email</span>
                        <input
                            v-model="userForm.email"
                            type="email"
                            class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-slate-950"
                            :disabled="!authUser || userForm.processing"
                            placeholder="jane@example.com"
                        />
                        <span v-if="userForm.errors.email" class="mt-2 block text-sm text-rose-600">
                            {{ userForm.errors.email }}
                        </span>
                    </label>

                    <label class="block">
                        <span class="mb-2 block text-sm font-medium text-slate-700">
                            Password {{ isEditing ? '(optional)' : '' }}
                        </span>
                        <input
                            v-model="userForm.password"
                            type="password"
                            class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-slate-950"
                            :disabled="!authUser || userForm.processing"
                            placeholder="Minimum 8 characters"
                        />
                        <span v-if="userForm.errors.password" class="mt-2 block text-sm text-rose-600">
                            {{ userForm.errors.password }}
                        </span>
                    </label>

                    <label class="block">
                        <span class="mb-2 block text-sm font-medium text-slate-700">Confirm password</span>
                        <input
                            v-model="userForm.password_confirmation"
                            type="password"
                            class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-slate-950"
                            :disabled="!authUser || userForm.processing"
                            placeholder="Repeat password"
                        />
                    </label>

                    <div class="md:col-span-2 flex flex-col gap-3 sm:flex-row">
                        <button
                            type="submit"
                            class="inline-flex items-center justify-center rounded-full bg-slate-950 px-6 py-3 text-sm font-semibold text-white transition hover:bg-slate-800 disabled:cursor-not-allowed disabled:bg-slate-400"
                            :disabled="!authUser || userForm.processing"
                        >
                            {{ userForm.processing ? 'Saving...' : isEditing ? 'Update user' : 'Create user' }}
                        </button>
                        <button
                            type="button"
                            class="inline-flex items-center justify-center rounded-full border border-slate-300 bg-white px-6 py-3 text-sm font-semibold text-slate-800 transition hover:border-slate-950 disabled:cursor-not-allowed disabled:opacity-50"
                            :disabled="!authUser || loadingUsers"
                            @click="refreshUsers"
                        >
                            Reload users
                        </button>
                    </div>
                </form>

                <div class="mt-8 space-y-3">
                    <button
                        v-for="user in userRecords"
                        :key="user.id"
                        type="button"
                        class="flex w-full items-center gap-4 rounded-3xl border border-slate-200/80 bg-white/90 px-4 py-4 text-left transition hover:border-slate-950"
                        @click="showUser(user.id)"
                    >
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-amber-300 to-orange-500 text-sm font-black text-slate-950">
                            {{ initials(user.name) }}
                        </div>

                        <div class="min-w-0 flex-1">
                            <p class="truncate font-semibold text-slate-950">{{ user.name }}</p>
                            <p class="truncate text-sm text-slate-600">{{ user.email }}</p>
                        </div>

                        <div
                            v-if="authUser"
                            class="flex shrink-0 items-center gap-2"
                            @click.stop
                        >
                            <button
                                type="button"
                                class="rounded-full border border-slate-300 px-3 py-2 text-xs font-semibold text-slate-700 transition hover:border-slate-950"
                                @click="editUser(user.id)"
                            >
                                Edit
                            </button>
                            <button
                                type="button"
                                class="rounded-full border border-rose-200 bg-rose-50 px-3 py-2 text-xs font-semibold text-rose-700 transition hover:border-rose-400"
                                @click="deleteUser(user.id)"
                            >
                                Delete
                            </button>
                        </div>
                    </button>

                    <div
                        v-if="!userRecords.length"
                        class="rounded-3xl border border-dashed border-slate-300 bg-white/70 px-5 py-6 text-sm text-slate-600"
                    >
                        No users found yet.
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script setup>
import axios from 'axios';
import { computed, reactive, ref } from 'vue';
import { usePage } from '@inertiajs/vue3';
import AppLayout from '../Layouts/AppLayout.vue';
import { useAuthModal } from '../Composables/useAuthModal';

defineOptions({
    layout: AppLayout,
});

const props = defineProps({
    message: {
        type: String,
        default: '',
    },
    users: {
        type: Array,
        default: () => [],
    },
    date: {
        type: String,
        default: '',
    },
});

const page = usePage();
const authUser = computed(() => page.props.auth?.user ?? null);
const { openAuth } = useAuthModal();

const loadingUsers = ref(false);
const apiNotice = ref('');
const selectedUser = ref(props.users[0] ?? null);
const userRecords = ref([...props.users]);

const userForm = reactive({
    email: '',
    errors: {},
    id: null,
    name: '',
    password: '',
    password_confirmation: '',
    processing: false,
});

const stats = computed(() => [
    { value: authUser.value ? 'Live' : 'Guest', label: 'Profile access comes from the layout shell' },
    { value: `${userRecords.value.length}`, label: 'Users currently visible on the page' },
    { value: 'Global', label: 'Login and signup can now be triggered anywhere' },
]);

const highlights = computed(() => [
    {
        title: 'Profile icon moved to layout',
        copy: 'Authentication entry no longer belongs to a single page, so every screen can use the same trigger.',
    },
    {
        title: 'Sidebar is reusable',
        copy: 'The left navigation now lives in a shared layout and collapses responsively instead of being rebuilt per page.',
    },
    {
        title: 'Home focuses on content',
        copy: 'This page keeps the dashboard and API manager, while shared chrome and auth handling stay outside it.',
    },
]);

const isEditing = computed(() => Boolean(userForm.id));
const formModeLabel = computed(() => (isEditing.value ? 'Edit existing user' : 'Create a new user'));

const initials = (name) =>
    name
        ?.split(' ')
        .filter(Boolean)
        .slice(0, 2)
        .map((part) => part[0]?.toUpperCase())
        .join('') || 'UI';

const resetUserForm = () => {
    userForm.id = null;
    userForm.name = '';
    userForm.email = '';
    userForm.password = '';
    userForm.password_confirmation = '';
    userForm.errors = {};
    userForm.processing = false;
};

const refreshUsers = async () => {
    loadingUsers.value = true;
    apiNotice.value = '';

    try {
        const response = await axios.get('/api/users');
        userRecords.value = response.data.data;
        selectedUser.value = userRecords.value[0] ?? null;
        apiNotice.value = 'User list refreshed from the API.';
    } catch (error) {
        apiNotice.value = error.response?.data?.message || 'Unable to refresh users right now.';
    } finally {
        loadingUsers.value = false;
    }
};

const showUser = async (userId) => {
    try {
        const response = await axios.get(`/api/users/${userId}`);
        selectedUser.value = response.data.data;
    } catch (error) {
        apiNotice.value = error.response?.data?.message || 'Unable to load that user.';
    }
};

const editUser = async (userId) => {
    try {
        const response = await axios.get(`/api/users/${userId}/edit`);
        const user = response.data.data;

        userForm.id = user.id;
        userForm.name = user.name;
        userForm.email = user.email;
        userForm.password = '';
        userForm.password_confirmation = '';
        userForm.errors = {};

        selectedUser.value = user;
        scrollToManager();
    } catch (error) {
        apiNotice.value = error.response?.data?.message || 'Unable to open that user for editing.';
    }
};

const saveUser = async () => {
    if (!authUser.value) {
        openAuth('login');
        return;
    }

    userForm.processing = true;
    userForm.errors = {};
    apiNotice.value = '';

    const payload = {
        email: userForm.email,
        name: userForm.name,
        password: userForm.password,
        password_confirmation: userForm.password_confirmation,
    };

    try {
        const response = isEditing.value
            ? await axios.put(`/api/users/${userForm.id}`, payload)
            : await axios.post('/api/users', payload);

        const user = response.data.data;

        if (isEditing.value) {
            userRecords.value = userRecords.value.map((record) => (record.id === user.id ? user : record));
            apiNotice.value = 'User updated through the API.';
        } else {
            userRecords.value = [user, ...userRecords.value];
            apiNotice.value = 'User created through the API.';
        }

        selectedUser.value = user;
        resetUserForm();
    } catch (error) {
        if (error.response?.status === 422) {
            userForm.errors = Object.fromEntries(
                Object.entries(error.response.data.errors).map(([key, value]) => [key, value[0]])
            );
        } else {
            apiNotice.value = error.response?.data?.message || 'Unable to save the user right now.';
        }
    } finally {
        userForm.processing = false;
    }
};

const deleteUser = async (userId) => {
    if (!authUser.value) {
        openAuth('login');
        return;
    }

    if (!window.confirm('Delete this user?')) {
        return;
    }

    try {
        await axios.delete(`/api/users/${userId}`);
        userRecords.value = userRecords.value.filter((record) => record.id !== userId);

        if (selectedUser.value?.id === userId) {
            selectedUser.value = userRecords.value[0] ?? null;
        }

        if (userForm.id === userId) {
            resetUserForm();
        }

        apiNotice.value = 'User deleted through the API.';
    } catch (error) {
        apiNotice.value = error.response?.data?.message || 'Unable to delete that user right now.';
    }
};

const scrollToManager = () => {
    document.getElementById('manager')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
};
</script>
