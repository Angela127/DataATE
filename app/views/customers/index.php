<?php require_once '../app/views/partials/flash.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customers List - Admin</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fa;
            padding: 20px;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #e0e0e0;
        }

        .header h1 {
            color: #333;
            font-size: 28px;
        }

        .header-actions {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-danger {
            background: #e74c3c;
            color: white;
        }

        .btn-danger:hover {
            background: #c0392b;
        }

        .btn-success {
            background: #27ae60;
            color: white;
        }

        .btn-success:hover {
            background: #229954;
        }

        .btn-info {
            background: #3498db;
            color: white;
        }

        .btn-info:hover {
            background: #2980b9;
        }

        .btn-warning {
            background: #f39c12;
            color: white;
        }

        .btn-warning:hover {
            background: #e67e22;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 12px;
        }

        .search-bar {
            margin-bottom: 20px;
        }

        .search-bar form {
            display: flex;
            gap: 10px;
        }

        .search-bar input {
            flex: 1;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
        }

        .search-bar input:focus {
            outline: none;
            border-color: #667eea;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }

        .stat-card h3 {
            font-size: 32px;
            margin-bottom: 5px;
        }

        .stat-card p {
            font-size: 14px;
            opacity: 0.9;
        }

        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1000px;
        }

        thead {
            background: #f8f9fa;
        }

        th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: #333;
            border-bottom: 2px solid #e0e0e0;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #f0f0f0;
            color: #555;
        }

        tbody tr {
            transition: background 0.2s ease;
        }

        tbody tr:hover {
            background: #f8f9fa;
        }

        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }

        .status-verified {
            background: #d4edda;
            color: #155724;
        }

        .status-not-verified {
            background: #fff3cd;
            color: #856404;
        }

        .status-blacklisted {
            background: #f8d7da;
            color: #721c24;
        }

        .actions {
            display: flex;
            gap: 5px;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }

        .empty-state svg {
            width: 100px;
            height: 100px;
            margin-bottom: 20px;
            opacity: 0.3;
        }

        .empty-state h3 {
            font-size: 24px;
            margin-bottom: 10px;
            color: #666;
        }

        .empty-state p {
            font-size: 14px;
        }

        /* Delete confirmation modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            align-items: center;
            justify-content: center;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: white;
            padding: 30px;
            border-radius: 15px;
            max-width: 400px;
            width: 90%;
            text-align: center;
        }

        .modal-content h3 {
            margin-bottom: 15px;
            color: #333;
        }

        .modal-content p {
            margin-bottom: 25px;
            color: #666;
        }

        .modal-actions {
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                gap: 15px;
            }

            .table-container {
                font-size: 12px;
            }

            th,
            td {
                padding: 10px 5px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>👥 Customers Management</h1>
            <div class="header-actions">
                <a href="<?= BASE_URL ?>customers/register" class="btn btn-primary">+ Add New Customer</a>
                <a href="<?= BASE_URL ?>/" class="btn btn-info">🏠 Dashboard</a>
            </div>
        </div>

        <!-- Statistics -->
        <div class="stats">
            <div class="stat-card">
                <h3><?= count($customers) ?></h3>
                <p>Total Customers</p>
            </div>
            <div class="stat-card" style="background: linear-gradient(135deg, #27ae60 0%, #229954 100%);">
                <h3>
                    <?php
                    $verified = array_filter($customers, fn($c) => $c->status === 'Verified');
                    echo count($verified);
                    ?>
                </h3>
                <p>Verified</p>
            </div>
            <div class="stat-card" style="background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);">
                <h3>
                    <?php
                    $notVerified = array_filter($customers, fn($c) => $c->status === 'Not Verified');
                    echo count($notVerified);
                    ?>
                </h3>
                <p>Not Verified</p>
            </div>
            <div class="stat-card" style="background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);">
                <h3>
                    <?php
                    $blacklisted = array_filter($customers, fn($c) => $c->status === 'Blacklisted');
                    echo count($blacklisted);
                    ?>
                </h3>
                <p>Blacklisted</p>
            </div>
        </div>

        <!-- Search Bar -->
        <div class="search-bar">
            <form action="<?= BASE_URL ?>/customers/search" method="POST">
                <input type="text" name="keyword"
                    placeholder="🔍 Search by name, username, email, matric number, or phone..."
                    value="<?= isset($keyword) ? htmlspecialchars($keyword) : '' ?>">
                <button type="submit" class="btn btn-primary">Search</button>
                <?php if (isset($keyword)): ?>
                    <a href="<?= BASE_URL ?>/customers/index" class="btn btn-warning">Clear</a>
                <?php endif; ?>
            </form>
        </div>

        <?php if (empty($customers)): ?>
            <!-- Empty State -->
            <div class="empty-state">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <h3>No Customers Found</h3>
                <p>
                    <?php if (isset($keyword)): ?>
                        No results found for "<?= htmlspecialchars($keyword) ?>"
                    <?php else: ?>
                        Start by adding your first customer
                    <?php endif; ?>
                </p>
            </div>
        <?php else: ?>
            <!-- Customer Table -->
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Customer ID</th>
                            <th>Username</th>
                            <th>Name</th>
                            <th>Matric/Staff No</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th>Balance</th>
                            <th>Registered</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($customers as $customer): ?>
                            <tr>
                                <td><?= htmlspecialchars($customer->customer_id) ?></td>
                                <td><strong><?= htmlspecialchars($customer->username) ?></strong></td>
                                <td><?= !empty($customer->name) ? htmlspecialchars($customer->name) : '<em>Not set</em>' ?></td>
                                <td><?= htmlspecialchars($customer->matric_staff_no) ?></td>
                                <td><?= htmlspecialchars($customer->email) ?></td>
                                <td><?= !empty($customer->phone) ? htmlspecialchars($customer->phone) : '<em>Not set</em>' ?>
                                </td>
                                <td>
                                    <?php
                                    $statusClass = '';
                                    switch ($customer->status) {
                                        case 'Verified':
                                            $statusClass = 'status-verified';
                                            break;
                                        case 'Blacklisted':
                                            $statusClass = 'status-blacklisted';
                                            break;
                                        default:
                                            $statusClass = 'status-not-verified';
                                    }
                                    ?>
                                    <span class="status-badge <?= $statusClass ?>">
                                        <?= htmlspecialchars($customer->status) ?>
                                    </span>
                                </td>
                                <td>RM <?= number_format($customer->balance, 2) ?></td>
                                <td><?= date('d/m/Y', strtotime($customer->created_at)) ?></td>
                                <td>
                                    <div class="actions">
                                        <a href="<?= BASE_URL ?>customers/show/<?= $customer->customer_id ?>"
                                            class="btn btn-info btn-sm">View</a>
                                        <button
                                            onclick="confirmDelete('<?= $customer->customer_id ?>', '<?= htmlspecialchars($customer->username) ?>')"
                                            class="btn btn-danger btn-sm">
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <h3>⚠️ Confirm Delete</h3>
            <p>Are you sure you want to delete customer <strong id="customerName"></strong>?</p>
            <p style="color: #e74c3c; font-size: 12px;">This action cannot be undone!</p>
            <div class="modal-actions">
                <button onclick="closeModal()" class="btn btn-info">Cancel</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const BASE_URL = '<?= BASE_URL ?>';

        function confirmDelete(customerId, customerName) {
            document.getElementById('customerName').textContent = customerName;
            document.getElementById('deleteForm').action = BASE_URL + '/customers/destroy/' + customerId;
            document.getElementById('deleteModal').classList.add('active');
        }

        function closeModal() {
            document.getElementById('deleteModal').classList.remove('active');
        }

        // Close modal when clicking outside
        document.getElementById('deleteModal').addEventListener('click', function (e) {
            if (e.target === this) {
                closeModal();
            }
        });

        // Close modal with ESC key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });
    </script>
</body>

</html>