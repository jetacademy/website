<template>
  <div class="login-page">
    <div class="login-container">
      <div class="login-card">
        <div class="login-header">
          <div class="brand">
            <div class="brand-logo">J</div>
            <span class="brand-name">Mitra<span>Jetschool</span></span>
          </div>
          <h2>Masuk ke Dasbor</h2>
          <p>Silakan masuk menggunakan akun Afiliator Anda.</p>
        </div>

        <form @submit.prevent="submitLogin" class="login-form">
          <div class="form-group">
            <label for="email">Alamat Email</label>
            <input 
              type="email" 
              id="email" 
              v-model="form.email"
              required
              class="form-input"
              placeholder="nama@email.com"
            >
          </div>

          <div class="form-group">
            <label for="password">Kata Sandi</label>
            <input 
              type="password" 
              id="password" 
              v-model="form.password"
              required
              class="form-input"
              placeholder="••••••••"
            >
          </div>

          <div v-if="alert.show" :class="['alert', alert.type]">
            {{ alert.message }}
          </div>

          <button 
            type="submit" 
            :disabled="isLoading"
            class="btn btn-primary btn-block"
          >
            <span v-if="!isLoading">Masuk Dasbor &rarr;</span>
            <span v-else>Memverifikasi...</span>
          </button>
        </form>

        <div class="login-footer">
          <p>Belum menjadi mitra? <a href="#" class="link">Pelajari Program Kemitraan</a></p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';

const router = useRouter();
const isLoading = ref(false);

const form = ref({
    email: '',
    password: ''
});

const alert = ref({
    show: false,
    type: 'error',
    message: ''
});

const submitLogin = async () => {
    try {
        isLoading.value = true;
        alert.value.show = false;
        
        await axios.get('/sanctum/csrf-cookie');
        const response = await axios.post('/api/login', form.value);
        
        if (response.data.success) {
            router.push('/affiliate/dashboard');
        }
    } catch (error) {
        alert.value = { 
            show: true, 
            type: 'alert-error', 
            message: error.response?.data?.message || 'Login gagal. Periksa kembali email dan kata sandi Anda.' 
        };
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
  background: var(--page);
  padding: 40px 20px;
}

.login-container {
  width: 100%;
  max-width: 420px;
}

.login-card {
  background: var(--card);
  border: 1px solid var(--border);
  border-radius: var(--r-lg);
  padding: 40px;
  box-shadow: var(--sh-xl);
}

.login-header {
  text-align: center;
  margin-bottom: 32px;
}

.brand {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 12px;
  margin-bottom: 24px;
}

.brand-logo {
  width: 40px;
  height: 40px;
  background: var(--indigo);
  color: white;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: var(--r-sm);
  font-family: var(--serif);
  font-size: 1.5rem;
}

.brand-name {
  font-family: var(--serif);
  font-size: 1.5rem;
  color: var(--ink);
}

.brand-name span {
  color: var(--indigo);
}

.login-header h2 {
  font-size: 1.8rem;
  margin-bottom: 8px;
}

.login-header p {
  font-size: 0.95rem;
  color: var(--ink-muted);
}

.form-group {
  margin-bottom: 24px;
}

.form-group label {
  display: block;
  font-size: 0.9rem;
  font-weight: 600;
  color: var(--ink);
  margin-bottom: 8px;
}

.form-input {
  width: 100%;
  padding: 14px 16px;
  background: var(--page);
  border: 1.5px solid var(--border);
  border-radius: var(--r-sm);
  font-size: 1rem;
  color: var(--ink);
  transition: all 0.2s;
}

.form-input:focus {
  outline: none;
  border-color: var(--indigo);
  box-shadow: 0 0 0 3px var(--indigo-light);
}

.btn-block {
  width: 100%;
  height: 52px;
}

.alert {
  padding: 16px;
  border-radius: var(--r-sm);
  margin-bottom: 24px;
  font-size: 0.95rem;
}

.alert-error {
  background: #FEF2F2;
  color: #B91C1C;
  border: 1px solid #FECACA;
}

.login-footer {
  margin-top: 32px;
  text-align: center;
  border-top: 1px solid var(--border-light);
  padding-top: 24px;
}

.login-footer p {
  font-size: 0.9rem;
  color: var(--ink-muted);
}

.link {
  color: var(--indigo);
  font-weight: 600;
  text-decoration: none;
}

.link:hover {
  text-decoration: underline;
}
</style>
