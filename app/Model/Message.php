<?php

class Message extends AppModel
{
    public $validate = [];
    public function beforeSave($options = array())
    {
        if (empty($this->data['Message']['date'])) {
            $this->data['Message']['date'] = date('Y-m-d H:i:s');
        }
        return true;
    }
}
