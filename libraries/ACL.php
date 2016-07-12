<?php
/**
 * ACL Class
 *.
 * @package
 * @subpackage
 * @category
 * @author Sanjeeb Rao
 */
class ACL {
    private $table_name = 'role_privilege';
    private $db_obj = NULL;

    /**
     * Initialization of Database object.
     *
     * @access public constructor of ACL
     * @param  object db_object
     */
    public function __construct($db_object)
    {
        $this->db_obj = $db_object;
    }

    /**
     * Get resource and privileges of given role id .
     *
     * @access public  get_privilege
     * @param  integer role_id
     * @return array
     */
    public function get_privilege($role_id)
    {
        $resource_privileges = array();
        $value = 'privilege.name AS privilege, resources.name AS resource';
        $condition = "JOIN resources
            ON role_privilege.resource_id = resources.id
            JOIN privilege
            ON  role_privilege.privilege_id = privilege.id
            WHERE role_privilege.role_id = $role_id";

        $result = $this->db_obj->select($this->table_name, $value, $condition);

        while($row = mysqli_fetch_assoc($result))
        {
            $resource_privileges[$row['resource']][] = $row['privilege'];
        }
        return $resource_privileges;
    }

    public function is_allowed($resource, $privilege)
    {
        if( isset($_SESSION['acl'][$resource]) && in_array($privilege, $_SESSION['acl'][$resource]))
        {
            return TRUE;
        }

        return FALSE;
    }
}