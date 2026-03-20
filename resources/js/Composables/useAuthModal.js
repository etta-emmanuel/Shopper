import { ref } from 'vue';

const showAuthModal = ref(false);
const authMode = ref('login');

export function useAuthModal() {
    const openAuth = (mode = 'login') => {
        authMode.value = mode;
        showAuthModal.value = true;
    };

    const closeAuth = () => {
        showAuthModal.value = false;
    };

    return {
        authMode,
        closeAuth,
        openAuth,
        showAuthModal,
    };
}
