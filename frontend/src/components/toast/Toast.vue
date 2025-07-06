<script setup>
import { useToasts } from "./useToasts";
import { CheckCircle, XCircle, AlertTriangle, X } from "lucide-vue-next";

const { toasts, removeToast } = useToasts();

const toastSettings = {
  success: {
    icon: CheckCircle,
    classes: "bg-green-500 border-green-600",
  },
  error: {
    icon: XCircle,
    classes: "bg-red-500 border-red-600",
  },
  warning: {
    icon: AlertTriangle,
    classes: "bg-yellow-500 border-yellow-600",
  },
};

const getToastSettings = (type) => {
  return toastSettings[type] || toastSettings.success;
};
</script>

<template>
  <div class="fixed bottom-5 right-5 z-50 w-full max-w-sm space-y-3">
    <transition-group name="toast-fade" tag="div">
      <div
        v-for="toast in toasts"
        :key="toast.id"
        class="flex items-center text-white p-4 rounded-lg shadow-lg border-b-4"
        :class="getToastSettings(toast.type).classes"
      >
        <component
          :is="getToastSettings(toast.type).icon"
          class="h-6 w-6 mr-3 flex-shrink-0"
        />
        <span class="flex-1">{{ toast.message }}</span>
        <button
          @click="removeToast(toast.id)"
          class="ml-4 p-1 rounded-full hover:bg-black/20"
        >
          <X class="h-4 w-4" />
        </button>
      </div>
    </transition-group>
  </div>
</template>

<style scoped>
.toast-fade-enter-active,
.toast-fade-leave-active {
  transition: all 0.4s ease;
}
.toast-fade-enter-from,
.toast-fade-leave-to {
  opacity: 0;
  transform: translateX(100%);
}
</style>
