/**
 * Main Application JavaScript File
 *
 * This file serves as the entry point for the Laravel application's frontend.
 * It imports and initializes all JavaScript modules and handles application-wide
 * functionality like error handling, module initialization, and global utilities.
 */

import './bootstrap';

// Import application modules
import { Utils } from './modules/utils.js';
import { modalManager } from './modules/modal.js';
import { FormManager } from './modules/forms.js';
import { ViewManager } from './modules/views.js';
import { TeacherManager } from './modules/teachers.js';
import { LayoutManager } from './modules/layout.js';

/**
 * Application Configuration
 */
const AppConfig = {
    debug: process.env.NODE_ENV === 'development',
    modules: {
        Utils: true,
        FormManager: true,
        ViewManager: true,
        TeacherManager: true,
        modalManager: true,
        LayoutManager: true,
    },
    features: {
        autoHideFlashMessages: true,
        mobileResponsive: true,
        cardAnimations: true,
        formValidation: true,
        layoutManagement: true,
    },
};

/**
 * Application Core Class
 */
class Application {
    /**
     * Initialize the application
     */
    static init() {
        if (AppConfig.debug) {
            console.log('🚀 Initializing Laravel Application...');
            console.log('📦 Available modules:', Object.keys(AppConfig.modules).filter(key => AppConfig.modules[key]));
        }

        try {
            // Initialize core utilities
            this.initUtilities();
            
            // Initialize feature modules
            this.initModules();
            
            // Set up global event listeners
            this.setupEventListeners();
            
            if (AppConfig.debug) {
                console.log('✅ Application initialized successfully');
            }
        } catch (error) {
            console.error('❌ Error initializing application:', error);
            this.handleError(error);
        }
    }

    /**
     * Initialize utility functions
     */
    static initUtilities() {
        if (AppConfig.features.cardAnimations) {
            Utils.enhanceCardAnimations();
        }
        
        if (AppConfig.features.mobileResponsive) {
            Utils.handleMobileView();
        }
        
        if (AppConfig.features.autoHideFlashMessages) {
            Utils.autoHideFlashMessages();
        }
    }

    /**
     * Initialize feature modules
     */
    static initModules() {
        if (AppConfig.modules.FormManager && AppConfig.features.formValidation) {
            FormManager.init();
        }
        
        if (AppConfig.modules.ViewManager) {
            ViewManager.initAll();
        }
        
        if (AppConfig.modules.TeacherManager) {
            TeacherManager.initAll();
        }
        
        if (AppConfig.modules.LayoutManager && AppConfig.features.layoutManagement) {
            LayoutManager.init();
        }
    }

    /**
     * Set up global event listeners
     */
    static setupEventListeners() {
        // Handle window resize for responsive behavior
        if (AppConfig.features.mobileResponsive) {
            window.addEventListener('resize', Utils.handleMobileView);
        }

        // Handle page visibility changes
        document.addEventListener('visibilitychange', () => {
            if (document.visibilityState === 'visible') {
                // Refresh data or perform cleanup when page becomes visible
                if (AppConfig.debug) {
                    console.log('🔄 Page became visible, refreshing data...');
                }
            }
        });

        // Handle beforeunload for cleanup
        window.addEventListener('beforeunload', () => {
            // Perform any necessary cleanup
            if (AppConfig.debug) {
                console.log('🧹 Performing cleanup before page unload...');
            }
        });
    }

    /**
     * Global error handler
     */
    static handleError(error) {
        console.error('Application Error:', error);
        
        // You could integrate with an error reporting service here
        // e.g., Sentry, Bugsnag, etc.
        
        // Show user-friendly error message in development
        if (AppConfig.debug) {
            this.showErrorToast('An error occurred. Check console for details.');
        }
    }

    /**
     * Show error toast notification
     */
    static showErrorToast(message) {
        const toast = document.createElement('div');
        toast.className = 'fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 transform transition-all duration-300';
        toast.innerHTML = `
            <div class="flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                </svg>
                <span>${message}</span>
            </div>
        `;
        
        document.body.appendChild(toast);
        
        // Auto-remove after 5 seconds
        setTimeout(() => {
            toast.style.transform = 'translateX(100%)';
            setTimeout(() => toast.remove(), 300);
        }, 5000);
    }

    /**
     * Check if a module is available
     */
    static hasModule(moduleName) {
        return AppConfig.modules[moduleName] && window[moduleName];
    }

    /**
     * Get application version (if available)
     */
    static getVersion() {
        return '1.0.0'; // This could be injected from Laravel
    }
}

/**
 * Initialize application when DOM is ready
 */
document.addEventListener('DOMContentLoaded', () => {
    Application.init();
});

/**
 * Make modules available globally for legacy code and debugging
 * Note: In modern applications, prefer importing modules directly
 */
if (AppConfig.debug) {
    window.App = Application;
    window.AppConfig = AppConfig;
}

window.Utils = Utils;
window.modalManager = modalManager;
window.FormManager = FormManager;
window.ViewManager = ViewManager;
window.TeacherManager = TeacherManager;
window.LayoutManager = LayoutManager;

// Export for module usage
export {
    Application,
    Utils,
    modalManager,
    FormManager,
    ViewManager,
    TeacherManager,
    LayoutManager
};
