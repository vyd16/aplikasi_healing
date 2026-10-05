{{-- ============================================
     HealPoint – HealBot Floating AI Chatbot Widget
     Powered by Google Gemini
     ============================================ --}}

<div id="healbot-container" class="healbot-widget">
    {{-- Floating Toggle Button --}}
    <button id="healbot-toggle-btn" class="healbot-toggle-btn" aria-label="Buka Chatbot HealBot" title="Tanya HealBot AI ✨">
        <span class="healbot-pulse-ring"></span>
        <span class="material-symbols-outlined healbot-open-icon">smart_toy</span>
        <span class="material-symbols-outlined healbot-close-icon">close</span>
        <span class="healbot-badge-dot" title="Online"></span>
    </button>

    {{-- Chat Window Box --}}
    <div id="healbot-window" class="healbot-window" style="display: none;">
        {{-- Header --}}
        <div class="healbot-header">
            <div class="healbot-header-info">
                <div class="healbot-avatar">
                    <span class="material-symbols-outlined">spa</span>
                    <span class="healbot-online-badge"></span>
                </div>
                <div class="healbot-titles">
                    <div class="d-flex align-items-center gap-1">
                        <h6 class="mb-0 healbot-name">HealBot</h6>
                        <span class="healbot-ai-tag">Gemini AI</span>
                    </div>
                    <span class="healbot-status">Teman healing & asisten wisatamu</span>
                </div>
            </div>
            <div class="healbot-header-actions">
                <button type="button" id="healbot-reset-btn" class="healbot-action-icon" title="Hapus riwayat chat">
                    <span class="material-symbols-outlined">restart_alt</span>
                </button>
                <button type="button" id="healbot-close-btn" class="healbot-action-icon" title="Tutup">
                    <span class="material-symbols-outlined">expand_more</span>
                </button>
            </div>
        </div>

        {{-- Chat Messages Area --}}
        <div id="healbot-messages" class="healbot-messages">
            {{-- Initial Greeting --}}
            <div class="healbot-msg healbot-msg-bot">
                <div class="healbot-msg-avatar">
                    <span class="material-symbols-outlined">spa</span>
                </div>
                <div class="healbot-msg-bubble">
                    <p class="mb-2">Halo! Aku <strong>HealBot</strong> 🌿</p>
                    <p class="mb-0">Mau cari rekomendasi tempat healing yang tenang, curug sejuk, atau spot camping di Cirebon, Kuningan, & Majalengka? Ceritakan suasana apa yang kamu butuhkan hari ini!</p>
                </div>
            </div>

            {{-- Quick Suggestion Chips --}}
            <div id="healbot-quick-chips" class="healbot-chips-wrapper">
                <span class="healbot-chips-title">Coba tanyakan ini:</span>
                <div class="healbot-chips">
                    <button type="button" class="healbot-chip" data-prompt="Rekomendasikan tempat healing yang sejuk dan tenang di Kuningan">
                        🌲 Spot sejuk di Kuningan
                    </button>
                    <button type="button" class="healbot-chip" data-prompt="Apa saja curug terbaik untuk menenangkan pikiran di Majalengka?">
                        💧 Curug di Majalengka
                    </button>
                    <button type="button" class="healbot-chip" data-prompt="Tempat healing yang ada fasilitas camping dan musholla">
                        ⛺ Spot camping & musholla
                    </button>
                    <button type="button" class="healbot-chip" data-prompt="Buatkan itinerary 1 hari untuk healing santai di daerah Ciayumajakuning">
                        🗺️ Saran Itinerary 1 Hari
                    </button>
                </div>
            </div>

            {{-- Dynamic Messages will be appended here --}}
        </div>

        {{-- Typing Indicator --}}
        <div id="healbot-typing" class="healbot-typing" style="display: none;">
            <div class="healbot-msg-avatar">
                <span class="material-symbols-outlined">spa</span>
            </div>
            <div class="healbot-typing-bubble">
                <span class="healbot-dot"></span>
                <span class="healbot-dot"></span>
                <span class="healbot-dot"></span>
                <span class="ms-1" style="font-size: 0.8rem; color: var(--text-muted);">HealBot sedang berpikir...</span>
            </div>
        </div>

        {{-- Chat Input Form --}}
        <form id="healbot-form" class="healbot-input-area" onsubmit="return false;">
            <div class="healbot-input-wrapper">
                <textarea 
                    id="healbot-input" 
                    rows="1" 
                    placeholder="Tanyakan rekomendasi tempat healing..."
                    maxlength="1000"
                    aria-label="Ketik pesan untuk HealBot"
                ></textarea>
                <button type="button" id="healbot-send-btn" class="healbot-send-btn" title="Kirim Pesan">
                    <span class="material-symbols-outlined">send</span>
                </button>
            </div>
            <div class="healbot-footer-hint">
                Tekan <strong>Enter</strong> untuk kirim, <strong>Shift+Enter</strong> baris baru
            </div>
        </form>
    </div>
</div>

<style>
/* ========================================================
   HealBot Widget Styles – Sanctuary Warm Aesthetic
   ======================================================== */
.healbot-widget {
    position: fixed;
    bottom: 24px;
    right: 24px;
    z-index: 1060;
    font-family: 'Plus Jakarta Sans', sans-serif;
}

@media (max-width: 768px) {
    .healbot-widget {
        bottom: 84px; /* avoid mobile bottom navigation */
        right: 16px;
    }
}

/* --- Floating Button --- */
.healbot-toggle-btn {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--color-accent) 0%, var(--color-accent-hover, #ba5c2d) 100%);
    color: #ffffff;
    border: none;
    cursor: pointer;
    box-shadow: 0 8px 24px rgba(154, 68, 23, 0.35);
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    transition: transform 0.25s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.25s ease;
    outline: none;
}

.healbot-toggle-btn:hover {
    transform: scale(1.08);
    box-shadow: 0 12px 30px rgba(154, 68, 23, 0.45);
}

.healbot-toggle-btn:active {
    transform: scale(0.95);
}

.healbot-open-icon,
.healbot-close-icon {
    font-size: 28px;
    transition: opacity 0.2s ease, transform 0.25s ease;
}

.healbot-widget:not(.active) .healbot-close-icon {
    display: none;
}

.healbot-widget.active .healbot-open-icon {
    display: none;
}

.healbot-badge-dot {
    position: absolute;
    top: 3px;
    right: 3px;
    width: 14px;
    height: 14px;
    background: #22c55e;
    border: 2.5px solid #ffffff;
    border-radius: 50%;
}

.healbot-pulse-ring {
    position: absolute;
    top: -4px;
    left: -4px;
    right: -4px;
    bottom: -4px;
    border-radius: 50%;
    border: 2px solid var(--color-accent);
    opacity: 0.7;
    animation: healbot-pulse 2.5s infinite;
    pointer-events: none;
}

@keyframes healbot-pulse {
    0% { transform: scale(0.95); opacity: 0.8; }
    50% { transform: scale(1.15); opacity: 0; }
    100% { transform: scale(1.15); opacity: 0; }
}

/* --- Chat Window --- */
.healbot-window {
    position: absolute;
    bottom: 74px;
    right: 0;
    width: 380px;
    max-width: calc(100vw - 32px);
    height: 540px;
    max-height: calc(100vh - 120px);
    background: var(--card-bg, #ffffff);
    border: 1px solid var(--card-border, rgba(220, 193, 182, 0.4));
    border-radius: 20px;
    box-shadow: 0 16px 48px -8px rgba(62, 43, 31, 0.25), 0 0 0 1px rgba(154, 68, 23, 0.05);
    display: flex;
    flex-direction: column;
    overflow: hidden;
    transform-origin: bottom right;
    animation: healbot-slide-up 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    backdrop-filter: blur(12px);
}

@keyframes healbot-slide-up {
    from {
        opacity: 0;
        transform: scale(0.85) translateY(20px);
    }
    to {
        opacity: 1;
        transform: scale(1) translateY(0);
    }
}

/* --- Header --- */
.healbot-header {
    background: linear-gradient(135deg, var(--color-accent) 0%, var(--color-accent-hover, #ba5c2d) 100%);
    color: #ffffff;
    padding: 14px 18px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-shrink: 0;
}

.healbot-header-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.healbot-avatar {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    color: #ffffff;
}

.healbot-avatar .material-symbols-outlined {
    font-size: 22px;
}

.healbot-online-badge {
    position: absolute;
    bottom: 0;
    right: 0;
    width: 10px;
    height: 10px;
    background: #22c55e;
    border: 2px solid var(--color-accent);
    border-radius: 50%;
}

.healbot-name {
    font-weight: 700;
    font-size: 1rem;
    color: #ffffff;
    line-height: 1.2;
}

.healbot-ai-tag {
    font-size: 0.65rem;
    background: rgba(255, 255, 255, 0.25);
    color: #ffffff;
    padding: 1px 6px;
    border-radius: 99px;
    font-weight: 600;
    letter-spacing: 0.3px;
}

.healbot-status {
    font-size: 0.75rem;
    color: rgba(255, 255, 255, 0.85);
}

.healbot-header-actions {
    display: flex;
    align-items: center;
    gap: 6px;
}

.healbot-action-icon {
    background: rgba(255, 255, 255, 0.15);
    border: none;
    color: #ffffff;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: background 0.2s ease, transform 0.15s ease;
}

.healbot-action-icon:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: scale(1.05);
}

.healbot-action-icon .material-symbols-outlined {
    font-size: 18px;
}

/* --- Messages Area --- */
.healbot-messages {
    flex: 1;
    overflow-y: auto;
    padding: 16px;
    display: flex;
    flex-direction: column;
    gap: 14px;
    background: var(--bg-primary, #fef9ed);
    scroll-behavior: smooth;
}

.healbot-messages::-webkit-scrollbar {
    width: 6px;
}

.healbot-messages::-webkit-scrollbar-thumb {
    background: var(--input-border, #dcc1b6);
    border-radius: 10px;
}

/* --- Message Bubbles --- */
.healbot-msg {
    display: flex;
    gap: 8px;
    max-width: 88%;
}

.healbot-msg-bot {
    align-self: flex-start;
}

.healbot-msg-user {
    align-self: flex-end;
    flex-direction: row-reverse;
}

.healbot-msg-avatar {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background: var(--color-accent-light, rgba(154, 68, 23, 0.1));
    color: var(--color-accent);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    margin-top: 2px;
}

.healbot-msg-avatar .material-symbols-outlined {
    font-size: 16px;
}

.healbot-msg-bubble {
    padding: 11px 14px;
    font-size: 0.88rem;
    line-height: 1.5;
    word-break: break-word;
}

.healbot-msg-bot .healbot-msg-bubble {
    background: var(--card-bg, #ffffff);
    color: var(--text-primary, #1d1c15);
    border-radius: 16px 16px 16px 4px;
    border: 1px solid var(--card-border, rgba(220, 193, 182, 0.4));
    box-shadow: 0 2px 8px rgba(62, 43, 31, 0.04);
}

.healbot-msg-user .healbot-msg-bubble {
    background: var(--color-accent, #9a4417);
    color: #ffffff;
    border-radius: 16px 16px 4px 16px;
}

.healbot-msg-bubble p {
    margin-bottom: 8px;
}

.healbot-msg-bubble p:last-child {
    margin-bottom: 0;
}

.healbot-msg-bubble ul,
.healbot-msg-bubble ol {
    margin-top: 6px;
    margin-bottom: 6px;
    padding-left: 20px;
}

.healbot-msg-bubble li {
    margin-bottom: 4px;
}

/* Link rekomendasi lokasi */
.healbot-link {
    display: inline-flex;
    align-items: center;
    gap: 3px;
    background: var(--color-accent-light, rgba(154, 68, 23, 0.08));
    color: var(--color-accent, #9a4417);
    font-weight: 600;
    padding: 2px 8px;
    border-radius: 6px;
    text-decoration: none;
    border: 1px solid rgba(154, 68, 23, 0.2);
    transition: all 0.15s ease;
    margin: 2px 0;
}

.healbot-link:hover {
    background: var(--color-accent, #9a4417);
    color: #ffffff !important;
}

/* --- Quick Chips --- */
.healbot-chips-wrapper {
    margin-top: 4px;
}

.healbot-chips-title {
    display: block;
    font-size: 0.75rem;
    color: var(--text-muted, #897269);
    margin-bottom: 6px;
    font-weight: 600;
}

.healbot-chips {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.healbot-chip {
    text-align: left;
    background: var(--card-bg, #ffffff);
    border: 1px solid var(--input-border, #dcc1b6);
    color: var(--text-secondary, #56433b);
    padding: 7px 12px;
    border-radius: 12px;
    font-size: 0.78rem;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    line-height: 1.3;
}

.healbot-chip:hover {
    background: var(--color-accent-light, rgba(154, 68, 23, 0.08));
    border-color: var(--color-accent);
    color: var(--color-accent);
    transform: translateX(3px);
}

/* --- Typing Indicator --- */
.healbot-typing {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 0 16px 8px;
    background: var(--bg-primary, #fef9ed);
}

.healbot-typing-bubble {
    background: var(--card-bg, #ffffff);
    border: 1px solid var(--card-border, rgba(220, 193, 182, 0.4));
    padding: 8px 14px;
    border-radius: 16px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.healbot-dot {
    width: 6px;
    height: 6px;
    background: var(--color-accent, #9a4417);
    border-radius: 50%;
    animation: healbot-bounce 1.4s infinite ease-in-out both;
}

.healbot-dot:nth-child(1) { animation-delay: -0.32s; }
.healbot-dot:nth-child(2) { animation-delay: -0.16s; }

@keyframes healbot-bounce {
    0%, 80%, 100% { transform: scale(0.6); opacity: 0.4; }
    40% { transform: scale(1.1); opacity: 1; }
}

/* --- Input Area --- */
.healbot-input-area {
    padding: 12px 14px;
    background: var(--card-bg, #ffffff);
    border-top: 1px solid var(--card-border, rgba(220, 193, 182, 0.4));
    flex-shrink: 0;
}

.healbot-input-wrapper {
    display: flex;
    align-items: center;
    gap: 8px;
    background: var(--input-bg, #ede8dc);
    border: 1px solid var(--input-border, #dcc1b6);
    border-radius: 24px;
    padding: 4px 6px 4px 14px;
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
}

.healbot-input-wrapper:focus-within {
    border-color: var(--color-accent);
    box-shadow: 0 0 0 3px var(--color-accent-light, rgba(154, 68, 23, 0.12));
}

#healbot-input {
    flex: 1;
    border: none;
    background: transparent;
    color: var(--text-primary, #1d1c15);
    font-size: 0.88rem;
    outline: none;
    resize: none;
    max-height: 80px;
    line-height: 1.4;
    padding: 6px 0;
    font-family: inherit;
}

#healbot-input::placeholder {
    color: var(--text-muted, #897269);
    font-size: 0.82rem;
}

.healbot-send-btn {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: var(--color-accent, #9a4417);
    color: #ffffff;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: transform 0.15s ease, background 0.15s ease, opacity 0.15s ease;
    flex-shrink: 0;
}

.healbot-send-btn:hover:not(:disabled) {
    background: var(--color-accent-hover, #ba5c2d);
    transform: scale(1.06);
}

.healbot-send-btn:disabled {
    opacity: 0.4;
    cursor: not-allowed;
}

.healbot-send-btn .material-symbols-outlined {
    font-size: 18px;
}

.healbot-footer-hint {
    font-size: 0.68rem;
    color: var(--text-muted, #897269);
    text-align: center;
    margin-top: 6px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('healbot-container');
    const toggleBtn = document.getElementById('healbot-toggle-btn');
    const windowEl = document.getElementById('healbot-window');
    const closeBtn = document.getElementById('healbot-close-btn');
    const resetBtn = document.getElementById('healbot-reset-btn');
    const form = document.getElementById('healbot-form');
    const input = document.getElementById('healbot-input');
    const sendBtn = document.getElementById('healbot-send-btn');
    const messagesEl = document.getElementById('healbot-messages');
    const typingEl = document.getElementById('healbot-typing');
    const quickChipsEl = document.getElementById('healbot-quick-chips');

    // Riwayat percakapan untuk context multi-turn
    let conversationHistory = [];
    let isSending = false;

    // Toggle Chat Window
    function toggleChat() {
        const isOpen = windowEl.style.display !== 'none';
        if (isOpen) {
            windowEl.style.display = 'none';
            container.classList.remove('active');
        } else {
            windowEl.style.display = 'flex';
            container.classList.add('active');
            scrollToBottom();
            setTimeout(() => input.focus(), 150);
        }
    }

    toggleBtn.addEventListener('click', toggleChat);
    closeBtn.addEventListener('click', toggleChat);

    // Reset Chat
    resetBtn.addEventListener('click', () => {
        if (confirm('Mulai ulang percakapan dengan HealBot?')) {
            conversationHistory = [];
            // Kembalikan ke tampilan awal
            messagesEl.innerHTML = `
                <div class="healbot-msg healbot-msg-bot">
                    <div class="healbot-msg-avatar">
                        <span class="material-symbols-outlined">spa</span>
                    </div>
                    <div class="healbot-msg-bubble">
                        <p class="mb-2">Halo! Aku <strong>HealBot</strong> 🌿</p>
                        <p class="mb-0">Ada yang ingin kamu tanyakan lagi tentang rekomendasi tempat healing di Cirebon, Kuningan, atau Majalengka?</p>
                    </div>
                </div>
            `;
            if (quickChipsEl) {
                messagesEl.appendChild(quickChipsEl);
            }
            scrollToBottom();
        }
    });

    // Auto-scroll to bottom of messages
    function scrollToBottom() {
        messagesEl.scrollTop = messagesEl.scrollHeight;
    }

    // Markdown Parser Sederhana untuk link, bold, list, dan baris baru
    function parseMarkdown(text) {
        if (!text) return '';
        let escaped = text
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');

        // Links: [Text](URL) -> <a href="URL" class="healbot-link">Text</a>
        escaped = escaped.replace(/\[([^\]]+)\]\(([^)]+)\)/g, function(match, linkText, url) {
            return `<a href="${url}" class="healbot-link" target="_self">${linkText} <span class="material-symbols-outlined" style="font-size:12px;vertical-align:middle;">open_in_new</span></a>`;
        });

        // Bold: **text** or __text__
        escaped = escaped.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');

        // Italic: *text*
        escaped = escaped.replace(/\*(.*?)\*/g, '<em>$1</em>');

        // Unordered lists (- item or * item)
        const lines = escaped.split('\n');
        let inList = false;
        let result = [];

        for (let line of lines) {
            const listMatch = line.match(/^\s*[-*]\s+(.*)/);
            if (listMatch) {
                if (!inList) {
                    inList = true;
                    result.push('<ul class="ps-3 mb-2">');
                }
                result.push(`<li>${listMatch[1]}</li>`);
            } else {
                if (inList) {
                    inList = false;
                    result.push('</ul>');
                }
                if (line.trim() !== '') {
                    result.push(`<p class="mb-2">${line}</p>`);
                }
            }
        }
        if (inList) result.push('</ul>');

        return result.join('');
    }

    // Append user message
    function appendUserMessage(text) {
        const msgDiv = document.createElement('div');
        msgDiv.className = 'healbot-msg healbot-msg-user';
        msgDiv.innerHTML = `
            <div class="healbot-msg-bubble">
                ${text.replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/\n/g, '<br>')}
            </div>
        `;
        messagesEl.appendChild(msgDiv);
        scrollToBottom();
    }

    // Append bot message
    function appendBotMessage(htmlContent) {
        const msgDiv = document.createElement('div');
        msgDiv.className = 'healbot-msg healbot-msg-bot';
        msgDiv.innerHTML = `
            <div class="healbot-msg-avatar">
                <span class="material-symbols-outlined">spa</span>
            </div>
            <div class="healbot-msg-bubble">
                ${htmlContent}
            </div>
        `;
        messagesEl.appendChild(msgDiv);
        scrollToBottom();
    }

    // Send Message Logic
    async function sendMessage(textToSend) {
        const text = (textToSend || input.value).trim();
        if (!text || isSending) return;

        isSending = true;
        sendBtn.disabled = true;
        input.value = '';
        input.style.height = 'auto';

        // Sembunyikan quick chips setelah user mengirim pesan pertama
        if (quickChipsEl && quickChipsEl.parentNode) {
            quickChipsEl.style.display = 'none';
        }

        // Tampilkan pesan user
        appendUserMessage(text);

        // Tampilkan indikator mengetik
        typingEl.style.display = 'flex';
        scrollToBottom();

        // Siapkan CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

        try {
            const response = await fetch("{{ route('chatbot.send') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    message: text,
                    history: conversationHistory
                })
            });

            const data = await response.json();

            // Sembunyikan indikator mengetik
            typingEl.style.display = 'none';

            if (data.success && data.reply) {
                // Simpan ke riwayat untuk turn berikutnya
                conversationHistory.push({ role: 'user', text: text });
                conversationHistory.push({ role: 'model', text: data.reply });

                const parsed = parseMarkdown(data.reply);
                appendBotMessage(parsed);
            } else {
                const errMsg = data.message || 'Maaf, terjadi kesalahan saat menghubungi HealBot. Silakan coba lagi.';
                appendBotMessage(`<p class="text-danger mb-0">${errMsg}</p>`);
            }
        } catch (error) {
            typingEl.style.display = 'none';
            console.error('HealBot Error:', error);
            appendBotMessage('<p class="text-danger mb-0">Maaf, koneksi terputus. Pastikan kamu terhubung ke internet dan coba kembali.</p>');
        } finally {
            isSending = false;
            sendBtn.disabled = false;
            setTimeout(() => input.focus(), 50);
            scrollToBottom();
        }
    }

    // Event listener kirim form
    sendBtn.addEventListener('click', () => sendMessage());

    // Enter key handling
    input.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendMessage();
        }
    });

    // Auto-expand textarea
    input.addEventListener('input', () => {
        input.style.height = 'auto';
        input.style.height = Math.min(input.scrollHeight, 80) + 'px';
    });

    // Quick Chips delegation
    document.addEventListener('click', (e) => {
        const chip = e.target.closest('.healbot-chip');
        if (chip) {
            const prompt = chip.getAttribute('data-prompt');
            if (prompt) {
                sendMessage(prompt);
            }
        }
    });
});
</script>
