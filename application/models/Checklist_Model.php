<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Checklist_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // Semua template aktif
    public function get_all_templates()
    {
        return $this->db->where('is_active', 1)->order_by('kode')->get('checklist_template')->result();
    }

    // Template by jenis_unit (mapping dari jenis_kendaraan)
    public function get_template_by_jenis($jenis_unit)
    {
        return $this->db->where('jenis_unit', $jenis_unit)->where('is_active', 1)->get('checklist_template')->row();
    }

    // Template by id
    public function get_template($id)
    {
        return $this->db->where('id_template', $id)->get('checklist_template')->row();
    }

    // Items by template, dikelompokkan per kategori
    public function get_items($id_template)
    {
        return $this->db
            ->where('id_template', $id_template)
            ->order_by('kategori DESC') // CRITICAL dulu
            ->order_by('CAST(no_urut AS UNSIGNED)', 'ASC', FALSE)
            ->get('checklist_item')
            ->result();
    }

    // Simpan jawaban checklist (bulk insert/update)
    public function save_checklist($id_uji, $items)
    {
        // Hapus jawaban lama dulu
        $this->db->where('id_uji', $id_uji)->delete('uji_checklist');

        if (empty($items)) return true;

        $batch = [];
        foreach ($items as $id_item => $val) {
            $batch[] = [
                'id_uji'     => $id_uji,
                'id_item'    => (int) $id_item,
                'hasil'      => in_array($val['hasil'], ['yes', 'no', 'na']) ? $val['hasil'] : 'na',
                'keterangan' => isset($val['keterangan']) ? trim($val['keterangan']) : '',
            ];
        }
        return $this->db->insert_batch('uji_checklist', $batch);
    }

    // Get jawaban checklist by id_uji
    public function get_checklist_answers($id_uji)
    {
        $this->db->select('uc.*, ci.kriteria, ci.kategori, ci.no_urut, ct.nama_template');
        $this->db->from('uji_checklist uc');
        $this->db->join('checklist_item ci',    'ci.id_item = uc.id_item');
        $this->db->join('checklist_template ct', 'ct.id_template = ci.id_template');
        $this->db->where('uc.id_uji', $id_uji);
        $this->db->order_by('ci.kategori DESC');
        $this->db->order_by('CAST(ci.no_urut AS UNSIGNED)', 'ASC', FALSE);
        return $this->db->get()->result();
    }

    // Hitung statistik hasil checklist
    public function get_summary($id_uji)
    {
        $rows = $this->get_checklist_answers($id_uji);
        $summary = [
            'total'    => count($rows),
            'yes'      => 0,
            'no' => 0,
            'na' => 0,
            'critical_no' => 0,
        ];
        foreach ($rows as $r) {
            $summary[$r->hasil]++;
            if ($r->hasil === 'no' && $r->kategori === 'CRITICAL') {
                $summary['critical_no']++;
            }
        }
        // Lulus jika: semua critical = YES dan tidak ada CRITICAL yang NO
        $summary['lulus'] = $summary['critical_no'] === 0;
        return $summary;
    }

    // CRUD Template (untuk halaman Checklist Template admin)
    public function update_template($id, $data)
    {
        $this->db->where('id_template', $id);
        return $this->db->update('checklist_template', $data);
    }

    // CRUD Items
    public function insert_item($data)
    {
        $this->db->insert('checklist_item', $data);
        return $this->db->insert_id();
    }

    public function update_item($id, $data)
    {
        $this->db->where('id_item', $id);
        return $this->db->update('checklist_item', $data);
    }

    public function delete_item($id)
    {
        $this->db->where('id_item', $id);
        return $this->db->delete('checklist_item');
    }

    public function get_item($id)
    {
        return $this->db->where('id_item', $id)->get('checklist_item')->row();
    }

    // Mapping jenis_kendaraan → jenis_unit template
    public static function map_jenis($jenis_kendaraan)
    {
        $map = [
            'Light Vehicle'   => 'Light Vehicle',
            'Light Truck'     => 'Light Truck',
            'Bus'             => 'Bus',
            'Bus Manhaul'     => 'Bus Manhaul',
            'Fuel Truck'      => 'Fuel Truck',
            'Dump Truck'      => 'Dump Truck',
            'Crane Truck'     => 'Crane Truck',
            'ADT'             => 'ADT',
            'Articulated Truck' => 'ADT',
            'Haul Truck'      => 'Haul Truck',
            'Forklift'        => 'Forklift',
            'Excavator'       => 'Excavator',
            'Compactor'       => 'Compactor',
            'Motor Grader'    => 'Motor Grader',
            'Wheel Loader'    => 'Wheel Loader',
            'Bulldozer'       => 'Bulldozer',
            'Crawler'         => 'Crawler',
            'Drill Rig'       => 'Drill Rig',
            'Jumbo'           => 'Jumbo',
            'Genset'          => 'Equipment Support',
            'Compressor'      => 'Equipment Support',
            'Lighting Plant'  => 'Equipment Support',
            'Pump'            => 'Equipment Support',
            'Equipment Support' => 'Equipment Support',
            'Water Truck'     => 'Fuel Truck', // closest match
        ];
        return isset($map[$jenis_kendaraan]) ? $map[$jenis_kendaraan] : null;
    }
}
