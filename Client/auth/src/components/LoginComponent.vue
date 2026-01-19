<template>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="lock-icon">🔐</div>
                <h2>Secure Login</h2>
                <p class="login-subtitle">Access Your Secure Documents</p>
            </div>

            <form @submit.prevent="login" class="login-form">
                <div class="form-group">
                    <label for="login-username">
                        <span class="label-icon">👤</span>
                        Username
                    </label>
                    <input 
                        type="text" 
                        id="login-username" 
                        name="username" 
                        v-model="username" 
                        required 
                        autocomplete="username"
                        placeholder="Enter your username"
                        class="form-control"
                    >
                </div>

                <div class="form-group">
                    <label for="login-password">
                        <span class="label-icon">🔑</span>
                        Password
                    </label>
                    <input 
                        type="password" 
                        id="login-password" 
                        name="password" 
                        v-model="password" 
                        required 
                        autocomplete="current-password"
                        placeholder="Enter your password"
                        class="form-control"
                    >
                </div>

                <button type="submit" class="btn btn-primary btn-login">
                    <span></span> Login
                </button>
            </form>

            <div class="login-footer">
                <p>Don't have an account? <router-link to="/register">Register here</router-link></p>
            </div>
        </div>

        <div v-if="errors" class="alert alert-danger alert-visible">
            <strong>⚠️ Login Failed</strong>
            <p>{{ errors }}</p>
        </div>

        <div v-if="success" class="alert alert-success alert-visible">
            <strong>✓ Welcome Back!</strong>
            <p>Hello, {{ success.username }}!</p>
            <p class="role-info"><strong>Your Role:</strong> {{ success.role }}</p>
        </div>
    </div>
</template>

<script>
import { login } from '@/services/user-services.js';
export default {
    name: 'LoginComponent',
    data() {
        return {
            username: '',
            password: '',
            success: null,
            errors: null,
        };
    },
    methods: {
        async login() {
            this.success = null;
            this.errors = null;
            try{
                const response = await login(this.username, this.password);
                this.success = response;
                localStorage.setItem('token', response.token);
                localStorage.setItem('userRole', response.role);
                localStorage.setItem('username', response.username);
                window.dispatchEvent(new Event('userLoggedIn'));
                console.log("Login successful:", response);
            } catch (error){
                console.error("Login failed:", error);
                this.errors = error.details?.unauthorized || error.message;
            }
        },
    },
};
</script>

<style scoped>
.login-container {
    max-width: 450px;
    margin: 2rem auto;
    padding: 0 1rem;
}

.login-card {
    background: white;
    border-radius: 12px;
    padding: 3rem 2rem;
    box-shadow: 0 10px 40px rgba(26, 58, 82, 0.15);
    border: 1px solid rgba(44, 90, 160, 0.2);
}

.login-header {
    text-align: center;
    margin-bottom: 2rem;
    border-bottom: 2px solid #f5f7fa;
    padding-bottom: 1.5rem;
}

.lock-icon {
    font-size: 3rem;
    display: block;
    margin-bottom: 1rem;
}

.login-header h2 {
    color: #1a3a52;
    margin: 0.5rem 0;
    font-size: 1.8rem;
}

.login-subtitle {
    color: #7f8c8d;
    margin: 0;
    font-size: 0.95rem;
    font-weight: 400;
}

.login-form {
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

.btn-login {
    width: 100%;
    padding: 1rem;
    font-size: 1.05rem;
    margin-top: 1rem;
}

.login-footer {
    text-align: center;
    padding-top: 1rem;
    border-top: 1px solid #f5f7fa;
}

.login-footer p {
    color: #7f8c8d;
    margin: 0;
    font-size: 0.9rem;
}

.login-footer a {
    color: #2c5aa0;
    font-weight: 600;
    text-decoration: none;
}

.login-footer a:hover {
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

.alert-success {
    background: #d4edda;
    border-left: 4px solid #4caf50;
    color: #155724;
}

.alert-success strong {
    color: #155724;
}

.role-info {
    margin: 0.5rem 0 0 0;
    font-size: 0.95rem;
    color: #155724;
}

@media (max-width: 480px) {
    .login-card {
        padding: 2rem 1.5rem;
    }
    
    .lock-icon {
        font-size: 2.5rem;
    }
    
    .login-header h2 {
        font-size: 1.5rem;
    }
}
</style>