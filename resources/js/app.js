import './bootstrap';
import Alpine from 'alpinejs';

// Initialiser Alpine.js
window.Alpine = Alpine;
Alpine.start();

// Fonctions utilitaires globales
window.utils = {
    // Formater une date
    formatDate(date, format = 'dd/mm/yyyy') {
        if (!date) return '';
        const d = new Date(date);
        const day = String(d.getDate()).padStart(2, '0');
        const month = String(d.getMonth() + 1).padStart(2, '0');
        const year = d.getFullYear();
        
        switch (format) {
            case 'dd/mm/yyyy':
                return `${day}/${month}/${year}`;
            case 'yyyy-mm-dd':
                return `${year}-${month}-${day}`;
            case 'dd-mm-yyyy':
                return `${day}-${month}-${year}`;
            default:
                return d.toLocaleDateString('fr-FR');
        }
    },
    
    // Formater un numéro de téléphone
    formatPhone(phone) {
        if (!phone) return '';
        return phone.replace(/(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})/, '$1 $2 $3 $4 $5');
    },
    
    // Capitaliser la première lettre
    capitalize(str) {
        if (!str) return '';
        return str.charAt(0).toUpperCase() + str.slice(1);
    },
    
    // Tronquer un texte
    truncate(str, length = 50) {
        if (!str) return '';
        return str.length > length ? str.substring(0, length) + '...' : str;
    },
    
    // Générer un ID unique
    generateId() {
        return Date.now().toString(36) + Math.random().toString(36).substr(2);
    },
    
    // Debounce une fonction
    debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    },
    
    // Throttle une fonction
    throttle(func, limit) {
        let inThrottle;
        return function() {
            const args = arguments;
            const context = this;
            if (!inThrottle) {
                func.apply(context, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        };
    },
    
    // Copier du texte dans le presse-papiers
    async copyToClipboard(text) {
        try {
            await navigator.clipboard.writeText(text);
            return true;
        } catch (err) {
            console.error('Erreur lors de la copie:', err);
            return false;
        }
    },
    
    // Télécharger un fichier
    downloadFile(url, filename) {
        const link = document.createElement('a');
        link.href = url;
        link.download = filename;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    },
    
    // Valider un email
    isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    },
    
    // Valider un numéro de téléphone français
    isValidPhone(phone) {
        const phoneRegex = /^(?:(?:\+|00)33|0)\s*[1-9](?:[\s.-]*\d{2}){4}$/;
        return phoneRegex.test(phone);
    },
    
    // Calculer l'âge à partir d'une date de naissance
    calculateAge(birthDate) {
        const today = new Date();
        const birth = new Date(birthDate);
        let age = today.getFullYear() - birth.getFullYear();
        const monthDiff = today.getMonth() - birth.getMonth();
        
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birth.getDate())) {
            age--;
        }
        
        return age;
    },
    
    // Formater une taille de fichier
    formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    },
    
    // Générer une couleur aléatoire
    randomColor() {
        return '#' + Math.floor(Math.random()*16777215).toString(16);
    },
    
    // Convertir une couleur hex en RGB
    hexToRgb(hex) {
        const result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
        return result ? {
            r: parseInt(result[1], 16),
            g: parseInt(result[2], 16),
            b: parseInt(result[3], 16)
        } : null;
    },
    
    // Calculer la luminosité d'une couleur
    getLuminance(hex) {
        const rgb = this.hexToRgb(hex);
        if (!rgb) return 0;
        
        const { r, g, b } = rgb;
        return (0.299 * r + 0.587 * g + 0.114 * b) / 255;
    },
    
    // Déterminer si une couleur est claire ou sombre
    isLightColor(hex) {
        return this.getLuminance(hex) > 0.5;
    }
};

// Gestionnaire d'API
window.api = {
    // Configuration de base
    baseURL: '/api',
    
    // Headers par défaut
    getHeaders() {
        return {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
        };
    },
    
    // Méthode GET
    async get(endpoint, params = {}) {
        const url = new URL(this.baseURL + endpoint, window.location.origin);
        Object.keys(params).forEach(key => {
            if (params[key] !== null && params[key] !== undefined) {
                url.searchParams.append(key, params[key]);
            }
        });
        
        try {
            const response = await fetch(url, {
                method: 'GET',
                headers: this.getHeaders()
            });
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            return await response.json();
        } catch (error) {
            console.error('API GET Error:', error);
            throw error;
        }
    },
    
    // Méthode POST
    async post(endpoint, data = {}) {
        try {
            const response = await fetch(this.baseURL + endpoint, {
                method: 'POST',
                headers: this.getHeaders(),
                body: JSON.stringify(data)
            });
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            return await response.json();
        } catch (error) {
            console.error('API POST Error:', error);
            throw error;
        }
    },
    
    // Méthode PUT
    async put(endpoint, data = {}) {
        try {
            const response = await fetch(this.baseURL + endpoint, {
                method: 'PUT',
                headers: this.getHeaders(),
                body: JSON.stringify(data)
            });
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            return await response.json();
        } catch (error) {
            console.error('API PUT Error:', error);
            throw error;
        }
    },
    
    // Méthode PATCH
    async patch(endpoint, data = {}) {
        try {
            const response = await fetch(this.baseURL + endpoint, {
                method: 'PATCH',
                headers: this.getHeaders(),
                body: JSON.stringify(data)
            });
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            return await response.json();
        } catch (error) {
            console.error('API PATCH Error:', error);
            throw error;
        }
    },
    
    // Méthode DELETE
    async delete(endpoint) {
        try {
            const response = await fetch(this.baseURL + endpoint, {
                method: 'DELETE',
                headers: this.getHeaders()
            });
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            return await response.json();
        } catch (error) {
            console.error('API DELETE Error:', error);
            throw error;
        }
    }
};

// Gestionnaire de notifications
window.notifications = {
    container: null,
    
    // Initialiser le conteneur de notifications
    init() {
        if (!this.container) {
            this.container = document.createElement('div');
            this.container.className = 'fixed top-4 right-4 z-50 space-y-2';
            this.container.id = 'notifications-container';
            document.body.appendChild(this.container);
        }
    },
    
    // Afficher une notification
    show(message, type = 'info', duration = 5000) {
        this.init();
        
        const notification = document.createElement('div');
        notification.className = `max-w-sm w-full bg-white shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden transform transition-all duration-300 translate-x-full opacity-0`;
        
        const colors = {
            success: 'text-green-600',
            error: 'text-red-600',
            warning: 'text-yellow-600',
            info: 'text-blue-600'
        };
        
        const icons = {
            success: 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
            error: 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z',
            warning: 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z',
            info: 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
        };
        
        notification.innerHTML = `
            <div class="p-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 ${colors[type]}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${icons[type]}" />
                        </svg>
                    </div>
                    <div class="ml-3 w-0 flex-1">
                        <p class="text-sm font-medium text-gray-900">${message}</p>
                    </div>
                    <div class="ml-4 flex-shrink-0 flex">
                        <button class="bg-white rounded-md inline-flex text-gray-400 hover:text-gray-500 focus:outline-none" onclick="this.closest('.notification').remove()">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        notification.classList.add('notification');
        this.container.appendChild(notification);
        
        // Animation d'entrée
        setTimeout(() => {
            notification.classList.remove('translate-x-full', 'opacity-0');
            notification.classList.add('translate-x-0', 'opacity-100');
        }, 100);
        
        // Auto-suppression
        if (duration > 0) {
            setTimeout(() => {
                this.remove(notification);
            }, duration);
        }
        
        return notification;
    },
    
    // Supprimer une notification
    remove(notification) {
        notification.classList.add('translate-x-full', 'opacity-0');
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    },
    
    // Méthodes de raccourci
    success(message, duration = 5000) {
        return this.show(message, 'success', duration);
    },
    
    error(message, duration = 7000) {
        return this.show(message, 'error', duration);
    },
    
    warning(message, duration = 6000) {
        return this.show(message, 'warning', duration);
    },
    
    info(message, duration = 5000) {
        return this.show(message, 'info', duration);
    }
};

// Gestionnaire de modales
window.modals = {
    // Ouvrir une modale
    open(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.classList.add('overflow-hidden');
            
            // Focus sur le premier élément focusable
            const focusable = modal.querySelector('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
            if (focusable) {
                focusable.focus();
            }
        }
    },
    
    // Fermer une modale
    close(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.classList.remove('overflow-hidden');
        }
    },
    
    // Fermer toutes les modales
    closeAll() {
        const modals = document.querySelectorAll('.modal');
        modals.forEach(modal => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        });
        document.body.classList.remove('overflow-hidden');
    }
};

// Gestionnaire de stockage local
window.storage = {
    // Sauvegarder des données
    set(key, value) {
        try {
            localStorage.setItem(key, JSON.stringify(value));
            return true;
        } catch (error) {
            console.error('Erreur lors de la sauvegarde:', error);
            return false;
        }
    },
    
    // Récupérer des données
    get(key, defaultValue = null) {
        try {
            const item = localStorage.getItem(key);
            return item ? JSON.parse(item) : defaultValue;
        } catch (error) {
            console.error('Erreur lors de la récupération:', error);
            return defaultValue;
        }
    },
    
    // Supprimer des données
    remove(key) {
        try {
            localStorage.removeItem(key);
            return true;
        } catch (error) {
            console.error('Erreur lors de la suppression:', error);
            return false;
        }
    },
    
    // Vider le stockage
    clear() {
        try {
            localStorage.clear();
            return true;
        } catch (error) {
            console.error('Erreur lors du vidage:', error);
            return false;
        }
    },
    
    // Vérifier si une clé existe
    has(key) {
        return localStorage.getItem(key) !== null;
    }
};

// Gestionnaire de formulaires
window.forms = {
    // Valider un formulaire
    validate(formElement) {
        const errors = {};
        const inputs = formElement.querySelectorAll('input, select, textarea');
        
        inputs.forEach(input => {
            const value = input.value.trim();
            const name = input.name;
            const required = input.hasAttribute('required');
            const type = input.type;
            
            // Validation des champs requis
            if (required && !value) {
                errors[name] = 'Ce champ est obligatoire';
                return;
            }
            
            // Validation par type
            if (value) {
                switch (type) {
                    case 'email':
                        if (!utils.isValidEmail(value)) {
                            errors[name] = 'Adresse email invalide';
                        }
                        break;
                    case 'tel':
                        if (!utils.isValidPhone(value)) {
                            errors[name] = 'Numéro de téléphone invalide';
                        }
                        break;
                    case 'number':
                        const min = input.getAttribute('min');
                        const max = input.getAttribute('max');
                        const numValue = parseFloat(value);
                        
                        if (isNaN(numValue)) {
                            errors[name] = 'Valeur numérique invalide';
                        } else {
                            if (min && numValue < parseFloat(min)) {
                                errors[name] = `La valeur doit être supérieure ou égale à ${min}`;
                            }
                            if (max && numValue > parseFloat(max)) {
                                errors[name] = `La valeur doit être inférieure ou égale à ${max}`;
                            }
                        }
                        break;
                    case 'date':
                        const dateValue = new Date(value);
                        if (isNaN(dateValue.getTime())) {
                            errors[name] = 'Date invalide';
                        }
                        break;
                }
            }
        });
        
        return {
            isValid: Object.keys(errors).length === 0,
            errors
        };
    },
    
    // Afficher les erreurs de validation
    showErrors(formElement, errors) {
        // Supprimer les erreurs existantes
        formElement.querySelectorAll('.error-message').forEach(el => el.remove());
        formElement.querySelectorAll('.border-red-300').forEach(el => {
            el.classList.remove('border-red-300', 'focus:border-red-500', 'focus:ring-red-500');
            el.classList.add('border-gray-300', 'focus:border-blue-500', 'focus:ring-blue-500');
        });
        
        // Afficher les nouvelles erreurs
        Object.keys(errors).forEach(fieldName => {
            const field = formElement.querySelector(`[name="${fieldName}"]`);
            if (field) {
                // Styliser le champ en erreur
                field.classList.remove('border-gray-300', 'focus:border-blue-500', 'focus:ring-blue-500');
                field.classList.add('border-red-300', 'focus:border-red-500', 'focus:ring-red-500');
                
                // Ajouter le message d'erreur
                const errorElement = document.createElement('p');
                errorElement.className = 'mt-1 text-sm text-red-600 error-message';
                errorElement.textContent = errors[fieldName];
                field.parentNode.appendChild(errorElement);
            }
        });
    },
    
    // Sérialiser un formulaire
    serialize(formElement) {
        const formData = new FormData(formElement);
        const data = {};
        
        for (let [key, value] of formData.entries()) {
            if (data[key]) {
                // Si la clé existe déjà, créer un tableau
                if (Array.isArray(data[key])) {
                    data[key].push(value);
                } else {
                    data[key] = [data[key], value];
                }
            } else {
                data[key] = value;
            }
        }
        
        return data;
    },
    
    // Remplir un formulaire avec des données
    populate(formElement, data) {
        Object.keys(data).forEach(key => {
            const field = formElement.querySelector(`[name="${key}"]`);
            if (field) {
                if (field.type === 'checkbox' || field.type === 'radio') {
                    field.checked = field.value === data[key] || data[key] === true;
                } else {
                    field.value = data[key];
                }
            }
        });
    }
};

// Gestionnaire d'événements globaux
document.addEventListener('DOMContentLoaded', function() {
    // Gestion du menu mobile
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    
    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });
    }
    
    // Fermer les dropdowns en cliquant à l'extérieur
    document.addEventListener('click', function(event) {
        const dropdowns = document.querySelectorAll('.dropdown-menu');
        dropdowns.forEach(dropdown => {
            if (!dropdown.contains(event.target) && !dropdown.previousElementSibling.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });
    });
    
    // Gestion des tooltips
    const tooltips = document.querySelectorAll('[data-tooltip]');
    tooltips.forEach(tooltip => {
        tooltip.addEventListener('mouseenter', function() {
            const tooltipText = this.getAttribute('data-tooltip');
            const tooltipElement = document.createElement('div');
            tooltipElement.className = 'absolute z-50 px-2 py-1 text-xs text-white bg-gray-900 rounded shadow-lg opacity-0 pointer-events-none transition-opacity duration-200';
            tooltipElement.textContent = tooltipText;
            tooltipElement.id = 'tooltip-' + utils.generateId();
            
            this.appendChild(tooltipElement);
            
            // Positionner le tooltip
            const rect = this.getBoundingClientRect();
            tooltipElement.style.bottom = '100%';
            tooltipElement.style.left = '50%';
            tooltipElement.style.transform = 'translateX(-50%)';
            tooltipElement.style.marginBottom = '5px';
            
            setTimeout(() => {
                tooltipElement.classList.remove('opacity-0');
                tooltipElement.classList.add('opacity-100');
            }, 100);
        });
        
        tooltip.addEventListener('mouseleave', function() {
            const tooltipElement = this.querySelector('[id^="tooltip-"]');
            if (tooltipElement) {
                tooltipElement.classList.remove('opacity-100');
                tooltipElement.classList.add('opacity-0');
                setTimeout(() => {
                    if (tooltipElement.parentNode) {
                        tooltipElement.parentNode.removeChild(tooltipElement);
                    }
                }, 200);
            }
        });
    });
    
    // Gestion des confirmations
    const confirmButtons = document.querySelectorAll('[data-confirm]');
    confirmButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            const message = this.getAttribute('data-confirm');
            if (!confirm(message)) {
                event.preventDefault();
                return false;
            }
        });
    });
    
    // Gestion des liens externes
    const externalLinks = document.querySelectorAll('a[href^="http"]:not([href*="' + window.location.hostname + '"])');
    externalLinks.forEach(link => {
        link.setAttribute('target', '_blank');
        link.setAttribute('rel', 'noopener noreferrer');
    });
    
    // Gestion du scroll smooth
    const smoothScrollLinks = document.querySelectorAll('a[href^="#"]');
    smoothScrollLinks.forEach(link => {
        link.addEventListener('click', function(event) {
            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);
            
            if (targetElement) {
                event.preventDefault();
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Gestion des images lazy loading
    const lazyImages = document.querySelectorAll('img[data-src]');
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove('lazy');
                    imageObserver.unobserve(img);
                }
            });
        });
        
        lazyImages.forEach(img => imageObserver.observe(img));
    } else {
        // Fallback pour les navigateurs qui ne supportent pas IntersectionObserver
        lazyImages.forEach(img => {
            img.src = img.dataset.src;
            img.classList.remove('lazy');
        });
    }
    
    // Gestion des formulaires avec validation automatique
    const forms = document.querySelectorAll('form[data-validate]');
    forms.forEach(form => {
        form.addEventListener('submit', function(event) {
            const validation = window.forms.validate(this);
            
            if (!validation.isValid) {
                event.preventDefault();
                window.forms.showErrors(this, validation.errors);
                window.notifications.error('Veuillez corriger les erreurs dans le formulaire');
                
                // Faire défiler vers la première erreur
                const firstError = this.querySelector('.border-red-300');
                if (firstError) {
                    firstError.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                    firstError.focus();
                }
            }
        });
        
        // Validation en temps réel
        const inputs = form.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                const validation = window.forms.validate(form);
                const fieldName = this.name;
                
                if (validation.errors[fieldName]) {
                    window.forms.showErrors(form, { [fieldName]: validation.errors[fieldName] });
                } else {
                    // Supprimer l'erreur si le champ est maintenant valide
                    const errorElement = this.parentNode.querySelector('.error-message');
                    if (errorElement) {
                        errorElement.remove();
                    }
                    this.classList.remove('border-red-300', 'focus:border-red-500', 'focus:ring-red-500');
                    this.classList.add('border-gray-300', 'focus:border-blue-500', 'focus:ring-blue-500');
                }
            });
        });
    });
    
    // Gestion des tableaux triables
    const sortableHeaders = document.querySelectorAll('th[data-sort]');
    sortableHeaders.forEach(header => {
        header.style.cursor = 'pointer';
        header.addEventListener('click', function() {
            const table = this.closest('table');
            const tbody = table.querySelector('tbody');
            const rows = Array.from(tbody.querySelectorAll('tr'));
            const column = this.dataset.sort;
            const currentDirection = this.dataset.direction || 'asc';
            const newDirection = currentDirection === 'asc' ? 'desc' : 'asc';
            
            // Supprimer les indicateurs de tri existants
            sortableHeaders.forEach(h => {
                h.removeAttribute('data-direction');
                const indicator = h.querySelector('.sort-indicator');
                if (indicator) indicator.remove();
            });
            
            // Ajouter l'indicateur de tri
            this.dataset.direction = newDirection;
            const indicator = document.createElement('span');
            indicator.className = 'sort-indicator ml-1';
            indicator.innerHTML = newDirection === 'asc' ? '↑' : '↓';
            this.appendChild(indicator);
            
            // Trier les lignes
            rows.sort((a, b) => {
                const aValue = a.children[this.cellIndex].textContent.trim();
                const bValue = b.children[this.cellIndex].textContent.trim();
                
                // Essayer de comparer comme des nombres
                const aNum = parseFloat(aValue);
                const bNum = parseFloat(bValue);
                
                if (!isNaN(aNum) && !isNaN(bNum)) {
                    return newDirection === 'asc' ? aNum - bNum : bNum - aNum;
                } else {
                    // Comparer comme des chaînes
                    return newDirection === 'asc' 
                        ? aValue.localeCompare(bValue)
                        : bValue.localeCompare(aValue);
                }
            });
            
            // Réorganiser les lignes dans le tableau
            rows.forEach(row => tbody.appendChild(row));
        });
    });
    
    // Gestion des accordéons
    const accordionTriggers = document.querySelectorAll('[data-accordion-trigger]');
    accordionTriggers.forEach(trigger => {
        trigger.addEventListener('click', function() {
            const target = document.querySelector(this.dataset.accordionTrigger);
            const isOpen = !target.classList.contains('hidden');
            
            // Fermer tous les autres accordéons du même groupe
            const group = this.dataset.accordionGroup;
            if (group) {
                document.querySelectorAll(`[data-accordion-group="${group}"]`).forEach(otherTrigger => {
                    if (otherTrigger !== this) {
                        const otherTarget = document.querySelector(otherTrigger.dataset.accordionTrigger);
                        otherTarget.classList.add('hidden');
                        otherTrigger.classList.remove('active');
                    }
                });
            }
            
            // Basculer l'accordéon actuel
            if (isOpen) {
                target.classList.add('hidden');
                this.classList.remove('active');
            } else {
                target.classList.remove('hidden');
                this.classList.add('active');
            }
        });
    });
    
    // Gestion des onglets
    const tabTriggers = document.querySelectorAll('[data-tab-trigger]');
    tabTriggers.forEach(trigger => {
        trigger.addEventListener('click', function(event) {
            event.preventDefault();
            
            const targetId = this.dataset.tabTrigger;
            const target = document.getElementById(targetId);
            const group = this.dataset.tabGroup;
            
            if (target) {
                // Désactiver tous les onglets du groupe
                document.querySelectorAll(`[data-tab-group="${group}"]`).forEach(tab => {
                    tab.classList.remove('active');
                });
                
                // Cacher tous les panneaux du groupe
                document.querySelectorAll(`[data-tab-panel][data-tab-group="${group}"]`).forEach(panel => {
                    panel.classList.add('hidden');
                    panel.classList.remove('active');
                });
                
                // Activer l'onglet et le panneau actuels
                this.classList.add('active');
                target.classList.remove('hidden');
                target.classList.add('active');
            }
        });
    });
});

// Gestion des erreurs globales
window.addEventListener('error', function(event) {
    console.error('Erreur JavaScript:', event.error);
    // Optionnel: envoyer l'erreur à un service de monitoring
});

window.addEventListener('unhandledrejection', function(event) {
    console.error('Promise rejetée:', event.reason);
    // Optionnel: envoyer l'erreur à un service de monitoring
});

// Gestion de la connectivité
window.addEventListener('online', function() {
    window.notifications.success('Connexion rétablie');
});

window.addEventListener('offline', function() {
    window.notifications.warning('Connexion perdue');
});

// Gestion du redimensionnement de la fenêtre
let resizeTimeout;
window.addEventListener('resize', function() {
    clearTimeout(resizeTimeout);
    resizeTimeout = setTimeout(function() {
        // Actions à effectuer après le redimensionnement
        const event = new CustomEvent('windowResized');
        window.dispatchEvent(event);
    }, 250);
});

// Gestion de la visibilité de la page
document.addEventListener('visibilitychange', function() {
    if (document.hidden) {
        // La page est cachée
        console.log('Page cachée');
    } else {
        // La page est visible
        console.log('Page visible');
    }
});

// Initialisation terminée
console.log('Application JavaScript initialisée');

// import des fichiers glob
import.meta.glob([
  '../images/**',
  '../fonts/**',
]);