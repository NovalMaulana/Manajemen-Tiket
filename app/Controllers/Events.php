<?php

namespace App\Controllers;

use App\Models\EventModel;
use App\Models\TicketModel;

class Events extends BaseController
{
    protected $eventModel;
    protected $ticketModel;

    public function __construct()
    {
        $this->eventModel = new EventModel();
        $this->ticketModel = new TicketModel();
    }

    public function index()
    {
        // Check if user has permission
        if (!in_array(session()->get('role_name'), ['admin', 'event_organizer'])) {
            return redirect()->to('dashboard')->with('error', 'Akses ditolak. Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        $role = session()->get('role_name');
        $userId = session()->get('user_id');

        // Filter events based on role
        if ($role === 'admin') {
            $events = $this->eventModel->getEventsWithStats();
        } else {
            // For event organizer, only show their own events
            $events = $this->eventModel->getEventsWithStatsByOrganizer($userId);
        }

        $data = [
            'title' => 'Manajemen Event',
            'events' => $events
        ];

        return view('events/index', $data);
    }

    public function create()
    {
        // Check if user has permission
        if (!in_array(session()->get('role_name'), ['admin', 'event_organizer'])) {
            return redirect()->to('dashboard')->with('error', 'Akses ditolak. Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        $data = [
            'title' => 'Tambah Event'
        ];

        return view('events/create', $data);
    }

    public function store()
    {
        // Check if user has permission
        if (!in_array(session()->get('role_name'), ['admin', 'event_organizer'])) {
            return redirect()->to('dashboard')->with('error', 'Akses ditolak. Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        // Validation rules
        $rules = [
            'title' => 'required|min_length[3]|max_length[200]',
            'description' => 'required|min_length[10]',
            'event_date' => 'required|valid_date',
            'event_time' => 'required',
            'location' => 'required|min_length[5]|max_length[200]',
            'capacity' => 'required|numeric|greater_than[0]',
            'ticket_price' => 'required|numeric|greater_than_equal_to[0]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // Check if event date is not in the past
        $eventDate = $this->request->getPost('event_date') . ' ' . $this->request->getPost('event_time');
        if (strtotime($eventDate) <= time()) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Tanggal dan waktu event tidak boleh di masa lalu.');
        }



        // Prepare data
        $data = [
            'event_name' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'event_date' => $this->request->getPost('event_date'),
            'event_time' => $this->request->getPost('event_time'),
            'venue' => $this->request->getPost('location'),
            'total_tickets' => $this->request->getPost('capacity'),
            'available_tickets' => $this->request->getPost('capacity'),
            'price' => $this->request->getPost('ticket_price'),
            'created_by' => session()->get('user_id')
        ];
        
        // Debug: Check if user_id exists
        if (!session()->get('user_id')) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'User ID tidak ditemukan dalam session');
        }

        // Try to insert without validation first
        try {
            // Disable validation temporarily
            $this->eventModel->setValidationRules([]);
            
            // Try direct database insert
            $db = \Config\Database::connect();
            $builder = $db->table('events');
            
            $result = $builder->insert($data);
            if ($result) {
                return redirect()->to('events')->with('success', 'Event berhasil ditambahkan.');
            } else {
                $errorMessage = 'Terjadi kesalahan saat menyimpan event.';
                
                return redirect()->back()
                    ->withInput()
                    ->with('error', $errorMessage);
            }
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Exception: ' . $e->getMessage());
        }
    }

    public function view($id = null)
    {
        // Check if user has permission
        if (!in_array(session()->get('role_name'), ['admin', 'event_organizer'])) {
            return redirect()->to('dashboard')->with('error', 'Akses ditolak. Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        $event = $this->eventModel->getEventWithOrganizer($id);
        if (!$event) {
            return redirect()->to('events')->with('error', 'Event tidak ditemukan.');
        }

        // Check if user is the organizer or admin
        if (session()->get('role_name') !== 'admin' && $event['created_by'] != session()->get('user_id')) {
            return redirect()->to('events')->with('error', 'Anda hanya dapat melihat event yang Anda buat.');
        }

        $data = [
            'title' => 'Detail Event',
            'event' => $event,
            'tickets' => $this->ticketModel->getTicketsByEvent($id)
        ];

        return view('events/view', $data);
    }

    public function edit($id = null)
    {
        // Check if user has permission
        if (!in_array(session()->get('role_name'), ['admin', 'event_organizer'])) {
            return redirect()->to('dashboard')->with('error', 'Akses ditolak. Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        $event = $this->eventModel->find($id);
        if (!$event) {
            return redirect()->to('events')->with('error', 'Event tidak ditemukan.');
        }

        // Check if user is the organizer or admin
        if (session()->get('role_name') !== 'admin' && $event['created_by'] != session()->get('user_id')) {
            return redirect()->to('events')->with('error', 'Anda hanya dapat mengedit event yang Anda buat.');
        }

        $data = [
            'title' => 'Edit Event',
            'event' => $event
        ];

        return view('events/edit', $data);
    }

    public function update($id = null)
    {
        // Check if user has permission
        if (!in_array(session()->get('role_name'), ['admin', 'event_organizer'])) {
            return redirect()->to('dashboard')->with('error', 'Akses ditolak. Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        $event = $this->eventModel->find($id);
        if (!$event) {
            return redirect()->to('events')->with('error', 'Event tidak ditemukan.');
        }

        // Check if user is the organizer or admin
        if (session()->get('role_name') !== 'admin' && $event['created_by'] != session()->get('user_id')) {
            return redirect()->to('events')->with('error', 'Anda hanya dapat mengedit event yang Anda buat.');
        }

        // Validation rules
        $rules = [
            'title' => 'required|min_length[3]|max_length[200]',
            'description' => 'required|min_length[10]',
            'event_date' => 'required|valid_date',
            'event_time' => 'required',
            'location' => 'required|min_length[5]|max_length[200]',
            'capacity' => 'required|numeric|greater_than[0]',
            'ticket_price' => 'required|numeric|greater_than_equal_to[0]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // Check if event date is not in the past
        $eventDate = $this->request->getPost('event_date') . ' ' . $this->request->getPost('event_time');
        if (strtotime($eventDate) <= time()) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Tanggal dan waktu event tidak boleh di masa lalu.');
        }



        // Prepare data
        $data = [
            'event_name' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'event_date' => $this->request->getPost('event_date'),
            'event_time' => $this->request->getPost('event_time'),
            'venue' => $this->request->getPost('location'),
            'total_tickets' => $this->request->getPost('capacity'),
            'price' => $this->request->getPost('ticket_price')
        ];

        // Update event
        if ($this->eventModel->update($id, $data)) {
            return redirect()->to('events')->with('success', 'Event berhasil diupdate.');
        } else {
            // Debug: Get validation errors
            $errors = $this->eventModel->errors();
            $errorMessage = 'Terjadi kesalahan saat mengupdate event.';
            if (!empty($errors)) {
                $errorMessage .= ' Errors: ' . implode(', ', $errors);
            }
            
            return redirect()->back()
                ->withInput()
                ->with('error', $errorMessage);
        }
    }

    public function delete($id = null)
    {
        // Check if user has permission
        if (!in_array(session()->get('role_name'), ['admin', 'event_organizer'])) {
            return redirect()->to('dashboard')->with('error', 'Akses ditolak. Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        $event = $this->eventModel->find($id);
        if (!$event) {
            return redirect()->to('events')->with('error', 'Event tidak ditemukan.');
        }

        // Check if user is the organizer or admin
        if (session()->get('role_name') !== 'admin' && $event['created_by'] != session()->get('user_id')) {
            return redirect()->to('events')->with('error', 'Anda hanya dapat menghapus event yang Anda buat.');
        }

        // Check if event has sold tickets
        $soldTickets = $this->ticketModel->where('event_id', $id)->countAllResults();
        if ($soldTickets > 0) {
            return redirect()->to('events')->with('error', 'Event tidak dapat dihapus karena sudah ada tiket yang terjual.');
        }



        // Delete event
        if ($this->eventModel->delete($id)) {
            return redirect()->to('events')->with('success', 'Event berhasil dihapus.');
        } else {
            return redirect()->to('events')->with('error', 'Terjadi kesalahan saat menghapus event.');
        }
    }
} 