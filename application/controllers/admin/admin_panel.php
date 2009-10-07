<?php

require_once "application/classes/Process.php";

/**
 * Description of admin_panel
 *
 * @property page_decorator $page_decorator
 *
 * @author Trieu Nguyen. Email: tantrieuf31@gmail.com
 */
class admin_panel extends Controller {
    public function __construct() {
        parent::Controller();
    }


    /**
     * @Decorated
     */
    public function index() {
        $data = "Admin panel";
        $this->output->set_output($data);
    //    $this->load->view("admin/left_menu_bar",NULL);

    }

    /**
     * @Decorated
     */
    public function add_new_process() {
        $this->load->model("process_manager");
        $data = $this->process_manager->get_dependency_instances();
        $data["action_uri"] = "admin/admin_panel/save_object/Process";
        $this->load->view("form/form_view",$data);
    }

    /** @Decorated */
    public function save_object($object_name) {
        if($object_name == "Process") {
            $pro = new Process();
            $pro->setProcessID($this->input->post("ProcessID"));
            $pro->setGroupID($this->input->post("GroupID"));
            $pro->setProcessName($this->input->post("ProcessName"));

            $this->load->model("process_manager");
            $this->process_manager->save($pro);
        }
        $this->output->set_output("Save ".$object_name." successfully!");
    }

    /**
     * @Decorated
     */
    public function list_processes($id = "all") {
        $this->load->model("process_manager");
        $filter = array();
        if(is_numeric($id)) {
            $filter = array("ProcessID"=>$id);
        }
        $processses = $this->process_manager->find_by_filter($filter);
        $data_table = $this->class_mapper->DataListToDataTable("Process",$processses);


        //echo $pro->getProcessName()." == ";
        $this->load->library('table');


        $this->table->set_template($this->table_template);
        $this->table->set_heading(array('ProcessID', 'GroupID', 'ProcessName'));
        $view =  $this->table->generate($data_table);

        $this->output->set_output($view);
    }




    /**
     * EndsWith
     * Tests whether a text ends with the given
     * string or not.
     *
     * @param     string
     * @param     string
     * @return    bool
     */
    private function EndsWith($Haystack, $Needle) {
        return strrpos($Haystack, $Needle) === strlen($Haystack)-strlen($Needle);
    }

    protected $table_template = array (
    'table_open'          => '<table border="1" cellpadding="4" cellspacing="0">',

    'heading_row_start'   => '<tr>',
    'heading_row_end'     => '</tr>',
    'heading_cell_start'  => '<th>',
    'heading_cell_end'    => '</th>',

    'row_start'           => '<tr>',
    'row_end'             => '</tr>',
    'cell_start'          => '<td>',
    'cell_end'            => '</td>',

    'row_alt_start'       => '<tr>',
    'row_alt_end'         => '</tr>',
    'cell_alt_start'      => '<td>',
    'cell_alt_end'        => '</td>',

    'table_close'         => '</table>'
    );
}
?>
