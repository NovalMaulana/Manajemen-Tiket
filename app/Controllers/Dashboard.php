<?php

namespace App\Controllers;

use App\Models\EventModel;
use App\Models\TicketModel;
use App\Models\UserModel;

class Dashboard extends BaseController
{
    protected $eventModel;
    protected $ticketModel;
    protected $userModel;

    public function __construct()
    {
        $this->eventModel = new EventModel();
        $this->ticketModel = new TicketModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Dashboard'
        ];

        $role = session()->get('role_name');
        $userId = session()->get('user_id');

        switch ($role) {
            case 'admin':
                $data['total_users'] = count($this->userModel->findAll());
                $data['total_events'] = count($this->eventModel->findAll());
                $data['total_tickets'] = count($this->ticketModel->findAll());
                return view('dashboard/admin', $data);

            case 'event_organizer':
                $data['my_events'] = $this->eventModel->getEventsByOrganizer($userId);
                $eventIds = array_column($data['my_events'], 'event_id');
                $data['total_tickets_sold'] = 0;
                
                if (!empty($eventIds)) {
                    $tickets = $this->ticketModel->whereIn('event_id', $eventIds)->findAll();
                    foreach ($tickets as $ticket) {
                        $data['total_tickets_sold'] += $ticket['quantity'];
                    }
                }
                
                return view('dashboard/organizer', $data);

            case 'customer':
                $data['upcoming_events'] = $this->eventModel->where('event_date >=', date('Y-m-d'))->findAll();
                $data['my_tickets'] = $this->ticketModel->getUserTickets($userId);
                return view('dashboard/customer', $data);

            default:
                return redirect()->to(base_url('auth/login'))->with('error', 'Role tidak valid');
        }
    }
} 