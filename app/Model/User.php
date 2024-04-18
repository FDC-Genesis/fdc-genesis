<?php

class User extends AppModel
{
    public $validate = array(
        'email' => array(
            'unique' => array(
                'rule' => 'isUnique',
                'required' => true,
                'message' => 'Email has already been taken',
                'on' => 'create'
            )
        ),
        'name' => array(
            'required' => array(
                'rule' => 'notBlank',
                'required' => true,
                'message' => 'Name is required'
            ),
            'length' => array(
                'rule' => array('between', 5, 20),
                'message' => 'Name must be between 5 and 20 characters long'
            )
        ),
        'password' => array(
            'required' => array(
                'rule' => 'notBlank',
                'required' => true,
                'message' => 'Password is required',
                'on' => 'create'
            ),
            'match' => [
                'rule' => 'compare',
                'message' => 'Password do not match'
            ]
        ),
        'confirm-password' => array(
            'required' => array(
                'rule' => 'notBlank',
                'required' => true,
                'message' => 'Password confirmation is required',
                'on' => 'create'
            )
        ),
        'gender' => [
            'required' => [
                'rule' => ['inList', ['m', 'f']],
                'required' => true,
                'message' => 'Please enter a valid gender'
            ]
        ],
        'birthdate' => [
            'required' => [
                'rule' => 'notBlank',
                'required' => true,
                'message' => 'Please enter a birth date',
            ],
            'customChecker' => [
                'rule' => 'birthDateCheker',
                'message' => 'Please enter a valid birth date',
            ]
        ],
        'hobby' => [
            'required' => [
                'rule' => 'notBlank',
                'required' => true,
                'message' => 'Hobby is required'
            ]
        ],
    );

    public function compare($data)
    {
        if ($data['password'] === $this->data['User']['confirm-password']) {
            return true;
        } else {
            return false;
        }
    }

    public function birthDateCheker($data)
    {
        $birthdate = $data['birthdate'];
        if (preg_match('#^\d{2}/\d{2}/\d{4}$#', $birthdate)) {
            $date = explode("/", $birthdate);
            $this->data['User']['birthdate'] = $date[2] . '-' . $date[0] . '-' . $date[1];
            return true;
        }
        return false;
    }

    public function beforeSave($options = array())
    {
        if (isset($this->data['User']['password'])) {
            $this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
        }
        return true;
    }
}
