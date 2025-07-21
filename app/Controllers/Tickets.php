<?php

namespace App\Controllers;

use App\Models\TicketModel;
use App\Models\EventModel;

class Tickets extends BaseController
{
    protected $ticketModel;
    protected $eventModel;

    public function __construct()
    {
        $this->ticketModel = new TicketModel();
        $this->eventModel = new EventModel();
    }

    public function myTickets()
    {
        // Check if user has permission (allow all logged in users)
        if (!session()->get('logged_in')) {
            return redirect()->to('dashboard')->with('error', 'Silakan login terlebih dahulu.');
        }

        $userId = session()->get('user_id');
        $data = [
            'title' => 'Tiket Saya',
            'tickets' => $this->ticketModel->getUserTickets($userId)
        ];

        return view('tickets/my_tickets', $data);
    }

    public function soldTickets()
    {
        // Check if user has permission
        $roleName = session()->get('role_name');
        $userId = session()->get('user_id');
        
        // Temporary: Allow all logged in users to access this page
        if (!session()->get('logged_in')) {
            return redirect()->to('dashboard')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Filter tickets based on role
        if ($roleName === 'admin') {
            $tickets = $this->ticketModel->getAllSoldTickets();
        } else {
            // For event organizer, only show tickets for their events
            $tickets = $this->ticketModel->getSoldTicketsByOrganizer($userId);
        }

        $data = [
            'title' => 'Tiket Terjual',
            'tickets' => $tickets
        ];

        return view('tickets/sold_tickets', $data);
    }



    public function buy($eventId = null)
    {
        // Check if user has permission (allow all logged in users)
        if (!session()->get('logged_in')) {
            return redirect()->to('dashboard')->with('error', 'Silakan login terlebih dahulu.');
        }

        $event = $this->eventModel->find($eventId);
        if (!$event) {
            return redirect()->to('dashboard')->with('error', 'Event tidak ditemukan.');
        }

        // Check if event is still available
        if ($event['available_tickets'] <= 0) {
            return redirect()->to('dashboard')->with('error', 'Tiket untuk event ini sudah habis.');
        }

        $data = [
            'title' => 'Beli Tiket',
            'event' => $event
        ];

        return view('tickets/buy', $data);
    }

    public function purchase($eventId = null)
    {
        // Check if user has permission (allow all logged in users)
        if (!session()->get('logged_in')) {
            return redirect()->to('dashboard')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Validation temporarily disabled for debugging
        // $rules = [
        //     'quantity' => 'required|numeric|greater_than[0]'
        // ];

        // if (!$this->validate($rules)) {
        //     return redirect()->back()
        //         ->withInput()
        //         ->with('errors', $this->validator->getErrors());
        // }

        $event = $this->eventModel->find($eventId);
        if (!$event) {
            return redirect()->to('dashboard')->with('error', 'Event tidak ditemukan.');
        }

        $quantity = $this->request->getPost('quantity');
        
        // Debug: Check event data
        log_message('debug', 'Event data: ' . json_encode($event));
        log_message('debug', 'Quantity: ' . $quantity);
        log_message('debug', 'User ID: ' . session()->get('user_id'));
        
        // Quantity validation temporarily disabled for debugging
        // if ($quantity > $event['available_tickets']) {
        //     return redirect()->back()
        //         ->withInput()
        //         ->with('error', 'Jumlah tiket yang diminta melebihi tiket yang tersedia.');
        // }

        // Calculate total price
        $totalPrice = $quantity * $event['price'];

        // Prepare ticket data
        $ticketData = [
            'event_id' => $eventId,
            'user_id' => session()->get('user_id'),
            'quantity' => $quantity,
            'total_price' => $totalPrice,
            'status' => 'pending'
        ];

        // Debug: Check if user_id exists
        if (!session()->get('user_id')) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'User ID tidak ditemukan dalam session');
        }

        // Try to insert ticket
        try {
            // Disable validation temporarily
            $this->ticketModel->setValidationRules([]);
            
            // Debug: Log ticket data
            log_message('debug', 'Ticket data to insert: ' . json_encode($ticketData));
            
            // Try direct database insert
            $db = \Config\Database::connect();
            $builder = $db->table('tickets');
            
            $result = $builder->insert($ticketData);
            if ($result) {
                // Update available tickets
                $newAvailable = $event['available_tickets'] - $quantity;
                $this->eventModel->update($eventId, ['available_tickets' => $newAvailable]);

                return redirect()->to('tickets/my-tickets')->with('success', 'Tiket berhasil dibeli. Silakan lakukan pembayaran.');
            } else {
                $errorMessage = 'Terjadi kesalahan saat membeli tiket.';
                
                return redirect()->back()
                    ->withInput()
                    ->with('error', $errorMessage);
            }
        } catch (\Exception $e) {
            // Debug: Log exception
            log_message('error', 'Ticket purchase exception: ' . $e->getMessage());
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Exception: ' . $e->getMessage());
        }
    }
    
    public function markAsPaid()
    {
        // Check if user has permission (allow all logged in users)
        if (!session()->get('logged_in')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Silakan login terlebih dahulu.'
            ]);
        }

        $ticketId = $this->request->getPost('ticket_id');
        
        if (!$ticketId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'ID Tiket tidak ditemukan.'
            ]);
        }

        // Get ticket data
        $ticket = $this->ticketModel->find($ticketId);
        
        if (!$ticket) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Tiket tidak ditemukan.'
            ]);
        }

        // Check if user owns this ticket or is admin/organizer
        $userId = session()->get('user_id');
        $roleName = session()->get('role_name');
        
        if ($roleName !== 'admin' && $roleName !== 'event_organizer' && $ticket['user_id'] != $userId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Anda tidak memiliki akses untuk mengubah tiket ini.'
            ]);
        }

        // Update ticket status to paid
        $updateData = [
            'status' => 'paid'
        ];

        if ($this->ticketModel->update($ticketId, $updateData)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Status tiket berhasil diubah menjadi Lunas.'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengubah status tiket.'
            ]);
        }
    }
} 