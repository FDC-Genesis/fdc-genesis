<?php

if (!function_exists('dd')) {
    function dd($data)
    {
        var_dump($data);
        die();
    }
}

function datastructurer($data, $id)
{
    $arr1 = [];
    $arr2 = [];
    foreach ($data as $d) {
        if ($d['m']['sender'] === $id) {
            array_push($arr1, $d);
        } else {
            array_push($arr2, $d);
        }
    }
    $result = [];
    foreach ($arr1 as $a) {
        $partial = $a;
        foreach ($arr2 as $b) {
            if ($a['m']['sender'] === $b['m']['receiver'] && $a['m']['receiver'] === $b['m']['sender']) {
                if ((int)($a[0]['max_id']) < (int)($b[0]['max_id'])) {
                    $partial = $b;
                }
            }
        }
        array_push($result, $partial);
    }
    usort($result, 'comparemaxid');
    return $result;
}

function comparemaxid($a, $b)
{
    return (int)($b[0]['max_id']) - (int)($a[0]['max_id']);
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
        $count = (int)$this->request->query('count');

        // for counting and pagination purposes
        $countquery = "SELECT sender, receiver, m.content, MAX(m.id) AS max_id, m.date, UserR.name as rname, UserR.img_name as rimg, UserS.name as sname, UserS.img_name as simg FROM messages as m RIGHT JOIN users as UserR on m.sender = UserR.id RIGHT JOIN users as UserS on m.receiver = UserS.id WHERE m.sender = :id or m.receiver = :id GROUP BY m.sender, m.receiver ORDER BY m.date desc;";
        $result = $this->Message->query($countquery, ['id' => $id]);

        $newdata = datastructurer($result, $id);
        $count = floor(sizeof($newdata) / 10) + ceil(sizeof($newdata) / 10 > 0 ? 1 : 0);
        echo json_encode([$count, array_slice($newdata, $offset, 10)]);
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
