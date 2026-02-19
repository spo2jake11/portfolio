<header class="container-fluid px-0" id="header-menu">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark py-4 px-5">
        <div class="container-fluid">
            <h3 class="navbar-brand">Welcome <?= $this->session->userdata('username') ?></h3>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="<?= base_url('home') ?>">Home</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link" href='<?= base_url('history/' . $this->session->userdata('username')) ?>'>History</a>
                        <!-- <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Menu
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#">Hi</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul> -->
                    </li>
                    <li>
                        <a class="nav-link" href="<?= base_url('logout') ?>">Logout</a>
                    </li>
                </ul>
                <form class="d-flex" role="search" method="get" action="<?= base_url('search') ?>">
                    <input class="form-control me-2" type="search" placeholder="Search Post" aria-label="Search" name="keyword">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>
</header>