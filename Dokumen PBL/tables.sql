DROP TABLE IF EXISTS kegiatan CASCADE;
DROP TABLE IF EXISTS perkuliahan CASCADE;
DROP TABLE IF EXISTS fasilitas CASCADE;
DROP TABLE IF EXISTS publikasi CASCADE;
DROP TABLE IF EXISTS galeri CASCADE;
DROP TABLE IF EXISTS berita CASCADE;
DROP TABLE IF EXISTS info_lab CASCADE;
DROP TABLE IF EXISTS profil_lab CASCADE;
DROP TABLE IF EXISTS anggota CASCADE;
DROP TABLE IF EXISTS fokus_riset CASCADE;
DROP TYPE IF EXISTS role_enum CASCADE;
DROP TYPE IF EXISTS status_approval_enum CASCADE;
DROP TYPE IF EXISTS jenis_konten_enum CASCADE;
DROP TYPE IF EXISTS kondisi_enum CASCADE;
DROP TYPE IF EXISTS jenis_publikasi_enum CASCADE;

CREATE TYPE role_enum AS ENUM ('admin', 'operator');
CREATE TYPE status_approval_enum AS ENUM ('pending', 'approved', 'rejected');
CREATE TYPE jenis_konten_enum AS ENUM ('visi', 'misi', 'struktur_organisasi');
CREATE TYPE kondisi_enum AS ENUM ('baik', 'rusak_ringan', 'rusak_berat');

CREATE TABLE anggota (
    id_anggota SERIAL PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nama_lengkap VARCHAR(100) NOT NULL,
    nip_nim VARCHAR(20),
    role role_enum NOT NULL DEFAULT 'operator',
    foto_profil VARCHAR(255),
    bio TEXT,
    status_aktif BOOLEAN DEFAULT TRUE,
    reset_token VARCHAR(64) NULL,
    reset_expires_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE profil_lab (
    id SERIAL PRIMARY KEY,
    jenis_konten jenis_konten_enum NOT NULL,
    isi_konten TEXT NOT NULL,
    status status_approval_enum DEFAULT 'pending',
    id_admin_penilai INT NULL,
    catatan_admin TEXT NULL,
    tanggal_validasi TIMESTAMP NULL,
    id_editor INT NULL,
    CONSTRAINT fk_profil_lab_editor FOREIGN KEY (id_editor) REFERENCES anggota(id_anggota) ON DELETE SET NULL,
    CONSTRAINT fk_profil_lab_admin FOREIGN KEY (id_admin_penilai) REFERENCES anggota(id_anggota) ON DELETE SET NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE info_lab (
    id SERIAL PRIMARY KEY,
    nama_lab VARCHAR(100) DEFAULT 'Lab Data Teknologi',
    alamat TEXT,
    email VARCHAR(100),
    telepon VARCHAR(20),
    link_maps TEXT,
    link_instagram VARCHAR(255),
    link_youtube VARCHAR(255),
    link_linkedin VARCHAR(255),
    link_facebook VARCHAR(255),
    link_twitter VARCHAR(255),
    deskripsi TEXT,
    status status_approval_enum DEFAULT 'pending',
    id_admin_penilai INT NULL,
    catatan_admin TEXT NULL,
    tanggal_validasi TIMESTAMP NULL,
    id_editor INT NULL,
    CONSTRAINT fk_info_lab_editor FOREIGN KEY (id_editor) REFERENCES anggota(id_anggota) ON DELETE SET NULL,
    CONSTRAINT fk_info_lab_admin FOREIGN KEY (id_admin_penilai) REFERENCES anggota(id_anggota) ON DELETE SET NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE berita (
    id_berita SERIAL PRIMARY KEY,
    judul VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL,
    isi_berita TEXT NOT NULL,
    gambar_utama VARCHAR(255),
    id_penulis INT NOT NULL,
    tanggal_posting TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status status_approval_enum DEFAULT 'pending',
    id_admin_penilai INT NULL,
    catatan_admin TEXT NULL,
    tanggal_validasi TIMESTAMP NULL,
    CONSTRAINT fk_berita_penulis FOREIGN KEY (id_penulis) REFERENCES anggota(id_anggota) ON DELETE CASCADE,
    CONSTRAINT fk_berita_admin FOREIGN KEY (id_admin_penilai) REFERENCES anggota(id_anggota) ON DELETE
    SET NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE galeri (
    id_galeri SERIAL PRIMARY KEY,
    deskripsi TEXT NOT NULL,
    kategori VARCHAR(100) DEFAULT 'Lainnya',
    file_path VARCHAR(255) NOT NULL,
    id_uploader INT NOT NULL,
    tanggal_upload TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status status_approval_enum DEFAULT 'pending',
    id_admin_penilai INT NULL,
    catatan_admin TEXT NULL,
    CONSTRAINT fk_galeri_uploader FOREIGN KEY (id_uploader) REFERENCES anggota(id_anggota) ON DELETE CASCADE,
    CONSTRAINT fk_galeri_admin FOREIGN KEY (id_admin_penilai) REFERENCES anggota(id_anggota) ON DELETE
    SET NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE publikasi (
    id_publikasi SERIAL PRIMARY KEY,
    judul_publikasi VARCHAR(255) NOT NULL,
    tahun_terbit INT,
    link_publikasi VARCHAR(255),
    deskripsi TEXT,
    id_anggota INT NOT NULL,
    status status_approval_enum DEFAULT 'pending',
    id_admin_penilai INT NULL,
    catatan_admin TEXT NULL,
    citation_count INT DEFAULT 0,
    CONSTRAINT fk_publikasi_anggota FOREIGN KEY (id_anggota) REFERENCES anggota(id_anggota) ON DELETE CASCADE,
    CONSTRAINT fk_publikasi_admin FOREIGN KEY (id_admin_penilai) REFERENCES anggota(id_anggota) ON DELETE
    SET NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE fasilitas (
    id_fasilitas SERIAL PRIMARY KEY,
    nama_fasilitas VARCHAR(100) NOT NULL,
    deskripsi TEXT,
    foto_fasilitas VARCHAR(255),
    jumlah_unit INT DEFAULT 1,
    kondisi kondisi_enum DEFAULT 'baik',
    status status_approval_enum DEFAULT 'pending',
    id_admin_penilai INT NULL,
    catatan_admin TEXT NULL,
    tanggal_validasi TIMESTAMP NULL,
    id_penulis INT,
    CONSTRAINT fk_fasilitas_penulis FOREIGN KEY (id_penulis) REFERENCES anggota(id_anggota) ON DELETE SET NULL,
    CONSTRAINT fk_fasilitas_admin FOREIGN KEY (id_admin_penilai) REFERENCES anggota(id_anggota) ON DELETE SET NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS fokus_riset (
    id_fokus SERIAL PRIMARY KEY,
    bidang VARCHAR(150) NOT NULL,
    status status_approval_enum DEFAULT 'pending',
    id_admin_penilai INT NULL,
    catatan_admin TEXT NULL,
    tanggal_validasi TIMESTAMP NULL,
    id_penulis INT,
    id_editor INT NULL,
    CONSTRAINT fk_fokus_riset_penulis FOREIGN KEY (id_penulis) REFERENCES anggota(id_anggota) ON DELETE SET NULL,
    CONSTRAINT fk_fokus_riset_admin FOREIGN KEY (id_admin_penilai) REFERENCES anggota(id_anggota) ON DELETE SET NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE kegiatan (
    id_kegiatan SERIAL PRIMARY KEY,
    judul_kegiatan VARCHAR(255) NOT NULL,
    deskripsi TEXT,
    gambar VARCHAR(255),
    status status_approval_enum DEFAULT 'pending',
    id_admin_penilai INT NULL,
    catatan_admin TEXT NULL,
    tanggal_validasi TIMESTAMP NULL,
    id_penulis INT,
    CONSTRAINT fk_kegiatan_penulis FOREIGN KEY (id_penulis) REFERENCES anggota(id_anggota) ON DELETE SET NULL,
    CONSTRAINT fk_kegiatan_admin FOREIGN KEY (id_admin_penilai) REFERENCES anggota(id_anggota) ON DELETE SET NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE perkuliahan (
    id_perkuliahan SERIAL PRIMARY KEY,
    judul_perkuliahan VARCHAR(255) NOT NULL,
    deskripsi TEXT,
    gambar VARCHAR(255),
    status status_approval_enum DEFAULT 'pending',
    id_admin_penilai INT NULL,
    catatan_admin TEXT NULL,
    tanggal_validasi TIMESTAMP NULL,
    id_penulis INT,
    CONSTRAINT fk_perkuliahan_penulis FOREIGN KEY (id_penulis) REFERENCES anggota(id_anggota) ON DELETE SET NULL,
    CONSTRAINT fk_perkuliahan_admin FOREIGN KEY (id_admin_penilai) REFERENCES anggota(id_anggota) ON DELETE SET NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE activity_logs (
    id SERIAL PRIMARY KEY,
    user_id INT,
    action_type VARCHAR(50) NOT NULL,
    module VARCHAR(50) NOT NULL,
    resource_id INT NULL,
    resource_name VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_activity_user FOREIGN KEY (user_id) REFERENCES anggota(id_anggota) ON DELETE SET NULL
);