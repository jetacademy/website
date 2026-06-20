import { ref, readonly } from 'vue';
import axios from 'axios';

const currentUser = ref(null);
const isAuthenticated = ref(false);
const isLoading = ref(true);
const roles = ref([]);

let fetchPromise = null;

export function useAuth() {
    const fetchUser = async (force = false) => {
        if (!force && fetchPromise) return fetchPromise;

        fetchPromise = (async () => {
            isLoading.value = true;
            try {
                const res = await axios.get('/api/me');
                if (res.data.user) {
                    currentUser.value = res.data.user;
                    roles.value = res.data.user.role_names || [];
                    isAuthenticated.value = true;
                } else {
                    currentUser.value = null;
                    roles.value = [];
                    isAuthenticated.value = false;
                }
            } catch (e) {
                currentUser.value = null;
                roles.value = [];
                isAuthenticated.value = false;
            } finally {
                isLoading.value = false;
            }
        })();

        return fetchPromise;
    };

    const login = async (email, password) => {
        const response = await axios.post('/api/login', { email, password });
        if (response.data.success) {
            await fetchUser(true);
            return { success: true };
        }
        return { success: false, message: response.data.message };
    };

    const logout = async () => {
        try {
            await axios.post('/api/logout');
        } catch (e) { /* ignore */ }
        currentUser.value = null;
        roles.value = [];
        isAuthenticated.value = false;
        fetchPromise = null;
    };

    const hasRole = (roleName) => {
        return roles.value.includes(roleName);
    };

    const isAdmin = () => {
        return hasRole('Super Admin') || hasRole('Admin');
    };

    return {
        currentUser: readonly(currentUser),
        isAuthenticated: readonly(isAuthenticated),
        isLoading: readonly(isLoading),
        roles: readonly(roles),
        fetchUser,
        login,
        logout,
        hasRole,
        isAdmin,
    };
}
