<?php
// Checks if a valid authorid or category id exists
    function isValid($id, $model){
    $model->id = $id;
    if($model->read_single()){
        return true;
    }
    return false;
    }
?>