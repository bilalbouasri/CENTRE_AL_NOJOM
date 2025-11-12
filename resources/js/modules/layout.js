/**
 * Layout management for dark mode and sidebar
 */

export class LayoutManager {
    /**
     * Initialize layout functionality
     */
    static init() {
        console.log('Initializing LayoutManager...');
        this.initDarkMode();
        this.initSidebar();
        console.log('LayoutManager initialized successfully');
    }

    /**
     * Initialize dark mode functionality
     */
    static initDarkMode() {
        console.log('Initializing dark mode...');
        const darkModeToggle = document.getElementById('dark-mode-toggle');
        const darkIcon = document.getElementById('dark-icon');
        const lightIcon = document.getElementById('light-icon');
        
        console.log('Dark mode elements:', { darkModeToggle, darkIcon, lightIcon });
        
        if (!darkModeToggle || !darkIcon || !lightIcon) {
            console.warn('Dark mode elements not found');
            return;
        }

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

    /**
     * Initialize sidebar functionality
     */
    static initSidebar() {
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const mobileSidebarToggle = document.getElementById('mobile-sidebar-toggle');
        
        if (!sidebar) {
            return;
        }

        // Get saved sidebar state from localStorage
        const savedSidebarState = localStorage.getItem('sidebarCollapsed');
        const isCollapsed = savedSidebarState === 'true';
        
        // Initialize sidebar state
        function initializeSidebar() {
            if (window.innerWidth >= 1024) {
                // Desktop: apply saved state
                if (isCollapsed) {
                    collapseSidebar();
                } else {
                    expandSidebar();
                }
            } else {
                // Mobile: always start collapsed (hidden)
                sidebar.classList.add('hidden');
            }
        }
        
        // Collapse sidebar function
        function collapseSidebar() {
            sidebar.classList.add('w-20');
            sidebar.classList.remove('w-64');
            
            // Hide text elements
            const logoText = document.getElementById('logo-text');
            const userInfo = document.getElementById('user-info');
            
            if (logoText) logoText.classList.add('hidden');
            if (userInfo) userInfo.classList.add('hidden');
            
            document.querySelectorAll('[id$="-text"]').forEach(el => {
                if (el.id !== 'logo-text') {
                    el.classList.add('hidden');
                }
            });
            
            // Save state
            localStorage.setItem('sidebarCollapsed', 'true');
        }
        
        // Expand sidebar function
        function expandSidebar() {
            sidebar.classList.remove('w-20');
            sidebar.classList.add('w-64');
            
            // Show text elements
            const logoText = document.getElementById('logo-text');
            const userInfo = document.getElementById('user-info');
            
            if (logoText) logoText.classList.remove('hidden');
            if (userInfo) userInfo.classList.remove('hidden');
            
            document.querySelectorAll('[id$="-text"]').forEach(el => {
                el.classList.remove('hidden');
            });
            
            // Save state
            localStorage.setItem('sidebarCollapsed', 'false');
        }
        
        // Toggle sidebar function
        function toggleSidebar() {
            if (window.innerWidth >= 1024) {
                // Desktop toggle
                if (sidebar.classList.contains('w-20')) {
                    expandSidebar();
                } else {
                    collapseSidebar();
                }
            } else {
                // Mobile toggle - just show/hide
                sidebar.classList.toggle('hidden');
            }
        }
        
        // Event listeners
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', toggleSidebar);
        }
        
        if (mobileSidebarToggle) {
            mobileSidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('hidden');
            });
        }
        
        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1024) {
                // Desktop: apply saved state and ensure visible
                sidebar.classList.remove('hidden');
                if (localStorage.getItem('sidebarCollapsed') === 'true') {
                    collapseSidebar();
                } else {
                    expandSidebar();
                }
            } else {
                // Mobile: always hidden by default
                if (!sidebar.classList.contains('hidden')) {
                    sidebar.classList.add('hidden');
                }
            }
        });
        
        // Initialize sidebar
        initializeSidebar();
        
        // Close mobile sidebar when clicking outside
        document.addEventListener('click', function(event) {
            if (window.innerWidth < 1024 && 
                !sidebar.contains(event.target) && 
                mobileSidebarToggle &&
                !mobileSidebarToggle.contains(event.target) &&
                !sidebar.classList.contains('hidden')) {
                sidebar.classList.add('hidden');
            }
        });
    }

    /**
     * Initialize all layout functionality
     */
    static initAll() {
        document.addEventListener('DOMContentLoaded', () => {
            this.init();
        });
    }
}

export default LayoutManager;
