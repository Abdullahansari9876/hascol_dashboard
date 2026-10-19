<?php
// Hascol Customer - Device Change Requests
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Device Requests | Hascol Customer</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

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
            --bg-body: #f4f6fa;
            --bg-panel: #ffffff;
            --border-color: #e2e8f0;
            --text-heading: #0f2440;
            --text-body: #334155;
            --text-muted: #64748b;
            --input-bg: #ffffff;
            --hover-bg: #f1f5f9;
            --table-head-bg: #f8fafc;
            --table-head-text: #475569;
            --table-row-text: #1e293b;
            --table-row-hover: #f1f5f9;
            --scrollbar-track: #eef1f6;
            --scrollbar-thumb: #cbd5e1;
            --modal-overlay: rgba(15, 23, 42, 0.45);
            --btn-secondary-bg: #e2e8f0;
            --btn-secondary-text: #334155;
            --btn-secondary-hover-bg: #cbd5e1;
            --btn-secondary-hover-text: #0f2440;
            --toolbar-btn-bg: #ffffff;
        }

        html.dark-mode {
            --bg-body: #060b13;
            --bg-panel: #0d1520;
            --border-color: #1a2635;
            --text-heading: #ffffff;
            --text-body: #e5e7eb;
            --text-muted: #94a3b8;
            --input-bg: #060b13;
            --hover-bg: #1a2635;
            --table-head-bg: #0a121c;
            --table-head-text: #94a3b8;
            --table-row-text: #e5e7eb;
            --table-row-hover: #0d1a2a;
            --scrollbar-track: #060b13;
            --scrollbar-thumb: #1a2635;
            --modal-overlay: rgba(6, 11, 19, .85);
            --btn-secondary-bg: #1a2635;
            --btn-secondary-text: #94a3b8;
            --btn-secondary-hover-bg: #1f2a3d;
            --btn-secondary-hover-text: #ffffff;
            --toolbar-btn-bg: #060b13;
        }

        body { background-color: var(--bg-body); color: var(--text-muted); font-family: 'Inter', sans-serif; }
        .text-heading { color: var(--text-heading) !important; }

        .panel-card { background-color: var(--bg-panel); border: 1px solid var(--border-color); border-radius: 0.375rem; }

        .form-input {
            background-color: var(--input-bg); border: 1px solid var(--border-color); border-radius: 0.25rem;
            color: var(--text-body); padding: 6px 10px; width: 100%; font-size: 12px; box-sizing: border-box;
        }
        .form-input:focus { outline: none; border-color: #1d4ed8; box-shadow: 0 0 0 2px rgba(29, 78, 216, .2); }
        .form-input::placeholder { color: var(--text-muted); }
        .form-input[readonly] { background-color: var(--hover-bg); color: var(--text-muted); cursor: not-allowed; }

        select.form-input {
            appearance: none; -webkit-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
            background-repeat: no-repeat; background-position: right 10px center; padding-right: 30px; cursor: pointer;
        }
        select.form-input option { background: var(--bg-panel); color: var(--text-body); }

        .form-label { color: var(--text-muted); font-size: 11px; font-weight: 500; margin-bottom: 4px; display: block; }
        .form-group { margin-bottom: 1rem; width: 100%; }

        .btn-primary { background-color: #1d4ed8; color: #fff; padding: 8px 20px; border-radius: 0.25rem; border: none; font-size: 12px; font-weight: 500; cursor: pointer; }
        .btn-primary:hover { background-color: #2563eb; }
        .btn-primary:disabled { opacity: 0.6; cursor: not-allowed; }

        .btn-secondary { background-color: var(--btn-secondary-bg); color: var(--btn-secondary-text); padding: 8px 20px; border-radius: 0.25rem; border: none; font-size: 12px; font-weight: 500; cursor: pointer; }
        .btn-secondary:hover { background-color: var(--btn-secondary-hover-bg); color: var(--btn-secondary-hover-text); }

        .btn-success { background-color: #10b981; color: #fff; padding: 8px 20px; border-radius: 0.25rem; border: none; font-size: 12px; font-weight: 500; cursor: pointer; }
        .btn-success:hover { background-color: #059669; }
        .btn-danger { background-color: #ef4444; color: #fff; padding: 8px 20px; border-radius: 0.25rem; border: none; font-size: 12px; font-weight: 500; cursor: pointer; }
        .btn-danger:hover { background-color: #dc2626; }
        .btn-success:disabled, .btn-danger:disabled { opacity: 0.6; cursor: not-allowed; }

        .btn-action {
            display: inline-flex; align-items: center; justify-content: center; gap: 4px; padding: 4px 10px;
            font-size: 10px; font-weight: 500; border-radius: 4px; border: 1px solid transparent; cursor: pointer; font-family: 'Inter', sans-serif;
        }
        .btn-edit { background: rgba(29, 78, 216, .1); color: #1d4ed8; border-color: rgba(29, 78, 216, .25); }
        .btn-edit:hover { background: #1d4ed8; color: #fff; }

        .btn-delete { background: rgba(239, 68, 68, .1); color: #ef4444; border-color: rgba(239, 68, 68, .25); }
        .btn-delete:hover { background: #ef4444; color: #fff; }
        .btn-delete:disabled { opacity: 0.4; cursor: not-allowed; background: rgba(148, 163, 184, .1); color: #94a3b8; border-color: rgba(148, 163, 184, .25); }

        .table-container { position: relative; overflow-x: auto; min-height: 120px; }
        .table-container table { width: 100% !important; border-collapse: collapse; font-size: 11px; }
        .table-container table thead th {
            background-color: var(--table-head-bg) !important; color: var(--table-head-text) !important; font-weight: 500;
            text-align: left; padding: 10px 12px; border-bottom: 1px solid var(--border-color); white-space: nowrap;
            font-size: 10px; text-transform: uppercase; letter-spacing: .5px;
        }
        .table-container table tbody td { padding: 10px 12px; border-bottom: 1px solid var(--border-color); color: var(--table-row-text); vertical-align: middle; }
        .table-container table tbody tr:hover { background-color: var(--table-row-hover); }

        .table-loading-overlay {
            position: absolute; inset: 0; background-color: var(--bg-panel); display: flex; align-items: center;
            justify-content: center; gap: 8px; font-size: 12px; color: var(--text-muted); z-index: 5;
        }
        .table-loading-overlay.hidden { display: none; }

        .dataTables_wrapper .dataTables_filter, .dataTables_wrapper .dataTables_length { display: none !important; }
        .dataTables_wrapper .dataTables_info { color: var(--text-muted) !important; font-size: 11px !important; padding-top: 12px !important; }
        .dataTables_wrapper .dataTables_paginate { padding-top: 12px !important; }
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 4px 10px !important; margin: 0 2px !important; border-radius: 4px !important;
            background: var(--toolbar-btn-bg) !important; border: 1px solid var(--border-color) !important;
            color: var(--text-muted) !important; font-size: 11px !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current { background: #1d4ed8 !important; color: #fff !important; border-color: #1d4ed8 !important; }

        .dt-buttons { display: flex !important; gap: 6px !important; flex-wrap: wrap !important; }
        .dt-buttons .dt-button {
            padding: 6px 12px !important; background-color: var(--toolbar-btn-bg) !important; border: 1px solid var(--border-color) !important;
            border-radius: .25rem !important; color: var(--text-muted) !important; font-size: 10px !important; cursor: pointer !important;
            display: inline-flex !important; align-items: center !important; gap: 4px !important; height: 30px !important; box-sizing: border-box !important;
        }
        .dt-buttons .dt-button:hover { background-color: var(--hover-bg) !important; color: var(--text-heading) !important; }

        .toolbar-row { display: flex; align-items: center; justify-content: space-between; gap: 10px; flex-wrap: nowrap; width: 100%; }
        .toolbar-left { display: flex; align-items: center; gap: 6px; flex-wrap: wrap; min-width: 0; }
        .toolbar-right { display: flex; align-items: center; gap: 8px; flex-shrink: 0; }

        .offcanvas {
            position: fixed; top: 0; bottom: 0; width: 480px; max-width: 90vw; max-height: 100vh; display: flex; flex-direction: column;
            background-color: var(--bg-panel); box-shadow: -10px 0 30px rgba(0, 0, 0, .25); transform: translateX(100%);
            transition: transform .3s ease-in-out; visibility: hidden; z-index: 99999;
        }
        .offcanvas.offcanvas-end { right: 0; border-left: 1px solid var(--border-color); }
        .offcanvas.showing, .offcanvas.show { transform: translateX(0); visibility: visible; }
        .offcanvas-backdrop { position: fixed; inset: 0; background-color: var(--modal-overlay); opacity: 0; transition: opacity .15s linear; z-index: 99998; }
        .offcanvas-backdrop.show { opacity: 1; }
        .offcanvas-header { display: flex; align-items: center; justify-content: space-between; padding: 16px 20px; flex-shrink: 0; border-bottom: 1px solid var(--border-color); }
        .offcanvas-title { margin: 0; }
        .offcanvas-body { flex: 1 1 auto; padding: 20px; overflow-y: auto; }

        .btn-close { width: 26px; height: 26px; border: none; background: transparent; color: var(--text-muted); cursor: pointer; display: inline-flex; align-items: center; justify-content: center; border-radius: 4px; padding: 0; }
        .btn-close::before { content: "\00d7"; font-size: 20px; line-height: 1; }

        .toast {
            position: fixed; bottom: 30px; right: 30px; background: var(--bg-panel); border: 1px solid var(--border-color);
            border-radius: .375rem; padding: 12px 20px; color: var(--text-body); font-size: 12px; z-index: 9999;
            transform: translateY(100px); opacity: 0; transition: all .3s ease-in-out; box-shadow: 0 10px 30px rgba(0, 0, 0, .25);
        }
        .toast.show { transform: translateY(0); opacity: 1; }
        .toast.success { border-color: #10b981; } .toast.success i { color: #10b981; }
        .toast.error { border-color: #ef4444; } .toast.error i { color: #ef4444; }

        .status-badge { display: inline-flex; align-items: center; gap: 5px; padding: 3px 9px; border-radius: 12px; font-size: 10px; font-weight: 600; }
        .status-pending { background: rgba(234, 179, 8, .15); color: #eab308; border: 1px solid rgba(234, 179, 8, .3); }
        .status-approved { background: rgba(16, 185, 129, .12); color: #10b981; border: 1px solid rgba(16, 185, 129, .25); }
        .status-rejected { background: rgba(239, 68, 68, .12); color: #ef4444; border: 1px solid rgba(239, 68, 68, .25); }
        .status-dot { width: 6px; height: 6px; border-radius: 50%; background: currentColor; }

        .warn-badge { background: rgba(239, 68, 68, .12); color: #ef4444; padding: 2px 8px; border-radius: 4px; font-size: 9px; font-weight: 600; display: inline-block; margin-top: 3px; }

        .cust-name { font-weight: 600; color: var(--text-heading); }
        .cust-id { font-size: 9px; color: var(--text-muted); margin-top: 2px; }
        .mono { font-family: monospace; font-size: 11px; }

        .detail-box { background: var(--hover-bg); border: 1px solid var(--border-color); border-radius: .375rem; padding: 12px; margin-bottom: 14px; }
        .detail-row { display: flex; justify-content: space-between; gap: 12px; padding: 5px 0; font-size: 11px; border-bottom: 1px dashed var(--border-color); }
        .detail-row:last-child { border-bottom: none; }
        .detail-row .k { color: var(--text-muted); flex-shrink: 0; }
        .detail-row .v { color: var(--text-heading); font-weight: 500; text-align: right; word-break: break-word; }

        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: var(--scrollbar-track); }
        ::-webkit-scrollbar-thumb { background: var(--scrollbar-thumb); border-radius: 4px; }

        .hidden { display: none !important; }
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
                        <i class="fa-solid fa-mobile-screen-button mr-2 text-blue-500"></i>Device Change Requests
                    </h2>
                    <p class="text-[10px] text-gray-500">Verify customer identity by call, then approve or reject</p>
                </div>
            </div>

            <div class="panel-card p-3 mb-4">
                <div class="toolbar-row">
                    <div class="toolbar-left" id="exportButtonsContainer"></div>
                    <div class="toolbar-right">
                        <select id="filterStatus" class="form-input text-xs"
                            style="height:30px;padding:4px 30px 4px 10px;width:130px;">
                            <option value="pending" selected>Pending</option>
                            <option value="approved">Approved</option>
                            <option value="rejected">Rejected</option>
                            <option value="">All</option>
                        </select>
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-magnifying-glass text-gray-500 text-xs"></i>
                            <input type="text" id="customSearchInput" placeholder="Search" class="form-input text-xs"
                                style="height:30px;padding:4px 10px;width:180px;">
                        </div>
                        <button type="button" onclick="loadRequests()" class="btn-secondary flex items-center gap-2"
                            style="height:30px;padding:4px 12px;">
                            <i class="fa-solid fa-rotate"></i> Refresh
                        </button>
                    </div>
                </div>
            </div>

            <div class="panel-card overflow-hidden">
                <div class="table-container">
                    <div class="table-loading-overlay" id="tableLoadingOverlay">
                        <i class="fa-solid fa-spinner fa-spin text-blue-400"></i> Loading requests...
                    </div>
                    <table id="requestTable" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Customer</th>
                                <th>Mobile</th>
                                <th>Reason</th>
                                <th>Old IMEI</th>
                                <th>New IMEI</th>
                                <th>Contact</th>
                                <th>Requested</th>
                                <th>Status</th>
                                <th style="width:150px;">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>

    <div id="toast" class="toast">
        <i class="fa-solid fa-check-circle mr-2"></i>
        <span id="toastMessage">Data loaded successfully!</span>
    </div>

    <!-- Review Offcanvas -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRequest">
        <div class="offcanvas-header">
            <h5 class="text-heading text-sm font-semibold offcanvas-title">
                <i class="fa-solid fa-clipboard-check mr-2 text-blue-500"></i>Review Request
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <input type="hidden" id="r_id" value="">

            <div class="detail-box" id="detailCustomer"></div>
            <div class="detail-box" id="detailRequest"></div>

            <div id="processSection">
                <div class="form-group">
                    <label class="form-label">Admin Note <span id="noteReq" class="text-red-500">(required for reject)</span></label>
                    <textarea class="form-input" id="r_note" rows="3" maxlength="255"
                        placeholder="e.g. Verified by phone call"></textarea>
                </div>
                <div class="flex gap-3 mt-4">
                    <button type="button" class="btn-success flex-1" id="btnApprove" onclick="processRequest('approve')">
                        <i class="fa-solid fa-check mr-1"></i> Approve
                    </button>
                    <button type="button" class="btn-danger flex-1" id="btnReject" onclick="processRequest('reject')">
                        <i class="fa-solid fa-xmark mr-1"></i> Reject
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

    <script>
        // ============================================
        // CONFIG
        // ============================================
        const API_BASE = 'http://localhost:8080/hascol_customer/api/device-change/';

        let dataTable = null;
        window.requestStore = {};

        const exportButtons = [
            { extend: 'copy', text: '<i class="fa-regular fa-copy"></i> Copy', className: 'dt-button' },
            { extend: 'excelHtml5', text: '<i class="fa-regular fa-file-excel"></i> Excel', className: 'dt-button', title: 'Device_Requests' },
            { extend: 'csvHtml5', text: '<i class="fa-regular fa-file-csv"></i> CSV', className: 'dt-button', title: 'Device_Requests' },
            { extend: 'pdfHtml5', text: '<i class="fa-regular fa-file-pdf"></i> PDF', className: 'dt-button', orientation: 'landscape', pageSize: 'A4', title: 'Device Requests' },
            { extend: 'print', text: '<i class="fa-solid fa-print"></i> Print', className: 'dt-button' }
        ];

        // ============================================
        // INIT
        // ============================================
        $(document).ready(function () {
            dataTable = $('#requestTable').DataTable({
                dom: 'Bfrtip',
                buttons: exportButtons,
                pageLength: 10,
                order: [],
                columnDefs: [{ orderable: false, targets: '_all' }],
                language: {
                    emptyTable: 'No requests found',
                    info: 'Showing _START_ to _END_ of _TOTAL_',
                    infoEmpty: '0 entries',
                    infoFiltered: '(filtered from _MAX_)'
                },
                initComplete: function () {
                    this.api().buttons().container().appendTo('#exportButtonsContainer');
                }
            });

            $('#customSearchInput').on('keyup', function () {
                dataTable.search(this.value).draw();
            });

            $('#filterStatus').on('change', loadRequests);

            loadRequests();
        });

        // ============================================
        // HELPERS
        // ============================================
        function escapeHtml(text) {
            if (text === null || text === undefined) return '';
            return String(text).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
        }
        function showToast(message, type = 'success') {
            const toast = $('#toast');
            toast.removeClass('success error').addClass(type);
            $('#toastMessage').text(message);
            toast.addClass('show');
            clearTimeout(window._toastT);
            window._toastT = setTimeout(() => toast.removeClass('show'), 3000);
        }
        function formatDate(dt) {
            if (!dt) return '—';
            const d = new Date(dt.replace(' ', 'T'));
            if (isNaN(d.getTime())) return dt;
            return d.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' }) + ' ' +
                d.toLocaleTimeString('en-GB', { hour: '2-digit', minute: '2-digit' });
        }
        function statusBadge(st) {
            st = (st || '').toLowerCase();
            const label = st.charAt(0).toUpperCase() + st.slice(1);
            return '<span class="status-badge status-' + escapeHtml(st) + '"><span class="status-dot"></span>' + escapeHtml(label) + '</span>';
        }
        function detailRow(k, v) {
            return '<div class="detail-row"><span class="k">' + k + '</span><span class="v">' + (v ? escapeHtml(v) : '—') + '</span></div>';
        }

        // ============================================
        // LOAD
        // ============================================
        function loadRequests() {
            const payload = { status: $('#filterStatus').val() || '' };
            $('#tableLoadingOverlay').removeClass('hidden');

            $.ajax({
                url: API_BASE + 'get-device-requests.php',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(payload),
                dataType: 'json',

                success: function (res) {
                    dataTable.clear();
                    window.requestStore = {};

                    const list = (res && Array.isArray(res.data)) ? res.data : [];

                    if (res && res.status === 'success' && list.length > 0) {
                        $.each(list, function (i, r) {
                            window.requestStore[r.id] = r;

                            let customerCell =
                                '<div class="cust-name">' + escapeHtml(r.name || '-') + '</div>' +
                                '<div class="cust-id">Req #' + r.id + ' · Cust #' + r.customer_id + '</div>';
                            if (parseInt(r.imei_in_use) > 0) {
                                customerCell += '<span class="warn-badge"><i class="fa-solid fa-triangle-exclamation"></i> New IMEI used by another account</span>';
                            }

                            const btnLabel = r.status === 'pending'
                                ? '<i class="fa-solid fa-clipboard-check"></i> Review'
                                : '<i class="fa-solid fa-eye"></i> View';

                            const action =
                                '<div style="display:flex;gap:4px;align-items:center;">' +
                                    '<button class="btn-action btn-edit" onclick="openReview(' + r.id + ')" title="Review / View">' + btnLabel + '</button>' +
                                    '<button class="btn-action btn-delete" onclick="deleteRequest(' + r.id + ')" title="Delete request">' +
                                        '<i class="fa-solid fa-trash"></i>' +
                                    '</button>' +
                                '</div>';

                            dataTable.row.add([
                                i + 1,
                                customerCell,
                                escapeHtml(r.mobile || '-'),
                                escapeHtml(r.reason || '-'),
                                '<span class="mono">' + escapeHtml(r.old_imei || '-') + '</span>',
                                '<span class="mono">' + escapeHtml(r.new_imei || '-') + '</span>',
                                escapeHtml(r.contact || '-'),
                                formatDate(r.created_at),
                                statusBadge(r.status),
                                action
                            ]);
                        });
                        showToast('Loaded ' + list.length + ' requests', 'success');
                    } else if (res && res.status !== 'success') {
                        showToast(res.message || 'Failed to load', 'error');
                    } else {
                        showToast('No requests found', 'error');
                    }

                    dataTable.draw();
                    $('#tableLoadingOverlay').addClass('hidden');
                },

                error: function (xhr) {
                    console.error('AJAX ERROR:', xhr.status, xhr.responseText);
                    dataTable.clear().draw();
                    $('#tableLoadingOverlay').addClass('hidden');
                    showToast('API Error: ' + xhr.status, 'error');
                }
            });
        }

        // ============================================
        // REVIEW
        // ============================================
        function openReview(id) {
            const r = window.requestStore[id]; if (!r) return;

            $('#r_id').val(r.id);
            $('#r_note').val(r.admin_note || '');

            $('#detailCustomer').html(
                '<div class="text-heading font-semibold mb-2" style="font-size:12px;"><i class="fa-solid fa-user mr-1 text-blue-500"></i>Customer (for verification call)</div>' +
                detailRow('Name', r.name) +
                detailRow('Mobile', r.mobile) +
                detailRow('CNIC', r.cnic) +
                detailRow('Address', r.address) +
                detailRow('Coupon No', r.coupon_no) +
                detailRow('Account Status', r.customer_status)
            );

            let warn = '';
            if (parseInt(r.imei_in_use) > 0) {
                warn = '<div class="warn-badge" style="display:block;margin-bottom:8px;padding:6px 8px;">' +
                    '<i class="fa-solid fa-triangle-exclamation"></i> New IMEI is already registered on another customer account.</div>';
            }

            $('#detailRequest').html(
                '<div class="text-heading font-semibold mb-2" style="font-size:12px;"><i class="fa-solid fa-mobile-screen-button mr-1 text-blue-500"></i>Request #' + r.id + '</div>' +
                warn +
                detailRow('Reason', r.reason) +
                detailRow('Contact', r.contact) +
                detailRow('Current IMEI', r.current_imei) +
                detailRow('Old IMEI (at request)', r.old_imei) +
                detailRow('New IMEI', r.new_imei) +
                detailRow('Requested', formatDate(r.created_at)) +
                detailRow('Status', r.status) +
                (r.processed_at ? detailRow('Processed', formatDate(r.processed_at)) : '')
            );

            const isPending = r.status === 'pending';
            $('#processSection').toggleClass('hidden', !isPending);
            if (!isPending) {
                $('#detailRequest').append(detailRow('Admin Note', r.admin_note));
            }

            bootstrap.Offcanvas.getOrCreateInstance(document.getElementById('offcanvasRequest')).show();
        }

        // ============================================
        // APPROVE / REJECT
        // ============================================
        function processRequest(action, force) {
            const id = parseInt($('#r_id').val());
            const note = ($('#r_note').val() || '').trim();

            if (action === 'reject' && !note) {
                Swal.fire({ icon: 'warning', title: 'Validation', text: 'Note is required when rejecting', confirmButtonColor: '#1d4ed8' });
                $('#r_note').focus();
                return;
            }

            const doCall = function () {
                $('#btnApprove, #btnReject').prop('disabled', true);

                $.ajax({
                    url: API_BASE + 'process-device-request.php',
                    method: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({ request_id: id, action: action, note: note, force: force ? 1 : 0 }),
                    dataType: 'json',
                    success: function (res) {
                        $('#btnApprove, #btnReject').prop('disabled', false);

                        if (res && res.status === 'success') {
                            bootstrap.Offcanvas.getInstance(document.getElementById('offcanvasRequest')).hide();
                            Swal.fire({ icon: 'success', title: action === 'approve' ? 'Approved!' : 'Rejected!', text: res.message, confirmButtonColor: '#1d4ed8' });
                            loadRequests();
                        } else if (res && res.error_code === 'IMEI_IN_USE') {
                            Swal.fire({
                                icon: 'warning',
                                title: 'IMEI already in use',
                                text: res.message + ' Approve anyway?',
                                showCancelButton: true,
                                confirmButtonColor: '#10b981',
                                cancelButtonColor: '#64748b',
                                confirmButtonText: 'Yes, approve anyway',
                                reverseButtons: true
                            }).then(r => { if (r.isConfirmed) processRequest('approve', true); });
                        } else {
                            Swal.fire({ icon: 'error', title: 'Error', text: (res && res.message) || 'Failed', confirmButtonColor: '#1d4ed8' });
                        }
                    },
                    error: function (xhr) {
                        console.error('Process error:', xhr.status, xhr.responseText);
                        $('#btnApprove, #btnReject').prop('disabled', false);
                        Swal.fire({ icon: 'error', title: 'Server Error', text: 'Request failed', confirmButtonColor: '#1d4ed8' });
                    }
                });
            };

            if (force) { doCall(); return; }

            Swal.fire({
                icon: action === 'approve' ? 'question' : 'warning',
                title: action === 'approve' ? 'Approve request?' : 'Reject request?',
                html: action === 'approve'
                    ? 'Customer ki IMEI new device par set hogi aur purane sessions band ho jayenge.<br><small style="color:#94a3b8;">Pehle identity verify kar len.</small>'
                    : 'Request reject ho jayegi. Customer ki IMEI wahi rahegi.',
                showCancelButton: true,
                confirmButtonColor: action === 'approve' ? '#10b981' : '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: action === 'approve' ? 'Yes, Approve' : 'Yes, Reject',
                reverseButtons: true
            }).then(r => { if (r.isConfirmed) doCall(); });
        }

        // ============================================
        // DELETE REQUEST
        // ============================================
        function deleteRequest(id) {
            const r = window.requestStore[id];
            if (!r) {
                Swal.fire({
                    icon: 'error',
                    title: 'Not Found',
                    text: 'Request data not found.',
                    confirmButtonColor: '#1d4ed8'
                });
                return;
            }

            // Warning message based on status
            let extraInfo = '';
            if (r.status === 'pending') {
                extraInfo = '<br><small style="color:#eab308;">This is a pending request. Customer\'s device lock has NOT been changed yet.</small>';
            } else if (r.status === 'approved') {
                extraInfo = '<br><small style="color:#ef4444;"><b>Warning:</b> This request was approved. Deleting it will remove the audit record, but the customer\'s IMEI will remain changed.</small>';
            } else {
                extraInfo = '<br><small style="color:#94a3b8;">This request was ' + escapeHtml(r.status) + '.</small>';
            }

            Swal.fire({
                icon: 'warning',
                title: 'Delete this request?',
                html:
                    '<div style="font-size:12px;text-align:left;">' +
                    '<b>Request #' + r.id + '</b> — ' + escapeHtml(r.name || 'Customer #' + r.customer_id) + '<br>' +
                    'New IMEI: <span style="font-family:monospace;">' + escapeHtml(r.new_imei || '—') + '</span>' +
                    extraInfo +
                    '<br><br>This action <b>cannot be undone</b>.' +
                    '</div>',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Yes, Delete',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    performDelete(id);
                }
            });
        }

        function performDelete(id) {
            $.ajax({
                url: API_BASE + 'delete-request.php',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({ id: id }),
                dataType: 'json',
                success: function (res) {
                    if (res && res.status === 'success') {
                        // Close offcanvas if open on this request
                        const currentId = parseInt($('#r_id').val());
                        if (currentId === id) {
                            const oc = bootstrap.Offcanvas.getInstance(document.getElementById('offcanvasRequest'));
                            if (oc) oc.hide();
                        }

                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: res.message || 'Request deleted successfully.',
                            confirmButtonColor: '#1d4ed8',
                            timer: 1800,
                            showConfirmButton: true
                        }).then(() => {
                            loadRequests();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: (res && res.message) || 'Failed to delete request.',
                            confirmButtonColor: '#1d4ed8'
                        });
                    }
                },
                error: function (xhr) {
                    console.error('Delete error:', xhr.status, xhr.responseText);
                    let errMsg = 'Failed to reach the server.';
                    try {
                        const parsed = JSON.parse(xhr.responseText);
                        if (parsed && parsed.message) errMsg = parsed.message;
                    } catch (_) {}
                    Swal.fire({
                        icon: 'error',
                        title: 'Server Error',
                        text: errMsg,
                        confirmButtonColor: '#1d4ed8'
                    });
                }
            });
        }
    </script>

</body>

</html>