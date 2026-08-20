/**
 * JavaScript - Main Script
 */

(function() {
    'use strict';
    
    // Initialize tooltips and popovers
    document.addEventListener('DOMContentLoaded', function() {
        // Bootstrap tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        // Setup CSRF tokens
        setupCsrfToken();
        
        // Setup forms
        setupFormValidation();
    });
    
    /**
     * Setup CSRF Token
     */
    function setupCsrfToken() {
        // CSRF token from meta tag or input
        const token = document.querySelector('meta[name="csrf-token"]')?.content || 
                     document.querySelector('input[name="csrf_token"]')?.value;
        
        if (token) {
            // Add to all AJAX requests
            document.addEventListener('send', function(e) {
                if (e.detail?.xhr) {
                    e.detail.xhr.setRequestHeader('X-CSRF-Token', token);
                }
            });
        }
    }
    
    /**
     * Form Validation
     */
    function setupFormValidation() {
        const forms = document.querySelectorAll('.needs-validation');
        
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }
    
    /**
     * AJAX Form Submission
     */
    window.submitFormAjax = function(formId, url, callback) {
        const form = document.getElementById(formId);
        if (!form) return;
        
        const formData = new FormData(form);
        
        fetch(url, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (callback) callback(data);
            else handleAjaxResponse(data);
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('An error occurred', 'error');
        });
    };
    
    /**
     * Handle AJAX Response
     */
    function handleAjaxResponse(data) {
        if (data.success) {
            showAlert(data.message || 'Success!', 'success');
            if (data.redirect) {
                setTimeout(() => {
                    window.location.href = data.redirect;
                }, 1000);
            }
        } else {
            showAlert(data.message || 'An error occurred', 'error');
        }
    }
    
    /**
     * Show Alert Message
     */
    window.showAlert = function(message, type = 'info') {
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
        alertDiv.setAttribute('role', 'alert');
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        const container = document.querySelector('.container') || document.body;
        container.insertBefore(alertDiv, container.firstChild);
        
        setTimeout(() => {
            alertDiv.remove();
        }, 5000);
    };
    
    /**
     * Lazy Load Images
     */
    window.setupLazyLoad = function() {
        if ('IntersectionObserver' in window) {
            const images = document.querySelectorAll('img[data-src]');
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.removeAttribute('data-src');
                        observer.unobserve(img);
                    }
                });
            });
            images.forEach(img => imageObserver.observe(img));
        }
    };
    
    /**
     * Format Currency
     */
    window.formatCurrency = function(amount, currency = 'INR') {
        return new Intl.NumberFormat('en-IN', {
            style: 'currency',
            currency: currency
        }).format(amount);
    };
    
    /**
     * Confirm Delete
     */
    window.confirmDelete = function(message = 'Are you sure?') {
        return confirm(message);
    };
    
    /**
     * Print Page
     */
    window.printPage = function() {
        window.print();
    };
    
})();
