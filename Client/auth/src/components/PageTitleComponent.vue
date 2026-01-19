<template>
    <header class="page-title">
        <div class="building-logo">
            <div class="building-icon">🏢</div>
            <div class="logo-text">
                <h1>SecureAccess</h1>
                <p class="tagline">BoK topic: Authentication</p>
            </div>
        </div>
        <div class="header-right">
            <div class="role-badge">
                <span class="role-label">Current Role:</span>
                <span class="role-value">{{ currentRole }}</span>
            </div>
            <nav class="nav-links">
                <router-link to="/" class="nav-item home-link">
                    <span class="icon">🏠</span>
                    <span>Home</span>
                </router-link>
                <router-link to="/documents" class="nav-item docs-link">
                    <span class="icon">📄</span>
                    <span>Documents</span>
                </router-link>
                <router-link to="/login" class="nav-item login-link">
                    <span class="icon">🔐</span>
                    <span>Login</span>
                </router-link>
                <router-link to="/register" class="nav-item register-link">
                    <span class="icon">📝</span>
                    <span>Register</span>
                </router-link>
                <button v-if="isLoggedIn" @click="logout" class="logout-btn">>
                    <span>Logout</span>
                </button>
            </nav>
        </div>
    </header>
</template>

<script>
import { logout } from '@/services/user-services.js';
export default {
    name: 'PageTitleComponent',
    data() {
        return {
            currentRole: 'none',
            isLoggedIn: false,
        };
    },
    methods: {
        updateRole() {
            this.currentRole = localStorage.getItem('userRole') || 'none';
            this.isLoggedIn = !!localStorage.getItem('userRole');
        },
        async logout() {
            var CurrentUserName = localStorage.getItem('username');
            await logout(CurrentUserName);
            this.currentRole = 'none';
            this.isLoggedIn = false;
            window.dispatchEvent(new Event('userLoggedOut'));
            window.location.reload();
        }
    },
    mounted() {
        this.updateRole();
        window.addEventListener('userLoggedIn', this.updateRole);
        window.addEventListener('userLoggedOut', this.updateRole);
    },
    beforeUnmount() {
        window.removeEventListener('userLoggedIn', this.updateRole);
        window.removeEventListener('userLoggedOut', this.updateRole);
    }
};
</script>

<style scoped>
header.page-title {
    background: linear-gradient(135deg, #1a3a52 0%, #2c5aa0 100%);
    color: white;
    padding: 1.5rem 2rem;
    box-shadow: 0 4px 12px rgba(26, 58, 82, 0.3);
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom: 4px solid #d4af37;
    position: sticky;
    top: 0;
    z-index: 100;
}

.building-logo {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex-shrink: 0;
}

.building-icon {
    font-size: 2.5rem;
    animation: float 3s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-5px); }
}

.logo-text h1 {
    margin: 0;
    font-size: 1.8rem;
    color: white;
    letter-spacing: 1px;
    font-weight: 700;
}

.tagline {
    margin: 0;
    font-size: 0.75rem;
    color: #d4af37;
    font-weight: 300;
    letter-spacing: 0.5px;
    text-transform: uppercase;
}

.header-right {
    display: flex;
    align-items: center;
    gap: 2rem;
    flex: 1;
    justify-content: flex-end;
}

.role-badge {
    background: rgba(255, 255, 255, 0.1);
    padding: 0.6rem 1.2rem;
    border-radius: 6px;
    border: 1px solid rgba(212, 175, 55, 0.3);
    display: flex;
    align-items: center;
    gap: 0.6rem;
    backdrop-filter: blur(10px);
}

.role-label {
    font-size: 0.85rem;
    color: rgba(255, 255, 255, 0.7);
    font-weight: 500;
}

.role-value {
    font-weight: 700;
    color: #d4af37;
    font-size: 0.95rem;
    text-transform: capitalize;
}

.nav-links {
    display: flex;
    gap: 0.5rem;
    align-items: center;
    flex-wrap: wrap;
    justify-content: flex-end;
}

.nav-item {
    display: flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.6rem 1rem;
    border-radius: 4px;
    color: white;
    transition: all 0.3s ease;
    font-weight: 500;
    font-size: 0.9rem;
    white-space: nowrap;
}

.nav-item:hover {
    background: rgba(212, 175, 55, 0.2);
    color: #d4af37;
    transform: translateY(-2px);
}

.nav-item.router-link-active {
    background: rgba(212, 175, 55, 0.3);
    color: #d4af37;
    border-bottom: 2px solid #d4af37;
}

.icon {
    font-size: 1.1rem;
}

.logout-btn {
    display: flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.6rem 1rem;
    background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-weight: 600;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    white-space: nowrap;
}

.logout-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 12px rgba(231, 76, 60, 0.3);
}

/* Responsive */
@media (max-width: 1024px) {
    header.page-title {
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .logo-text h1 {
        font-size: 1.5rem;
    }
    
    .tagline {
        display: none;
    }
    
    .header-right {
        width: 100%;
        justify-content: space-between;
        gap: 1rem;
    }
}

@media (max-width: 768px) {
    header.page-title {
        padding: 1rem;
        flex-direction: column;
        align-items: flex-start;
    }
    
    .building-logo {
        width: 100%;
    }
    
    .logo-text h1 {
        font-size: 1.25rem;
    }
    
    .header-right {
        width: 100%;
        flex-direction: column;
        gap: 1rem;
    }
    
    .nav-links {
        width: 100%;
    }
    
    .role-badge {
        width: 100%;
        justify-content: space-between;
    }
    
    .nav-item span:last-child {
        display: none;
    }
}
</style>