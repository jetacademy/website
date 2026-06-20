import { reactive } from 'vue';

const state = reactive({ toasts: [], nextId: 0 });

export function useToast() {
    const show = (message, type = 'info', duration = 3500) => {
        const id = state.nextId++;
        state.toasts.push({ id, message, type });
        setTimeout(() => remove(id), duration);
    };

    const remove = (id) => {
        const idx = state.toasts.findIndex(t => t.id === id);
        if (idx > -1) state.toasts.splice(idx, 1);
    };

    const success = (msg) => show(msg, 'success');
    const error = (msg) => show(msg, 'error');
    const info = (msg) => show(msg, 'info');

    return { toasts: state.toasts, show, remove, success, error, info };
}
