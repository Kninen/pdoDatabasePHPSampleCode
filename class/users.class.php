<?php

class Users
{
    protected $db;

    public function __construct(Database $db)
    {
        $this->database = $db;
    }

    public function findSingleUser($userid)
    {
        $userid = abs((int)$userid);

        $this->database->query('SELECT * FROM users WHERE id = :userid');
        $this->database->bind(':userid', $userid);
        $row = $this->database->single();

        if ($row) {
            return $row['firstname'].' '.$row['lastname'];
        }
    }

    public function listAllUsers()
    {
        $returnValue = array();

        $this->database->query('SELECT * FROM users ORDER BY id ASC');

        $rows = $this->database->resultset();

        foreach ($rows as $row):

        $returnValue[] = array(
        'id'   => $row['id'],
        'firstname' => $row['firstname'],
        'lastname' => $row['lastname'],
        'timestamp' => $row['timestamp']
        );
        
        endforeach;

        return $returnValue;
    }
}
