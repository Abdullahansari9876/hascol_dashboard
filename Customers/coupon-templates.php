<?php
// Hascol Admin - Default Coupon Templates Management
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Default Coupon Templates | Hascol Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- DataTables Core -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    
    <!-- DataTables Export Buttons CSS & JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        (function () {
            const isDarkMode = localStorage.getItem('darkMode') === 'true';
            if (isDarkMode) document.documentElement.classList.add('dark-mode');
        })();
    </script>

    <script>
        tailwind.config = {
            theme: { extend: { fontFamily: { sans: ['Inter', 'sans-serif'] } } }
        }
    </script>

    <style>
        :root {
            --bg-body: #f4f6fa; --bg-panel: #ffffff; --border-color: #e2e8f0;
            --text-heading: #0f2440; --text-body: #334155; --text-muted: #64748b;
            --input-bg: #ffffff; --hover-bg: #f1f5f9; --table-head-bg: #f8fafc;
            --table-head-text: #475569; --table-row-text: #1e293b; --table-row-hover: #f1f5f9;
            --btn-secondary-bg: #e2e8f0; --btn-secondary-text: #334155;
            --btn-secondary-hover-bg: #cbd5e1; --btn-secondary-hover-text: #0f2440;
            --toolbar-btn-bg: #ffffff;
        }

        html.dark-mode {
            --bg-body: #060b13; --bg-panel: #0d1520; --border-color: #1a2635;
            --text-heading: #ffffff; --text-body: #e5e7eb; --text-muted: #94a3b8;
            --input-bg: #060b13; --hover-bg: #1a2635; --table-head-bg: #0a121c;
            --table-head-text: #94a3b8; --table-row-text: #e5e7eb; --table-row-hover: #0d1a2a;
            --btn-secondary-bg: #1a2635; --btn-secondary-text: #94a3b8;
            --btn-secondary-hover-bg: #1f2a3d; --btn-secondary-hover-text: #ffffff;
            --toolbar-btn-bg: #060b13;
        }

        body { background-color: var(--bg-body); color: var(--text-muted); font-family: 'Inter', sans-serif; }
        .text-heading { color: var(--text-heading) !important; }
        .panel-card { background-color: var(--bg-panel); border: 1px solid var(--border-color); border-radius: 0.375rem; }

        .form-input {
            background-color: var(--input-bg); border: 1px solid var(--border-color);
            border-radius: 0.25rem; color: var(--text-body); padding: 6px 10px;
            width: 100%; font-size: 12px; box-sizing: border-box; transition: border-color .15s, box-shadow .15s;
        }
        .form-input:focus { outline: none; border-color: #1d4ed8; box-shadow: 0 0 0 2px rgba(29, 78, 216, .2); }
        .form-input::placeholder { color: var(--text-muted); }

        .form-label { color: var(--text-muted); font-size: 11px; font-weight: 500; margin-bottom: 4px; display: block; }
        
        .btn-primary {
            background-color: #1d4ed8; color: #fff; padding: 8px 20px;
            border-radius: 0.25rem; border: none; font-size: 12px; font-weight: 500;
            cursor: pointer; display: inline-flex; align-items: center; gap: 6px; transition: background-color .15s;
        }
        .btn-primary:hover { background-color: #2563eb; }
        .btn-primary:disabled { opacity: .6; cursor: not-allowed; }

        .btn-secondary {
            background-color: var(--btn-secondary-bg); color: var(--btn-secondary-text);
            padding: 8px 20px; border-radius: 0.25rem; border: none; font-size: 12px;
            font-weight: 500; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; transition: all .15s;
        }
        .btn-secondary:hover { background-color: var(--btn-secondary-hover-bg); color: var(--btn-secondary-hover-text); }
        
        .btn-danger { background-color: #ef4444; color: #fff; }
        .btn-danger:hover { background-color: #dc2626; }
        .btn-sm { padding: 4px 10px; font-size: 10px; }

        .table-container { position: relative; overflow-x: auto; min-height: 120px; }
        .table-container table { width: 100% !important; border-collapse: collapse; font-size: 11px; }
        .table-container table thead th {
            background-color: var(--table-head-bg) !important; color: var(--table-head-text) !important;
            font-weight: 500; text-align: left; padding: 10px 12px;
            border-bottom: 1px solid var(--border-color); white-space: nowrap; font-size: 10px;
            text-transform: uppercase; letter-spacing: .5px;
        }
        .table-container table tbody td {
            padding: 10px 12px; border-bottom: 1px solid var(--border-color);
            color: var(--table-row-text); vertical-align: middle;
        }
        .table-container table tbody tr:hover { background-color: var(--table-row-hover); }

        .table-loading-overlay {
            position: absolute; inset: 0; background-color: var(--bg-panel);
            display: flex; align-items: center; justify-content: center; gap: 8px;
            font-size: 12px; color: var(--text-muted); z-index: 5;
        }
        .table-loading-overlay.hidden { display: none; }

        /* ── DataTables Custom Styling (Search & Export Buttons) ── */
        .dataTables_wrapper .dt-buttons {
            display: inline-flex !important;
            gap: 6px !important;
            flex-wrap: wrap !important;
            margin: 0 0 10px 0 !important;
            padding: 0 !important;
            float: left;
        }

        .dataTables_wrapper .dt-buttons .dt-button, button.dt-button {
            background: var(--toolbar-btn-bg) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 0.25rem !important;
            box-shadow: none !important;
            color: var(--text-body) !important;
            font-family: 'Inter', sans-serif !important;
            font-size: 11px !important;
            font-weight: 500 !important;
            padding: 0 12px !important;
            height: 32px !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 6px !important;
            cursor: pointer !important;
            transition: all .15s !important;
        }

        .dataTables_wrapper .dt-buttons .dt-button:hover, button.dt-button:hover {
            background-color: var(--hover-bg) !important;
            color: var(--text-heading) !important;
        }
        
        .dataTables_wrapper .dt-buttons .dt-button i { margin-right: 4px; }

        .dataTables_wrapper .dataTables_filter {
            float: right;
            margin-bottom: 10px !important;
        }

        .dataTables_wrapper .dataTables_filter input {
            background-color: var(--input-bg) !important; border: 1px solid var(--border-color) !important;
            border-radius: 0.25rem !important; color: var(--text-body) !important; padding: 6px 12px !important;
            font-size: 12px !important; height: 32px !important; width: 220px !important;
        }
        
        .dataTables_wrapper::after { content: ""; display: table; clear: both; }

        .modal-backdrop-custom {
            position: fixed; inset: 0; background: rgba(0, 0, 0, .55);
            z-index: 10000; display: flex; align-items: center; justify-content: center;
            padding: 16px; backdrop-filter: blur(2px);
        }
        .modal-backdrop-custom.hidden { display: none !important; }
        .modal-box {
            background: var(--bg-panel); border: 1px solid var(--border-color);
            border-radius: 8px; width: 100%; max-width: 650px; max-height: 92vh;
            display: flex; flex-direction: column; box-shadow: 0 20px 60px rgba(0, 0, 0, .35);
        }
        .modal-header { padding: 14px 18px; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center; }
        .modal-body { padding: 16px 18px; overflow-y: auto; }
        .modal-footer { padding: 12px 18px; border-top: 1px solid var(--border-color); display: flex; justify-content: flex-end; gap: 8px; background: var(--bg-panel); }
        .modal-close-btn { background: transparent; border: none; cursor: pointer; color: var(--text-muted); font-size: 18px; }
        .modal-title { color: var(--text-heading); font-weight: 600; font-size: 14px; display: flex; align-items: center; gap: 8px; }
        
        .toast {
            position: fixed; bottom: 30px; right: 30px; background: var(--bg-panel);
            border: 1px solid var(--border-color); border-radius: .375rem;
            padding: 12px 20px; color: var(--text-body); font-size: 12px;
            z-index: 9999; transform: translateY(100px); opacity: 0;
            transition: all .3s ease-in-out; box-shadow: 0 10px 30px rgba(0, 0, 0, .25);
        }
        .toast.show { transform: translateY(0); opacity: 1; }
        .toast.success { border-color: #10b981; }
        .toast.error { border-color: #ef4444; }
        
        .badge-active { background: rgba(16, 185, 129, .12); color: #10b981; border: 1px solid rgba(16, 185, 129, .25); padding: 3px 9px; border-radius: 12px; font-size: 10px; font-weight: 600; }
        .badge-inactive { background: rgba(148, 163, 184, .15); color: #94a3b8; border: 1px solid rgba(148, 163, 184, .3); padding: 3px 9px; border-radius: 12px; font-size: 10px; font-weight: 600; }
        
        .swal2-container { z-index: 999999 !important; }
    </style>
</head>

<body class="flex h-screen overflow-hidden text-xs">

    <?php include __DIR__ . '/../includes/sidebar.php'; ?>

    <main id="mainContent" class="flex-1 flex flex-col overflow-hidden">
        <?php include __DIR__ . '/../includes/topbar.php'; ?>

        <div class="flex-1 overflow-y-auto p-4" id="pageContent">
            <div class="flex flex-wrap justify-between items-center mb-4 gap-2">
                <div>
                    <h2 class="text-heading font-semibold text-base tracking-wide uppercase">
                        <i class="fa-solid fa-layer-group mr-2 text-blue-500"></i>Default Coupon Templates
                    </h2>
                    <p class="text-[10px] text-gray-500">Manage coupons that are automatically assigned to new customers.</p>
                </div>
                <div>
                    <button type="button" id="btnOpenAdd" class="btn-primary" style="height:34px;">
                        <i class="fa-solid fa-plus-circle"></i> Add Template
                    </button>
                </div>
            </div>

            <div class="panel-card overflow-hidden p-3">
                <div class="table-container">
                    <div class="table-loading-overlay" id="tableLoadingOverlay">
                        <i class="fa-solid fa-spinner fa-spin text-blue-400"></i> Loading templates...
                    </div>
                    <table id="tplTable" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Template Title</th>
                                <th>Discount</th>
                                <th>Validity</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <div id="tplModal" class="modal-backdrop-custom hidden">
        <div class="modal-box">
            <div class="modal-header">
                <div class="modal-title">
                    <i class="fa-solid fa-ticket text-blue-500"></i>
                    <span id="modalTitleText">Add New Template</span>
                </div>
                <button type="button" class="modal-close-btn" id="btnCloseModal">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <div class="modal-body">
                <form id="tplForm" autocomplete="off">
                    <input type="hidden" id="tplId" value="">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div class="md:col-span-2">
                            <label class="form-label">Coupon Title <span style="color:#ef4444;">*</span></label>
                            <input type="text" id="tplTitle" class="form-input" placeholder="e.g. Welcome 15% Off" required>
                        </div>

                        <div class="md:col-span-2">
                            <label class="form-label">Description</label>
                            <input type="text" id="tplDesc" class="form-input" placeholder="e.g. Get 15% discount on first order">
                        </div>

                        <div class="md:col-span-2">
                            <label class="form-label">Banner Image (Upload File)</label>
                            <input type="file" id="tplImageFile" class="form-input" accept="image/*">
                            <small id="imgPreviewName" style="color:var(--text-muted); font-size:10px;"></small>
                        </div>

                        <div>
                            <label class="form-label">Discount Type <span style="color:#ef4444;">*</span></label>
                            <select id="tplType" class="form-input" required>
                                <option value="percent">Percent (%)</option>
                                <option value="flat">Flat (Rs.)</option>
                            </select>
                        </div>

                        <div>
                            <label class="form-label">Discount Value <span style="color:#ef4444;">*</span></label>
                            <input type="number" id="tplValue" class="form-input" min="0.01" step="0.01" placeholder="e.g. 15" required>
                        </div>

                        <!-- ✅ STATUS FIELD ADDED HERE -->
                        <div>
                            <label class="form-label">Status <span style="color:#ef4444;">*</span></label>
                            <select id="tplStatus" class="form-input" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                        <div>
                            <label class="form-label">Valid From <span style="color:#ef4444;">*</span></label>
                            <input type="date" id="tplValidFrom" class="form-input" required>
                        </div>

                        <div>
                            <label class="form-label">Valid To <span style="color:#ef4444;">*</span></label>
                            <input type="date" id="tplValidTo" class="form-input" required>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-secondary" id="btnCancelModal">
                    <i class="fa-solid fa-xmark"></i> Cancel
                </button>
                <button type="button" class="btn-primary" id="btnSubmitForm">
                    <i class="fa-solid fa-save"></i> Save Template
                </button>
            </div>
        </div>
    </div>

    <div id="toast" class="toast">
        <i class="fa-solid fa-check-circle mr-2"></i>
        <span id="toastMessage">Data loaded successfully!</span>
    </div>

    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        const API_BASE = 'http://localhost:8080/hascol_customer/api/admin/';
        let dataTable = null;
        let templatesCache = [];

        // Export Buttons Config
        const exportButtons = [
            { extend: 'copy', text: '<i class="fa-regular fa-copy"></i> Copy', className: 'dt-button' },
            { extend: 'excelHtml5', text: '<i class="fa-regular fa-file-excel"></i> Excel', className: 'dt-button', title: 'Coupon_Templates_Export' },
            { extend: 'csvHtml5', text: '<i class="fa-regular fa-file-csv"></i> CSV', className: 'dt-button', title: 'Coupon_Templates_Export' },
            { extend: 'pdfHtml5', text: '<i class="fa-regular fa-file-pdf"></i> PDF', className: 'dt-button', orientation: 'landscape', pageSize: 'A4', title: 'Coupon_Templates' },
            { extend: 'print', text: '<i class="fa-solid fa-print"></i> Print', className: 'dt-button' }
        ];

        $(document).ready(function () {
            dataTable = $('#tplTable').DataTable({
                dom: 'Bfrtip',
                buttons: exportButtons,
                pageLength: 10,
                order: [],
                columnDefs: [{ orderable: false, targets: '_all' }],
                language: {
                    emptyTable: 'No templates found',
                    search: '',
                    searchPlaceholder: 'Search templates...'
                }
            });

            $('#btnOpenAdd').on('click', () => openModal());
            $('#btnCloseModal, #btnCancelModal').on('click', closeModal);
            $('#tplModal').on('click', function (e) { if (e.target === this) closeModal(); });
            $('#btnSubmitForm').on('click', submitForm);
            
            $('#tplImageFile').on('change', function() {
                const file = this.files[0];
                $('#imgPreviewName').text(file ? file.name : '');
            });

            loadTemplates();
        });

        function showToast(message, type = 'success') {
            const toast = $('#toast');
            toast.removeClass('success error').addClass(type);
            $('#toastMessage').text(message);
            toast.addClass('show');
            clearTimeout(window._toastT);
            window._toastT = setTimeout(() => toast.removeClass('show'), 3000);
        }

        function formatDateDisplay(dateString) {
            if(!dateString) return '—';
            const d = new Date(dateString);
            return d.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
        }

        function openModal(templateId = null) {
            $('#tplForm')[0].reset();
            $('#tplId').val('');
            $('#imgPreviewName').text('');
            
            if (templateId) {
                const tpl = templatesCache.find(t => t.id == templateId);
                if (tpl) {
                    $('#modalTitleText').text('Edit Template');
                    $('#tplId').val(tpl.id);
                    $('#tplTitle').val(tpl.title);
                    $('#tplDesc').val(tpl.description);
                    
                    if(tpl.valid_from) $('#tplValidFrom').val(tpl.valid_from.split(' ')[0]);
                    if(tpl.valid_to) $('#tplValidTo').val(tpl.valid_to.split(' ')[0]);
                    
                    if (tpl.discount_percent > 0) {
                        $('#tplType').val('percent');
                        $('#tplValue').val(tpl.discount_percent);
                    } else {
                        $('#tplType').val('flat');
                        $('#tplValue').val(tpl.discount_amount);
                    }

                    // ✅ Status Set Karein
                    $('#tplStatus').val(tpl.is_active);
                }
            } else {
                $('#modalTitleText').text('Add New Template');
                $('#tplType').val('percent');
                
                const today = new Date().toISOString().split('T')[0];
                const nextYear = new Date(new Date().setFullYear(new Date().getFullYear() + 1)).toISOString().split('T')[0];
                $('#tplValidFrom').val(today);
                $('#tplValidTo').val(nextYear);

                // ✅ Default Status Active
                $('#tplStatus').val('1'); 
            }
            
            $('#tplModal').removeClass('hidden');
        }

        function closeModal() {
            $('#tplModal').addClass('hidden');
        }

        function loadTemplates() {
            $('#tableLoadingOverlay').removeClass('hidden');
            $.ajax({
                url: API_BASE + 'list-coupon-templates.php', 
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({}), 
                dataType: 'json',
                success: function (res) {
                    dataTable.clear().draw();
                    templatesCache = [];

                    if (res && res.status === 'success' && res.data.length > 0) {
                        templatesCache = res.data;
                        $.each(res.data, function (i, tpl) {
                            
                            let discountStr = '';
                            if (tpl.discount_percent > 0) {
                                discountStr = `<span style="color:#10b981;font-weight:700;">${parseFloat(tpl.discount_percent).toFixed(2)}%</span>`;
                            } else {
                                discountStr = `<span style="color:#8b5cf6;font-weight:700;">Rs ${parseFloat(tpl.discount_amount).toFixed(2)}</span>`;
                            }

                            let validityStr = `
                                <div style="font-size:10px; line-height:1.4;">
                                    <span style="color:var(--text-muted);">From:</span> ${formatDateDisplay(tpl.valid_from)}<br>
                                    <span style="color:var(--text-muted);">To:</span> <b style="color:var(--text-heading);">${formatDateDisplay(tpl.valid_to)}</b>
                                </div>
                            `;

                            let statusStr = tpl.is_active == 1 
                                ? '<span class="badge-active">Active</span>' 
                                : '<span class="badge-inactive">Inactive</span>';

                            let actionStr = `
                                <button class="btn-primary btn-sm" onclick="openModal(${tpl.id})" style="margin-right:4px;">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                                <button class="btn-danger btn-sm" onclick="deleteTemplate(${tpl.id})">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            `;

                            dataTable.row.add([
                                i + 1,
                                `<div style="font-weight:600;color:var(--text-heading);">${tpl.title}</div>
                                 <div style="font-size:10px;color:var(--text-muted);">${tpl.description || '—'}</div>`,
                                discountStr,
                                validityStr,
                                statusStr,
                                actionStr
                            ]);
                        });
                    } else {
                        dataTable.row.add(['No templates found.', '', '', '', '', '']);
                    }
                    dataTable.draw(false);
                    $('#tableLoadingOverlay').hide();
                },
                error: function () {
                    $('#tableLoadingOverlay').hide();
                    showToast('Failed to load templates', 'error');
                }
            });
        }

        function submitForm() {
            const id = $('#tplId').val();
            const title = $('#tplTitle').val().trim();
            const desc = $('#tplDesc').val().trim();
            const type = $('#tplType').val();
            const value = parseFloat($('#tplValue').val() || 0);
            const validFrom = $('#tplValidFrom').val();
            const validTo = $('#tplValidTo').val();
            const status = $('#tplStatus').val(); // ✅ Get Status
            const imageFile = $('#tplImageFile')[0].files[0];

            if (!title) return showToast('Title is required', 'error');
            if (value <= 0) return showToast('Discount value must be > 0', 'error');
            if (!validFrom || !validTo) return showToast('Validity dates are required', 'error');
            if (new Date(validTo) < new Date(validFrom)) return showToast('Valid To date must be after Valid From date', 'error');

            const btn = $('#btnSubmitForm');
            btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin"></i> Saving...');

            const processData = (base64Image = '') => {
                const payload = {
                    id: id,
                    title: title,
                    description: desc,
                    discount_type: type,
                    discount_value: value,
                    valid_from: validFrom,
                    valid_to: validTo,
                    is_active: status, // ✅ Add to Payload
                    image_base64: base64Image
                };

                const url = id ? API_BASE + 'update-coupon-template.php' : API_BASE + 'add-coupon-template.php';

                $.ajax({
                    url: url,
                    method: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify(payload),
                    dataType: 'json',
                    success: function (res) {
                        if (res && res.status === 'success') {
                            Swal.fire({ icon: 'success', title: 'Success', text: res.message, timer: 1500, showConfirmButton: false });
                            closeModal();
                            loadTemplates();
                        } else {
                            Swal.fire('Error', res.message || 'Something went wrong', 'error');
                        }
                    },
                    error: function () {
                        Swal.fire('Error', 'Server error occurred', 'error');
                    },
                    complete: function () {
                        btn.prop('disabled', false).html('<i class="fa-solid fa-save"></i> Save Template');
                    }
                });
            };

            if (imageFile) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    processData(e.target.result);
                };
                reader.readAsDataURL(imageFile);
            } else {
                processData('');
            }
        }

        function deleteTemplate(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This template will be marked as inactive.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: API_BASE + 'delete-coupon-template.php',
                        method: 'POST',
                        contentType: 'application/json',
                        data: JSON.stringify({ id: id }),
                        dataType: 'json',
                        success: function (res) {
                            if (res && res.status === 'success') {
                                showToast(res.message, 'success');
                                loadTemplates();
                            } else {
                                showToast(res.message || 'Failed to delete', 'error');
                            }
                        }
                    });
                }
            });
        }
    </script>

</body>
</html>