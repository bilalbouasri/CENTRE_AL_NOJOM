/**
 * Modal management system
 */

export class ModalManager {
    constructor() {
        this.modals = new Map();
        this.init();
    }

    /**
     * Initialize modal system
     */
    init() {
        // Add event listeners for Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                this.closeAllModals();
            }
        });

        // Add event listeners for outside clicks
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('modal-backdrop')) {
                this.closeAllModals();
            }
        });
    }

    /**
     * Register a modal
     */
    register(modalId, options = {}) {
        const modal = document.getElementById(modalId);
        if (!modal) {
            console.warn(`Modal with id "${modalId}" not found`);
            return null;
        }

        const modalConfig = {
            element: modal,
            backdrop: options.backdrop !== false,
            closeOnEscape: options.closeOnEscape !== false,
            closeOnBackdropClick: options.closeOnBackdropClick !== false,
            onOpen: options.onOpen || null,
            onClose: options.onClose || null
        };

        this.modals.set(modalId, modalConfig);
        return modalConfig;
    }

    /**
     * Open a modal
     */
    open(modalId, options = {}) {
        const modalConfig = this.modals.get(modalId) || this.register(modalId, options);
        if (!modalConfig) return;

        const { element, onOpen } = modalConfig;

        // Show modal
        element.style.display = 'block';

        // Add backdrop if needed
        if (modalConfig.backdrop) {
            this.addBackdrop(element);
        }

        // Focus on first input
        setTimeout(() => {
            const firstInput = element.querySelector('input, textarea, select');
            if (firstInput) firstInput.focus();
        }, 100);

        // Call onOpen callback
        if (onOpen && typeof onOpen === 'function') {
            onOpen(element);
        }

        console.log(`Modal "${modalId}" opened`);
    }

    /**
     * Close a modal
     */
    close(modalId) {
        const modalConfig = this.modals.get(modalId);
        if (!modalConfig) return;

        const { element, onClose } = modalConfig;

        // Hide modal
        element.style.display = 'none';

        // Remove backdrop
        this.removeBackdrop(element);

        // Call onClose callback
        if (onClose && typeof onClose === 'function') {
            onClose(element);
        }

        console.log(`Modal "${modalId}" closed`);
    }

    /**
     * Close all modals
     */
    closeAllModals() {
        this.modals.forEach((config, modalId) => {
            this.close(modalId);
        });
    }

    /**
     * Add backdrop to modal
     */
    addBackdrop(modalElement) {
        if (!modalElement.parentElement.classList.contains('modal-backdrop')) {
            const backdrop = document.createElement('div');
            backdrop.className = 'modal-backdrop';
            backdrop.style.cssText = `
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0,0,0,0.5);
                z-index: 9998;
                backdrop-filter: blur(2px);
            `;
            
            modalElement.parentNode.insertBefore(backdrop, modalElement);
            modalElement.style.zIndex = '9999';
        }
    }

    /**
     * Remove backdrop from modal
     */
    removeBackdrop(modalElement) {
        const backdrop = modalElement.previousElementSibling;
        if (backdrop && backdrop.classList.contains('modal-backdrop')) {
            backdrop.remove();
        }
        modalElement.style.zIndex = '';
    }

    /**
     * Create modal dynamically
     */
    createModal(content, options = {}) {
        const modalId = options.id || `modal-${Date.now()}`;
        const modalHtml = `
            <div id="${modalId}" class="modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 9999;">
                ${content}
            </div>
        `;

        document.body.insertAdjacentHTML('beforeend', modalHtml);
        this.register(modalId, options);
        return modalId;
    }

    /**
     * Destroy a modal
     */
    destroy(modalId) {
        const modalConfig = this.modals.get(modalId);
        if (modalConfig) {
            modalConfig.element.remove();
            this.modals.delete(modalId);
        }
    }
}

// Create global modal manager instance
export const modalManager = new ModalManager();

export default modalManager;