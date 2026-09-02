-- ============================================================
-- MODUL DIGIMAN - HRMS
-- Jalankan script ini sekali di database `hrms`
-- ============================================================

-- Tabel Jadwal Istirahat
CREATE TABLE IF NOT EXISTS jam_istirahat (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    jam_istirahat TIME NOT NULL,
    hari_istirahat VARCHAR(20) NOT NULL,
    created_at DATETIME NULL,
    updated_at DATETIME NULL,
    deleted_at DATETIME NULL,
    INDEX idx_hari_istirahat (hari_istirahat)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabel Video Digiman
CREATE TABLE IF NOT EXISTS digiman_video (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    video VARCHAR(255) NOT NULL,
    status ENUM('aktif','non-aktif') DEFAULT 'aktif',
    created_at DATETIME NULL,
    updated_at DATETIME NULL,
    deleted_at DATETIME NULL,
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ============================================================
-- Contoh data awal (optional)
-- ============================================================
INSERT INTO jam_istirahat (jam_istirahat, hari_istirahat) VALUES
('10:00:00', 'Senin'),
('12:10:00', 'Senin'),
('15:00:00', 'Senin'),
('10:00:00', 'Selasa'),
('12:10:00', 'Selasa'),
('15:00:00', 'Selasa'),
('10:00:00', 'Rabu'),
('12:10:00', 'Rabu'),
('15:00:00', 'Rabu'),
('10:00:00', 'Kamis'),
('12:10:00', 'Kamis'),
('15:00:00', 'Kamis'),
('10:00:00', 'Jumat'),
('12:10:00', 'Jumat'),
('15:00:00', 'Jumat');
