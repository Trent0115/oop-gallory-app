<?php
class User extends Db_object
{

    protected static $db_table       = "users";
    protected static $db_table_field = ['username', 'password', 'first_name', 'last_name', 'user_image'];

    public $id;
    public $username;
    public $password;
    public $first_name;
    public $last_name;
    public $user_image;
    public $upload_directory  = "images";
    public $image_placeholder = "https://via.placeholder.com/400x400&text=image";

    public function set_file($file)
    {
        if (empty($file) || !$file || !is_array($file)) {
            $this->errors[] = "There was no file uploaded here";
            return false;
        } elseif ($file['error'] != 0) {
            $this->errors[] = $this->upload_errors_array[$file['error']];
            return false;
        } else {

            $this->user_image = basename($file['name']);
            $this->tmp_path   = $file['tmp_name'];
            $this->type       = $file['type'];
            $this->size       = $file['size'];
        }
    }

    public function upload_photo()
    {

        if (!empty($this->errors)) {
            return false;
        }
        if (empty($this->user_image) || empty($this->tmp_path)) {
            $this->errors[] = "the file was not avalible";
            return false;
        }
        $target_path = SITE_ROOT . DS . 'admin' . DS . $this->upload_directory . DS . $this->user_image;

        if (file_exists($target_path)) {
            $this->errors[] = "The file {$this->user_image} already exists";
            return false;
        }
        if (move_uploaded_file($this->tmp_path, $target_path)) {
            unset($this->tmp_path);
            return true;

            $this->errors[] = "Failed to create the photo record";
        } else {
            $this->errors[] = "the file directory no permission";
            return false;
        }
    }

    public function image_path_and_placeholder()
    {
        return empty($this->user_image) ? $this->image_placeholder : $this->upload_directory . DS . $this->user_image;
    }

    public static function verify_user($username, $password)
    {
        global $database;
        $username = $database->escape_string($username);
        $password = $database->escape_string($password);

        $sql = "SELECT * FROM users WHERE ";
        $sql .= "username = '{$username}' ";
        $sql .= "AND password = '{$password}' ";
        $sql .= "LIMIT 1";

        $the_result_array = self::find_by_query("$sql");

        return !empty($the_result_array) ? array_shift($the_result_array) : false;
    }
} //end of class user
