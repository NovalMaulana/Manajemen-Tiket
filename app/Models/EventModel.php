<?php

namespace App\Models;

use CodeIgniter\Model;

class EventModel extends Model
{
    protected $table = 'events';
    protected $primaryKey = 'event_id';
    protected $allowedFields = [
        'event_name', 
        'description', 
        'event_date', 
        'event_time', 
        'venue', 
        'price', 
        'total_tickets', 
        'available_tickets',
        'created_by'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = '';

    // Validation - temporarily disabled for debugging
    protected $validationRules = [];

    public function getEvent($id)
    {
        return $this->select('events.*, users.full_name as organizer_name')
                    ->join('users', 'users.user_id = events.created_by')
                    ->find($id);
    }

    public function getEventWithOrganizer($id)
    {
        return $this->select('events.*, users.full_name as organizer_name')
                    ->join('users', 'users.user_id = events.created_by')
                    ->find($id);
    }

    public function getAllEvents()
    {
        return $this->select('events.*, users.full_name as organizer_name')
                    ->join('users', 'users.user_id = events.created_by')
                    ->orderBy('events.event_date', 'ASC')
                    ->findAll();
    }

    public function getEventsWithStats()
    {
        $builder = $this->db->table('events e');
        $builder->select('e.*, u.full_name as organizer_name, COUNT(t.ticket_id) as sold_tickets');
        $builder->join('users u', 'u.user_id = e.created_by', 'left');
        $builder->join('tickets t', 't.event_id = e.event_id', 'left');
        $builder->groupBy('e.event_id');
        $builder->orderBy('e.created_at', 'DESC');
        
        return $builder->get()->getResultArray();
    }

    public function getEventsWithStatsByOrganizer($userId)
    {
        $builder = $this->db->table('events e');
        $builder->select('e.*, u.full_name as organizer_name, COUNT(t.ticket_id) as sold_tickets');
        $builder->join('users u', 'u.user_id = e.created_by', 'left');
        $builder->join('tickets t', 't.event_id = e.event_id', 'left');
        $builder->where('e.created_by', $userId);
        $builder->groupBy('e.event_id');
        $builder->orderBy('e.created_at', 'DESC');
        
        return $builder->get()->getResultArray();
    }

    public function getEventsByOrganizer($userId)
    {
        return $this->select('events.*, users.full_name as organizer_name')
                    ->join('users', 'users.user_id = events.created_by')
                    ->where('events.created_by', $userId)
                    ->orderBy('events.event_date', 'ASC')
                    ->findAll();
    }

    public function getActiveEvents()
    {
        return $this->select('events.*, users.full_name as organizer_name')
                    ->join('users', 'users.user_id = events.created_by')
                    ->where('events.event_date >=', date('Y-m-d'))
                    ->orderBy('events.event_date', 'ASC')
                    ->findAll();
    }

    public function getUpcomingEvents($limit = 5)
    {
        return $this->select('events.*, users.full_name as organizer_name')
                    ->join('users', 'users.user_id = events.created_by')
                    ->where('events.event_date >=', date('Y-m-d'))
                    ->orderBy('events.event_date', 'ASC')
                    ->limit($limit)
                    ->findAll();
    }
} 