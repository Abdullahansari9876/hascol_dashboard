<?php
// Hascol OMC - Advertisements Management
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hascol OMC - Advertisements</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        (function() {
            const isDarkMode = localStorage.getItem('darkMode') === 'true';
            document.documentElement.classList.toggle('dark-mode', isDarkMode);
        })();
    </script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] }
                }
            }
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
            --dropdown-bg: #ffffff;
            --dropdown-hover: #f1f5f9;
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
            --modal-overlay: rgba(6, 11, 19, 0.85);
            --btn-secondary-bg: #1a2635;
            --btn-secondary-text: #94a3b8;
            --btn-secondary-hover-bg: #1f2a3d;
            --btn-secondary-hover-text: #ffffff;
            --toolbar-btn-bg: #060b13;
            --dropdown-bg: #0d1520;
            --dropdown-hover: #1a2635;
        }

        body {
            background-color: var(--bg-body);
            color: var(--text-muted);
            font-family: 'Inter', sans-serif;
            transition: background-color .25s ease, color .25s ease;
        }

        .text-heading { color: var(--text-heading) !important; }

        .panel-card {
            background-color: var(--bg-panel);
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
            transition: background-color .25s ease, border-color .25s ease;
        }

        #sidebar, #mainContent { transition: all 0.3s ease-in-out; }

        .table-container { overflow-x: auto; }
        .table-container table { width: 100% !important; border-collapse: collapse; font-size: 11px; }
        .table-container table thead th {
            background-color: var(--table-head-bg) !important;
            color: var(--table-head-text) !important;
            font-weight: 500;
            text-align: left;
            padding: 10px 12px;
            border-bottom: 1px solid var(--border-color);
            white-space: nowrap;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .table-container table tbody td {
            padding: 10px 12px;
            border-bottom: 1px solid var(--border-color);
            color: var(--table-row-text);
            vertical-align: middle;
        }
        .table-container table tbody tr:hover { background-color: var(--table-row-hover); }

        .badge { padding: 2px 10px; border-radius: 9999px; font-size: 9px; font-weight: 600; display: inline-block; }
        .badge-active { background: #10b98120; color: #10b981; border: 1px solid #10b98140; }
        .badge-inactive { background: #ef444420; color: #ef4444; border: 1px solid #ef444440; }

        .action-btn {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 11px;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
            background: transparent;
            color: var(--text-muted);
        }
        .action-btn:hover { background: var(--hover-bg); color: var(--text-heading); }
        .action-btn.edit:hover { background: #3b82f620; color: #3b82f6; }

        #offcanvasOverlay {
            position: fixed; inset: 0; z-index: 50;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            opacity: 0; visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }
        #offcanvasOverlay.active { opacity: 1; visibility: visible; }

        #offcanvasForm {
            position: fixed; top: 0; right: -100%;
            width: 480px; max-width: 92vw; height: 100vh;
            z-index: 60;
            background-color: var(--bg-panel);
            border-left: 1px solid var(--border-color);
            box-shadow: -10px 0 30px rgba(0, 0, 0, 0.25);
            transition: right 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex; flex-direction: column;
        }
        #offcanvasForm.active { right: 0; }

        .form-input, .form-select {
            background-color: var(--input-bg);
            border: 1px solid var(--border-color);
            border-radius: 0.25rem;
            color: var(--text-body);
            padding: 6px 10px;
            width: 100%;
            font-size: 12px;
            transition: border-color 0.2s;
        }
        .form-input:focus, .form-select:focus {
            outline: none;
            border-color: #1d4ed8;
            box-shadow: 0 0 0 2px rgba(29, 78, 216, 0.2);
        }
        .form-input::placeholder { color: var(--text-muted); }
        .form-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3E%3Cpath stroke='%2364748b' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3E%3C/svg%3E");
            background-position: right 8px center;
            background-repeat: no-repeat;
            background-size: 16px;
            padding-right: 32px;
            cursor: pointer;
        }
        .form-select option { background-color: var(--bg-panel); color: var(--text-body); }

        .form-label { color: var(--text-muted); font-size: 11px; font-weight: 500; margin-bottom: 4px; display: block; }
        .form-group { margin-bottom: 14px; }
        .form-group:last-of-type { margin-bottom: 0; }

        .btn-primary {
            background-color: #1d4ed8; color: #ffffff;
            padding: 8px 20px; border-radius: 0.25rem; border: none;
            font-size: 12px; font-weight: 500; cursor: pointer;
            transition: background-color 0.2s;
        }
        .btn-primary:hover { background-color: #2563eb; }
        .btn-secondary {
            background-color: var(--btn-secondary-bg);
            color: var(--btn-secondary-text);
            padding: 8px 20px; border-radius: 0.25rem; border: none;
            font-size: 12px; font-weight: 500; cursor: pointer;
            transition: background-color 0.2s, color 0.2s;
        }
        .btn-secondary:hover { background-color: var(--btn-secondary-hover-bg); color: var(--btn-secondary-hover-text); }

        .dataTables_wrapper .dataTables_filter, .dataTables_wrapper .dataTables_length { display: none !important; }
        .dataTables_wrapper .dataTables_info { color: var(--text-muted) !important; font-size: 11px !important; padding-top: 12px !important; }
        .dataTables_wrapper .dataTables_paginate { padding-top: 12px !important; }
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 4px 10px !important; margin: 0 2px !important;
            border-radius: 4px !important;
            background: var(--toolbar-btn-bg) !important;
            border: 1px solid var(--border-color) !important;
            color: var(--text-muted) !important;
            font-size: 11px !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: var(--hover-bg) !important;
            color: var(--text-heading) !important;
            border-color: var(--border-color) !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #1d4ed8 !important; color: #ffffff !important; border-color: #1d4ed8 !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled { opacity: 0.5 !important; cursor: not-allowed !important; }

        .dt-buttons { display: flex !important; gap: 6px !important; flex-wrap: wrap !important; }
        .dt-buttons .dt-button {
            padding: 6px 12px !important;
            background-color: var(--toolbar-btn-bg) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 0.25rem !important;
            color: var(--text-muted) !important;
            font-size: 10px !important;
            cursor: pointer !important;
            transition: all 0.2s !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 4px !important;
            font-family: 'Inter', sans-serif !important;
            height: 30px !important;
            box-sizing: border-box !important;
        }
        .dt-buttons .dt-button:hover { background-color: var(--hover-bg) !important; color: var(--text-heading) !important; }

        .search-input {
            background-color: var(--input-bg);
            border: 1px solid var(--border-color);
            border-radius: 0.25rem;
            color: var(--text-body);
            padding: 6px 10px;
            font-size: 12px;
            outline: none;
            height: 30px;
            box-sizing: border-box;
        }
        .search-input::placeholder { color: var(--text-muted); }
        .search-input:focus { border-color: #1d4ed8; box-shadow: 0 0 0 2px rgba(29, 78, 216, 0.2); }

        .toast {
            position: fixed; bottom: 30px; right: 30px;
            background: var(--bg-panel);
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
            padding: 12px 20px;
            color: var(--text-body);
            font-size: 12px;
            z-index: 9999;
            transform: translateY(100px);
            opacity: 0;
            transition: all 0.3s ease-in-out;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
        }
        .toast.show { transform: translateY(0); opacity: 1; }
        .toast.success { border-color: #10b981; }
        .toast.success i { color: #10b981; }
        .toast.error { border-color: #ef4444; }
        .toast.error i { color: #ef4444; }

        .offcanvas-open { overflow: hidden !important; }

        .toolbar-row {
            display: flex; align-items: center; justify-content: space-between;
            gap: 10px; flex-wrap: nowrap; width: 100%;
        }
        .toolbar-left { display: flex; align-items: center; gap: 6px; flex-wrap: wrap; min-width: 0; }
        .toolbar-right { display: flex; align-items: center; gap: 8px; flex-wrap: nowrap; flex-shrink: 0; }
        .toolbar-right .form-select { height: 30px; padding: 4px 28px 4px 10px; box-sizing: border-box; min-width: 130px; }

        @media (max-width: 1024px) {
            .toolbar-row { flex-wrap: wrap; }
            .toolbar-right { flex-wrap: wrap; }
        }

        .column-visibility-dropdown { position: relative; display: inline-block; flex-shrink: 0; }
        .column-visibility-dropdown .dropdown-btn {
            background-color: var(--toolbar-btn-bg);
            border: 1px solid var(--border-color);
            border-radius: 0.25rem;
            color: var(--text-muted);
            padding: 6px 12px;
            font-size: 10px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
            font-family: 'Inter', sans-serif;
            min-width: 95px;
            justify-content: center;
            height: 30px;
            box-sizing: border-box;
            white-space: nowrap;
        }
        .column-visibility-dropdown .dropdown-btn:hover { background-color: var(--hover-bg); color: var(--text-heading); }
        .column-visibility-dropdown .dropdown-menu {
            position: absolute;
            top: calc(100% + 4px);
            left: 0;
            min-width: 210px;
            background-color: var(--dropdown-bg);
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
            padding: 6px 0;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
            z-index: 100;
            display: none;
            max-height: 380px;
            overflow-y: auto;
        }
        .column-visibility-dropdown .dropdown-menu.show { display: block; }
        .column-visibility-dropdown .dropdown-menu .dropdown-header {
            padding: 6px 14px 8px 14px;
            font-size: 9px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-muted);
            border-bottom: 1px solid var(--border-color);
        }
        .column-visibility-dropdown .dropdown-menu .dropdown-item {
            display: flex; align-items: center; gap: 10px;
            padding: 6px 14px; cursor: pointer;
            transition: background-color 0.15s;
            font-size: 11px; color: var(--text-body);
        }
        .column-visibility-dropdown .dropdown-menu .dropdown-item:hover { background-color: var(--dropdown-hover); }
        .column-visibility-dropdown .dropdown-menu .dropdown-item input[type="checkbox"] {
            width: 14px; height: 14px; cursor: pointer; accent-color: #1d4ed8; flex-shrink: 0;
        }
        .column-visibility-dropdown .dropdown-menu .dropdown-item .column-label { flex: 1; user-select: none; }
        .column-visibility-dropdown .dropdown-menu .dropdown-divider { height: 1px; background-color: var(--border-color); margin: 4px 8px; }
        .column-visibility-dropdown .dropdown-menu .dropdown-actions {
            display: flex; gap: 6px; padding: 8px 14px 4px 14px;
            border-top: 1px solid var(--border-color);
            margin-top: 4px;
        }
        .column-visibility-dropdown .dropdown-menu .dropdown-actions button {
            flex: 1; padding: 4px 8px; border-radius: 0.25rem;
            border: 1px solid var(--border-color);
            background: var(--toolbar-btn-bg);
            color: var(--text-muted);
            font-size: 9px; cursor: pointer;
            transition: all 0.2s;
            font-family: 'Inter', sans-serif;
            white-space: nowrap;
        }
        .column-visibility-dropdown .dropdown-menu .dropdown-actions button:hover { background: var(--hover-bg); color: var(--text-heading); }
        .column-visibility-dropdown .dropdown-menu .dropdown-actions button.select-all-btn { border-color: #10b981; color: #10b981; }
        .column-visibility-dropdown .dropdown-menu .dropdown-actions button.select-all-btn:hover { background: #10b98115; }
        .column-visibility-dropdown .dropdown-menu .dropdown-actions button.deselect-all-btn { border-color: #ef4444; color: #ef4444; }
        .column-visibility-dropdown .dropdown-menu .dropdown-actions button.deselect-all-btn:hover { background: #ef444415; }
        .column-visibility-dropdown .dropdown-menu::-webkit-scrollbar { width: 4px; }
        .column-visibility-dropdown .dropdown-menu::-webkit-scrollbar-track { background: var(--scrollbar-track); }
        .column-visibility-dropdown .dropdown-menu::-webkit-scrollbar-thumb { background: var(--scrollbar-thumb); border-radius: 4px; }

        /* Advertisement thumbnail preview */
        .ad-thumb {
            width: 42px; height: 42px; object-fit: cover;
            border-radius: 4px;
            border: 1px solid var(--border-color);
            background: var(--hover-bg);
            cursor: pointer;
        }

        /* Description cell (single line with ellipsis, full text on hover) */
        .desc-cell {
            display: inline-block;
            max-width: 220px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            vertical-align: middle;
        }

        /* File upload wrapper */
        .file-upload-wrap {
            display: flex; align-items: center; gap: 12px;
            border: 1px dashed var(--border-color);
            border-radius: 0.25rem;
            padding: 10px;
            background: var(--input-bg);
            min-height: 100px;
        }
        .file-upload-wrap input[type="file"] {
            flex: 1;
            font-size: 11px;
            color: var(--text-muted);
        }
        .file-upload-wrap input[type="file"]::file-selector-button {
            padding: 5px 12px;
            margin-right: 10px;
            border-radius: 4px;
            border: 1px solid var(--border-color);
            background: var(--btn-secondary-bg);
            color: var(--btn-secondary-text);
            font-size: 11px;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            transition: all 0.2s;
        }
        .file-upload-wrap input[type="file"]::file-selector-button:hover {
            background: var(--btn-secondary-hover-bg);
            color: var(--btn-secondary-hover-text);
        }
        .img-preview-box {
            width: 80px; height: 80px; flex-shrink: 0;
            border-radius: 6px;
            border: 1px solid var(--border-color);
            background: var(--hover-bg);
            overflow: hidden;
            display: flex; align-items: center; justify-content: center;
            padding: 4px;
            box-sizing: border-box;
        }
        .img-preview-box img {
            width: 100%; height: 100%;
            object-fit: contain;
            display: block;
        }
        .img-preview-box .placeholder-icon { color: var(--text-muted); font-size: 22px; }

        /* Force hide — override Tailwind's .hidden inside preview box */
        .img-preview-box .hidden { display: none !important; }
    </style>
</head>

<body class="flex h-screen overflow-hidden text-xs">

    <?php include __DIR__ . '/../includes/sidebar.php'; ?>

    <main id="mainContent" class="flex-1 flex flex-col overflow-hidden">

        <?php include __DIR__ . '/../includes/topbar.php'; ?>

        <div class="flex-1 overflow-y-auto p-4" id="pageContent">

            <!-- Page header -->
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h2 class="text-heading font-semibold text-base tracking-wide uppercase">Advertisements</h2>
                    <p class="text-[10px] text-gray-500">Manage advertisement banners</p>
                </div>
                <button onclick="openCreateOffcanvas()"
                    class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded text-xs font-medium transition flex items-center gap-2">
                    <i class="fa-solid fa-plus"></i> Create Advertisement
                </button>
            </div>

            <!-- Toolbar -->
            <div class="panel-card p-3 mb-4">
                <div class="toolbar-row">
                    <div class="toolbar-left" id="exportButtonsContainer"></div>
                    <div class="toolbar-right">
                        <div class="column-visibility-dropdown" id="columnVisibilityDropdown">
                            <button class="dropdown-btn" onclick="toggleColumnDropdown()">
                                <i class="fa-regular fa-eye"></i> Columns
                                <i class="fa-solid fa-chevron-down text-[8px]"></i>
                            </button>
                            <div class="dropdown-menu" id="columnDropdownMenu">
                                <div class="dropdown-header">
                                    <i class="fa-regular fa-eye mr-1"></i> Column Visibility
                                </div>
                                <div id="columnListItems"></div>
                                <div class="dropdown-divider"></div>
                                <div class="dropdown-actions">
                                    <button class="select-all-btn" onclick="selectAllColumns()">
                                        <i class="fa-regular fa-check-circle mr-1"></i> All Selected
                                    </button>
                                    <button class="deselect-all-btn" onclick="deselectAllColumns()">
                                        <i class="fa-regular fa-circle mr-1"></i> De-Selected
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-magnifying-glass text-gray-500 text-xs"></i>
                            <input type="text" id="customSearchInput" placeholder="Search advertisements..." class="search-input">
                        </div>
                        <select id="statusFilter" class="form-select text-xs">
                            <option value="all">All Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="panel-card overflow-hidden">
                <div class="table-container">
                    <table id="adsTable" class="display" style="width:100%;">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Valid From</th>
                                <th>Valid To</th>
                                <th>Status</th>
                                <th>Edit</th>
                            </tr>
                        </thead>
                        <tbody id="adsTableBody">
                            <tr>
                                <td colspan="9" class="text-center py-8 text-gray-500">
                                    <i class="fa-solid fa-spinner fa-spin text-blue-400 mr-2"></i>
                                    Loading advertisements...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>

    <!-- Toast -->
    <div id="toast" class="toast">
        <i class="fa-solid fa-check-circle mr-2"></i>
        <span id="toastMessage">Done!</span>
    </div>

    <!-- Offcanvas overlay -->
    <div id="offcanvasOverlay" onclick="closeOffcanvas()"></div>

    <!-- Offcanvas form -->
    <div id="offcanvasForm">
        <div class="flex justify-between items-center p-4 border-b flex-shrink-0" style="border-color: var(--border-color);">
            <h3 id="offcanvasTitle" class="text-heading font-semibold tracking-wide text-sm">
                <i class="fa-solid fa-bullhorn mr-2 text-blue-500"></i>Create Advertisement
            </h3>
            <button onclick="closeOffcanvas()" class="text-gray-400 hover:text-red-500 transition">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>

        <div class="flex-1 overflow-y-auto p-4">
            <form id="adForm" onsubmit="saveAd(event)">
                <input type="hidden" id="adId" value="">
                <input type="hidden" id="existingImageUrl" value="">

                <div class="form-group">
                    <label class="form-label">Title *</label>
                    <input type="text" id="title" class="form-input" placeholder="Enter Title" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea id="description" rows="3" class="form-input" placeholder="Enter Description"></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Image *</label>
                    <div class="file-upload-wrap">
                        <div class="img-preview-box" id="imgPreviewBox">
                            <i class="fa-regular fa-image placeholder-icon" id="imgPlaceholder"></i>
                            <img id="imagePreview" src="" alt="" class="hidden">
                        </div>
                        <input type="file" id="image_file" accept="image/*" onchange="handleImageSelect(event)">
                    </div>
                    <p class="text-[10px] text-gray-500 mt-1">Allowed: JPG, PNG, WEBP. Max 5MB.</p>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div class="form-group">
                        <label class="form-label">Valid From *</label>
                        <input type="datetime-local" id="valid_from" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Valid To *</label>
                        <input type="datetime-local" id="valid_to" class="form-input" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select id="status" class="form-select">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
            </form>
        </div>

        <div class="flex gap-3 p-4 border-t flex-shrink-0" style="border-color: var(--border-color);">
            <button type="submit" form="adForm" class="btn-primary flex-1">
                <i class="fa-regular fa-floppy-disk mr-1"></i> Save
            </button>
            <button type="button" onclick="closeOffcanvas()" class="btn-secondary">
                <i class="fa-regular fa-xmark mr-1"></i> Cancel
            </button>
        </div>
    </div>

    <script>
        const API_BASE_URL = 'http://localhost:8080/hascol_customer/api/';
        // Fallback base URL for old records that stored relative paths
        const IMG_BASE_URL = 'http://localhost:8080/hascol_customer/';

        let adsData = [];
        let dataTable = null;

        const columnConfig = [
            { idx: 0, label: 'S.No' },
            { idx: 1, label: 'Image' },
            { idx: 2, label: 'Title' },
            { idx: 3, label: 'Description' },
            { idx: 4, label: 'Valid From' },
            { idx: 5, label: 'Valid To' },
            { idx: 6, label: 'Status' },
            { idx: 7, label: 'Edit' }
        ];

        $(document).ready(function() {
            $('#sidebarToggle').on('click', function() {
                $('#sidebar').toggleClass('collapsed');
                localStorage.setItem('sidebarCollapsed', $('#sidebar').hasClass('collapsed'));
            });
            if (localStorage.getItem('sidebarCollapsed') === 'true') {
                $('#sidebar').addClass('collapsed');
            }

            $('#customSearchInput').on('keyup', function() {
                if ($.fn.DataTable.isDataTable('#adsTable')) {
                    $('#adsTable').DataTable().search($(this).val()).draw();
                }
            });

            $('#statusFilter').on('change', applyFilters);

            loadAds();

            $(document).on('click', function(e) {
                if (!$(e.target).closest('.column-visibility-dropdown').length) {
                    closeColumnDropdown();
                }
            });

            const isDarkMode = localStorage.getItem('darkMode') === 'true';
            const icon = document.querySelector('.dark-mode-toggle i');
            if (icon) icon.className = isDarkMode ? 'fa-solid fa-sun' : 'fa-solid fa-moon';
        });

        // Helper: escape HTML so text can't inject markup into the table
        function escapeHtml(str) {
            return String(str === null || str === undefined ? '' : str)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#39;');
        }

        // Helper: resolve image URL (handles both full URL and legacy relative path)
        function resolveImageUrl(url) {
            if (!url) return '';
            if (url.startsWith('http://') || url.startsWith('https://')) return url;
            return IMG_BASE_URL + url.replace(/^\/+/, '');
        }

        // ─── Load all advertisements ───
        function loadAds() {
            $('#adsTableBody').html(`
                <tr>
                    <td colspan="9" class="text-center py-8 text-gray-500">
                        <i class="fa-solid fa-spinner fa-spin text-blue-400 mr-2"></i>
                        Loading advertisements...
                    </td>
                </tr>
            `);

            $.ajax({
                url: API_BASE_URL + 'advertisements.php',
                type: 'POST',
                data: { customer_id: 0 },
                dataType: 'json',
                timeout: 30000,
                success: function(response) {
                    if (response && response.status === 'success' && Array.isArray(response.advertisements)) {
                        adsData = response.advertisements.map(function(a) {
                            return {
                                id: parseInt(a.id) || 0,
                                title: a.title || 'N/A',
                                description: a.description || '',
                                image_url: a.image_url || '',
                                valid_from: a.valid_from || '',
                                valid_to: a.valid_to || '',
                                status: a.status || 'active'
                            };
                        });
                    } else {
                        adsData = [];
                    }
                    initializeDataTable();
                },
                error: function(xhr, status, error) {
                    console.error('API Error:', status, error);
                    showToast('Failed to load advertisements.', 'error');
                    adsData = [];
                    initializeDataTable();
                }
            });
        }

        // ─── Row builder ───
        function buildTableRow(ad, index) {
            const isActive = ad.status === 'active';
            const fullImg = resolveImageUrl(ad.image_url);

            const thumb = fullImg
                ? `<img src="${fullImg}" class="ad-thumb" onclick="window.open('${fullImg}','_blank')" onerror="this.src='data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2242%22 height=%2242%22><rect width=%22100%25%22 height=%22100%25%22 fill=%22%23e2e8f0%22/><text x=%2250%25%22 y=%2255%25%22 font-size=%228%22 text-anchor=%22middle%22 fill=%22%2364748b%22>No Img</text></svg>'">`
                : '<span class="text-gray-500">—</span>';

            const descText = (ad.description || '').trim();
            const descCell = descText
                ? `<span class="desc-cell" title="${escapeHtml(descText)}">${escapeHtml(descText)}</span>`
                : '<span class="text-gray-500">—</span>';

            return [
                index + 1,
                thumb,
                escapeHtml(ad.title),
                descCell,
                formatDate(ad.valid_from),
                formatDate(ad.valid_to),
                `<span class="badge ${isActive ? 'badge-active' : 'badge-inactive'}">${isActive ? 'Active' : 'Inactive'}</span>`,
                `<button onclick="openEditOffcanvas(${ad.id})" class="action-btn edit"><i class="fa-solid fa-pen-to-square"></i></button>`
            ];
        }

        function formatDate(dt) {
            if (!dt) return '—';
            const d = new Date(dt.replace(' ', 'T'));
            if (isNaN(d.getTime())) return dt;
            const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
            return `${String(d.getDate()).padStart(2,'0')} ${months[d.getMonth()]} ${d.getFullYear()}`;
        }

        // ─── DataTable init ───
        function initializeDataTable() {
            if ($.fn.DataTable.isDataTable('#adsTable')) {
                $('#adsTable').DataTable().destroy();
            }

            const tableData = adsData.map(buildTableRow);

            // Export: S.No, ID, Title, Description, Valid From, Valid To, Status (Image & Edit excluded)
            const exportCols = [0, 1, 3, 4, 5, 6];

            dataTable = $('#adsTable').DataTable({
                data: tableData,
                columns: [
                    { title: 'S.No' },
                    { title: 'Image', orderable: false, searchable: false },
                    { title: 'Title' },
                    { title: 'Description' },
                    { title: 'Valid From' },
                    { title: 'Valid To' },
                    { title: 'Status' },
                    { title: 'Edit', orderable: false, searchable: false }
                ],
                dom: 'Bfrtip',
                buttons: [
                    { extend: 'copy', text: '<i class="fa-regular fa-copy"></i> Copy', className: 'toolbar-btn', exportOptions: { columns: exportCols } },
                    { extend: 'excelHtml5', text: '<i class="fa-regular fa-file-excel"></i> Excel', className: 'toolbar-btn', exportOptions: { columns: exportCols }, title: 'Advertisements_Export' },
                    { extend: 'csvHtml5', text: '<i class="fa-regular fa-file-csv"></i> CSV', className: 'toolbar-btn', exportOptions: { columns: exportCols }, title: 'Advertisements_Export' },
                    { extend: 'pdfHtml5', text: '<i class="fa-regular fa-file-pdf"></i> PDF', className: 'toolbar-btn', exportOptions: { columns: exportCols }, title: 'Advertisements', orientation: 'landscape', pageSize: 'A4' },
                    { extend: 'print', text: '<i class="fa-solid fa-print"></i> Print', className: 'toolbar-btn', exportOptions: { columns: exportCols } }
                ],
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
                ordering: true,
                order: [[1, 'desc']],
                language: {
                    emptyTable: '<div class="text-center py-8 text-gray-500"><i class="fa-solid fa-bullhorn text-2xl block mb-2"></i>No advertisements found</div>',
                    info: 'Showing _START_ to _END_ of _TOTAL_ entries',
                    infoEmpty: 'Showing 0 to 0 of 0 entries',
                    infoFiltered: '(filtered from _MAX_ total entries)'
                },
                initComplete: function() {
                    $('.dt-buttons').appendTo('#exportButtonsContainer');
                    populateColumnDropdown();
                }
            });

            applyFilters();
        }

        function populateColumnDropdown() {
            const container = $('#columnListItems');
            container.empty();

            columnConfig.forEach(function(col) {
                let isVisible = true;
                try { isVisible = dataTable.column(col.idx).visible(); } catch(e) {}
                container.append(`
                    <div class="dropdown-item" onclick="toggleColumnVisibility(${col.idx})">
                        <input type="checkbox" id="col-checkbox-${col.idx}" ${isVisible ? 'checked' : ''}
                               onclick="event.stopPropagation(); toggleColumnVisibility(${col.idx})">
                        <span class="column-label">${col.label}</span>
                    </div>
                `);
            });
        }

        function toggleColumnVisibility(colIdx) {
            if (!dataTable) return;
            try {
                const isVisible = dataTable.column(colIdx).visible();
                dataTable.column(colIdx).visible(!isVisible);
                $(`#col-checkbox-${colIdx}`).prop('checked', !isVisible);
            } catch(e) {}
        }

        function selectAllColumns() {
            if (!dataTable) return;
            columnConfig.forEach(function(col) {
                dataTable.column(col.idx).visible(true);
                $(`#col-checkbox-${col.idx}`).prop('checked', true);
            });
            showToast('All columns selected!', 'success');
        }

        function deselectAllColumns() {
            if (!dataTable) return;
            columnConfig.forEach(function(col) {
                dataTable.column(col.idx).visible(false);
                $(`#col-checkbox-${col.idx}`).prop('checked', false);
            });
            showToast('All columns deselected!', 'success');
        }

        function toggleColumnDropdown() {
            const menu = $('#columnDropdownMenu');
            menu.toggleClass('show');
            if (menu.hasClass('show')) populateColumnDropdown();
        }

        function closeColumnDropdown() {
            $('#columnDropdownMenu').removeClass('show');
        }

        function applyFilters() {
            const status = $('#statusFilter').val();
            const filtered = adsData.filter(ad => status === 'all' || ad.status === status);
            const tableData = filtered.map(buildTableRow);
            if (dataTable) {
                dataTable.clear();
                dataTable.rows.add(tableData);
                dataTable.draw();
            }
        }

        // ─── Toast ───
        function showToast(message, type = 'success') {
            const toast = $('#toast');
            $('#toastMessage').text(message);
            toast.removeClass('success error').addClass(type).addClass('show');
            clearTimeout(window.toastTimeout);
            window.toastTimeout = setTimeout(() => toast.removeClass('show'), 3000);
        }

        // ─── Offcanvas ───
        function openOffcanvas() {
            $('#offcanvasOverlay').addClass('active');
            $('#offcanvasForm').addClass('active');
            $('body').addClass('offcanvas-open');
        }

        function closeOffcanvas() {
            $('#offcanvasOverlay').removeClass('active');
            $('#offcanvasForm').removeClass('active');
            $('body').removeClass('offcanvas-open');
        }

        function toLocalInput(dt) {
            if (!dt) return '';
            const d = new Date(dt.replace(' ', 'T'));
            if (isNaN(d.getTime())) return '';
            const pad = n => String(n).padStart(2, '0');
            return `${d.getFullYear()}-${pad(d.getMonth()+1)}-${pad(d.getDate())}T${pad(d.getHours())}:${pad(d.getMinutes())}`;
        }

        // ─── Image preview box helpers ───
        function showImagePreview(url) {
            const img = $('#imagePreview');
            const icon = $('#imgPlaceholder');

            if (url) {
                img.off('error').on('error', function() {
                    $(this).addClass('hidden').attr('src', '');
                    icon.removeClass('hidden');
                });
                img.attr('src', url).removeClass('hidden');
                icon.addClass('hidden');
            } else {
                img.addClass('hidden').attr('src', '');
                icon.removeClass('hidden');
            }
        }

        function handleImageSelect(event) {
            const file = event.target.files[0];
            if (!file) return;

            if (!file.type.startsWith('image/')) {
                showToast('Please select a valid image file.', 'error');
                event.target.value = '';
                return;
            }
            if (file.size > 5 * 1024 * 1024) {
                showToast('Image size should be less than 5MB.', 'error');
                event.target.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                showImagePreview(e.target.result);
            };
            reader.readAsDataURL(file);
        }

        // ─── Create ───
        function openCreateOffcanvas() {
            $('#offcanvasTitle').html('<i class="fa-solid fa-bullhorn mr-2 text-blue-500"></i>Create Advertisement');
            $('#adForm')[0].reset();
            $('#adId').val('');
            $('#existingImageUrl').val('');
            $('#status').val('active');
            $('#image_file').val('');
            showImagePreview('');
            openOffcanvas();
        }

        // ─── Edit ───
        function openEditOffcanvas(adId) {
            const ad = adsData.find(a => a.id === adId);
            if (!ad) { showToast('Advertisement not found.', 'error'); return; }

            $('#offcanvasTitle').html('<i class="fa-solid fa-pen-to-square mr-2 text-blue-500"></i>Edit Advertisement');
            $('#adId').val(ad.id);
            $('#title').val(ad.title);
            $('#description').val(ad.description);
            $('#valid_from').val(toLocalInput(ad.valid_from));
            $('#valid_to').val(toLocalInput(ad.valid_to));
            $('#status').val(ad.status);

            $('#existingImageUrl').val(ad.image_url);
            $('#image_file').val('');

            showImagePreview(resolveImageUrl(ad.image_url));

            openOffcanvas();
        }

        // ─── Save (create / update with image upload) ───
        function saveAd(event) {
            event.preventDefault();

            const id = $('#adId').val();
            const fileInput = $('#image_file')[0];
            const newFile = fileInput.files && fileInput.files[0];
            const existingImageUrl = $('#existingImageUrl').val();

            if (!id && !newFile) {
                showToast('Please select an image.', 'error');
                return;
            }
            if (!$('#title').val().trim() || !$('#valid_from').val() || !$('#valid_to').val()) {
                showToast('Please fill all required fields.', 'error');
                return;
            }

            const submitBtn = $('#adForm button[type="submit"]');
            submitBtn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin mr-1"></i> Saving...');

            const finishSave = function(imageUrl) {
                const payload = {
                    title: $('#title').val().trim(),
                    description: $('#description').val().trim(),
                    image_url: imageUrl,
                    valid_from: $('#valid_from').val().replace('T', ' ') + ':00',
                    valid_to: $('#valid_to').val().replace('T', ' ') + ':00',
                    status: $('#status').val()
                };

                let url;
                if (id) {
                    payload.id = parseInt(id);
                    url = API_BASE_URL + 'advertisements_update.php';
                } else {
                    url = API_BASE_URL + 'advertisements_create.php';
                }

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: JSON.stringify(payload),
                    contentType: 'application/json',
                    dataType: 'json',
                    success: function(response) {
                        submitBtn.prop('disabled', false).html('<i class="fa-regular fa-floppy-disk mr-1"></i> Save');
                        if (response && response.status === 'success') {
                            showToast(id ? 'Advertisement updated successfully!' : 'Advertisement created successfully!', 'success');
                            closeOffcanvas();
                            loadAds();
                        } else {
                            showToast((response && response.message) || 'Operation failed.', 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        submitBtn.prop('disabled', false).html('<i class="fa-regular fa-floppy-disk mr-1"></i> Save');
                        console.error('Save Error:', status, error, xhr.responseText);
                        showToast('Error saving advertisement.', 'error');
                    }
                });
            };

            if (newFile) {
                const fd = new FormData();
                fd.append('image', newFile);

                $.ajax({
                    url: API_BASE_URL + 'advertisements_upload.php',
                    type: 'POST',
                    data: fd,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(res) {
                        if (res && res.status === 'success' && res.image_url) {
                            finishSave(res.image_url);
                        } else {
                            submitBtn.prop('disabled', false).html('<i class="fa-regular fa-floppy-disk mr-1"></i> Save');
                            showToast((res && res.message) || 'Image upload failed.', 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        submitBtn.prop('disabled', false).html('<i class="fa-regular fa-floppy-disk mr-1"></i> Save');
                        console.error('Upload Error:', status, error, xhr.responseText);
                        showToast('Error uploading image.', 'error');
                    }
                });
            } else {
                finishSave(existingImageUrl);
            }
        }

        // ─── Esc + backdrop ───
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape') {
                if ($('#offcanvasForm').hasClass('active')) closeOffcanvas();
                closeColumnDropdown();
            }
        });
    </script>

</body>
</html>