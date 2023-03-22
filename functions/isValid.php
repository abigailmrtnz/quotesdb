<?php
function isValid($id, $model) {
    $model->id = $id;
    return ($model->read_single() > 0) ? true : false;
}
?>