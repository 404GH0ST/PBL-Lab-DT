-- Drop existing objects if they exist
DROP MATERIALIZED VIEW IF EXISTS mv_dashboard_stats;
DROP VIEW IF EXISTS view_recent_activity; -- Cleanup old view
DROP PROCEDURE IF EXISTS refresh_dashboard_stats;

-- 1. Materialized View for Dashboard Stats
-- Aggregates counts for users, content, and pending approvals
CREATE MATERIALIZED VIEW mv_dashboard_stats AS
SELECT
    (SELECT COUNT(*) FROM anggota) AS total_users,
    (SELECT COUNT(*) FROM berita) AS total_news,
    (SELECT COUNT(*) FROM galeri) AS total_gallery,
    (SELECT COUNT(*) FROM publikasi) AS total_publications,
    (SELECT COUNT(*) FROM kegiatan) AS total_activities,
    (SELECT COUNT(*) FROM perkuliahan) AS total_courses,
    (SELECT COUNT(*) FROM fokus_riset) AS total_research,
    (
        (SELECT COUNT(*) FROM berita WHERE status = 'pending') +
        (SELECT COUNT(*) FROM galeri WHERE status = 'pending') +
        (SELECT COUNT(*) FROM publikasi WHERE status = 'pending') +
        (SELECT COUNT(*) FROM kegiatan WHERE status = 'pending') +
        (SELECT COUNT(*) FROM perkuliahan WHERE status = 'pending') +
        (SELECT COUNT(*) FROM fokus_riset WHERE status = 'pending')
    ) AS pending_approvals;

-- 2. Stored Procedure to Refresh Stats
CREATE OR REPLACE PROCEDURE refresh_dashboard_stats()
LANGUAGE plpgsql
AS $$
BEGIN
    REFRESH MATERIALIZED VIEW mv_dashboard_stats;
END;
$$;

-- 3. Function to Get Sorted Publications
CREATE OR REPLACE FUNCTION get_sorted_publications(limit_val INT)
RETURNS TABLE (
    id_publikasi INT,
    judul_publikasi VARCHAR,
    tahun_terbit INT,
    link_publikasi VARCHAR,
    deskripsi TEXT,
    id_anggota INT,
    status status_approval_enum,
    citation_count INT,
    nama_penulis VARCHAR
)
LANGUAGE plpgsql
AS $$
BEGIN
    RETURN QUERY
    SELECT 
        p.id_publikasi,
        p.judul_publikasi,
        p.tahun_terbit,
        p.link_publikasi,
        p.deskripsi,
        p.id_anggota,
        p.status,
        p.citation_count,
        a.nama_lengkap AS nama_penulis
    FROM publikasi p
    JOIN anggota a ON p.id_anggota = a.id_anggota
    WHERE p.status = 'approved'
    ORDER BY 
        COALESCE(p.citation_count, 0) DESC, 
        p.tahun_terbit DESC
    LIMIT limit_val;
END;
$$;

-- 4. View for Top Contributors
CREATE OR REPLACE VIEW view_top_contributors AS
SELECT
    a.id_anggota,
    a.nama_lengkap,
    a.foto_profil,
    (
        COUNT(DISTINCT b.id_berita) + 
        COUNT(DISTINCT g.id_galeri) + 
        COUNT(DISTINCT p.id_publikasi)
    ) AS total_contributions
FROM anggota a
LEFT JOIN berita b ON a.id_anggota = b.id_penulis AND b.status = 'approved'
LEFT JOIN galeri g ON a.id_anggota = g.id_uploader AND g.status = 'approved'
LEFT JOIN publikasi p ON a.id_anggota = p.id_anggota AND p.status = 'approved'
GROUP BY a.id_anggota, a.nama_lengkap, a.foto_profil
ORDER BY total_contributions DESC
LIMIT 5;

-- 5. Trigger Function to Refresh Stats
CREATE OR REPLACE FUNCTION trigger_refresh_dashboard_stats()
RETURNS TRIGGER AS $$
BEGIN
    CALL refresh_dashboard_stats();
    RETURN NULL;
END;
$$ LANGUAGE plpgsql;

-- 6. Trigger Function for Activity Logging
CREATE OR REPLACE FUNCTION log_activity_trigger()
RETURNS TRIGGER AS $$
DECLARE
    user_id INT;
    action_type VARCHAR(50);
    module_name VARCHAR(50);
    resource_id INT;
    resource_name VARCHAR(255);
    old_status status_approval_enum;
    new_status status_approval_enum;
BEGIN
    -- Determine Module Name
    IF TG_TABLE_NAME = 'berita' THEN module_name := 'Berita';
    ELSIF TG_TABLE_NAME = 'galeri' THEN module_name := 'Galeri';
    ELSIF TG_TABLE_NAME = 'publikasi' THEN module_name := 'Publikasi';
    ELSIF TG_TABLE_NAME = 'kegiatan' THEN module_name := 'Kegiatan';
    ELSIF TG_TABLE_NAME = 'perkuliahan' THEN module_name := 'Perkuliahan';
    ELSIF TG_TABLE_NAME = 'fokus_riset' THEN module_name := 'Riset';
    ELSIF TG_TABLE_NAME = 'fasilitas' THEN module_name := 'Fasilitas';
    ELSIF TG_TABLE_NAME = 'info_lab' THEN module_name := 'Info Lab';
    ELSIF TG_TABLE_NAME = 'profil_lab' THEN module_name := 'Visi Misi';
    END IF;

    -- Handle INSERT
    IF (TG_OP = 'INSERT') THEN
        action_type := 'create';
        
        -- Get User ID (generic approach)
        IF TG_TABLE_NAME = 'berita' OR TG_TABLE_NAME = 'kegiatan' OR TG_TABLE_NAME = 'perkuliahan' OR TG_TABLE_NAME = 'fokus_riset' THEN
            user_id := NEW.id_penulis;
        ELSIF TG_TABLE_NAME = 'galeri' THEN
            user_id := NEW.id_uploader;
        ELSIF TG_TABLE_NAME = 'publikasi' THEN
            user_id := NEW.id_anggota;
        ELSIF TG_TABLE_NAME = 'profil_lab' OR TG_TABLE_NAME = 'info_lab' THEN
            user_id := NEW.id_editor;
        ELSE
            user_id := NULL; -- System or unknown initial insert
        END IF;

        -- Get Resource Info
        IF TG_TABLE_NAME = 'berita' THEN 
            resource_id := NEW.id_berita; resource_name := NEW.judul;
        ELSIF TG_TABLE_NAME = 'galeri' THEN 
            resource_id := NEW.id_galeri; resource_name := SUBSTRING(NEW.deskripsi, 1, 50);
        ELSIF TG_TABLE_NAME = 'publikasi' THEN 
            resource_id := NEW.id_publikasi; resource_name := NEW.judul_publikasi;
        ELSIF TG_TABLE_NAME = 'kegiatan' THEN 
            resource_id := NEW.id_kegiatan; resource_name := NEW.judul_kegiatan;
        ELSIF TG_TABLE_NAME = 'perkuliahan' THEN 
            resource_id := NEW.id_perkuliahan; resource_name := NEW.judul_perkuliahan;
        ELSIF TG_TABLE_NAME = 'fokus_riset' THEN 
            resource_id := NEW.id_fokus; resource_name := NEW.bidang;
        ELSIF TG_TABLE_NAME = 'fasilitas' THEN 
             resource_id := NEW.id_fasilitas; resource_name := NEW.nama_fasilitas;
        ELSIF TG_TABLE_NAME = 'info_lab' THEN 
             resource_id := NEW.id; resource_name := NEW.nama_lab;
        ELSIF TG_TABLE_NAME = 'profil_lab' THEN 
             resource_id := NEW.id; resource_name := CAST(NEW.jenis_konten AS VARCHAR);
        END IF;

        INSERT INTO activity_logs (user_id, action_type, module, resource_id, resource_name, created_at)
        VALUES (user_id, action_type, module_name, resource_id, resource_name, NOW());
        
        RETURN NEW;

    -- Handle UPDATE (Specifically for Status Changes or Content Updates)
    ELSIF (TG_OP = 'UPDATE') THEN
        -- Check if status exists and changed
        IF (NEW.status IS DISTINCT FROM OLD.status) THEN
            IF NEW.status = 'approved' THEN
                action_type := 'approve';
            ELSIF NEW.status = 'rejected' THEN
                action_type := 'reject';
            ELSIF NEW.status = 'pending' THEN
                action_type := 'update'; -- Re-submission?
            END IF;

            user_id := NEW.id_admin_penilai; -- The admin who approved/rejected
            
            -- Fallback if no admin ID (e.g. system update)
            IF user_id IS NULL AND action_type = 'update' THEN
                 IF TG_TABLE_NAME = 'berita' THEN user_id := NEW.id_penulis;
                 ELSIF TG_TABLE_NAME = 'galeri' THEN user_id := NEW.id_uploader;
                 ELSIF TG_TABLE_NAME = 'publikasi' THEN user_id := NEW.id_anggota;
                 ELSIF TG_TABLE_NAME = 'profil_lab' OR TG_TABLE_NAME = 'info_lab' OR TG_TABLE_NAME = 'fokus_riset' THEN user_id := NEW.id_editor;
                 END IF;
            END IF;

             -- Get Resource Info (Same as Insert)
            IF TG_TABLE_NAME = 'berita' THEN resource_id := NEW.id_berita; resource_name := NEW.judul;
            ELSIF TG_TABLE_NAME = 'galeri' THEN resource_id := NEW.id_galeri; resource_name := SUBSTRING(NEW.deskripsi, 1, 50);
            ELSIF TG_TABLE_NAME = 'publikasi' THEN resource_id := NEW.id_publikasi; resource_name := NEW.judul_publikasi;
            ELSIF TG_TABLE_NAME = 'kegiatan' THEN resource_id := NEW.id_kegiatan; resource_name := NEW.judul_kegiatan;
            ELSIF TG_TABLE_NAME = 'perkuliahan' THEN resource_id := NEW.id_perkuliahan; resource_name := NEW.judul_perkuliahan;
            ELSIF TG_TABLE_NAME = 'fokus_riset' THEN resource_id := NEW.id_fokus; resource_name := NEW.bidang;
            ELSIF TG_TABLE_NAME = 'fasilitas' THEN resource_id := NEW.id_fasilitas; resource_name := NEW.nama_fasilitas;
            ELSIF TG_TABLE_NAME = 'info_lab' THEN resource_id := NEW.id; resource_name := NEW.nama_lab;
            ELSIF TG_TABLE_NAME = 'profil_lab' THEN resource_id := NEW.id; resource_name := CAST(NEW.jenis_konten AS VARCHAR);
            END IF;

            INSERT INTO activity_logs (user_id, action_type, module, resource_id, resource_name, created_at)
            VALUES (user_id, action_type, module_name, resource_id, resource_name, NOW());

        END IF;

        -- Log Content Updates for Profil Lab (Visi Misi), Info Lab, and Fokus Riset
        IF TG_TABLE_NAME = 'profil_lab' THEN
            IF NEW.isi_konten IS DISTINCT FROM OLD.isi_konten THEN
                 action_type := 'update';
                 user_id := NEW.id_editor;
                 resource_id := NEW.id; 
                 resource_name := CAST(NEW.jenis_konten AS VARCHAR);
                 
                 INSERT INTO activity_logs (user_id, action_type, module, resource_id, resource_name, created_at)
                 VALUES (user_id, action_type, module_name, resource_id, resource_name, NOW());
            END IF;
        
        ELSIF TG_TABLE_NAME = 'info_lab' THEN
            IF (NEW.nama_lab IS DISTINCT FROM OLD.nama_lab OR NEW.deskripsi IS DISTINCT FROM OLD.deskripsi OR NEW.telepon IS DISTINCT FROM OLD.telepon) THEN
                 action_type := 'update';
                 user_id := NEW.id_editor;
                 resource_id := NEW.id; 
                 resource_name := NEW.nama_lab;

                 INSERT INTO activity_logs (user_id, action_type, module, resource_id, resource_name, created_at)
                 VALUES (user_id, action_type, module_name, resource_id, resource_name, NOW());
            END IF;

        ELSIF TG_TABLE_NAME = 'fokus_riset' THEN
             IF NEW.bidang IS DISTINCT FROM OLD.bidang THEN
                 action_type := 'update';
                 user_id := NEW.id_editor;
                 resource_id := NEW.id_fokus; 
                 resource_name := NEW.bidang;

                 INSERT INTO activity_logs (user_id, action_type, module, resource_id, resource_name, created_at)
                 VALUES (user_id, action_type, module_name, resource_id, resource_name, NOW());
             END IF;
        END IF;

        RETURN NEW;
    END IF;

    RETURN NULL;
END;
$$ LANGUAGE plpgsql;


-- 7. Apply Triggers to Tables
-- Drop existing stats triggers first to be clean (re-adding them below)
DROP TRIGGER IF EXISTS trg_refresh_stats_berita ON berita;
DROP TRIGGER IF EXISTS trg_refresh_stats_galeri ON galeri;
DROP TRIGGER IF EXISTS trg_refresh_stats_publikasi ON publikasi;
DROP TRIGGER IF EXISTS trg_refresh_stats_kegiatan ON kegiatan;
DROP TRIGGER IF EXISTS trg_refresh_stats_perkuliahan ON perkuliahan;
DROP TRIGGER IF EXISTS trg_refresh_stats_fokus ON fokus_riset;

-- Re-create Stats Triggers
CREATE TRIGGER trg_refresh_stats_berita
AFTER INSERT OR UPDATE OR DELETE ON berita
FOR EACH STATEMENT
EXECUTE FUNCTION trigger_refresh_dashboard_stats();

CREATE TRIGGER trg_refresh_stats_galeri
AFTER INSERT OR UPDATE OR DELETE ON galeri
FOR EACH STATEMENT
EXECUTE FUNCTION trigger_refresh_dashboard_stats();

CREATE TRIGGER trg_refresh_stats_publikasi
AFTER INSERT OR UPDATE OR DELETE ON publikasi
FOR EACH STATEMENT
EXECUTE FUNCTION trigger_refresh_dashboard_stats();

CREATE TRIGGER trg_refresh_stats_kegiatan
AFTER INSERT OR UPDATE OR DELETE ON kegiatan
FOR EACH STATEMENT
EXECUTE FUNCTION trigger_refresh_dashboard_stats();

CREATE TRIGGER trg_refresh_stats_perkuliahan
AFTER INSERT OR UPDATE OR DELETE ON perkuliahan
FOR EACH STATEMENT
EXECUTE FUNCTION trigger_refresh_dashboard_stats();

CREATE TRIGGER trg_refresh_stats_fokus
AFTER INSERT OR UPDATE OR DELETE ON fokus_riset
FOR EACH STATEMENT
EXECUTE FUNCTION trigger_refresh_dashboard_stats();


-- Create Logging Triggers (Row Level)
CREATE OR REPLACE TRIGGER trg_log_berita
AFTER INSERT OR UPDATE ON berita
FOR EACH ROW EXECUTE FUNCTION log_activity_trigger();

CREATE OR REPLACE TRIGGER trg_log_galeri
AFTER INSERT OR UPDATE ON galeri
FOR EACH ROW EXECUTE FUNCTION log_activity_trigger();

CREATE OR REPLACE TRIGGER trg_log_publikasi
AFTER INSERT OR UPDATE ON publikasi
FOR EACH ROW EXECUTE FUNCTION log_activity_trigger();

CREATE OR REPLACE TRIGGER trg_log_kegiatan
AFTER INSERT OR UPDATE ON kegiatan
FOR EACH ROW EXECUTE FUNCTION log_activity_trigger();

CREATE OR REPLACE TRIGGER trg_log_perkuliahan
AFTER INSERT OR UPDATE ON perkuliahan
FOR EACH ROW EXECUTE FUNCTION log_activity_trigger();

CREATE OR REPLACE TRIGGER trg_log_fokus
AFTER INSERT OR UPDATE ON fokus_riset
FOR EACH ROW EXECUTE FUNCTION log_activity_trigger();

CREATE OR REPLACE TRIGGER trg_log_fasilitas
AFTER INSERT OR UPDATE ON fasilitas
FOR EACH ROW EXECUTE FUNCTION log_activity_trigger();

CREATE OR REPLACE TRIGGER trg_log_info_lab
AFTER INSERT OR UPDATE ON info_lab
FOR EACH ROW EXECUTE FUNCTION log_activity_trigger();

CREATE OR REPLACE TRIGGER trg_log_profil_lab
AFTER INSERT OR UPDATE ON profil_lab
FOR EACH ROW EXECUTE FUNCTION log_activity_trigger();


-- 8. Function to Get Operator Stats
CREATE OR REPLACE FUNCTION get_operator_stats(user_id INT)
RETURNS TABLE (
    my_contributions BIGINT,
    my_pending BIGINT
)
LANGUAGE plpgsql
AS $$
BEGIN
    RETURN QUERY SELECT
    (
        (SELECT COUNT(*) FROM berita WHERE id_penulis = user_id AND status = 'approved') +
        (SELECT COUNT(*) FROM galeri WHERE id_uploader = user_id AND status = 'approved') +
        (SELECT COUNT(*) FROM publikasi WHERE id_anggota = user_id AND status = 'approved') +
        (SELECT COUNT(*) FROM kegiatan WHERE id_penulis = user_id AND status = 'approved') +
        (SELECT COUNT(*) FROM perkuliahan WHERE id_penulis = user_id AND status = 'approved') +
        (SELECT COUNT(*) FROM fokus_riset WHERE id_penulis = user_id AND status = 'approved')
    ) as my_contributions,
    (
        (SELECT COUNT(*) FROM berita WHERE id_penulis = user_id AND status = 'pending') +
        (SELECT COUNT(*) FROM galeri WHERE id_uploader = user_id AND status = 'pending') +
        (SELECT COUNT(*) FROM publikasi WHERE id_anggota = user_id AND status = 'pending') +
        (SELECT COUNT(*) FROM kegiatan WHERE id_penulis = user_id AND status = 'pending') +
        (SELECT COUNT(*) FROM perkuliahan WHERE id_penulis = user_id AND status = 'pending') +
        (SELECT COUNT(*) FROM fokus_riset WHERE id_penulis = user_id AND status = 'pending')
    ) as my_pending;
END;
$$;

