<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model('Auth_model');
		$this->load->library(['form_validation', 'session']);
		$this->load->helper(['url', 'form']);
	}

	public function index()
	{
		$this->load->view('auth/index');
	}

	public function login()
	{
		if ($this->input->method() !== 'post') {
			show_error('Invalid request method', 404);
			return;
		}


		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('identity', 'Email / Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('captcha', 'Captcha', 'required');

		if ($this->form_validation->run() == FALSE) {
			echo json_encode([
				'status' => 'error',
				'message' => validation_errors()
			]);
			return;
		}

		$attempt = $this->session->userdata('login_attempt') ?? 0;

		if ($attempt >= 5) {
			echo json_encode([
				'status' => 'error',
				'message' => 'Terlalu banyak percobaan login!'
			]);
			return;
		}

		$captcha_input = trim($this->input->post('captcha'));
		$captcha_session = (string) $this->session->userdata('captcha_code');

		if ($captcha_input !== $captcha_session) {

			$this->session->set_userdata('login_attempt', $attempt + 1);

			echo json_encode([
				'status' => 'error',
				'message' => 'Captcha salah!'
			]);
			return;
		}

		$identity = $this->input->post('identity', TRUE);
		$password = $this->input->post('password', TRUE);

		if (filter_var($identity, FILTER_VALIDATE_EMAIL)) {
			$user = $this->Auth_model->check_login_by_email($identity);
		} else {
			$user = $this->Auth_model->check_login_by_username($identity);
		}

		if ($user && password_verify($password, $user->password)) {

			$this->session->unset_userdata('login_attempt');

			$this->session->set_userdata([
				'id_user'   => $user->id_user,
				'nama'      => $user->nama,
				'role'      => $user->id_role,
				'logged_in' => TRUE
			]);

			echo json_encode([
				'status' => 'success',
				'message' => 'Berhasil masuk',
				'redirect' => base_url('dashboard')
			]);
		} else {

			$this->session->set_userdata('login_attempt', $attempt + 1);

			echo json_encode([
				'status' => 'error',
				'message' => 'Username / Password salah!'
			]);
		}
	}

	public function logout()
	{
		if (!$this->session->userdata('logged_in')) {
			redirect('auth');
			return;
		}

		$this->session->set_flashdata('success', 'Berhasil keluar');
		$this->session->sess_destroy();

		redirect('auth');
	}

	// Generate captcha sederhana
	public function generate_captcha()
	{

		$angka1 = rand(1, 9);
		$angka2 = rand(1, 9);

		$this->session->set_userdata('captcha_code', $angka1 + $angka2);

		echo json_encode([
			'captcha_text' => "$angka1 + $angka2 = ?"
		]);
	}
}
