<?php
defined('BASEPATH') or exit('No direct script access allowed');

// application/controllers/Project.php
class Agenda extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('logged_in')) {
		} else {
			redirect('login');
		}
		$this->load->model('tasks_model');
	}

	public function index()
	{
		// Mengambil semua tasks dari database
		$data['tasks'] = $this->tasks_model->getAllTasks();
		$data['judul'] = 'Agenda';
		$this->load->vars($data);
		$this->template->load('template/template', 'gantt_chart');
	}

	public function addTask()
	{
		$dateString = $this->input->post('start_date');
		$trimmedDate = substr($dateString, 0, 24);
		$timestamp = strtotime($trimmedDate);
		// Ambil data dari AJAX POST
		$taskData = array(
			'text' => $this->input->post('text'),
			'start_date' => date("Y-m-d H:i:s", $timestamp),
			'duration' => $this->input->post('duration'),
			'parent' => $this->input->post('parent'),
			'progress' => $this->input->post('progress'),
			'username' => $this->session->userdata('username'),
			// 'open' => $this->input->post('open')
			// Sesuaikan dengan kolom-kolom yang Anda miliki dalam tabel tasks
		);

		$insertedId = $this->tasks_model->addTask($taskData);

		if ($insertedId) {
			// Task berhasil ditambahkan ke database
			echo json_encode(array('status' => 'success', 'task_id' => $insertedId, 'tanggal' => date("Y-m-d H:i:s", $timestamp)));
		} else {
			// Gagal menambahkan task
			echo json_encode(array('status' => 'error'));
		}
	}

	public function deleteTask()
	{
		// Ambil ID task dari POST
		$task_id = $this->input->post('id');
		// Implementasikan logika untuk menghapus task dari database
		$deletedId = $this->tasks_model->deleteTask($task_id);

		// Jika penghapusan berhasil, kembalikan response
		echo json_encode(array('status' => 'success'));
	}

	public function updateTask()
	{
		// Ambil data dari POST untuk memperbarui task di database
		$id = $this->input->post('id');
		$text = $this->input->post('text');
		$start_date = $this->input->post('start_date');
		$duration = $this->input->post('duration');
		$progress = $this->input->post('progress');
		$parent = $this->input->post('parent');
		$open = $this->input->post('open');

		$dateString = $this->input->post('start_date');
		$trimmedDate = substr($dateString, 0, 24);
		$tanggal = strtotime($trimmedDate);

		// Data yang akan diupdate
		$taskData = array(
			'text' => $text,
			'start_date' => date("Y-m-d H:i:s", $tanggal),
			'duration' => $duration,
			'progress' => $progress,
			'parent' => $parent,
			'open' => $open
		);

		// Implementasikan logika untuk memperbarui task di database
		// Misalnya, menggunakan model untuk melakukan update
		$update = $this->tasks_model->updateTask($id, $taskData);

		// Berikan respons sesuai dengan keberhasilan update
		if ($update) {
			echo json_encode(array('status' => 'success'));
		} else {
			echo json_encode(array('status' => 'error'));
		}
	}
}
