<template>
  <Teleport to="body">
    <TransitionGroup name="toast" tag="div" class="toast-container">
      <div v-for="t in toasts" :key="t.id" :class="['toast-item', 'toast-' + t.type]" @click="remove(t.id)">
        <span class="toast-icon" v-if="t.type === 'success'">✓</span>
        <span class="toast-icon" v-else-if="t.type === 'error'">✕</span>
        <span class="toast-icon" v-else>ℹ</span>
        <span class="toast-msg">{{ t.message }}</span>
      </div>
    </TransitionGroup>
  </Teleport>
</template>

<script setup>
import { useToast } from '../composables/useToast';
const { toasts, remove } = useToast();
</script>

<style>
.toast-container {
  position: fixed;
  top: 20px;
  right: 20px;
  z-index: 99999;
  display: flex;
  flex-direction: column;
  gap: 10px;
  pointer-events: none;
}
.toast-item {
  pointer-events: auto;
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 14px 20px;
  border-radius: 12px;
  font-size: 0.9rem;
  font-weight: 600;
  font-family: 'Inter', sans-serif;
  cursor: pointer;
  min-width: 280px;
  max-width: 420px;
  box-shadow: 0 10px 25px -5px rgba(0,0,0,0.15);
}
.toast-icon {
  width: 24px;
  height: 24px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 0.8rem;
  font-weight: 900;
  flex-shrink: 0;
}
.toast-success { background: #F0FDF4; color: #166534; border: 1px solid #BBF7D0; }
.toast-success .toast-icon { background: #22C55E; color: #fff; }
.toast-error { background: #FEF2F2; color: #991B1B; border: 1px solid #FECACA; }
.toast-error .toast-icon { background: #EF4444; color: #fff; }
.toast-info { background: #EFF6FF; color: #1E40AF; border: 1px solid #BFDBFE; }
.toast-info .toast-icon { background: #3B82F6; color: #fff; }

.toast-enter-active { transition: all 0.3s ease; }
.toast-leave-active { transition: all 0.25s ease; }
.toast-enter-from { opacity: 0; transform: translateX(60px); }
.toast-leave-to { opacity: 0; transform: translateX(60px); }
</style>
