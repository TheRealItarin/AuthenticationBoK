<template>
  <div class="documents-container">
    <div class="documents-header">
      <h2>📄 Secure Document Library</h2>
      <p class="header-subtitle">Manage and view secure text entries</p>
    </div>
    <div v-if="!token" class="alert alert-danger">
      <strong>🔒 Access Denied</strong>
      <p>Please log in first to access the document library. Your credentials are required for security verification.</p>
    </div>
    <div v-else-if="!canRead" class="alert alert-warning">
      <strong>⚠️ Insufficient Permissions</strong>
      <p>Your current role does not have the necessary permissions to access document content. Please contact an administrator.</p>
    </div>
    <div v-else class="content-area">
      <div v-if="!canEdit" class="alert alert-info">
        <strong>ℹ️ Read-Only Access</strong>
        <p>You have read-only access to documents. Upgrade your role to writer to contribute new entries.</p>
      </div>
      <div v-else class="writer-section">
        <div class="writer-header">
          <h3>✍️ Add New Entry</h3>
          <p>Share your content with the team (Writer privilege)</p>
        </div>
        <form @submit.prevent="addEntry" class="writer-form">
          <div class="form-group">
            <label for="text-entry">Your Text Entry:</label>
            <textarea 
              id="text-entry"
              v-model="newText" 
              placeholder="Write your text here... This will be saved securely and attributed to your account."
              class="form-control textarea-large"
            ></textarea>
          </div>
          <button type="submit" class="btn btn-primary">
            <span>➕</span> Add Entry
          </button>
        </form>
      </div>

      <div class="entries-section">
        <div class="entries-header">
          <h3>📚 Document Entries</h3>
          <span v-if="entries.length > 0" class="entry-count">{{ entries.length }} entries</span>
        </div>

        <div v-if="entries.length > 0" class="entries-list">
          <div v-for="(entry, index) in entries" :key="entry.id" class="entry-card" :style="{ animationDelay: `${index * 0.05}s` }">
            <div class="entry-header">
              <div class="entry-author-info">
                <div class="author-avatar">{{ entry.written_by.charAt(0).toUpperCase() }}</div>
                <div class="author-details">
                  <strong class="author-name">{{ entry.written_by }}</strong>
                  <time class="entry-date">{{ formatDate(entry.created_at) }}</time>
                </div>
              </div>
            </div>
            <div class="entry-body">
              {{ entry.text }}
            </div>
            <div class="entry-footer">
              <span class="entry-id">Entry #{{ entry.id }}</span>
            </div>
          </div>
        </div>

        <div v-else class="alert alert-secondary">
          <strong>📭 No Entries Yet</strong>
          <p v-if="canEdit">Be the first to contribute! Use the "Add New Entry" section above to get started.</p>
          <p v-else>No entries available yet. Check back later for shared documents.</p>
        </div>
      </div>

      <div v-if="error" class="alert alert-danger mt-3">
        <strong>❌ Error</strong>
        <p>{{ error }}</p>
      </div>
    </div>
  </div>
</template>

<script>
import { get, post } from '@/services/util/api-methods';

export default {
  name: 'DocumentsComponent',
  data() {
    return {
      token: localStorage.getItem('token'),
      entries: [],
      newText: '',
      role: null,
      canRead: false,
      canEdit: false,
      loading: true,
      error: null
    };
  },

  mounted() {
    this.fetchEntries();
    setInterval(() => this.fetchEntries(), 5000);
  },

  methods: {
    async fetchEntries() {
      try {
        const response = await get('/text-content');

        this.entries = response.entries;
        this.role = response.role;
        this.canRead = true;
        this.canEdit = response.can_edit;
        this.error = null;
      } catch (error) {
        console.error("Fetch error details:", error.details);
        console.error("Status code:", error.status);
        if (error.status === 403) {
          this.canRead = false;
          this.error = "You don't have the necessary role to access this content";
        } else if (error.status === 401) {
          this.error = 'Please log in again';
        }
      } finally {
        this.loading = false;
      }
    },

    async addEntry() {
      if (!this.newText.trim()) {
        this.error = 'Please enter some text before submitting';
        return;
      }

      try {
        const response = await post('/text-content', 
          { text: this.newText }
        );

        this.entries.unshift(response.entry);
        this.newText = '';
        this.error = null;
      } catch (error) {
        console.error("Add entry error:", error);
        if (error.status === 403) {
          this.error = 'Your role has changed. Please log in again.';
          this.fetchEntries();
        } else {
          this.error = 'Failed to add entry. Please try again.';
        }
      }
    },

    formatDate(dateString) {
      const date = new Date(dateString);
      return date.toLocaleString();
    }
  }
};
</script>

<style scoped>
.documents-container {
    max-width: 900px;
    margin: 0 auto;
    padding: 0 1rem;
}

.documents-header {
    text-align: center;
    margin-bottom: 2rem;
    padding: 2rem;
    background: linear-gradient(135deg, rgba(44, 90, 160, 0.1) 0%, rgba(212, 175, 55, 0.1) 100%);
    border-radius: 12px;
    border-left: 4px solid #d4af37;
}

.documents-header h2 {
    margin: 0 0 0.5rem 0;
    color: #1a3a52;
    font-size: 2rem;
}

.header-subtitle {
    margin: 0;
    color: #7f8c8d;
    font-size: 1rem;
}

.content-area {
    padding: 0;
}

.writer-section {
    background: white;
    border-radius: 12px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 4px 15px rgba(26, 58, 82, 0.1);
    border: 2px solid #f0f8ff;
}

.writer-header {
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #f5f7fa;
}

.writer-header h3 {
    margin: 0 0 0.5rem 0;
    color: #1a3a52;
    font-size: 1.3rem;
}

.writer-header p {
    margin: 0;
    color: #7f8c8d;
    font-size: 0.9rem;
}

.writer-form {
    margin: 0;
}

.form-group {
    margin-bottom: 1rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.6rem;
    color: #1a3a52;
    font-weight: 600;
    font-size: 0.95rem;
}

.textarea-large {
    min-height: 140px !important;
    resize: vertical;
    padding: 1rem !important;
    border: 2px solid #cbd5e0 !important;
    font-family: inherit;
    line-height: 1.5;
}

.textarea-large:focus {
    border-color: #2c5aa0 !important;
    box-shadow: 0 0 0 3px rgba(44, 90, 160, 0.1) !important;
}

.writer-form button {
    margin-top: 0.5rem;
}

.entries-section {
    margin-top: 2rem;
}

.entries-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #f5f7fa;
}

.entries-header h3 {
    margin: 0;
    color: #1a3a52;
    font-size: 1.3rem;
}

.entry-count {
    background: linear-gradient(135deg, #2c5aa0 0%, #4a7ba7 100%);
    color: white;
    padding: 0.4rem 0.9rem;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
}

.entries-list {
    display: grid;
    gap: 1.5rem;
    max-height: 600px;
    overflow-y: auto;
    padding-right: 0.5rem;
}

.entries-list::-webkit-scrollbar {
    width: 8px;
}

.entries-list::-webkit-scrollbar-track {
    background: #f5f7fa;
    border-radius: 4px;
}

.entries-list::-webkit-scrollbar-thumb {
    background: #cbd5e0;
    border-radius: 4px;
}

.entries-list::-webkit-scrollbar-thumb:hover {
    background: #2c5aa0;
}

.entry-card {
    background: white;
    border: 1px solid #e8ecf1;
    border-radius: 8px;
    padding: 1.5rem;
    box-shadow: 0 2px 8px rgba(26, 58, 82, 0.08);
    transition: all 0.3s ease;
    animation: slideInLeft 0.4s ease-out forwards;
    opacity: 0;
    border-left: 4px solid #d4af37;
}

@keyframes slideInLeft {
    from {
        opacity: 0;
        transform: translateX(-20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.entry-card:hover {
    box-shadow: 0 6px 20px rgba(26, 58, 82, 0.12);
    transform: translateY(-3px);
}

.entry-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #f5f7fa;
}

.entry-author-info {
    display: flex;
    align-items: center;
    gap: 0.8rem;
}

.author-avatar {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #2c5aa0 0%, #4a7ba7 100%);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 0.95rem;
    box-shadow: 0 2px 8px rgba(44, 90, 160, 0.2);
}

.author-details {
    display: flex;
    flex-direction: column;
    gap: 0.2rem;
}

.author-name {
    color: #1a3a52;
    font-size: 0.95rem;
}

.entry-date {
    color: #95a5a6;
    font-size: 0.8rem;
}

.entry-body {
    color: #2c3e50;
    font-size: 0.95rem;
    line-height: 1.6;
    white-space: pre-wrap;
    word-wrap: break-word;
    margin-bottom: 1rem;
    padding: 1rem;
    background: #f9f9f9;
    border-radius: 6px;
}

.entry-footer {
    display: flex;
    justify-content: flex-end;
    padding-top: 0.8rem;
    border-top: 1px solid #f5f7fa;
}

.entry-id {
    font-size: 0.75rem;
    color: #95a5a6;
    font-weight: 500;
}

.alert {
    padding: 1.2rem;
    border-radius: 8px;
    border-left: 4px solid;
    margin-bottom: 1.5rem;
    box-shadow: 0 2px 8px rgba(26, 58, 82, 0.08);
}

.alert strong {
    display: block;
    margin-bottom: 0.5rem;
}

.alert p {
    margin: 0.3rem 0;
}

.alert-danger {
    background: #f8d7da;
    border-left-color: #f44336;
    color: #721c24;
}

.alert-warning {
    background: #fff3cd;
    border-left-color: #ffc107;
    color: #856404;
}

.alert-info {
    background: #d1ecf1;
    border-left-color: #17a2b8;
    color: #0c5460;
}

.alert-secondary {
    background: #e9ecef;
    border-left-color: #6c757d;
    color: #383d41;
}

.mt-3 {
    margin-top: 0.75rem;
}

@media (max-width: 768px) {
    .documents-header {
        padding: 1.5rem 1rem;
    }
    
    .documents-header h2 {
        font-size: 1.5rem;
    }
    
    .writer-section {
        padding: 1.5rem;
    }
    
    .entry-card {
        padding: 1rem;
    }
    
    .entry-body {
        font-size: 0.9rem;
    }
    
    .entries-list {
        max-height: 400px;
    }
}
</style>