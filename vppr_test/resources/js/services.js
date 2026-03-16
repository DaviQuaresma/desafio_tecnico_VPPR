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
            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                <td class="px-6 py-4 text-sm text-slate-500 dark:text-slate-400">${s.id}</td>
                <td class="px-6 py-4"><span class="text-sm font-medium text-slate-900 dark:text-white">${escapeHtml(s.name)}</span></td>
                <td class="px-6 py-4"><span class="text-sm text-slate-700 dark:text-slate-300">${formatCurrency(s.value)}</span></td>
                <td class="px-6 py-4"><span class="text-sm text-slate-500 dark:text-slate-400">${escapeHtml(truncateText(s.description))}</span></td>
                <td class="px-6 py-4 text-right">
                    <div class="flex items-center justify-end gap-2">
                        <button class="btn-edit p-2 text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 rounded-lg transition-colors" data-id="${s.id}" title="Editar">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </button>
                        <button class="btn-delete p-2 text-slate-400 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors" data-id="${s.id}" data-name="${escapeHtml(s.name)}" title="Excluir">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
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

    $('#logout-btn').on('click', logout);
    loadServices();
});
