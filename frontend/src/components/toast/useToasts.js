import { ref, readonly } from "vue";

const toasts = ref([]);
let idCounter = 0;

const addToast = (message, type = "success", duration = 4000) => {
  const id = idCounter++;
  toasts.value.push({ id, message, type });

  setTimeout(() => {
    removeToast(id);
  }, duration);
};

const removeToast = (id) => {
  toasts.value = toasts.value.filter((toast) => toast.id !== id);
};

export function useToasts() {
  return {
    toasts: readonly(toasts),
    addToast,
    removeToast,
  };
}
