<?php

class Goal {

  private $db;

  public function __construct() {
    $this->db = new Database;
  }

  public function getGoals($user_id) {
    //using aliases
    $this->db->query('SELECT *,
    goals.goal_id as goalId,
    users.id as userId,
    goals.created_on as goalCreated,
    users.created_at as userCreated
    FROM goals
    INNER JOIN users
    ON goals.user_id = users.id
    WHERE (goals.user_id = :user_id) AND (goals.completed_on IS NULL)
    ORDER BY goals.due_on ASC
    ');

    $this->db->bind(':user_id', $user_id);
    return $this->db->resultSet();
  }

  public function getCompletedGoals($user_id) {
    //using aliases
    $this->db->query('SELECT *,
    goals.goal_id as goalId,
    users.id as userId,
    goals.created_on as goalCreated,
    users.created_at as userCreated
    FROM goals
    INNER JOIN users
    ON goals.user_id = users.id
    WHERE (goals.user_id = :user_id) AND (goals.completed_on IS NOT NULL)
    ORDER BY goals.due_on DESC
    ');

    $this->db->bind(':user_id', $user_id);
    return $this->db->resultSet();
  }

  public function addGoal($goal) {
    $this->db->query('INSERT INTO goals (title, user_id, body, progress, due_on)
                      VALUES(:title, :user_id, :body, :progress, :due)' 
                      );
    $this->db->bind(':title', $goal->title);
    $this->db->bind(':body', $goal->body);
    $this->db->bind(':due', $goal->due_on);
    $this->db->bind(':user_id', $goal->user_id);
    $this->db->bind(':progress', 0);
    return ($this->db->execute());
  }

  public function editGoal($goal) {
    $this->db->query('UPDATE goals SET title = :title, body = :body, due_on = :due WHERE goal_id = :goal_id' );
    $this->db->bind(':goal_id', $goal->goal_id);
    $this->db->bind(':title',  $goal->title);
    $this->db->bind(':body',  $goal->body);
    $this->db->bind(':due',  $goal->due_on);
    return ($this->db->execute());
  }

  public function updateProgress($goal) {
    $this->db->query('UPDATE goals SET progress = :progress, comments = :comments WHERE goal_id = :goal_id' );
    $this->db->bind(':goal_id', $goal->goal_id);
    $this->db->bind(':progress', $goal->progress);
    $this->db->bind(':comments', $goal->comments);
    return ($this->db->execute());
  }

  public function findGoalByTitle($goal) {
    $this->db->query('SELECT * FROM goals WHERE title = :title');
    $this->db->bind(':title', $goal->title);
    $row = $this->db->single();
    return ($this->db->rowCount() > 0);
  }

  public function deleteGoal($goal_id) {
    $this->db->query('DELETE FROM goals WHERE goal_id = :goal_id' );
    $this->db->bind(':goal_id', $goal_id);
    return ($this->db->execute());
  }

  public function completeGoal($goal_id, $date) {
    $this->db->query('UPDATE goals SET completed_on = :completed_on WHERE goal_id = :goal_id' );
    $this->db->bind(':goal_id', $goal_id);
    $this->db->bind(':completed_on', $date);
    return ($this->db->execute());
  }

  public function reopenGoal($goal_id) {
    $this->db->query('UPDATE goals SET completed_on = :completed_on WHERE goal_id = :goal_id' );
    $this->db->bind(':goal_id', $goal_id);
    $this->db->bind(':completed_on', null);
    return ($this->db->execute());
  }

  public function getGoalById($goal_id) {
    $this->db->query('SELECT * FROM goals WHERE goals.goal_id = :goal_id');
    $this->db->bind(':goal_id', $goal_id);
    $row = $this->db->single();
    return $row;
  }

}


