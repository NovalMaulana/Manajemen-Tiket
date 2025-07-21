<?php

namespace App\Models;

use CodeIgniter\Model;

class TicketModel extends Model
{
    protected $table = 'tickets';
    protected $primaryKey = 'ticket_id';
    protected $allowedFields = [
        'event_id', 
        'user_id', 
        'quantity', 
        'total_price', 
        'status'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'purchase_date';
    protected $updatedField = '';

    // Validation - temporarily disabled for debugging
    protected $validationRules = [];

    public function getTicket($id)
    {
        return $this->select('tickets.*, events.event_name, users.full_name as buyer_name')
                    ->join('events', 'events.event_id = tickets.event_id')
                    ->join('users', 'users.user_id = tickets.user_id')
                    ->find($id);
    }

    public function getUserTickets($userId)
    {
        return $this->select('tickets.*, events.event_name, events.event_date, events.event_time, events.venue')
                    ->join('events', 'events.event_id = tickets.event_id')
                    ->where('tickets.user_id', $userId)
                    ->orderBy('tickets.purchase_date', 'DESC')
                    ->findAll();
    }

    public function getTicketsByEvent($eventId)
    {
        return $this->select('tickets.*, users.full_name as buyer_name')
                    ->join('users', 'users.user_id = tickets.user_id')
                    ->where('tickets.event_id', $eventId)
                    ->orderBy('tickets.purchase_date', 'DESC')
                    ->findAll();
    }

    public function getEventTickets($eventId)
    {
        return $this->select('tickets.*, users.full_name as buyer_name')
                    ->join('users', 'users.user_id = tickets.user_id')
                    ->where('tickets.event_id', $eventId)
                    ->findAll();
    }

    public function generateTicketCode()
    {
        $prefix = 'TIX';
        $timestamp = time();
        $random = strtoupper(substr(md5(uniqid()), 0, 6));
        return $prefix . $timestamp . $random;
    }

    public function getTicketByCode($code)
    {
        return $this->select('tickets.*, events.event_name, events.event_date, events.event_time, events.venue, users.full_name as buyer_name')
                    ->join('events', 'events.event_id = tickets.event_id')
                    ->join('users', 'users.user_id = tickets.user_id')
                    ->where('tickets.ticket_code', $code)
                    ->first();
    }

    public function getTicketStats($eventId = null)
    {
        $builder = $this->db->table('tickets t');
        $builder->select('COUNT(*) as total_tickets, SUM(t.total_price) as total_revenue');
        
        if ($eventId) {
            $builder->where('t.event_id', $eventId);
        }
        
        return $builder->get()->getRowArray();
    }

    public function getAllSoldTickets()
    {
        return $this->select('tickets.*, events.event_name, events.event_date, events.event_time, events.venue, users.full_name as buyer_name')
                    ->join('events', 'events.event_id = tickets.event_id')
                    ->join('users', 'users.user_id = tickets.user_id')
                    ->orderBy('tickets.purchase_date', 'DESC')
                    ->findAll();
    }

    public function getSoldTicketsByOrganizer($organizerId)
    {
        return $this->select('tickets.*, events.event_name, events.event_date, events.event_time, events.venue, users.full_name as buyer_name')
                    ->join('events', 'events.event_id = tickets.event_id')
                    ->join('users', 'users.user_id = tickets.user_id')
                    ->where('events.created_by', $organizerId)
                    ->orderBy('tickets.purchase_date', 'DESC')
                    ->findAll();
    }
} 