/**
 * Main Application JavaScript
 * Organized and centralized JavaScript functionality
 */

// Global Application Object
window.App = {
    // Dark Mode Functionality
    initDarkMode: function() {
        const darkModeToggle = document.getElementById('dark-mode-toggle');
        const darkIcon = document.getElementById('dark-icon');
        const lightIcon = document.getElementById('light-icon');
        
        if (darkModeToggle && darkIcon && lightIcon) {
            // Get saved dark mode state from localStorage
            const savedDarkMode = localStorage.getItem('darkMode');
            const isDarkMode = savedDarkMode === 'true';
            
            // Apply dark mode based on saved state
            function applyDarkMode(isDark) {
                if (isDark) {
                    document.documentElement.classList.add('dark');
                    darkIcon.classList.add('hidden');
                    lightIcon.classList.remove('hidden');
                } else {
                    document.documentElement.classList.remove('dark');
                    darkIcon.classList.remove('hidden');
                    lightIcon.classList.add('hidden');
                }
                localStorage.setItem('darkMode', isDark.toString());
            }
            
            // Initialize dark mode
            applyDarkMode(isDarkMode);
            
            // Toggle dark mode
            darkModeToggle.addEventListener('click', function() {
                const isCurrentlyDark = document.documentElement.classList.contains('dark');
                applyDarkMode(!isCurrentlyDark);
            });
        }
    },

    // Sidebar Toggle Functionality
    initSidebar: function() {
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const mobileSidebarToggle = document.getElementById('mobile-sidebar-toggle');
        const sidebar = document.getElementById('sidebar');
        const logoText = document.getElementById('logo-text');
        const userInfo = document.getElementById('user-info');
        const navTexts = [
            'dashboard-text', 'students-text', 'teachers-text', 
            'classes-text', 'payments-text', 'subjects-text', 'unpaid-students-text'
        ];

        function toggleSidebar() {
            const isCollapsed = sidebar.classList.contains('w-20');
            
            if (isCollapsed) {
                // Expand sidebar
                sidebar.classList.remove('w-20');
                sidebar.classList.add('w-64');
                if (logoText) logoText.classList.remove('hidden');
                if (userInfo) userInfo.classList.remove('hidden');
                
                // Show all navigation texts
                navTexts.forEach(textId => {
                    const element = document.getElementById(textId);
                    if (element) element.classList.remove('hidden');
                });
            } else {
                // Collapse sidebar
                sidebar.classList.remove('w-64');
                sidebar.classList.add('w-20');
                if (logoText) logoText.classList.add('hidden');
                if (userInfo) userInfo.classList.add('hidden');
                
                // Hide all navigation texts
                navTexts.forEach(textId => {
                    const element = document.getElementById(textId);
                    if (element) element.classList.add('hidden');
                });
            }
        }

        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', toggleSidebar);
        }

        if (mobileSidebarToggle) {
            mobileSidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('-translate-x-full');
            });
        }
    },

    // Flash Messages
    initFlashMessages: function() {
        const flashMessages = document.querySelectorAll('.fixed.top-4.right-4');
        flashMessages.forEach(message => {
            setTimeout(() => {
                message.style.opacity = '0';
                message.style.transform = 'translateY(-20px)';
                setTimeout(() => message.remove(), 300);
            }, 5000);
        });
    },

    // Mobile View Handling
    initMobileView: function() {
        function handleMobileView() {
            const sidebar = document.getElementById('sidebar');
            if (window.innerWidth < 1024) {
                sidebar.classList.add('-translate-x-full');
            } else {
                sidebar.classList.remove('-translate-x-full');
                }
        }

        handleMobileView();
        window.addEventListener('resize', handleMobileView);
    },

    // Modal Management
    openModal: function(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
    },

    closeModal: function(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    },

    // Confirmation Dialogs
    confirmAction: function(message, callback) {
        if (confirm(message)) {
            callback();
        }
    },

    // Form Enhancements
    initFormEnhancements: function() {
        // Auto-focus first input in forms
        const firstInput = document.querySelector('form input[type="text"]');
        if (firstInput) {
            firstInput.focus();
        }

        // Form loading states
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            const submitButton = form.querySelector('button[type="submit"]');
            if (submitButton) {
                form.addEventListener('submit', function() {
                    submitButton.disabled = true;
                    submitButton.innerHTML = '<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Processing...';
                });
            }
        });
    },

    // View Management (Card/Table Toggle)
    initViewManagement: function() {
        const cardViewBtn = document.getElementById('card-view-btn');
        const tableViewBtn = document.getElementById('table-view-btn');
        const cardView = document.getElementById('card-view');
        const tableView = document.getElementById('table-view');

        if (cardViewBtn && tableViewBtn && cardView && tableView) {
            function setView(viewType) {
                if (viewType === 'card') {
                    cardView.classList.remove('hidden');
                    tableView.classList.add('hidden');
                    cardViewBtn.classList.add('bg-primary-500', 'text-white');
                    cardViewBtn.classList.remove('text-gray-700', 'dark:text-gray-300');
                    tableViewBtn.classList.remove('bg-primary-500', 'text-white');
                    tableViewBtn.classList.add('text-gray-700', 'dark:text-gray-300');
                    localStorage.setItem('preferredView', 'card');
                } else {
                    cardView.classList.add('hidden');
                    tableView.classList.remove('hidden');
                    tableViewBtn.classList.add('bg-primary-500', 'text-white');
                    tableViewBtn.classList.remove('text-gray-700', 'dark:text-gray-300');
                    cardViewBtn.classList.remove('bg-primary-500', 'text-white');
                    cardViewBtn.classList.add('text-gray-700', 'dark:text-gray-300');
                    localStorage.setItem('preferredView', 'table');
                }
            }

            // Set initial view based on localStorage
            const preferredView = localStorage.getItem('preferredView') || 'card';
            setView(preferredView);

            // Add event listeners
            cardViewBtn.addEventListener('click', () => setView('card'));
            tableViewBtn.addEventListener('click', () => setView('table'));
        }
    },

    // Initialize all functionality
    init: function() {
        this.initDarkMode();
        this.initSidebar();
        this.initFlashMessages();
        this.initMobileView();
        this.initFormEnhancements();
        this.initViewManagement();
    }
};

// Initialize application when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    App.init();
});

// Global functions for onclick handlers
window.openCreateModal = function() { App.openModal('create-modal'); };
window.closeCreateModal = function() { App.closeModal('create-modal'); };
window.openEditModal = function() { App.openModal('edit-modal'); };
window.closeEditModal = function() { App.closeModal('edit-modal'); };
window.openViewModal = function() { App.openModal('view-modal'); };
window.closeViewModal = function() { App.closeModal('view-modal'); };