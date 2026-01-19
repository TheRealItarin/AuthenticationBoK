<script setup>
import { RouterView } from 'vue-router'
import PageTitleComponent from './components/PageTitleComponent.vue';
import '@/assets/css/office-theme.css';
</script>

<template>
  <div id="app-container">
    <PageTitleComponent />
    <main class="main-content">
      <RouterView />
    </main>
    <footer class="app-footer">
      <p>&copy; 2026 Authentication BoK Project | Building Secure Access Systems</p>
    </footer>
  </div>
</template>

<style scoped>
#app-container {
  min-height: 100vh;
  display: flex;
  flex-direction: column;
}

.main-content {
  flex: 1;
  padding: 2rem 1rem;
}

.app-footer {
  background: linear-gradient(135deg, #1a3a52 0%, #2c5aa0 100%);
  color: white;
  text-align: center;
  padding: 2rem;
  margin-top: 3rem;
  border-top: 3px solid #d4af37;
  font-size: 0.9rem;
}

.app-footer p {
  margin: 0;
  color: white;
}
</style>