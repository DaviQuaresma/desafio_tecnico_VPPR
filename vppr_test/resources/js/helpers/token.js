export function getToken() {
    return localStorage.getItem('auth_token') || sessionStorage.getItem('auth_token');
}

export function saveToken(token, remember = true) {
    if (remember) {
        localStorage.setItem('auth_token', token);
    } else {
        sessionStorage.setItem('auth_token', token);
    }
}

export function removeToken() {
    localStorage.removeItem('auth_token');
    sessionStorage.removeItem('auth_token');
}
