<template>
  <div class="login-page">
    <!-- Animated Background -->
    <div class="login-bg">
      <div class="bg-orb bg-orb-1"></div>
      <div class="bg-orb bg-orb-2"></div>
      <div class="bg-orb bg-orb-3"></div>
      <div class="bg-grid"></div>
    </div>

    <div class="login-container">
      <!-- Left Panel — Branding -->
      <div class="login-branding">
        <div class="branding-content">
          <div class="brand-icon">
            <svg width="48" height="48" viewBox="0 0 48 48" fill="none">
              <rect width="48" height="48" rx="14" fill="url(#grad)" />
              <path d="M16 32V20l8-6 8 6v12l-8 4-8-4z" fill="rgba(255,255,255,0.9)" />
              <path d="M24 14l8 6v12l-8 4V14z" fill="rgba(255,255,255,0.6)" />
              <defs>
                <linearGradient id="grad" x1="0" y1="0" x2="48" y2="48">
                  <stop stop-color="#6366F1" />
                  <stop offset="1" stop-color="#8B5CF6" />
                </linearGradient>
              </defs>
            </svg>
          </div>
          <h2 class="brand-title">Jetschool</h2>
          <p class="brand-subtitle">Sistem Operasi Digital<br>Yayasan & Sekolah</p>

          <div class="brand-features">
            <div class="feature-item">
              <div class="feature-icon">🛡️</div>
              <div>
                <strong>Keamanan Terjamin</strong>
                <span>Enkripsi end-to-end & session management</span>
              </div>
            </div>
            <div class="feature-item">
              <div class="feature-icon">⚡</div>
              <div>
                <strong>Akses Cepat</strong>
                <span>Dashboard real-time untuk monitoring</span>
              </div>
            </div>
            <div class="feature-item">
              <div class="feature-icon">📊</div>
              <div>
                <strong>Data Terpusat</strong>
                <span>Kelola semua data dalam satu platform</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Right Panel — Login Form -->
      <div class="login-form-panel">
        <div class="form-wrapper">
          <div class="form-header">
            <h1>Selamat Datang</h1>
            <p>Masuk ke panel administrasi Jetschool</p>
          </div>

          <!-- Error Message -->
          <Transition name="shake">
            <div v-if="errorMsg" class="alert-error">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10" /><line x1="15" y1="9" x2="9" y2="15" /><line x1="9" y1="9" x2="15" y2="15" />
              </svg>
              <span>{{ errorMsg }}</span>
            </div>
          </Transition>

          <!-- Rate Limit Warning -->
          <div v-if="retryAfter > 0" class="alert-warning">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
              <line x1="12" y1="9" x2="12" y2="13" /><line x1="12" y1="17" x2="12.01" y2="17" />
            </svg>
            <span>Akun terkunci. Coba lagi dalam <strong>{{ retryAfter }}s</strong></span>
          </div>

          <form @submit.prevent="handleLogin" class="login-form">
            <div class="input-group">
              <label for="email">Email</label>
              <div class="input-wrapper" :class="{ focused: emailFocused, error: emailError }">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                  <polyline points="22,6 12,13 2,6" />
                </svg>
                <input
                  id="email"
                  type="email"
                  v-model="form.email"
                  required
                  placeholder="admin@jetschool.id"
                  autocomplete="email"
                  @focus="emailFocused = true"
                  @blur="emailFocused = false"
                  :disabled="retryAfter > 0"
                >
              </div>
            </div>

            <div class="input-group">
              <label for="password">Password</label>
              <div class="input-wrapper" :class="{ focused: passwordFocused, error: passwordError }">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <rect x="3" y="11" width="18" height="11" rx="2" ry="2" /><path d="M7 11V7a5 5 0 0110 0v4" />
                </svg>
                <input
                  id="password"
                  :type="showPassword ? 'text' : 'password'"
                  v-model="form.password"
                  required
                  placeholder="Masukkan password..."
                  autocomplete="current-password"
                  @focus="passwordFocused = true"
                  @blur="passwordFocused = false"
                  :disabled="retryAfter > 0"
                >
                <button type="button" class="toggle-password" @click="showPassword = !showPassword" tabindex="-1" aria-label="Toggle password visibility">
                  <svg v-if="!showPassword" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" /><circle cx="12" cy="12" r="3" />
                  </svg>
                  <svg v-else width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24" />
                    <line x1="1" y1="1" x2="23" y2="23" />
                  </svg>
                </button>
              </div>
            </div>

            <button type="submit" class="btn-submit" :disabled="isLoading || retryAfter > 0">
              <span v-if="isLoading" class="btn-spinner"></span>
              <span v-else>Masuk ke Dashboard</span>
            </button>
          </form>

          <div class="form-footer">
            <router-link to="/" class="back-link">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="19" y1="12" x2="5" y2="12" /><polyline points="12 19 5 12 12 5" />
              </svg>
              Kembali ke Website
            </router-link>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onUnmounted } from 'vue';
import { useRouter } from 'vue-router';
import { useAuth } from '../composables/useAuth';

const router = useRouter();
const auth = useAuth();

const form = ref({ email: '', password: '' });
const isLoading = ref(false);
const errorMsg = ref('');
const retryAfter = ref(0);
const showPassword = ref(false);
const emailFocused = ref(false);
const passwordFocused = ref(false);
const emailError = ref(false);
const passwordError = ref(false);

let retryInterval = null;

const startRetryCountdown = (seconds) => {
    retryAfter.value = seconds;
    retryInterval = setInterval(() => {
        retryAfter.value--;
        if (retryAfter.value <= 0) {
            clearInterval(retryInterval);
            retryInterval = null;
        }
    }, 1000);
};

onUnmounted(() => {
    if (retryInterval) clearInterval(retryInterval);
});

const handleLogin = async () => {
    if (retryAfter.value > 0) return;

    isLoading.value = true;
    errorMsg.value = '';
    emailError.value = false;
    passwordError.value = false;

    try {
        const result = await auth.login(form.value.email, form.value.password);
        if (result.success) {
            if (auth.isAdmin()) {
                router.push('/webadmin');
            } else if (auth.hasRole('Affiliator')) {
                router.push('/affiliate/dashboard');
            } else {
                router.push('/');
            }
        } else {
            errorMsg.value = result.message || 'Login gagal.';
            passwordError.value = true;
        }
    } catch (e) {
        if (e.response?.status === 429) {
            const seconds = e.response.data.retry_after || 60;
            startRetryCountdown(seconds);
            errorMsg.value = '';
        } else if (e.response?.status === 401) {
            errorMsg.value = e.response.data.message || 'Email atau password salah.';
            const remaining = e.response.data.attempts_remaining;
            if (remaining !== undefined && remaining <= 2) {
                errorMsg.value += ` (${remaining} percobaan tersisa)`;
            }
            passwordError.value = true;
        } else if (e.response?.status === 422) {
            const errors = e.response.data.errors;
            errorMsg.value = errors ? Object.values(errors).flat().join(', ') : 'Data tidak valid.';
            emailError.value = !!errors?.email;
            passwordError.value = !!errors?.password;
        } else {
            errorMsg.value = 'Terjadi kesalahan server. Coba lagi nanti.';
        }
    } finally {
        isLoading.value = false;
    }
};
</script>

<style scoped>
.login-page {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #0B0F1A;
  position: relative;
  overflow: hidden;
}

/* Animated Background */
.login-bg {
  position: absolute;
  inset: 0;
  pointer-events: none;
}

.bg-orb {
  position: absolute;
  border-radius: 50%;
  filter: blur(80px);
  opacity: 0.4;
  animation: float 20s ease-in-out infinite;
}

.bg-orb-1 {
  width: 500px;
  height: 500px;
  background: radial-gradient(circle, #6366F1, transparent);
  top: -10%;
  left: -5%;
  animation-delay: 0s;
}

.bg-orb-2 {
  width: 400px;
  height: 400px;
  background: radial-gradient(circle, #8B5CF6, transparent);
  bottom: -10%;
  right: -5%;
  animation-delay: -7s;
}

.bg-orb-3 {
  width: 300px;
  height: 300px;
  background: radial-gradient(circle, #06B6D4, transparent);
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  animation-delay: -14s;
  opacity: 0.2;
}

.bg-grid {
  position: absolute;
  inset: 0;
  background-image:
    linear-gradient(rgba(99, 102, 241, 0.03) 1px, transparent 1px),
    linear-gradient(90deg, rgba(99, 102, 241, 0.03) 1px, transparent 1px);
  background-size: 60px 60px;
}

@keyframes float {
  0%, 100% { transform: translate(0, 0) scale(1); }
  33% { transform: translate(30px, -20px) scale(1.05); }
  66% { transform: translate(-20px, 20px) scale(0.95); }
}

/* Container */
.login-container {
  display: grid;
  grid-template-columns: 1fr 1fr;
  width: 100%;
  max-width: 1000px;
  min-height: 600px;
  margin: 24px;
  border-radius: 24px;
  overflow: hidden;
  box-shadow: 0 40px 80px -20px rgba(0, 0, 0, 0.6), 0 0 0 1px rgba(99, 102, 241, 0.1);
  position: relative;
  z-index: 1;
  background: rgba(15, 23, 42, 0.6);
  backdrop-filter: blur(20px);
  border: 1px solid rgba(99, 102, 241, 0.15);
}

/* Left Branding Panel */
.login-branding {
  background: linear-gradient(160deg, #1E1B4B 0%, #312E81 50%, #4338CA 100%);
  padding: 48px 40px;
  display: flex;
  align-items: center;
  position: relative;
  overflow: hidden;
}

.login-branding::before {
  content: '';
  position: absolute;
  inset: 0;
  background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}

.branding-content {
  position: relative;
  z-index: 1;
}

.brand-icon {
  margin-bottom: 24px;
}

.brand-title {
  font-size: 2rem;
  font-weight: 800;
  color: #fff;
  margin: 0 0 8px;
  letter-spacing: -0.02em;
}

.brand-subtitle {
  color: rgba(255, 255, 255, 0.7);
  font-size: 1rem;
  line-height: 1.5;
  margin: 0 0 40px;
}

.brand-features {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.feature-item {
  display: flex;
  align-items: flex-start;
  gap: 14px;
}

.feature-icon {
  font-size: 1.4rem;
  flex-shrink: 0;
  width: 40px;
  height: 40px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: rgba(255, 255, 255, 0.1);
  border-radius: 10px;
}

.feature-item strong {
  display: block;
  color: #fff;
  font-size: 0.9rem;
  font-weight: 700;
  margin-bottom: 2px;
}

.feature-item span {
  color: rgba(255, 255, 255, 0.55);
  font-size: 0.82rem;
  line-height: 1.4;
}

/* Right Form Panel */
.login-form-panel {
  background: #fff;
  padding: 48px 40px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.form-wrapper {
  width: 100%;
  max-width: 360px;
}

.form-header {
  margin-bottom: 32px;
}

.form-header h1 {
  font-size: 1.75rem;
  font-weight: 800;
  color: #0F172A;
  margin: 0 0 8px;
  letter-spacing: -0.02em;
}

.form-header p {
  color: #64748B;
  font-size: 0.95rem;
  margin: 0;
}

/* Alerts */
.alert-error {
  display: flex;
  align-items: center;
  gap: 10px;
  background: #FEF2F2;
  border: 1px solid #FECACA;
  color: #DC2626;
  padding: 12px 16px;
  border-radius: 12px;
  font-size: 0.85rem;
  font-weight: 600;
  margin-bottom: 20px;
  animation: shakeX 0.4s ease;
}

.alert-warning {
  display: flex;
  align-items: center;
  gap: 10px;
  background: #FFFBEB;
  border: 1px solid #FDE68A;
  color: #92400E;
  padding: 12px 16px;
  border-radius: 12px;
  font-size: 0.85rem;
  font-weight: 600;
  margin-bottom: 20px;
}

@keyframes shakeX {
  0%, 100% { transform: translateX(0); }
  20% { transform: translateX(-6px); }
  40% { transform: translateX(6px); }
  60% { transform: translateX(-4px); }
  80% { transform: translateX(4px); }
}

/* Form */
.login-form {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.input-group label {
  display: block;
  font-weight: 700;
  font-size: 0.85rem;
  color: #1E293B;
  margin-bottom: 8px;
}

.input-wrapper {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 0 16px;
  border: 1.5px solid #E2E8F0;
  border-radius: 12px;
  background: #F8FAFC;
  transition: all 0.2s ease;
  height: 50px;
}

.input-wrapper svg {
  color: #94A3B8;
  flex-shrink: 0;
  transition: color 0.2s;
}

.input-wrapper.focused {
  border-color: #6366F1;
  background: #fff;
  box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.08);
}

.input-wrapper.focused svg {
  color: #6366F1;
}

.input-wrapper.error {
  border-color: #F87171;
  background: #FEF2F2;
}

.input-wrapper.error svg {
  color: #EF4444;
}

.input-wrapper input {
  flex: 1;
  border: none;
  background: transparent;
  font-size: 0.95rem;
  color: #0F172A;
  outline: none;
  height: 100%;
}

.input-wrapper input::placeholder {
  color: #94A3B8;
}

.input-wrapper input:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.toggle-password {
  background: none;
  border: none;
  cursor: pointer;
  padding: 4px;
  color: #94A3B8;
  transition: color 0.2s;
  display: flex;
  align-items: center;
}

.toggle-password:hover {
  color: #6366F1;
}

/* Submit Button */
.btn-submit {
  width: 100%;
  height: 50px;
  background: linear-gradient(135deg, #6366F1 0%, #4F46E5 100%);
  color: #fff;
  border: none;
  border-radius: 12px;
  font-size: 1rem;
  font-weight: 700;
  cursor: pointer;
  transition: all 0.25s ease;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-top: 4px;
  position: relative;
  overflow: hidden;
}

.btn-submit::before {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(135deg, transparent, rgba(255,255,255,0.1));
  opacity: 0;
  transition: opacity 0.25s;
}

.btn-submit:hover:not(:disabled)::before {
  opacity: 1;
}

.btn-submit:hover:not(:disabled) {
  transform: translateY(-2px);
  box-shadow: 0 12px 24px -6px rgba(99, 102, 241, 0.4);
}

.btn-submit:active:not(:disabled) {
  transform: translateY(0);
}

.btn-submit:disabled {
  opacity: 0.5;
  cursor: not-allowed;
  transform: none;
}

.btn-spinner {
  width: 20px;
  height: 20px;
  border: 2.5px solid rgba(255, 255, 255, 0.3);
  border-top-color: #fff;
  border-radius: 50%;
  animation: spin 0.7s linear infinite;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}

/* Footer */
.form-footer {
  margin-top: 28px;
  text-align: center;
}

.back-link {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  color: #64748B;
  font-size: 0.88rem;
  font-weight: 600;
  text-decoration: none;
  transition: color 0.2s;
}

.back-link:hover {
  color: #6366F1;
}

/* Transitions */
.shake-enter-active { animation: shakeX 0.4s ease; }
.shake-leave-active { transition: opacity 0.2s; }
.shake-leave-to { opacity: 0; }

/* Responsive */
@media (max-width: 768px) {
  .login-container {
    grid-template-columns: 1fr;
    max-width: 440px;
    margin: 16px;
    min-height: auto;
  }

  .login-branding {
    display: none;
  }

  .login-form-panel {
    padding: 40px 28px;
    border-radius: 24px;
  }
}

@media (max-width: 480px) {
  .login-form-panel {
    padding: 32px 20px;
  }

  .form-header h1 {
    font-size: 1.5rem;
  }

  .input-wrapper {
    height: 46px;
  }

  .btn-submit {
    height: 46px;
  }
}
</style>
