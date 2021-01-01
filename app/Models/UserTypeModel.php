<?php  

use CodeIgniter\Model;

class UserTypeModel extends Model {
    protected $table = 'user_type';
    protected $useSoftDeletes = true;
    protected $primaryKey = 'id';
    protected $allowedFields = ['type'];
    protected $useTimestamps = true;
}

?>