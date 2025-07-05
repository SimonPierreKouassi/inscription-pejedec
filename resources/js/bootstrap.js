import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Configuration CSRF pour Axios
let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

// Configuration des intercepteurs Axios
window.axios.interceptors.request.use(
    config => {
        // Ajouter un indicateur de chargement
        const loadingEvent = new CustomEvent('axios:loading', { detail: { loading: true } });
        window.dispatchEvent(loadingEvent);
        return config;
    },
    error => {
        const loadingEvent = new CustomEvent('axios:loading', { detail: { loading: false } });
        window.dispatchEvent(loadingEvent);
        return Promise.reject(error);
    }
);

window.axios.interceptors.response.use(
    response => {
        // Supprimer l'indicateur de chargement
        const loadingEvent = new CustomEvent('axios:loading', { detail: { loading: false } });
        window.dispatchEvent(loadingEvent);
        return response;
    },
    error => {
        // Supprimer l'indicateur de chargement
        const loadingEvent = new CustomEvent('axios:loading', { detail: { loading: false } });
        window.dispatchEvent(loadingEvent);
        
        // Gestion des erreurs globales
        if (error.response) {
            switch (error.response.status) {
                case 401:
                    // Non autorisé - rediriger vers la page de connexion
                    window.location.href = '/login';
                    break;
                case 403:
                    // Interdit
                    if (window.notifications) {
                        window.notifications.error('Vous n\'avez pas les permissions nécessaires');
                    }
                    break;
                case 404:
                    // Non trouvé
                    if (window.notifications) {
                        window.notifications.error('Ressource non trouvée');
                    }
                    break;
                case 422:
                    // Erreur de validation
                    if (error.response.data.errors) {
                        const errors = error.response.data.errors;
                        const firstError = Object.values(errors)[0][0];
                        if (window.notifications) {
                            window.notifications.error(firstError);
                        }
                    }
                    break;
                case 500:
                    // Erreur serveur
                    if (window.notifications) {
                        window.notifications.error('Erreur serveur. Veuillez réessayer plus tard.');
                    }
                    break;
                default:
                    if (window.notifications) {
                        window.notifications.error('Une erreur est survenue');
                    }
            }
        } else if (error.request) {
            // Erreur de réseau
            if (window.notifications) {
                window.notifications.error('Erreur de connexion. Vérifiez votre connexion internet.');
            }
        }
        
        return Promise.reject(error);
    }
);