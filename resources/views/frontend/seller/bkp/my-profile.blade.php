<?php include('header.php'); ?>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
                <div class="position-sticky pt-3">
                    <h5 class="d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span>Seller Panel</span>
                    </h5>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">
                                <i class="fas fa-home"></i>
                                Dashboard
                            </a>
                        </li>
                    </ul>
                    <h6
                        class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span>A. Action Tasks</span>
                    </h6>
                    <ul class="nav flex-column mb-2">
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-bullhorn"></i>
                                Biddings Active - All (<span class="badge bg-primary rounded-pill">#</span>)
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-check-square"></i>
                                Biddings Active - Participated (<span class="badge bg-primary rounded-pill">#</span>)
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-file-alt"></i>
                                My Open Orders (<span class="badge bg-primary rounded-pill">#</span>)
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-comments"></i>
                                Communicate with Buyers
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-headset"></i>
                                Communicate with Support
                            </a>
                        </li>
                    </ul>
                    <h6
                        class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span>B. Reports</span>
                    </h6>
                    <ul class="nav flex-column mb-2">
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-chart-line"></i>
                                Bidding Status - Participated
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-trophy"></i>
                                Bidding Status - Won
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-truck"></i>
                                Orders Allocated
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-folder-open"></i>
                                Open Orders
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-check-circle"></i>
                                Completed Orders
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-ban"></i>
                                Terminated Orders
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-times-circle"></i>
                                Cancelled Orders
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-list-ul"></i>
                                All Orders
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-dollar-sign"></i>
                                My Sales Report
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-percent"></i>
                                Commission Report
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-envelope"></i>
                                Communication Log with Buyers
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-life-ring"></i>
                                Communication Log with Support
                            </a>
                        </li>
                    </ul>
                    <h6
                        class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span>C. My Profile</span>
                    </h6>
                    <ul class="nav flex-column mb-2">
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-user"></i>
                                Edit Profile
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-cog"></i>
                                Settings
                            </a>
                        </li>
                    </ul>
                    <h6
                        class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span>D. My Notices</span>
                    </h6>
                    <ul class="nav flex-column mb-2">
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-bell"></i>
                                View Notices
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">My Open Orders</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <!-- Share Export This week and dropdown-->
                        <div class="btn-toolbar mb-2 mb-md-0">
                            <button type="button" class="btn btn-sm btn-outline-secondary">
                                <span data-feather="share-2"></span>
                                Share
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary">
                                <span data-feather="download"></span>
                                Export
                            </button>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                    id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span data-feather="calendar"></span>
                                    This week
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <li><a class="dropdown-item" href="#">Last Week</a></li>
                                    <li><a class="dropdown-item" href="#">Last Month</a></li>
                                    <li><a class="dropdown-item" href="#">Last Year</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Sno</th>
                                <th>Ord Id</th>
                                <th>SKU</th>
                                <th>CAS No</th>
                                <th>Impurity Name</th>
                                <th>Qty Reqd</th>
                                <th>Rate p.u.</th>
                                <th>Ord Value</th>
                                <th>Exp Dely</th>
                                <th>Dely City</th>
                                <th>Buyer</th>
                                <th class="actions-col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $data = [
                                [
                                    'Ord Id' => 'ORD-9387',
                                    'SKU' => 'SKU-982',
                                    'CAS No' => '6791513-42-2',
                                    'Impurity Name' => 'Impurity A',
                                    'Qty Reqd' => '10 kg',
                                    'Rate p.u.' => '$14',
                                    'Ord Value' => '$398',
                                    'Exp Dely' => '2025-07-17',
                                    'Dely City' => 'City A',
                                    'Buyer' => 'Buyer A',
                                ],
                                [
                                    'Ord Id' => 'ORD-5991',
                                    'SKU' => 'SKU-418',
                                    'CAS No' => '5004783-11-2',
                                    'Impurity Name' => 'Impurity B',
                                    'Qty Reqd' => '6 kg',
                                    'Rate p.u.' => '$14',
                                    'Ord Value' => '$925',
                                    'Exp Dely' => '2025-07-13',
                                    'Dely City' => 'City B',
                                    'Buyer' => 'Buyer B',
                                ],
                                [
                                    'Ord Id' => 'ORD-2809',
                                    'SKU' => 'SKU-767',
                                    'CAS No' => '5625149-72-6',
                                    'Impurity Name' => 'Impurity C',
                                    'Qty Reqd' => '5 kg',
                                    'Rate p.u.' => '$95',
                                    'Ord Value' => '$398',
                                    'Exp Dely' => '2025-07-16',
                                    'Dely City' => 'City C',
                                    'Buyer' => 'Buyer C',
                                ],
                                [
                                    'Ord Id' => 'ORD-6866',
                                    'SKU' => 'SKU-851',
                                    'CAS No' => '5582281-69-6',
                                    'Impurity Name' => 'Impurity D',
                                    'Qty Reqd' => '5 kg',
                                    'Rate p.u.' => '$10',
                                    'Ord Value' => '$256',
                                    'Exp Dely' => '2025-07-11',
                                    'Dely City' => 'City D',
                                    'Buyer' => 'Buyer D',
                                ],
                                [
                                    'Ord Id' => 'ORD-9724',
                                    'SKU' => 'SKU-167',
                                    'CAS No' => '5549947-96-6',
                                    'Impurity Name' => 'Impurity E',
                                    'Qty Reqd' => '9 kg',
                                    'Rate p.u.' => '$34',
                                    'Ord Value' => '$190',
                                    'Exp Dely' => '2025-07-08',
                                    'Dely City' => 'City E',
                                    'Buyer' => 'Buyer E',
                                ],
                            ];
                            foreach ($data as $i => $row): ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><?= $row['Ord Id'] ?></td>
                                <td><?= $row['SKU'] ?></td>
                                <td><?= $row['CAS No'] ?></td>
                                <td><?= $row['Impurity Name'] ?></td>
                                <td><?= $row['Qty Reqd'] ?></td>
                                <td><?= $row['Rate p.u.'] ?></td>
                                <td><?= $row['Ord Value'] ?></td>
                                <td><?= $row['Exp Dely'] ?></td>
                                <td><?= $row['Dely City'] ?></td>
                                <td><?= $row['Buyer'] ?></td>
                                <td class="actions-col">
                                    <button class="btn btn-sm btn-primary"><i class="fas fa-eye"></i> View</button>
                                    <button class="btn btn-sm btn-success"><i class="fas fa-check"></i>
                                        Complete</button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>
    <?php include('footer.php'); ?> 