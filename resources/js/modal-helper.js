/**
 * BIMASADA Modal & Notification Helper - REBUILT
 */

// Modal System
window.Modal = {
    show(id) {
        const m = document.getElementById(id);
        if (m) { m.classList.remove('hidden'); document.body.style.overflow = 'hidden'; }
    },
    hide(id) {
        const m = document.getElementById(id);
        if (m) { m.classList.add('hidden'); document.body.style.overflow = ''; }
    },
    
    confirmDelete(opts = {}) {
        const {modalId = 'confirm-delete-modal', title = 'Konfirmasi Hapus', message = 'Yakin hapus?', itemName = '', onConfirm = () => {}, onCancel = () => {}} = opts;
        const m = document.getElementById(modalId);
        if (!m) return;
        
        m.querySelector('.modal-title').textContent = title;
        m.querySelector('.modal-message').textContent = message;
        const item = m.querySelector('.modal-item-name');
        if (itemName) { item.classList.remove('hidden'); item.querySelector('p').textContent = itemName; } else { item.classList.add('hidden'); }
        
        const conf = m.querySelector('.modal-confirm');
        const canc = m.querySelector('.modal-cancel');
        const newConf = conf.cloneNode(true);
        const newCanc = canc.cloneNode(true);
        conf.replaceWith(newConf);
        canc.replaceWith(newCanc);
        
        newConf.onclick = () => { this.hide(modalId); onConfirm(); };
        newCanc.onclick = () => { this.hide(modalId); onCancel(); };
        
        const esc = (e) => { if (e.key === 'Escape') { this.hide(modalId); onCancel(); document.removeEventListener('keydown', esc); } };
        document.addEventListener('keydown', esc);
        
        this.show(modalId);
    },
    
    alert(opts = {}) {
        const {modalId = 'alert-modal', title = 'Alert', message = '', onConfirm = () => {}} = opts;
        const m = document.getElementById(modalId);
        if (!m) return;
        
        m.querySelector('.modal-title').textContent = title;
        m.querySelector('.modal-message').textContent = message;
        const conf = m.querySelector('.modal-confirm');
        const newConf = conf.cloneNode(true);
        conf.replaceWith(newConf);
        newConf.onclick = () => { this.hide(modalId); onConfirm(); };
        
        const esc = (e) => { if (e.key === 'Escape') { this.hide(modalId); onConfirm(); document.removeEventListener('keydown', esc); } };
        document.addEventListener('keydown', esc);
        
        this.show(modalId);
    },
    
    confirm(opts = {}) {
        const {modalId = 'confirm-modal', title = 'Konfirmasi', message = 'Yakin?', onConfirm = () => {}, onCancel = () => {}} = opts;
        const m = document.getElementById(modalId);
        if (!m) return;
        
        m.querySelector('.modal-title').textContent = title;
        m.querySelector('.modal-message').textContent = message;
        const conf = m.querySelector('.modal-confirm');
        const canc = m.querySelector('.modal-cancel');
        const newConf = conf.cloneNode(true);
        const newCanc = canc.cloneNode(true);
        conf.replaceWith(newConf);
        canc.replaceWith(newCanc);
        
        newConf.onclick = () => { this.hide(modalId); onConfirm(); };
        newCanc.onclick = () => { this.hide(modalId); onCancel(); };
        
        const esc = (e) => { if (e.key === 'Escape') { this.hide(modalId); onCancel(); document.removeEventListener('keydown', esc); } };
        document.addEventListener('keydown', esc);
        
        this.show(modalId);
    }
};

// Notification System
window.Notification = {
    create(title, msg, type = 'info', dur = 5000) {
        const cont = document.getElementById('notification-container');
        if (!cont) { console.error('notification-container not found'); return; }
        
        const tmpl = document.getElementById('notification-template');
        if (!tmpl) { console.error('notification-template not found'); return; }
        
        const notif = tmpl.content.cloneNode(true).querySelector('.notification-item');
        if (!notif) { console.error('notification-item not found in template'); return; }
        
        // Show appropriate icon
        const iconClass = `notification-icon-${type}`;
        const iconEl = notif.querySelector(`.${iconClass}`);
        if (iconEl) iconEl.classList.remove('hidden');
        
        // Set content
        const titleEl = notif.querySelector('.notification-title');
        if (titleEl) titleEl.textContent = title;
        
        const msgEl = notif.querySelector('.notification-message');
        if (msgEl) msgEl.textContent = msg;
        
        // Progress bar config
        const progColors = {
            success: 'bg-emerald-500',
            error: 'bg-red-500',
            warning: 'bg-amber-500',
            info: 'bg-blue-500'
        };
        const progBar = notif.querySelector('.notification-progress-bar');
        if (progBar) progBar.classList.add(...(progColors[type] || progColors.info).split(' '));
        
        cont.appendChild(notif);
        
        const close = () => {
            notif.style.opacity = '0';
            notif.style.transform = 'translateX(100%)';
            setTimeout(() => notif.remove(), 300);
        };
        
        const closeBtn = notif.querySelector('button');
        if (closeBtn) closeBtn.onclick = close;
        
        if (dur > 0) {
            if (progBar) {
                progBar.style.width = '100%';
                progBar.style.transition = `width ${dur}ms linear`;
                setTimeout(() => { if (progBar) progBar.style.width = '0%'; }, 10);
            }
            setTimeout(close, dur);
        } else {
            const progContainer = notif.querySelector('.notification-progress');
            if (progContainer) progContainer.style.display = 'none';
        }
    },
    success(t, m, d) { this.create(t, m, 'success', d); },
    error(t, m, d) { this.create(t, m, 'error', d); },
    warning(t, m, d) { this.create(t, m, 'warning', d); },
    info(t, m, d) { this.create(t, m, 'info', d); }
};

// Auto show session notifications
document.addEventListener('DOMContentLoaded', () => {
    if (window.sessionNotifications && typeof window.sessionNotifications === 'object') {
        Object.keys(window.sessionNotifications).forEach(type => {
            const msg = window.sessionNotifications[type];
            if (msg && Notification[type]) {
                const titles = { success: 'Berhasil!', error: 'Error!', warning: 'Perhatian!', info: 'Informasi', status: 'Status' };
                Notification[type](titles[type] || 'Notifikasi', msg);
            }
        });
    }
});
