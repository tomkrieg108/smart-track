<?php
class CGoal {
    public function __construct($goal) {
      $this->goal_id = $goal->goal_id;
      $this->title = $goal->title;
      $this->body = $goal->body;
      $this->created_on = $goal->created_on;
      $this->due_on = $goal->due_on;
      $this->completed_on = $goal->completed_on;
      $this->user_id = $goal->user_id;
      $this->progress = $goal->progress;
      $this->comments = $goal->comments;
    }

    public function shortBody($num_chars = 140) {
      $short_body = mb_substr($this->body, 0, $num_chars);
      if(strlen($this->body) > $num_chars) {
        $short_body = $short_body . " ...";
      }
      return $short_body;
    }

    private function getDateInterval($date) {
      $today = new DateTime();
      $due_on = new DateTime($date);
      return $today->diff($due_on);
    }

    public function daysUntilDue() {
      $diff = $this->getDateInterval($this->due_on);  
      if($diff->invert == 1) {
        return  "(" . $diff->format("%a days overdue") . ")";
      } else {
        return  "(" . $diff->format("%a days remaining") . ")";
      }
    }

    public function daysSinceCreated() {
      $diff = $this->getDateInterval($this->created_on);
      return  "(" . $diff->format("%a days ago") . ")";  
    }

    public function daysSinceCompleted() {
      if(isset($this->completed_on)) {
        $diff = $this->getDateInterval($this->completed_on);
        return  "(" . $diff->format("%a days ago") . ")"; 
      }
      else return '';
    }

    public function getDueClass() {
      $diff = $this->getDateInterval($this->due_on);  
      if($diff->invert == 1) {
        return 'text-danger';
      }elseif($diff->days < 7) {
        return 'text-warning';
      } else {
        return 'text-success';
      }
    }

    public function getProgressClass() {
      return ($this->progress > 0) ? 'bg-primary' : 'bg-secondary';
    }

    public function getProgressStyle() {
      $width = ($this->progress < 10) ? 10 : $this->progress;
      $style = 'width: ' . $width . '%;';
      return $style;
    }

    public function getProgressVal() {
      return ($this->progress > 0) ? $this->progress . '% complete'  : 'Not started';
    }

  }
  ?>