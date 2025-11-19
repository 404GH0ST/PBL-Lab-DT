
CREATE TABLE "User" (
    id BIGSERIAL PRIMARY KEY,
    nama_user VARCHAR(255) NOT NULL,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    level VARCHAR(50) CHECK (level IN ('admin', 'editor'))
);


CREATE TABLE Anggota (
    id BIGSERIAL PRIMARY KEY,
    nama_anggota VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    status_aktif BOOLEAN NOT NULL,
    role VARCHAR(50) NOT NULL, 
    new_column BIGINT NOT NULL
);

COMMENT ON COLUMN Anggota.id IS 'ID unik setiap anggota';
COMMENT ON COLUMN Anggota.nama_anggota IS 'Nama lengkap';
COMMENT ON COLUMN Anggota.password IS 'Password terenkripsi, untuk login';
COMMENT ON COLUMN Anggota.status_aktif IS 'Menandakan apakah akun aktif';
COMMENT ON COLUMN Anggota.role IS 'Menentukan hak akses pengguna';


CREATE TABLE Kontak (
    id SERIAL PRIMARY KEY,
    alamat VARCHAR(255) NOT NULL,
    telepon VARCHAR(255) NOT NULL,
    email_lab VARCHAR(255) NOT NULL,
    link_maps VARCHAR(255) NOT NULL
);

COMMENT ON COLUMN Kontak.id IS 'ID unik kontak';
COMMENT ON COLUMN Kontak.alamat IS 'alamat lengkap lab';
COMMENT ON COLUMN Kontak.telepon IS 'Nomor telepon lab';
COMMENT ON COLUMN Kontak.email_lab IS 'Email resmi lab';
COMMENT ON COLUMN Kontak.link_maps IS 'Link ke Google Maps';


CREATE TABLE Galeri (
    id SERIAL PRIMARY KEY,
    judul_foto VARCHAR(255) NOT NULL,
    deskripsi_foto TEXT NOT NULL,
    path_foto VARCHAR(255) NOT NULL,
    tanggal_upload TIMESTAMP NOT NULL,
    id_anggota BIGINT NOT NULL, 
    status VARCHAR(50) NOT NULL, 
    add_approval BIGINT NOT NULL,
    CONSTRAINT galeri_id_anggota_unique UNIQUE (id_anggota)
);

COMMENT ON COLUMN Galeri.id IS 'ID unik foto';
COMMENT ON COLUMN Galeri.judul_foto IS 'judul foto';
COMMENT ON COLUMN Galeri.deskripsi_foto IS 'Keterangan foto';
COMMENT ON COLUMN Galeri.path_foto IS 'Lokasi file foto';
COMMENT ON COLUMN Galeri.tanggal_upload IS 'Waktu diunggah';
COMMENT ON COLUMN Galeri.id_anggota IS 'Pengunggah foto';
COMMENT ON COLUMN Galeri.status IS 'Status persetujuan';


CREATE TABLE Berita (
    id SERIAL PRIMARY KEY,
    judul_berita VARCHAR(255) NOT NULL,
    isi_berita TEXT NOT NULL,
    tanggal_posting TIMESTAMP NOT NULL,
    foto_berita VARCHAR(255) NOT NULL,
    id_anggota BIGINT NOT NULL,
    status VARCHAR(50) NOT NULL, 
    add_approval BIGINT NOT NULL,
    CONSTRAINT berita_id_anggota_unique UNIQUE (id_anggota)
);

COMMENT ON COLUMN Berita.id IS 'ID unik berita';
COMMENT ON COLUMN Berita.judul_berita IS 'isi lengkap berita yang ingin di upload';
COMMENT ON COLUMN Berita.isi_berita IS 'Isi lengkap berita yang mau di upload';
COMMENT ON COLUMN Berita.tanggal_posting IS 'Tanggal berita diupload';
COMMENT ON COLUMN Berita.foto_berita IS 'Gambar utama berita yang ingin diupload';
COMMENT ON COLUMN Berita.id_anggota IS 'Penulis berita';
COMMENT ON COLUMN Berita.status IS 'Status persetujuan dari admin';


CREATE TABLE Publikasi (
    id SERIAL PRIMARY KEY,
    judul VARCHAR(255) NOT NULL,
    tahun_terbit INTEGER NOT NULL, 
    link_publikasi VARCHAR(255) NOT NULL,
    deskripsi TEXT NOT NULL,
    id_anggota BIGINT NOT NULL, 
    status VARCHAR(50) NOT NULL, 
    tanggal_upload TIMESTAMP NOT NULL,
    add_approval BIGINT NOT NULL,
    CONSTRAINT publikasi_id_anggota_unique UNIQUE (id_anggota)
);

COMMENT ON COLUMN Publikasi.id IS 'ID unik publikasi';
COMMENT ON COLUMN Publikasi.judul IS 'Judul publikasi';
COMMENT ON COLUMN Publikasi.tahun_terbit IS 'Tahun terbit publikasi';
COMMENT ON COLUMN Publikasi.link_publikasi IS 'URL atau tautan ke file publikasi';
COMMENT ON COLUMN Publikasi.deskripsi IS 'Deskripsi singkat publikasi';
COMMENT ON COLUMN Publikasi.id_anggota IS 'Pembuat publikasi';
COMMENT ON COLUMN Publikasi.status IS 'Status publikasi';
COMMENT ON COLUMN Publikasi.tanggal_upload IS 'Waktu publikasi ditambahkan';

CREATE TABLE approval (
    id SERIAL PRIMARY KEY,
    id_konten INTEGER NOT NULL,
    jenis_konten VARCHAR(50) NOT NULL, 
    id_admin BIGINT NOT NULL, 
    status_approval VARCHAR(50) NOT NULL, 
    tanggal_pengajuan TIMESTAMP NOT NULL,
    tanggal_respon TIMESTAMP NOT NULL,
    catatan_admin TEXT NULL,
    id_operator INTEGER NOT NULL,
    CONSTRAINT approval_id_konten_unique UNIQUE (id_konten),
    CONSTRAINT approval_id_admin_unique UNIQUE (id_admin)
);

COMMENT ON COLUMN approval.id IS 'ID unik approval';
COMMENT ON COLUMN approval.id_konten IS 'ID dari konten terkait (berita/publikasi/galeri)';
COMMENT ON COLUMN approval.jenis_konten IS 'Jenis konten yang diajukan';
COMMENT ON COLUMN approval.id_admin IS 'Admin yang memeriksa konten';
COMMENT ON COLUMN approval.status_approval IS 'Hasil persetujuan';
COMMENT ON COLUMN approval.tanggal_pengajuan IS 'Tanggal pengajuan konten';
COMMENT ON COLUMN approval.tanggal_respon IS 'Tanggal direspon oleh admin';
COMMENT ON COLUMN approval.catatan_admin IS 'alasan atau komentar admin';
COMMENT ON COLUMN approval.id_operator IS 'Pembuat konten';


CREATE TABLE Fasilitas (
    id SERIAL PRIMARY KEY,
    nama_fasilitas VARCHAR(255) NOT NULL,
    deskripsi TEXT NOT NULL,
    foto_fasilitas VARCHAR(255) NOT NULL
);

COMMENT ON COLUMN Fasilitas.id IS 'ID unik fasilitas';
COMMENT ON COLUMN Fasilitas.nama_fasilitas IS 'nama barang/fasilitas';
COMMENT ON COLUMN Fasilitas.deskripsi IS 'penjelasan fasilitas';
COMMENT ON COLUMN Fasilitas.foto_fasilitas IS 'foto fasilitas';

CREATE TABLE visi (
    id BIGSERIAL PRIMARY KEY,
    add_approval BIGINT NOT NULL
);


CREATE TABLE misi (
    id BIGSERIAL PRIMARY KEY,
    add_approval BIGINT NOT NULL
);


ALTER TABLE Galeri ADD CONSTRAINT galeri_id_anggota_foreign FOREIGN KEY (id_anggota) REFERENCES Anggota(id);
ALTER TABLE Publikasi ADD CONSTRAINT publikasi_id_anggota_foreign FOREIGN KEY (id_anggota) REFERENCES Anggota(id);
ALTER TABLE Berita ADD CONSTRAINT berita_id_anggota_foreign FOREIGN KEY (id_anggota) REFERENCES Anggota(id);
ALTER TABLE approval ADD CONSTRAINT approval_id_admin_foreign FOREIGN KEY (id_admin) REFERENCES Anggota(id);


ALTER TABLE Berita ADD CONSTRAINT berita_id_foreign FOREIGN KEY (id) REFERENCES approval(id);
ALTER TABLE Galeri ADD CONSTRAINT galeri_id_foreign FOREIGN KEY (id) REFERENCES approval(id);
ALTER TABLE Publikasi ADD CONSTRAINT publikasi_id_foreign FOREIGN KEY (id) REFERENCES approval(id);

