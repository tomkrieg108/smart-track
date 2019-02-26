<?php

class Task {

  private $db;

  public function __construct() {
    $this->db = new Database;
  }

  public function getTasksByUserID($user_id) {
    $this->db->query('  SELECT *
                        FROM tasks
                        WHERE (tasks.goal_id IN (
                            SELECT goals.goal_id 
                            FROM goals 
                            WHERE (goals.user_id = :user_id)  
                          )
                        AND (tasks.completed_on IS NULL)   
                        )
    ');
    $this->db->bind(':user_id', $user_id);
    return $this->db->resultSet();
  }

  public function getCompletedTasksByUserID($user_id) {
    $this->db->query('  SELECT *
                        FROM tasks
                        WHERE (tasks.goal_id IN (
                            SELECT goals.goal_id 
                            FROM goals 
                            WHERE (goals.user_id = :user_id)  
                          )
                        AND (tasks.completed_on IS NOT NULL)  
                        )
    ');
    $this->db->bind(':user_id', $user_id);
    return $this->db->resultSet();
  }

  public function getTasks($goal_id) {
    $this->db->query('SELECT *
    FROM tasks
    WHERE (tasks.goal_id = :goal_id)
    ');
    $this->db->bind(':goal_id', $goal_id);
    return $this->db->resultSet();
  }

  public function getOpenTasks($goal_id) {
    $this->db->query('SELECT *,
    FROM tasks
    WHERE (tasks.goal_id = :goal_id) AND (tasks.completed_on IS NULL)
    ORDER BY tasks.created_on ASC
    ');
    $this->db->bind(':goal_id', $goal_id);
    return $this->db->resultSet();
  }

  public function getCompletedTasks($goal_id) {
    $this->db->query('SELECT *,
    FROM tasks
    WHERE (tasks.goal_id = :goal_id) AND (tasks.completed_on IS NOT NULL)
    ORDER BY tasks.created_on ASC
    ');
    $this->db->bind(':goal_id', $goal_id);
    return $this->db->resultSet();
  }

  public function addTask($task) {
    $this->db->query('INSERT INTO tasks (body, goal_id)
                      VALUES(:body, :goal_id)' 
                      );
    $this->db->bind(':body', $task->body);
    $this->db->bind(':goal_id', $task->goal_id);
    return ($this->db->execute());
  }

  public function editTask($task) {
    $this->db->query('UPDATE tasks SET body = :body WHERE task_id = :task_id' );
    $this->db->bind(':task_id', $task->task_id);
    $this->db->bind(':body',  $task->body);
    return ($this->db->execute());
  }

  public function deleteTask($task_id) {
    $this->db->query('DELETE FROM tasks WHERE task_id = :task_id' );
    $this->db->bind(':task_id', $task_id);
    return ($this->db->execute());
  }

  public function completeTask($task_id, $date) {
    $this->db->query('UPDATE tasks SET completed_on = :completed_on WHERE task_id = :task_id' );
    $this->db->bind(':task_id', $task_id);
    $this->db->bind(':completed_on', $date);
    return ($this->db->execute());
  }

  public function reopenTask($task_id) {
    $this->db->query('UPDATE tasks SET completed_on = :completed_on WHERE task_id = :task_id' );
    $this->db->bind(':task_id', $task_id);
    $this->db->bind(':completed_on', null);
    return ($this->db->execute());
  }

  public function getTaskById($task_id) {
    $this->db->query('SELECT * FROM tasks WHERE tasks.task_id = :task_id');
    $this->db->bind(':task_id', $task_id);
    $row = $this->db->single();
    return $row;
  }

}