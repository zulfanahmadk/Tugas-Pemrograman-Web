<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Pegawai & Jabatan</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="app-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="brand">
                <div class="logo">
                    <i class="fa-solid fa-users-gear"></i>
                </div>
                <h2>HR System</h2>
            </div>
            <nav class="nav-menu">
                <a href="#" class="nav-item active" data-target="dashboard-view">
                    <i class="fa-solid fa-chart-pie"></i> Dashboard
                </a>
                <a href="#" class="nav-item" data-target="pegawai-view">
                    <i class="fa-solid fa-user-tie"></i> Data Pegawai
                </a>
                <a href="#" class="nav-item" data-target="jabatan-view">
                    <i class="fa-solid fa-briefcase"></i> Data Jabatan
                </a>
                <a href="#" class="nav-item" data-target="relasi-view">
                    <i class="fa-solid fa-sitemap"></i> Jabatan Pegawai
                </a>
            </nav>
            <div class="theme-toggle">
                <i class="fa-solid fa-moon"></i> Dark Mode
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header class="topbar">
                <h1 id="page-title">Dashboard</h1>
                <div class="user-profile">
                    <img src="https://ui-avatars.com/api/?name=Admin&background=random" alt="Admin">
                    <span>Admin</span>
                </div>
            </header>

            <div class="content-area">
                <!-- Dashboard View -->
                <section id="dashboard-view" class="view-section active">
                    <div class="stats-grid">
                        <div class="stat-card">
                            <div class="icon-box"><i class="fa-solid fa-users"></i></div>
                            <div class="stat-info">
                                <h3>Total Pegawai</h3>
                                <h2 id="count-pegawai">0</h2>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="icon-box"><i class="fa-solid fa-layer-group"></i></div>
                            <div class="stat-info">
                                <h3>Total Jabatan</h3>
                                <h2 id="count-jabatan">0</h2>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="icon-box"><i class="fa-solid fa-address-card"></i></div>
                            <div class="stat-info">
                                <h3>Penugasan Aktif</h3>
                                <h2 id="count-relasi">0</h2>
                            </div>
                        </div>
                    </div>
                    <div class="welcome-banner">
                        <div class="banner-content">
                            <h2>Selamat datang di HR System!</h2>
                            <p>Sistem manajemen sumber daya manusia yang dirancang dengan desain premium dan antarmuka yang cepat.</p>
                        </div>
                    </div>
                </section>

                <!-- Pegawai View -->
                <section id="pegawai-view" class="view-section">
                    <div class="table-header">
                        <h2>Data Pegawai</h2>
                        <button class="btn-primary" onclick="openModal('pegawaiModal')"><i class="fa-solid fa-plus"></i> Tambah Pegawai</button>
                    </div>
                    <div class="table-container">
                        <table id="table-pegawai">
                            <thead>
                                <tr>
                                    <th>NIP</th>
                                    <th>Nama Lengkap</th>
                                    <th>L/P</th>
                                    <th>Tgl Lahir</th>
                                    <th>No HP</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data will be loaded here via JS -->
                            </tbody>
                        </table>
                    </div>
                </section>

                <!-- Jabatan View -->
                <section id="jabatan-view" class="view-section">
                    <div class="table-header">
                        <h2>Data Jabatan</h2>
                        <button class="btn-primary" onclick="openModal('jabatanModal')"><i class="fa-solid fa-plus"></i> Tambah Jabatan</button>
                    </div>
                    <div class="table-container">
                        <table id="table-jabatan">
                            <thead>
                                <tr>
                                    <th>Kode Jabatan</th>
                                    <th>Nama Jabatan</th>
                                    <th>Level</th>
                                    <th>Gaji</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data will be loaded here via JS -->
                            </tbody>
                        </table>
                    </div>
                </section>

                <!-- Relasi Jabatan Pegawai View -->
                <section id="relasi-view" class="view-section">
                    <div class="table-header">
                        <h2>Jabatan Pegawai</h2>
                        <button class="btn-primary" onclick="openModal('relasiModal')"><i class="fa-solid fa-plus"></i> Tambah Penugasan</button>
                    </div>
                    <div class="table-container">
                        <table id="table-relasi">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Pegawai</th>
                                    <th>Jabatan</th>
                                    <th>Periode</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data will be loaded here via JS -->
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </main>
    </div>

    <!-- Modals -->
    <!-- Modal Pegawai -->
    <div id="pegawaiModal" class="modal-overlay">
        <div class="modal">
            <div class="modal-header">
                <h3 id="modalPegawaiTitle">Tambah Pegawai</h3>
                <button class="close-btn" onclick="closeModal('pegawaiModal')">&times;</button>
            </div>
            <form id="form-pegawai">
                <input type="hidden" id="pegawai-action" value="create">
                <div class="form-group">
                    <label>NIP</label>
                    <input type="text" id="pegawai-nip" name="nip" required>
                </div>
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" id="pegawai-nama" name="namalengkap" required>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <select id="pegawai-jk" name="jeniskelamin">
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Lahir</label>
                        <input type="date" id="pegawai-tgl" name="tanggallahir">
                    </div>
                </div>
                <div class="form-group">
                    <label>Alamat</label>
                    <textarea id="pegawai-alamat" name="alamat" rows="2"></textarea>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>No HP</label>
                        <input type="text" id="pegawai-nohp" name="nohp">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" id="pegawai-email" name="email">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-secondary" onclick="closeModal('pegawaiModal')">Batal</button>
                    <button type="submit" class="btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Jabatan -->
    <div id="jabatanModal" class="modal-overlay">
        <div class="modal">
            <div class="modal-header">
                <h3 id="modalJabatanTitle">Tambah Jabatan</h3>
                <button class="close-btn" onclick="closeModal('jabatanModal')">&times;</button>
            </div>
            <form id="form-jabatan">
                <input type="hidden" id="jabatan-action" value="create">
                <div class="form-group">
                    <label>Kode Jabatan</label>
                    <input type="text" id="jabatan-kode" name="kodejabatan" required>
                </div>
                <div class="form-group">
                    <label>Nama Jabatan</label>
                    <input type="text" id="jabatan-nama" name="namajabatan" required>
                </div>
                <div class="form-group">
                    <label>Level</label>
                    <input type="text" id="jabatan-level" name="level">
                </div>
                <div class="form-group">
                    <label>Gaji (Rp)</label>
                    <input type="number" id="jabatan-gaji" name="gaji">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-secondary" onclick="closeModal('jabatanModal')">Batal</button>
                    <button type="submit" class="btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Jabatan Pegawai -->
    <div id="relasiModal" class="modal-overlay">
        <div class="modal">
            <div class="modal-header">
                <h3 id="modalRelasiTitle">Tambah Penugasan Jabatan</h3>
                <button class="close-btn" onclick="closeModal('relasiModal')">&times;</button>
            </div>
            <form id="form-relasi">
                <input type="hidden" id="relasi-action" value="create">
                <input type="hidden" id="relasi-idjp" name="idjp">
                <div class="form-group">
                    <label>Pegawai</label>
                    <select id="relasi-nip" name="nip" required>
                        <!-- Loaded dynamically -->
                    </select>
                </div>
                <div class="form-group">
                    <label>Jabatan</label>
                    <select id="relasi-kode" name="kodejabatan" required>
                        <!-- Loaded dynamically -->
                    </select>
                </div>
                <div class="form-group">
                    <label>Periode</label>
                    <input type="text" id="relasi-periode" name="periode" placeholder="Contoh: 2024 - 2025">
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select id="relasi-status" name="status">
                        <option value="1">Aktif</option>
                        <option value="0">Tidak Aktif</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-secondary" onclick="closeModal('relasiModal')">Batal</button>
                    <button type="submit" class="btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>
