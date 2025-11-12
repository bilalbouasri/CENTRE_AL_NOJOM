/**
 * Teacher-specific JavaScript functionality
 */

import { modalManager } from './modal.js';
import { Utils } from './utils.js';

export class TeacherManager {
    /**
     * Initialize teacher-specific functionality
     */
    static init() {
        this.initModals();
        this.initEventListeners();
    }

    /**
     * Initialize teacher modals
     */
    static initModals() {
        // Register create modal
        modalManager.register('createModal', {
            backdrop: true,
            closeOnEscape: true,
            closeOnBackdropClick: true,
            onOpen: (modal) => {
                // Focus on first input when modal opens
                setTimeout(() => {
                    const firstInput = modal.querySelector('input');
                    if (firstInput) firstInput.focus();
                }, 100);
            }
        });

        // Register edit modal
        modalManager.register('editModal', {
            backdrop: true,
            closeOnEscape: true,
            closeOnBackdropClick: true
        });
    }

    /**
     * Initialize event listeners
     */
    static initEventListeners() {
        // Create modal event listeners
        const createModal = document.getElementById('createModal');
        const createModalContent = createModal?.querySelector('div');
        
        if (createModal && createModalContent) {
            createModal.addEventListener('click', function(e) {
                if (e.target === createModal) {
                    modalManager.close('createModal');
                }
            });

            createModalContent.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        }

        // Edit modal event listeners
        const editModal = document.getElementById('editModal');
        const editModalContent = editModal?.querySelector('div');
        
        if (editModal && editModalContent) {
            editModal.addEventListener('click', function(e) {
                if (e.target === editModal) {
                    modalManager.close('editModal');
                }
            });

            editModalContent.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        }
    }

    /**
     * Open create modal
     */
    static openCreateModal() {
        modalManager.open('createModal');
    }

    /**
     * Close create modal
     */
    static closeCreateModal() {
        modalManager.close('createModal');
    }

    /**
     * Open edit modal and load teacher data
     */
    static openEditModal(teacherId) {
        modalManager.open('editModal');
        
        // Load teacher data via AJAX
        fetch(`/teachers/${teacherId}/edit`)
            .then(response => response.text())
            .then(html => {
                // Extract the form from the response
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const form = doc.querySelector('form');
                
                if (form) {
                    // Update the form action to use the update route
                    form.action = `/teachers/${teacherId}`;
                    form.method = 'POST';
                    
                    // Add method spoofing for PUT request
                    const methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'PUT';
                    form.appendChild(methodInput);
                    
                    // Add CSRF token if not present
                    if (!form.querySelector('input[name="_token"]')) {
                        const csrfToken = Utils.getCsrfToken();
                        const csrfInput = document.createElement('input');
                        csrfInput.type = 'hidden';
                        csrfInput.name = '_token';
                        csrfInput.value = csrfToken;
                        form.appendChild(csrfInput);
                    }
                    
                    document.getElementById('editModalContent').innerHTML = '';
                    document.getElementById('editModalContent').appendChild(form);
                    
                    // Focus on first input
                    setTimeout(() => {
                        const firstInput = form.querySelector('input');
                        if (firstInput) firstInput.focus();
                    }, 100);
                } else {
                    document.getElementById('editModalContent').innerHTML = '<p style="color: #ef4444; text-align: center; padding: 40px;" class="dark:text-red-400">Error loading teacher data</p>';
                }
            })
            .catch(error => {
                console.error('Error loading teacher data:', error);
                document.getElementById('editModalContent').innerHTML = '<p style="color: #ef4444; text-align: center; padding: 40px;" class="dark:text-red-400">Error loading teacher data</p>';
            });
    }

    /**
     * Close edit modal
     */
    static closeEditModal() {
        modalManager.close('editModal');
        // Reset modal content for next use
        document.getElementById('editModalContent').innerHTML = `
            <div style="text-align: center; padding: 40px;">
                <div style="width: 48px; height: 48px; border: 3px solid #e5e7eb; border-top: 3px solid #3b82f6; border-radius: 50%; animation: spin 1s linear infinite; margin: 0 auto 16px;" class="dark:border-gray-600"></div>
                <p style="color: #6b7280; font-size: 14px;" class="dark:text-gray-300">Loading teacher information...</p>
            </div>
        `;
    }

    /**
     * Open view modal (redirect to show page for now)
     */
    static openViewModal(teacherId) {
        window.location.href = `/teachers/${teacherId}`;
    }

    /**
     * Initialize all teacher functionality
     */
    static initAll() {
        this.init();
        
        // Make functions available globally for onclick handlers
        window.openCreateModal = this.openCreateModal;
        window.closeCreateModal = this.closeCreateModal;
        window.openEditModal = this.openEditModal;
        window.closeEditModal = this.closeEditModal;
        window.openViewModal = this.openViewModal;
    }
}

export default TeacherManager;