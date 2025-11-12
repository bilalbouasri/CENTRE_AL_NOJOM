/**
 * View management system for card/table toggles
 */

export class ViewManager {
    /**
     * Initialize view toggle functionality
     */
    static init(viewType = 'card') {
        const cardViewBtn = document.getElementById('card-view-btn');
        const tableViewBtn = document.getElementById('table-view-btn');
        const cardView = document.getElementById('card-view');
        const tableView = document.getElementById('table-view');

        if (!cardViewBtn || !tableViewBtn || !cardView || !tableView) {
            return;
        }

        // Load saved view preference
        const savedView = localStorage.getItem('studentViewPreference') || viewType;

        // Switch view function
        const switchView = (view) => {
            if (view === 'card') {
                cardView.classList.remove('hidden');
                tableView.classList.add('hidden');
                cardViewBtn.classList.add('bg-primary-500', 'text-white', 'shadow-sm');
                cardViewBtn.classList.remove('text-gray-500', 'dark:text-gray-400');
                tableViewBtn.classList.remove('bg-primary-500', 'text-white', 'shadow-sm');
                tableViewBtn.classList.remove('text-gray-500', 'dark:text-gray-400');
            } else {
                cardView.classList.add('hidden');
                tableView.classList.remove('hidden');
                tableViewBtn.classList.add('bg-primary-500', 'text-white', 'shadow-sm');
                tableViewBtn.classList.remove('text-gray-500', 'dark:text-gray-400');
                cardViewBtn.classList.remove('bg-primary-500', 'text-white', 'shadow-sm');
                cardViewBtn.classList.remove('text-gray-500', 'dark:text-gray-400');
            }
            localStorage.setItem('studentViewPreference', view);
        };

        // Initialize view based on saved preference
        switchView(savedView);

        // Add event listeners for view toggle buttons
        cardViewBtn.addEventListener('click', () => switchView('card'));
        tableViewBtn.addEventListener('click', () => switchView('table'));
    }

    /**
     * Initialize bulk actions functionality
     */
    static initBulkActions() {
        const bulkActions = document.getElementById('bulk-actions');
        const studentCheckboxes = document.querySelectorAll('.student-checkbox');
        const selectedCount = document.getElementById('selected-count');
        const clearSelection = document.getElementById('clear-selection');
        const bulkPayment = document.getElementById('bulk-payment');
        const bulkExport = document.getElementById('bulk-export');
        const exportBtn = document.getElementById('export-btn');

        if (!bulkActions || !selectedCount) {
            return;
        }

        let selectedStudents = new Set();

        // Toggle student selection
        document.addEventListener('click', function(event) {
            const card = event.target.closest('.student-card');
            if (card && !event.target.closest('a') && !event.target.closest('button')) {
                const checkbox = card.querySelector('.student-checkbox');
                const studentId = card.dataset.studentId;
                
                checkbox.classList.toggle('hidden');
                setTimeout(() => {
                    checkbox.checked = !checkbox.checked;
                    if (checkbox.checked) {
                        selectedStudents.add(studentId);
                        card.classList.add('ring-2', 'ring-primary-500');
                    } else {
                        selectedStudents.delete(studentId);
                        card.classList.remove('ring-2', 'ring-primary-500');
                    }
                    
                    ViewManager.updateBulkActions(selectedStudents, selectedCount, bulkActions);
                }, 10);
            }
        });

        // Update bulk actions visibility
        ViewManager.updateBulkActions(selectedStudents, selectedCount, bulkActions);

        // Clear selection
        if (clearSelection) {
            clearSelection.addEventListener('click', function() {
                selectedStudents.clear();
                studentCheckboxes.forEach(checkbox => {
                    checkbox.checked = false;
                    checkbox.classList.add('hidden');
                });
                document.querySelectorAll('.student-card').forEach(card => {
                    card.classList.remove('ring-2', 'ring-primary-500');
                });
                ViewManager.updateBulkActions(selectedStudents, selectedCount, bulkActions);
            });
        }

        // Export functionality
        if (exportBtn) {
            exportBtn.addEventListener('click', function() {
                this.disabled = true;
                this.innerHTML = '<svg class="animate-spin ltr:-ml-1 rtl:-mr-1 ltr:mr-2 rtl:ml-2 h-4 w-4 text-gray-700" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Exporting...';
                
                // Simulate export process
                setTimeout(() => {
                    alert('Export completed! All student data has been prepared for download.');
                    this.disabled = false;
                    this.innerHTML = '<svg class="w-4 h-4 lg:w-5 lg:h-5 ltr:mr-2 rtl:ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>Export Data';
                }, 2000);
            });
        }

        // Bulk export
        if (bulkExport) {
            bulkExport.addEventListener('click', function() {
                if (selectedStudents.size > 0) {
                    alert(`Exporting ${selectedStudents.size} selected students...`);
                }
            });
        }

        // Bulk payment
        if (bulkPayment) {
            bulkPayment.addEventListener('click', function() {
                if (selectedStudents.size > 0) {
                    const studentIds = Array.from(selectedStudents).join(',');
                    window.location.href = `/payments/create-bulk?student_ids=${studentIds}`;
                }
            });
        }
    }

    /**
     * Update bulk actions visibility and count
     */
    static updateBulkActions(selectedStudents, selectedCount, bulkActions) {
        const count = selectedStudents.size;
        selectedCount.textContent = `${count} student${count !== 1 ? 's' : ''} selected`;
        
        if (count > 0) {
            bulkActions.classList.remove('hidden');
        } else {
            bulkActions.classList.add('hidden');
        }
    }

    /**
     * Initialize search functionality
     */
    static initSearch() {
        const searchInput = document.getElementById('search');
        if (searchInput) {
            // Auto-hide search results info after 5 seconds
            const searchInfo = document.querySelector('.bg-blue-50');
            if (searchInfo) {
                setTimeout(() => {
                    searchInfo.style.opacity = '0';
                    setTimeout(() => searchInfo.remove(), 300);
                }, 5000);
            }

            // Add debounced search
            searchInput.addEventListener('input', ViewManager.debounceSearch);
        }
    }

    /**
     * Debounced search function
     */
    static debounceSearch(event) {
        // This would typically submit the form or make an AJAX request
        // For now, we'll just log the search term
        console.log('Searching for:', event.target.value);
    }

    /**
     * Initialize all view-related functionality
     */
    static initAll() {
        this.init();
        this.initBulkActions();
        this.initSearch();
    }
}

export default ViewManager;