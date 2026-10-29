<?php
session_start();

// Check karein ke user login hai ya nahi
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    // Agar session nahi hai, toh Login page par bhej dein
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Coupons | Hascol Customer</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

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
            --btn-secondary-bg: #1a2635;
            --btn-secondary-text: #94a3b8;
            --btn-secondary-hover-bg: #1f2a3d;
            --btn-secondary-hover-text: #ffffff;
            --toolbar-btn-bg: #060b13;
        }

        body {
            background-color: var(--bg-body);
            color: var(--text-muted);
            font-family: 'Inter', sans-serif;
        }

        .text-heading {
            color: var(--text-heading) !important;
        }

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
            box-shadow: 0 0 0 2px rgba(29, 78, 216, .2);
        }

        .form-input::placeholder {
            color: var(--text-muted);
        }

        select.form-input {
            appearance: none;
            -webkit-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 10px center;
            padding-right: 30px;
            cursor: pointer;
        }

        select.form-input option {
            background: var(--bg-panel);
            color: var(--text-body);
        }

        .form-label {
            color: var(--text-muted);
            font-size: 11px;
            font-weight: 500;
            margin-bottom: 4px;
            display: block;
        }

        .btn-secondary {
            background-color: var(--btn-secondary-bg);
            color: var(--btn-secondary-text);
            padding: 8px 20px;
            border-radius: 0.25rem;
            border: none;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all .15s;
        }

        .btn-secondary:hover {
            background-color: var(--btn-secondary-hover-bg);
            color: var(--btn-secondary-hover-text);
        }

        .btn-primary {
            background-color: #1d4ed8;
            color: #fff;
            padding: 8px 20px;
            border-radius: 0.25rem;
            border: none;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: background-color .15s;
        }

        .btn-primary:hover {
            background-color: #2563eb;
        }

        .btn-primary:disabled {
            opacity: .6;
            cursor: not-allowed;
        }

        .table-container {
            position: relative;
            overflow-x: auto;
            min-height: 120px;
        }

        .table-container table {
            width: 100% !important;
            border-collapse: collapse;
            font-size: 11px;
        }

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
            letter-spacing: .5px;
        }

        .table-container table tbody td {
            padding: 10px 12px;
            border-bottom: 1px solid var(--border-color);
            color: var(--table-row-text);
            vertical-align: middle;
        }

        .table-container table tbody tr:hover {
            background-color: var(--table-row-hover);
        }

        .table-loading-overlay {
            position: absolute;
            inset: 0;
            background-color: var(--bg-panel);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 12px;
            color: var(--text-muted);
            z-index: 5;
        }

        .table-loading-overlay.hidden {
            display: none;
        }

        .dataTables_wrapper .dt-buttons,
        .dt-buttons {
            display: inline-flex !important;
            gap: 6px !important;
            flex-wrap: wrap !important;
            margin: 0 0 10px 0 !important;
            padding: 0 !important;
            float: left;
        }

        .dataTables_wrapper .dt-buttons .dt-button,
        .dt-buttons .dt-button,
        button.dt-button,
        .dt-button {
            background-image: none !important;
            background-color: var(--toolbar-btn-bg) !important;
            background: var(--toolbar-btn-bg) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 0.25rem !important;
            box-shadow: none !important;
            text-shadow: none !important;
            color: var(--text-body) !important;
            font-family: 'Inter', sans-serif !important;
            font-size: 11px !important;
            font-weight: 500 !important;
            line-height: 1 !important;
            padding: 0 12px !important;
            height: 32px !important;
            min-height: 32px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 6px !important;
            cursor: pointer !important;
            box-sizing: border-box !important;
            vertical-align: middle !important;
            transition: background-color .15s, color .15s, border-color .15s !important;
            outline: none !important;
            text-decoration: none !important;
        }

        .dataTables_wrapper .dt-buttons .dt-button i,
        .dt-buttons .dt-button i,
        .dt-button i {
            font-size: 11px !important;
            color: inherit !important;
            margin: 0 !important;
        }

        .dataTables_wrapper .dt-buttons .dt-button:hover,
        .dt-buttons .dt-button:hover,
        button.dt-button:hover,
        .dt-button:hover,
        .dt-button:not(.disabled):active {
            background-color: var(--hover-bg) !important;
            color: var(--text-heading) !important;
            border-color: var(--border-color) !important;
            box-shadow: none !important;
            outline: none !important;
        }

        .dataTables_wrapper .dt-buttons .dt-button:focus,
        .dt-buttons .dt-button:focus,
        button.dt-button:focus,
        .dt-button:focus {
            outline: none !important;
            box-shadow: 0 0 0 2px rgba(29, 78, 216, .2) !important;
            border-color: #1d4ed8 !important;
        }

        .dataTables_wrapper .dt-buttons .dt-button:active,
        .dt-buttons .dt-button:active,
        button.dt-button:active,
        .dt-button:active {
            background-color: var(--hover-bg) !important;
            transform: none !important;
            box-shadow: none !important;
        }

        .dataTables_wrapper .dataTables_filter,
        div.dataTables_wrapper div.dataTables_filter {
            float: right;
            margin: 0 0 10px 0 !important;
            padding: 0 !important;
            display: flex !important;
            align-items: center !important;
            gap: 6px !important;
            position: relative;
            text-align: right !important;
            font-family: 'Inter', sans-serif !important;
        }

        .dataTables_wrapper .dataTables_filter label,
        div.dataTables_wrapper div.dataTables_filter label {
            color: var(--text-muted) !important;
            font-size: 11px !important;
            font-weight: 500 !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 6px !important;
            margin: 0 !important;
            padding: 0 !important;
            position: relative !important;
            white-space: nowrap !important;
            font-family: 'Inter', sans-serif !important;
        }

        .dataTables_wrapper .dataTables_filter label::before,
        div.dataTables_wrapper div.dataTables_filter label::before {
            content: "\f002";
            font-family: "Font Awesome 6 Free" !important;
            font-weight: 900 !important;
            position: absolute !important;
            left: 11px !important;
            top: 50% !important;
            transform: translateY(-50%) !important;
            font-size: 11px !important;
            color: var(--text-muted) !important;
            pointer-events: none !important;
            z-index: 2 !important;
        }

        .dataTables_wrapper .dataTables_filter input,
        div.dataTables_wrapper div.dataTables_filter input,
        .dataTables_filter input[type="search"],
        .dataTables_filter input[type="text"] {
            background-color: var(--input-bg) !important;
            background-image: none !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 0.25rem !important;
            color: var(--text-body) !important;
            padding: 6px 12px 6px 32px !important;
            font-size: 12px !important;
            font-family: 'Inter', sans-serif !important;
            font-weight: 400 !important;
            height: 32px !important;
            min-height: 32px !important;
            max-height: 32px !important;
            width: 220px !important;
            max-width: 100% !important;
            outline: none !important;
            margin: 0 !important;
            box-sizing: border-box !important;
            line-height: 1.2 !important;
            display: inline-block !important;
            vertical-align: middle !important;
            transition: border-color .15s, box-shadow .15s !important;
            -webkit-appearance: none !important;
            appearance: none !important;
        }

        .dataTables_wrapper .dataTables_filter input:focus,
        div.dataTables_wrapper div.dataTables_filter input:focus {
            outline: none !important;
            border-color: #1d4ed8 !important;
            box-shadow: 0 0 0 2px rgba(29, 78, 216, 0.2) !important;
        }

        .dataTables_wrapper .dataTables_filter input::placeholder,
        div.dataTables_wrapper div.dataTables_filter input::placeholder {
            color: var(--text-muted) !important;
            font-size: 11px !important;
            opacity: 1 !important;
        }

        .dataTables_filter input[type="search"]::-webkit-search-cancel-button {
            -webkit-appearance: none;
            appearance: none;
            height: 14px;
            width: 14px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cline x1='18' y1='6' x2='6' y2='18'/%3E%3Cline x1='6' y1='6' x2='18' y2='18'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-size: contain;
            cursor: pointer;
            opacity: .6;
        }

        .dataTables_filter input[type="search"]::-webkit-search-cancel-button:hover {
            opacity: 1;
        }

        .dataTables_wrapper .dataTables_info {
            color: var(--text-muted) !important;
            font-size: 11px !important;
            padding-top: 12px !important;
            clear: both;
            font-family: 'Inter', sans-serif !important;
        }

        .dataTables_wrapper .dataTables_paginate {
            padding-top: 12px !important;
            float: right;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 4px 10px !important;
            margin: 0 2px !important;
            border-radius: 4px !important;
            background: var(--toolbar-btn-bg) !important;
            border: 1px solid var(--border-color) !important;
            color: var(--text-muted) !important;
            font-size: 11px !important;
            font-family: 'Inter', sans-serif !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            background: #1d4ed8 !important;
            color: #fff !important;
            border-color: #1d4ed8 !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: var(--hover-bg) !important;
            color: var(--text-heading) !important;
            border-color: var(--border-color) !important;
        }

        .dataTables_wrapper::after {
            content: "";
            display: table;
            clear: both;
        }

        .dataTables_wrapper .dataTables_processing {
            display: none !important;
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
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: var(--bg-panel);
            border: 1px solid var(--border-color);
            border-radius: .375rem;
            padding: 12px 20px;
            color: var(--text-body);
            font-size: 12px;
            z-index: 9999;
            transform: translateY(100px);
            opacity: 0;
            transition: all .3s ease-in-out;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .25);
        }

        .toast.show {
            transform: translateY(0);
            opacity: 1;
        }

        .toast.success {
            border-color: #10b981;
        }

        .toast.success i {
            color: #10b981;
        }

        .toast.error {
            border-color: #ef4444;
        }

        .toast.error i {
            color: #ef4444;
        }

        .cp-status {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 9px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 600;
        }

        .cp-available {
            background: rgba(16, 185, 129, .12);
            color: #10b981;
            border: 1px solid rgba(16, 185, 129, .25);
        }

        .cp-used {
            background: rgba(29, 78, 216, .12);
            color: #1d4ed8;
            border: 1px solid rgba(29, 78, 216, .25);
        }

        .cp-expired {
            background: rgba(148, 163, 184, .15);
            color: #94a3b8;
            border: 1px solid rgba(148, 163, 184, .3);
        }

        .cp-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
        }

        .discount-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 10px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 700;
            background: rgba(16, 185, 129, .12);
            color: #10b981;
            border: 1px solid rgba(16, 185, 129, .25);
        }

        .discount-flat {
            background: rgba(139, 92, 246, .12);
            color: #8b5cf6;
            border-color: rgba(139, 92, 246, .25);
        }

        .coupon-title {
            font-weight: 600;
            color: var(--text-heading);
            font-size: 12px;
            display: block;
            margin-bottom: 2px;
        }

        .coupon-desc {
            font-size: 10px;
            color: var(--text-muted);
            max-width: 220px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .cell-name {
            font-weight: 600;
            color: var(--text-heading);
            font-size: 11px;
        }

        .cell-sub {
            font-size: 9px;
            color: var(--text-muted);
        }

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
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        .summary-icon.blue {
            background: rgba(29, 78, 216, .12);
            color: #1d4ed8;
        }

        .summary-icon.green {
            background: rgba(16, 185, 129, .12);
            color: #10b981;
        }

        .summary-icon.yellow {
            background: rgba(234, 179, 8, .12);
            color: #eab308;
        }

        .summary-icon.gray {
            background: rgba(148, 163, 184, .15);
            color: #94a3b8;
        }

        .summary-label {
            font-size: 10px;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: .5px;
            font-weight: 500;
        }

        .summary-value {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-heading);
            margin-top: 2px;
        }

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
            padding-right: 55px !important;
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
            z-index: 5 !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            border-color: var(--text-muted) transparent transparent transparent !important;
            border-width: 5px 4px 0 4px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__clear {
            position: absolute !important;
            right: 26px !important;
            top: 50% !important;
            transform: translateY(-50%) !important;
            font-size: 15px !important;
            font-weight: 700 !important;
            color: var(--text-muted) !important;
            cursor: pointer !important;
            z-index: 10 !important;
            padding: 0 4px !important;
            line-height: 1 !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__clear:hover {
            color: #ef4444 !important;
        }

        .select2-container--default.select2-container--focus .select2-selection--single,
        .select2-container--default.select2-container--open .select2-selection--single {
            border-color: #1d4ed8 !important;
            box-shadow: 0 0 0 2px rgba(29, 78, 216, 0.2) !important;
        }

        .select2-container--default .select2-dropdown {
            background-color: var(--bg-panel) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 0.25rem !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25) !important;
            z-index: 99999 !important;
        }

        .select2-container--default .select2-search--dropdown .select2-search__field {
            background-color: var(--input-bg) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 0.25rem !important;
            color: var(--text-body) !important;
            padding: 6px 10px !important;
            font-size: 12px !important;
            outline: none !important;
            height: 32px !important;
            box-sizing: border-box !important;
        }

        .select2-container--default .select2-search--dropdown .select2-search__field:focus {
            border-color: #1d4ed8 !important;
            box-shadow: 0 0 0 2px rgba(29, 78, 216, 0.2) !important;
        }

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

        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: var(--scrollbar-track);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--scrollbar-thumb);
            border-radius: 4px;
        }

        .hidden {
            display: none !important;
        }

        .modal-backdrop-custom {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .55);
            z-index: 10000;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
            backdrop-filter: blur(2px);
        }

        .modal-backdrop-custom.hidden {
            display: none !important;
        }

        .modal-box {
            background: var(--bg-panel);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            width: 100%;
            max-width: 720px;
            max-height: 92vh;
            display: flex;
            flex-direction: column;
            box-shadow: 0 20px 60px rgba(0, 0, 0, .35);
        }

        .modal-header {
            padding: 14px 18px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-body {
            padding: 16px 18px;
            overflow-y: auto;
        }

        .modal-footer {
            padding: 12px 18px;
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: flex-end;
            gap: 8px;
            background: var(--bg-panel);
        }

        .modal-close-btn {
            background: transparent;
            border: none;
            cursor: pointer;
            color: var(--text-muted);
            font-size: 18px;
            line-height: 1;
            padding: 4px 8px;
            border-radius: 4px;
            transition: all .15s;
        }

        .modal-close-btn:hover {
            background: var(--hover-bg);
            color: var(--text-heading);
        }

        .modal-title {
            color: var(--text-heading);
            font-weight: 600;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .cust-info-card {
            background: var(--hover-bg);
            border: 1px solid var(--border-color);
            border-radius: 6px;
            padding: 12px 14px;
            margin-top: 8px;
        }

        .cust-info-header {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--border-color);
        }

        .cust-info-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: rgba(29, 78, 216, .12);
            color: #1d4ed8;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: 600;
            flex-shrink: 0;
        }

        .cust-info-name {
            font-weight: 600;
            color: var(--text-heading);
            font-size: 13px;
        }

        .cust-info-mobile {
            font-size: 10px;
            color: var(--text-muted);
        }

        .cust-info-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 8px;
        }

        .cust-stat {
            text-align: center;
            padding: 8px 4px;
            border-radius: 4px;
            background: var(--bg-panel);
            border: 1px solid var(--border-color);
        }

        .cust-stat-label {
            font-size: 9px;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: .3px;
            margin-bottom: 3px;
        }

        .cust-stat-value {
            font-size: 15px;
            font-weight: 700;
            color: var(--text-heading);
        }

        .cust-stat-value.green {
            color: #10b981;
        }

        .cust-stat-value.blue {
            color: #1d4ed8;
        }

        .cust-stat-value.gray {
            color: #94a3b8;
        }

        .cust-stat-loading {
            padding: 10px;
            text-align: center;
            font-size: 11px;
            color: var(--text-muted);
        }

        .swal2-container {
            z-index: 999999 !important;
        }

        @media (max-width: 640px) {
            .cust-info-stats {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .dataTables_wrapper .dataTables_filter input,
            div.dataTables_wrapper div.dataTables_filter input {
                width: 160px !important;
            }

            .dataTables_wrapper .dt-buttons,
            .dt-buttons {
                float: none !important;
                margin-bottom: 8px !important;
            }

            .dataTables_wrapper .dataTables_filter,
            div.dataTables_wrapper div.dataTables_filter {
                float: none !important;
                justify-content: flex-start !important;
                width: 100% !important;
            }
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
                        <i class="fa-solid fa-ticket mr-2 text-blue-500"></i>Coupons
                    </h2>
                    <p class="text-[10px] text-gray-500">View all coupons and their usage</p>
                </div>
                <div>
                    <button type="button" id="btnOpenAssign" class="btn-primary" style="height:34px;">
                        <i class="fa-solid fa-plus-circle"></i> Assign Coupons
                    </button>
                </div>
            </div>

            <div class="summary-grid">
                <div class="summary-card">
                    <div class="summary-icon blue"><i class="fa-solid fa-list"></i></div>
                    <div>
                        <div class="summary-label">Total Coupons</div>
                        <div class="summary-value" id="sumTotal">0</div>
                    </div>
                </div>
                <div class="summary-card">
                    <div class="summary-icon green"><i class="fa-solid fa-circle-check"></i></div>
                    <div>
                        <div class="summary-label">Available</div>
                        <div class="summary-value" id="sumAvailable">0</div>
                    </div>
                </div>
                <div class="summary-card">
                    <div class="summary-icon yellow"><i class="fa-solid fa-check-double"></i></div>
                    <div>
                        <div class="summary-label">Used</div>
                        <div class="summary-value" id="sumUsed">0</div>
                    </div>
                </div>
                <div class="summary-card">
                    <div class="summary-icon gray"><i class="fa-solid fa-clock"></i></div>
                    <div>
                        <div class="summary-label">Expired</div>
                        <div class="summary-value" id="sumExpired">0</div>
                    </div>
                </div>
            </div>

            <div class="panel-card p-3 mb-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3">
                    <div class="lg:col-span-2">
                        <label class="form-label">Customer</label>
                        <select id="filterCustomer" class="form-input text-xs" style="width:100%;">
                            <option value="">All Customers</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Status</label>
                        <select id="filterStatus" class="form-input text-xs" style="height:32px;">
                            <option value="">All Status</option>
                            <option value="available">Available</option>
                            <option value="used">Used</option>
                            <option value="expired">Expired</option>
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
                    <div class="lg:col-span-4"
                        style="display:flex;gap:8px;align-items:flex-end;justify-content:flex-end;">
                        <button type="button" onclick="loadCoupons()" class="btn-primary"
                            style="height:32px;padding:0 16px;">
                            <i class="fa-solid fa-filter"></i> Apply
                        </button>
                        <button type="button" onclick="resetFilters()" class="btn-secondary"
                            style="height:32px;padding:0 14px;">
                            <i class="fa-solid fa-rotate-left"></i> Reset
                        </button>
                    </div>
                </div>
            </div>

            <div class="panel-card overflow-hidden p-3">
                <div class="table-toolbar">
                    <div class="table-toolbar-left" id="exportButtonsContainer"></div>
                    <div class="table-toolbar-right" id="searchContainer"></div>
                </div>

                <div class="table-container">
                    <div class="table-loading-overlay" id="tableLoadingOverlay">
                        <i class="fa-solid fa-spinner fa-spin text-blue-400"></i> Loading coupons...
                    </div>
                    <table id="cpTable" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Coupon</th>
                                <th>Customer</th>
                                <th>Discount</th>
                                <th>Validity</th>
                                <th>Status</th>
                                <th>Used At</th>
                                <th>Used Station</th>
                                <th>Created</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>

    <div id="assignModal" class="modal-backdrop-custom hidden">
        <div class="modal-box">
            <div class="modal-header">
                <div class="modal-title">
                    <i class="fa-solid fa-ticket text-blue-500"></i>
                    Assign Coupons to Customer
                </div>
                <button type="button" class="modal-close-btn" id="btnCloseAssign">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <div class="modal-body">
                <form id="assignForm" autocomplete="off">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">

                        <div class="md:col-span-2">
                            <label class="form-label">Select Customer <span style="color:#ef4444;">*</span></label>
                            <select id="assignCustomer" class="form-input" style="width:100%;" multiple required>
                            </select>
                            <div style="font-size:10px;color:var(--text-muted);margin-top:4px;">
                                <i class="fa-solid fa-circle-info"></i>
                                Only registered customers are listed here. You can select multiple customers.
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <div id="custInfoWrapper" class="hidden">
                                <div class="cust-info-card">
                                    <div class="cust-info-header">
                                        <div class="cust-info-avatar" id="custInfoAvatar">--</div>
                                        <div>
                                            <div class="cust-info-name" id="custInfoName">—</div>
                                            <div class="cust-info-mobile" id="custInfoMobile">—</div>
                                        </div>
                                    </div>
                                    <div class="cust-info-stats">
                                        <div class="cust-stat">
                                            <div class="cust-stat-label">Total</div>
                                            <div class="cust-stat-value" id="custStatTotal">0</div>
                                        </div>
                                        <div class="cust-stat">
                                            <div class="cust-stat-label">Available</div>
                                            <div class="cust-stat-value green" id="custStatAvailable">0</div>
                                        </div>
                                        <div class="cust-stat">
                                            <div class="cust-stat-label">Used</div>
                                            <div class="cust-stat-value blue" id="custStatUsed">0</div>
                                        </div>
                                        <div class="cust-stat">
                                            <div class="cust-stat-label">Expired</div>
                                            <div class="cust-stat-value gray" id="custStatExpired">0</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="custInfoLoading" class="hidden cust-info-card">
                                <div class="cust-stat-loading">
                                    <i class="fa-solid fa-spinner fa-spin"></i> Loading customer details...
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="form-label">Discount Type <span style="color:#ef4444;">*</span></label>
                            <select id="assignType" class="form-input" required>
                                <option value="percent">Percent (%)</option>
                                <option value="flat">Flat (Rs.)</option>
                            </select>
                        </div>

                        <div>
                            <label class="form-label">
                                Discount Value <span id="discountUnit" style="color:var(--text-muted);">(%)</span>
                                <span style="color:#ef4444;">*</span>
                            </label>
                            <input type="number" id="assignValue" class="form-input" min="0.01" step="0.01"
                                placeholder="Enter discount value" required>
                        </div>

                        <div class="md:col-span-2">
                            <label class="form-label">Coupon Title <span
                                    style="color:var(--text-muted);font-weight:400;">(optional)</span></label>
                            <input type="text" id="assignTitle" class="form-input" maxlength="200"
                                placeholder="e.g. Special Discount Coupon, Loyalty Reward">
                            <div style="font-size:10px;color:var(--text-muted);margin-top:4px;">
                                Leave empty to auto-generate based on discount
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <label class="form-label">Description <span
                                    style="color:var(--text-muted);font-weight:400;">(optional)</span></label>
                            <textarea id="assignDesc" class="form-input" rows="2" maxlength="1000"
                                placeholder="Leave empty → 'Get 20% Discount' will be auto-generated"></textarea>
                        </div>

                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-secondary" id="btnCancelAssign">
                    <i class="fa-solid fa-xmark"></i> Cancel
                </button>
                <button type="button" class="btn-primary" id="btnSubmitAssign">
                    <i class="fa-solid fa-paper-plane"></i> Assign Coupon
                </button>
            </div>
        </div>
    </div>

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
        const API_BASE = 'http://localhost:8080/hascol_customer/api/coupons-list/';

        let dataTable = null;
        window.cpStore = {};

        const exportButtons = [
            { extend: 'copy', text: '<i class="fa-regular fa-copy"></i> Copy', className: 'dt-button' },
            { extend: 'excelHtml5', text: '<i class="fa-regular fa-file-excel"></i> Excel', className: 'dt-button', title: 'Coupons_Export' },
            { extend: 'csvHtml5', text: '<i class="fa-regular fa-file-csv"></i> CSV', className: 'dt-button', title: 'Coupons_Export' },
            { extend: 'pdfHtml5', text: '<i class="fa-regular fa-file-pdf"></i> PDF', className: 'dt-button', orientation: 'landscape', pageSize: 'A4', title: 'Coupons' },
            { extend: 'print', text: '<i class="fa-solid fa-print"></i> Print', className: 'dt-button' }
        ];

        $(document).ready(function () {
            dataTable = $('#cpTable').DataTable({
                dom: 'Bfrtip',
                buttons: exportButtons,
                pageLength: 10,
                order: [],
                columnDefs: [{ orderable: false, targets: '_all' }],
                language: {
                    emptyTable: 'No coupons found',
                    info: 'Showing _START_ to _END_ of _TOTAL_',
                    infoEmpty: '0 entries',
                    infoFiltered: '(filtered from _MAX_)',
                    search: '',
                    searchPlaceholder: 'Search in table...'
                },
                initComplete: function () {
                    this.api().buttons().container().appendTo('#exportButtonsContainer');
                    const searchBox = $('#cpTable_wrapper .dataTables_filter');
                    searchBox.appendTo('#searchContainer');

                    setTimeout(function () {
                        const $input = $('#searchContainer .dataTables_filter input');
                        $input.css({
                            'width': '220px',
                            'height': '32px',
                            'padding': '6px 12px 6px 32px',
                            'box-sizing': 'border-box'
                        });
                    }, 50);
                }
            });

            $('#filterStatus').on('change', function () { loadCoupons(); });
            $('#filterCustomer').on('change', function () { loadCoupons(); });

            $('#btnOpenAssign').on('click', openAssignModal);
            $('#btnCloseAssign, #btnCancelAssign').on('click', closeAssignModal);
            $('#assignModal').on('click', function (e) {
                if (e.target === this) closeAssignModal();
            });
            $('#assignType').on('change', function () {
                $('#discountUnit').text(this.value === 'percent' ? '(%)' : '(Rs.)');
            });
            $('#btnSubmitAssign').on('click', submitAssignCoupons);

            $('#assignCustomer').on('change', onAssignCustomerChange);

            $(document).on('keydown', function (e) {
                if (e.key === 'Escape' && !$('#assignModal').hasClass('hidden')) {
                    closeAssignModal();
                }
            });

            loadCustomersForFilter();
            loadCoupons();
        });

        function initSelect2(selector, placeholder, isMultiple = false) {
            const $el = $(selector);
            if ($el.data('select2')) {
                $el.select2('destroy');
            }
            $el.select2({
                placeholder: placeholder || 'Select',
                allowClear: true,
                width: '100%',
                multiple: isMultiple,
                dropdownParent: $('body'),
                language: {
                    noResults: function () { return 'No customers found'; },
                    searching: function () { return 'Searching...'; }
                },
                minimumResultsForSearch: 0
            });

            if (!isMultiple) {
                $el.off('select2:unselecting.fixclear select2:opening.fixclear');
                $el.on('select2:unselecting.fixclear', function () {
                    $(this).data('state', 'unselected');
                });
                $el.on('select2:opening.fixclear', function (e) {
                    if ($(this).data('state') === 'unselected') {
                        $(this).removeData('state');
                        e.preventDefault();
                        return false;
                    }
                });
            }
        }

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
        function formatMoney(n) {
            return 'Rs ' + Number(n || 0).toLocaleString('en-PK', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        }
        function getInitials(name) {
            if (!name) return '--';
            const parts = String(name).trim().split(/\s+/);
            if (parts.length === 1) return parts[0].substring(0, 2).toUpperCase();
            return (parts[0][0] + parts[parts.length - 1][0]).toUpperCase();
        }

        let customersLoadedOnce = false;
        let customersCache = [];

        function loadCustomersForFilter() {
            $.ajax({
                url: API_BASE + 'get-coupon-customers.php',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({}),
                dataType: 'json',
                success: function (res) {
                    customersCache = (res && res.hascol_customer) ? res.hascol_customer : [];
                    customersLoadedOnce = true;

                    const $filterSel = $('#filterCustomer');
                    $filterSel.find('option').remove();
                    $filterSel.append('<option value="">All Customers</option>');
                    customersCache.forEach(function (c) {
                        const label = c.name + (c.mobile ? ' — ' + c.mobile : '');
                        $filterSel.append('<option value="' + c.id + '">' + escapeHtml(label) + '</option>');
                    });
                    initSelect2('#filterCustomer', 'All Customers');

                    const $assignSel = $('#assignCustomer');
                    $assignSel.find('option').remove();
                    customersCache.forEach(function (c) {
                        const label = c.name
                            + (c.mobile ? ' — ' + c.mobile : '')
                            + ' (ID: ' + c.id + ')';
                        $assignSel.append('<option value="' + c.id + '">' + escapeHtml(label) + '</option>');
                    });
                    initSelect2('#assignCustomer', '-- Search or select customers --', true);
                },
                error: function (xhr, s, e) {
                    console.error('Load customers error:', e, xhr.responseText);
                    showToast('Failed to load customers list', 'error');
                }
            });
        }

        function resetFilters() {
            $('#filterCustomer').val('').trigger('change.select2');
            $('#filterStatus').val('');
            $('#filterDateFrom').val('');
            $('#filterDateTo').val('');

            dataTable.search('').draw();
            dataTable.page(0).draw(false);

            loadCoupons();
            showToast('Filters reset — showing all coupons', 'success');
        }

        function loadCoupons() {
            const payload = {};
            const customer_id = $('#filterCustomer').val();
            const status = $('#filterStatus').val();
            const dateFrom = $('#filterDateFrom').val();
            const dateTo = $('#filterDateTo').val();

            if (customer_id) payload.customer_id = parseInt(customer_id);
            if (status) payload.status = status;
            if (dateFrom) payload.date_from = dateFrom;
            if (dateTo) payload.date_to = dateTo;

            $('#tableLoadingOverlay').removeClass('hidden');

            $.ajax({
                url: API_BASE + 'get-coupons.php',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(payload),
                dataType: 'json',
                success: function (res) {
                    dataTable.clear().draw();
                    window.cpStore = {};

                    if (res && res.status === 'success') {
                        $('#sumTotal').text(res.total || 0);
                        $('#sumAvailable').text(res.total_available || 0);
                        $('#sumUsed').text(res.total_used || 0);
                        $('#sumExpired').text(res.total_expired || 0);

                        if (Array.isArray(res.coupons) && res.coupons.length) {
                            $.each(res.coupons, function (i, c) {
                                window.cpStore[c.id] = c;

                                const titleCell = '<div>' +
                                    '<span class="coupon-title">' + escapeHtml(c.title) + '</span>' +
                                    (c.description ? '<span class="coupon-desc" title="' + escapeHtml(c.description) + '">' + escapeHtml(c.description) + '</span>' : '') +
                                    '</div>';

                                let customerCell = '<span style="color:var(--text-muted);">—</span>';
                                if (c.customer_id && c.customer_name) {
                                    customerCell = '<div>' +
                                        '<div class="cell-name">' + escapeHtml(c.customer_name) + '</div>' +
                                        '<div class="cell-sub">' + escapeHtml(c.customer_mobile || '—') + '</div>' +
                                        '</div>';
                                }

                                let discountCell;
                                if (c.discount_percent > 0) {
                                    discountCell = '<span class="discount-badge"><i class="fa-solid fa-percent"></i> ' + Number(c.discount_percent).toFixed(2) + '%</span>';
                                } else if (c.discount_amount > 0) {
                                    discountCell = '<span class="discount-badge discount-flat"><i class="fa-solid fa-money-bill"></i> ' + formatMoney(c.discount_amount) + '</span>';
                                } else {
                                    discountCell = '<span style="color:var(--text-muted);">—</span>';
                                }

                                let validityCell = '<span style="color:var(--text-muted);">—</span>';
                                if (c.valid_from && c.valid_to) {
                                    validityCell = '<div style="font-size:10px;line-height:1.3;">' +
                                        '<div style="color:var(--text-muted);">From: ' + formatDate(c.valid_from) + '</div>' +
                                        '<div style="color:var(--text-heading);font-weight:600;">To: ' + formatDate(c.valid_to) + '</div>' +
                                        '</div>';
                                } else if (c.valid_to) {
                                    validityCell = '<span style="color:var(--text-heading);font-weight:600;">' + formatDate(c.valid_to) + '</span>';
                                }

                                let statusHtml;
                                if (c.status === 'available') statusHtml = '<span class="cp-status cp-available"><span class="cp-dot"></span>Available</span>';
                                else if (c.status === 'used') statusHtml = '<span class="cp-status cp-used"><span class="cp-dot"></span>Used</span>';
                                else statusHtml = '<span class="cp-status cp-expired"><span class="cp-dot"></span>Expired</span>';

                                const usedAtCell = c.used_at
                                    ? '<span style="color:var(--text-body);font-size:11px;">' + formatDate(c.used_at, true) + '</span>'
                                    : '<span style="color:var(--text-muted);">—</span>';

                                const stationCell = c.used_at_station
                                    ? '<span style="color:var(--text-body);font-size:11px;">' + escapeHtml(c.used_at_station) + '</span>'
                                    : '<span style="color:var(--text-muted);">—</span>';

                                dataTable.row.add([
                                    i + 1,
                                    titleCell,
                                    customerCell,
                                    discountCell,
                                    validityCell,
                                    statusHtml,
                                    usedAtCell,
                                    stationCell,
                                    formatDate(c.created_at, true)
                                ]);
                            });
                            showToast('Loaded ' + res.total + ' coupons', 'success');
                        } else {
                            dataTable.row.add([
                                '<span style="color:var(--text-muted);">No coupons found</span>',
                                '', '', '', '', '', '', '', ''
                            ]);
                        }
                    } else {
                        dataTable.row.add([
                            '<span style="color:#ef4444;">Error loading coupons</span>',
                            '', '', '', '', '', '', '', ''
                        ]);
                    }

                    dataTable.draw(false);
                    $('#tableLoadingOverlay').hide();
                },
                error: function (xhr, s, e) {
                    console.error('Load coupons error:', e, xhr.responseText);
                    dataTable.clear().draw();
                    dataTable.row.add([
                        '<span style="color:#ef4444;">Error loading coupons</span>',
                        '', '', '', '', '', '', '', ''
                    ]).draw(false);
                    $('#tableLoadingOverlay').hide();
                    showToast('Failed to load coupons', 'error');
                }
            });
        }

        function openAssignModal() {
            if (!customersLoadedOnce) {
                showToast('Customers list is still loading. Please wait...', 'error');
                return;
            }
            if (!customersCache.length) {
                showToast('No customers available to assign coupons', 'error');
                return;
            }

            $('#assignForm')[0].reset();
            $('#assignCustomer').val(null).trigger('change.select2');
            $('#assignType').val('percent');
            $('#assignValue').val('');
            $('#assignTitle').val('');
            $('#assignDesc').val('');
            $('#discountUnit').text('(%)');

            $('#custInfoWrapper').addClass('hidden');
            $('#custInfoLoading').addClass('hidden');

            $('#assignModal').removeClass('hidden');
        }

        function closeAssignModal() {
            $('#assignModal').addClass('hidden');
        }

      function onAssignCustomerChange() {
    let customerIds = $('#assignCustomer').val() || [];
    if (!Array.isArray(customerIds)) {
        customerIds = [customerIds];
    }

    // Card aur loading dono ko pehle hide kar dein
    $('#custInfoWrapper').addClass('hidden');
    $('#custInfoLoading').addClass('hidden');

    if (customerIds.length === 0) return;

    // ✅ Agar 1 se zyada customer select hain, toh Card show hi na karein
    if (customerIds.length > 1) {
        // Optional: Aap chahein toh yahan bhi ek chhota sa text dikha sakte hain, 
        // lekin sabse clean UI yehi hai ke jab bulk select ho toh card hide rahe.
        return; 
    }

    // Agar sirf 1 customer select hua hai, toh uski detail nikal kar dikhayein
    const customerId = parseInt(customerIds[0]);
    if (!customerId) return;

    $('#custInfoLoading').removeClass('hidden');

    const cust = customersCache.find(c => c.id === customerId);
    if (cust) {
        $('#custInfoName').text(cust.name || '—');
        $('#custInfoMobile').text(cust.mobile || '—');
        $('#custInfoAvatar').text(getInitials(cust.name));
    }

    // Fetch coupon summary for this single customer
    $.ajax({
        url: API_BASE + 'get-coupons.php',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({ customer_id: customerId }),
        dataType: 'json',
        success: function (res) {
            $('#custInfoLoading').addClass('hidden');
            $('#custInfoWrapper').removeClass('hidden');

            if (res && res.status === 'success') {
                $('#custStatTotal').text(res.total || 0);
                $('#custStatAvailable').text(res.total_available || 0);
                $('#custStatUsed').text(res.total_used || 0);
                $('#custStatExpired').text(res.total_expired || 0);
            } else {
                $('#custStatTotal').text('0');
                $('#custStatAvailable').text('0');
                $('#custStatUsed').text('0');
                $('#custStatExpired').text('0');
            }
        },
        error: function () {
            $('#custInfoLoading').addClass('hidden');
            $('#custInfoWrapper').removeClass('hidden');
            $('#custStatTotal').text('—');
            $('#custStatAvailable').text('—');
            $('#custStatUsed').text('—');
            $('#custStatExpired').text('—');
            showToast('Failed to load customer summary', 'error');
        }
    });
}

        function submitAssignCoupons() {
            let customerIds = $('#assignCustomer').val() || [];
            const type = $('#assignType').val();
            const value = parseFloat($('#assignValue').val() || 0);
            const title = $('#assignTitle').val().trim();
            const desc = $('#assignDesc').val().trim();

            if (!Array.isArray(customerIds)) {
                customerIds = [customerIds];
            }

            if (customerIds.length === 0) {
                showToast('Please select at least one customer', 'error');
                return;
            }
            if (!value || value <= 0) {
                showToast('Discount value must be greater than 0', 'error');
                return;
            }
            if (type === 'percent' && value > 100) {
                showToast('Percent discount cannot exceed 100', 'error');
                return;
            }

            Swal.fire({
                title: 'Confirm Assignment?',
                html: '<div style="font-size:13px;text-align:left;">' +
                    '<b>Customers Selected:</b> ' + customerIds.length + '<br>' +
                    '<b>Coupons to assign:</b> ' + customerIds.length + ' (1 per customer)<br>' +
                    '<b>Discount:</b> ' + (type === 'percent' ? value + '%' : 'Rs. ' + value) +
                    '</div>',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, Assign',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#1d4ed8',
                cancelButtonColor: '#64748b',
                didOpen: () => {
                    const container = document.querySelector('.swal2-container');
                    if (container) container.style.zIndex = '999999';
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    doAssignAjax({
                        customer_ids: customerIds,
                        coupons_count: 1,
                        discount_type: type,
                        discount_value: value,
                        title: title,
                        description: desc
                    });
                }
            });
        }

        function doAssignAjax(payload) {
            const btn = $('#btnSubmitAssign');
            const originalHtml = btn.html();
            btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin"></i> Assigning...');

            $.ajax({
                url: API_BASE + 'assign-coupons.php',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(payload),
                dataType: 'json',
                success: function (res) {
                    if (res && res.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: res.message || 'Coupon assigned successfully',
                            timer: 2000,
                            showConfirmButton: false,
                            didOpen: () => {
                                const container = document.querySelector('.swal2-container');
                                if (container) container.style.zIndex = '999999';
                            }
                        });
                        closeAssignModal();
                        setTimeout(() => loadCoupons(), 400);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed',
                            text: (res && res.message) || 'Coupon could not be assigned',
                            didOpen: () => {
                                const container = document.querySelector('.swal2-container');
                                if (container) container.style.zIndex = '999999';
                            }
                        });
                    }
                },
                error: function (xhr) {
                    let msg = 'Server error';
                    try {
                        const r = JSON.parse(xhr.responseText);
                        if (r && r.message) msg = r.message;
                    } catch (e) { }
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: msg,
                        didOpen: () => {
                            const container = document.querySelector('.swal2-container');
                            if (container) container.style.zIndex = '999999';
                        }
                    });
                },
                complete: function () {
                    btn.prop('disabled', false).html(originalHtml);
                }
            });
        }
    </script>

</body>

</html>