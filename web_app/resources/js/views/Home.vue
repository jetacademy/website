<template>
  <div class="home-layout">
    <HomeHero />
    <section id="why"><HomeValueProp /></section>
    <section id="solusi"><HomeModules /></section>
    <section id="fitur"><HomeFeatures /></section>
    <HomeAdvantages />
    <HomeComparison />
    <HomeWhitelabel />

    <section id="harga"><HomePricing /></section>
  </div>
</template>

<script setup>
import HomeHero from '../components/home/HomeHero.vue';
import HomeValueProp from '../components/home/HomeValueProp.vue';
import HomeModules from '../components/home/HomeModules.vue';
import HomeFeatures from '../components/home/HomeFeatures.vue';
import HomeAdvantages from '../components/home/HomeAdvantages.vue';
import HomeComparison from '../components/home/HomeComparison.vue';
import HomeWhitelabel from '../components/home/HomeWhitelabel.vue';

import HomePricing from '../components/home/HomePricing.vue';
</script>

<style scoped>
.home-layout {
  background: #FFFFFF;
  overflow-x: hidden;
}
</style>
