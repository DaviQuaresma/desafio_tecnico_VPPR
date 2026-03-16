import { getMe } from './api/auth.js';
import { getServices, getService, createService, updateService, deleteService as deleteServiceApi } from './api/services.js';
import { getErrorMessage } from './api/index.js';
import { requireAuth, logout } from './helpers/auth.js';
import { toastSuccess, toastError } from './helpers/messages.js';
import { setSaveLoading, setDeleteLoading } from './helpers/loading.js';
import { formatCurrency, truncateText, escapeHtml } from './helpers/formatters.js';
import { setupEscapeClose } from './helpers/modal.js';

$(document).ready(async function() {
    if (requireAuth()) return;

    const DOM = {
        loading: $('#loading'),
        emptyState: $('#empty-state'),
        tableContainer: $('#services-table-container'),
        tbody: $('#services-tbody'),
        modalService: $('#modal-service'),
        modalDelete: $('#modal-delete')
    };

    const serviceModal = {
        open(service = null) {
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
            DOM.modalService.removeClass('hidden');
        },
        close() {
            DOM.modalService.addClass('hidden');
            setSaveLoading(false);
        }
    };

    const deleteModal = {
        open(id, name) {
            $('#delete-service-id').val(id);
            $('#delete-service-name').text(name);
            DOM.modalDelete.removeClass('hidden');
        },
        close() {
            DOM.modalDelete.addClass('hidden');
            setDeleteLoading(false);
        }
    };

    async function loadServices() {
        DOM.loading.removeClass('hidden');
        DOM.emptyState.addClass('hidden');
        DOM.tableContainer.addClass('hidden');

        try {
            const services = await getServices();
            DOM.loading.addClass('hidden');
            
            if (services.length === 0) {
                DOM.emptyState.removeClass('hidden');
            } else {
                renderTable(services);
                DOM.tableContainer.removeClass('hidden');
            }
        } catch {
            DOM.loading.addClass('hidden');
            toastError('Erro ao carregar serviços.');
            DOM.emptyState.removeClass('hidden');
        }
    }

    async function saveService() {
        const id = $('#service-id').val();
        const data = {
            name: $('#service-name').val().trim(),
            value: parseFloat($('#service-value').val()),
            description: $('#service-description').val().trim()
        };

        if (!data.name || !data.value) {
            $('#modal-error-text').text('Nome e valor são obrigatórios.');
            $('#modal-error').removeClass('hidden');
            return;
        }

        setSaveLoading(true);
        $('#modal-error').addClass('hidden');

        try {
            if (id) {
                await updateService(id, data);
            } else {
                await createService(data);
            }
            serviceModal.close();
            toastSuccess(id ? 'Serviço atualizado!' : 'Serviço criado!');
            loadServices();
        } catch (error) {
            $('#modal-error-text').text(getErrorMessage(error, 'Erro ao salvar.'));
            $('#modal-error').removeClass('hidden');
            setSaveLoading(false);
        }
    }

    async function handleDeleteService() {
        const id = $('#delete-service-id').val();
        setDeleteLoading(true);

        try {
            await deleteServiceApi(id);
            deleteModal.close();
            toastSuccess('Serviço excluído!');
            loadServices();
        } catch {
            deleteModal.close();
            toastError('Erro ao excluir serviço.');
        }
    }

    function renderTable(services) {
        DOM.tbody.empty();
        services.forEach(s => DOM.tbody.append(createRow(s)));
    }

    function createRow(s) {
        return `
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-6 py-4 text-sm text-vppr-navy-500 font-mono">#${s.id}</td>
                <td class="px-6 py-4"><span class="text-sm font-medium text-vppr-navy-900">${escapeHtml(s.name)}</span></td>
                <td class="px-6 py-4"><span class="text-sm font-semibold text-vppr-gold-600">${formatCurrency(s.value)}</span></td>
                <td class="px-6 py-4"><span class="text-sm text-vppr-navy-600">${escapeHtml(truncateText(s.description))}</span></td>
                <td class="px-6 py-4 text-right">
                    <div class="flex items-center justify-end gap-1">
                        <button class="btn-edit p-2 text-vppr-navy-500 hover:text-vppr-blue-600 hover:bg-vppr-blue-50 rounded-lg transition-colors" data-id="${s.id}" title="Editar">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/><path d="m15 5 4 4"/></svg>
                        </button>
                        <button class="btn-delete p-2 text-vppr-navy-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" data-id="${s.id}" data-name="${escapeHtml(s.name)}" title="Excluir">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                        </button>
                    </div>
                </td>
            </tr>`;
    }

    $('#btn-new-service, #btn-new-service-empty').on('click', () => serviceModal.open());
    $('#modal-close, #modal-cancel, #modal-backdrop').on('click', serviceModal.close);
    $('#modal-delete-cancel, #modal-delete-backdrop').on('click', deleteModal.close);
    $('#modal-delete-confirm').on('click', handleDeleteService);
    $('#service-form').on('submit', e => { e.preventDefault(); saveService(); });

    $(document).on('click', '.btn-edit', async function() {
        try {
            const service = await getService($(this).data('id'));
            serviceModal.open(service);
        } catch {
            toastError('Erro ao carregar serviço.');
        }
    });

    $(document).on('click', '.btn-delete', function() {
        deleteModal.open($(this).data('id'), $(this).data('name'));
    });

    setupEscapeClose(serviceModal.close, deleteModal.close);

    try {
        const user = await getMe();
        $('#user-name').text('Olá, ' + user.name);
    } catch {}

    $('#logout-btn').on('click', () => logout());
    
    await loadServices();

    if (new URLSearchParams(window.location.search).get('new') === '1') {
        serviceModal.open();
        window.history.replaceState({}, '', window.location.pathname);
    }
});
