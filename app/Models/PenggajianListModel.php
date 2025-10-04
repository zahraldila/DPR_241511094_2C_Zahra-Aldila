<?php
namespace App\Models;

use CodeIgniter\Model;

class PenggajianListModel extends Model
{
    protected $DBGroup = 'default';

    // Konstanta normalisasi ke bulanan
    private const WEEKS_IN_MONTH   = 4.33;
    private const WORKDAYS_IN_MONTH = 22;

    public function rekapBulanan(int $bulan, int $tahun, ?string $q = null): array
    {
        $db = $this->db;

        // multiplier satuan → bulanan (di SQL)
        $mul = "CASE LOWER(kg.satuan)
                    WHEN 'bulanan' THEN 1
                    WHEN 'tahunan' THEN 0.0833333333 /* 1/12 */
                    WHEN 'mingguan' THEN " . self::WEEKS_IN_MONTH . "
                    WHEN 'harian' THEN " . self::WORKDAYS_IN_MONTH . "
                    ELSE 1
                END";

        $builder = $db->table('penggajian p')
            ->select([
                'a.id_anggota',
                'a.gelar_depan',
                'a.nama_depan',
                'a.nama_belakang',
                'a.gelar_belakang',
                'a.status_pernikahan',
                'a.jumlah_anak',
                'j.nama_jabatan',

                // Total plus/minus bulanan
                "COALESCE(SUM(CASE WHEN kg.is_potongan = 0 THEN (pd.nominal * $mul) ELSE 0 END),0) AS total_plus_bulanan",
                "COALESCE(SUM(CASE WHEN kg.is_potongan = 1 THEN (pd.nominal * $mul) ELSE 0 END),0) AS total_minus_bulanan",

                // Gaji pokok (dinormalisasi juga)
                "COALESCE(SUM(CASE WHEN (kg.is_gaji_pokok = 1 OR kg.kode = 'GAJI_POKOK')
                                    THEN (pd.nominal * $mul) ELSE 0 END),0) AS gaji_pokok_bulanan",
            ])
            ->join('penggajian_detail pd', 'pd.id_penggajian = p.id_penggajian', 'left')
            ->join('komponen_gaji kg', 'kg.id_komponen_gaji = pd.id_komponen_gaji', 'left')
            ->join('anggota a', 'a.id_anggota = p.id_anggota')
            ->join('jabatan j', 'j.id_jabatan = a.id_jabatan', 'left')
            ->where('p.bulan', $bulan)
            ->where('p.tahun', $tahun)
            ->groupBy('a.id_anggota');

        // Search dasar (tanpa THP dulu)
        if ($q) {
            $q = trim($q);
            $builder->groupStart()
                ->like('a.id_anggota', $q)
                ->orLike('a.gelar_depan', $q)
                ->orLike('a.nama_depan', $q)
                ->orLike('a.nama_belakang', $q)
                ->orLike('a.gelar_belakang', $q)
                ->orLike('j.nama_jabatan', $q)
            ->groupEnd();
        }

        $rows = $builder->orderBy('a.id_anggota', 'ASC')->get()->getResultArray();

        return $rows;
    }

    public function detailPenggajian(int $idPenggajian): array
    {
        $db = $this->db;

        $header = $db->table('penggajian p')
            ->select('p.*, a.id_anggota, a.gelar_depan, a.nama_depan, a.nama_belakang, a.gelar_belakang, a.status_pernikahan, a.jumlah_anak, j.nama_jabatan')
            ->join('anggota a', 'a.id_anggota = p.id_anggota')
            ->join('jabatan j', 'j.id_jabatan = a.id_jabatan', 'left')
            ->where('p.id_penggajian', $idPenggajian)
            ->get()->getRowArray();

        $detail = $db->table('penggajian_detail pd')
            ->select('pd.id_detail, kg.nama_komponen, kg.kode, kg.kategori, kg.satuan, kg.is_potongan, kg.is_gaji_pokok, pd.nominal')
            ->join('komponen_gaji kg', 'kg.id_komponen_gaji = pd.id_komponen_gaji')
            ->where('pd.id_penggajian', $idPenggajian)
            ->orderBy('kg.nama_komponen', 'ASC')
            ->get()->getResultArray();

        return ['header' => $header, 'detail' => $detail];
    }
}
