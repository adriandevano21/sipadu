<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tasks extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('logged_in')) {
        } else {
            redirect('login');
        }
        
        $this->load->model('task_model');
        $this->load->model('project_model');
        $this->load->model('master_model');
        $this->load->library('form_validation');
    }

    public function index($project_id) {
        $data['projects'] = $this->task_model->get_projects();
        $data['project_id'] = $project_id;
        $data['employees'] = $this->task_model->get_employees();
        $data['judul'] = 'Project';
        $this->load->vars($data);
        $this->template->load('template/template', 'tasks/index');
        // $this->load->view('tasks/index', $data);
    }
    
    public function view($project_id) {
        $data['projects'] = $this->task_model->get_projects();
        $data['project_id'] = $project_id;
        $data['project'] = $this->project_model->get_project($project_id);
        $data['judul'] = 'Project';
        $data['employees'] = $this->task_model->get_employees();
        $this->load->vars($data);
        $this->template->load('template/template', 'tasks/index');
        // $this->load->view('tasks/index', $data);
    }

    public function get_tasks($project_id) {
        $tasks = $this->task_model->get_tasks($project_id);
        echo json_encode($tasks);
    }

    public function add_task() {
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('project_id', 'Project', 'required');
        $this->form_validation->set_rules('status_id', 'Status', 'required');

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 'error', 'message' => validation_errors()]);
        } else {
            $data = [
                'title' => $this->input->post('title'),
                'description' => $this->input->post('description'),
                'project_id' => $this->input->post('project_id'),
                'status_id' => $this->input->post('status_id'),
                'employee_id' => $this->input->post('employee_id'),
                'start_date' => $this->input->post('start_date'),
                'end_date' => $this->input->post('end_date'),
                'progress' => $this->input->post('progress'),
                'priority' => $this->input->post('priority'),
                'created_by' => $this->session->userdata('username')
            ];
            $task_id = $this->task_model->add_task($data);
            $cek = $this->kirim_notif($task_id);
            if(empty($cek)) {
                echo json_encode(['status' => 'success', 'task_id' => $task_id]);    
            } else {
                echo json_encode(['status' => 'failed', 'task_id' => $task_id]);
            }
            
        }
    }

    public function update_task_status() {
        $task_id = $this->input->post('task_id');
        $new_status_id = $this->input->post('new_status_id');
        $result = $this->task_model->update_task($task_id, ['status_id' => $new_status_id]);
        echo json_encode(['status' => $result ? 'success' : 'error']);
    }

    public function get_employees() {
        $employees = $this->task_model->get_employees();
        echo json_encode($employees);
    }

    public function edit_task() {
        $task_id = $this->input->post('task_id');
        $data = [
            'title' => $this->input->post('title'),
            'description' => $this->input->post('description'),
            'employee_id' => $this->input->post('employee_id'),
            'start_date' => $this->input->post('start_date'),
            'end_date' => $this->input->post('end_date'),
            'progress' => $this->input->post('progress'),
            'priority' => $this->input->post('priority'),
            'created_by' => $this->session->userdata('username')
        ];
        $result = $this->task_model->update_task($task_id, $data);
        echo json_encode(['status' => $result ? 'success' : 'error']);
    }

    public function delete_task() {
        $task_id = $this->input->post('task_id');
        $result = $this->task_model->delete_task($task_id);
        echo json_encode(['status' => $result ? 'success' : 'error']);
    }

    public function get_task($id) {
        $task = $this->task_model->get_task($id);
        echo json_encode($task);
    }
    public function kirim_notif($id)
      {
         $task = $this->task_model->get_task($id);
        
         $param = [
            "pesan" => "*Pemberitahuan Projek*
    
    Yth. $task->nama_pegawai
    Dengan ini saudara/i mendapatkan tugas dengan detail:
    
    Projek : $task->project_name
    Tugas : $task->title
    Tanggal : $task->start_date s.d $task->end_date
    
    Demikian untuk dilaksanakan, atas perhatian dan kerjasamanya diucapkan terima kasih
    ",
            "no_wa" => $task->no_wa,
            
          ];
          //   print_r($param);
          //   echo "<br>";
        //   return send($param);
           return $this->send($param);
        
      }
    public function send($params)
  {
    try {
      $dataSending = array();
      $dataSending["api_key"] = "59N5INDJF6I683Z4";
      $dataSending["number_key"] = "W4VNFb2ffPlQihxt";
      $dataSending["phone_no"] = $params["no_wa"];
      $dataSending["message"] = $params["pesan"];
      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.watzap.id/v1/send_message',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode($dataSending),
        CURLOPT_HTTPHEADER => array(
          'Content-Type: application/json'
        ),
      ));
      $response = curl_exec($curl);
      curl_close($curl);
      // echo $response;

      $response = json_decode($response);
      //   print_r($response);
      //   exit;

      if (!empty($response->worker_by)) {
        $insert_params = [

          "status" => $response->status,
          "message" => $response->message,
          "worker_by" => $response->worker_by,
          "ack" => $response->ack,
          "no_wa" => $params['no_wa'],
          "ket" => "tambah project"

        ];
        
        $this->master_model->insert("status_watzap", $insert_params);
      } else {
          return $response->message;
        // $this->session->set_flashdata('gagal', "Data yg anda masukan berhasil tetapi tidak berhasil kirim notif WA, silahkan hubungi admin $response->message");
        // redirect('project');
      }
    } catch (Exception $e) {
    //   print_r($e);
    }
  }
}