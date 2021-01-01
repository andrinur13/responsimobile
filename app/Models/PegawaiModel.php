<?php  

use CodeIgniter\Model;

class PegawaiModel extends Model {
    protected $table = 'pegawai';
    protected $useSoftDeletes = true;
    protected $primaryKey = 'id';
    protected $allowedFields = ['email', 'name', 'alamat'];
    protected $useTimestamps = true;
}

?>