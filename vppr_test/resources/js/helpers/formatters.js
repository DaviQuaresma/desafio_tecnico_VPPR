export function formatCurrency(value) {
    return new Intl.NumberFormat('pt-BR', {
        style: 'currency',
        currency: 'BRL'
    }).format(value);
}

export function formatMoney(value, currency = 'BRL', locale = 'pt-BR') {
    return new Intl.NumberFormat(locale, {
        style: 'currency',
        currency: currency
    }).format(value);
}

export function truncateText(text, maxLength = 50, suffix = '...') {
    if (!text) return '-';
    return text.length > maxLength ? text.substring(0, maxLength) + suffix : text;
}

export function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

export function formatDate(date, includeTime = false) {
    const d = new Date(date);
    const options = {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
    };
    
    if (includeTime) {
        options.hour = '2-digit';
        options.minute = '2-digit';
    }
    
    return d.toLocaleDateString('pt-BR', options);
}

export function formatNumber(value, decimals = 2) {
    return new Intl.NumberFormat('pt-BR', {
        minimumFractionDigits: decimals,
        maximumFractionDigits: decimals
    }).format(value);
}

export function capitalize(text) {
    if (!text) return '';
    return text.toLowerCase().replace(/\b\w/g, char => char.toUpperCase());
}

export function removeAccents(text) {
    if (!text) return '';
    return text.normalize('NFD').replace(/[\u0300-\u036f]/g, '');
}
