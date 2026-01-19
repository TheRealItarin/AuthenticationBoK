<template>
    <div class="register-container">
        <div class="register-card">
            <div class="register-header">
                <div class="register-icon">📝</div>
                <h2>Create Account</h2>
                <p class="register-subtitle">Join Our Secure Platform</p>
            </div>

            <form @submit.prevent="register" class="register-form">
                <div class="form-group">
                    <label for="register-username">
                        <span class="label-icon">👤</span>
                        Username
                    </label>
                    <input 
                        type="text" 
                        id="register-username" 
                        name="username" 
                        v-model="username" 
                        required
                        placeholder="Choose a unique username"
                        class="form-control"
                    >
                </div>

                <div class="form-group">
                    <label for="register-password">
                        <span class="label-icon">🔑</span>
                        Password
                    </label>
                    <input 
                        type="password" 
                        id="register-password" 
                        name="password" 
                        v-model="password" 
                        required
                        placeholder="Choose a strong password"
                        class="form-control"
                    >
                    <small class="password-hint">Min 15 characters</small>
                </div>

                <button type="submit" class="btn btn-primary btn-register">
                    <span></span> Create Account
                </button>
            </form>

            <div class="register-footer">
                <p>Already have an account? <router-link to="/login">Login here</router-link></p>
            </div>
        </div>

        <div v-if="errors" class="alert alert-danger alert-visible">
            <strong>⚠️ Registration Failed</strong>
            <div v-if="typeof errors === 'string'">
                <p>{{ errors }}</p>
            </div>
            <div v-else>
                <ul class="error-list">
                    <li v-for="(error, field) in errors" :key="field">
                        <strong>{{ field }}:</strong> {{ Array.isArray(error) ? error.join(', ') : error }}
                    </li>
                </ul>
            </div>
        </div>

        <div v-if="success" class="alert alert-success alert-visible">
            <strong>✓ Success!</strong>
            <p>Your account has been created successfully!</p>
            <p class="next-step">You can now <router-link to="/login">login with your credentials</router-link></p>
        </div>
    </div>
</template>

<script>
import { register } from '@/services/user-services.js';
export default {
    name: 'RegistrationComponent',
    data() {
        return {
            username: '',
            password: '',
            errors: null,
            success: null,
            successfulRegistration: null,
        };
    },
    methods: {
        async register() {
            this.errors = null;
            this.success = null;
            try {
                const response = await register(this.username, this.password);
                this.success = response;
                this.successfulRegistration = true;
                this.username = '';
                this.password = '';
                console.log("Registration successful:", response);
            } catch (error) {
                console.error("Registration failed:", error);
                this.errors = error.details?.errors || error.message;
            }
        },
    },
};
</script>

<style scoped>
.register-container {
    max-width: 450px;
    margin: 2rem auto;
    padding: 0 1rem;
}

.register-card {
    background: white;
    border-radius: 12px;
    padding: 3rem 2rem;
    box-shadow: 0 10px 40px rgba(26, 58, 82, 0.15);
    border: 1px solid rgba(44, 90, 160, 0.2);
}

.register-header {
    text-align: center;
    margin-bottom: 2rem;
    border-bottom: 2px solid #f5f7fa;
    padding-bottom: 1.5rem;
}

.register-icon {
    font-size: 3rem;
    display: block;
    margin-bottom: 1rem;
}

.register-header h2 {
    color: #1a3a52;
    margin: 0.5rem 0;
    font-size: 1.8rem;
}

.register-subtitle {
    color: #7f8c8d;
    margin: 0;
    font-size: 0.95rem;
    font-weight: 400;
}

.register-form {
    margin-bottom: 1.5rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 0.6rem;
    color: #1a3a52;
    font-weight: 600;
    font-size: 0.95rem;
}

.label-icon {
    font-size: 1.2rem;
}

.form-control {
    width: 100%;
    padding: 0.9rem 1rem;
    border: 2px solid #cbd5e0;
    border-radius: 6px;
    font-family: inherit;
    font-size: 1rem;
    transition: all 0.3s ease;
    background-color: #f9f9f9;
}

.form-control:focus {
    outline: none;
    border-color: #2c5aa0;
    background-color: white;
    box-shadow: 0 0 0 3px rgba(44, 90, 160, 0.1);
}

.form-control::placeholder {
    color: #bdc3c7;
}

.password-hint {
    display: block;
    margin-top: 0.3rem;
    font-size: 0.8rem;
    color: #95a5a6;
}

.btn-register {
    width: 100%;
    padding: 1rem;
    font-size: 1.05rem;
    margin-top: 1rem;
}

.register-footer {
    text-align: center;
    padding-top: 1rem;
    border-top: 1px solid #f5f7fa;
}

.register-footer p {
    color: #7f8c8d;
    margin: 0;
    font-size: 0.9rem;
}

.register-footer a {
    color: #2c5aa0;
    font-weight: 600;
    text-decoration: none;
}

.register-footer a:hover {
    color: #d4af37;
    text-decoration: underline;
}

.alert-visible {
    margin-top: 1.5rem;
    animation: slideIn 0.3s ease;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.alert-danger {
    background: #f8d7da;
    border-left: 4px solid #f44336;
    color: #721c24;
}

.alert-danger strong {
    color: #721c24;
    display: block;
    margin-bottom: 0.5rem;
}

.error-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.error-list li {
    padding: 0.3rem 0;
    font-size: 0.9rem;
}

.alert-success {
    background: #d4edda;
    border-left: 4px solid #4caf50;
    color: #155724;
}

.alert-success strong {
    color: #155724;
    display: block;
    margin-bottom: 0.5rem;
}

.next-step {
    margin: 0.8rem 0 0 0;
}

.next-step a {
    color: #155724;
    font-weight: 600;
    text-decoration: underline;
}

.next-step a:hover {
    color: #0d3416;
}

@media (max-width: 480px) {
    .register-card {
        padding: 2rem 1.5rem;
    }
    
    .register-icon {
        font-size: 2.5rem;
    }
    
    .register-header h2 {
        font-size: 1.5rem;
    }
}
</style>