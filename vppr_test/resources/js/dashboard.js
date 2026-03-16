$(document).ready(function() {
    const token = localStorage.getItem('auth_token') || sessionStorage.getItem('auth_token');

    if (!token) {
        window.location.href = '/login';
        return;
    }

    $.ajaxSetup({
        headers: {
            'Authorization': 'Bearer ' + token,
            'Accept': 'application/json'
        }
    });

    $.ajax({
        url: '/api/auth/me',
        method: 'GET',
        success: function(response) {
            if (response.user && response.user.name) {
                $('#user-name').text('Olá, ' + response.user.name);
            }
        },
        error: function(xhr) {
            if (xhr.status === 401) {
                localStorage.removeItem('auth_token');
                sessionStorage.removeItem('auth_token');
                window.location.href = '/login';
            }
        }
    });

    $.ajax({
        url: '/api/services',
        method: 'GET',
        success: function(response) {
            let count = 0;
            if (Array.isArray(response)) {
                count = response.length;
            } else if (response.data && Array.isArray(response.data)) {
                count = response.data.length;
            }
            $('#services-count').text(count);
        },
        error: function() {
            $('#services-count').text('0');
        }
    });

    $('#logout-btn').on('click', function() {
        $.ajax({
            url: '/api/auth/logout',
            method: 'POST',
            success: function() {
                localStorage.removeItem('auth_token');
                sessionStorage.removeItem('auth_token');
                window.location.href = '/login';
            },
            error: function() {
                localStorage.removeItem('auth_token');
                sessionStorage.removeItem('auth_token');
                window.location.href = '/login';
            }
        });
    });
});
