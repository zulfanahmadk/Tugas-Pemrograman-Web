document.addEventListener('DOMContentLoaded', () => {
    // Navigation
    const navItems = document.querySelectorAll('.nav-item');
    const sections = document.querySelectorAll('.view-section');
    const pageTitle = document.getElementById('page-title');

    navItems.forEach(item => {
        item.addEventListener('click', (e) => {
            e.preventDefault();
            const targetId = item.getAttribute('data-target');
            
            navItems.forEach(nav => nav.classList.remove('active'));
            item.classList.add('active');
            
            sections.forEach(sec => sec.classList.remove('active'));
            document.getElementById(targetId).classList.add('active');

            pageTitle.textContent = item.textContent.trim();

            if (targetId === 'dashboard-view') loadDashboard();
            if (targetId === 'pegawai-view') loadPegawai();
            if (targetId === 'jabatan-view') loadJabatan();
            if (targetId === 'relasi-view') loadRelasi();
        });
    });

    // Dark mode toggle
    const themeToggle = document.querySelector('.theme-toggle');
    themeToggle.addEventListener('click', () => {
        const body = document.body;
        if (body.getAttribute('data-theme') === 'dark') {
            body.removeAttribute('data-theme');
            themeToggle.innerHTML = '<i class="fa-solid fa-moon"></i> Dark Mode';
        } else {
            body.setAttribute('data-theme', 'dark');
            themeToggle.innerHTML = '<i class="fa-solid fa-sun"></i> Light Mode';
        }
    });

    // Initial Load
    loadDashboard();
    loadPegawai();
    loadJabatan();
});

// Modals
function openModal(modalId) {
    document.getElementById(modalId).classList.add('show');
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.remove('show');
    // Reset forms
    if(modalId === 'pegawaiModal') {
        document.getElementById('form-pegawai').reset();
        document.getElementById('pegawai-action').value = 'create';
        document.getElementById('pegawai-nip').readOnly = false;
        document.getElementById('modalPegawaiTitle').textContent = 'Tambah Pegawai';
    }
    if(modalId === 'jabatanModal') {
        document.getElementById('form-jabatan').reset();
        document.getElementById('jabatan-action').value = 'create';
        document.getElementById('jabatan-kode').readOnly = false;
        document.getElementById('modalJabatanTitle').textContent = 'Tambah Jabatan';
    }
    if(modalId === 'relasiModal') {
        document.getElementById('form-relasi').reset();
        document.getElementById('relasi-action').value = 'create';
        document.getElementById('modalRelasiTitle').textContent = 'Tambah Penugasan';
    }
}

// Helpers
const formatRupiah = (number) => {
    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(number);
}

// Pegawai API
async function loadPegawai() {
    try {
        const res = await fetch('api_pegawai.php?action=read');
        const data = await res.json();
        
        document.getElementById('count-pegawai').textContent = data.length;
        
        const tbody = document.querySelector('#table-pegawai tbody');
        tbody.innerHTML = '';
        
        // Also update select in relasi modal
        const selectPegawai = document.getElementById('relasi-nip');
        selectPegawai.innerHTML = '<option value="">Pilih Pegawai</option>';

        data.forEach(p => {
            tbody.innerHTML += `
                <tr>
                    <td><strong>${p.nip}</strong></td>
                    <td>${p.namalengkap}</td>
                    <td>${p.jeniskelamin}</td>
                    <td>${p.tanggallahir}</td>
                    <td>${p.nohp}</td>
                    <td>
                        <div class="action-btns">
                            <button class="btn-icon btn-edit" onclick='editPegawai(${JSON.stringify(p)})'><i class="fa-solid fa-pen"></i></button>
                            <button class="btn-icon btn-delete" onclick="deletePegawai('${p.nip}')"><i class="fa-solid fa-trash"></i></button>
                        </div>
                    </td>
                </tr>
            `;
            
            selectPegawai.innerHTML += `<option value="${p.nip}">${p.nip} - ${p.namalengkap}</option>`;
        });
    } catch (error) {
        console.error("Error loading pegawai:", error);
    }
}

document.getElementById('form-pegawai').addEventListener('submit', async (e) => {
    e.preventDefault();
    const action = document.getElementById('pegawai-action').value;
    const formData = new FormData(e.target);
    
    let url = 'api_pegawai.php?action=' + action;
    let options = { method: action === 'create' ? 'POST' : 'PUT' };
    
    if(action === 'create') {
        options.body = formData;
    } else {
        const data = Object.fromEntries(formData.entries());
        options.body = JSON.stringify(data);
        options.headers = { 'Content-Type': 'application/json' };
    }

    try {
        const res = await fetch(url, options);
        const result = await res.json();
        if(result.status === 'success') {
            closeModal('pegawaiModal');
            loadPegawai();
        } else {
            alert('Error: ' + result.message);
        }
    } catch (error) {
        alert('Terjadi kesalahan.');
    }
});

function editPegawai(p) {
    document.getElementById('pegawai-action').value = 'update';
    document.getElementById('modalPegawaiTitle').textContent = 'Edit Pegawai';
    document.getElementById('pegawai-nip').value = p.nip;
    document.getElementById('pegawai-nip').readOnly = true; // PK shouldn't be edited
    document.getElementById('pegawai-nama').value = p.namalengkap;
    document.getElementById('pegawai-jk').value = p.jeniskelamin;
    document.getElementById('pegawai-tgl').value = p.tanggallahir;
    document.getElementById('pegawai-alamat').value = p.alamat;
    document.getElementById('pegawai-nohp').value = p.nohp;
    document.getElementById('pegawai-email').value = p.email;
    openModal('pegawaiModal');
}

async function deletePegawai(nip) {
    if(confirm('Yakin ingin menghapus pegawai ini?')) {
        const res = await fetch(`api_pegawai.php?action=delete&nip=${nip}`);
        const result = await res.json();
        if(result.status === 'success') loadPegawai();
        else alert('Error: ' + result.message);
    }
}

// Jabatan API
async function loadJabatan() {
    try {
        const res = await fetch('api_jabatan.php?action=read');
        const data = await res.json();
        
        document.getElementById('count-jabatan').textContent = data.length;
        
        const tbody = document.querySelector('#table-jabatan tbody');
        tbody.innerHTML = '';
        
        // Update select in relasi modal
        const selectJabatan = document.getElementById('relasi-kode');
        selectJabatan.innerHTML = '<option value="">Pilih Jabatan</option>';

        data.forEach(j => {
            tbody.innerHTML += `
                <tr>
                    <td><span class="status-badge" style="background:var(--primary-color);color:white">${j.kodejabatan}</span></td>
                    <td><strong>${j.namajabatan}</strong></td>
                    <td>Level ${j.level}</td>
                    <td>${formatRupiah(j.gaji)}</td>
                    <td>
                        <div class="action-btns">
                            <button class="btn-icon btn-edit" onclick='editJabatan(${JSON.stringify(j)})'><i class="fa-solid fa-pen"></i></button>
                            <button class="btn-icon btn-delete" onclick="deleteJabatan('${j.kodejabatan}')"><i class="fa-solid fa-trash"></i></button>
                        </div>
                    </td>
                </tr>
            `;
            
            selectJabatan.innerHTML += `<option value="${j.kodejabatan}">${j.namajabatan}</option>`;
        });
    } catch (error) {
        console.error("Error loading jabatan:", error);
    }
}

document.getElementById('form-jabatan').addEventListener('submit', async (e) => {
    e.preventDefault();
    const action = document.getElementById('jabatan-action').value;
    const formData = new FormData(e.target);
    
    let url = 'api_jabatan.php?action=' + action;
    let options = { method: action === 'create' ? 'POST' : 'PUT' };
    
    if(action === 'create') {
        options.body = formData;
    } else {
        const data = Object.fromEntries(formData.entries());
        options.body = JSON.stringify(data);
        options.headers = { 'Content-Type': 'application/json' };
    }

    try {
        const res = await fetch(url, options);
        const result = await res.json();
        if(result.status === 'success') {
            closeModal('jabatanModal');
            loadJabatan();
        } else {
            alert('Error: ' + result.message);
        }
    } catch (error) {
        alert('Terjadi kesalahan.');
    }
});

function editJabatan(j) {
    document.getElementById('jabatan-action').value = 'update';
    document.getElementById('modalJabatanTitle').textContent = 'Edit Jabatan';
    document.getElementById('jabatan-kode').value = j.kodejabatan;
    document.getElementById('jabatan-kode').readOnly = true;
    document.getElementById('jabatan-nama').value = j.namajabatan;
    document.getElementById('jabatan-level').value = j.level;
    document.getElementById('jabatan-gaji').value = j.gaji;
    openModal('jabatanModal');
}

async function deleteJabatan(kode) {
    if(confirm('Yakin ingin menghapus jabatan ini?')) {
        const res = await fetch(`api_jabatan.php?action=delete&kode=${kode}`);
        const result = await res.json();
        if(result.status === 'success') loadJabatan();
        else alert('Error: ' + result.message);
    }
}

// Jabatan Pegawai (Relasi) API
async function loadRelasi() {
    try {
        const res = await fetch('api_jabatanpegawai.php?action=read');
        const data = await res.json();
        
        document.getElementById('count-relasi').textContent = data.length;
        
        const tbody = document.querySelector('#table-relasi tbody');
        tbody.innerHTML = '';
        
        data.forEach(r => {
            let statusBadge = r.status == '1' ? 
                '<span class="status-badge status-active">Aktif</span>' : 
                '<span class="status-badge status-inactive">Tidak Aktif</span>';
                
            tbody.innerHTML += `
                <tr>
                    <td>#${r.idjp}</td>
                    <td><strong>${r.namalengkap || r.nip}</strong></td>
                    <td>${r.namajabatan || r.kodejabatan}</td>
                    <td>${r.periode || '-'}</td>
                    <td>${statusBadge}</td>
                    <td>
                        <div class="action-btns">
                            <button class="btn-icon btn-edit" onclick='editRelasi(${JSON.stringify(r)})'><i class="fa-solid fa-pen"></i></button>
                            <button class="btn-icon btn-delete" onclick="deleteRelasi('${r.idjp}')"><i class="fa-solid fa-trash"></i></button>
                        </div>
                    </td>
                </tr>
            `;
        });
    } catch (error) {
        console.error("Error loading relasi:", error);
    }
}

document.getElementById('form-relasi').addEventListener('submit', async (e) => {
    e.preventDefault();
    const action = document.getElementById('relasi-action').value;
    const formData = new FormData(e.target);
    
    let url = 'api_jabatanpegawai.php?action=' + action;
    let options = { method: action === 'create' ? 'POST' : 'PUT' };
    
    if(action === 'create') {
        options.body = formData;
    } else {
        const data = Object.fromEntries(formData.entries());
        options.body = JSON.stringify(data);
        options.headers = { 'Content-Type': 'application/json' };
    }

    try {
        const res = await fetch(url, options);
        const result = await res.json();
        if(result.status === 'success') {
            closeModal('relasiModal');
            loadRelasi();
            loadDashboard(); // Update stats
        } else {
            alert('Error: ' + result.message);
        }
    } catch (error) {
        alert('Terjadi kesalahan.');
    }
});

function editRelasi(r) {
    document.getElementById('relasi-action').value = 'update';
    document.getElementById('modalRelasiTitle').textContent = 'Edit Penugasan';
    document.getElementById('relasi-idjp').value = r.idjp;
    document.getElementById('relasi-nip').value = r.nip;
    document.getElementById('relasi-kode').value = r.kodejabatan;
    document.getElementById('relasi-periode').value = r.periode;
    document.getElementById('relasi-status').value = r.status;
    openModal('relasiModal');
}

async function deleteRelasi(idjp) {
    if(confirm('Yakin ingin menghapus penugasan ini?')) {
        const res = await fetch(`api_jabatanpegawai.php?action=delete&idjp=${idjp}`);
        const result = await res.json();
        if(result.status === 'success') {
            loadRelasi();
            loadDashboard();
        } else alert('Error: ' + result.message);
    }
}

function loadDashboard() {
    loadPegawai();
    loadJabatan();
    loadRelasi();
}
