<?php

class Comment {

  private $db;

  public function __construct() {
    $this->db = new Database;
  }

  public function getComments($goal_id) {
    $this->db->query('SELECT *
    FROM comments
    WHERE (comments.goal_id = :goal_id)
    ORDER BY comments.created_on DESC
    ');
    $this->db->bind(':goal_id', $goal_id);
    return $this->db->resultSet();
  }
  public function addComment($comment) {
    $this->db->query('INSERT INTO comments (body, goal_id)
                      VALUES(:body, :goal_id)' 
                      );
    $this->db->bind(':body', $comment->body);
    $this->db->bind(':goal_id', $comment->goal_id);
    return ($this->db->execute());
  }

  public function editComment($comment) {
    $this->db->query('UPDATE comments SET body = :body WHERE comment_id = :comment_id' );
    $this->db->bind(':comment_id', $comment->comment_id);
    $this->db->bind(':body',  $comment->body);
    return ($this->db->execute());
  }

  public function deleteComment($comment_id) {
    $this->db->query('DELETE FROM comments WHERE comment_id = :comment_id' );
    $this->db->bind(':comment_id', $comment_id);
    return ($this->db->execute());
  }

  public function getCommentById($comment_id) {
    $this->db->query('SELECT * FROM comments WHERE comments.comment_id = :comment_id');
    $this->db->bind(':comment_id', $comment_id);
    $row = $this->db->single();
    return $row;
  }

}