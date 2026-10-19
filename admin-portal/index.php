<?php
// ─────────────────────────────────────────────
// CONFIG
// ─────────────────────────────────────────────
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'hascolbridge');

// ─────────────────────────────────────────────
// PASSWORD DECRYPTION (AES-256-GCM)
// ─────────────────────────────────────────────
define('PASSWORD_ENC_KEY', '9b79441fe979752861f8ba0f4d9f6d2868d5f4b279c6df23db4e3749bafb039a');

function decryptPassword(string $stored): ?string {
    if ($stored === '') return null;

    $raw = base64_decode($stored, true);
    if ($raw === false || strlen($raw) < 29) {
        return null;
    }

    $key = hex2bin(PASSWORD_ENC_KEY);
    if ($key === false || strlen($key) !== 32) {
        return null;
    }

    $iv     = substr($raw, 0, 12);
    $tag    = substr($raw, 12, 16);
    $cipher = substr($raw, 28);

    $plain = openssl_decrypt($cipher, 'aes-256-gcm', $key, OPENSSL_RAW_DATA, $iv, $tag);
    return $plain === false ? null : $plain;
}

// ─────────────────────────────────────────────
// DB CONNECTION
// ─────────────────────────────────────────────
$db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($db->connect_error) {
    die('DB connection failed');
}
$db->set_charset('utf8mb4');

// ─────────────────────────────────────────────
// HELPERS
// ─────────────────────────────────────────────
function jsonOut($arr) {
    header('Content-Type: application/json');
    echo json_encode($arr);
    exit;
}

// ─────────────────────────────────────────────
// AJAX HANDLER
// ─────────────────────────────────────────────
if (isset($_POST['action'])) {
    $action = $_POST['action'];

    // ─────────── LOAD CUSTOMERS ───────────
    if ($action === 'load_customers') {
        $q = trim($_POST['q'] ?? '');
        $customers = [];

        if ($q === '') {
            $stmt = $db->prepare("
                SELECT id, player_id, name, mobile, email, imei, status, verified,
                       password,
                       coupon_no, customer_type, total_coupons,
                       remaining_coupons, used_coupons, last_login, created_at
                FROM hascol_customer
                ORDER BY id DESC
                LIMIT 200
            ");
        } else {
            $like = '%' . $q . '%';
            $stmt = $db->prepare("
                SELECT id, player_id, name, mobile, email, imei, status, verified,
                       password,
                       coupon_no, customer_type, total_coupons,
                       remaining_coupons, used_coupons, last_login, created_at
                FROM hascol_customer
                WHERE name LIKE ? OR mobile LIKE ? OR player_id LIKE ?
                   OR imei LIKE ? OR coupon_no LIKE ?
                ORDER BY id DESC
                LIMIT 200
            ");
            $stmt->bind_param('sssss', $like, $like, $like, $like, $like);
        }

        $stmt->execute();
        $res = $stmt->get_result();

        while ($row = $res->fetch_assoc()) {
            // Build encrypted value preview (first 20 chars)
            $encPreview = '';
            if (!empty($row['password'])) {
                $encPreview = substr($row['password'], 0, 20) . '...';
            }
            $row['password_hash_preview'] = $encPreview;
            $row['password_has_hash'] = !empty($row['password']);

            // Can it be decrypted?
            $decryptable = false;
            if (!empty($row['password'])) {
                $testDecrypt = decryptPassword($row['password']);
                $decryptable = ($testDecrypt !== null);
            }
            $row['password_decryptable'] = $decryptable;

            unset($row['password']);

            $customers[] = $row;
        }
        $stmt->close();

        jsonOut(['ok' => true, 'customers' => $customers, 'count' => count($customers)]);
    }

    // ─────────── REVEAL PASSWORD ───────────
    if ($action === 'reveal_password') {
        $id = (int) ($_POST['customer_id'] ?? 0);
        if ($id <= 0) jsonOut(['ok' => false, 'msg' => 'Invalid customer']);

        $stmt = $db->prepare("
            SELECT password 
            FROM hascol_customer 
            WHERE id = ? 
            LIMIT 1
        ");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if (!$row) {
            jsonOut(['ok' => false, 'msg' => 'Customer not found']);
        }

        if (empty($row['password'])) {
            jsonOut(['ok' => false, 'msg' => 'No password stored for this customer']);
        }

        // Try AES decryption
        $decrypted = decryptPassword($row['password']);

        if ($decrypted !== null) {
            jsonOut([
                'ok'       => true,
                'password' => $decrypted,
                'source'   => 'encrypted'
            ]);
        }

        // Decryption failed — old bcrypt hash
        jsonOut([
            'ok'       => true,
            'password' => substr($row['password'], 0, 20) . '...',
            'source'   => 'legacy',
            'msg'      => 'Cannot decode. This password uses an old format.'
        ]);
    }

    jsonOut(['ok' => false, 'msg' => 'Unknown action']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Customer Records</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            min-height: 100vh;
            color: #e5e7eb;
            padding: 20px;
        }

        .dash-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #0f172a;
            color: #fff;
            padding: 14px 20px;
            border-radius: 12px;
            margin-bottom: 18px;
            max-width: 1300px;
            margin-left: auto;
            margin-right: auto;
            border: 1px solid #334155;
        }
        
        .card {
            background: #fff;
            color: #1e293b;
            border-radius: 12px;
            padding: 24px;
            max-width: 1300px;
            margin: 0 auto;
            box-shadow: 0 20px 50px rgba(0,0,0,.4);
        }

        .search-bar {
            display: flex;
            gap: 8px;
            margin-bottom: 16px;
        }
        .search-bar input {
            flex: 1;
            padding: 11px 14px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
        }
        .search-bar input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59,130,246,.15);
        }
        .search-bar button {
            padding: 0 20px;
            background: #3b82f6;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            font-family: inherit;
        }
        .search-bar button:hover { background: #2563eb; }

        .stats-row {
            display: flex;
            gap: 10px;
            margin-bottom: 16px;
            font-size: 12px;
            color: #64748b;
        }
        .stats-row span { padding: 4px 10px; background: #f1f5f9; border-radius: 6px; }

        .table-wrap {
            overflow-x: auto;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            background: #fff;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }
        thead {
            background: #f8fafc;
        }
        thead th {
            text-align: left;
            padding: 10px 12px;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: #475569;
            font-weight: 600;
            border-bottom: 1px solid #e2e8f0;
            white-space: nowrap;
        }
        tbody td {
            padding: 10px 12px;
            border-bottom: 1px solid #f1f5f9;
            color: #1e293b;
            vertical-align: middle;
        }
        tbody tr:hover { background: #f8fafc; }

        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 10px;
            font-weight: 600;
        }
        .badge.green { background: rgba(16,185,129,.12); color: #059669; }
        .badge.red   { background: rgba(239,68,68,.12); color: #dc2626; }
        .badge.gray  { background: rgba(148,163,184,.15); color: #64748b; }
        .badge.blue  { background: rgba(59,130,246,.12); color: #2563eb; }

        .pwd-cell {
            display: flex;
            align-items: center;
            gap: 8px;
            min-width: 220px;
        }
        .pwd-value {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            letter-spacing: 0.5px;
            padding: 3px 8px;
            border-radius: 5px;
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            transition: all .2s;
        }
        .pwd-hash {
            color: #64748b;
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
        }
        .pwd-real {
            color: #059669;
            background: rgba(16,185,129,.08);
            border: 1px solid rgba(16,185,129,.25);
            font-weight: 700;
        }
        .pwd-missing {
            color: #94a3b8;
            font-size: 10px;
            font-style: italic;
        }
        .pwd-btn {
            background: rgba(59,130,246,.1);
            color: #2563eb;
            border: 1px solid rgba(59,130,246,.25);
            padding: 3px 10px;
            border-radius: 5px;
            font-size: 10px;
            font-weight: 600;
            cursor: pointer;
            font-family: inherit;
            transition: all .15s;
            white-space: nowrap;
        }
        .pwd-btn:hover:not(:disabled) { background: #2563eb; color: #fff; }
        .pwd-btn:disabled { opacity: .5; cursor: not-allowed; }
        .pwd-btn.copy {
            background: rgba(16,185,129,.1);
            color: #059669;
            border-color: rgba(16,185,129,.3);
        }
        .pwd-btn.copy:hover { background: #059669; color: #fff; }

        .toast {
            position: fixed;
            bottom: 24px;
            right: 24px;
            background: #0f172a;
            color: #fff;
            padding: 12px 18px;
            border-radius: 8px;
            font-size: 13px;
            box-shadow: 0 10px 30px rgba(0,0,0,.4);
            opacity: 0;
            transform: translateY(20px);
            transition: all .3s;
            z-index: 9999;
            pointer-events: none;
        }
        .toast.show { opacity: 1; transform: translateY(0); }
        .toast.success { border-left: 3px solid #10b981; }
        .toast.error   { border-left: 3px solid #ef4444; }
    </style>
</head>
<body>

    <div class="dash-header">
        <div>
            <div style="font-weight:600;font-size:14px;"><i class="fa-solid fa-users mr-2"></i>Customer Records</div>
            <div style="font-size:12px;color:#94a3b8;">Direct Access Portal</div>
        </div>
    </div>

    <div class="card">
        <div class="search-bar">
            <input type="text" id="searchInput"
                   placeholder="Search by name, mobile, player ID, IMEI..."
                   autofocus>
            <button onclick="loadCustomers()">
                <i class="fa-solid fa-search"></i> Search
            </button>
        </div>

        <div class="stats-row">
            <span id="countLabel">Loading...</span>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>Player ID</th>
                        <th>IMEI</th>
                        <th>Password</th>
                        <th>Status</th>
                        <th>Verified</th>
                        <th>Coupons</th>
                        <th>Last Login</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody id="custTableBody">
                    <tr><td colspan="11" style="text-align:center;padding:30px;color:#94a3b8;">
                        <i class="fa-solid fa-spinner fa-spin"></i> Loading customers...
                    </td></tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="toast" id="toast"></div>

    <script>
        const autoHideTimers = {};

        function toast(msg, type = 'success') {
            const el = document.getElementById('toast');
            el.className = 'toast show ' + type;
            el.textContent = msg;
            clearTimeout(el._t);
            el._t = setTimeout(() => el.className = 'toast ' + type, 3000);
        }

        function esc(t) {
            if (t === null || t === undefined) return '';
            return String(t).replace(/&/g,'&amp;').replace(/</g,'&lt;')
                .replace(/>/g,'&gt;').replace(/"/g,'&quot;').replace(/'/g,'&#039;');
        }

        function fmtDate(dt) {
            if (!dt) return '—';
            const d = new Date(dt.replace(' ', 'T'));
            if (isNaN(d.getTime())) return dt;
            return d.toLocaleDateString('en-GB', { day:'2-digit', month:'short', year:'numeric' }) +
                   ' ' + d.toLocaleTimeString('en-GB', { hour:'2-digit', minute:'2-digit' });
        }

        function post(data) {
            const fd = new FormData();
            Object.entries(data).forEach(([k, v]) => fd.append(k, v));
            return fetch('', { method: 'POST', body: fd }).then(r => r.json());
        }

        let searchTimer = null;
        document.getElementById('searchInput').addEventListener('input', function() {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(loadCustomers, 350);
        });
        document.getElementById('searchInput').addEventListener('keydown', function(e) {
            if (e.key === 'Enter') { e.preventDefault(); loadCustomers(); }
        });

        async function loadCustomers() {
            const tbody = document.getElementById('custTableBody');
            tbody.innerHTML = '<tr><td colspan="11" style="text-align:center;padding:30px;color:#94a3b8;">' +
                              '<i class="fa-solid fa-spinner fa-spin"></i> Loading...</td></tr>';

            try {
                const res = await post({
                    action: 'load_customers',
                    q: document.getElementById('searchInput').value.trim(),
                });

                if (!res.ok) {
                    tbody.innerHTML = '<tr><td colspan="11" style="text-align:center;padding:30px;color:#ef4444;">' +
                                      esc(res.msg || 'Error loading customers') + '</td></tr>';
                    return;
                }

                document.getElementById('countLabel').innerHTML =
                    '<i class="fa-solid fa-list"></i> ' + res.count + ' record(s)';

                if (!res.customers.length) {
                    tbody.innerHTML = '<tr><td colspan="11" style="text-align:center;padding:30px;color:#94a3b8;">' +
                                      '<i class="fa-solid fa-inbox" style="font-size:24px;display:block;margin-bottom:8px;"></i>' +
                                      'No customers found</td></tr>';
                    return;
                }

                tbody.innerHTML = res.customers.map(c => {
                    const statusBadge = c.status === 'active'
                        ? '<span class="badge green">Active</span>'
                        : (c.status === 'banned'
                            ? '<span class="badge red">Banned</span>'
                            : '<span class="badge gray">' + esc(c.status) + '</span>');

                    const verifiedBadge = c.verified == 1
                        ? '<span class="badge green">Yes</span>'
                        : '<span class="badge gray">No</span>';

                    let pwdHtml;
                    if (!c.password_has_hash) {
                        pwdHtml = '<span class="pwd-missing">not stored</span>';
                    } else if (!c.password_decryptable) {
                        pwdHtml =
                            '<span class="pwd-value pwd-hash" id="pwd-' + c.id + '" ' +
                                  'data-hash-preview="' + esc(c.password_hash_preview) + '" ' +
                                  'title="Cannot be decoded (old format)">' +
                                esc(c.password_hash_preview) +
                            '</span>' +
                            '<button class="pwd-btn" disabled title="Cannot be decoded">No Plain</button>';
                    } else {
                        pwdHtml =
                            '<span class="pwd-value pwd-hash" id="pwd-' + c.id + '" ' +
                                  'data-hash-preview="' + esc(c.password_hash_preview) + '" ' +
                                  'title="Encrypted — click Show to decode">' +
                                esc(c.password_hash_preview) +
                            '</span>' +
                            '<button class="pwd-btn" id="pwdBtn-' + c.id + '" onclick="revealPwd(' + c.id + ', this)">Show</button>';
                    }

                    return `
                        <tr>
                            <td>${c.id}</td>
                            <td style="font-weight:500;">${esc(c.name)}</td>
                            <td>${esc(c.mobile) || '—'}</td>
                            <td><span style="font-family:monospace;font-size:11px;color:#64748b;">${esc(c.player_id)}</span></td>
                            <td><span style="font-family:monospace;font-size:11px;color:#64748b;">${esc(c.imei) || '—'}</span></td>
                            <td><div class="pwd-cell">${pwdHtml}</div></td>
                            <td>${statusBadge}</td>
                            <td>${verifiedBadge}</td>
                            <td style="font-size:11px;">
                                <span class="badge blue">${c.total_coupons} total</span>
                                <span class="badge green">${c.remaining_coupons} avail</span>
                            </td>
                            <td style="font-size:11px;color:#64748b;">${fmtDate(c.last_login)}</td>
                            <td style="font-size:11px;color:#64748b;">${fmtDate(c.created_at)}</td>
                        </tr>
                    `;
                }).join('');

            } catch (err) {
                console.error(err);
                tbody.innerHTML = '<tr><td colspan="11" style="text-align:center;padding:30px;color:#ef4444;">' +
                                  'Network error</td></tr>';
            }
        }

        async function revealPwd(customerId, btn) {
            if (btn.dataset.mode === 'copy') {
                const pwdText = btn.dataset.password || '';
                try {
                    await navigator.clipboard.writeText(pwdText);
                    toast('Password copied to clipboard', 'success');
                } catch (e) {
                    const tmp = document.createElement('textarea');
                    tmp.value = pwdText;
                    document.body.appendChild(tmp);
                    tmp.select();
                    document.execCommand('copy');
                    document.body.removeChild(tmp);
                    toast('Password copied', 'success');
                }

                clearTimeout(autoHideTimers[customerId]);
                hidePwd(customerId);
                return;
            }

            btn.disabled = true;
            btn.textContent = '...';

            try {
                const res = await post({
                    action: 'reveal_password',
                    customer_id: customerId,
                });

                if (!res.ok) {
                    toast(res.msg || 'Failed to reveal', 'error');
                    btn.disabled = false;
                    btn.textContent = 'Show';
                    return;
                }

                const span = document.getElementById('pwd-' + customerId);

                if (res.source === 'legacy') {
                    span.className = 'pwd-value pwd-hash';
                    span.textContent = res.password;
                    span.title = 'Cannot be decoded — old format';
                    toast('Cannot decode — old format', 'error');
                    btn.disabled = false;
                    btn.textContent = 'Show';
                    return;
                }

                span.className = 'pwd-value pwd-real';
                span.textContent = res.password;
                span.title = 'Decrypted password';

                btn.textContent = 'Copy';
                btn.classList.add('copy');
                btn.disabled = false;
                btn.dataset.mode = 'copy';
                btn.dataset.password = res.password;

                clearTimeout(autoHideTimers[customerId]);
                autoHideTimers[customerId] = setTimeout(() => {
                    hidePwd(customerId);
                }, 30000);

            } catch (err) {
                console.error(err);
                toast('Network error', 'error');
                btn.disabled = false;
                btn.textContent = 'Show';
            }
        }

        function hidePwd(customerId) {
            const span = document.getElementById('pwd-' + customerId);
            const btn  = document.getElementById('pwdBtn-' + customerId);

            if (!span || !btn) return;

            const originalPreview = span.dataset.hashPreview || '';
            if (!originalPreview) return;

            span.className = 'pwd-value pwd-hash';
            span.textContent = originalPreview;
            span.title = 'Encrypted — click Show to decode';

            btn.textContent = 'Show';
            btn.classList.remove('copy');
            btn.disabled = false;
            btn.dataset.mode = '';
            btn.dataset.password = '';

            delete autoHideTimers[customerId];
        }

        // Page load hote hi customers load karo
        (function init() {
            loadCustomers();
            setTimeout(() => document.getElementById('searchInput').focus(), 200);
        })();
    </script>

</body>
</html>