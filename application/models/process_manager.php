<?php
require_once 'application/classes/Process.php';

/**
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property CI_DB_active_record $db
 */
class process_manager extends data_manager {

    public function __construct() {
        parent::__construct();
    }

    public function save($process) {
        if($process->getProcessID() > 0) {
            $this->update($process);
        }
        else {
            $this->insert($process);
        }
    }

    protected function insert($process) {
    }

    protected function update($process) {
    }

    /**
     * @access	public
     * @param	id
     * @return	Process
     */
    public function find_by_id($id) {
        $query = $this->db->get_where("Processes", array('ProcessID' => $id));
        foreach ($query->result_array() as $data_row) {
            $pro = new Process();
            return $pro = $this->class_mapping($data_row, "Process", $pro);
        }
    }


    /**
     * @access	public
     * @param	id
     * @return	array
     */
    public function find_by_filter($filter = array()) {
        $query = $this->db->get_where("Processes", $filter);
        $list = array();
        $idx = 0;
        foreach ($query->result_array() as $data_row) {
            $pro = new Process();
            $list[$idx++] = $this->class_mapping($data_row, "Process", $pro);
        }
        return $list;
    }

    public function delete($process) {
    }

    public function delete_by_id($id) {
    }

}


?>
