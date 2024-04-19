<?php

if (!function_exists('dd')) {
    function dd($data)
    {
        var_dump($data);
        die();
    }
}

function datastructurer($data, $data2)
{
    $d1 = $data;
    $d2 = $data2;
    $result = [];

    foreach ($data as $a) {
        foreach ($data2 as $b) {
            if ($a['messages']['receiver'] === $b['messages']['sender']) {
                if ((int)($a[0]['id']) > (int)($b[0]['id'])) {
                    $key = array_search($b, $d2);
                    unset($d2[$key]);
                } else {
                    $key = array_search($a, $d1);
                    unset($d1[$key]);
                }
            }
        }
    }
    foreach ($d1 as $a) {
        $result[] = $a;
    }
    foreach ($d2 as $a) {
        $result[] = $a;
    }
    return $result;
}

function comparedate($a, $b)
{
    return strtotime($b['m']['date']) - strtotime($a['m']['date']);
}
class MessagesController extends AppController
{
    public $uses = array('Message');

    public function sendmessage()
    {
        $this->loadModel('User');
        if ($this->request->is('post')) {
            $this->Message->set($this->request->data);
            if ($this->Message->validates()) {
                if ($savedData = $this->Message->save($this->request->data)) {
                    $imgname = $this->User->findById($savedData['Message']['sender']);
                    $imageName = $imgname['User']['img_name'];
                    echo json_encode([$savedData, $imageName]);
                } else {
                    echo json_encode(["error"]);
                }
            }
        }
        exit();
    }

    public function convolist()
    {
        $id = $this->request->query('id');
        $deleted = (int)$this->request->query('deleted');
        $offset = (((int)$this->request->query('offset') - 1) * 10) - $deleted;

        $countlatest = $this->Message->query("SELECT MAX(id) AS max_id
                FROM messages
                WHERE sender = '$id' OR receiver = '$id'
                GROUP BY GREATEST(sender, receiver) ORDER BY max_id desc");

        $count = floor(sizeof($countlatest) / 10) + (sizeof($countlatest) % 10 === 0 ? 0 : 1);

        $latest =
            $this->Message->query("SELECT MAX(id) AS max_id
                FROM messages
                WHERE sender = '$id' OR receiver = '$id'
                GROUP BY GREATEST(sender, receiver) ORDER BY max_id desc limit 10 offset $offset");

        // kuhaon ang mga id
        $ids = [];
        foreach ($latest as $eachid) {
            array_push($ids, $eachid[0]['max_id']);
        }

        $implodedIds = implode(',', $ids);
        $fetched = $this->Message->query("SELECT m.sender as sender, m.receiver as receiver, m.content as content, m.date as date, s.img_name as simg, s.name as sn, r.img_name as rimg, r.name as rn
                    FROM messages AS m JOIN users as s JOIN users as r
                    WHERE
                    m.sender = s.id and m.receiver = r.id and
                    m.id IN ($implodedIds)
                    ORDER BY m.date DESC");


        echo json_encode([$count, $fetched]);
        exit();
    }

    public function deleteconvo()
    {
        if ($this->request->is('post')) {
            $id = $this->Auth->user()['User']['id'];
            $convowith = $this->request->data['convowith'];

            $success = false;

            // Delete messages where sender = $id and receiver = $convowith
            $result1 = $this->Message->query("DELETE FROM messages WHERE sender = ? AND receiver = ?", [$id, $convowith]);
            if ($result1) {
                $success = true;
            }

            // Delete messages where receiver = $id and sender = $convowith
            $result2 = $this->Message->query("DELETE FROM messages WHERE receiver = ? AND sender = ?", [$id, $convowith]);
            if ($result2) {
                $success = true;
            }

            if ($success) {
                echo "success";
            } else {
                echo "error";
            }

            exit();
        }
    }

    public function getchats($convowith = null)
    {
        $id = $this->Auth->user()['User']['id'];
        $deleted = (int)$this->request->query('deleted');
        $offset = (((int)$this->request->query('offset') - 1) * 10) - $deleted;
        $count = (int)$this->request->query('count');

        // for counting and pagination purposes
        $countquery = "SELECT count(id) as count from messages where (receiver = :id and sender = :convowith) or (receiver = :convowith and sender = :id)";
        $result = $this->Message->query($countquery, ['id' => $id, 'convowith' => $convowith]);
        $count = floor((int)$result[0][0]['count'] / 10) + (ceil((int)$result[0][0]['count'] / 10) > 0 ? 1 : 0);

        $sql = "SELECT
                m.id,
                m.sender,
                m.receiver,
                ur.name AS receiver_name,
                ur.img_name AS receiver_img,
                us.name AS sender_name,
                us.img_name AS sender_img,
                m.content,
                m.date
            FROM 
                messages as m 
            INNER JOIN 
                users AS ur ON ur.id = m.receiver 
            INNER JOIN 
                users AS us ON us.id = m.sender 
            WHERE 
                (m.receiver = '$id' AND m.sender = '$convowith')
                OR
                (m.receiver = '$convowith' AND m.sender = '$id')
            ORDER BY 
                m.date DESC limit 10 offset $offset;";

        $data = $this->Message->query($sql);

        echo json_encode([$count, $data]);
        exit();
    }

    public function deletemessage()
    {
        if ($this->request->is('post')) {
            $id = $this->request->data['id'];

            if ($this->Message->delete($id)) {
                echo "success";
            } else {
                echo "error";
            }
        }
        exit();
    }
}
