<template>
    <div class="main-page-container">
        <div class="welcome-section">
            <div class="welcome-header">
                <h1>Welcome to SecureAccess</h1>
                <p class="subtitle">Enterprise-Grade Authentication & Authorization System</p>
            </div>
            
            <div class="intro-text">
                <p>This platform demonstrates comprehensive security implementation combining authentication, authorization, and role-based access control (RBAC). To access secure documents, you must first register and login to the system.</p>
            </div>
        </div>

        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">🔐</div>
                <h3>Secure Authentication</h3>
                <p>Industry-standard authentication with encrypted credential storage using Argon2id password hashing</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">👥</div>
                <h3>Role-Based Access Control</h3>
                <p>RBAC implementation defining granular permissions. Users are assigned roles that determine document access levels.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">📊</div>
                <h3>Logging & Monitoring</h3>
                <p>Comprehensive logging and monitoring systems tracking all authentication and authorization events for security audits.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">🔑</div>
                <h3>Two-Factor Authentication</h3>
                <p>Enhanced security with 2FA implementation providing additional protection layer for user accounts.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">⚡</div>
                <h3>OWASP Best Practices</h3>
                <p>Implementation follows OWASP Authentication and Authorization Cheat Sheets for maximum security compliance.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">🛡️</div>
                <h3>Advanced Protections</h3>
                <p>ModSecurity integration and Apache deployment providing enterprise-level web application firewall protection.</p>
            </div>
        </div>

        <div class="cta-section">
            <h2>Get Started</h2>
            <div class="button-group">
                <router-link to="/register" class="btn btn-primary">
                    <span>📝</span> Register New Account
                </router-link>
                <router-link to="/login" class="btn btn-secondary">
                    <span>🔓</span> Login to Your Account
                </router-link>
            </div>
        </div>

        <div class="building-features">
            <h3>Building Your Security Foundation</h3>
            <div class="foundation-grid">
                <div class="foundation-item">
                    <strong>Level 1: Authentication</strong>
                    <p>Username/password verification with secure storage</p>
                </div>
                <div class="foundation-item">
                    <strong>Level 2: Authorization</strong>
                    <p>Role-based access control to resources</p>
                </div>
                <div class="foundation-item">
                    <strong>Level 3: Monitoring</strong>
                    <p>Comprehensive logging of all security events</p>
                </div>
                <div class="foundation-item">
                    <strong>Level 4: Advanced Security</strong>
                    <p>2FA, ModSecurity, and enterprise protections</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
  name: 'MainPageComponent'
};
</script>

<style scoped>
.main-page-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 1rem;
}

.welcome-section {
    text-align: center;
    margin-bottom: 4rem;
    padding: 3rem 2rem;
    background: linear-gradient(135deg, rgba(44, 90, 160, 0.08) 0%, rgba(212, 175, 55, 0.08) 100%);
    border-radius: 12px;
    border: 2px solid rgba(44, 90, 160, 0.2);
}

.welcome-header h1 {
    margin-bottom: 0.5rem;
    color: #1a3a52;
    font-size: 2.5rem;
}

.subtitle {
    font-size: 1.3rem;
    color: #2c5aa0;
    margin: 0;
    font-weight: 500;
}

.intro-text {
    margin-top: 1.5rem;
    font-size: 1.05rem;
    line-height: 1.8;
    color: #2c3e50;
    max-width: 700px;
    margin-left: auto;
    margin-right: auto;
}

.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 2rem;
    margin-bottom: 4rem;
}

.feature-card {
    background: white;
    border-radius: 8px;
    padding: 2rem;
    box-shadow: 0 4px 15px rgba(26, 58, 82, 0.1);
    transition: all 0.3s ease;
    border-left: 4px solid #d4af37;
    position: relative;
    overflow: hidden;
}

.feature-card::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 100px;
    height: 100px;
    background: radial-gradient(circle, rgba(212, 175, 55, 0.1) 0%, transparent 70%);
    border-radius: 50%;
}

.feature-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 30px rgba(26, 58, 82, 0.15);
    border-left-color: #2c5aa0;
}

.feature-icon {
    font-size: 3rem;
    margin-bottom: 1rem;
    display: inline-block;
}

.feature-card h3 {
    color: #1a3a52;
    margin-bottom: 0.8rem;
    font-size: 1.3rem;
}

.feature-card p {
    color: #555;
    font-size: 0.95rem;
    line-height: 1.6;
    margin: 0;
}

.cta-section {
    text-align: center;
    padding: 3rem 2rem;
    background: linear-gradient(135deg, #1a3a52 0%, #2c5aa0 100%);
    border-radius: 12px;
    margin-bottom: 4rem;
    color: white;
}

.cta-section h2 {
    color: white;
    margin-bottom: 1.5rem;
}

.button-group {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

.button-group .btn {
    padding: 1rem 2rem;
    font-size: 1.05rem;
    display: flex;
    align-items: center;
    gap: 0.6rem;
}

.btn-primary {
    background: white;
    color: #1a3a52;
    font-weight: 700;
}

.btn-primary:hover {
    background: #d4af37;
}

.btn-secondary {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    border: 2px solid white;
}

.btn-secondary:hover {
    background: white;
    color: #1a3a52;
}

.building-features {
    background: white;
    padding: 3rem 2rem;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(26, 58, 82, 0.1);
    margin-bottom: 3rem;
    border-top: 4px solid #d4af37;
}

.building-features h3 {
    text-align: center;
    margin-bottom: 2rem;
    font-size: 1.5rem;
    color: #1a3a52;
}

.foundation-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
}

.foundation-item {
    background: linear-gradient(135deg, rgba(44, 90, 160, 0.08) 0%, rgba(212, 175, 55, 0.08) 100%);
    padding: 1.5rem;
    border-radius: 8px;
    border-left: 4px solid #2c5aa0;
    text-align: center;
}

.foundation-item strong {
    display: block;
    color: #1a3a52;
    margin-bottom: 0.5rem;
    font-size: 1rem;
}

.foundation-item p {
    color: #555;
    font-size: 0.9rem;
    margin: 0;
}

@media (max-width: 768px) {
    .welcome-header h1 {
        font-size: 1.75rem;
    }
    
    .subtitle {
        font-size: 1rem;
    }
    
    .features-grid {
        grid-template-columns: 1fr;
    }
    
    .button-group {
        flex-direction: column;
    }
    
    .button-group .btn {
        width: 100%;
        justify-content: center;
    }
}
</style>