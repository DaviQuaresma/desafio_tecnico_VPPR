$(document).ready(function() {
    const API_URL = '/api/services';
    const token = localStorage.getItem('auth_token') || sessionStorage.getItem('auth_token');

    if (!token) {
        window.location.href = '/login';
        return;
    }

    $.ajaxSetup({
        headers: {
            'Authorization': 'Bearer ' + token,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    });

    const $loading = $('#loading');
    const $emptyState = $('#empty-state');
    const $tableContainer = $('#services-table-container');
    const $tbody = $('#services-tbody');
    const $modalService = $('#modal-service');
    const $modalDelete = $('#modal-delete');


    function showAlert(type, message) {
        const $alert = type === 'success' ? $('#alert-success') : $('#alert-error');
        const $text = type === 'success' ? $('#alert-success-text') : $('#alert-error-text');
        
        $('#alert-success, #alert-error').addClass('hidden');
        $text.text(message);
        $alert.removeClass('hidden');

        setTimeout(() => $alert.addClass('hidden'), 5000);
    }

    function formatCurrency(value) {
        return new Intl.NumberFormat('pt-BR', {
            style: 'currency',
            currency: 'BRL'
        }).format(value);
    }

    function truncateText(text, maxLength = 50) {
        if (!text) return '-';
        return text.length > maxLength ? text.substring(0, maxLength) + '...' : text;
    }

    function setModalLoading(loading) {
        const $btn = $('#modal-submit');
        const $text = $('#modal-submit-text');
        const $spinner = $('#modal-submit-spinner');

        if (loading) {
            $btn.prop('disabled', true);
            $text.text('Salvando...');
            $spinner.removeClass('hidden');
        } else {
            $btn.prop('disabled', false);
            $text.text('Salvar');
            $spinner.addClass('hidden');
        }
    }

    function setDeleteLoading(loading) {
        const $btn = $('#modal-delete-confirm');
        const $text = $('#delete-btn-text');
        const $spinner = $('#delete-btn-spinner');

        if (loading) {
            $btn.prop('disabled', true);
            $text.text('Excluindo...');
            $spinner.removeClass('hidden');
        } else {
            $btn.prop('disabled', false);
            $text.text('Excluir');
            $spinner.addClass('hidden');
        }
    }


    function openModal(service = null) {
        $('#modal-error').addClass('hidden');
        $('#service-form')[0].reset();

        if (service) {
            $('#modal-title').text('Editar Serviço');
            $('#service-id').val(service.id);
            $('#service-name').val(service.name);
            $('#service-value').val(service.value);
            $('#service-description').val(service.description || '');
        } else {
            $('#modal-title').text('Novo Serviço');
            $('#service-id').val('');
        }

        $modalService.removeClass('hidden');
    }

    function closeModal() {
        $modalService.addClass('hidden');
    }

    function openDeleteModal(id, name) {
        $('#delete-service-id').val(id);
        $('#delete-service-name').text(name);
        $modalDelete.removeClass('hidden');
    }

    function closeDeleteModal() {
        $modalDelete.addClass('hidden');
    }


    function loadServices() {
        $loading.removeClass('hidden');
        $emptyState.addClass('hidden');
        $tableContainer.addClass('hidden');

        $.ajax({
            url: API_URL,
            method: 'GET',
            success: function(response) {
                $loading.addClass('hidden');

                const services = Array.isArray(response) ? response : (response.data || []);

                if (services.length === 0) {
                    $emptyState.removeClass('hidden');
                } else {
                    renderTable(services);
                    $tableContainer.removeClass('hidden');
                }
            },
            error: function(xhr) {
                $loading.addClass('hidden');

                if (xhr.status === 401) {
                    localStorage.removeItem('auth_token');
                    sessionStorage.removeItem('auth_token');
                    window.location.href = '/login';
                } else {
                    showAlert('error', 'Erro ao carregar serviços.');
                    $emptyState.removeClass('hidden');
                }
            }
        });
    }

    function renderTable(services) {
        $tbody.empty();

        services.forEach(function(service) {
            const row = `
                <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                    <td class="px-6 py-4 text-sm text-slate-500 dark:text-slate-400">
                        ${service.id}
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-sm font-medium text-slate-900 dark:text-white">${escapeHtml(service.name)}</span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-sm text-slate-700 dark:text-slate-300">${formatCurrency(service.value)}</span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-sm text-slate-500 dark:text-slate-400">${escapeHtml(truncateText(service.description))}</span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <button 
                                class="btn-edit p-2 text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 rounded-lg transition-colors"
                                data-id="${service.id}"
                                title="Editar"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </button>
                            <button 
                                class="btn-delete p-2 text-slate-400 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors"
                                data-id="${service.id}"
                                data-name="${escapeHtml(service.name)}"
                                title="Excluir"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
            $tbody.append(row);
        });
    }

    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    function saveService() {
        const id = $('#service-id').val();
        const name = $('#service-name').val().trim();
        const value = $('#service-value').val();
        const description = $('#service-description').val().trim();

        if (!name || !value) {
            $('#modal-error-text').text('Nome e valor são obrigatórios.');
            $('#modal-error').removeClass('hidden');
            return;
        }

        setModalLoading(true);
        $('#modal-error').addClass('hidden');

        const data = { name, value: parseFloat(value), description };
        const method = id ? 'PUT' : 'POST';
        const url = id ? `${API_URL}/${id}` : API_URL;

        $.ajax({
            url: url,
            method: method,
            data: JSON.stringify(data),
            success: function() {
                closeModal();
                showAlert('success', id ? 'Serviço atualizado com sucesso!' : 'Serviço criado com sucesso!');
                loadServices();
            },
            error: function(xhr) {
                let errorMessage = 'Erro ao salvar serviço.';
                
                if (xhr.status === 422) {
                    const response = xhr.responseJSON;
                    if (response && response.errors) {
                        const errors = Object.values(response.errors).flat();
                        errorMessage = errors.join(' ');
                    } else if (response && response.message) {
                        errorMessage = response.message;
                    }
                } else if (xhr.status === 401) {
                    localStorage.removeItem('auth_token');
                    sessionStorage.removeItem('auth_token');
                    window.location.href = '/login';
                    return;
                }

                $('#modal-error-text').text(errorMessage);
                $('#modal-error').removeClass('hidden');
                setModalLoading(false);
            }
        });
    }

    function deleteService() {
        const id = $('#delete-service-id').val();

        setDeleteLoading(true);

        $.ajax({
            url: `${API_URL}/${id}`,
            method: 'DELETE',
            success: function() {
                closeDeleteModal();
                showAlert('success', 'Serviço excluído com sucesso!');
                loadServices();
            },
            error: function(xhr) {
                closeDeleteModal();
                
                if (xhr.status === 401) {
                    localStorage.removeItem('auth_token');
                    sessionStorage.removeItem('auth_token');
                    window.location.href = '/login';
                } else {
                    showAlert('error', 'Erro ao excluir serviço.');
                }
            }
        });
    }

    function getServiceById(id) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: `${API_URL}/${id}`,
                method: 'GET',
                success: function(response) {
                    resolve(response.service || response);
                },
                error: function(xhr) {
                    reject(xhr);
                }
            });
        });
    }


    $('#btn-new-service, #btn-new-service-empty').on('click', function() {
        openModal();
    });

    $('#modal-close, #modal-cancel, #modal-backdrop').on('click', function() {
        closeModal();
    });

    $('#service-form').on('submit', function(e) {
        e.preventDefault();
        saveService();
    });

    $(document).on('click', '.btn-edit', function() {
        const id = $(this).data('id');
        
        getServiceById(id).then(service => {
            openModal(service);
        }).catch(() => {
            showAlert('error', 'Erro ao carregar dados do serviço.');
        });
    });

    $(document).on('click', '.btn-delete', function() {
        const id = $(this).data('id');
        const name = $(this).data('name');
        openDeleteModal(id, name);
    });

    $('#modal-delete-cancel, #modal-delete-backdrop').on('click', function() {
        closeDeleteModal();
    });

    $('#modal-delete-confirm').on('click', function() {
        deleteService();
    });

    $(document).on('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModal();
            closeDeleteModal();
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

    $('#logout-btn').on('click', function() {
        $.ajax({
            url: '/api/auth/logout',
            method: 'POST',
            complete: function() {
                localStorage.removeItem('auth_token');
                sessionStorage.removeItem('auth_token');
                window.location.href = '/login';
            }
        });
    });

    loadServices();
});
