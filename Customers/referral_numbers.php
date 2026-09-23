<?php
// Hascol Customer - Referral Numbers Management
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Referral Numbers | Hascol Customer</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

    <!-- Select2 for searchable dropdown -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        (function() {
            const isDarkMode = localStorage.getItem('darkMode') === 'true';
            if (isDarkMode) document.documentElement.classList.add('dark-mode');
        })();
    </script>

    <script>
        tailwind.config = {
            theme: { extend: { fontFamily: { sans: ['Inter','sans-serif'] } } }
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
            --modal-overlay: rgba(6,11,19,.85);
            --btn-secondary-bg: #1a2635;
            --btn-secondary-text: #94a3b8;
            --btn-secondary-hover-bg: #1f2a3d;
            --btn-secondary-hover-text: #ffffff;
            --toolbar-btn-bg: #060b13;
        }

        body { background-color: var(--bg-body); color: var(--text-muted); font-family: 'Inter', sans-serif; }
        .text-heading { color: var(--text-heading) !important; }

        .panel-card {
            background-color: var(--bg-panel);
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
        }

        .form-input {
            background-color: var(--input-bg);
            border: 1px solid var(--border-color);
            border-radius: 0.25rem;
            color: var(--text-body);
            padding: 6px 10px;
            width: 100%;
            font-size: 12px;
            box-sizing: border-box;
            transition: border-color .15s, box-shadow .15s;
        }
        .form-input:focus {
            outline: none;
            border-color: #1d4ed8;
            box-shadow: 0 0 0 2px rgba(29,78,216,.2);
        }
        .form-input::placeholder { color: var(--text-muted); }

        select.form-input {
            appearance: none;
            -webkit-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 10px center;
            padding-right: 30px;
            cursor: pointer;
        }
        select.form-input option { background: var(--bg-panel); color: var(--text-body); }

        .form-label {
            color: var(--text-muted);
            font-size: 11px;
            font-weight: 500;
            margin-bottom: 4px;
            display: block;
        }

        .btn-secondary {
            background-color: var(--btn-secondary-bg); color: var(--btn-secondary-text);
            padding: 8px 20px; border-radius: 0.25rem; border: none;
            font-size: 12px; font-weight: 500; cursor: pointer;
            display: inline-flex; align-items: center; gap: 6px;
            transition: all .15s;
        }
        .btn-secondary:hover {
            background-color: var(--btn-secondary-hover-bg);
            color: var(--btn-secondary-hover-text);
        }

        .btn-primary {
            background-color: #1d4ed8; color: #fff;
            padding: 8px 20px; border-radius: 0.25rem; border: none;
            font-size: 12px; font-weight: 500; cursor: pointer;
            display: inline-flex; align-items: center; gap: 6px;
            transition: background-color .15s;
        }
        .btn-primary:hover { background-color: #2563eb; }

        .btn-action {
            display: inline-flex; align-items: center; justify-content: center;
            gap: 4px; padding: 4px 10px; font-size: 10px; font-weight: 500;
            border-radius: 4px; border: 1px solid transparent; cursor: pointer;
            font-family: 'Inter', sans-serif;
        }
        .btn-delete {
            background: rgba(239,68,68,.1); color: #ef4444;
            border-color: rgba(239,68,68,.25);
        }
        .btn-delete:hover { background: #ef4444; color: #fff; }
        .btn-delete:disabled {
            opacity: 0.4;
            cursor: not-allowed;
            background: rgba(148,163,184,.1);
            color: #94a3b8;
            border-color: rgba(148,163,184,.25);
        }

        .table-container { position: relative; overflow-x: auto; min-height: 120px; }
        .table-container table {
            width: 100% !important; border-collapse: collapse; font-size: 11px;
        }
        .table-container table thead th {
            background-color: var(--table-head-bg) !important;
            color: var(--table-head-text) !important;
            font-weight: 500; text-align: left; padding: 10px 12px;
            border-bottom: 1px solid var(--border-color);
            white-space: nowrap; font-size: 10px;
            text-transform: uppercase; letter-spacing: .5px;
        }
        .table-container table tbody td {
            padding: 10px 12px; border-bottom: 1px solid var(--border-color);
            color: var(--table-row-text); vertical-align: middle;
        }
        .table-container table tbody tr:hover { background-color: var(--table-row-hover); }

        .table-loading-overlay {
            position: absolute; inset: 0; background-color: var(--bg-panel);
            display: flex; align-items: center; justify-content: center;
            gap: 8px; font-size: 12px; color: var(--text-muted); z-index: 5;
        }
        .table-loading-overlay.hidden { display: none; }

        /* DataTables wrapper */
        .dataTables_wrapper .dt-buttons {
            display: flex !important;
            gap: 6px !important;
            flex-wrap: wrap !important;
            margin: 0 0 10px 0 !important;
            float: left;
        }
        .dataTables_wrapper .dt-buttons .dt-button {
            padding: 6px 12px !important;
            background-color: var(--toolbar-btn-bg) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: .25rem !important;
            color: var(--text-muted) !important;
            font-size: 10px !important;
            cursor: pointer !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 4px !important;
            height: 30px !important;
            box-sizing: border-box !important;
            font-family: 'Inter', sans-serif !important;
            transition: all .15s !important;
        }
        .dataTables_wrapper .dt-buttons .dt-button:hover {
            background-color: var(--hover-bg) !important;
            color: var(--text-heading) !important;
            box-shadow: none !important;
        }

        .dataTables_wrapper .dataTables_filter {
            float: right;
            margin: 0 0 10px 0 !important;
            display: flex;
            align-items: center;
            gap: 6px;
            position: relative;
        }
        .dataTables_wrapper .dataTables_filter label {
            color: var(--text-muted) !important;
            font-size: 11px !important;
            font-weight: 500 !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 6px !important;
            margin: 0 !important;
            position: relative;
        }
        .dataTables_wrapper .dataTables_filter label::before {
            content: "\f002";
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 11px;
            color: var(--text-muted);
            pointer-events: none;
            z-index: 2;
        }
        .dataTables_wrapper .dataTables_filter input {
            background-color: var(--input-bg) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 0.25rem !important;
            color: var(--text-body) !important;
            padding: 6px 12px 6px 30px !important;
            font-size: 12px !important;
            height: 32px !important;
            width: 220px !important;
            outline: none !important;
            font-family: 'Inter', sans-serif !important;
            margin: 0 !important;
            box-sizing: border-box !important;
            transition: border-color .15s, box-shadow .15s !important;
        }
        .dataTables_wrapper .dataTables_filter input:focus {
            outline: none !important;
            border-color: #1d4ed8 !important;
            box-shadow: 0 0 0 2px rgba(29, 78, 216, 0.2) !important;
        }
        .dataTables_wrapper .dataTables_filter input::placeholder {
            color: var(--text-muted) !important;
            font-size: 11px !important;
        }

        .dataTables_wrapper .dataTables_info {
            color: var(--text-muted) !important;
            font-size: 11px !important;
            padding-top: 12px !important;
            clear: both;
        }
        .dataTables_wrapper .dataTables_paginate {
            padding-top: 12px !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 4px 10px !important;
            margin: 0 2px !important;
            border-radius: 4px !important;
            background: var(--toolbar-btn-bg) !important;
            border: 1px solid var(--border-color) !important;
            color: var(--text-muted) !important;
            font-size: 11px !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #1d4ed8 !important;
            color: #fff !important;
            border-color: #1d4ed8 !important;
        }
        .dataTables_wrapper::after {
            content: "";
            display: table;
            clear: both;
        }

        .table-toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 12px;
            padding: 0 4px;
        }
        .table-toolbar-left {
            display: flex;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
        }
        .table-toolbar-right {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-shrink: 0;
        }

        .toast {
            position: fixed; bottom: 30px; right: 30px;
            background: var(--bg-panel); border: 1px solid var(--border-color);
            border-radius: .375rem; padding: 12px 20px;
            color: var(--text-body); font-size: 12px; z-index: 9999;
            transform: translateY(100px); opacity: 0;
            transition: all .3s ease-in-out;
            box-shadow: 0 10px 30px rgba(0,0,0,.25);
        }
        .toast.show { transform: translateY(0); opacity: 1; }
        .toast.success { border-color: #10b981; }
        .toast.success i { color: #10b981; }
        .toast.error { border-color: #ef4444; }
        .toast.error i { color: #ef4444; }

        /* Status badges */
        .ref-status {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 3px 9px; border-radius: 12px; font-size: 10px; font-weight: 600;
        }
        .ref-used { background: rgba(239,68,68,.12); color: #ef4444; border: 1px solid rgba(239,68,68,.25); }
        .ref-available { background: rgba(16,185,129,.12); color: #10b981; border: 1px solid rgba(16,185,129,.25); }
        .ref-dot { width: 6px; height: 6px; border-radius: 50%; background: currentColor; }

        /* Referral code */
        .ref-code {
            font-family: 'Courier New', monospace;
            font-weight: 700;
            font-size: 12px;
            color: var(--text-heading);
            background: var(--hover-bg);
            padding: 3px 10px;
            border-radius: 4px;
            letter-spacing: 1px;
            display: inline-block;
        }

        /* Customer cell */
        .cell-name { font-weight: 600; color: var(--text-heading); font-size: 11px; }
        .cell-sub { font-size: 9px; color: var(--text-muted); }

        /* Summary cards */
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 10px;
            margin-bottom: 12px;
        }
        .summary-card {
            background: var(--bg-panel);
            border: 1px solid var(--border-color);
            border-radius: 6px;
            padding: 12px 14px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .summary-icon {
            width: 40px; height: 40px;
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 16px; flex-shrink: 0;
        }
        .summary-icon.blue { background: rgba(29,78,216,.12); color: #1d4ed8; }
        .summary-icon.green { background: rgba(16,185,129,.12); color: #10b981; }
        .summary-icon.red { background: rgba(239,68,68,.12); color: #ef4444; }
        .summary-label {
            font-size: 10px; color: var(--text-muted);
            text-transform: uppercase; letter-spacing: .5px; font-weight: 500;
        }
        .summary-value {
            font-size: 16px; font-weight: 700;
            color: var(--text-heading); margin-top: 2px;
        }

        /* ============================================
           Select2 Custom Styling (matches form-input)
           ============================================ */

        /* Container */
        .select2-container--default .select2-selection--single {
            background-color: var(--input-bg) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 0.25rem !important;
            height: 32px !important;
            transition: border-color .15s, box-shadow .15s;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: var(--text-body) !important;
            line-height: 30px !important;
            padding-left: 10px !important;
            padding-right: 30px !important;
            font-size: 12px !important;
            font-family: 'Inter', sans-serif !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: var(--text-muted) !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 30px !important;
            width: 26px !important;
            right: 2px !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            border-color: var(--text-muted) transparent transparent transparent !important;
            border-width: 5px 4px 0 4px !important;
            left: 50% !important;
            margin-left: -4px !important;
            margin-top: -2px !important;
        }

        /* Focus state */
        .select2-container--default.select2-container--focus .select2-selection--single,
        .select2-container--default.select2-container--open .select2-selection--single {
            border-color: #1d4ed8 !important;
            box-shadow: 0 0 0 2px rgba(29, 78, 216, 0.2) !important;
            outline: none !important;
        }

        /* Dropdown */
        .select2-container--default .select2-dropdown {
            background-color: var(--bg-panel) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 0.25rem !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25) !important;
            z-index: 9999 !important;
        }
        .select2-container--default .select2-search--dropdown {
            padding: 6px !important;
        }
        .select2-container--default .select2-search--dropdown .select2-search__field {
            background-color: var(--input-bg) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 0.25rem !important;
            color: var(--text-body) !important;
            padding: 6px 10px !important;
            font-size: 12px !important;
            outline: none !important;
            font-family: 'Inter', sans-serif !important;
            height: 32px !important;
            box-sizing: border-box !important;
        }
        .select2-container--default .select2-search--dropdown .select2-search__field:focus {
            border-color: #1d4ed8 !important;
            box-shadow: 0 0 0 2px rgba(29, 78, 216, 0.2) !important;
        }
        .select2-container--default .select2-search--dropdown .select2-search__field::placeholder {
            color: var(--text-muted) !important;
        }

        /* Results */
        .select2-container--default .select2-results__option {
            font-size: 12px !important;
            color: var(--text-body) !important;
            padding: 6px 10px !important;
        }
        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #1d4ed8 !important;
            color: #ffffff !important;
        }
        .select2-container--default .select2-results__option[aria-selected=true] {
            background-color: var(--hover-bg) !important;
            color: var(--text-heading) !important;
        }
        .select2-results__options {
            max-height: 280px !important;
        }

        /* Scrollbar for dropdown */
        .select2-results__options::-webkit-scrollbar {
            width: 6px;
        }
        .select2-results__options::-webkit-scrollbar-track {
            background: var(--scrollbar-track);
        }
        .select2-results__options::-webkit-scrollbar-thumb {
            background: var(--scrollbar-thumb);
            border-radius: 4px;
        }

        /* Loading message */
        .select2-container--default .select2-results__option.loading-results {
            color: var(--text-muted) !important;
            font-style: italic !important;
        }
        /* No results */
        .select2-container--default .select2-results__message {
            color: var(--text-muted) !important;
            font-size: 12px !important;
            padding: 8px 10px !important;
        }

        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: var(--scrollbar-track); }
        ::-webkit-scrollbar-thumb { background: var(--scrollbar-thumb); border-radius: 4px; }

        .hidden { display: none !important; }

        @media (max-width: 768px) {
            .dataTables_wrapper .dataTables_filter input { width: 160px !important; }
            .dataTables_wrapper .dt-buttons { float: none; margin-bottom: 8px !important; }
            .dataTables_wrapper .dataTables_filter { float: none; justify-content: flex-start; }
        }
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
                        <i class="fa-solid fa-ticket mr-2 text-blue-500"></i>Referral Numbers
                    </h2>
                    <p class="text-[10px] text-gray-500">View referral codes and their usage</p>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="summary-grid">
                <div class="summary-card">
                    <div class="summary-icon blue"><i class="fa-solid fa-list"></i></div>
                    <div>
                        <div class="summary-label">Total Referrals</div>
                        <div class="summary-value" id="sumTotal">0</div>
                    </div>
                </div>
                <div class="summary-card">
                    <div class="summary-icon red"><i class="fa-solid fa-circle-check"></i></div>
                    <div>
                        <div class="summary-label">Used</div>
                        <div class="summary-value" id="sumUsed">0</div>
                    </div>
                </div>
                <div class="summary-card">
                    <div class="summary-icon green"><i class="fa-solid fa-circle-xmark"></i></div>
                    <div>
                        <div class="summary-label">Unused</div>
                        <div class="summary-value" id="sumUnused">0</div>
                    </div>
                </div>
            </div>

            <!-- Filters (Custom Search removed) -->
            <div class="panel-card p-3 mb-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3">
                    <div class="lg:col-span-2">
                        <label class="form-label">Used By Customer</label>
                        <select id="filterCustomer" class="form-input text-xs" style="width:100%;">
                            <option value="">All Customers</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Status</label>
                        <select id="filterUsed" class="form-input text-xs" style="height:32px;">
                            <option value="">All Status</option>
                            <option value="0">Unused</option>
                            <option value="1">Used</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Date From</label>
                        <input type="date" id="filterDateFrom" class="form-input text-xs" style="height:32px;">
                    </div>
                    <div>
                        <label class="form-label">Date To</label>
                        <input type="date" id="filterDateTo" class="form-input text-xs" style="height:32px;">
                    </div>
                    <div class="lg:col-span-4" style="display:flex;gap:8px;align-items:flex-end;justify-content:flex-end;">
                        <button type="button" onclick="loadReferrals()" class="btn-primary flex items-center gap-2" style="height:32px;padding:0 16px;">
                            <i class="fa-solid fa-filter"></i> Apply
                        </button>
                        <button type="button" onclick="resetFilters()" class="btn-secondary flex items-center gap-2" style="height:32px;padding:0 14px;" title="Reset all filters">
                            <i class="fa-solid fa-rotate-left"></i> Reset
                        </button>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="panel-card overflow-hidden p-3">
                <div class="table-toolbar">
                    <div class="table-toolbar-left" id="exportButtonsContainer"></div>
                    <div class="table-toolbar-right" id="searchContainer"></div>
                </div>

                <div class="table-container">
                    <div class="table-loading-overlay" id="tableLoadingOverlay">
                        <i class="fa-solid fa-spinner fa-spin text-blue-400"></i> Loading referral numbers...
                    </div>
                    <table id="refTable" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Referral No</th>
                                <th>Status</th>
                                <th>Used By</th>
                                <th>Used At</th>
                                <th>Created</th>
                                <th style="width:70px;">Action</th>
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
        const API_BASE = 'https://hascol.allowance.flamboyant-spence.92-205-119-218.plesk.page/api/referrals-no-list/';

        let dataTable = null;
        window.refStore = {};

        const exportButtons = [
            { extend: 'copy', text: '<i class="fa-regular fa-copy"></i> Copy', className: 'dt-button' },
            { extend: 'excelHtml5', text: '<i class="fa-regular fa-file-excel"></i> Excel', className: 'dt-button', title: 'Referral_Numbers_Export' },
            { extend: 'csvHtml5', text: '<i class="fa-regular fa-file-csv"></i> CSV', className: 'dt-button', title: 'Referral_Numbers_Export' },
            { extend: 'pdfHtml5', text: '<i class="fa-regular fa-file-pdf"></i> PDF', className: 'dt-button', orientation: 'landscape', pageSize: 'A4', title: 'Referral Numbers' },
            { extend: 'print', text: '<i class="fa-solid fa-print"></i> Print', className: 'dt-button' }
        ];

        // ============================================
        // INIT
        // ============================================
        $(document).ready(function() {
            // ─── Initialize Select2 on Customer dropdown ───
            initCustomerSelect2();

            dataTable = $('#refTable').DataTable({
                dom: 'Bfrtip',
                buttons: exportButtons,
                pageLength: 10,
                order: [],
                columnDefs: [{ orderable: false, targets: '_all' }],
                language: {
                    emptyTable: 'No referral numbers found',
                    info: 'Showing _START_ to _END_ of _TOTAL_',
                    infoEmpty: '0 entries',
                    infoFiltered: '(filtered from _MAX_)',
                    search: '',
                    searchPlaceholder: 'Search in table...'
                },
                initComplete: function () {
                    this.api().buttons().container().appendTo('#exportButtonsContainer');
                    const searchBox = $('#refTable_wrapper .dataTables_filter');
                    searchBox.appendTo('#searchContainer');
                }
            });

            // Filters auto-apply
            $('#filterUsed').on('change', function() { loadReferrals(); });

            // ─── Customer dropdown change → auto apply ───
            // (Use jQuery .on — Select2 triggers 'change' event on this)
            $('#filterCustomer').on('change', function() {
                loadReferrals();
            });

            // Initial loads
            loadCustomersForFilter();
            loadReferrals();
        });

        // ============================================
        // INITIALIZE SELECT2 ON CUSTOMER DROPDOWN
        // ============================================
        function initCustomerSelect2() {
            $('#filterCustomer').select2({
                placeholder: 'All Customers',
                allowClear: true,
                width: '100%',
                dropdownParent: $('body'), // prevent overflow issues
                language: {
                    noResults: function() {
                        return 'No customers found';
                    },
                    searching: function() {
                        return 'Searching...';
                    },
                    inputTooShort: function() {
                        return 'Type to search customers...';
                    }
                },
                minimumResultsForSearch: 0 // always show search box
            });
        }

        // ============================================
        // HELPERS
        // ============================================
        function escapeHtml(text) {
            if (text === null || text === undefined) return '';
            return String(text).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;').replace(/'/g,'&#039;');
        }
        function showToast(message, type = 'success') {
            const toast = $('#toast');
            toast.removeClass('success error').addClass(type);
            $('#toastMessage').text(message);
            toast.addClass('show');
            clearTimeout(window._toastT);
            window._toastT = setTimeout(() => toast.removeClass('show'), 3000);
        }
        function formatDate(dt, withTime) {
            if (!dt) return '—';
            const d = new Date(dt.replace(' ', 'T'));
            if (isNaN(d.getTime())) return dt;
            const dateStr = d.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
            if (withTime) {
                const timeStr = d.toLocaleTimeString('en-GB', { hour: '2-digit', minute: '2-digit' });
                return dateStr + ' ' + timeStr;
            }
            return dateStr;
        }

        // ============================================
        // LOAD FILTER DROPDOWN
        // ============================================
        function loadCustomersForFilter() {
            $.ajax({
                url: API_BASE + 'get-referral-customers.php',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({}),
                dataType: 'json',
                success: function(res) {
                    const sel = $('#filterCustomer');
                    // Clear existing options (except placeholder)
                    sel.find('option').remove();
                    sel.append('<option value="">All Customers</option>');
                    if (res && res.customers && res.customers.length) {
                        res.customers.forEach(c => {
                            const label = c.name + (c.mobile ? ' — ' + c.mobile : '');
                            sel.append('<option value="' + c.id + '">' + escapeHtml(label) + '</option>');
                        });
                    }
                    // Re-init Select2 with new options (keeps search working)
                    initCustomerSelect2();
                },
                error: function() { console.warn('Failed to load customers for filter'); }
            });
        }

        // ============================================
        // RESET FILTERS
        // ============================================
        function resetFilters() {
            $('#filterCustomer').val('').trigger('change.select2'); // reset select2
            $('#filterUsed').val('');
            $('#filterDateFrom').val('');
            $('#filterDateTo').val('');

            dataTable.search('').draw();
            dataTable.page(0).draw(false);

            loadReferrals();
            showToast('Filters reset — showing all referrals', 'success');
        }

        // ============================================
        // LOAD REFERRALS
        // ============================================
        function loadReferrals() {
            const payload = {};
            const customer_id = $('#filterCustomer').val();
            const is_used = $('#filterUsed').val();
            const dateFrom = $('#filterDateFrom').val();
            const dateTo = $('#filterDateTo').val();

            if (customer_id) payload.customer_id = parseInt(customer_id);
            if (is_used !== '') payload.is_used = parseInt(is_used);
            if (dateFrom) payload.date_from = dateFrom;
            if (dateTo) payload.date_to = dateTo;

            $('#tableLoadingOverlay').removeClass('hidden');

            $.ajax({
                url: API_BASE + 'get-referrals.php',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(payload),
                dataType: 'json',
                success: function(res) {
                    console.log('Referrals Response:', res);
                    dataTable.clear().draw();
                    window.refStore = {};

                    if (res && res.status === 'success') {
                        $('#sumTotal').text(res.total || 0);
                        $('#sumUsed').text(res.total_used || 0);
                        $('#sumUnused').text(res.total_unused || 0);

                        if (Array.isArray(res.referrals) && res.referrals.length) {
                            $.each(res.referrals, function(i, r) {
                                window.refStore[r.id] = r;

                                const refCode = '<span class="ref-code">' + escapeHtml(r.referral_no) + '</span>';

                                const statusHtml = r.is_used === 1
                                    ? '<span class="ref-status ref-used"><span class="ref-dot"></span>Used</span>'
                                    : '<span class="ref-status ref-available"><span class="ref-dot"></span>Available</span>';

                                let usedByCell = '<span style="color:var(--text-muted);">—</span>';
                                if (r.is_used === 1 && r.used_by_name) {
                                    usedByCell = '<div>' +
                                        '<div class="cell-name">' + escapeHtml(r.used_by_name) + '</div>' +
                                        '<div class="cell-sub">' + escapeHtml(r.used_by_mobile || '—') + '</div>' +
                                    '</div>';
                                }

                                const usedAtCell = r.used_at
                                    ? '<span style="color:var(--text-body);font-size:11px;">' + formatDate(r.used_at, true) + '</span>'
                                    : '<span style="color:var(--text-muted);">—</span>';

                                let action = '';
                                if (r.is_used === 0) {
                                    action = '<button class="btn-action btn-delete" onclick="deleteReferral(' + r.id + ', \'' + escapeHtml(r.referral_no).replace(/'/g, "\\'") + '\')" title="Delete">' +
                                        '<i class="fa-solid fa-trash"></i>' +
                                    '</button>';
                                } else {
                                    action = '<button class="btn-action btn-delete" disabled title="Cannot delete a used referral">' +
                                        '<i class="fa-solid fa-trash"></i>' +
                                    '</button>';
                                }

                                dataTable.row.add([
                                    i + 1,
                                    refCode,
                                    statusHtml,
                                    usedByCell,
                                    usedAtCell,
                                    formatDate(r.created_at, true),
                                    action
                                ]);
                            });
                            showToast('Loaded ' + res.total + ' referral numbers', 'success');
                        } else {
                            dataTable.row.add([
                                '<span style="color:var(--text-muted);">No referral numbers found</span>',
                                '', '', '', '', '', ''
                            ]);
                        }
                    } else {
                        dataTable.row.add([
                            '<span style="color:#ef4444;">Error loading referrals</span>',
                            '', '', '', '', '', ''
                        ]);
                    }

                    dataTable.draw(false);
                    $('#tableLoadingOverlay').addClass('hidden');
                },
                error: function(xhr, s, e) {
                    console.error('Load referrals error:', e, xhr.responseText);
                    dataTable.clear().draw();
                    dataTable.row.add([
                        '<span style="color:#ef4444;">Error loading referrals</span>',
                        '', '', '', '', '', ''
                    ]).draw(false);
                    $('#tableLoadingOverlay').addClass('hidden');
                    showToast('Failed to load referrals', 'error');
                }
            });
        }

        // ============================================
        // DELETE
        // ============================================
        function deleteReferral(id, refNo) {
            Swal.fire({
                icon: 'warning',
                title: 'Delete Referral Number?',
                html: 'Delete <b>' + escapeHtml(refNo) + '</b>?<br><small style="color:#94a3b8;">This action cannot be undone.</small>',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: '<i class="fa-solid fa-trash"></i> Yes, Delete',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then(r => {
                if (!r.isConfirmed) return;
                $.ajax({
                    url: API_BASE + 'delete-referral.php',
                    method: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({ id: id }),
                    dataType: 'json',
                    success: function(res) {
                        if (res && res.status === 'success') {
                            Swal.fire({ icon:'success', title:'Deleted!', text: res.message, confirmButtonText:'OK', confirmButtonColor:'#1d4ed8' });
                            loadReferrals();
                        } else {
                            Swal.fire({ icon:'error', title:'Error', text: res.message || 'Delete failed', confirmButtonText:'OK', confirmButtonColor:'#1d4ed8' });
                        }
                    },
                    error: function() {
                        Swal.fire({ icon:'error', title:'Server Error', text:'Delete failed', confirmButtonText:'OK', confirmButtonColor:'#1d4ed8' });
                    }
                });
            });
        }
    </script>

</body>
</html>