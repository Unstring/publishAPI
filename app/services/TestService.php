<?php
class TestService extends Requests
{
  public function test($id)
  {
    echo json_encode($id);
  }
}