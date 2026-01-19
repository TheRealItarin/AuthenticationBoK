<template>
  <div class="error-wrapper">
    <div class="error-container">
      <div class="error-icon">⚠️</div>
      <h3 class="error-title">Error Details</h3>
      <div v-for="(value, name) in response" :key="name" class="error-field">
        <strong class="error-field-name">{{ name }}:</strong>
        <div v-if="Array.isArray(value)" class="error-value-list">
          <ul>
            <li v-for="(msg, idx) in value" :key="idx" class="error-message">
              {{ msg }}
            </li>
          </ul>
        </div>
        <div v-else-if="typeof value === 'object'" class="error-value-list">
          <ul>
            <li v-for="(subValue, subName) in value" :key="subName" class="error-message">
              <strong>{{ subName }}:</strong> {{ subValue }}
            </li>
          </ul>
        </div>
        <div v-else class="error-message">{{ value }}</div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'ErrorComponent',
  props: {
    response: {
      type: Object,
      required: true
    }
  },
  mounted() {
    console.log("ErrorComponent mounted with response:", this.response);
  }
};
</script>

<style scoped>
.error-wrapper {
  padding: 0 1rem;
  margin-bottom: 2rem;
}

.error-container {
  background: linear-gradient(135deg, rgba(244, 67, 54, 0.1) 0%, rgba(244, 67, 54, 0.05) 100%);
  border: 2px solid #f44336;
  border-radius: 8px;
  padding: 1.5rem;
  box-shadow: 0 4px 12px rgba(244, 67, 54, 0.15);
}

.error-icon {
  font-size: 2.5rem;
  text-align: center;
  margin-bottom: 1rem;
  display: block;
}

.error-title {
  color: #c62828;
  text-align: center;
  margin: 0 0 1rem 0;
  font-size: 1.25rem;
}

.error-field {
  margin-bottom: 1rem;
  padding: 1rem;
  background: white;
  border-radius: 6px;
  border-left: 3px solid #f44336;
  box-shadow: 0 2px 4px rgba(244, 67, 54, 0.1);
}

.error-field:last-child {
  margin-bottom: 0;
}

.error-field-name {
  display: block;
  color: #c62828;
  font-size: 0.95rem;
  margin-bottom: 0.5rem;
  text-transform: capitalize;
}

.error-message {
  color: #721c24;
  font-size: 0.9rem;
  margin: 0.3rem 0;
  line-height: 1.5;
}

.error-value-list {
  margin-top: 0.5rem;
}

.error-value-list ul {
  list-style: none;
  padding: 0;
  margin: 0;
}

.error-value-list li {
  padding: 0.4rem 0 0.4rem 1.5rem;
  position: relative;
}

.error-value-list li::before {
  content: '✗';
  position: absolute;
  left: 0;
  color: #f44336;
  font-weight: bold;
}

.error-value-list li strong {
  color: #c62828;
}
</style>
