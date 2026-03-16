import Toastify from 'toastify-js';
import 'toastify-js/src/toastify.css';

const defaultConfig = {
    duration: 4000,
    gravity: 'top',
    position: 'right',
    stopOnFocus: true,
    close: true
};

export function toast(message, options = {}) {
    Toastify({
        text: message,
        ...defaultConfig,
        style: {
            background: 'linear-gradient(to right, #10b981, #059669)',
            borderRadius: '8px',
            boxShadow: '0 4px 12px rgba(0,0,0,0.15)'
        },
        ...options
    }).showToast();
}

export function toastSuccess(message) {
    toast(message, {
        style: {
            background: 'linear-gradient(to right, #10b981, #059669)',
            borderRadius: '8px',
            boxShadow: '0 4px 12px rgba(0,0,0,0.15)'
        }
    });
}

export function toastError(message) {
    toast(message, {
        duration: 5000,
        style: {
            background: 'linear-gradient(to right, #ef4444, #dc2626)',
            borderRadius: '8px',
            boxShadow: '0 4px 12px rgba(0,0,0,0.15)'
        }
    });
}

export function toastWarning(message) {
    toast(message, {
        style: {
            background: 'linear-gradient(to right, #f59e0b, #d97706)',
            borderRadius: '8px',
            boxShadow: '0 4px 12px rgba(0,0,0,0.15)'
        }
    });
}

export function toastInfo(message) {
    toast(message, {
        style: {
            background: 'linear-gradient(to right, #3b82f6, #2563eb)',
            borderRadius: '8px',
            boxShadow: '0 4px 12px rgba(0,0,0,0.15)'
        }
    });
}

export const showAlert = (type, message) => {
    if (type === 'success') toastSuccess(message);
    else if (type === 'error') toastError(message);
    else if (type === 'warning') toastWarning(message);
    else toastInfo(message);
};

export function showError(message, errorSelector = '#error-message', textSelector = '#error-text') {
    $(textSelector).text(message);
    $(errorSelector).removeClass('hidden');
}

export function showSuccess(message, successSelector = '#success-message', textSelector = '#success-text') {
    $(textSelector).text(message);
    $(successSelector).removeClass('hidden');
}

export function hideMessages(errorSelector = '#error-message', successSelector = '#success-message') {
    $(errorSelector).addClass('hidden');
    $(successSelector).addClass('hidden');
}
