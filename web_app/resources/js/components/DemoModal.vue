<template>
  <div v-if="appState.isDemoModalOpen" class="modal-overlay" @click.self="closeModal">
    <div class="modal-content">
      <button class="modal-close" @click="closeModal">&times;</button>
      
      <div class="modal-header">
        <h3 class="modal-title">{{ $t('demoModal.title') }}</h3>
        <p class="modal-desc">{{ $t('demoModal.desc') }}</p>
      </div>

      <form @submit.prevent="submitForm" class="modal-form">
        <div class="form-group">
          <label for="name">{{ $t('demoModal.nameLabel') }}</label>
          <input type="text" id="name" v-model="form.name" required class="form-input" :placeholder="$t('demoModal.namePlaceholder')">
        </div>

        <div class="form-group">
          <label for="school_name">{{ $t('demoModal.schoolLabel') }}</label>
          <input type="text" id="school_name" v-model="form.school_name" required class="form-input" :placeholder="$t('demoModal.schoolPlaceholder')">
        </div>

        <div class="form-group">
          <label for="phone">{{ $t('demoModal.phoneLabel') }}</label>
          <input type="tel" id="phone" v-model="form.phone_number" required class="form-input" :placeholder="$t('demoModal.phonePlaceholder')" @input="validatePhone">
          <span v-if="phoneError" class="field-error">{{ phoneError }}</span>
        </div>

        <div v-if="alert.show" :class="['alert', alert.type]">
          {{ alert.message }}
        </div>

        <button type="submit" :disabled="isLoading" class="btn btn-glow w-full mt-4">
          <span v-if="!isLoading">{{ $t('demoModal.btnSubmit') }}</span>
          <span v-else>{{ $t('demoModal.btnLoading') }}</span>
        </button>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';
import { useI18n } from 'vue-i18n';
import { appState } from '../state';

const { t } = useI18n();

const isLoading = ref(false);
const phoneError = ref('');
const form = ref({
    name: '',
    school_name: '',
    phone_number: ''
});

const alert = ref({
    show: false,
    type: 'success',
    message: ''
});

const closeModal = () => {
    appState.isDemoModalOpen = false;
};

const validatePhone = () => {
    const phone = form.value.phone_number;
    if (!phone) {
        phoneError.value = '';
        return true;
    }
    // Only allow digits, +, -, spaces, and parentheses
    const phoneRegex = /^[0-9+\-\s()]+$/;
    if (!phoneRegex.test(phone)) {
        phoneError.value = 'Nomor HP hanya boleh berisi angka dan karakter +, -, spasi, kurung';
        return false;
    }
    if (phone.replace(/\D/g, '').length < 8) {
        phoneError.value = 'Nomor HP terlalu pendek';
        return false;
    }
    phoneError.value = '';
    return true;
};

const getReferralCode = () => {
    const cachedRef = localStorage.getItem('jetschool_affiliate_ref');
    if (cachedRef) {
        try {
            const parsedData = JSON.parse(cachedRef);
            if (new Date().getTime() < parsedData.expires) {
                return parsedData.code;
            } else {
                localStorage.removeItem('jetschool_affiliate_ref');
            }
        } catch (e) {}
    }
    return null;
};

const submitForm = async () => {
    // Client-side validation
    if (!validatePhone()) {
        return;
    }
    
    try {
        isLoading.value = true;
        alert.value.show = false;
        
        const submitData = {
            ...form.value,
            ref: getReferralCode()
        };
        
        const response = await axios.post('/api/leads', submitData);
        
        if (response.data.success) {
            // Success, now redirect to WA
            const waNumber = "6287786264789"; 
            const waRawText = t('demoModal.waMessage', { 
              name: form.value.name, 
              school: form.value.school_name 
            });
            const waText = encodeURIComponent(waRawText);
            
            form.value = { name: '', school_name: '', phone_number: '' };
            phoneError.value = '';
            closeModal();
            window.open(`https://wa.me/${waNumber}?text=${waText}`, '_blank');
        }
    } catch (error) {
        const status = error.response?.status;
        if (status === 429) {
            alert.value = { show: true, type: 'error', message: error.response?.data?.message || 'Terlalu banyak pengiriman. Coba lagi nanti.' };
        } else {
            alert.value = { show: true, type: 'error', message: error.response?.data?.message || t('demoModal.errorSubmit') };
        }
    } finally {
        isLoading.value = false;
    }
};
</script>

<style scoped>
.modal-overlay {
  position: fixed; top: 0; left: 0; right: 0; bottom: 0;
  background: rgba(10, 15, 30, 0.7); backdrop-filter: blur(8px);
  z-index: 9999; display: flex; align-items: center; justify-content: center;
  padding: 20px;
}
.modal-content {
  background: white; border-radius: 20px; padding: 40px;
  width: 100%; max-width: 450px; position: relative;
  box-shadow: 0 24px 56px rgba(10, 15, 30, 0.2);
}
.modal-close {
  position: absolute; top: 20px; right: 24px;
  background: none; border: none; font-size: 2rem; color: #8E8EA0;
  cursor: pointer; line-height: 1;
}
.modal-title { font-size: 1.8rem; font-family: 'DM Serif Display', serif; margin-bottom: 8px; color: #1A1A2E; }
.modal-desc { font-size: 0.95rem; color: #4A4A68; margin-bottom: 32px; }

.modal-form { display: flex; flex-direction: column; gap: 20px; }
.form-group label { display: block; font-size: 0.9rem; font-weight: 600; color: #1A1A2E; margin-bottom: 8px; }
.form-input { 
  width: 100%; padding: 14px 16px; border: 1.5px solid #E8E4DE; border-radius: 8px; font-size: 1rem;
  transition: all 0.2s;
}
.form-input:focus { outline: none; border-color: #6366F1; box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1); }
.w-full { width: 100%; }
.mt-4 { margin-top: 16px; }

.alert { padding: 12px 16px; border-radius: 8px; font-size: 0.9rem; }
.alert.success { background: #ECFDF5; color: #047857; border: 1px solid #A7F3D0; }
.alert.error { background: #FEF2F2; color: #B91C1C; border: 1px solid #FECACA; }

.field-error { display: block; font-size: 0.8rem; color: #B91C1C; margin-top: 6px; font-weight: 500; }
</style>
