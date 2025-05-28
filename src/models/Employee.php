<?php

class Employee extends DatabaseModel
{
    public function fetchAllNames()
    {
        return $this->fetchAll('SELECT name FROM employees');
    }

    public function insert()
    {
        $this->execute('INSERT INTO employees (name) VALUES (?)', ['s', $_POST['name']]);
    }
}
