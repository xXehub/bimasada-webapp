/**
 * BIMASADA Modal & Notification Helper
 * Reusable modal and notification system
 */

// ============================================
// MODAL SYSTEM
// ============================================
window.Modal = {
    // Show modal
    show(modalId) {
        const modal = document.getElementById(modalId);
        if (!modal) return;
        
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        
        // Animate backdrop
        const backdrop = modal.querySelector('.modal-backdrop');
        const panel = modal.querySelector('.modal-panel');
        
        requestAnimationFrame(() => {
            backdrop.style.opacity = '1';
            panel.style.transform = 'scale(1)';
            panel.style.opacity = '1';
        });
    },
    
    // Hide modal
    hide(modalId) {
        const modal = document.getElementById(modalId);
        if (!modal) return;
        
        const backdrop = modal.querySelector('.modal-backdrop');
        const panel = modal.querySelector('.modal-panel');
        
        backdrop.style.opacity = '0';
        panel.style.transform = 'scale(0.95)';
        panel.style.opacity = '0';
        
        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }, 200);
    },
    
    // Confirm Delete Modal
    confirmDelete(options = {}) {
        const {
            modalId = 'confirm-delete-modal',
            title = 'Konfirmasi Hapus',
            message = 'Apakah Anda yakin ingin menghapus data ini?',
            itemName = '',
            onConfirm = () => {},
            onCancel = () => {}
        } = options;
        
        const modal = document.getElementById(modalId);
        if (!modal) {
            console.error(`Modal with id "${modalId}" not found`);
            return;
        }
        
        // Update content
        const modalTitle = modal.querySelector('.modal-title, #modal-title');
        const modalMessage = modal.querySelector('.modal-message');
        const modalItemName = modal.querySelector('.modal-item-name');
        
        if (modalTitle) modalTitle.textContent = title;
        if (modalMessage) modalMessage.textContent = message;
        
        if (itemName && modalItemName) {
            modalItemName.classList.remove('hidden');
            modalItemName.querySelector('span').textContent = itemName;
        } else if (modalItemName) {
            modalItemName.classList.add('hidden');
        }
        
        // Setup event handlers
        const confirmBtn = modal.querySelector('.modal-confirm');
        const cancelBtn = modal.querySelector('.modal-cancel');
        const backdrop = modal.querySelector('.modal-backdrop');
        
        // Remove old event listeners by cloning
        const newConfirmBtn = confirmBtn.cloneNode(true);
        const newCancelBtn = cancelBtn.cloneNode(true);
        confirmBtn.parentNode.replaceChild(newConfirmBtn, confirmBtn);
        cancelBtn.parentNode.replaceChild(newCancelBtn, cancelBtn);
        
        // Add new event listeners
        newConfirmBtn.addEventListener('click', () => {
            this.hide(modalId);
            onConfirm();
        });
        
        newCancelBtn.addEventListener('click', () => {
            this.hide(modalId);
            onCancel();
        });
        
        backdrop.addEventListener('click', () => {
            this.hide(modalId);
            onCancel();
        });
        
        // Show modal
        this.show(modalId);
    },
    
    // Alert Modal
    alert(options = {}) {
        const {
            modalId = 'alert-modal',
            type = 'info', // success, error, warning, info
            title = 'Alert',
            message = '',
            onConfirm = () => {}
        } = options;
        
        const modal = document.getElementById(modalId);
        if (!modal) {
            console.error(`Modal with id "${modalId}" not found`);
            return;
        }
        
        // Update content
        const modalTitle = modal.querySelector('.modal-title');
        const modalMessage = modal.querySelector('.modal-message');
        
        if (modalTitle) modalTitle.textContent = title;
        if (modalMessage) modalMessage.textContent = message;
        
        // Setup event handlers
        const confirmBtn = modal.querySelector('.modal-confirm');
        const backdrop = modal.querySelector('.modal-backdrop');
        
        // Remove old event listeners by cloning
        const newConfirmBtn = confirmBtn.cloneNode(true);
        confirmBtn.parentNode.replaceChild(newConfirmBtn, confirmBtn);
        
        // Add new event listener
        newConfirmBtn.addEventListener('click', () => {
            this.hide(modalId);
            onConfirm();
        });
        
        backdrop.addEventListener('click', () => {
            this.hide(modalId);
            onConfirm();
        });
        
        // Show modal
        this.show(modalId);
    },
    
    // Confirm Modal
    confirm(options = {}) {
        const {
            modalId = 'confirm-modal',
            title = 'Konfirmasi',
            message = 'Apakah Anda yakin?',
            onConfirm = () => {},
            onCancel = () => {}
        } = options;
        
        const modal = document.getElementById(modalId);
        if (!modal) {
            console.error(`Modal with id "${modalId}" not found`);
            return;
        }
        
        // Update content
        const modalTitle = modal.querySelector('.modal-title');
        const modalMessage = modal.querySelector('.modal-message');
        
        if (modalTitle) modalTitle.textContent = title;
        if (modalMessage) modalMessage.textContent = message;
        
        // Setup event handlers
        const confirmBtn = modal.querySelector('.modal-confirm');
        const cancelBtn = modal.querySelector('.modal-cancel');
        const backdrop = modal.querySelector('.modal-backdrop');
        
        // Remove old event listeners by cloning
        const newConfirmBtn = confirmBtn.cloneNode(true);
        const newCancelBtn = cancelBtn.cloneNode(true);
        confirmBtn.parentNode.replaceChild(newConfirmBtn, confirmBtn);
        cancelBtn.parentNode.replaceChild(newCancelBtn, cancelBtn);
        
        // Add new event listeners
        newConfirmBtn.addEventListener('click', () => {
            this.hide(modalId);
            onConfirm();
        });
        
        newCancelBtn.addEventListener('click', () => {
            this.hide(modalId);
            onCancel();
        });
        
        backdrop.addEventListener('click', () => {
            this.hide(modalId);
            onCancel();
        });
        
        // Show modal
        this.show(modalId);
    }
};

// ============================================
// UTILITY FUNCTIONS
// ============================================

// Handle AJAX delete with confirmation
window.deleteWithConfirm = function(url, itemName = '', onSuccess = null, onError = null) {
    Modal.confirmDelete({
        itemName: itemName,
        onConfirm: () => {
            // Show loading notification
            const loadingNotif = Notification.info('Menghapus...', 'Sedang menghapus data', 0);
            
            // Perform delete
            fetch(url, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                // Remove loading notification
                if (loadingNotif) loadingNotif.remove();
                
                if (data.success) {
                    Notification.success('Berhasil!', data.message || 'Data berhasil dihapus');
                    if (onSuccess) onSuccess(data);
                } else {
                    Notification.error('Gagal!', data.message || 'Gagal menghapus data');
                    if (onError) onError(data);
                }
            })
            .catch(error => {
                // Remove loading notification
                if (loadingNotif) loadingNotif.remove();
                
                Notification.error('Error!', 'Terjadi kesalahan saat menghapus data');
                if (onError) onError(error);
            });
        }
    });
};

// Show Laravel validation errors
window.showValidationErrors = function(errors) {
    const errorMessages = Object.values(errors).flat();
    const message = errorMessages.join('\n');
    
    Notification.error(
        'Validasi Gagal',
        errorMessages[0], // Show first error
        7000
    );
    
    // Show all errors if more than one
    if (errorMessages.length > 1) {
        errorMessages.slice(1).forEach((msg, index) => {
            setTimeout(() => {
                Notification.error('Error', msg, 7000);
            }, (index + 1) * 300);
        });
    }
};

// Initialize modal animations
document.addEventListener('DOMContentLoaded', function() {
    // Setup modal animations
    document.querySelectorAll('.modal').forEach(modal => {
        const backdrop = modal.querySelector('.modal-backdrop');
        const panel = modal.querySelector('.modal-panel');
        
        if (backdrop) {
            backdrop.style.transition = 'opacity 0.2s ease-out';
            backdrop.style.opacity = '0';
        }
        
        if (panel) {
            panel.style.transition = 'all 0.2s ease-out';
            panel.style.transform = 'scale(0.95)';
            panel.style.opacity = '0';
        }
    });
    
    // Close modal on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('.modal:not(.hidden)').forEach(modal => {
                Modal.hide(modal.id);
            });
        }
    });
    
    // Auto-show session notifications
    // This will work globally without needing to add script to each page
    const sessionData = window.sessionNotifications || {};
    
    if (sessionData.success) {
        Notification.success('Berhasil!', sessionData.success);
    }
    if (sessionData.error) {
        Notification.error('Error!', sessionData.error);
    }
    if (sessionData.warning) {
        Notification.warning('Peringatan!', sessionData.warning);
    }
    if (sessionData.info) {
        Notification.info('Info', sessionData.info);
    }
    if (sessionData.status) {
        Notification.success('Berhasil!', sessionData.status);
    }
});
