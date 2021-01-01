<?php

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'user';
    protected $useSoftDeletes = true;
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'name', 'password', 'user_type', 'email'];
    protected $useTimestamps = true;


    public function cariPegawai($username)
    {
        $db = \Config\Database::connect();

        $builder = $db->table('user');

        if($username == null) {
            return null;
        }  else {
            return $builder->getWhere(['username' => $username])->getResultArray();
        }
    }
}
