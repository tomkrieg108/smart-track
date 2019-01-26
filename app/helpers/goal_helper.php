<?php
class CGoal {
    public function __construct($goal) {
      $this->goal_id = $goal->goal_id;
      $this->title = $goal->title;
      $this->body = $goal->body;
      $this->due_on = $goal->due_on;
      $this->user_id = $goal->user_id;
      $this->progress = $goal->progress;
      $this->commments = $goal->comments;
    }

    public function shortBody($num_chars = 140) {
      $short_body = mb_substr($this->body, 0, $num_chars);
      if(strlen($this->body) > $num_chars) {
        $short_body = $short_body . " ...";
      }
      return $short_body;
    }

    private function getDateInterval() {
      // $due_on = date_create($this->due_on);
      // $diff=date_diff($due_on,$now);
      // echo $diff->format("%R%a days");
      $today = new DateTime();
      $due_on = new DateTime($this->due_on);
      return $today->diff($due_on);
    }

    public function daysUntilDue() {
      $diff = $this->getDateInterval();  
      return  "(" . $diff->format("%R%a days") . ")";
      // return $diff->format("%a days");
    }

    public function isOverDue() {
      $diff = $this->getDateInterval();  
      return $diff->days < 0;
    }

    public function getDueClass() {
      $diff = $this->getDateInterval();  
      if($diff->invert == 1) {
        return 'text-danger';
      }elseif($diff->days < 7) {
        return 'text-warning';
      } else {
        return 'text-success';
      }
    }

    public function getProgressClass() {
      if($this->progress < 10) {
        return 'bg-secondary';
      } else {
        return 'bg-primary';
      }
    }

    public function getProgressStyle() {
      if($this->progress < 10) {
        return 10;
      } else {
        return $this->progress;
      }
    }

  }
  ?>