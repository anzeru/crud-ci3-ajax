<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Comment extends CI_Controller
{

    public function index()
    {
    }

    public function addComment()
    {
        $this->load->view('comment');

        $error = '';
        $comment_name = '';
        $comment_content = '';

        if (empty($_POST["comment_name"])) {
            $error .= '<p class="text-danger">Name is required</p>';
        } else {
            $comment_name = $_POST["comment_name"];
        }

        if (empty($_POST["comment_content"])) {
            $error .= '<p class="text-danger">Comment is required</p>';
        } else {
            $comment_content = $_POST["comment_content"];
        }

        if ($error == '') {
            $datas = [
                'parent_comment_id' => $_POST["comment_id"],
                'comment'   => $comment_content,
                'comment_sender_name'   => $comment_name
            ];

            $this->db->insert('tbl_comment', $datas);

            $error = '<label class="text-success">Comment Added</label>';
        }

        $data = array(
            'error'  => $error
        );

        echo json_encode($data);
    }
}
